/* Encode File name script.bd0k1hg.js */

/* Resetpassword script */
$('#resetpassword').click(function(resetpassword){
resetpassword.preventDefault();

var email = $("#email").val();
var new_password = $("#new_password").val();
var cnew_password = $("#cnew_password").val();
$.ajax({

        type: "POST",
        url: "plugin/resetpassword.php",
        dataType: "json",
        data: {email:email,new_password:new_password,cnew_password:cnew_password},

        beforeSend: function() {
        swal("กำลังบันทึกข้อมูล กรุณารอสักครู่...",{button:false,closeOnClickOutside:false,timer:1900,});

        },

        success : function(data){
        setTimeout(function() {
            if (data.code == "200"){
                swal("เปลี่ยนรหัสผ่าน สำเร็จ!", "ระบบกำลังพาท่านไป...", "success",{button:false,closeOnClickOutside:false,});
                setTimeout(function(){ window.location.href="logout";}, 2000);
            } else {
                swal(data.msg ,"" ,"error",{button:{className:'hyper-btn-notoutline-danger',},closeOnClickOutside:false,});
            }
        }, 2000);
        }

});

});