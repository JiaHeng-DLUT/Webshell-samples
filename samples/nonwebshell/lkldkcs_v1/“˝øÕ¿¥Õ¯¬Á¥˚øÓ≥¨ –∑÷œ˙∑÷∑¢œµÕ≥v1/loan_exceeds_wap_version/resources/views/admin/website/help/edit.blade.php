@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>编辑帮助</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.website.help.update',['id'=>$help->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.website.help._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.website.help._js')
@endsection
