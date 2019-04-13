@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>编辑部门</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.channel.department.update',['id'=>$department->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.department._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.department._js')
@endsection
