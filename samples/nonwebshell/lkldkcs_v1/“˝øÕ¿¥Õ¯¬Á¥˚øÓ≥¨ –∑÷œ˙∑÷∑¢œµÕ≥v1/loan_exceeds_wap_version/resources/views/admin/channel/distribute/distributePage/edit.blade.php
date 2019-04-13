@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>定制分发页 -- {{ $distributeTemplate->name }}</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.channel.distribute.updateDistribute',['id'=>$distributePage->template_id,'channel_id'=>5])}}" method="post">
                {{ method_field('put') }}
                @include('admin.channel.distribute.distributePage._custom_form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.channel.distribute.distributePage._custom_js')
@endsection
