<?php

namespace App\Http\Controllers;

use App\BuyModel;
use App\CashHeadModel;
use App\Product;
use Illuminate\Http\Request;

class BuyController extends Controller
{
    private $msg_status = "";
    private $msg="ระบบทอนเงิน";
    public function index()
    {

        $product_list = Product::all();
        $cash_head_list = CashHeadModel::all();

        return view('home',['product_list'=>$product_list,'cash_head_list'=>$cash_head_list]);
    }

    public function Addtotal($num,$total_left){
        $total = $num + $total_left;
        $buy = new BuyModel();
        $buy->cash_topup = $num;
        $buy->cash_total = $total;
        $buy->save();
        session()->put('total',$total);
        return redirect()->back()->with('success', 'เติมเงินสำเร็จ');
    }

    public function Buyproduct($price,$id_product,$total,$product_amount){
        $buy = new BuyModel();
        $buy->cash_buy = $price;
        $buy->cash_topup = 0;
        $total_after_buy = $total - $price;
        $buy->cash_total = $total_after_buy;
        $buy->product_id = $id_product;
        $buy->save();
        $buy_id = $buy->id;
        $product_amount_to_save = ($product_amount-1);
        $data_product=[
            'product_amount'=>$product_amount_to_save,
        ];
        Product::where('id',$id_product)->update($data_product);
        session()->put('total',$total_after_buy);
        $this->CashChange($total_after_buy,$buy_id,$price,$id_product,$product_amount_to_save);
        $msg_status = $this->msg_status;
        $msg = $this->msg;
        return redirect()->back()->with($msg_status,$msg);
    }

    protected function CashChange($money,$buy_id,$price,$id_product,$product_amount){
        $getCash = CashHeadModel::select('cash_name')->where([
            ['cash_name', '<=', $money],
            ['cash_amount','<>','0'],
            ])
        ->orderBy('cash_name', 'desc')
        ->pluck('cash_name');
        $cash_arr = $getCash->toarray();
        rsort($cash_arr);
        $data_chage=array();
        $money_start = $money;
        foreach($cash_arr as $items){
            if($money>=$items){
                $sum1=$money/$items;
                $sum2=floor($sum1)*$items;
                $money=$money-$sum2;
                $data_chage [$items] = floor($sum1);
            }
        }
        if (!empty($data_chage)) {
            $isOK = $this->CheckCashDB($data_chage,$buy_id);
            if($isOK){
                $msg_type_cash = "";
                $count_arr = 0;
                foreach($data_chage as $key=>$value){
                    $cash_type = CashHeadModel::select('cash_type')->where('cash_name','=',$key)->pluck('cash_type');
                    $cash_type_arr = $cash_type->toarray();
                    try {

                        if($cash_type_arr[0]=='coin'){
                            $msg_type_cash = "เหรียญ";
                        }else{
                            $msg_type_cash = "ธนบัตร";
                        }

                      } catch (\Exception $e) {

                          return $e->getMessage();
                      }

                    $this->msg .= $msg_type_cash." ".strval($key)." บาท จำนวน ".strval($value)." ".$msg_type_cash." ";
                    $count_arr++;
                    $cash_id = CashHeadModel::select('id')->where('cash_name','=',$key)->pluck('id');
                    $cash_name = $key;
                    $cash_amount= $value;
                    $this->updateCashHead($cash_id,$cash_name,$cash_amount);
                }
                session()->put('total',0);
                $this->msg_status = "success";
            }else {
                $data=[
                    'cash_buy' => 0,
                    'cash_total'=> 0,
                    'cash_cancel' => ($money_start+$price),
                ];
                BuyModel::where('id',$buy_id)->update($data);
                $data_product=[
                    'product_amount'=>($product_amount+1),
                ];
                Product::where('id',$id_product)->update($data_product);
                session()->put('total',0);
                $this->msg_status = "error";
                $this->msg = "ยกเลิกการซื้อสินค้าเนื่องจากเงินทอนในระบบไม่เพียงพอและทำการคืนเงินทั้งหมด";
            }
       }else {
        $this->msg_status = "success";
        $this->msg = "ซื้อสินค้าเรียบร้อย";
       }

    }

    protected function CheckCashDB($data_chage,$buy_id){
        $isOK = false;
        foreach($data_chage as $name=>$amount){
            $checkCashDB = CashHeadModel::select('cash_amount')->where([
                ['cash_name','=',$name],
                ['cash_amount','>=',$amount],
                ])->get();
              if(count($checkCashDB)>0){
                    $isOK = true;
              }else if(count($checkCashDB)<=0){
                    $isOK = false;
                    break;
              }
          }
          return $isOK;
    }

    protected function updateCashHead($id,$cash_name,$cash_amount)
    {
        $cash_haed_list = CashHeadModel::select('cash_amount')->where('cash_name','=',$cash_name)->pluck('cash_amount');
        $cash_head_arr = $cash_haed_list->toarray();
        for($i=0;count($cash_head_arr);$i++){
            try{
                $total_amount = $cash_head_arr[$i] - $cash_amount;
            }catch (\Exception $e) {

                return $e->getMessage();
            }

            $data=[
                'cash_amount' => $total_amount,
            ];
            CashHeadModel::where('id',$id)->update($data);
        }

    }
}
