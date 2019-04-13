@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加帮助</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.website.help.store')}}" method="post">
                @include('admin.website.help._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.website.help._js')
@endsection