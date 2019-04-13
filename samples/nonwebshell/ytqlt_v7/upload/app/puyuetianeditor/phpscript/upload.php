<?php
if (!defined('puyuetian'))
	exit('403');

if ((!InArray($_G['USERGROUP']['QUANXIAN'], 'uploadfile') && $_G['USERGROUP']['ID']) || (!InArray($_G['USER']['QUANXIAN'], 'uploadfile') && !$_G['USERGROUP']['ID'])) {
	uploadexit('您无权上传文件');
}

if (!InArray('image,file,music,video', $_G['GET']['T'])) {
	uploadexit('非法的目录请求');
}

$date = date('Ymd', time());
$useruploadfilespath = "{$_G['SYSTEM']['PATH']}/uploadfiles/{$_G['GET']['T']}s/{$_G['USER']['ID']}/{$date}/";
if (file_exists($useruploadfilespath) && ((Cnum(JsonData($_G['USER']['DATA'], 'dayuploadfilesize')) * 1024) || Cnum($_G['SET']['DAYUPLOADFILESIZE']))) {
	$uploadedfiles = scandir($useruploadfilespath);
	$filesizecount = 0;
	Cnum(JsonData($_G['USERGROUP']['DATA'], 'dayuploadfilesize')) ? $dayuploadfilesize = Cnum(JsonData($_G['USERGROUP']['DATA'], 'dayuploadfilesize')) : $dayuploadfilesize = Cnum(JsonData($_G['USER']['DATA'], 'dayuploadfilesize'));
	if ($dayuploadfilesize) {
		$cfilesizecount = $dayuploadfilesize * 1024;
	} else {
		$cfilesizecount = Cnum($_G['SET']['DAYUPLOADFILESIZE']) * 1024;
	}
	foreach ($uploadedfiles as $file) {
		if (str_replace('.', '', $file)) {
			$filesizecount += filesize($useruploadfilespath . $file);
		}
	}
	if ($filesizecount > $cfilesizecount) {
		uploadexit('您已达到每日上传文件最大上限' . Cnum($cfilesizecount / 1024) . 'KB');
	}
}

if (count($_FILES['file']['tmp_name']) - 1 > Cnum($_G['SET']['UPLOADFILECOUNT'], 5)) {
	uploadexit('一次最多上传' . Cnum($_G['SET']['UPLOADFILESCOUNT'], 5) . '个文件');
}
//print_r($_FILES);
//exit();
$jscode = '';
if (!$_FILES['file']['error']) {
	uploadexit(TRUE);
}
foreach ($_FILES['file']['error'] as $key => $value) {
	if ($_FILES['file']['error'][$key] > 0) {
		switch ($_FILES['file']['error'][$key]) {
			case 1 :
				$errortip = $_FILES['file']['name'][$key] . '的大小超过了php.ini中upload_max_filesize选项限制的值';
				break;
			case 2 :
				$errortip = $_FILES['file']['name'][$key] . '的大小超过了HTML表单中MAX_FILE_SIZE选项指定的值';
				break;
			case 3 :
				$errortip = $_FILES['file']['name'][$key] . '只有部分被上传';
				break;
			case 4 :
				$errortip = $_FILES['file']['name'][$key] . '没有文件被上传';
				break;
			case 6 :
				$errortip = $_FILES['file']['name'][$key] . '找不到临时文件夹';
				break;
			case 7 :
				$errortip = $_FILES['file']['name'][$key] . '写入失败';
				break;
			default :
				$errortip = $_FILES['file']['name'][$key] . '未知错误';
				break;
		}
		uploadexit("{$key}:{$errortip}");
	}

	if ($_FILES['file']['size'][$key] < 10) {
		uploadexit($_FILES['file']['name'][$key] . '文件过小或未选择文件！');
	}

	Cnum(JsonData($_G['USERGROUP']['DATA'], 'uploadsize')) ? $uploadsize = Cnum(JsonData($_G['USERGROUP']['DATA'], 'uploadsize')) : $uploadsize = Cnum(JsonData($_G['USER']['DATA'], 'uploadsize'));
	if ($uploadsize) {
		if ($_FILES['file']['size'][$key] > ($uploadsize * 1024)) {
			uploadexit('上传文件不能超过' . ($uploadsize * 1024) . 'K');
		}
	} else {
		if (!Cnum($_G['SET']['UPLOADFILESIZE'])) {
			uploadexit('本站禁止上传文件');
		}
		if ($_FILES['file']['size'][$key] > (Cnum($_G['SET']['UPLOADFILESIZE']) * 1024)) {
			uploadexit("上传文件不能超过{$_G['SET']['UPLOADFILESIZE']}K");
		}
	}

	$suffix = strtolower(end(explode('.', $_FILES['file']['name'][$key])));
	if ($_G['GET']['T'] == 'image') {
		if (!InArray('jpg,jpeg,png,gif,bmp', $suffix)) {
			uploadexit('只能上传图片文件');
		}
	} elseif ($_G['GET']['T'] == 'music') {
		if (!InArray('mp3,ogg,wav', $suffix)) {
			uploadexit('只能上传音频文件：mp3,ogg,wav');
		}
	} elseif ($_G['GET']['T'] == 'video') {
		if (!InArray('mp4,ogg,mov,avi,mid,flash,3gp', $suffix)) {
			uploadexit('只能上传视频文件：mp4,ogg,mov,avi,mid,flash,3gp');
		}
	} else {
		if (!InArray($_G['SET']['UPLOADFILETYPES'], $suffix, '|')) {
			uploadexit("不允许的文件后缀:{$suffix}，请核对后再上传");
		}
	}

	if (!is_uploaded_file($_FILES['file']['tmp_name'][$key])) {
		uploadexit('上传失败！未通过系统检验');
	}

	if (!file_exists($useruploadfilespath) && !mkdir($useruploadfilespath, 0777, TRUE)) {
		uploadexit('创建目录失败');
	}

	//更名，保存文件至指定目录
	$uid = $_G['USER']['ID'];
	$time = date('His', time());
	$rand = CreateRandomString(6);
	$idcode = md5($uid . $date . $time . $rand . $suffix);
	$filename = "{$time}_{$rand}.{$suffix}";
	$filesize = (int)($_FILES['file']['size'][$key] / 1024) + 1;
	move_uploaded_file($_FILES['file']['tmp_name'][$key], $useruploadfilespath . $filename);
	//图片压缩
	$compress_wh = explode(',', $_G['SET']['APP_PUYUETIANEDITOR_COMPRESS_WH']);
	//&& $suffix != 'gif'
	if ($_G['GET']['T'] == 'image' && $suffix != 'gif' && count($compress_wh) == 2) {
		$image = FALSE;
		$m_w = Cnum($compress_wh[0]);
		$m_h = Cnum($compress_wh[1]);
		$image_info = getimagesize($useruploadfilespath . $filename);
		if ($m_w < $image_info[0] && $m_w) {
			//宽度超过了要求，压缩图片
			$image = imagecreatefromstring(file_get_contents($useruploadfilespath . $filename));
			$_h = $image_info[1] / $image_info[0] * $m_w;
			$_image = imagecreatetruecolor($m_w, $_h);
			imagecopyresampled($_image, $image, 0, 0, 0, 0, $m_w, $_h, $image_info[0], $image_info[1]);
			if ($image) {
				switch (strtolower(end(explode('.', $useruploadfilespath . $filename)))) {
					case 'jpg' :
						imagejpeg($_image, $useruploadfilespath . $filename);
						break;
					case 'gif' :
						imagegif($_image, $useruploadfilespath . $filename);
						break;
					default :
						imagepng($_image, $useruploadfilespath . $filename);
						break;
				}
			}
		}
		$image_info = getimagesize($useruploadfilespath . $filename);
		if ($m_h < $image_info[1] && $m_h) {
			//高度超过了要求，压缩图片
			$image = imagecreatefromstring(file_get_contents($useruploadfilespath . $filename));
			$_w = $image_info[0] / $image_info[1] * $m_h;
			$_image = imagecreatetruecolor($_w, $m_h);
			imagecopyresampled($_image, $image, 0, 0, 0, 0, $_w, $m_h, $image_info[0], $image_info[1]);
			if ($image) {
				switch (strtolower(end(explode('.', $useruploadfilespath . $filename)))) {
					case 'jpg' :
						imagejpeg($_image, $useruploadfilespath . $filename);
						break;
					case 'gif' :
						imagegif($_image, $useruploadfilespath . $filename);
						break;
					default :
						imagepng($_image, $useruploadfilespath . $filename);
						break;
				}
			}
		}
	}
	//图片加水印
	if ($_G['GET']['T'] == 'image' && $suffix != 'gif' && $_G['SET']['APP_PUYUETIANEDITOR_WATERMARK_TEXT']) {
		$image = imagecreatefromstring(file_get_contents($useruploadfilespath . $filename));
		$color = imagecolorallocate($image, Cnum($_G['SET']['APP_PUYUETIANEDITOR_WATERMARK_TEXTCOLOR_R']), Cnum($_G['SET']['APP_PUYUETIANEDITOR_WATERMARK_TEXTCOLOR_G']), Cnum($_G['SET']['APP_PUYUETIANEDITOR_WATERMARK_TEXTCOLOR_B']));
		!file_exists("{$_G['SYSTEM']['PATH']}/app/puyuetianeditor/template/font/default.ttc") ? imagestring($image, 5, 10, 5, $_G['SET']['APP_PUYUETIANEDITOR_WATERMARK_TEXT'], $color) : imagettftext($image, Cnum($_G['SET']['APP_PUYUETIANEDITOR_WATERMARK_FONTSIZE'], 18), Cnum($_G['SET']['APP_PUYUETIANEDITOR_WATERMARK_PP']), Cnum($_G['SET']['APP_PUYUETIANEDITOR_WATERMARK_PX']), Cnum($_G['SET']['APP_PUYUETIANEDITOR_WATERMARK_PY']), $color, "{$_G['SYSTEM']['PATH']}/app/puyuetianeditor/template/font/default.ttc", $_G['SET']['APP_PUYUETIANEDITOR_WATERMARK_TEXT']);
		switch (strtolower(end(explode('.', $useruploadfilespath . $filename)))) {
			case 'jpg' :
				imagejpeg($image, $useruploadfilespath . $filename);
				break;
			case 'gif' :
				imagegif($image, $useruploadfilespath . $filename);
				break;
			default :
				imagepng($image, $useruploadfilespath . $filename);
				break;
		}
	}

	$uploadarray['target'] = $_G['GET']['T'];
	$uploadarray['uid'] = $uid;
	$uploadarray['datetime'] = $date . $time;
	$uploadarray['rand'] = $rand;
	$uploadarray['suffix'] = $suffix;
	$uploadarray['idcode'] = $idcode;
	$uploadarray['jifen'] = $uploadarray['tiandou'] = $uploadarray['downloadcount'] = 0;
	$uploadarray['name'] = '';
	$uploadarray['uploadtime'] = time();
	$_G['TABLE']['UPLOAD'] -> newData($uploadarray);
	$id = $_G['TABLE']['UPLOAD'] -> getId();

	if ($_G['GET']['T'] != 'file') {
		$url = "uploadfiles/{$_G['GET']['T']}s/{$uid}/{$date}/{$time}_{$rand}.{$suffix}";
		if ($_G['GET']['T'] == 'image') {
			$jscode .= 'if(typeof(parent.PytAddImageInbox)=="function"){parent.PytAddImageInbox("' . $url . '");}else{parent.document.getElementById("PytImagesBox").innerHTML+="<div class=\"pk-w-sm-3 pk-margin-bottom-10\"><img class=\"pk-active\" src=\"' . $url . '\" onclick=\"$(this).toggleClass(\'pk-active\')\"></div>";}';
		} else {
			$jscode .= 'parent.document.getElementById("Pyt' . strtoupper(substr($_G['GET']['T'], 0, 1)) . substr($_G['GET']['T'], 1) . 'Url").value="' . $url . '";';
		}
	} else {
		$url = "index.php?c=app&a=puyuetianeditor:index&s=showfile&id={$id}";
		$jscode .= 'parent.document.getElementById("PytFileUrl").value="' . $url . '";';
	}
}
exit('
<script>
' . $jscode . ';
location.href="app/puyuetianeditor/template/upload.html?t=' . $_G['GET']['T'] . '&align=' . $_G['GET']['ALIGN'] . '&rnd=' . $_G['RND'] . '";
</script>
');

function uploadexit($str) {
	global $_G;
	if ($str === TRUE) {
		$str = '";str=document.getElementsByTagName("body")[0].innerText;"';
	} else {
		$str = str_replace('"', '\\"', $str);
	}
	exit('
<script>
var str="' . $str . '";
parent.ppp({title:"出错",icon:2,content:str});
location.href="app/puyuetianeditor/template/upload.html?t=' . $_G['GET']['T'] . '&align=' . $_G['GET']['ALIGN'] . '&rnd=' . $_G['RND'] . '";
</script>
');
}
