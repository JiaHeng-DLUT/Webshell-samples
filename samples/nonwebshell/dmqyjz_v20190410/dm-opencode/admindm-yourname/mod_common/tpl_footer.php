
</div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
 
 <div class="pull-right">

  <a class="needpopup" href="../mod_imgfj/mod_imgfj.php?pid=name&lang=<?php echo LANG; ?>"  >名称附件管理</a>     |
  <a class="needpopup" href="../mod_imgfj/mod_imgfj.php?pid=common&lang=<?php echo LANG; ?>" >公共编辑器附件管理</a>     |
  <?php echo showblockid(); ?>      |
   <a class="needpopup" href="../mod_common/someclass.html">一些样式></a>    |

  <a target="_blank" href="<?php echo $dmlink_color;?>">配色方案></a>

    </div>




技术支持：<a href="<?php echo $dmlink_home;?>" target="_blank">DM企业建站系统 demososo.com</a>  (V2019.4.10)

&nbsp;&nbsp;



 

  </footer>




</div>
<!-- ./wrapper -->

<?php

  require_once HERE_ROOT.'mod_common/tpl_footerpop.php';

?>

<div id="backtotop" style="display: none;">
        <a href="javascript:void(0)">
        </a>
    </div>

<script>
$(function(){

         jQuery(window).scroll(function () {
             // if($('body').width()<800)  return false;
            if (jQuery(this).scrollTop() > 100) {
                jQuery('#backtotop').fadeIn();
            } else {
                jQuery('#backtotop').fadeOut();
            }
        });

        // scroll body to 0px on click
        jQuery('#backtotop a').click(function () {
            jQuery('body,html').animate({
                scrollTop: 0
            }, 500);
            return false;
        });



});
</script>
</body>
</html>