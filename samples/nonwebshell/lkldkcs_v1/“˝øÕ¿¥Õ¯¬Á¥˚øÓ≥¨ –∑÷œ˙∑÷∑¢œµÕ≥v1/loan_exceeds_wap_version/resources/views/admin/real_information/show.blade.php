@extends('admin.layouts.base')
@section('content')
    <style>
        .lay-info-box- span{
            display: inline-block;
        }
        .lay-info-box- .title {
            width: 100px;
            font-size: 15px;
            text-align: right;
        }
        .lay-info-box- .content {
           margin-left: 20px;
        }
        .lay-info-box-  div{
            height: 60px;
        }

    </style>
    <div class="layui-col-md12" id="LAY-app-message-detail">
        <div class="layui-card layuiAdmin-msg-detail">
            <div class="layui-card-header" style="background: #fafafa">
                <h1>
                    采集信息详情
                </h1>
            </div>
            <div style="margin-left: 20px;width: 80%;">
                <div class="layui-card-body layui-text" >
                    <div class="lay-info-box-">
                        <div >
                            <b><span class="title">用户电话:</span><span class="content">{{$info->member->phone}}</span></b>
                        </div>
                        <div>
                            <b><span class="title">姓名:</span><span class="content">{{$info->real_name}}</span></b>
                        </div>
                        <div>
                            <b><span class="title">身份证号码 :</span><span class="content">{{$info->id_number}}</span></b>
                        </div>
                        <div>
                            <b><span class="title">居住地址 :</span><span class="content">
                                    @if($info->provinceName)
                                        {{$info->provinceName->name}} {{$info->cityName->name}}{{$info->districtName->name}}
                                    @endif
                                    {{$info->address}}
                                </span>
                            </b>
                        </div>
                        <div>
                            <b><span class="title">联系人姓名:</span><span class="content">{{$info->contact}}</span></b>
                        </div>
                        <div>
                            <b><span class="title">联系人电话:</span><span class="content">{{$info->contact_phone}}</span></b>
                        </div>
                        <div>
                            <b><span class="title">关系:</span><span class="content">{{$info->contact_relation}}</span></b>
                        </div>
                        <div style="height: 350px">
                            <b><span class="title">身份证正面:</span></b>
                            <img style="width: 400px;height: 300px;"  src="{{iAsset($info->card_face)}}" >
                        </div>
                        <div style="height: 350px">
                            <b><span class="title">身份证背面:</span></b>
                            <img style="width: 400px;height: 300px;"   src="{{iAsset($info->card_back)}}" >
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <hr>
    </div>

@endsection