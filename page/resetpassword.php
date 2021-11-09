      <!-- Setpassword Form -->
      <div class="card mt-4 shadow-dark radius-border hyper-bg-white ml-auto mr-auto" style="max-width:500px;">
      <div class="card-body">
        <h4 class="mt-0 mb-4 text-center"><i class="fal fa-key mr-2"></i>เปลี่ยนรหัสผ่าน</h4>
          
        <form method="POST">
        <div class="input-group mb-4">
          <div class="input-group-prepend">
            <span class="input-group-text hyper-bg-dark border-dark"><i class="fal fa-envelope"></i></span>
          </div>
          <input id="email" type="email" class="form-control form-control-sm hyper-form-control" placeholder="E-mail ( อีเมล )" autocomplete="off" required>
        </div>

        <div class="input-group mb-4">
          <div class="input-group-prepend">
            <span class="input-group-text hyper-bg-dark border-dark"><i class="fal fa-key"></i></span>
          </div>
          <input id="new_password" type="password" class="form-control form-control-sm hyper-form-control" placeholder="NewPassword ( รหัสผ่านใหม่ )" required>
        </div>

        <div class="input-group mb-4">
          <div class="input-group-prepend">
            <span class="input-group-text hyper-bg-dark border-dark"><i class="fal fa-key"></i></span>
          </div>
          <input id="cnew_password" type="password" class="form-control form-control-sm hyper-form-control" placeholder="Confirm-NewPassword ( ยืนยัน-รหัสผ่านใหม่ )" required>
        </div>

        <center><button id="resetpassword" class="btn btn-sm hyper-btn-orange w-100" type="submit"><i class="fal fa-key mr-1"></i> เปลี่ยนรหัสผ่าน</button></center>
        </form>
      </div>
      </div>
      <!-- End Setpassword Form -->

      <script>
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
      </script>