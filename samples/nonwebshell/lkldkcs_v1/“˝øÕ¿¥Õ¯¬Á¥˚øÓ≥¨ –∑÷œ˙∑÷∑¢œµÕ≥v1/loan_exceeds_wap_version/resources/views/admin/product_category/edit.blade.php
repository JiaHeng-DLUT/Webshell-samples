@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>编辑贷款类目</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" id="myForm" action="{{route('admin.productCategory.update',['productCategory'=>$productCategory])}}" method="post">
                {{method_field('put')}}
                <input type="hidden" name="id" value="{{ $productCategory->id }}">
                @include('admin.product_category._from')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.product_category._js')
@endsection