@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>编辑贷款栏目</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" id="myForm" action="{{route('admin.productColumn.update',['productColumn'=>$productColumn])}}" method="post">
                {{method_field('put')}}
                <input type="hidden" name="id" value="{{ $productColumn->id }}">
                @include('admin.product_column._from')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.product_column._js')
@endsection