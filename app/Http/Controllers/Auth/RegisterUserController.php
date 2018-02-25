<?php

namespace App\Http\Controllers\Auth;
use App\UserGroupPosition;
use App\Group;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Storage;

class RegisterUserController extends Controller
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
        $group = \DB::table("group")->where('group_group_id','=',NULL)->get();
        return view('registeruser',["group"=>$group]);
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

        //validate if email already taken
        $sameemails = \DB::table('user')->where('email','=',$data['email'])->get();

        if(count($sameemails)>0)
        {
            return redirect()->route('RegisterUser')->with('emailtaken','This email is already taken.');
        }

        //validate if group exists
        $groupkeys = \DB::table('group')->where('businessKey','=',$data['business'])->get();
        if(count($groupkeys)==0)
            return redirect()->route('RegisterUser')->with('nokey','No school with such key exists.');

         $rand = rand(100000,999999);

        if(isset($data['sign']))
        {
             Storage::putFileAs("signature",$data['sign'],$rand.".png");
             $signpath = "signature/".$rand.".png";
        }
        else
            $signpath="";

        if(isset($data['userprofpic']))
        {
             $path = $data['userprofpic']->store('users/pictures');
            $image = $data['userprofpic']->hashName();
        }
        else
            $image="default.png";


        $user = User::create([
            'user_id' => $rand,
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'lastname'=> $data['lname'],
            'firstname'=> $data['fname'],
            'address'=> $data['address'],
            'contactnum'=>$data['contact'],
            'gender'=> $data['gender'],
            'profilepic'=>$image,
            'signature'=>$signpath,
            'status'=> 'active',
        ]);
            
        $businessKey = \DB::table("group")->where("businessKey","=",$data['business'])->get();

        foreach($businessKey as $businessKeys)
            $group = $businessKeys->group_id;

        $user->UserGroup = UserGroupPosition::create([
            'upg_id'=>rand(10000,99999),
            'position_pos_id'=>NULL,
            'user_user_id'=>$rand,
            'rights_rights_id'=>'2',
            'group_group_id'=>NULL,
            'client_id'=> $group,
            'upg_status'=>'inactive',
        ]);
        return $user;
    }

}
