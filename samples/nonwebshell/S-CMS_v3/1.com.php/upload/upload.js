var langcode="php";
function showUpload(a,b){

            tid="#"+a;
            processid=getID();
            $(tid).parent().append("<input type='file' id='testFile"+a+"' style='display:none;' onchange='aaa(\""+a+"\",\""+b+"\")'/>");
            $("#testFile"+a).trigger("click");
}


function aaa(a,b){
    var fileObj = document.getElementById("testFile"+a).files[0];
        var form = new FormData();
        form.append("file"+processid, fileObj);
        filename=fileObj.name;
        filesize=fileObj.size;

        $.ajax({  
         url: "upload/upload."+langcode+"?path="+b.replace("..","@@")+"&processid=AN"+processid+"&id="+a,
         type: 'POST',  
         data: form,  
         async: false,
        cache: false,
        contentType: false,
        processData: false,
         success: function (msg) {
        console.log(msg);

        if(msg.substr(0,4)=="http"){
            $(tid+"x").attr("src",msg);
            $(tid+"x").attr("alt","<img src='"+msg+"' width=400");
            $(tid).val(msg);
        }else{
            $(tid+"x").attr("src",b+"/"+msg);
            $(tid+"x").attr("alt","<img src='"+b+"/"+msg+"' width=400");
            if(b=="../media"){
                $(tid).val("media/"+msg);
            }else{
                $(tid).val(msg);
            }
        }

        $("#testFile"+a).remove();
         },  
         error: function (msg) {  
            console.log(msg);
         }  
    });           
}




function getID(){var mydt=new Date();with(mydt){var y=getYear();if(y<10){y='0'+y}var m=getMonth()+1;if(m<10){m='0'+m}var d=getDate();if(d<10){d='0'+d}var h=getHours();if(h<10){h='0'+h}var mm=getMinutes();if(mm<10){mm='0'+mm}var s=getSeconds();if(s<10){s='0'+s}}var r="000" + Math.floor(Math.random() * 1000);r=r.substr(r.length-4);return y + m + d + h + mm + s + r;};