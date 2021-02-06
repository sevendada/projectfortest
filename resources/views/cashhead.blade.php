@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">ระบบจัดการเงินทอน</div>

                <div class="card-body">
                        <div class="form-group row align-content-end">
                            <div class="col-md-6 offset-md-4">
                                <a class="btn btn-primary" href="{{ route('typecash') }}">
                                    เพิ่มประเภทเงินทอน
                                </a>
                            </div>
                        </div>
                    <form method="POST" id="form_cash_head" action="/updateCashHead">
                        <x-alert/>
                        @csrf
                        <div class="form-group row">
                            <label for="select_cash" class="col-md-4 col-form-label text-md-right">เลือกประเภทเงินทอน</label>
                            <div class="col-md-6">
                                <select name="select_cash" id="select_cash" class="form-control-sm" onchange="sel_cash(this.value)">
                                    <option value="">-------</option>
                        @foreach ($cash_head as $item)
                                    <option value="{{$item->id}}">{{$item->cash_name}}</option>
                        @endforeach
                                    </select>
                                </div>
                            </div>
                        <div class="form-group row">
                            <label for="cash_name" class="col-md-4 col-form-label text-md-right">ชื่อ</label>
                            <div class="col-md-6">
                            <input type="text" name="cash_name" id="cash_name"  class="form-control @error('cash_name') is-invalid @enderror" required autocomplete="cash_name">
                            @error('cash_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>กรุณากรอกชื่อ</strong>
                            </span>
                             @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="typecash" class="col-md-4 col-form-label text-md-right">ประเภท</label>
                            <div class="col-md-6">
                                <input type="radio" name="typecash" id="coin" value="coin" >
                                <label for="typecash" class="col-md-4 col-form-label" >เหรียญ</label>
                                <input type="radio" name="typecash" id="cash" value="cash">
                                {{-- <input type="radio" name="typecash" id="cash" value="cash"  {{ $item->cash_type =='cash' ? "checked" : ""}}> --}}
                                <label for="typecash" class="col-md-4 col-form-label">ธนบัตร</label>
                            @error('typecash')
                            <span class="invalid-feedback" role="alert">
                                <strong>กรุณากรอกประเภท</strong>
                            </span>
                             @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cash_amount" class="col-md-4 col-form-label text-md-right">จำนวนคงเหลือ</label>
                            <div class="col-md-6">
                            <input type="text" name="cash_amount" id="cash_amount"  class="form-control @error('cash_amount') is-invalid @enderror" required autocomplete="cash_amount">
                            @error('cash_amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>กรุณากรอกจำนวนคงเหลือ</strong>
                            </span>
                             @enderror
                            </div>
                        </div>
                        <hr>

                        <div class="form-group row">
                            <div class="col-md-6  offset-md-4">
                                <button type="submit" id="btn_submit" class="btn btn-primary">
                                    เพิ่มเงินทอน
                                </button>
                                <a href="#" id="delcash_head" class="btn btn-danger">
                                    ลบข้อมูล
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById("btn_submit").disabled = true;
    function sel_cash(value)
    {
        //alert(value);
        if(value==""){
            document.getElementById("btn_submit").disabled = true;
            $('#cash_name').val('');
            $('#cash_amount').val('');
            $('#coin').prop("checked", false);
            $('#cash').prop("checked", false);
        }else {
            @foreach ($cash_head as $item)
                    if('{{$item->id}}' == value){
                        $('#form_cash_head').attr('action','/updateCashHead/'+'{{$item->id}}');
                        $('#cash_name').val('{{$item->cash_name}}');
                        $('#cash_amount').val('{{$item->cash_amount}}');
                        var a = document.getElementById('delcash_head');
                        a.href = "/delcash_head/{{$item->id}}";
                        if('{{$item->cash_type}}'=='coin'){
                            $('#coin').prop("checked", true);
                            $('#cash').prop("checked", false);
                        }else {
                            $('#coin').prop("checked", false);
                            $('#cash').prop("checked", true);
                        }
                    }
        @endforeach
        document.getElementById("btn_submit").disabled = false;
        }
    }
</script>
@endsection
