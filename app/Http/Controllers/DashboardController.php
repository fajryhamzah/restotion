<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;

class DashboardController extends Controller
{


  //handling registration
  public function register(Request $r){
    $rules = array(
        'username' => 'required|min:4',
        'password' => 'required|min:4',
        'password1' => 'required|min:4',
        'email' => 'required|email',
        'name' => 'required'
    );

    $validator = \Validator::make($r->all(), $rules);

    if($validator->fails()){
        return \Redirect::back()->with(["error" => $validator->errors()]);
    }

    if($r->input("password") != $r->input("password1")){
        return \Redirect::back()->withInput()->with(["error" => "Password konfirmasi tidak sama"]);
    }

    $email = $r->input("email");
    $username = $r->input("username");
    $password = md5($r->input("password"));
    $name = $r->input("name");

    $find = User::where("username",$username)->orWhere("email",$email)->first();

    //username or email already registered
    if($find){
        return \Redirect::back()->withInput()->with(["error" => "Username/Email telah terdaftar"]);
    }

    $insert = new User;
    $insert->username = $username;
    $insert->password = $password;
    $insert->email = $email;
    $insert->name = $name;
    $insert->verifyHash = sha1(time().$username);
    $insert->joined = date('Y-m-d h:i:s',time());

    try{
      $insert->save();

      return view('register_success');
    }
    catch(\Exception $e){
        return \Redirect::back()->withInput()->with(["error" => "Terjadi kesalahan pada database."]);
    }

  }

  //handling login request
  public function login(Request $r){
    $rules = array(
      "uname" => "required",
      "password" => "required"
    );

    $validator = \Validator::make($r->all(), $rules);

    if($validator->fails()){
      return \Redirect::back()->withInput()->with(["error" => $validator->errors()]);
    }

    $uname = $r->input("uname");
    $pass = md5($r->input("password"));

    $data = User::where(function($q) use($uname){
      $q->where("email",$uname)->orWhere("username",$uname);
    })->where("password",$pass)->first();

    if($data){
      return \Redirect::to(url('\dashboard'));
    }
    else{
      return \Redirect::back()->withInput()->with(["error" => "Username dan password tidak cocok."]);
    }
  }



}
