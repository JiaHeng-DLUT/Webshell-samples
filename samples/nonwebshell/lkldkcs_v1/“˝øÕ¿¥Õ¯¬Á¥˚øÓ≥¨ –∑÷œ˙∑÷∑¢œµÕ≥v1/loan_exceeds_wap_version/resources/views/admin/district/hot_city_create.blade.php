@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加热门城市</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" id="form-hotCity" action="{{route('admin.hotCity.store')}}" method="post">
                @include('admin.district.hot_city_from')
            </form>
        </div>
    </div>
@endsection
