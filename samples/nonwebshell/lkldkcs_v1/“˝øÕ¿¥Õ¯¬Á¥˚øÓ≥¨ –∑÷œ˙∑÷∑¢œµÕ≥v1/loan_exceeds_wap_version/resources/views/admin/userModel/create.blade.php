@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加用户模型</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.userModel.store')}}" method="post">
                @include('admin.userModel._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.userModel._js')
@endsection