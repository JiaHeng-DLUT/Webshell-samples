@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加模板</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.channel.distributeTemplate.store')}}" method="post">
                @include('admin.channel.distributeTemplate._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.channel.distributeTemplate._js')
@endsection