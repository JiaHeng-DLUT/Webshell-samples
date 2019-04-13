@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header">短信模板</div>
        <div class="layui-card-body">
            <div class="layui-collapse" lay-filter="component-panel">
                @if(!empty($template['data']))
                    @foreach($template['data'] as $item)
                    <div class="layui-colla-item">
                        <h2 class="layui-colla-title"><?php
                            switch($item['category']['name']){
                                case  'notice':
                                    echo '通知模板';
                                    break;
                                case  'register':
                                    echo '注册模板';
                                    break;
                                case  'login':
                                    echo '登录模板';
                                    break;
                                case  'forgot':
                                    echo '找回密码';
                                    break;
                                default :
                                    echo '';
                                    break;
                            }
                            ?><i class="layui-icon layui-colla-icon"></i></h2>
                        <div class="layui-colla-content">
                            <p>{{ $item['content'] }}</p>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>

    </div>
@endsection