<?php
require '../conn/conn2.php';
require '../conn/function.php';

$D_domain = splitx($_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"], "/weixin", 0);
$sql = "Select * from SL_config";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if (mysqli_num_rows($result) > 0) {
    $C_webtitle = $row["C_title"];
    $C_wtoken = $row["C_wtoken"];
    $C_logo = $row["C_logo"];
    $C_ico = $row["C_ico"];
    $C_wx_appidz = $row["C_wx_appid"];
    $C_wx_appsecretz = $row["C_wx_appsecret"];
}
$signature = $_REQUEST["signature"];
$nonce = $_REQUEST["nonce"];
$timestamp = $_REQUEST["timestamp"];
$echostr = $_REQUEST["echostr"];
if ($echostr != "") {
    $array = array();
    $array = array($C_wtoken, $timestamp, $nonce);
    sort($array);
    $str = sha1(implode($array));
    if ($str == $signature && $echostr) {
        echo $echostr;
        exit;
    }
}
if ($signature != "" && $echostr == "") {
    $postArr = file_get_contents("php://input");
    $postObj = simplexml_load_string($postArr);
    $ToUserName = $postObj->FromUserName;
    $FromUserName = $postObj->ToUserName;
    $MsgType = $postObj->MsgType;
    $strEvent = $postObj->Event;
    $EventKey = $postObj->EventKey;

    if ($MsgType == "event") {
       
        if ($strEvent == "subscribe") {
            $strsend = events( $ToUserName,$FromUserName, "key_" . getrs("select * from SL_reply where R_key='新用户关注'", "R_reply"));

            $sqlx = "Select  * from SL_member where M_qqid='" . $ToUserName . "'";
            $resultx = mysqli_query($conn, $sqlx);
            if (mysqli_num_rows($resultx) > 0) {
                mysqli_query($conn, "update SL_member set M_subscribe=1 where M_qqid='" . $ToUserName . "'");
            } else {
                $access_token = json_decode(GetBody("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $C_wx_appidz . "&secret=" . $C_wx_appsecretz, ""))->access_token;
                $M_info = json_decode(GetBody("https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $access_token . "&openid=" . $ToUserName . "&lang=zh_CN", ""));

                $M_login = $M_info->nickname;
                $M_pic = $M_info->headimgurl;
                $M_city = $M_info->city;
                $M_province = $M_info->province;
                $M_country = $M_info->country;
                if($M_login!=""){
                    mysqli_query($conn, "insert into SL_member(M_login,M_pwd,M_qqid,M_pic,M_fen,M_regtime,M_add,M_name,M_subscribe) values('" . $M_login . "','" . $ToUserName . "','" . $ToUserName . "','" . $M_pic . "',0,'" . date('Y-m-d H:i:s') . "','" . $M_country . $M_province . $M_city . "','" . $M_login . "',1)");
                    $sql = "select * from SL_member order by M_id desc limit 1";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    if (mysqli_num_rows($result) > 0) {
                        $M_id = $row["M_id"];
                    }
                    uplevel($M_id);
                }


            }
        }
        if ($strEvent == "unsubscribe") {
            mysqli_query($conn, "update SL_member set M_subscribe=0 where M_qqid='" . $ToUserName . "'");
        }
        if ($strEvent == "CLICK") {;
            $strsend = events( $ToUserName,$FromUserName, $EventKey);
            
        }
    }
    if ($MsgType == "text") {
        $E_content = $postObj->Content;
        $strsend = text( $ToUserName, $FromUserName,$E_content);
    }
    echo $strsend;
}
function events($FromUserName, $ToUserName, $key) {
    global $conn, $D_domain, $C_ico;
    $E_type = getrs("select * from SL_event where E_id=" . splitx($key, "_", 1), "E_type");
    $E_content = getrs("select * from SL_event where E_id=" . splitx($key, "_", 1), "E_content");
    switch ($E_type) {
        case "text":
            $events = "<xml>
						<ToUserName><![CDATA[" . $FromUserName . "]]></ToUserName>
						<FromUserName><![CDATA[" . $ToUserName . "]]></FromUserName>
						<CreateTime>" . date('Y-m-d H:i:s') . "</CreateTime>
						<MsgType><![CDATA[text]]></MsgType>
						<Content><![CDATA[" . $E_content . "]]></Content>
						<FuncFlag>0<FuncFlag>
						</xml>";
        break;
        case "article":
            $events = "<xml>
						<ToUserName><![CDATA[" . $FromUserName . "]]></ToUserName>
						<FromUserName><![CDATA[" . $ToUserName . "]]></FromUserName>
						<CreateTime>" . date('Y-m-d H:i:s') . "</CreateTime>
						<MsgType><![CDATA[news]]></MsgType>
						<ArticleCount>1</ArticleCount>
						<Articles>";
            $emptystr = "<item>
							<Title><![CDATA[文章已删除]]></Title> 
							<Description><![CDATA[文章已删除]]></Description>
							<PicUrl><![CDATA[http://" . $D_domain . "/" . $C_ico . "]]></PicUrl>
							<Url><![CDATA[http://" . $D_domain . "/wap_index.php]]></Url>
						</item>";
            switch (substr($E_content, 0, 1)) {
                case "T":
                    if (getrs("select * from SL_text where T_id=" . substr($E_content, -(strlen($E_content) - 1)), "T_title") != "") {
                        $events = $events . "<item>
												<Title><![CDATA[" . lang(getrs("select * from SL_text where T_id=" . substr($E_content, -(strlen($E_content) - 1)), "T_title")) . "]]></Title>
												<Description><![CDATA[" . lang(getrs("select * from SL_text where T_id=" . substr($E_content, -(strlen($E_content) - 1)), "T_description")) . "]]></Description>
												<PicUrl><![CDATA[http://" . $D_domain . "/" . getrs("select * from SL_text where T_id=" . substr($E_content, -(strlen($E_content) - 1)), "T_pic") . "]]></PicUrl>
												<Url><![CDATA[http://" . $D_domain . "/wap_index.php?type=text&S_id=" . substr($E_content, -(strlen($E_content) - 1)) . "]]></Url>
											</item>";
                    } else {
                        $events = $events . $emptystr;
                    }
                break;
                case "N":
                    if (getrs("select * from SL_news where N_id=" . substr($E_content,  strlen($E_content) - 1), "N_title") != "") {
                        $events = $events . "<item>
												<Title><![CDATA[" . lang(getrs("select * from SL_news where N_id=" . substr($E_content, -(strlen($E_content) - 1)), "N_title")) . "]]></Title>
												<Description><![CDATA[" . lang(getrs("select * from SL_news where N_id=" . substr($E_content, -(strlen($E_content) - 1)), "N_short")) . "]]></Description>
												<PicUrl><![CDATA[http://" . $D_domain . "/" . getrs("select * from SL_news where N_id=" . substr($E_content, -(strlen($E_content) - 1)), "N_pic") . "]]></PicUrl>
												<Url><![CDATA[http://" . $D_domain . "/wap_index.php?type=newsinfo&S_id=" . substr($E_content, -(strlen($E_content) - 1)) . "]]></Url>
												</item>";
                    } else {
                        $events = $events . $emptystr;
                    }
                break;
                case "P":
                    if (getrs("select * from SL_product where P_id=" . substr($E_content,  strlen($E_content) - 1), "P_title") != "") {
                        $events = $events . "<item>
											<Title><![CDATA[" . lang(getrs("select * from SL_product where P_id=" . substr($E_content, -(strlen($E_content) - 1)), "P_title")) . "]]></Title>
											<Description><![CDATA[" . lang(getrs("select * from SL_product where P_id=" . substr($E_content, -(strlen($E_content) - 1)), "P_short")) . "]]></Description>
											<PicUrl><![CDATA[http://" . $D_domain . "/" . splitx(getrs("select * from SL_product where P_id=" . substr($E_content, -(strlen($E_content) - 1)), "P_path"), "|", 0) . "]]></PicUrl>
											<Url><![CDATA[http://" . $D_domain . "/wap_index.php?type=productinfo&S_id=" . substr($E_content, -(strlen($E_content) - 1)) . "]]></Url>
											</item>";
                    } else {
                        $events = $events . $emptystr;
                    }
                break;
                case "F":
                    if (getrs("select * from SL_form where F_id=" . substr($E_content, -(strlen($E_content) - 1)), "F_title") != "") {
                        $events = $events . "<item>
											<Title><![CDATA[" . lang(getrs("select * from SL_form where F_id=" . substr($E_content, -(strlen($E_content) - 1)), "F_title")) . "]]></Title>
											<Description><![CDATA[" . lang(getrs("select * from SL_form where F_id=" . substr($E_content, -(strlen($E_content) - 1)), "F_description")) . "]]></Description>
											<PicUrl><![CDATA[http://" . $D_domain . "/" . getrs("select * from SL_form where F_id=" . substr($E_content, -(strlen($E_content) - 1)), "F_pic") . "]]></PicUrl>
											<Url><![CDATA[http://" . $D_domain . "/wap_index.php?type=form&S_id=" . substr($E_content, -(strlen($E_content) - 1)) . "]]></Url>
											</item>";
                    } else {
                        $events = $events . $emptystr;
                    }
                break;
                case "C":
                    $events = $events . "<item>
											<Title><![CDATA[联系我们]]></Title>
											<Description><![CDATA[联系我们]]></Description>
											<PicUrl><![CDATA[http://" . $D_domain . "/" . $C_ico . "]]></PicUrl>
											<Url><![CDATA[http://" . $D_domain . "/wap_index.php?type=contact&S_id=1]]></Url>
											</item>";
                break;
                case "G":
                    $events = $events . "<item>
										<Title><![CDATA[在线留言]]></Title>
										<Description><![CDATA[在线留言]]></Description>
										<PicUrl><![CDATA[http://" . $D_domain . "/" . $C_ico . "]]></PicUrl>
										<Url><![CDATA[http://" . $D_domain . "/wap_index.php?type=guestbook&S_id=1]]></Url>
										</item>";
            }
            $events = $events . "</Articles></xml>";
        break;
        case "articles":
            if ($E_content == "推送网站目录") {
                $events = gz( $FromUserName,$ToUserName);
            } else {
                $E_content = explode(",", $E_content);
                for ($i = 0;$i < count($E_content);$i++) {
                    switch (substr($E_content[$i], 0, 1)) {
                        case "T":
                            if (getrs("select * from SL_text where T_id=" . substr($E_content[$i], -(strlen($E_content[$i]) - 1)), "T_title") != "") {
                                $events = $events . "<item>
													<Title><![CDATA[" . lang(getrs("select * from SL_text where T_id=" . substr($E_content[$i], -(strlen($E_content[$i]) - 1)), "T_title")) . "]]></Title>
													<Description><![CDATA[" . lang(getrs("select * from SL_text where T_id=" . substr($E_content[$i], -(strlen($E_content[$i]) - 1)), "T_description")) . "]]></Description>
													<PicUrl><![CDATA[http://" . $D_domain . "/" . getrs("select * from SL_text where T_id=" . substr($E_content[$i], -(strlen($E_content[$i]) - 1)), "T_pic") . "]]></PicUrl>
													<Url><![CDATA[http://" . $D_domain . "/wap_index.php?type=text&S_id=" . substr($E_content[$i], -(strlen($E_content[$i]) - 1)) . "]]></Url>
													</item>";
                            }
                        break;
                        case "N":
                            if (getrs("select * from SL_news where N_id=" . substr($E_content[$i], -(strlen($E_content[$i]) - 1)), "N_title") != "") {
                                $events = $events . "<item>
														<Title><![CDATA[" . lang(getrs("select * from SL_news where N_id=" . substr($E_content[$i], -(strlen($E_content[$i]) - 1)), "N_title")) . "]]></Title>
														<Description><![CDATA[" . lang(getrs("select * from SL_news where N_id=" . substr($E_content[$i], -(strlen($E_content[$i]) - 1)), "N_short")) . "]]></Description>
														<PicUrl><![CDATA[http://" . $D_domain . "/" . getrs("select * from SL_news where N_id=" . substr($E_content[$i], -(strlen($E_content[$i]) - 1)), "N_pic") . "]]></PicUrl>
														<Url><![CDATA[http://" . $D_domain . "/wap_index.php?type=newsinfo&S_id=" . substr($E_content[$i], -(strlen($E_content[$i]) - 1)) . "]]></Url>
														</item>";
                            }
                        break;
                        case "P":
                            if (getrs("select * from SL_product where P_id=" . substr($E_content[$i], -(strlen($E_content[$i]) - 1)), "P_title") != "") {
                                $events = $events . "<item>
													<Title><![CDATA[" . lang(getrs("select * from SL_product where P_id=" . substr($E_content[$i], -(strlen($E_content[$i]) - 1)), "P_title")) . "]]></Title>
													<Description><![CDATA[" . lang(getrs("select * from SL_product where P_id=" . substr($E_content[$i], -(strlen($E_content[$i]) - 1)), "P_short")) . "]]></Description>
													<PicUrl><![CDATA[http://" . $D_domain . "/" . splitx(splitx(getrs("select * from SL_product where P_id=" . substr($E_content[$i], -(strlen($E_content[$i]) - 1)), "P_path"), "|", 0),"_",0) . "]]></PicUrl>
													<Url><![CDATA[http://" . $D_domain . "/wap_index.php?type=productinfo&S_id=" . substr($E_content[$i], -(strlen($E_content[$i]) - 1)) . "]]></Url>
													</item>";
                            }
                        break;
                        case "F":
                            if (getrs("select * from SL_form where F_id=" . substr($E_content[$i], -(strlen($E_content[$i]) - 1)), "F_title") != "") {
                                $events = $events . "<item>
													<Title><![CDATA[" . lang(getrs("select * from SL_form where F_id=" . substr($E_content[$i], -(strlen($E_content[$i]) - 1)), "F_title")) . "]]></Title>
													<Description><![CDATA[" . lang(getrs("select * from SL_form where F_id=" . substr($E_content[$i], -(strlen($E_content[$i]) - 1)), "F_description")) . "]]></Description>
													<PicUrl><![CDATA[http://" . $D_domain . "/" . getrs("select * from SL_form where F_id=" . substr($E_content[$i], -(strlen($E_content[$i]) - 1)), "F_pic") . "]]></PicUrl>
													<Url><![CDATA[http://" . $D_domain . "/wap_index.php?type=form&S_id=" . substr($E_content[$i], -(strlen($E_content[$i]) - 1)) . "]]></Url>
													</item>";
                            }
                        break;
                        case "C":
                            $events = $events . "<item>
													<Title><![CDATA[联系我们]]></Title>
													<Description><![CDATA[联系我们]]></Description>
													<PicUrl><![CDATA[http://" . $D_domain . "/" . $C_ico . "]]></PicUrl>
													<Url><![CDATA[http://" . $D_domain . "/wap_index.php?type=contact&S_id=1]]></Url>
													</item>";
                        break;
                        case "G":
                            $events = $events . "<item>
													<Title><![CDATA[在线留言]]></Title>
													<Description><![CDATA[在线留言]]></Description>
													<PicUrl><![CDATA[http://" . $D_domain . "/" . $C_ico . "]]></PicUrl>
													<Url><![CDATA[http://" . $D_domain . "/wap_index.php?type=guestbook&S_id=1]]></Url>
													</item>";
                    }
                }
                
                if (strpos($events,"<Title>")===false) {
                    $events = "<item>
								<Title><![CDATA[文章已删除]]></Title>
								<Description><![CDATA[文章已删除]]></Description>
								<PicUrl><![CDATA[http://" . $D_domain . "/" . $C_ico . "]]></PicUrl>
								<Url><![CDATA[http://" . $D_domain . "/wap_index.php]]></Url>
								</item>";
                    $NUM = 1;
                }else{
                	$NUM = count(explode("<Title>", $events))-1;
                }

                $events = "<xml>
							<ToUserName><![CDATA[" . $FromUserName . "]]></ToUserName>
							<FromUserName><![CDATA[" . $ToUserName . "]]></FromUserName>
							<CreateTime>" . date('Y-m-d H:i:s') . "</CreateTime>
							<MsgType><![CDATA[news]]></MsgType>
							<ArticleCount>" . $NUM . "</ArticleCount>
							<Articles>" . $events . "</Articles></xml>";
            }
    }
    return $events;
}
function text($FromUserName, $ToUserName, $fromstr) {
    global $conn, $D_domain, $C_ico;
    $sql = "select * from SL_reply where R_key='" . $fromstr . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
        $text = events( $FromUserName,$ToUserName, "key_" . $row["R_reply"]);
    } else {
        $text = events( $FromUserName,$ToUserName, "key_" . getrs("select * from SL_event where E_title='未匹配到关键词'","E_id"));
    }
    return $text;
}
function gz($FromUserName, $ToUserName) {
    global $conn, $D_domain, $C_ico;
    $sql2 = "Select * from SL_slide order by S_id desc limit 1";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
    if (mysqli_num_rows($result2) > 0) {
        $S_pic = $row2["S_pic"];
    }
    $sql2 = "select count(*) as U_count from SL_menu where U_sub=0";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
    $U_count = $row2["U_count"];
    if ($U_count > 8) {
        $U_count = 8;
    }
    $gz = "<xml>
    <ToUserName><![CDATA[" . $FromUserName . "]]></ToUserName>
    <FromUserName><![CDATA[" . $ToUserName . "]]></FromUserName>
    <CreateTime>" . date('Y-m-d H:i:s') . "</CreateTime>
    <MsgType>news</MsgType>
    <ArticleCount>" . $U_count . "</ArticleCount>
    <Articles>";
    $gz = $gz . "<item>
    <Title>欢迎关注" . lang($C_webtitle) . "</Title>
    <Description>" . lang($C_webtitle) . "</Description>
    <PicUrl><![CDATA[http://" . $D_domain . "/" . $S_pic . "]]></PicUrl>
    <Url><![CDATA[http://" . $D_domain . "]]></Url>
    </item>";
    $sql2 = "select * from SL_menu where U_sub=0 and not U_type='index' order by U_order limit " . ($U_count - 1);
    $result2 = mysqli_query($conn, $sql2);
    if (mysqli_num_rows($result2) > 0) {
        while ($row2 = mysqli_fetch_assoc($result2)) {
            if ($row2["U_type"] != "sub" && $row2["U_type"] != "link") {
                $link = "wap_index.php?type=" . $row2["U_type"] . "&S_id=" . $row2["U_typeid"];
            } else {
                $link = $row2["U_link"];
            }
            $gz = $gz . "<item><Title>" . lang($row2["U_title"]) . "/" . lang($row2["U_entitle"]) . "</Title><Description>" . lang($row2["U_title"]) . "/" . lang($row2["U_entitle"]) . "</Description><PicUrl><![CDATA[http://" . $D_domain . "/" . $C_ico . "]]></PicUrl><Url><![CDATA[http://" . $D_domain . "/" . $link . "]]></Url></item>";
        }
        $gz = $gz . "</Articles><FuncFlag>1</FuncFlag></xml>";
    }
    return $gz;
}
?>