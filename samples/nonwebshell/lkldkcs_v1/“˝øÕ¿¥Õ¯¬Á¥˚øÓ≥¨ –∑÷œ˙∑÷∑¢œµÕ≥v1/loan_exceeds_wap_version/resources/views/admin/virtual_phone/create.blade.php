@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>导入号码</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" id="form-virtualPhone" action="{{route('admin.virtualPhone.store')}}" method="post">
                @include('admin.virtual_phone._from')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.virtual_phone._js')
@endsection