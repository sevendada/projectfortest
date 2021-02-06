@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">ระบบจัดการตู้จำหน่ายสินค้าอัตโนมัติ</div>

                <div class="card-body">
                    <form method="POST" action="/uploadproduct" id="form_product" enctype="multipart/form-data">
                        <x-alert/>
                        <div class="form-group row">
                            <label for="select_product" class="col-md-4 col-form-label text-md-right">เลือกสินค้า</label>
                            <div class="col-md-6">
                                <select name="select_product" id="select_product" class="form-control-sm" onchange="sel_product(this.value)">
                                    <option value="">-------</option>
                        @foreach ($product_data as $item)
                                    <option value="{{$item->id}}">{{$item->product_name}}</option>
                        @endforeach
                                    </select>
                                </div>
                            </div>
                        <div class="form-group row">
                            <label for="product_name" class="col-md-4 col-form-label text-md-right">ชื่อสินค้า</label>
                            <div class="col-md-6">
                            <input type="text" name="product_name" id="product_name"  class="form-control @error('product_name') is-invalid @enderror" required autocomplete="product_name">
                            @error('product_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>กรุณากรอกชื่อสินค้า</strong>
                            </span>
                             @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="product_price" class="col-md-4 col-form-label text-md-right">ราคาสินค้า</label>
                            <div class="col-md-6">
                            <input type="text" name="product_price" id="product_price"  class="form-control @error('product_price') is-invalid @enderror" required autocomplete="product_price">
                            @error('product_price')
                            <span class="invalid-feedback" role="alert">
                                <strong>กรุณากรอกราคาสินค้า</strong>
                            </span>
                             @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="product_amount" class="col-md-4 col-form-label text-md-right">จำนวนสินค้า</label>
                            <div class="col-md-6">
                            <input type="text" name="product_amount" id="product_amount"  class="form-control @error('product_amount') is-invalid @enderror" required autocomplete="product_amount">
                            @error('product_amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>กรุณากรอกจำนวนสินค้า</strong>
                            </span>
                             @enderror
                            </div>
                        </div>
                        <div class="form-group row" id="upload_file">
                            <label for="product_image" class="col-md-4 col-form-label text-md-right">รูปสินค้า</label>
                            <div class="col-md-6">
                            @csrf
                            <input type="file" name="product_image" id="product_image" class="form-control">
                            @error('product_image')
                            <span class="invalid-feedback" role="alert">
                                <strong>กรุณาแนปรูปสินค้า</strong>
                            </span>
                             @enderror
                             <img src="" id="show_pic" alt="PicProduct" width="150px" style="display:none;">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" id="btn_submit" class="btn btn-primary" onclick="before_save();">
                                    เพิ่มสินค้า
                                </button>
                                <a href="#" id="del_product" class="btn btn-danger">
                                    ลบข้อมูล
                                </a>
                            </div>
                        </div>
                        <input type="hidden" name="product_id" id="product_id" value="">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    function before_save(){
        var selecter = document.getElementById('select_product').value;
        if($('#product_image').val()=='' && selecter ==''){
            alert('กรุณาแนบไฟล์รูป')
        }else {
            $('#form_product').submit()
        }
    }

    function sel_product(value)
    {
        var a = document.getElementById('del_product');
        if(value==""){
            $('#product_id').val('');
            $('#product_name').val('');
            $('#product_price').val('');
            $('#product_amount').val('');
            $('#product_image').val('');
            $('#show_pic').css('display','none');
            $("#btn_submit").html('เพิ่มสินค้า');
            $('#product_name').prop('readonly', false);
            $('#form_product').attr('action','/uploadproduct');
            a.href = "#";
        }else {
            @foreach ($product_data as $item)
                    if('{{$item->id}}' == value){
                        if('{{$item->product_image}}'==''){
                            $('#show_pic').css('display','none');
                            $('#form_product').attr('action','/editproduct/'+'{{$item->id}}'+'/'+'NULL');
                        }else {
                            $('#show_pic').css('display','');
                            $('#form_product').attr('action','/editproduct/'+'{{$item->id}}'+'/'+'{{$item->product_image}}');
                        }
                        $("#btn_submit").html('แก้ไขข้อมูลสินค้า');
                        $('#product_id').val('{{$item->id}}');
                        $('#product_name').val('{{$item->product_name}}');
                        $('#product_name').prop('readonly', true);
                        $('#product_price').val('{{$item->product_price}}');
                        $('#product_amount').val('{{$item->product_amount}}');
                        $('#show_pic').attr('src',"{{asset('/storage/images/'.$item->product_image)}}");
                        var a = document.getElementById('del_product');
                        a.href = "/del_product/{{$item->id}}";

                    }
             @endforeach
        }
    }
</script>
@endsection
