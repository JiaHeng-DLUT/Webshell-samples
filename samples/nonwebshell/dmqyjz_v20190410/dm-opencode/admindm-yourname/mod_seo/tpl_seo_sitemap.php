<section class="content-header">
<h1>网站地图</h1>
</section>
<p style="padding:20px 0">
<a  style="font-size:18px" href="mod_seo.php?lang=<?php echo LANG?>&file=sitemap&act=generatemap">点击生成网站地图 （位于 网站根目录下的sitemap.xml)</a>
</p>

<?php 
 //echo $dateday;
 //echo $baseurl;
 $freq = 'weekly';

 
if($act=='generatemap'){
  
  $pagemap = map_page($dateday,$freq);
  $catemap = map_cate($dateday,$freq);
  $nodemap = map_node($dateday,$freq);

$maphome="<url><loc>$baseurl</loc><priority>1</priority><lastmod>$dateday</lastmod><changefreq>$freq</changefreq></url>";
 $sitemap1 = '<?xml version="1.0" encoding="utf-8"?>  <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
 $sitemap2 = '</urlset>';

 $sitemap = $sitemap1.$maphome.$pagemap.$catemap.$nodemap.$sitemap2;

 $mapfile = WEB_ROOT.'sitemap.xml';
 //echo $mapfile;
 file_put_contents($mapfile,$sitemap );
 

 echo '<p style="padding:100px 0; font-size:20px">操作成功。<a target="_blank" href="'.fronturl(BASEURL.'sitemap.xml').'">点击查看></a></p>';

}

function map_page($dateday,$freq){
 global $andlangbh;
  $sql = "SELECT id,pidname,alias_jump from ".TABLE_PAGE." where  pid='0'  $andlangbh  order by pos desc,id";
 if(getnum($sql)>0){
    $result = getall($sql);
    $map = '';
    foreach($result as $v){
       // pre($v);
        $tid = $v['id'];
        $pidname = $v['pidname'];
        $alias = alias($pidname);
        
        //url($type,$alias,$tid,$jump)
        $link = BASEURLPATH.get_url($v);
        if($alias<>'index')
        $map = $map."<url><loc>$link</loc><priority>0.5</priority><lastmod>$dateday</lastmod><changefreq>$freq</changefreq></url>";
       
    }
    return $map;
 }
 else return '';
 
}

function map_cate($dateday,$freq){
  global $andlangbh;
  $k = 'node';
  $sql = "SELECT id,pidname,alias_jump  from ".TABLE_CATE." where   modtype='$k'    $andlangbh  order by pos desc,id desc";
  if(getnum($sql)>0){
     $result = getall($sql);
     $map = '';
     foreach($result as $v){
        // pre($v);
         $tid = $v['id'];
         $pidname = $v['pidname'];
         $jump = $v['alias_jump'];
 
         
         
         if($jump==''){
           //url($type,$alias,$tid,$jump)
            $link = BASEURLPATH.get_url($v); 
          $map = $map."<url><loc>$link</loc><priority>0.5</priority><lastmod>$dateday</lastmod><changefreq>$freq</changefreq></url>";
         }
        
     }
     return $map;
  }
  else return ''; 
 
 }

 
 function map_node($dateday,$freq){ 
  
  global $andlangbh;
  $k = 'node';
  $sql = "SELECT id,pidname,alias_jump from ".TABLE_NODE." where   modtype='$k'    $andlangbh  order by pos desc,id desc";
  if(getnum($sql)>0){
     $result = getall($sql);
     $map = '';
     foreach($result as $v){
         //pre($v);
         $tid = $v['id'];
         $pidname = $v['pidname'];
         $jump = $v['alias_jump'];
 
        
         //url($type,$alias,$tid,$jump)
         if($jump==''){
          $link = BASEURLPATH.get_url($v);
           $map = $map."<url><loc>$link</loc><priority>0.5</priority><lastmod>$dateday</lastmod><changefreq>$freq</changefreq></url>";
         }
        
     }
     return $map;
  }
  else return ''; 
 
 }

 

/*
<?xml version="1.0" encoding="utf-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<url>
<loc>https://www.demososo.com</loc>
<priority>1</priority>
<lastmod>2018-08-23</lastmod>
<changefreq>weekly</changefreq>
</url>
<url>
<loc>https://www.demososo.com/about.html</loc>
<priority>0.5</priority>
<lastmod>2018-08-23</lastmod>
<changefreq>weekly</changefreq>
</url>
</urlset>
 */
?>

