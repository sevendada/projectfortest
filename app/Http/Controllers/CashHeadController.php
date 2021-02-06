<?php

namespace App\Http\Controllers;

use App\CashHeadModel;
use Illuminate\Http\Request;

class CashHeadController extends Controller
{
    public function index(){

        $cash_head = CashHeadModel::all();

        return view('cashhead')->with('cash_head',$cash_head);
    }

    public function typecash(){
        return view('typecash');
    }

    public function create(Request $request){

        $request->validate([
            'typecash_name'=>'required',
            'typecash'=>'required',
        ]);

        $cash_head = new CashHeadModel();
        $cash_head->cash_name = $request->typecash_name;
        $cash_head->cash_type = $request->typecash;
        $cash_head->save();
        return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย');

    }

    public function update(Request $request,$id){
        $request->validate([
            'cash_name'=>'required',
            'cash_amount'=>'required',
            'typecash'=>'required',
        ]);
        $data = [
            'cash_name'=>$request->cash_name,
            'cash_amount'=>$request->cash_amount,
            'cash_type'=>$request->typecash,
        ];
        CashHeadModel::where('id',$id)->update($data);
        return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }

    public function delete($id){
        CashHeadModel::where('id',$id)->delete();
        return redirect()->back()->with('success', 'ลบข้อมูลเรียบร้อย');
    }
}
