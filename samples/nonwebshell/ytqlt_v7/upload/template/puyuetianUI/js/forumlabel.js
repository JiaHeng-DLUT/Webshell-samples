$(function() {
	$('head:eq(0)').append('<link rel="stylesheet" href="template/puyuetianUI/css/forumlabel.css" />');
	if($('#forumlabel').html()) {
		//primary,secondary,warning,danger,success
		var $cs = ["#458fce", "#12b7f5", "#FFCC66", "#CC6666", "#66CC66"];
		var $as = $('#forumlabel>a');
		var $i = 0;
		for(var i = 0; i < $as.length; i++) {
			$($as[i]).css({
				"color": $cs[$i],
				"border-color": $cs[$i]
			});
			$i < 4 ? $i++ : $i = 0;
			//当前选中的东西
			var $labels = decodeURIComponent($_GET('label'));
			if($labels) {
				$labels = $labels.split(',');
				for(var ii = 0; ii < $labels.length; ii++) {
					if($labels[ii] == $($as[i]).html() && $labels[ii]) {
						$($as[i]).addClass('pk-active');
					}
				}
			}
		}
		$('#forumlabel>a').click(function() {
			var $label = '';
			$(this).toggleClass('pk-active');
			var $url = location.href;
			var $as = $('#forumlabel>a');
			for(var i = 0; i < $as.length; i++) {
				if($($as[i]).hasClass('pk-active')) {
					$label += ',' + $($as[i]).html();
				}
			}
			$label = $label.substr(1);
			//去除现有的label
			$url = $url.replace('&label=' + $_GET('label'), '');
			$url = $url.replace('?label=' + $_GET('label'), '');
			if($url.indexOf('?') == -1) {
				$url = $url + '?label=' + encodeURIComponent($label);
			} else {
				$url = $url + '&label=' + encodeURIComponent($label);
			}
			location.href = $url;
		});
	}
});