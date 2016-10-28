<?php

namespace App\Http\Controllers;

use App\User;
use App\Ticket;
use App\Category;
use App\State;
use App\Http\Requests;
use App\Mailers\AppMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Excel;
use Datatables;
use Session;

class TicketsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

    /**
     * Display all tickets.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    	$tickets = Ticket::paginate(10);
        $categories = Category::all();

        return view('tickets.index', compact('tickets', 'categories'));
    }


		/**
     * Display all tickets.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllTickets()
    {

    	$tickets = Ticket::paginate(10);
		
        $categories = Category::all();

        return view('tickets.limited', compact('tickets', 'categories'));
    }

    /**
     * Display all tickets by a user.
     *
     * @return \Illuminate\Http\Response
     */
    public function userTickets()
    {
        $tickets = Ticket::where('user_id', Auth::user()->id)->paginate(10);
        $categories = Category::all();

        return view('tickets.user_tickets', compact('tickets', 'categories'));
    }




    /**
     * Show the form for opening a new ticket.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$categories = Category::all();
        $states = State::all();

        return view('tickets.create', compact('categories', 'states'));
    }

	public function exportExcelReport()
	{
		//add datetime stamp
		Excel::create('HOC_Report', function($excel) {

		    $excel->sheet('Sheetname', function($sheet) {
					  $tickets = Ticket::where('user_id', Auth::user()->id)->get();
		        $sheet->fromArray($tickets);

		    });

		})->export('xls');
	}

    public function exportExcelTickRep($id)
    {
        
        Excel::create('HOC_Report', function($excel){
            $ticket = Ticket::find($id);
            $comments = $ticket->comments();
            $excel->setTitle($ticket->title.' - #'.$ticket->_id);
            
            $excel->sheet($ticket->ticket_id, function($sheet){
                $ticket = Ticket::find($id);
                $comments = $ticket->comments();

                $sheet->fromArray($comments);
            });

        })->export('xls');
    }

    /**
     * Store a newly created ticket in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, AppMailer $mailer)
    {
            //get the list of phonenumbers
            //dd($request->input('state'));
            //$user = User::where('region', 25)->first();
            //dd($user->phone_number);

            //this is to get the numbers
            $state_ids = $request->input('state');

            //this is to keep only unique ids
            $state_ids = array_unique($state_ids);

            //dd(json_decode($state_ids, true));
            // output format: 
            /*array:2 [▼
                  0 => "15"
                  1 => "25"
                ]*/
            $phone_nos = array();

            foreach ($state_ids as $state_id) {
                $users = User::where('region', $state_id)->get();
                foreach ($users as $user) {
                    #dump($user->phone_number);
                    array_push($phone_nos, $user->phone_number);
                }
            }

            //dump($phone_nos);


			$ticket = null;
			$alertMessage = "A ticket with ID: #6JSFY4KYP3 has been opened.";

            $message = array();

			if($request['category'] == '1')
            {
    			$this->validate($request, [
                    'title'     => 'required',
                    'category'  => 'required',
                    'priority'  => 'required',
        			'node_a'		=> 'required',
        			'node_b'		=> 'required',
                    'vendor' => 'required',
                    'time_of_occurence' => 'required',
                    'cause_of_failure' => 'required',
                ]);
			}
            elseif($request['category'] == '2')
            {
    			$this->validate($request, [
                'title'     => 'required',
                'category'  => 'required',
                'priority'  => 'required',
                'site_id'  => 'required',
                'bsc'  => 'required',
                'time_of_occurence' => 'required',
                'cause_of_failure' => 'required',
                ]);
			}
            elseif($request['category'] == '3')
            {
    			$this->validate($request, [
                    'title'     => 'required',
                    'category'  => 'required',
                    'priority'  => 'required',
                    'location'  => 'required',
                    'time_of_occurence' => 'required',
                    'cause_of_failure' => 'required',
                ]);
			}
            else
            {
    			$this->validate($request, [
                'title'     => 'required',
                'category'  => 'required',
                'priority'  => 'required',
                'time_of_occurence' => 'required',
                'cause_of_failure' => 'required',
                ]);
		    }
        //$mailer->sendTicketInformation(Auth::user(), $ticket);
        //$phone_nos = json_encode($phone_nos);
        $state_ids = json_encode($state_ids);
        $ticket = new Ticket([
        'title'     => $request->input('title'),
        'user_id'   => Auth::user()->id,
        'ticket_id' => strtoupper(str_random(10)),
        'category_id'  => $request->input('category'),
        'priority'  => $request->input('priority'),
        'region'   => $state_ids,
        'nodeA'   => $request->input('node_a'),
        'nodeB'   => $request->input('node_b'),
        'vendor'   => $request->input('vendor'),
        'site_id'   => $request->input('site_id'),
        'bsc'   => $request->input('bsc'),
        'location'   => $request->input('location'),
        'time_occurence'   => $request->input('time_of_occurence'),
        'cause_of_failure'   => $request->input('cause_of_failure'),
        'impact'   => $request->input('message'),
        'status'    => "Open",
        ]);

        
        $message = [
            $ticket->ticket_id,
            $ticket->title,
            $ticket->category->name,
            $ticket->priority,
            $ticket->status,
        ];

        if($request['category'] == '1')
        {
            array_push($message, $ticket->nodeA);
            array_push($message, $ticket->nodeB);
            array_push($message, $ticket->vendor);
        }

        elseif($request['category'] == '2')
        {
            array_push($message, $request['site_id']);
            array_push($message, $request['bsc']);
        }

        elseif($request['category'] == '3')
        {
            array_push($message, $request['location']);
        }

        array_push($message, $request['time_of_occurence']);
        array_push($message, $request['cause_of_failure']);
        array_push($message, $request['message']);

        //dump($message);
        //die();
        $ticket->save();
        $alertMessage = "A transmission ticket with ID: #$ticket->ticket_id has been opened.";
        $alertMessage = str_replace(" ","+",$alertMessage);
        //$ret = $this->sendSMS($phone_nos,$message);

        /*if($ret)
        {
            dump("success");
        }else{
            dump("false");
        }
        die();*/

        //the message is to contain everything in the 
        //then we should send to everybody selected wen the trouble ticket is made
        //it should send the trouble ticket ID.



        return redirect()->route('all.tickets')->with("suc_msg", "A ticket with ID: #$ticket->ticket_id has been opened.");
    }

    /**
     * Display a specified ticket.
     *
     * @param  int  $ticket_id
     * @return \Illuminate\Http\Response
     */
    public function show($ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        $comments = $ticket->comments;

        $category = $ticket->category;

        return view('tickets.show', compact('ticket', 'category', 'comments'));
    }

    /**
     * Close the specified ticket.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function close($ticket_id, AppMailer $mailer)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        $ticket->status = 'Closed';

        $ticket->save();

        $ticketOwner = $ticket->user;

        $mailer->sendTicketStatusNotification($ticketOwner, $ticket);

        return redirect()->back()->with("status", "The ticket has been closed.");
    }

	public function sendSMS($to = null,$message = null){
        
        /*$to = trim(implode(",", $to));
		#$message = str_replace("#","",$message);
        $message = trim(implode(",", $message));
        */

        $to = '09097694139';
        $message = 'Am testing';
		$url = "http://www.smslive247.com/http/index.aspx?cmd=sendquickmsg&owneremail=bayorasunmo@gmail.com&subacct=FMS&subacctpwd=bayorfms&message=".$message."&sender=GLONOC&sendto=".trim($to)."&msgtype=0";
		/* call the URL */

        //dd($url);
        dd(fopen($url, "r"));

		if ($f = @fopen($url, "r"))  
        {
    	$answer = fgets($f, 255);
        	 if (substr($answer, 0, 1) == "+") 
             {
        		   echo $answer;
    		 }  
             else  
             {
    			   echo $answer;
    		 }
        }  else  
        {
            return "error";
        }
	}

    public function mySendSMS()
    {
        $dns=array("8.8.8.8","8.8.4.4");
        var_export (dns_get_record ( "http://www.smslive247.com/http/index.aspx?cmd=sendquickmsg&owneremail=bayorasunmo@gmail.com&subacct=FMS&subacctpwd=bayorfms&message=Am testing&sender=GLONOC&sendto=09097694139&msgtype=0" ,  DNS_ALL , $dns ));
        die();
        $to = '09097694139';
        $message = 'Am testing';

        $url = "http://www.smslive247.com/http/index.aspx?cmd=sendquickmsg&owneremail=bayorasunmo@gmail.com&subacct=FMS&subacctpwd=bayorfms&message=".$message."&sender=GLONOC&sendto=".$to."&msgtype=0";

        $url = "http://www.smslive247.com/http/index.aspx?cmd=sendquickmsg&owneremail=bayorasunmo@gmail.com&subacct=FMS&subacctpwd=bayorfms&message=Am testing&sender=GLONOC&sendto=09097694139&msgtype=0";

        dd(( $url));

        $curl = curl_init($url);

        $result = curl_exec($curl);

        dd($result);
    }

    public function anyData()
    {
        //$tickets = Ticket::select('', '', '')::where('user_id', Auth::user()->id)->get();
        $counter = 0;
        $tickets =  Ticket::select(['id', 'ticket_id', 'category_id', 'title', 'priority', 'status'])->where('user_id', Auth::user()->id)->get();
        return Datatables::of($tickets)
        ->editColumn('category_id', function($category_id){
           return  $category_id->category->name;
        })
        ->editColumn('priority', function($row){
            $priority = strtolower($row->priority);
            if ($priority === "low") {
                return '<span class="label label-success">'. ucfirst($row->priority) .'</span>';
            }else if($priority === "medium")
            {
                return '<span class="label label-warning">'. ucfirst($row->priority) .'</span>';
            }else
            {
                return '<span class="label label-danger">'. ucfirst($row->priority) .'</span>';
            }

        })
        ->editColumn('status', function($status){
            //dump($status);
            if ($status->status === "Open") {
                return '<span class="label label-success">'.$status->status.'</span>';
            }
            return '<span class="label label-danger">'.$status->status.'</span>';
        })
        ->addColumn('action', function($row){
            return '<a href="'.route('ticket.show', $row->ticket_id).'" class="btn btn-info btn-xs">More</a> 
            ';
        })
        ->removeColumn('id')
        ->removeColumn('ticket_id')
        ->make(true);
    }

    public function allData()
    {
        $counter = 0;
        $tickets =  Ticket::select(['id', 'ticket_id', 'category_id', 'title', 'priority', 'status']);
        return Datatables::of($tickets)
        ->editColumn('category_id', function($category_id){
           return  $category_id->category->name;
        })
        ->editColumn('priority', function($row){
            $priority = strtolower($row->priority);
            if ($priority === "low") {
                return '<span class="label label-success">'. ucfirst($row->priority) .'</span>';
            }else if($priority === "medium")
            {
                return '<span class="label label-warning">'. ucfirst($row->priority) .'</span>';
            }else
            {
                return '<span class="label label-danger">'. ucfirst($row->priority) .'</span>';
            }

        })
        ->editColumn('status', function($status){
            //dump($status);
            if ($status->status === "Open") {
                return '<span class="label label-success">'.$status->status.'</span>';
            }
            return '<span class="label label-danger">'.$status->status.'</span>';
        })
        ->addColumn('action', function($row){
            return '<a href="'.route('ticket.show', $row->ticket_id).'" class="btn btn-info btn-xs">More</a> 
            ';
        })
        ->removeColumn('id')
        ->removeColumn('ticket_id')
        ->make(true);
    }

    //this is to get the tickets that are 
    //open so u can escalate
    public function escalateListData()
    {
        $tickets =  Ticket::select(['id', 'ticket_id', 'title',  'status', 'priority'])->where('status', 'Open');
        return Datatables::of($tickets)
        ->editColumn('priority', function($row){
            $priority = strtolower($row->priority);
            if ($priority === "low") {
                return '<span class="label label-success">'. ucfirst($row->priority) .'</span>';
            }else if($priority === "medium")
            {
                return '<span class="label label-warning">'. ucfirst($row->priority) .'</span>';
            }else
            {
                return '<span class="label label-danger">'. ucfirst($row->priority) .'</span>';
            }

        })
        ->editColumn('status', function($status){
            //dump($status);
            if ($status->status === "Open") {
                return '<span class="label label-success">'.$status->status.'</span>';
            }
            return '<span class="label label-danger">'.$status->status.'</span>';
        })
        ->addColumn('action', function($row){
            return '<a href="'.route('escalate.show', $row->id).'" class="btn btn-info btn-xs">Next</a> 
            ';
        })
        ->removeColumn('id')
        ->make(true);
    }

    public function closeTicket($id)
    {
        $ticket = Ticket::find($id);
        return view('tickets.resolution', compact('ticket'));
    }

    public function closeTicketFinal(Request $request)
    {
        $this->validate($request, [
            'resolution' => 'required|min:8',
        ]);

        $ticket = Ticket::find($request->input('ticket_id'));
        $ticket->resolution = $request->input('resolution');
        $ticket->status = "Closed";
        $ticket->save();

        Session::flash('suc_msg', ' Ticket with '. $ticket->ticket_id. ' has been closed.');
        return redirect()->route('all.tickets');
    } 

    public function escalateList()
    {
        return view('tickets.escalate_index');
    }

    public function escalateShow($id)
    {
        //dd($id);
        $ticket = Ticket::find($id);
        $states = State::all();
        return view('tickets.escalate_show', compact('ticket', 'states'));
    }

    public function escalateViaSms(Request $request)
    {
        $this->validate($request, [
            'region' => 'required'
        ]);

        $ticket = Ticket::find($request->input('ticket_id'));
        $ticket->region = json_encode($request->input('region'));
        $ticket->save();

        //send the sms again her by selectin the whole data again
        $ticket = Ticket::find($request->input('ticket_id'));
        $message = [
            $ticket->ticket_id,
            $ticket->title,
            $ticket->category->name,
            $ticket->priority,
            $ticket->status,
        ];

        //this is to get the numbers
        $state_ids = $request->input('region');

        //this is to keep only unique ids
        $state_ids = array_unique($state_ids);
        $phone_nos = array();

        foreach ($state_ids as $state_id) {
            $users = User::where('region', $state_id)->get();
            foreach ($users as $user) {
                #dump($user->phone_number);
                array_push($phone_nos, $user->phone_number);
            }
        }

        //dump($message);
        //dd($phone_nos);

        //when u fix the sms part, call the function here with 
        //the required values
    }//end of escalateViaSms

}//end of class
