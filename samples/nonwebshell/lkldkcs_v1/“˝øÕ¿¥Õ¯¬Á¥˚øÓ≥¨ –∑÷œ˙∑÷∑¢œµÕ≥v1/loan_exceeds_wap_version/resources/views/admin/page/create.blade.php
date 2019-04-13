@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加单页</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" id="form-page" action="{{route('admin.page.store')}}" method="post">
                @include('admin.page._from')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.page._js')
@endsection