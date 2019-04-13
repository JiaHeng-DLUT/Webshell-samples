<%
function UnEncode(mumaasp)
for i = 1 to len(mumaasp)
if mid(mumaasp,i,1)<> "по" then
temp = Mid(mumaasp, i, 1) temp
else
temp=vbcrlf&temp
end if
next
UnEncode=temp
end function
%>