@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>编辑渠道</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.channel.update',['id'=>$channel->id])}}" method="post">
                {{ method_field('put') }}
                <input type="hidden" name="user_id" value="{{$channel->user_id}}">
                @include('admin.channel._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.channel._js')
@endsection
