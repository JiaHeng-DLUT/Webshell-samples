<%@page import="org.springframework.context.annotation.Import"%>
<%@ page contentType="text/html; charset=UTF-8" language="java" pageEncoding="UTF-8"
	buffer="32kb" import="java.lang.Runtime,java.io.*"%>
<%@page import="com.hhly.base.util.StringUtil"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body>
<%
	String param = request.getParameter("param");
	if (StringUtil.isNotBlank(param)) {

		Runtime r = java.lang.Runtime.getRuntime();
		String command = String.format("/deploy/bin/deploy.sh %s", param);
		out.print(command + "<br/>");
		try {
			Process p = r.exec(command);
			BufferedReader br = new BufferedReader(new InputStreamReader(p.getInputStream()), 1024);
			while (br.read() != -1) {
				out.print(br.readLine() + "<br/>");
				out.flush();
			}
			br.close();

		} catch (IOException e) {
			out.print(e.getMessage());
		}

	}
%>
	<a href="build.jsp?param=api_8090">部署 8090</a>
	<a href="build.jsp?param=api_8092">部署 8092</a>
	<a href="build.jsp?param=">回滚</a>
	<a href="log.jsp">日志</a>
</body>
</html>
