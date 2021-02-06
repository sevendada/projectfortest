@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">เพิ่มประเภทเงินทอน</div>

                <div class="card-body">
                    <form method="GET" action="/createtypecash">
                        <x-alert/>
                        <div class="form-group row">
                            <label for="typecash_name" class="col-md-4 col-form-label text-md-right">ชื่อ</label>
                            <div class="col-md-6">
                            <input type="text" name="typecash_name" id="typecash_name"  class="form-control @error('typecash_name') is-invalid @enderror" required autocomplete="product_name">
                            @error('typecash_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>กรุณากรอกชื่อ</strong>
                            </span>
                             @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="typecash" class="col-md-4 col-form-label text-md-right">ประเภทเงินทอน</label>
                                <div class="col-md-6">
                                    <input type="radio" name="typecash" id="coin" value="coin" checked class="@error('typecash') is-invalid @enderror" >
                                    <label for="typecash" class="col-md-4 col-form-label">เหรียญ</label>
                                    <input type="radio" name="typecash" id="cash" value="cash" class="@error('typecash') is-invalid @enderror">
                                    <label for="typecash" class="col-md-4 col-form-label">ธนบัตร</label>
                                    {{-- <select name="typecash" id="typecash" class="form-control-sm">
                                        <option value="coin">เหรียญ</option>
                                        <option value="cash">ธนบัตร</option>
                                    </select> --}}
                            @error('typecash')
                            <span class="invalid-feedback" role="alert">
                                <strong>กรุณาเลือกประเภทเงินทอน</strong>
                            </span>
                             @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    เพิ่มประเภทเงินทอน
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
