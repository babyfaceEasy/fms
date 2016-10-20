<?php

namespace App\Http\Controllers;

use App\User;
use App\Ticket;
use App\Category;
use App\Http\Requests;
use App\Mailers\AppMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Excel;

class AdminController extends Controller
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
    	//$categories = Category::all();

        return view('auth.createaccount');
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

    /**
     * Store a newly created ticket in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, AppMailer $mailer)
    {
				$this->validate($request, [
            'name'     => 'required',
            'email'  => 'required',
            'phone_number'  => 'required',
						'region'		=> 'required',
						'role'		=> 'required',
						'password'		=> 'required'
        ]);
				$user = new User([
            'name'     => $request->input('name'),
            'email'   => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'region'  => $request->input('region'),
            'role'  => $request->input('role'),
            'phone_number'   => $request->input('phone_number'),
        ]);
				$user->save();
				$alertMessage = "User Account Created";
				$alertMessage = str_replace(" ","+",$alertMessage);

				return redirect("/");
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

		public function sendSMS($to,$message){
			$message = str_replace("#","",$message);
			$url = "http://www.smslive247.com/http/index.aspx?cmd=sendquickmsg&owneremail=bayorasunmo@gmail.com&subacct=FMS&subacctpwd=bayorfms&message=".$message."&sender=GLONOC&sendto=".trim($to)."&msgtype=0";
			/* call the URL */

			if ($f = @fopen($url, "r"))  {
				 $answer = fgets($f, 255);
				 if (substr($answer, 0, 1) == "+") {
					   echo $answer;
					 }  else  {
						   echo $answer;
					 }
					 }  else  {
						 return false;
					 }
		}
}
