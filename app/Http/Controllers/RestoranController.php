<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Restoran;
use App\Model\RestoranImage;

class RestoranController extends Controller
{

  //add restaurant
  public function addRestoran(Request $r){
    $rules = array(
        'nama' => 'required|min:1',
        'detail' => 'required|min:4',
        'logo' => 'required|file',
        'image.*' => 'file|mimes:jpg,jpeg,png,bmp|max:1000',
        'lat' => 'required',
        'lng' => 'required',
    );

    $validator = \Validator::make($r->all(), $rules,[
                    'image.*.mimes' => 'Format yang diijinkan jpg,jpeg,png dan bmp',
                    'image.*.max' => 'Ukurang gambar maksimal 1MB',
                ]);

    if($validator->fails()){
        return \Redirect::back()->withInput()->with(["error" => $validator->errors()]);
    }

    $nama = $r->input("nama");
    $detail = $r->input("detail");
    $logo = $r->file("logo");
    $images = $r->file("image");
    $lat = $r->input("lat");
    $lng = $r->input("lng");

    $newResto = new Restoran;
    $newResto->nama_restoran = $nama;
    $newResto->detail_restoran = $detail;
    $newResto->latitude = $lat;
    $newResto->longitude = $lng;
    $newResto->id_owner = \Session::get("id");

    try{
      $newResto->save();

      //get the id
      $id = $newResto->id_restoran;
      $path = public_path()."/restoran/".md5($id)."/";
      //logo
      $logo->move($path,"logo.png");

      //check if there is image list
      if($images){
        $url = array();
        foreach($images as $image){
          $name = $image->getClientOriginalName();
          $ext = $image->getClientOriginalExtension();
          $filename = md5(time().$name).".".$ext;
          $image->move($path,$filename);

          $url[] = array("link" => $filename, "id_restoran" => $id);
        }

        //save to db
        RestoranImage::insert($url);
      }

      return \Redirect::to(url("dashboard"));
    }
    catch(\Exception $e){
      dd($e->getMessage());
    }







  }

}
