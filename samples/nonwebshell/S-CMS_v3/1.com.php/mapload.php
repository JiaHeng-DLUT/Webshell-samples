<?php
require 'conn/conn.php';
require 'conn/function.php';

$C_zb=htmlspecialchars($_GET["C_zb"]);
$C_address=htmlspecialchars($_GET["C_address"]);

if ($C_map=="google"){
?>

<html>
<head>
<script src="//maps.google.cn/maps/api/js?sensor=false"></script>

<script>
var myCenter=new google.maps.LatLng(<?php echo splitx($C_zb,",",1)?>,<?php echo splitx($C_zb,",",0)?>);

function initialize()
{
var mapProp = {
  center:myCenter,
  zoom:15,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };

var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

var marker=new google.maps.Marker({
  position:myCenter,
  });

marker.setMap(map);

var infowindow = new google.maps.InfoWindow({
  content:"<?php echo $C_address?>"
  });

infowindow.open(map,marker);
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
</head>

<body>
<div id="googleMap"></div>
<script>document.getElementById("googleMap").style.width=document.documentElement.clientWidth+"px";document.getElementById("googleMap").style.height=document.documentElement.clientHeight+"px";</script></html>
</body>
</html>
<?php
}else{
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html;">
<title></title>
<script type="text/javascript" src="//1.ss.faisys.com/js/comm/jquery/jquery-core.min.js?v=201601261749"></script>
<script type="text/javascript" src="//1.ss.faisys.com/js/comm/fai.min.js?v=201608151835"></script>
<script src="//api.map.baidu.com/api?v=1.1&services=true" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
	if (false) {
		Fai.ing("当前设置的坐标数据有问题，为保证百度API正常使用，现已重置为默认坐标。请您联系客服处理。", true);
	}
	if(1 == 1){
		if( typeof BMap == 'undefined' ){
			var mapContainer = $('#mapContainer316');
			mapContainer.css({ color: 'red', position: 'relative', textAlign: 'center' });
			var msg = $('<div>').css({ position: 'absolute', top:'50%', width:'100%' }).text('加载地图失败，请刷新重试');
			mapContainer.append( msg );
		}else{
			var mMap = new BMap.Map( 'mapContainer316' );
			var mPoint = new BMap.Point( <?php echo $C_zb?> );
			var oPoint = new BMap.Point( <?php echo $C_zb?> );
			var mInfoWindow = new BMap.InfoWindow( "<?php echo $C_address?>", { width:'auto', height:'auto', title:'', enableAutoPan:false });
			var mMarker = new BMap.Marker( oPoint );
			mMarker.addEventListener('infowindowopen', function(e) {
				setTimeout(function(){
					var moduleWidth = 730;
					var diff = 0;
					if( moduleWidth < 255 ){
						diff = 730 - 255;
						if( diff < -100 ){ diff = -100; }
					}
					var pop = $('#mapContainer316').children('#platform').children('#mask').next().children('div:first').children('div.pop');
					var divTop = pop.children('.top');
					divTop.css({ width: (202+diff) + 'px' });// top-center source [202px]
					divTop.next().css({ left: (227+diff) + 'px' });// top-right-radius source [227px]
					
					//middle-center source [250px]
					if( $.browser.msie ){
						if( $.browser.version < 8 ){
							pop.children('.center').css({ width: (250+diff+2) + 'px' });
						}else{
							pop.children('.center').css({ width: (250+diff) + 'px' });
						}
					} else {
						pop.children('.center').css({ width: (250+diff) + 'px' });
					}
					
					var divBottom = pop.children('.bottom');
					divBottom.css({ width: (202+diff) + 'px' });// bottom-center source [202px]
					divBottom.next().css({ left: (227+diff) + 'px' });// bottom-right-radius source [227px]
					pop.children('div:last').css({ width: (220+diff) + 'px' });// middle-center text source [220px]
					pop.children('img:first').css({ left: (227+diff) + 'px' });// close img button source [227px]
				}, 100);
			})
			mMarker.addEventListener('click', function(e) {
				if( mInfoWindow.isOpen() ){
					this.closeInfoWindow();
				} else {
					this.openInfoWindow(mInfoWindow);
				}
			});
			mMap.centerAndZoom( mPoint, 17 );
			mMap.disableDoubleClickZoom();
			mMap.addControl( new BMap.NavigationControl() );
			mMap.addOverlay( mMarker );
			mMarker.openInfoWindow( mInfoWindow );
		}
	}
	
});
</script>
</head>
<body style="margin:0px; padding:0px; font-size:12px;">
<div id="mapContainer316" style="height:100%; width:100%;"></div>
</body>
</html>
<?php
}
?>