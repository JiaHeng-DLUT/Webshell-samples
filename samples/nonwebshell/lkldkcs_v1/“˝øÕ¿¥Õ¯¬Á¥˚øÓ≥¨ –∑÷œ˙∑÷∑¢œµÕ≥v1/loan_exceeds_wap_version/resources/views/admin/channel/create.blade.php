@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加渠道</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.channel.store')}}" method="post">
            {{--<form class="layui-form" action="{{route('admin.channel.storeCustom')}}" method="post">--}}
                @include('admin.channel._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.channel._js')
@endsection