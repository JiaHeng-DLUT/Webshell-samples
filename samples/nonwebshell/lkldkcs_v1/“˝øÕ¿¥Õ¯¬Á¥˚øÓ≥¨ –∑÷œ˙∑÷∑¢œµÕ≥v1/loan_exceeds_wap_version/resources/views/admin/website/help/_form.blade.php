{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>问题</label>
    <div class="layui-input-block">
        <input type="text" name="question" maxlength="50" value="{{$help->question??old('question')}}" lay-verify="my_text" placeholder="请输入问题" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>回答</label>
    <div class="layui-input-block">
        <textarea name="answer" maxlength="500" placeholder="请输入回答" lay-verify="my_answer" class="layui-textarea">{{$help->answer??old('answer')}}</textarea>
    </div>
</div>





<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.website.help')}}" >返 回</a>
    </div>
</div>