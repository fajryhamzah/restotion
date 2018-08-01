<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Restoran;
use App\Model\Menu;
use App\Model\Meja;
use App\Model\RestoranImage as Gallery;

class RestoranController extends Controller
{
  private $error;

  //add restaurant
  public function addRestoran(Request $r){
    $rules = array(
        'nama' => 'required|min:1',
        'detail' => 'required|min:4',
        'logo' => 'required|file',
        'image.*' => 'file|mimes:jpg,jpeg,png,bmp|max:1000',
        'jam_buka' => 'required|date_format:"G:i"|before:jam_tutup',
        'jam_tutup' => 'required|date_format:"G:i"',
        'hari.*' => 'required|min:1|max:7',
        'lat' => 'required',
        'lng' => 'required',
    );

    $validator = \Validator::make($r->all(), $rules,[
                    'image.*.mimes' => 'Format yang diijinkan jpg,jpeg,png dan bmp',
                    'image.*.max' => 'Ukurang gambar maksimal 1MB',
                ]);

    if($validator->fails()){
        return \Redirect::back()->withInput()->with(["error" => "<li>".implode("</li><li>",$validator->errors()->all())."</li>" ]);
    }

    $nama = $r->input("nama");
    $detail = $r->input("detail");
    $logo = $r->file("logo");
    $images = $r->file("image");
    $lat = $r->input("lat");
    $buka = $r->input("jam_buka");
    $tutup = $r->input("jam_tutup");
    $hari = $r->input("hari");
    $lng = $r->input("lng");

    $newResto = new Restoran;
    $newResto->nama_restoran = $nama;
    $newResto->detail_restoran = $detail;
    $newResto->jam_buka = $buka;
    $newResto->jam_tutup = $tutup;
    $newResto->hari_buka = json_encode($hari);
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
        Gallery::insert($url);
      }

      return \Redirect::to(url("dashboard"))->with(["success" => "Berhasil ditambahkan!"]);
    }
    catch(\Exception $e){
      dd($e->getMessage());
    }
  }

  public function deleteRestoran($id){
    $info = Restoran::find($id);

    $cek = $this->cekHak($info);

    if(!$cek) return $this->error;

    try{
      $info->delete();

      return \Redirect::to(url("dashboard"))->with(['success' => "Berhasil di hapus!"]);
    }
    catch(\Exception $e){
      dd($e->getMessage());
    }

  }

  public function getRestoranInfo($id){
    $data['info'] = Restoran::find($id);

    $cek = $this->cekHak($data['info']);

    if(!$cek){
      return false;
    }

    $hash = md5($id);
    $logo_path = public_path()."/restoran/".$hash."/";
    $data['logo'] = (file_exists($logo_path."logo.png"))? asset("restoran/".$hash."/logo.png"):asset("/default.png");

    return $data;
  }

  public function cekHak($info){
    if(!$info){
      $this->error = \Redirect::to(url("dashboard"))->with(['error' => "Not Found"]);
      return false;
    }

    if($info->id_owner != \Session::get("id")){
      $this->error = \Redirect::to(url("dashboard"))->with(['error' => "Not Authorized"]);
      return false;
    }

    return true;
  }

  public function detail($id,Request $r){
    $data = Restoran::find($id);

    $cek = $this->cekHak($data);

    if(!$cek) return $this->error;

    $rules = array(
        "logo" => "file",
        "nama" => "required|min:1",
        'detail' => 'required|min:4',
        'jam_buka' => 'required|date_format:"G:i"|before:jam_tutup',
        'jam_tutup' => 'required|date_format:"G:i"',
        'hari.*' => 'required|min:1|max:7',
        'lat' => 'required',
        'lng' => 'required',
    );

    $validator = \Validator::make($r->all(),$rules);

    if($validator->fails()){
        return \Redirect::back()->withInput()->with(["error" => "<li>".implode("</li><li>",$validator->errors()->all())."</li>" ]);
    }

    $nama = $r->input("nama");
    $detail = $r->input("detail");
    $logo = $r->file("logo");
    $lat = $r->input("lat");
    $buka = $r->input("jam_buka");
    $tutup = $r->input("jam_tutup");
    $hari = $r->input("hari");
    $lng = $r->input("lng");



    $data->nama_restoran = $nama;
    $data->detail_restoran = $detail;
    $data->jam_buka = $buka;
    $data->jam_tutup = $tutup;
    $data->hari_buka = json_encode($hari);
    $data->latitude = $lat;
    $data->longitude = $lng;

    try{
      $data->save();

      //get the id
      $id = $data->id_restoran;
      $path = public_path()."/restoran/".md5($id)."/";
      //logo

      if($logo){
        $logo->move($path,"logo.png");
      }

      return \Redirect::to(url("dashboard/".$id))->with(["success" => "Berhasil diedit!"]);
    }
    catch(\Exception $e){
      dd($e->getMessage());
    }

  }

  public function getGalleryList($id){
    $data = Gallery::select("id_image","link")->where("id_restoran",$id)->get();

    return $data;
  }

  public function galleryAdd($id,Request $r){
    $rules = array(
        'image.*' => 'required|file|mimes:jpg,jpeg,png,bmp|max:1000',
    );

    $validator = \Validator::make($r->all(), $rules,[
                    'image.*.mimes' => 'Format yang diijinkan jpg,jpeg,png dan bmp',
                    'image.*.max' => 'Ukurang gambar maksimal 1MB',
                ]);

    if($validator->fails()){
        return \Redirect::back()->with(["error" => "<li>".implode("</li><li>",$validator->errors()->all())."</li>" ]);
    }

    $data = Restoran::find($id);

    $cek = $this->cekHak($data);

    if(!$cek) return $this->error;

    if(!$r->file("image")){
      return \Redirect::back()->with(["error" => "Pilih gambar terlebih dahulu" ]);
    }

    $url = array();
    $path = public_path()."/restoran/".md5($id)."/";
    foreach($r->file("image") as $image){
      $name = $image->getClientOriginalName();
      $ext = $image->getClientOriginalExtension();
      $filename = md5(time().$name).".".$ext;
      $image->move($path,$filename);

      $url[] = array("link" => $filename, "id_restoran" => $id);
    }


    try{
      Gallery::insert($url);

      return \Redirect::back()->with(["success" => "Berhasil ditambahkan"]);
    }
    catch(\Exception $e){
      dd($e->getMessage());
    }



  }

  public function galleryDelete($id,$im){
    $data = Restoran::find($id);

    $cek = $this->cekHak($data);

    if(!$cek) return $this->error;

    $info = Gallery::find($im);

    if($id != $info->id_restoran){
      return \Redirect::to(url("dashboard"))->with(['error' => "Not Authorized"]);
    }

    \File::delete(public_path()."/restoran/".md5($id)."/".$info->link);
    $info->delete();

    return \Redirect::back()->with(["success" => "berhasil dihapus"]);
  }

  public function getAppetizerList($id){
    $find = Menu::where("tipe","Appetizer")->where("id_restoran",$id)->paginate(10);

    return $find;
  }

  public function getMainMenuList($id){
    $find = Menu::where("tipe","Main Dishes")->where("id_restoran",$id)->paginate(10);
    $find->setPageName('main');

    return $find;
  }

  public function getDrinkList($id){
    $find = Menu::where("tipe","Drinks")->where("id_restoran",$id)->paginate(10);
    $find->setPageName('drink');

    return $find;
  }

  public function getDessertList($id){
    $find = Menu::where("tipe","Desserts")->where("id_restoran",$id)->paginate(10);
    $find->setPageName('dessert');

    return $find;
  }

  public function deleteMenu($id,$mn){
    $data = Restoran::find($id);
    $cek = $this->cekHak($data);
    if(!$cek) return $this->error;

    $menu = Menu::find($mn);
    if($menu->id_restoran != $id){
      return \Redirect::to(url("dashboard"))->with(['error' => "Not Authorized"]);
    }

    $img = $menu->image;

    try{
      //delete file
      \File::delete(public_path()."/restoran/".md5($id)."/".$img);

      //delete from db
      $menu->delete();

      return \Redirect::back()->with(["success" => "Menu berhasil dihapus"]);
    }
    catch(\Exception $e){
      dd($e->getMessage());
    }
  }

  public function addMenu($id,Request $r){
    $data = Restoran::find($id);
    $cek = $this->cekHak($data);
    if(!$cek) return $this->error;

    $rules = array(
      "nama" => "required|min:3",
      "harga" => "required|min:1",
      "detail" => "required|min:1|max:100",
      "tipe" => ["required", \Illuminate\Validation\Rule::in(['Appetizer','Main Dishes','Drinks','Desserts'])],
      "gambar" => "required|file|mimes:jpg,jpeg,png,bmp|max:1024"
    );

    $validator = \Validator::make($r->all(),$rules);

    if($validator->fails()){
      return \Redirect::back()->withInput()->with(["error" => "<li>".implode("</li><li>",$validator->errors()->all())."</li>" ]);
    }

    $nama = $r->input("nama");
    $harga = $r->input("harga");
    $detail = $r->input("detail");
    $tipe = $r->input("tipe");
    $gambar = $r->file("gambar");

    $menu = new Menu;
    $menu->nama_menu = $nama;
    $menu->harga = $harga;
    $menu->detail_menu = $detail;
    $menu->tipe = $tipe;
    $menu->id_restoran = $id;

    $path = public_path()."/restoran/".md5($id)."/menu/";


    try{
      //pindah gambar
      $name = $gambar->getClientOriginalName();
      $ext = $gambar->getClientOriginalExtension();
      $filename = md5(time().$name).".".$ext;
      $gambar->move($path,$filename);

      //save db
      $menu->image = $filename;
      $menu->save();

      return \Redirect::to(url("dashboard/menu/".$id))->with(['success' => "Berhasil ditambahkan"]);
    }
    catch(\Exception $e){
      dd($e->getMessage());
    }
  }

  public function editMenu($id,$mn,Request $r){
    $data = Restoran::find($id);
    $cek = $this->cekHak($data);
    if(!$cek) return $this->error;

    $rules = array(
      "nama" => "required|min:3",
      "harga" => "required|min:1",
      "detail" => "required|min:1|max:100",
      "tipe" => ["required", \Illuminate\Validation\Rule::in(['Appetizer','Main Dishes','Drinks','Desserts'])],
      "gambar" => "file|mimes:jpg,jpeg,png,bmp|max:1024"
    );

    $validator = \Validator::make($r->all(),$rules);

    if($validator->fails()){
      return \Redirect::back()->withInput()->with(["error" => "<li>".implode("</li><li>",$validator->errors()->all())."</li>" ]);
    }

    $nama = $r->input("nama");
    $harga = $r->input("harga");
    $detail = $r->input("detail");
    $tipe = $r->input("tipe");
    $gambar = $r->file("gambar");

    $menu = Menu::find($mn);

    if($menu->id_restoran != $id){
      return \Redirect::to(url("dashboard"))->with(['error' => "Not Authorized"]);
    }

    $menu->nama_menu = $nama;
    $menu->harga = $harga;
    $menu->detail_menu = $detail;
    $menu->tipe = $tipe;
    $menu->id_restoran = $id;



    try{

      if($gambar){
        //pindah gambar
        $path = public_path()."/restoran/".md5($id)."/menu\/";
        //old image
        \File::delete($path.$menu->image);
        $name = $gambar->getClientOriginalName();
        $ext = $gambar->getClientOriginalExtension();
        $filename = md5(time().$name).".".$ext;
        $gambar->move($path,$filename);
        $menu->image = $filename;
      }

      //save db
      $menu->save();

      return \Redirect::to(url("dashboard/menu/".$id))->with(['success' => "Berhasil ditambahkan"]);
    }
    catch(\Exception $e){
      dd($e->getMessage());
    }
  }

  public function addMeja($id,Request $r){
    $data = Restoran::find($id);
    $cek = $this->cekHak($data);
    if(!$cek) return $this->error;

    $rules = array(
      "nama" => "required|min:1",
      "kapasitas" => "required|min:1",
      "detail" => "required|min:1|max:100"
    );

    $validator = \Validator::make($r->all(),$rules);

    if($validator->fails()){
      return \Redirect::back()->withInput()->with(["error" => "<li>".implode("</li><li>",$validator->errors()->all())."</li>" ]);
    }

    $nama = $r->input("nama");
    $harga = $r->input("kapasitas");
    $detail = $r->input("detail");

    $meja = new Meja;
    $meja->nama_meja = $nama;
    $meja->kapasitas = $harga;
    $meja->keterangan = $detail;
    $meja->status = 0;
    $meja->id_restoran = $id;

    try{
      $meja->save();

      return \Redirect::to(url("dashboard/meja/".$id))->with(['success' => "Berhasil ditambahkan"]);
    }
    catch(\Exception $e){
      dd($e->getMessage());
    }
  }

  public function editMeja($id,$mn,Request $r){
    $data = Restoran::find($id);
    $cek = $this->cekHak($data);
    if(!$cek) return $this->error;

    $rules = array(
      "nama" => "required|min:1",
      "kapasitas" => "required|min:1",
      "detail" => "required|min:1|max:100"
    );

    $validator = \Validator::make($r->all(),$rules);

    if($validator->fails()){
      return \Redirect::back()->withInput()->with(["error" => "<li>".implode("</li><li>",$validator->errors()->all())."</li>" ]);
    }

    $nama = $r->input("nama");
    $harga = $r->input("kapasitas");
    $detail = $r->input("detail");

    $meja = Meja::find($mn);
    if($meja->id_restoran != $id){
      return \Redirect::to(url("dashboard"))->with(['error' => "Not Authorized"]);
    }
    $meja->nama_meja = $nama;
    $meja->kapasitas = $harga;
    $meja->keterangan = $detail;

    try{
      $meja->save();

      return \Redirect::to(url("dashboard/meja/".$id))->with(['success' => "Berhasil diedit"]);
    }
    catch(\Exception $e){
      dd($e->getMessage());
    }
  }

  public function getMeja($id){
    $data = Meja::where("id_restoran",$id)->get();
    return $data;
  }

  public function deleteMeja($id,$mn){
    $data = Restoran::find($id);
    $cek = $this->cekHak($data);
    if(!$cek) return $this->error;

    $menu = Meja::find($mn);
    if($menu->id_restoran != $id){
      return \Redirect::to(url("dashboard"))->with(['error' => "Not Authorized"]);
    }

    try{

      $menu->delete();

      return \Redirect::back()->with(["success" => "Meja berhasil dihapus"]);
    }
    catch(\Exception $e){
      dd($e->getMessage());
    }
  }

  public function statusMeja($id,$mn){
    $data = Restoran::find($id);
    $cek = $this->cekHak($data);
    if(!$cek) return $this->error;

    $meja = Meja::find($mn);

    if($id != $meja->id_restoran){
      return null;
    }

    $meja->status = ($meja->status == 1)? 0:1;

    $meja->save();

    return $meja->status;
  }

  public function getNewResto($size){
    $data = Restoran::limit($size)->get();

    return $data;
  }

  public function getNewMenu($size){
    $data = Menu::limit($size)->get();

    return $data;
  }

  public function getDetailRestoran($id){
    $data = Restoran::find($id);


    return $data;
  }

  public function search(Request $r){
    $cari = $r->input("cari");

    $data['resto'] = Restoran::where("nama_restoran","LIKE","%".$cari."%")->get();
    $data['page'] = "restoran";

    return view("front/cari",$data);
  }
  /* INTERFACE */
  public function addRestoranInterface(){
    return view("restaurant/add");
  }

  public function detailInterface($id){
    $data = $this->getRestoranInfo($id);

    if(!$data) return $this->error;

    $data['hari'] = array();
    $list = json_decode($data['info']->hari_buka);

    $data['hari'] = (!is_array($list))? array():$list;
    $data['id'] = $data['info']->id_restoran;
    $data['page'] = "detail";




    return view("restaurant/insideDashboard",$data);
  }

  public function galleryInterface($id){
    $data['img'] = $this->getGalleryList($id);
    $data['id'] = $id;
    $data['id_hash'] = md5($id);
    $data['page'] = "galeri";


    return view("restaurant/gallery",$data);
  }

  public function menuInterface($id){
    $data = Restoran::find($id);
    $cek = $this->cekHak($data);
    if(!$cek) return $this->error;


    $data['page'] = "menu";
    $data['id'] = $id;
    $data['image'] = asset("/restoran/".md5($id)."/menu\/");
    $data['appetizer'] = $this->getAppetizerList($id);
    $data['main'] = $this->getMainMenuList($id);
    $data['drink'] = $this->getDrinkList($id);
    $data['dessert'] = $this->getDessertList($id);
    return view("restaurant/menuInterface",$data);
  }

  public function addMenuInterface($id){
    $info = Restoran::find($id);
    $cek = $this->cekHak($info);
    if(!$cek) return $this->error;

    $data['id'] = $id;
    $data['page'] = "menu";

    return view("restaurant/addMenu",$data);
  }

  public function editMenuInterface($id,$mn){
    $info = Restoran::find($id);
    $cek = $this->cekHak($info);
    if(!$cek) return $this->error;

    $menu = Menu::find($mn);

    if($id != $menu->id_restoran){
      return \Redirect::to(url("dashboard"))->with(['error' => "Not Authorized"]);
    }
    $data['info'] = $menu;
    $data['id'] = $id;
    $data['page'] = "menu";
    $data['image'] = asset("/restoran/".md5($id)."/menu\/");

    return view("restaurant/editMenu",$data);
  }

  public function mejaInterface($id){
    $data = Restoran::find($id);
    $cek = $this->cekHak($data);
    if(!$cek) return $this->error;

    $data['page'] = "meja";
    $data['id'] = $id;

    $data['meja'] = $this->getMeja($id);
    $data['color'] = array("red","orange","yellow","olive","green","teal");

    return view("restaurant/mejaInterface",$data);
  }

  public function addMejaInterface($id){
    $data = Restoran::find($id);
    $cek = $this->cekHak($data);
    if(!$cek) return $this->error;

    $data['page'] = "meja";
    $data['id'] = $id;

    return view("restaurant/addMeja",$data);
  }

  public function editMejaInterface($id,$mj){
    $data = Restoran::find($id);
    $cek = $this->cekHak($data);
    if(!$cek) return $this->error;

    $data['page'] = "meja";
    $data['id'] = $id;
    $info = Meja::find($mj);

    if($info->id_restoran != $id){
      return \Redirect::to(url("dashboard"))->with(['error' => "Not Authorized"]);
    }

    $data['info'] = $info;

    return view("restaurant/editMeja",$data);
  }

  //frontend
  public function frontInterface(){
    $data['page'] = "home";
    $data['new'] = $this->getNewResto(5);
    $data['now'] = time();
    $data['day'] = date('N');

    $data['menu'] = $this->getNewMenu(5);

    return view("front/index",$data);
  }

  public function restoranDetailInterface($id){
    $data['info'] = $this->getDetailRestoran($id);
    $data['page'] = "restoran";
    $data['id'] = $id;
    $data['hari'] = json_decode($data['info']->hari_buka);
    $data['days'] = array("Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu");
    $data['now'] = time();
    $data['day'] = date('N');


    return view("front/detailRestoran",$data);
  }

  public function lihatMenuInterface($id){
    $data['info'] = $this->getDetailRestoran($id);
    $data['page'] = "restoran";
    $data['id'] = $id;
    $data['hari'] = json_decode($data['info']->hari_buka);
    $data['days'] = array("Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu");
    $data['now'] = time();

    $data['menu'] = $this->getAppetizerList($id);
    $data['mna'] = $this->getMainMenuList($id);
    $data['dr'] = $this->getDrinkList($id);
    $data['ds'] = $this->getDessertList($id);

    return view("front/menuRestoran",$data);
  }

  public function lihatGaleriInterface($id){
    $data['info'] = $this->getDetailRestoran($id);
    $data['page'] = "restoran";
    $data['id'] = $id;
    $data['hari'] = json_decode($data['info']->hari_buka);
    $data['days'] = array("Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu");
    $data['now'] = time();

    $data['img'] = $this->getGalleryList($id);

    return view("front/galeriRestoran",$data);
  }

  public function lihatMejaInterface($id){
    $data['info'] = $this->getDetailRestoran($id);
    $data['page'] = "restoran";
    $data['id'] = $id;
    $data['hari'] = json_decode($data['info']->hari_buka);
    $data['days'] = array("Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu");
    $data['now'] = time();

    $data['meja'] = $this->getMeja($id);

    return view("front/mejaRestoran",$data);
  }

  public function listRestoranInterface(){
    $data['resto'] = Restoran::paginate(6);
    $data["page"] = "restoran";

    return view("front/resto",$data);
  }
}
