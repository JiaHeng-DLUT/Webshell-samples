@extends('admin.layouts.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">

            <form action="" method="get" class="layui-form" >
                <div class="layui-btn-group layui-inline">
                    @can('system.permission.create')
                        <a class="layui-btn layui-btn-sm" href="{{ route('admin.permission.create') }}">添 加</a>
                    @endcan
                    @if(request('parent_id'))
                        <a class="layui-btn layui-btn-sm" id="returnParent" pid="0" href="javascript:history.back()">返回上级</a>
                    @endif
                </div>
                <div class="layui-inline" style="float:right;margin-right:5%;">
                    <div class="layui-inline">
                        <input class="layui-input" name="keyword" value="{{request('keyword','')}}" autocomplete="off" placeholder="输入权限进行搜索">
                    </div>
                    <button class="layui-btn layui-btn-normal" type="submit">搜索</button>
                </div>
            </form>
        </div>

        <div class="layui-card-body">
            @if($permissions->count())
                <form name="form-article-list" id="form-article-list" class="layui-form layui-form-pane" >
                    <table class="layui-table">
                        <colgroup>
                            {{--<col width="50">--}}
                            {{--<col width="50">--}}
                            <col>
                            <col>
                            <col>
                            <col>
                            <col>
                            <col>
                            <col>
                            <col width="200">
                        </colgroup>
                        <thead>
                        <tr>
                            {{--<th><input type="checkbox" name=""  lay-skin="primary"  lay-filter="allChoose"> </th>--}}
                            {{--<th>ID</th>--}}
                            <th>权限标识</th>
                            <th>展示名称</th>
                            <th>路由</th>
                            <th>图标</th>
                            <th>排序值</th>
                            <th>创建时间</th>
                            <th>更新时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $permission)
                                <tr>
                                    {{--<td><input type="checkbox" name=""  lay-skin="primary"> </td>--}}
                                    {{--<td>{{$permission->id}}</td>--}}
                                    <td>{{$permission->name}}</td>
                                    <td>{{$permission->display_name}}</td>
                                    <td>{{$permission->route}}</td>
                                    <td>
                                        <i class="layui-icon {{$permission->icon?$permission->icon->class:''}}"></i>
                                    </td>
                                    <td>
                                        <input type="tel" maxlength="3"  class="sort" value="{{$permission->sort}}" data-id="{{$permission->id}}" style="border: none;height: 40px;width: 50px">
                                    </td>
                                    <td>{{$permission->created_at}}</td>
                                    <td>{{$permission->updated_at}}</td>
                                    <td>
                                        <div class="layui-btn-group">
                                            @can('system.permission')
                                                <a class="layui-btn layui-btn-sm" href="{{url('admin/permission')}}?parent_id={{$permission->id}}">子权限</a>
                                            @endcan
                                            {{--@can('system.permission.edit')--}}
                                                <a class="layui-btn layui-btn-sm" href="{{url("admin/permission/$permission->id/edit")}}">编辑</a>
                                            {{--@endcan--}}
                                            {{--@can('system.permission.destroy')--}}
                                                {{--<a href="javascript:;" data-url="{{ route('admin.permission.destroy',$permission->id) }}" class="layui-btn layui-btn-sm layui-btn-danger form-delete">删除</a>--}}
                                            {{--@endcan--}}real_informations
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
                <div id="paginate-render"></div>
            @else
                <br />
                <blockquote class="layui-elem-quote">暂无数据!</blockquote>
            @endif
        </div>
    </div>
@endsection

@section('script')
    @include('admin.layouts._paginate',[ 'count' => $permissions->total() ])
    <script>
        $('body').find('.sort').on('blur',function () {
            var id=$(this).data('id');
            var sort=$(this).val();
            var _token="{{csrf_token()}}";
            $.post('/admin/permission/sort',{'_token':_token,'id':id,'sort':sort},function (res) {
                if(res.code===1){
                    layer.msg(res.msg);
                }
            })
        })
    </script>
@endsection
