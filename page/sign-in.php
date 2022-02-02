 <?php
  if (isset($_SESSION['USER_SID'])) {
  ?>
   <script>
     window.location.href = '/';
   </script>
 <?php
  }

  ?>

 <!-- Sign-in Form -->
 <div class="card mt-4 shadow-dark radius-border hyper-bg-white ml-auto mr-auto" style="max-width:500px;">
   <div class="card-body">
     <h4 class="mt-0 mb-4 text-center"><i class="fas fa-sign-in-alt mr-2"></i>เข้าสู่ระบบ</h4>

     <form method="POST" id="login">
       <div class="input-group mb-4">
         <div class="input-group-prepend">
           <span class="input-group-text hyper-bg-dark border-dark"><i class="fal fa-user"></i></span>
         </div>
         <input value="" id="username" type="text" maxlength="16" class="form-control form-control-sm hyper-form-control" placeholder="Username ( ชื่อผู้ใช้งาน )" required>
       </div>

       <div class="input-group mb-4">
         <div class="input-group-prepend">
           <span class="input-group-text hyper-bg-dark border-dark"><i class="fal fa-key"></i></span>
         </div>
         <input value="" id="password" type="password" maxlength="16" class="form-control form-control-sm hyper-form-control" placeholder="Password ( รหัสผ่าน )" required>
       </div>

       <div class="float-left  mt-3 mb-2">
         <input type="checkbox" name="remember" id="reme"><span onclick="$('#reme').click()" style="cursor: default;">&nbsp;&nbsp;จดจำฉันไว้</span>
       </div>
       <a href="resetpassword">
         <div class="float-right mt-3 mb-2" style="font-size: 0.9rem;"> ลืมรหัสผ่าน ?</div>
       </a>
       <button id="signin" class="btn btn-sm hyper-btn-success my-2 my-sm-0 mr-2 w-100" type="submit"><i class="fal fa-sign-in-alt mr-1"></i> เข้าสู่ระบบ</button>

     </form>

   </div>
 </div>
 <!-- End Sign-in Form -->


 <script>
   $(document).ready(() => {

     const isremember = localStorage.getItem('remember');
     if (isremember == 'true') {
        $('#username').val(localStorage.getItem('username'));
        $('#password').val(atob(localStorage.getItem('password')));
        $('#reme').prop('checked', true);
     }
   })
   /* Sign-In script */
   $('#signin').click(function(signin) {
     signin.preventDefault();

     var username = $("#username").val();
     var password = $("#password").val();
     var remember = $('#reme').is(':checked') ? 'checked' : '';
     $.ajax({

       type: "POST",
       url: "plugin/login.php",
       dataType: "json",
       data: {
         username: username,
         password: password,
         remember: remember,
       },

       beforeSend: function() {
         swal("กำลังตรวจสอบข้อมูล กรุณารอสักครู่...", {
           button: false,
           closeOnClickOutside: false,
           timer: 500,
         });

       },

       success: function(data) {
         setTimeout(() => {
           if (data.code == "200") {
             swal("เข้าสู่ระบบ สำเร็จ!", "ระบบกำลังพาท่านไป...", "success", {
               button: false,
               closeOnClickOutside: false,
             });
             if (remember == 'checked') {
               window.localStorage.setItem('username', username);
               window.localStorage.setItem('password', btoa(password));
               window.localStorage.setItem('remember', true);
             } else {
               window.localStorage.removeItem('username');
               window.localStorage.removeItem('password');
               window.localStorage.removeItem('remember');
             }
             setTimeout(function() {
               console.log(data.remember);
               window.location.reload();
             }, 1500);
           } else {
             swal(data.msg, "", "error", {
               button: {
                 className: 'hyper-btn-notoutline-danger',
               },
               closeOnClickOutside: false,
             });
           }
         }, 600);
       }

     });

   });
 </script>
 <style>
   .btn {
     color: black;
   }
 </style>