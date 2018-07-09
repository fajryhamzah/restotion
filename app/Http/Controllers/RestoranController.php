<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        return \Redirect::back()->with(["error" => $validator->errors()]);
    }

    $nama = $r->input("nama");
    $detail = $r->input("detail");
    $logo = $r->file("logo");
    $image = $r->file("image");
    $lat = $r->input("lat");
    $lng = $r->input("lng");

    

  }

}
