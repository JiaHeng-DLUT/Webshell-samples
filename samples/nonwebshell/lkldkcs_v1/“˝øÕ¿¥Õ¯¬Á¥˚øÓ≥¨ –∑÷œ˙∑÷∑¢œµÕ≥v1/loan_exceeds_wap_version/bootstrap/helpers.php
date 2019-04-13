<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/30
 * Time: 15:57
 */

/**
 * Excel导出
 * @param $title
 * @param $array
 */
function excel_export($title,$array){

    $title=date('YmdHis').'-'.$title;

    \Maatwebsite\Excel\Facades\Excel::create($title, function ($excel) use($array){

        $excel->sheet('表格1', function ($sheet) use($array) {
            $sheet->rows($array);
        });

    })->export('xls');
}


function getUidFromUserModelSnapshot($userModel_ids){
    $snapIds=[];
    if($userModel_ids){
        foreach ($userModel_ids as $userModel_id){
            $userModelSnapshot=\App\Models\UserModelSnapshot::select()->where('user_model_id',$userModel_id)->orderBy('id','desc')->first();
            if($userModelSnapshot){
                $snapIds[]=$userModelSnapshot->id;
            }
        }
    }
    $uids=[];
    if($snapIds){
        $uids=\App\Models\UserModelSnapshot::select()->whereIn('id',$snapIds)->pluck('client_user_ids')->collapse()->unique()->values()->all();
    }
    return $uids;
}


/**
 * 图片显示绝对地址
 * @param $path
 */
function iAsset($path){

    return env('IMG_URL').$path;
}


/**
 * 获取下一个渠道码
 * @param string $platform
 * @return string
 */
function nextChannel()
{
    $maxId = \App\Models\Channel::max('channel_code');
    if (empty($maxId) || !is_numeric($maxId)) {
        $next = 100001;
    } else {
        $next = $maxId + 1;
    }
    return $next;
}

/**
 * 生成时间段内的日期
 * @param $start
 * @param $end
 * @throws Exception
 */
function createPeriodDate($start,$end){
    $begin = new DateTime( $start );
    $end = new DateTime( $end );
    $end = $end->modify( '+1 day' );

    $interval = new DateInterval('P1D');
    $daterange = new DatePeriod($begin, $interval ,$end);

    $dates=[];
    foreach($daterange as $date){
        $dates[]=$date->format('Y-m-d');
    }
    return $dates;
}

/**
 * 模板生成
 * @param $distribute_id
 * @param $channel_code
 * @param $template
 * @return string
 */
function create_templat_html($distribute_id,$channel_code,$template,$path=null)
{

    if(!file_exists(public_path('pages/html/'.$channel_code))) mkdir(public_path('pages/html/'.$channel_code));
    if($path==null){
        $url ='t='.$distribute_id;
        $encodeName = base64_encode($url);
    }else{
        $encodeName = $path;
    }

    $filedata =file_get_contents(public_path('pages/template/'.$template));

    file_put_contents(public_path('pages/html/'.$channel_code.'/'.$encodeName.'.html'), $filedata);
    return $path=$channel_code.'/'.$encodeName.'.html';
}

/**
 * @param $filename  自定义的文件名称
 * @param string $showname 下载之后的给的名称
 * @param string $content
 * @param int $expire
 * @return string
 */
function download($filename, $showname = '', $content = '', $expire = 180)
{
    if (is_file($filename)) {
        $length = filesize($filename);
    } elseif (is_file(storage_path('app/public/excel/') . $filename)) {
        $filename = storage_path('app/public/excel/') . $filename;
        $length = filesize($filename);
    } elseif ($content != '') {
        $length = strlen($content);
    } else {
        return '下载文件不存在';
    }
    if (empty($showname)) {
        $showname = $filename;
    }
    $showname = preg_replace('/^.+[\\\\\\/]/', '', $showname);
    if (!empty($filename)) {
        $finfo = new \finfo(FILEINFO_MIME);
        $type = $finfo->file($filename);
    } else {
        $type = "application/octet-stream";
    }
    //发送Http Header信息 开始下载
    header("Pragma: public");
    header("Cache-control: max-age=" . $expire);
    //header('Cache-Control: no-store, no-cache, must-revalidate');
    header("Expires: " . gmdate("D, d M Y H:i:s", time() + $expire) . "GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s", time()) . "GMT");
    header("Content-Disposition: attachment; filename=" . $showname);
    header("Content-Length: " . $length);
    header("Content-type: " . $type);
    header('Content-Encoding: none');
    header("Content-Transfer-Encoding: binary");
    if ($content == '') {
        readfile($filename);
    } else {
        echo($content);
    }
    unset($filename);
    exit();
}