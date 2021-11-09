      <!-- Sign-up Form -->
      <div class="card mt-4 shadow-dark radius-border hyper-bg-white ml-auto mr-auto" style="max-width:500px;">
        <div class="card-body">
          <h4 class="mt-0 mb-4 text-center"><i class="fal fa-user-plus mr-2"></i>สมัครสมาชิก</h4>
          
          <form method="POST">
          <div class="input-group mb-4">
            <div class="input-group-prepend">
              <span class="input-group-text hyper-bg-dark border-dark"><i class="fal fa-user"></i></span>
            </div>
            <input id="username" maxlength="16" type="text" class="form-control form-control-sm hyper-form-control" placeholder="Username ( ชื่อผู้ใช้งาน )" required autocomplete="off">
          </div>

          <div class="input-group mb-4">
            <div class="input-group-prepend">
              <span class="input-group-text hyper-bg-dark border-dark"><i class="fal fa-key"></i></span>
            </div>
            <input id="password" maxlength="16" type="password" class="form-control form-control-sm hyper-form-control" placeholder="Password ( รหัสผ่าน )" required autocomplete="off">
          </div>

          <div class="input-group mb-4">
            <div class="input-group-prepend">
              <span class="input-group-text hyper-bg-dark border-dark"><i class="fal fa-key"></i></span>
            </div>
            <input id="c_password" maxlength="16" type="password" class="form-control form-control-sm hyper-form-control" placeholder="Confirm-Password ( ยืนยัน-รหัสผ่าน )" required autocomplete="off">
          </div>

          <div class="input-group mb-4">
            <div class="input-group-prepend">
              <span class="input-group-text hyper-bg-dark border-dark"><i class="fal fa-envelope"></i></span>
            </div>
            <input id="email" type="email" class="form-control form-control-sm hyper-form-control" placeholder="E-mail ( อีเมล )" required>
          </div>

          <button id="signup" class="btn btn-sm hyper-btn-orange my-2 my-sm-0 mr-2 w-100" type="button"><i class="fal fa-user-plus mr-1"></i> สมัครสมาชิก</button>
          </form>

        </div>
      </div>
      <!-- End Sign-up Form -->

      <script>
      /* Sign-Up script */
      $('#signup').click(function(signup){
        signup.preventDefault();
      
        var username = $("#username").val();
        var password = $("#password").val();
        var cpassword = $("#c_password").val();
        var email = $("#email").val();

        $.ajax({
      
              type: "POST",
              url: "plugin/register.php",
              dataType: "json",
              data: {username:username,password:password,cpassword:cpassword,email:email},
      
              beforeSend: function() {
              swal("กำลังบันทึกข้อมูล กรุณารอสักครู่...",{button:false,closeOnClickOutside:false,timer:1900,});
      
              },
      
              success : function(data){
              setTimeout(function() {
                  if (data.code == "200"){
                      swal("สมัครสมาชิก สำเร็จ!", "ระบบกำลังพาท่านไป...", "success",{button:false,closeOnClickOutside:false,});
                      setTimeout(function(){ window.location.href="login";}, 2000);
                  } else {
                      swal(data.msg ,"" ,"error",{button:{className:'hyper-btn-notoutline-danger',},closeOnClickOutside:false,});
                  }
              }, 2000);
              }
      
        });
      
      });
      </script>