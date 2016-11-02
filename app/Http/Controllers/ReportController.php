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

    public function exportExcel($type ='t', $mode='o')
    {
        //1 = > transmission
        //2 = > base station switch
        //3 = > IP Network

        /*$tickets = Ticket::select(['id', 'user_id', 'ticket_id', 'title', 'priority', 'nodeA', 'nodeB', 'vendor', 'time_occurence', 'cause_of_failure', 'impact' ])
            ->with(['user'], function($query){
                dump($query->id);
            })
            ->where([
                ['category_id', '=', '1'],
                ['status', '=', 'Open']
            ])->get();

        dd($tickets->all());*/

        //$tickets = Ticket::all();
        if($type == 't' && $mode == 'o')
        {
            //dis is to create the excel file
            Excel::create('transmission', function($excel){

                $excel->sheet('Open Tickets', function($sheet){

                    $tickets =  Ticket::select(['id', 'user_id', 'ticket_id', 'title', 'priority', 'nodeA', 'nodeB', 'vendor', 'time_occurence', 'cause_of_failure', 'impact'])
                    ->where([
                            ['category_id', '=', '1'],
                            ['status', '=', 'Open']
                        ])
                    ->get();

                    $arr = array();

                    foreach ($tickets as $ticket) {
                        $data = array($ticket->id, $ticket->user->email, $ticket->ticket_id, $ticket->title, $ticket->priority, $ticket->nodeA, $ticket->nodeB, $ticket->vendor, $ticket->time_occurence, $ticket->cause_of_failure, $ticket->impact);

                        array_push($arr, $data);
                    }

                //set titles

                    $sheet->fromArray($arr, null, 'A1', false, false)->prependRow(
                        array('Ticket Id', 'Category', 'Ticket #', 'Title', 'Priority', 'Node A', 'Node B', 'Vendor', 'Time of Occurence', 'Caue of Failure', 'Impact')
                    ); 
                });
            })->export('xlsx');
        }//end of typ == 't' and mode == 'o'
        else if($type == 't' && $mode == 'c'){

            //dis is to create the excel file
            Excel::create('transmission', function($excel){

                $excel->sheet('Closed Tickets', function($sheet){

                    $tickets =  Ticket::select(['id', 'user_id', 'ticket_id', 'title', 'priority', 'nodeA', 'nodeB', 'vendor', 'time_occurence', 'cause_of_failure', 'impact', 'resolution'])
                    ->where([
                            ['category_id', '=', '1'],
                            ['status', '=', 'Closed']
                        ])
                    ->get();

                    $arr = array();

                    foreach ($tickets as $ticket) {
                        $data = array($ticket->id, $ticket->user->email, $ticket->ticket_id, $ticket->title, $ticket->priority, $ticket->nodeA, $ticket->nodeB, $ticket->vendor, $ticket->time_occurence, $ticket->cause_of_failure, $ticket->impact, $ticket->resolution, $ticket->updated_at);

                        array_push($arr, $data);
                    }

                //set titles

                    $sheet->fromArray($arr, null, 'A1', false, false)->prependRow(
                        array('Ticket Id', 'Category', 'Ticket #', 'Title', 'Priority', 'Node A', 'Node B', 'Vendor', 'Time of Occurence', 'Caue of Failure', 'Impact', 'Resolution', 'Closed At')
                    ); 
                });
            })->export('xlsx');

        }//end of elseif( $type == 't' && $mode == 'c')
        else if($type == 'b' && $mode == 'o'){
            //dis is to create the excel file
            Excel::create('Base Station Switch', function($excel){

                $excel->sheet('Open Tickets', function($sheet){

                    $tickets =  Ticket::select(['id', 'user_id', 'ticket_id', 'title', 'priority', 'site_id', 'bsc','time_occurence', 'cause_of_failure', 'impact'])
                    ->where([
                            ['category_id', '=', '2'],
                            ['status', '=', 'Open']
                        ])
                    ->get();

                    $arr = array();

                    foreach ($tickets as $ticket) {
                        $data = array($ticket->id, $ticket->user->email, $ticket->ticket_id, $ticket->title, $ticket->priority, $ticket->site_id, $ticket->bsc,  $ticket->time_occurence, $ticket->cause_of_failure, $ticket->impact);

                        array_push($arr, $data);
                    }

                //set titles

                    $sheet->fromArray($arr, null, 'A1', false, false)->prependRow(
                        array('Ticket Id', 'Category', 'Ticket #', 'Title', 'Priority', 'Site ID', 'BSC / RND', 'Time of Occurence', 'Caue of Failure', 'Impact')
                    ); 
                });
            })->export('xlsx');
        }//end of else if ($type == 'b' && $mode == 'o')
        else if($type == 'b' && $mode == 'c'){
            //dis is to create the excel file
            Excel::create('Base Station Switch', function($excel){

                $excel->sheet('Open Tickets', function($sheet){

                    $tickets =  Ticket::select(['id', 'user_id', 'ticket_id', 'title', 'priority', 'site_id', 'bsc','time_occurence', 'cause_of_failure', 'impact', 'resolution', 'updated_at'])
                    ->where([
                            ['category_id', '=', '2'],
                            ['status', '=', 'Closed']
                        ])
                    ->get();

                    $arr = array();

                    foreach ($tickets as $ticket) {
                        $data = array($ticket->id, $ticket->user->email, $ticket->ticket_id, $ticket->title, $ticket->priority, $ticket->site_id, $ticket->bsc,  $ticket->time_occurence, $ticket->cause_of_failure, $ticket->impact, $ticket->resolution, $ticket->updated_at);

                        array_push($arr, $data);
                    }

                //set titles

                    $sheet->fromArray($arr, null, 'A1', false, false)->prependRow(
                        array('Ticket Id', 'Category', 'Ticket #', 'Title', 'Priority', 'Site ID', 'BSC / RND', 'Time of Occurence', 'Caue of Failure', 'Impact', 'Resolution', 'Closed At')
                    ); 
                });
            })->export('xlsx');
        }//end of else if($type == 'b' && $mode == 'c')
        else if($type == 'i' && $mode == 'o'){
            //dis is to create the excel file
            Excel::create('IP Network', function($excel){

                $excel->sheet('Open Tickets', function($sheet){

                    $tickets =  Ticket::select(['id', 'user_id', 'ticket_id', 'title', 'priority', 'location','time_occurence', 'cause_of_failure', 'impact'])
                    ->where([
                            ['category_id', '=', '3'],
                            ['status', '=', 'Open']
                        ])
                    ->get();

                    $arr = array();

                    foreach ($tickets as $ticket) {
                        $data = array($ticket->id, $ticket->user->email, $ticket->ticket_id, $ticket->title, $ticket->priority, $ticket->location,$ticket->time_occurence, $ticket->cause_of_failure, $ticket->impact);

                        array_push($arr, $data);
                    }

                //set titles

                    $sheet->fromArray($arr, null, 'A1', false, false)->prependRow(
                        array('Ticket Id', 'Category', 'Ticket #', 'Title', 'Priority', 'Location', 'Time of Occurence', 'Caue of Failure', 'Impact')
                    ); 
                });
            })->export('xlsx');
        }//end of ekse if ($type == 'i' && $mode == 'o')
        else if ($type == 'i' && $mode == 'c'){
            //dis is to create the excel file
            Excel::create('IP Network', function($excel){

                $excel->sheet('Open Tickets', function($sheet){

                    $tickets =  Ticket::select(['id', 'user_id', 'ticket_id', 'title', 'priority', 'location','time_occurence', 'cause_of_failure', 'impact', 'resolution', 'updated_at'])
                    ->where([
                            ['category_id', '=', '3'],
                            ['status', '=', 'Closed']
                        ])
                    ->get();

                    $arr = array();

                    foreach ($tickets as $ticket) {
                        $data = array($ticket->id, $ticket->user->email, $ticket->ticket_id, $ticket->title, $ticket->priority, $ticket->location,$ticket->time_occurence, $ticket->cause_of_failure, $ticket->impact, $ticket->resolution, $ticket->updated_at);

                        array_push($arr, $data);
                    }

                //set titles

                    $sheet->fromArray($arr, null, 'A1', false, false)->prependRow(
                        array('Ticket Id', 'Category', 'Ticket #', 'Title', 'Priority', 'Location', 'Time of Occurence', 'Caue of Failure', 'Impact', 'Resolution', 'Closed At')
                    ); 
                });
            })->export('xlsx');
        }
    }//end of func
}
