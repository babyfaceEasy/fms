<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use Datatables;
use Auth;
use Excel;
use App\Ticket;
use App\Comment;

use App\Http\Requests;

class ReportController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function index()
    {
    	return view('tickets.report_index');
    }

    public function allData()
    {
    	$tickets = Ticket::select(['id', 'ticket_id', 'title', 'status'])->where('status', 'Closed');
    	return Datatables::of($tickets)
    	->editColumn('status', function($status){
            return '<span class="label label-danger">'.$status->status.'</span>';
        })
        ->addColumn('action', function($row){
            return '<a href="'.route('escalate.show', $row->id).'" class="btn btn-info btn-xs">Generate Report</a> 
            ';
        })
        ->removeColumn('id')
        ->make(true);
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
}
