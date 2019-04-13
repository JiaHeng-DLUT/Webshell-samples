@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>编辑单页</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" id="form-page" action="{{route('admin.page.update',['page'=>$page])}}" method="post">
                {{method_field('put')}}
                <input type="hidden" name="id" value="{{ $page->id }}">
                @include('admin.page._from')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.page._js')
@endsection