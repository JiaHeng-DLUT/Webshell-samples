<div class="layui-inline">
    <label class="layui-form-label">时间区间</label>
    <div class="layui-input-block">
        <div class="layui-input-inline">
            <input type="text" name="start" placeholder="开始时间" autocomplete="off" class="layui-input" id="start" value="{{\Carbon\Carbon::parse('-1 month')->toDateString()}}">
        </div>
        <div class="layui-input-inline">至</div>
        <div class="layui-input-inline">
            <input type="text" name="end" placeholder="结束时间" autocomplete="off" class="layui-input" id="end" value="{{\Carbon\Carbon::now()->toDateString()}}">
        </div>
    </div>
</div>