$(document).ready(function()
{
    if(v.showLog == 1)
    {
        setInterval('showLog()', 3000);
        showLog();
    }

    $('#menu li').removeClass('active').find('a[href*=xuanxuan]').parent().addClass('active');
})

function showLog()
{
    $.getJSON(createLink('chat', 'showLog'), function(response)
    {
        if(response.result == 'fail')
        {
            $('#log').html(response.message);
        }
        else
        {
            $('#log').html(response.logs);
        }
    });
}
