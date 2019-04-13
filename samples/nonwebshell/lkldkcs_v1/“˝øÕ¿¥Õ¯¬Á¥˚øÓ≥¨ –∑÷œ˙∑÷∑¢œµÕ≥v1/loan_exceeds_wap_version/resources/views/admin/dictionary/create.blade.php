@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加字典</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.dictionary.store')}}" method="post">
                @include('admin.dictionary._from')
            </form>
        </div>
    </div>
@endsection
