<div class="layui-inline">
    <label class="layui-form-label">部门</label>
    <div class="layui-input-block">
        <select name="department_id" id="department_id"  lay-filter="department_id">
            <option value="">不限</option>
            <?php $departments=\App\Models\Department::all();?>
            @if($departments->count())
                @foreach($departments as $department)
                    <option value="{{$department->id}}">{{$department->name}}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>

<div class="layui-inline">
    <label class="layui-form-label">渠道</label>
    <div class="layui-input-block">
        <select name="channel_code" id="channel_code" lay-search>
            <option value="">不限</option>
        </select>
    </div>
</div>
