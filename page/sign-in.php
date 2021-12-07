      <!-- Sign-in Form -->
      <div class="card mt-4 shadow-dark radius-border hyper-bg-white ml-auto mr-auto" style="max-width:500px;">
        <div class="card-body">
          <h4 class="mt-0 mb-4 text-center"><i class="fas fa-sign-in-alt mr-2"></i>เข้าสู่ระบบ</h4>
          
          <form method="POST">
          <div class="input-group mb-4">
            <div class="input-group-prepend">
              <span class="input-group-text hyper-bg-dark border-dark"><i class="fal fa-user"></i></span>
            </div>
            <input id="username" type="text" maxlength="16" class="form-control form-control-sm hyper-form-control" placeholder="Username ( ชื่อผู้ใช้งาน )" required>
          </div>

          <div class="input-group mb-4">
            <div class="input-group-prepend">
              <span class="input-group-text hyper-bg-dark border-dark"><i class="fal fa-key"></i></span>
            </div>
            <input id="password" type="password" maxlength="16" class="form-control form-control-sm hyper-form-control" placeholder="Password ( รหัสผ่าน )" required>
          </div>

          <a href="resetpassword"><div class="float-right mb-2" style="font-size: 0.9rem;">ลืมรหัสผ่าน ?</div></a>

          <button id="signin" class="btn btn-sm hyper-btn-success my-2 my-sm-0 mr-2 w-100" type="submit"><i class="fal fa-sign-in-alt mr-1"></i> เข้าสู่ระบบ</button>
          </form>

        </div>
      </div>
      <!-- End Sign-in Form -->


      <script>
      /* Sign-In script */
      $('#signin').click(function(signin){
        signin.preventDefault();
      
        var username = $("#username").val();
        var password = $("#password").val();
        $.ajax({
      
              type: "POST",
              url: "plugin/login.php",
              dataType: "json",
              data: {username:username,password:password},
      
              beforeSend: function() {
              swal("กำลังตรวจสอบข้อมูล กรุณารอสักครู่...",{button:false,closeOnClickOutside:false,timer:1900,});
      
              },
      
              success : function(data){
              setTimeout(function() {
                  if (data.code == "200"){
                      swal("เข้าสู่ระบบ สำเร็จ!", "ระบบกำลังพาท่านไป...", "success",{button:false,closeOnClickOutside:false,});
                      setTimeout(function(){ window.location.reload(); window.location.reload() }, 2000);
                  } else {
                      swal(data.msg ,"" ,"error",{button:{className:'hyper-btn-notoutline-danger',},closeOnClickOutside:false,});
                  }
              }, 2000);
              }
      
        });
      
        });
      </script>
      <style>
        .btn {
          color : black;
        }
      </style>