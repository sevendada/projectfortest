<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Home</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            @if (Route::has('login'))
                <div class="row" style="position: absolute;top: 8px;right: 16px;font-size: 18px;">
                    @auth
                        <a href="{{ route('manage')}}">จัดการสินค้า</a>
                    @else
                        <a href="{{ route('login') }}">Login</a> /

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
        <div class="row" >
            เติมเงิน <br>
            <button name="btn_1" id="btn_1" onclick="Addtotal_left('1')">1 บาท</button> &nbsp;
            <button name="btn_2" id="btn_2" onclick="Addtotal_left('2')">2 บาท</button>&nbsp;
            <button name="btn_5" id="btn_5" onclick="Addtotal_left('5')">5 บาท</button>&nbsp;
            <button name="btn_10" id="btn_10" onclick="Addtotal_left('10')">10 บาท</button>&nbsp;
            <button name="btn_20" id="btn_20" onclick="Addtotal_left('20')">20 บาท</button>&nbsp;
            <button name="btn_50" id="btn_50" onclick="Addtotal_left('50')">50 บาท</button>&nbsp;
            <button name="btn_100" id="btn_100" onclick="Addtotal_left('100')">100 บาท</button>&nbsp;
            <button name="btn_500" id="btn_500" onclick="Addtotal_left('500')">500 บาท</button>&nbsp;
            <button name="btn_1000" id="btn_1000" onclick="Addtotal_left('1000')">1000 บาท</button>&nbsp;
            <br>
            <x-alert/>
            <hr>
        </div>
        <div class="row">
            ยอดเงินคงเหลือ&nbsp;
            <span id="total_left">
                @if (session()->has('total'))
                {{session()->get('total')}}
                @endif
            </span> &nbsp;บาท<br>

        </div>
        <div class="row">
            <table border="2" width="800px" style="" class="table table-bordered">
            <tr>
                @php $count="0" @endphp
            @foreach ($product_list as $item)
                    @if ($count%4==0)
                    </tr>
                    <tr>
                    @endif
                    <td>
                        ชื่อสินค้า : {{$item->product_name}} <br>
                        <img src="{{asset('/storage/images/'.$item->product_image)}}" id="show_pic" alt="PicProduct" width="150px" ><br>
                        ราคา : {{$item->product_price}} บาท<br>
                        จำนวนคงเหลือ : {{$item->product_amount}}<br>
                        <button name="buy_product" id="buy_product" onclick="try_buy({{$count}})">ซื้อ</button>
                        <input type="hidden" name="hd_product_price" id="hd_product_price_{{$count}}" value="{{$item->product_price}}">
                        <input type="hidden" name="hd_product_amount" id="hd_product_amount_{{$count}}" value="{{$item->product_amount}}">
                        <input type="hidden" name="hd_product_id" id="hd_product_id_{{$count}}" value="{{$item->id}}">
                    </td>
                    @php $count++ @endphp
             @endforeach
            </tr>
            </table>
        </div>
        </div>
    </div>
</body>
<script>
    var total_num = 0;
    function try_buy(count_value){
        var total_left = document.getElementById("total_left").innerText;
        var product_price = document.getElementById("hd_product_price_"+count_value).value;
        var product_amount = document.getElementById("hd_product_amount_"+count_value).value;
        var product_id = document.getElementById("hd_product_id_"+count_value).value;
        if(parseInt(product_amount)<=0){
            alert('สินค้าหมด!!');
        }else if(parseInt(total_left)<parseInt(product_price)){
            alert('ยอดเงินคงเหลือไม่เพียงพอซื้อสินค้า!!');
        }else{
            var txt;
            var r = confirm("ยืนยันการเลือกซื้อสินค้า");
            if (r == true) {
            txt = "ยืนยันการเลือกสินค้าแล้ว!!";
            alert(txt);
            window.location.href="/buyProduct/"+product_price+"/"+product_id+"/"+total_left+"/"+product_amount;
            } else {
            txt = "ยกเลิกการเลือกซื้อสินค้า!";
            alert(txt);
            }
        }

    }
    function Addtotal_left(num){
        var total_left = document.getElementById("total_left").innerText;
        window.location.href="/addTotal/"+num+"/"+total_left;
    }

    function reset_total_left(){
        document.getElementById("total_left").innerHTML="0 บาท";
    }
</script>
</html>
