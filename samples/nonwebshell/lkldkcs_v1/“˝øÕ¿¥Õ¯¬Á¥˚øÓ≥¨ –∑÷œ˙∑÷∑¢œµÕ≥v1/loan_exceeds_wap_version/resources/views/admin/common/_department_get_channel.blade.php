<div class="layui-input-inline">
    <select name="department"  id="department" lay-filter="department">
        <option value="">所有部门</option>
        @foreach(\App\Models\Department::all() as $item)
            @isset($item->id)
                <option {{ request('department') == $item->id ? 'selected' :'' }}   value="{{ $item->id }}">{{ $item->name }}</option>
            @endisset
        @endforeach
    </select>
</div>
<div class="layui-input-inline">
    <select name="channel_code"  id="channel_code" lay-filter="channel_code">
        <option value="">所有渠道</option>
        {{-- @foreach(\App\Models\Channel::all() as $item)
             @isset($item->id)
                 <option {{ request('channel_code') == $item->channel_code ? 'selected' :'' }} value="{{ $item->channel_code }}">{{ $item->channel_name }}</option>
             @endisset
         @endforeach--}}
    </select>
</div>
