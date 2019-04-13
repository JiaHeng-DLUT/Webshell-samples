function ajaxx(A_url, A_data, action, id) {
    toastr.warning("请耐心等待，不要关闭页面", "", {timeOut:3e4});
    $.ajax({
        type: "post",
        url: A_url,
        data: A_data,
        success: function(data) {
            toastr.clear();
            if(data.split("|")[0]=="success"){
            switch (action) {
            case "delete":
                toastr.success(data.split("|")[1])
                $("#item_" + id).hide();
                break;
            case "edit":
			      toastr.success(data.split("|")[1])
            window.setTimeout(tourl(id),2000); 
                break;
            case "mail":
            toastr.success(data.split("|")[1])
            break;
            }
        }else{
            toastr.error(data.split("|")[1])
        }
    }
    });
}

function tourl(str){
  window.location=str;
}
toastr.options = {
  "closeButton": false,
  "debug": false,
  "positionClass": "toast-bottom-right",
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "3000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}