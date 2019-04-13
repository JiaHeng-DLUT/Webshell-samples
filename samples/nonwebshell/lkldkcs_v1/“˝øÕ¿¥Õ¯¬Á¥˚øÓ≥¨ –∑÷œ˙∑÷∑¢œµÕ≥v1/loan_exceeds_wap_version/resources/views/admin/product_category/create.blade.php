@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加贷款类目</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" id="myForm" action="{{route('admin.productCategory.store')}}" method="post">
                @include('admin.product_category._from')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.product_category._js')
@endsection