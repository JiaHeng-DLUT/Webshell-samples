@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>编辑用户模型</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.userModel.update',['id'=>$user_model->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.userModel._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.userModel._js')
@endsection
