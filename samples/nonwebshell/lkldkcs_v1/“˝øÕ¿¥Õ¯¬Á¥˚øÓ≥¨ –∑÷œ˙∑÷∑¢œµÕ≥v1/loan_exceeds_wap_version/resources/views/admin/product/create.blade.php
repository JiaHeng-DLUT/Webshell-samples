@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加贷款产品</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" id="myForm" action="{{route('admin.product.store')}}" method="post">
                @include('admin.product._from')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.product._js')
@endsection