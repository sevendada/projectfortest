<?php

namespace App\Http\Controllers;

use App\product as AppProduct;
use App\Product;
use App\User;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{

  public function uploadDataProduct(Request $request){

        $duplicate_product = Product::select('id')->where('product_name','=', $request->product_name)->get();
        if(count($duplicate_product)>0){
            return redirect()->back()->with('error', 'ชื่อสินค้าซ้ำกับในระบบฐานข้อมูล ');
        }

        $request->validate([
            'product_name'=>'required',
            'product_price'=>'required',
            'product_amount'=>'required',
            'product_image'=>'required',
        ]);

        if($request->hasFile('product_image')){
            $product = new Product();
            $product->product_name = $request->product_name;
            $product->product_price = $request->product_price;
            $product->product_amount = $request->product_amount;
            $filename = $request->product_image->getClientOriginalName();
            $product->product_image = $filename;
            $request->product_image->storeAs('images',$filename,'public');
            $product->save();
            return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย');
        }

  }

  public function editProduct(Request $request,$id,$product_image){
    $request->validate([
        'product_name'=>'required',
        'product_price'=>'required',
        'product_amount'=>'required',
    ]);

    if($request->hasFile('product_image')){
        $filename = $request->product_image->getClientOriginalName();
            $this->delOldimages($product_image);
            $request->product_image->storeAs('images',$filename,'public');
        $data=[
            'product_price'=>$request->product_price,
            'product_amount'=>$request->product_amount,
            'product_image'=>$filename,
        ];
        Product::where('id',$id)->update($data);
        return redirect()->back()->with('success', 'แก้ไขข้อมูลเรียบร้อย');
    }else{
        $data=[
            'product_price'=>$request->product_price,
            'product_amount'=>$request->product_amount,
        ];
        Product::where('id',$id)->update($data);
        return redirect()->back()->with('success', 'แก้ไขข้อมูลเรียบร้อย');
    }

  }

  protected function delOldimages($imagefile){
      Storage::delete('public/images/'.$imagefile);
  }

  public function delete($id){
    Product::where('id',$id)->delete();
    return redirect()->back()->with('success', 'ลบข้อมูลเรียบร้อย');
  }

}
