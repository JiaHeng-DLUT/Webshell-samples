<%@page import="java.text.SimpleDateFormat"%>
<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%  StringBuffer bf = null;
        if (null == application.getAttribute("talks")) {
                bf = new StringBuffer();
        } else {
                bf = (StringBuffer) application.getAttribute("talks");
        }
%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>Chinese Hackers' Chating Room</title>
<style type="text/css">
html{background:#f7f7f7;}
pre{font-size:15pt;font-family:Times New Roman;line-height:120%;}
p{font-size:10pt;}
.tx{font-family:Lucida Handwriting,Times New Roman;}
</style>
</head>
<center>
<a style="letter-spacing:3px;"><b>Hacked! Owned by Chinese Hackers!</b><br></a>
<h1>&#33738;&#33457;&#32842;&#22825;&#23460;</h1>
<hr>
<form method=post action="?" onkeydown="if(event.ctrlKey&&event.keyCode==13)this.submit()">
<p></p>
<textarea rows="5" id="what" style="font-family:Times New Roman;font-size:14pt;" cols="80" name="what">&#35828;&#28857;&#20160;&#20040;&#21543;</textarea>
<p class="tx">Chating Room is Powered By <a href="http://blackbap.org" target="_blank">Silic Group Hacker Army</a>&copy;2009-2012</p>
<input type="submit" title="Ctrl+Enter Submit" value="&#38593;&#36807;&#30041;&#22768;&#32;&#36335;&#36807;&#30041;&#35328;" tilte="Submit" style="width:120px;height:64px;">
</form>
<%
request.setCharacterEncoding("UTF-8");
String p1 = request.getParameter("what");
if (null != p1 && p1.length() > 0) {
p1 = p1.replaceAll("<","&lt;");
p1 = p1.replaceAll(">","&gt;");
String msg = "<div style='margin-top:20px'>"+p1+"</div><div style='font-size:11px'>"+request.getRemoteAddr()+"&#30340;&#31461;&#38795; >>> Fucked at: "+new SimpleDateFormat("yyyy-MM-dd hh:mm:ss").format(new Date())+"</div>";
bf.append(msg);
application.setAttribute("talks", bf);
response.setHeader("refresh","1");
}
%>
</center>
<%
StringBuffer b = (StringBuffer) application.getAttribute("talks");
if (null != b && b.length() > 0) {
out.println(b.toString());
}
%>
</html>
