      <!-- Pay Form -->
      <div class="card shadow-dark radius-border">
        <div class="card-body p-0 text-center pt-4">

            <img src="assets/img/tw.png" style="width: 15%;" class="mb-4 pr-4 border-right">
            <img src="assets/img/wallet-logo.png" style="width: 40%;" class="mb-4 pl-4">
            </p>

            <h4>ใส่ลิ้งซองของขวัญ</h4>
            <h6>คงเหลือ <?= $points; ?> Points</h6>
            <input type="text" id="ref" class="text-center form-control form-control-sm hyper-form-control ml-auto mr-auto" placeholder="กรอกลิ้งซองอั่งเปา" style="max-width:350px;width:80%;border: 1px solid #343a40;" autocomplete="off">
            <small id="giftlinkHelp" class="form-text" style="opacity: 0.7;">ตัวอย่างลิ้ง : https://gift.truemoney.com/campaign/?v=cofi9...</small>
            <button onclick="Pay()" type="button" class="btn btn-sm hyper-btn-success mt-3 ml-auto mr-auto w-100 mb-3" style="max-width:350px;"><i class="far fa-check-circle pr-1 pt-1"></i> ตรวจสอบการทำรายการ</button></br>
            <small style="opacity: 0.7;">Truewallet Gift API By <a href="https://www.facebook.com/pagehyperstudio" class="text-sky" target="_blank" >Hyper Studio</a>.</small>
            <div class="mt-4"></div>
      </div>
      </div>
      <!-- End Pay Form -->

      <script>
      /** Pay */
      function Pay() {
      var  ref = $("#ref").val();
      swal({
            title: 'คุณต้องการทำรายการ',
            text: "ลิ้งซองของขวัญ\n"+ref,
            icon: "info",
            buttons: {
            confirm : {text:'ทำรายการ',className:'hyper-btn-notoutline-success'},
            cancel : 'ยกเลิก'
            },
            closeOnClickOutside:false,
      })
      .then((willDelete) => {
            if (willDelete) {
            $.ajax({

            type: "POST",
            url: "plugin/transaction.php",
            dataType: "json",
            data: {ref:ref},

            beforeSend: function() {
            swal("กำลังตรวจสอบรายการ กรุณารอสักครู่...",{button:false,closeOnClickOutside:false,timer:5000,});

            },

            success : function(data){
            setTimeout(function() {
                  if (data.code == "200"){
                  swal("ทำรายการ สำเร็จ!", "ระบบกำลังพาท่านไป...", "success",{button:false,closeOnClickOutside:false,});
                  setTimeout(function(){ window.location.reload();}, 2000);
                  } else {
                  swal(data.msg ,"" ,"error",{button:{className:'hyper-btn-notoutline-danger',},closeOnClickOutside:false,});
                  }
            }, 2000);
            }

            });
            }
      });
      }
      </script>