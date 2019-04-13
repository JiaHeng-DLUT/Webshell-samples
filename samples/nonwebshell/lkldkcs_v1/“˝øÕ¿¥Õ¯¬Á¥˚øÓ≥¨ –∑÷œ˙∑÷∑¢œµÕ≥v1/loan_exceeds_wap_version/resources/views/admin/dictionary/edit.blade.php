@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新字典</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.dictionary.update',['dictionary'=>$dictionary])}}" method="post">
                {{method_field('put')}}
                <input type="hidden" name="id" value="{{ $dictionary->id }}">
                @include('admin.dictionary._from')
            </form>
        </div>
    </div>
@endsection