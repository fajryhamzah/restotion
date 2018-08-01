<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;
use App\Model\Restoran;
use Mail;

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
        return \Redirect::back()->withInput()->with(["error" => implode("<br />",$validator->errors()->all() )]);
    }

    if($r->input("password") != $r->input("password1")){
        return \Redirect::back()->withInput()->with(["error" => "Password konfirmasi tidak sama"]);
    }

    $email = $r->input("email");
    $username = $r->input("username");
    $password = sha1($r->input("password"));
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

      //send Email
      $data = array('name'=>$name,'hash'=>$insert->verifyHash);
      Mail::send(['html'=>'confirm'], $data, function($message) use($email,$username) {
           $message->to($email, $username)->subject
              ('Konfirmasi akun anda');
           $message->from('blast@restotion.com','Restotion Bot');
        });
      $data['page'] = "login";
      return view('register_success',$data);
    }
    catch(\Exception $e){
        return \Redirect::back()->withInput()->with(["error" => "Terjadi kesalahan pada database. : "]);
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
      return \Redirect::back()->withInput()->with(["error" => implode("<br />",$validator->errors()->all() ) ]);
    }

    $uname = $r->input("uname");
    $pass = sha1($r->input("password"));

    $data = User::where(function($q) use($uname){
      $q->where("email",$uname)->orWhere("username",$uname);
    })->where("password",$pass)->where("verified",1)->first();

    if($data){

      \Session::put("id",$data->id);
      \Session::put("uname",$data->username);
      \Session::put("name",$data->name);

      return \Redirect::to(url('dashboard'));
    }
    else{
      return \Redirect::back()->withInput()->with(["error" => "Username dan password tidak cocok atau akun belum di verifikasi."]);
    }
  }

  //konfirmasi Email
  public function konfirmasi($hash){
    $data = User::where("verifyHash",$hash)->first();

    if( (!$data) || ($data->verified == 1) ){
      return 404;
    }

    $data->verified = 1;

    $data->save();
    $a['page'] = "login";
    return view("confirmCongrats",$a);
  }

  //logout
  public function logout(){
    \Session::flush();

    return \Redirect::to(url("login"));
  }

  //handling form save
  public function settingSave(Request $r){
    $cek = $r->input("display");

    if($cek == 1){
      $rules = array(
        "name" => "required",
        "email" => "required|email"
      );
    }
    else if($cek == 0){
      $rules = array(
        "passwordlama" => "required",
        "passwordbaru" => "required",
        "passwordbarukonf" => "required"
      );
    }
    else{
      return \Redirect::back()->withInput()->with(['error' => "Invalid"]);
    }

    $validator = \Validator::make($r->all(),$rules);

    if($validator->fails()){
      return \Redirect::back()->withInput()->with(['error' => $validator->errors()]);
    }


    if($cek == 1){
      //check Email
      $check_email = User::where("email",$r->input("email"))->where("id","!=",\Session::get("id"))->first();

      //email has been taken by someone else
      if($check_email){
        return \Redirect::back()->with(["error" => "Email telah ada di pakai"]);
      }

      $profile = User::find(\Session::get("id"));
      $profile->email = $r->input("email");
      $profile->name = $r->input("name");

      try{
        $profile->save();

        return \Redirect::to(url('setting'))->with(['success' => 'Sukses diubah']);
      }
      catch(\Exception $e){
        return \Redirect::to(url('setting'))->withInput()->with(['error' => $e->getMessage()]);
      }
    }
    else{

      if($r->input("passwordbaru") != $r->input("passwordbarukonf")){
        return \Redirect::back()->withInput()->with(['error' => "Password baru tidak sama"]);
      }

      $check = User::find(\Session::get("id"));

      if($check->password != sha1($r->input("passwordlama"))){
        return \Redirect::back()->withInput()->with(['error' => "Password tidak sama"]);
      }

      $check->password = sha1($r->input("passwordbaru"));

      try{
        $check->save();

        return \Redirect::to(url('setting'))->with(['success' => 'Sukses ganti password']);
      }
      catch(\Exception $e){
        return \Redirect::to(url('setting'))->withInput()->with(['error' => $e->getMessage()]);
      }

    }
  }

  //INTERFACE

  //interface register
  public function registerInterface(){
    $data['page'] = "login";
    return view("register",$data);
  }

  //interface login
  public function loginInterface(){
    $data['page'] = "login";
    return view("login",$data);
  }

  //interface dashboard
  public function dashboardInterface(){
    $data = Restoran::select("id_restoran as id",'nama_restoran','id_owner')->where("id_owner",\Session::get("id"))->get();

    $data = $data->map(function($item){
        $hash = md5($item->id);
        $logo_path = public_path()."/restoran/".$hash."/";
        $item->logo = (file_exists($logo_path."logo.png"))? asset("restoran/".$hash."/logo.png"):asset("/default.png");
        return $item;
    });

    $item['data'] = $data;
    return view("dashboard",$item);
  }

  //interface setting
  public function settingInterface(){
    $data['profile'] = User::select("email","name")->find(\Session::get("id"));
    $data['hal'] = 1;
    return view("profile/setting",$data);
  }

}
