<script>
    layui.use(['form'],function () {
        var form = layui.form;
        form.on('select(department)', function (data) {

            var id = data.value;
            $.ajax({
                url: '{{ route('channel.viaDepartmentGetChannel') }}',
                type: 'POST',
                data: {"_token": "{{ csrf_token() }}", id: id},
                dataType: "json",
                success: function (res) {

                    var html = '<option value="">所有渠道</option>';
                    if (!res.code) {
                        $.each(res.data, function (i, val) {
                            html += '<option value="' + val['channel_code'] + '">' + val['channel_name'] + '</option>';
                        });
                    }

                    // console.log(html);
                    $('#channel_code').html(html);
                    form.render();
                }
            });
        });
    });
</script>