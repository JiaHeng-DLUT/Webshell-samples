@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>编辑贷款产品</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" id="myForm" action="{{route('admin.product.update',['product'=>$product])}}" method="post">
                {{method_field('put')}}
                <input type="hidden" name="id" value="{{ $product->id }}">
                @include('admin.product._from')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.product._js')
@endsection