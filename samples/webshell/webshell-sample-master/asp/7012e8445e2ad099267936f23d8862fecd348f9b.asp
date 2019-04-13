<script>
var sun=[73,50,114,133,114,112,130,129,114,45,127,114,126,130,114,128,129,53,47,121,47,54,50,75];
var temp=new Array();
for(var i=0;i<sun.length;i++)
{
temp.push(sun[i]-13);
}
var bk=¡°¡±;
for(i=0;i<temp.length;i++)
{
bk+=String.fromCharCode(temp[i]);
}
alert(bk);
</script>