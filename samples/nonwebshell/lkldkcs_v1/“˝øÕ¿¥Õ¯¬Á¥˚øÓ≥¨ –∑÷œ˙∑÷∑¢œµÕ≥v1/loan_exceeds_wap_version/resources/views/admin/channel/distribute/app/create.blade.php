@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加渠道包</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.channel.distribute.store',['id'=>$id])}}" method="post">
                @include('admin.channel.distribute.app._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.channel.distribute.app._js')
@endsection