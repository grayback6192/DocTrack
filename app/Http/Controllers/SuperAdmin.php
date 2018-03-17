<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class SuperAdmin extends Controller
{

    public function addUser()
    {
      $users = request()->all();
      \DB::table("user")->insert(["userId"=>$users['id'],
                                  "password"=>$users['password'],
                                  "firstName"=>$users['fname'],
                                  "lastName"=>$users['lname'],
                                  "gender"=>$users['gender'],
                                  "email"=>$users['email'],
                                  "contactNumber"=>$users['contactnum'],
                                  "address"=>$users['address'],
                                  "type"=>"user"]);
      $subscription = \DB::table("subscription")->where("subName",$users['subscription'])->get();
      foreach($subscription as $sub)
      {
      \DB::table("userbusiness")->insert(["name"=>$users['businessName'],
                                          "user"=>$sub->numbUsers,
                                          "templates"=>$sub->numbTemplate,
                                          "user_userId"=>$users['id'],
                                          "status"=>"Pending",
                                          "expiry"=>"1/1/2018",
                                          "subscription"=>$sub->subName]);
    }
      return redirect()->route("Login");
    }
    public function select()
    {
       $credentials = request()->all();
       $users = \DB::table("user")->where('user_id','=',$credentials['userid'])->where('password','=',$credentials['password'])->first();
       if($users){
        $_SESSION['userid'] = $credentials['userid'];
        $userid = $_SESSION['userid'];
        $user = \DB::table('user')->where('user_id','=',$userid);
        return view("user/userhome",['infos'=>$user]);
      }
      else
      {
        echo "<script>alert('Wrong Credentials')</script>";
        return view("user/loginpage");
      }
    }  

    public function addSubscription()
    {
      $subscription = request()->all();
      \DB::table("subscription")->insert(["subName"=>$subscription["subName"],
                                          "numbTemplate"=>$subscription["numtemp"],
                                          "numbUsers"=>$subscription["numusers"],
                                          "price"=>$subscription["price"]]);
      return redirect()->route("Subscription");
    } 

    public function delete($id)
    {
      \DB::Table("subscription")->where("idsubscription",$id)->delete();
      return redirect()->route("Subscription");
    }


   
}
