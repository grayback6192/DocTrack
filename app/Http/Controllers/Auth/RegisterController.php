<?php

namespace App\Http\Controllers\Auth;
use App\UserGroupPosition;
use App\Group;
use App\User;
use App\Position;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function showRegistrationForm()
    {
        $sub = \DB::table("subscription")->get();
        return view('registerclient',["subscription"=>$sub]);
    }
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
       'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $rand = rand(1000,99999);
        $userRand = rand(101010,999999);
        $posrand = rand(1000,99999);

        // //for profpic
        //  if(isset($data['clientprofpic']))
        //  {
        //     $path = $request->profpic->store('users/pictures');
        //     $image =$request->profpic->hashName();
        //  }
        //  else
        //     $image="";

        $user = User::create([
            'user_id' => $userRand,
            'email' => $data['email'],
            'contactnum' => $data['contact'],
            'password' => bcrypt($data['password']),
            'lastname'=> $data['lname'],
            'firstname'=> $data['fname'],
            'address'=> $data['address'],
            'gender'=> $data['gender'],
            // 'profilepic' => $image,
            'status'=> 'active',
        ]);
        
        $user->Group = Group::create([
            'group_id'=>$rand,
            'groupName'=>$data['business'],
            'groupDescription'=>'',
            'creator_user_id'=>$userRand,
            'businessKey'=>$data['businessKey'],
            'status'=>'Active',
            ]);

        $user->Position = Position::create([
            'pos_id'=>$posrand,
            'posName'=>'masteradmin',
            'posDescription'=>'masteradmin',
            'status'=>'active',
            'client_id'=>$rand,
            ]);

        $user->UserGroup = UserGroupPosition::create([
        'upg_id'=>rand(10000,99999),
        'position_pos_id'=>$posrand,
        'user_user_id'=>$userRand,
        'rights_rights_id'=>'1',
        'group_group_id'=>$rand,
        'client_id'=> $rand,
        'upg_status'=>'active',
        ]);

        return $user;
    }
}
