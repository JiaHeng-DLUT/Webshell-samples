 
<div id="<?php echo $dhtrigger;?>" class="<?php  echo  $cssname?>">
  <dl class="accord">
<?php
 
foreach($result as $k=>$v){

          $title = $v['title']; 
          $imgv =  get_img($v['kv']);
          $despv =  get_nodedesp($v['desp'],$v['desptext']);   
          $linkdhtitle = $linkdhurl = $titlebz1=$titlebz2=$titlebz3='';
          $arr_can = $v['arr_can'];
          $bscntarr = explode('==#==',$arr_can); 
          if(count($bscntarr)>1){
            foreach ($bscntarr as   $bsvalue) {
             if(strpos($bsvalue, ':##')){
               $bsvaluearr = explode(':##',$bsvalue);
               $bsccc = $bsvaluearr[0];
               $$bsccc=$bsvaluearr[1];
             }
           }
          }

   $linkurlarr =  get_nodelinkurl($linkdhurl);      


?>
  <dt><?php echo $title;?></dt>
    <dd style="display:none">
        <?php 
         if($v['kv']<>''){
            echo '<p><img src="'.$imgv.'" alt="" /></p>';
         }
          echo '<div>'.$despv.'</div>';
          ?>
    </dd>

<?php 
 
 }
  ?>  
    </dl>
</div>

 

 <script>
$(function(){

      //$('#<?php echo $dhtrigger?> .accord dd').hide();
       $('#<?php echo $dhtrigger?> .accord').on('click', 'dt', function() {
          
           // $(this).next().slideToggle(200);
           var dtdisplay = $(this).next().css('display');
           //alert(dtdisplay);

           if($(this).next().css('display')=='block')  $(this).next().hide();
            else  {
                 $('#<?php echo $dhtrigger?> .accord dd').hide();
                 $(this).next().show();
            }

           

    });


});
</script>