<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

//facades
use Auth;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
    * This return the page for change password
    * @return \Illuminate\Http\Response
    */
    public function chngePass()
    {
        return view('change_password');
    }

    /**
    * this is to change the password
    */
    public function changePass(Request $request)
    {
        $this->validate($request, [
            'newpass' => 'required|confirmed|min:6'
        ]);
        $input =  $request->only('newpass');

        $user = Auth::user();

        $user->password =  bcrypt($input['newpass']);

        if($user->save()){
            Session::flash('suc_msg', ' Password change was successful!');
            return redirect('/logout');
        }else{
            Session::flash('err_msg', ' An error occured. Try again later');
            return redirect('/home');
        }       
        //return redirect('/logout');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = Auth::user();
        $info = false;
        if($auth->created_at == $auth->updated_at)
            $info = true;
        //return view('home')->with('info', $info);
        return view('tickets.index')->with('info', $info);
    }
}
