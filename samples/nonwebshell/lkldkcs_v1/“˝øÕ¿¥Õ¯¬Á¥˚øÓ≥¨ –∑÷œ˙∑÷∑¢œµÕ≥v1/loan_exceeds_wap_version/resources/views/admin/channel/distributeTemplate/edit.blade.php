@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>编辑模板</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.channel.distributeTemplate.update',['id'=>$distribute_template->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.channel.distributeTemplate._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.channel.distributeTemplate._js')
@endsection
