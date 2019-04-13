@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>编辑渠道包</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.channel.distribute.update',['id'=>$id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.channel.distribute.app._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.channel.distribute.app._js')
@endsection
