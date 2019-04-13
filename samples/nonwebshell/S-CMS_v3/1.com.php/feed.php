<?php
require 'conn/conn.php';
require 'conn/function.php';
?><?php echo "<?"?>xml version="1.0" encoding="UTF-8"?><rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	>

<channel>
	<title><?php echo lang($C_webtitle)?></title>
	<atom:link href="http://<?php echo $C_domain?><?php echo $C_dir?>feed.asp" rel="self" type="application/rss+xml" />
	<link>http://<?php echo $C_domain?></link>
	<description><?php echo lang($C_description)?></description>
	<lastBuildDate><?php echo date(DATE_RSS)?></lastBuildDate>
	<language>zh-CN</language>
	<sy:updatePeriod>hourly</sy:updatePeriod>
	<sy:updateFrequency>1</sy:updateFrequency>
	<generator>https://www.s-cms.cn/?v=4.7.5</generator>
<?php

$sql="select * from SL_text order by T_id desc";
$result = mysqli_query($conn,  $sql);
if (mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
?>
	<item>
		<title><?php echo lang($row["T_title"])?></title>
		<link><?php echo "<!"?>[CDATA[<?php if ($C_html==0){
echo "http://".$C_domain.$C_dir."?type=text&S_id="&$row["T_id"];
		}else{
echo "http://".$C_domain.$C_dir."html/about/"&$row["T_id"]&".html";
	}
		?>]]></link>
		<pubDate><?php echo date(DATE_RSS)?></pubDate>
		<dc:creator><?php echo "<!"?>[CDATA[<?php echo lang($C_webtitle)?>]]></dc:creator>
		<category><?php echo "<!"?>[CDATA[<?php echo lang($row["T_title"])?>]]></category>
		<description><?php echo "<!"?>[CDATA[<?php echo lang($row["T_description"])?>]]></description>
		<content:encoded><?php echo "<!"?>[CDATA[<?php echo lang(str_replace("{@SL_安装目录}",$C_dir,$row["T_content"]))?>]]></content:encoded>
		</item>
<?php
    }
} 


$sql="select * from SL_news,SL_nsort where N_sort=S_id order by N_id desc";
$result = mysqli_query($conn,  $sql);
if (mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
?>
	<item>
		<title><?php echo lang($row["N_title"])?></title>
		<link><?php echo "<!"?>[CDATA[<?php if ($C_html==0){
echo "http://".$C_domain.$C_dir."?type=news&S_id="&$row["N_id"];
		}else{
echo "http://".$C_domain.$C_dir."html/news/"&$row["N_id"]&".html";
	}
		?>]]></link>
		<pubDate><?php echo date(DATE_RSS)?></pubDate>
		<dc:creator><?php echo "<!"?>[CDATA[<?php echo $row["N_author"]?>]]></dc:creator>
		<category><?php echo "<!"?>[CDATA[<?php echo lang($row["S_title"])?>]]></category>
		<description><?php echo "<!"?>[CDATA[<?php echo lang($row["N_description"])?>]]></description>
		<content:encoded><?php echo "<!"?>[CDATA[<?php echo lang(str_replace("{@SL_安装目录}",$C_dir,$row["N_content"]))?>]]></content:encoded>
		</item>
<?php
    }
} 


$sql="select * from SL_product,SL_psort where P_sort=S_id order by P_id desc";
$result = mysqli_query($conn,  $sql);
if (mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
?>
	<item>
		<title><?php echo lang($row["P_title"])?></title>
		<link><?php echo "<!"?>[CDATA[<?php if ($C_html==0){
echo "http://".$C_domain.$C_dir."?type=product&S_id="&$row["P_id"];
		}else{
echo "http://".$C_domain.$C_dir."html/product/"&$row["P_id"]&".html";
	}
		?>]]></link>
		<pubDate><?php echo date(DATE_RSS)?></pubDate>
		<dc:creator><?php echo "<!"?>[CDATA[<?php echo lang($C_webtitle)?>]]></dc:creator>
		<category><?php echo "<!"?>[CDATA[<?php echo lang($row["S_title"])?>]]></category>
		<description><?php echo "<!"?>[CDATA[<?php echo lang($row["P_description"])?>]]></description>
		<content:encoded><?php echo "<!"?>[CDATA[<?php echo lang(str_replace("{@SL_安装目录}",$C_dir,$row["P_content"]))?>]]></content:encoded>
		</item>
<?php
    }
} 
?>
	</channel>
</rss>