<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class SessionController extends Controller
{
    //
    public function getSession($sessionname)
    {
    	// $sessionkey = "'".$sessionname."'";
        
    	// $sessionvalue = $request->session->get($sessionkey);
    	$sessionvalue = Session::get($sessionkey);

    	return $sessionvalue;
    }

    public function putSession($sessionname, $sessionvalue)
    {
    	$sessionkey = "'".$sessionname."'";
    	$sessionval = "'".$sessionvalue."'";
    	// $request->session->put($sessionkey,$sessionval);
    	Session::put($sessionkey,$sessionval);

    	// $newsession = $request->session->get($sessionkey);
    	$newsession = Session::get($sessionkey);

    	return $newsession;
    }
}
