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
use DB;

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
            //output format:
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
            $time_of_occurence = null;
            $cause_of_failure = null;
            $impact = null;

			if($request['category'] == '1')
            {
    			$this->validate($request, [
                    'title'     => 'required',
                    'category'  => 'required',
                    'priority'  => 'required',
        			'node_a'		=> 'required',
        			'node_b'		=> 'required',
                    'vendor' => 'required',
                    'time_of_occurence1' => 'required',
                    'cause_of_failure1' => 'required',
                ]);

                $time_of_occurence = $request->input('time_of_occurence1');
                $cause_of_failure = $request->input('cause_of_failure1');
                $impact = $request->input('impact1');
			}
            elseif($request['category'] == '2')
            {
    			$this->validate($request, [
                'title'     => 'required',
                'category'  => 'required',
                'priority'  => 'required',
                'site_id'  => 'required',
                'bsc'  => 'required',
                'time_of_occurence2' => 'required',
                'cause_of_failure2' => 'required',
                ]);
                $time_of_occurence = $request->input('time_of_occurence2');
                $cause_of_failure = $request->input('cause_of_failure2');
                $impact = $request->input('impact2');
			}
            elseif($request['category'] == '3')
            {
    			$this->validate($request, [
                    'title'     => 'required',
                    'category'  => 'required',
                    'priority'  => 'required',
                    'location'  => 'required',
                    'time_of_occurence3' => 'required',
                    'cause_of_failure3' => 'required',
                ]);

                $time_of_occurence = $request->input('time_of_occurence3');
                $cause_of_failure = $request->input('cause_of_failure3');
                $impact = $request->input('impact3');
			}
            else
            {
    			$this->validate($request, [
                'title'     => 'required',
                'category'  => 'required',
                'priority'  => 'required',
                //'time_of_occurence' => 'required',
                //'cause_of_failure' => 'required',
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
        'time_occurence'   => $time_of_occurence,
        'cause_of_failure'   => $cause_of_failure,
        'impact'   => $impact,
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

        array_push($message, $time_of_occurence);
        array_push($message, $cause_of_failure);
        array_push($message, $impact);

        //dump($message);
        //die();
        $ticket->save();
        //$message = str_replace(" ", "+", $message);
        //$alertMessage = "A transmission ticket with ID: #$ticket->ticket_id has been opened.";
        //$alertMessage = str_replace(" ","+",$alertMessage);
        $ret = $this->sendSMS($phone_nos,$message);

        if($ret == "error")
        {
            Session::flash('err_msg', "An error occured while trying to send the SMS please retry by using the escalate via SMS link");
        }
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


	//always use this function to send sms... pass in to: and Message:
	public function sendSMS($to = null,$message = null){

        $to = trim(implode(",", $to));
        $to = rtrim($to, ',');

        if(is_array($message))
        {
            $message = trim(implode("\n", $message));
        }

		$message = str_replace(" ","+",$message);

		//URL must never have space, replace all space with +
		//$message = str_replace(" ","+",$message);
		$url = "http://www.smslive247.com/http/index.aspx?cmd=sendquickmsg&owneremail=bayorasunmo@gmail.com&subacct=FMS&subacctpwd=bayorfms&message=".$message."&sender=FMSNOC&sendto=".trim($to)."&msgtype=0";
		/* call the URL */

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
        }  
        else
        {
            return "error";
        }
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
        DB::statement(DB::raw('set @rownum=0'));
        $tickets =  Ticket::select([
            DB::raw('@rownum := @rownum + 1 AS rownum'),
            'id', 'ticket_id', 'category_id', 'title', 'priority', 'status']);
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
        $ticket->updated_at =  date('Y-m-d H:i:s') ;
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
            'region' => 'required',
            'message' => 'required|min:3',
        ]);

        $ticket = Ticket::find($request->input('ticket_id'));
        $ticket->region = json_encode($request->input('region'));
        $ticket->save();

        //send the sms again here by selectin the whole data again
        /*$ticket = Ticket::find($request->input('ticket_id'));
        $message = [
            $ticket->ticket_id,
            $ticket->title,
            $ticket->category->name,
            $ticket->priority,
            $ticket->status,
        ];
        */

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

        dump($message);
        //dd($phone_nos);

        $ret = $this->sendSMS($phone_nos, $request->input('message'));

        if($ret != 'error')
        {
            Session::flash('suc_msg', ' Escalation operation was successful.');
            return redirect()->route('escalate.data');
        }
    }//end of escalateViaSms

}//end of class
