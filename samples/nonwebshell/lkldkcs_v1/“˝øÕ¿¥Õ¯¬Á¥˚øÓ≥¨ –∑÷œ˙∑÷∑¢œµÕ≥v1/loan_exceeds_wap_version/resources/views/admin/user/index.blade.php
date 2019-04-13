@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">

        <div class="layui-card-header layuiadmin-card-header-auto">

            <form action="" method="get" class="layui-form" >
                <div class="layui-btn-group layui-inline">
                    @can('system.user.create')
                        <a class="layui-btn layui-btn-sm" href="{{ route('admin.user.create') }}">添 加</a>
                    @endcan
                </div>
                <div class="layui-inline" style="float:right;margin-right:5%;">
                    <div class="layui-inline">
                        <select name="role_id">
                            <option value="">全部角色</option>
                            @if($roles->count())
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}" {{request('role_id','')==$role->id?'selected':''}}>{{$role->display_name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <button class="layui-btn layui-btn-normal" type="submit">搜索</button>
                </div>
            </form>

        </div>

        <div class="layui-card-body">
                <table class="layui-table" id="dataTable">
                    {{--<colgroup>--}}
                        {{--<col width="50">--}}
                        {{--<col width="60">--}}
                        {{--<col>--}}
                        {{--<col width="100">--}}
                        {{--<col width="130">--}}
                        {{--<col width="100">--}}
                        {{--<col width="130">--}}
                        {{--<col width="100">--}}
                        {{--<col width="60">--}}
                        {{--<col width="300">--}}
                    {{--</colgroup>--}}
                    <thead>
                    <tr>
                        {{--<th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose"></th>--}}
                        {{--<th>ID</th>--}}
                        <th>显示名称</th>
                        <th>登录用户名</th>
                        <th>角色类型</th>
                        @can('system.user.status')
                            <th>状态</th>
                        @endcan
                        <th>创建时间</th>
                        <th>更新时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($users->count())
                    @foreach($users as $index => $user)
                        <tr>
                            {{--<td><input type="checkbox" name="" value="{{$user->id}}" lay-skin="primary" lay-filter="itemChoose"></td>--}}
                            {{--<td>{{ $user->id }}</td>--}}
                            <td>{{ $user->name  }}</td>
                            <td>{{ $user->username  }}</td>
                            <td>{{ implode('、',$user->roles->pluck('display_name')->all())}}</td>
                            @can('system.user.status')
                                <td class="layui-form">
                                    <input type="checkbox" name="status" lay-filter="status" @if($user->isRoot()) disabled @endif data-id="{{$user->id}}" lay-skin="switch" lay-text="启用|禁用"  value="{{$user->status}}"  {{ $user->status == '1' ? 'checked' : '' }}>
                                </td>
                            @endcan
                            <td>{{ $user->created_at}}</td>
                            <td>{{ $user->updated_at}}</td>
                            <td>
                                @can('system.user.create')
                                    <a class="layui-btn layui-btn-sm" href="{{route('admin.user.edit',$user->id)}}">编辑</a>
                                @endcan
                                {{--@can('system.user.role')--}}
                                    {{--<a class="layui-btn layui-btn-sm" href="{{route('admin.user.role',$user->id)}}">角色</a>--}}
                                {{--@endcan--}}
                                @can('system.user.permission')
                                    <a class="layui-btn layui-btn-sm" href="{{route('admin.user.permission',$user->id)}}">权限</a>
                                @endcan
                                @can('system.user.destroy')
                                    @if(in_array('root',$user->roles->pluck('name')->all()))
                                        <a class="layui-btn layui-btn-danger layui-btn-sm  layui-btn-disabled" href="javascript:;" disabled="">删除</a>
                                    @else
                                        <a class="layui-btn layui-btn-danger layui-btn-sm form-delete" href="javascript:;" data-url="{{ route('admin.user.destroy', $user->id) }}">删除</a>
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="8" style="text-align: center">暂无数据!</td>
                        </tr>
                        {{--<br />--}}
                        {{--<blockquote class="layui-elem-quote"></blockquote>--}}
                    @endif
                    </tbody>

                </table>
                <form id="delete-form" action="" method="POST" style="display:none;">
                    <input type="hidden" name="_method" value="DELETE">
                    {{ csrf_field() }}
                </form>
                <div id="paginate-render"></div>


        </div>

    </div>
@endsection

@section('script')
    @include('admin.layouts._paginate',[ 'count' => $users->total(), ])
    <script>
        layui.use(['layer','table','form'],function () {
            var layer = layui.layer;
            var form = layui.form;

            form.on('switch(status)', function(data){
                var user_id=$(data.elem).data('id');
                var status=data.value;
                $.post("{{route('admin.user.status')}}",{user_id:user_id,status:status},function (res) {
                    console.log(res);
                    if(res.code===0){
                        $(data.elem).attr('value',res.status);
                        layer.msg(res.msg,{icon:1});
                    }else {
                        layer.msg(res.msg,{icon:2});
                    }
                })
            });

        })
    </script>
@endsection



