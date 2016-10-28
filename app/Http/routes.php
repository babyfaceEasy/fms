<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::auth();

Route::get('/', 'HomeController@index');

Route::get('createaccount', 'AdminController@create')->name('createacct.get');

Route::post('createaccount', 'AdminController@store');


Route::get('/myx_tickets', 'TicketsController@anyData')->name('myTicket.data');
Route::get('/myl_tickets', 'TicketsController@allData')->name('tickets.data');

Route::get('/resolution/{ticket_id}', 'TicketsController@closeTicket')->name('close.ticket');
Route::post('/resolution', 'TicketsController@closeTicketFinal')->name('close.ticket.post');

Route::get('new_ticket', 'TicketsController@create');
Route::get('all_tickets', 'TicketsController@getAllTickets')->name('all.tickets');
Route::get('download_report', 'TicketsController@exportExcelReport');
//escalate
Route::get('newsms_list', 'TicketsController@escalateListData')->name('escalate.data');
Route::get('escalate_show/{id}', 'TicketsController@escalateShow')->name('escalate.show');
//end escalate
Route::get('new_sms', 'TicketsController@escalateList');
Route::post('new_ticket', 'TicketsController@store');
Route::get('tickets/{ticket_id}', 'TicketsController@show')->name('ticket.show');
Route::get('my_tickets', 'TicketsController@userTickets');


Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function() {
	Route::get('tickets', 'TicketsController@index');
	Route::post('close_ticket/{ticket_id}', 'TicketsController@close');
});

Route::post('comment', 'CommentsController@postComment');

Route::get('/chngpass', 'HomeController@chngePass')->name('chngpass.get');
Route::post('/chngpass', 'HomeController@changePass')->name('chngpass.post');

Route::get('/test_sms', 'TicketsController@mySendSMS')->name('test.sms');

