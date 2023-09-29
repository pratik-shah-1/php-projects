<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Products extends Controller{

	//All Products...
	public function products(Request $req){
		$slider = DB::table('slider')->get();
		$books = DB::table('products')->get();
		return view('users.index',['books'=>$books, 'slider'=>$slider]);
	}

	//Shoper Products...
	public function shoper_products(Request $req){
		$s_id = $req->session()->get('SLogged');
		$category = DB::table('product_category')->get();
        $books = DB::table('products')
		->join('shopers_products', 'products.id', '=', 'shopers_products.product_id')
		->where('shopers_products.id',$s_id)
		->get();
        return view('shopers.products',['books'=>$books,'category'=>$category]);    
	}

	//Shoper Product_Details
	public function sview($id){
    	$data = DB::table('products')->where('id', $id)->get();
    	return view('shopers.product',['book'=>$data[0]]);
	}

	//User Product_Details View
    public function view($id){
    	$data = DB::table('products')->where('id', $id)->get();
    	return view('users.product',['book'=>$data[0]]);
    }

	public function add_form(){
		$category = DB::table('product_category')->get();
		$field = DB::table('field')->get();
		$branch = DB::table('branch')->where('field', $field[0]->field)->get();
		$sem = DB::table('sem')->get();
		$arr = ['category'=>$category, 'field'=>$field, 'branch'=>$branch, 'sem'=>$sem];
		return view('shopers.add_product',$arr);
	}

	public function update_form($id){
		$product = DB::table('products')
		->leftjoin('sub_category','products.id','=','sub_category.id')
		->select('products.*','sub_category.*','products.id as p_id')
		->where('products.id',$id)
		->get();
		// echo "<pre>";
		// echo json_encode($product,JSON_PRETTY_PRINT);
		// print_r($product);
		$category = DB::table('product_category')->get();
		$field = DB::table('field')->get();
		$branch = DB::table('branch')->where('field', $field[0]->field)->get();
		$sem = DB::table('sem')->get();
		$arr = ['category'=>$category, 'field'=>$field, 'branch'=>$branch, 'sem'=>$sem ,'book'=>$product[0]];
		return view('shopers.update_product',$arr);
	}

	public function add(Request $req){
		$s_id = $req->session()->get('SLogged');
		//Get All Details of Products...
		$arr = $this->prepare_product($req);
		//Set Image Location if Available...
		$arr['img'] = "";
		if($req->img!="")
			$arr['img'] = $this->img_loc($req, $s_id);
		$p_id = DB::table('products')->insertGetId($arr);
		//If Education Category Available then Put Sub Category...
		if($req->category=='Education'){
			$arr = ['id'=>$p_id, 'field'=>$req->field, 'branch'=>$req->branch, 'sem'=>$req->sem];
			DB::table('sub_category')->insert($arr);
		}
		// Pass Data in also shopers_products table...
		$arr = ['id'=>$s_id, 'product_id'=>$p_id];
		DB::table('shopers_products')->insert($arr);
		$req->session()->flash('add',true);	
		return redirect('shoper/products');
	}

	public function update(Request $req, $p_id){
		$s_id = $req->session()->get('SLogged');
		//Prepare Products details...
		$arr = $this->prepare_product($req);
		//Set Image if Available...
		if($req->img!="")
			$arr['img'] = $this->img_loc($req, $s_id);
		DB::table('products')->where('id', $p_id)->update($arr);
		//If Sub Category Available...
		if($req->category=='Education'){
			$arr = ['field'=>$req->field, 'branch'=>$req->branch, 'sem'=>$req->sem];
			DB::table('sub_category')->where('id', $p_id)->update($arr);
		}
		$req->session()->flash('update',true);
		return redirect('/shoper/products');
	}

	public function delete(Request $req, $p_id){
		$s_id = $req->session()->get('SLogged');
		DB::table('shopers_products')->where('product_id',$p_id)->delete();
		DB::table('products')->where('id',$p_id)->delete();
		$req->session()->flash('delete',true);
		return redirect('/shoper/products');
	}

	public function img_loc($req, $s_id){
		$imgObj = $req->img;
		$file_name = "img_".rand(10,99)."_".time()."_".rand(1000,9999);
		$imgObj->move(public_path("upload/products/".$s_id."/".$req->category."/"), $file_name);
		$img_loc = "upload/products/".$s_id."/".$req->category."/".$file_name;
		return $img_loc;
	}

	public function prepare_product($req){
		return $arr = [
			'category'=>$req->category,
			'name'=>$req->name,
			'isbn'=>$req->isbn,
			'author'=>$req->author,
			'pages'=>$req->pages,
			'details'=>$req->details,
			'lang'=>$req->lang,
			'quantity'=>$req->quantity,
			'price'=>$req->price
		];
	}

}