@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>编辑发现</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.website.article.update',['id'=>$article->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.website.article._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.website.article._js')
@endsection
