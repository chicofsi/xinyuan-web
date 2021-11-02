<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


class LoginController extends Controller
{
    public function getLogin()
  	{
  		if(Auth::check()){
            return redirect()->intended('/dashboard');
  		}
    	return view('auth.login');
  	}

  	public function postLogin(Request $request)
  	{

      	// Validate the form data
    	$this->validate($request, [
	      'username' => 'required',
	      'password' => 'required'
    	]);

    	if (Auth::guard('web')->attempt(['username' => $request->username, 'password' => $request->password]) || Auth::guard('sales')->attempt(['email' => $request->username, 'password' => $request->password])) {

  			return redirect()->intended('/dashboard');
    	} else {
            return redirect()->back()->withErrors(new MessageBag(['password' => ['Email and/or password invalid.']]));

        }



  	}

    public function logout( Request $request )
    {
        Auth::logout();

        return redirect()->intended('/login');
    }
}
