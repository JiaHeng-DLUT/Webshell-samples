@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>修改热门城市</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" id="form-hotCity" action="{{route('admin.hotCity.update',['id'=>$city->id])}}" method="post">
                {{method_field('put')}}
                <input type="hidden" name="id" value="{{ $city->id }}">
                @include('admin.district.hot_city_from')
            </form>
        </div>
    </div>
@endsection
