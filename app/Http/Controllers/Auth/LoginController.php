<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function showLoginForm()
    {
        return view("login");
    }
    public function username()
    {
        return "email";
    }
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    protected function redirectTo()
    {
        $id = Auth::user();
        $role = \DB::table('userpositiongroup as upg')->where('upg.user_user_id','=',$id->user_id)
                    ->join('rights as r','upg.rights_rights_id','=','r.rights_id')
                    ->select("r.rightsName","upg.position_pos_id","upg.group_group_id","upg.upg_id",'upg.client_id')
                    ->get();
        foreach ($role as $roles) {
           $title = $roles->rightsName;
           $group = $roles->group_group_id;
           $upgid = $roles->upg_id;
           $clientid = $roles->client_id;
        }
            \Session::put('client',$clientid);

        if($title == "Admin")
            return "/admin";
        else if($title == "Super Admin")
            return "/superadmin";
        else{
            $redirect = "/groups/".$id->user_id;
            return $redirect;
        }
    }

    public function getBusinessKey()
    {
        return response()->json("Data"); //Ajax Test
    }
    
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        return redirect('/');
    }
}
