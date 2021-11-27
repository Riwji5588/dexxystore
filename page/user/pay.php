      <!-- Pay Form -->
      <div class="card color radius-border">
            <div class="card-body p-0 text-center pt-4">

                  <img src="assets/img/tw.png" style="width: 15%;" class="mb-4 pr-4 border-right">
                  <img src="assets/img/wallet-logo.png" style="width: 40%;" class="mb-4 pl-4">
                  </p>

                  <h4 class="text-color">ใส่ลิ้งซองของขวัญ</h4>
                  <h6 class="text-color">คงเหลือ <?= $points; ?> บาท</h6>
                  <input type="text" id="ref" class="text-center form-control form-control-sm hyper-form-control ml-auto mr-auto" placeholder="กรอกลิ้งซองอั่งเปา" style="max-width:350px;width:80%;border: 1px solid #343a40;" autocomplete="off">
                  <small id="giftlinkHelp" class="form-text text-color" style="opacity: 0.7;">ตัวอย่างลิ้ง : https://gift.truemoney.com/campaign/?v=cofi9...</small>
                  <button type="button" class="btn btn-sm edit" data-toggle="modal" data-target="#sub">วิธีการเติมเงิน</button><br>
                  <button onclick="Pay()" type="button" class="btn btn-sm hyper-btn-success mt-3 ml-auto mr-auto w-100 mb-3" style="max-width:350px;"><i class="far fa-check-circle pr-1 pt-1"></i> ตรวจสอบการทำรายการ</button></br>

                  <div class="mt-4"></div>
            </div>
      </div>
      <!-- End Pay Form -->

      <script>
            /** Pay */
            function Pay() {
                  var ref = $("#ref").val();
                  swal({
                              title: 'คุณต้องการทำรายการ',
                              text: "ลิ้งซองของขวัญ\n" + ref,
                              icon: "info",
                              buttons: {
                                    confirm: {
                                          text: 'ทำรายการ',
                                          className: 'hyper-btn-notoutline-success'
                                    },
                                    cancel: 'ยกเลิก'
                              },
                              closeOnClickOutside: false,
                        })
                        .then((willDelete) => {
                              if (willDelete) {
                                    $.ajax({

                                          type: "POST",
                                          url: "plugin/transaction.php",
                                          dataType: "json",
                                          data: {
                                                ref: ref
                                          },

                                          beforeSend: function() {
                                                swal("กำลังตรวจสอบรายการ กรุณารอสักครู่...", {
                                                      button: false,
                                                      closeOnClickOutside: false,
                                                      timer: 5000,
                                                });

                                          },

                                          success: function(data) {
                                                setTimeout(function() {
                                                      if (data.code == "200") {
                                                            swal("ทำรายการ สำเร็จ!", "ระบบกำลังพาท่านไป...", "success", {
                                                                  button: false,
                                                                  closeOnClickOutside: false,
                                                            });
                                                            setTimeout(function() {
                                                                  window.location.reload();
                                                            }, 2000);
                                                      } else {
                                                            swal(data.msg, "", "error", {
                                                                  button: {
                                                                        className: 'hyper-btn-notoutline-danger',
                                                                  },
                                                                  closeOnClickOutside: false,
                                                            });
                                                      }
                                                }, 2000);
                                          }

                                    });
                              }
                        });
            }
      </script>
      <!-- sub modal -->
      <div class="modal fade" id="sub" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                        <div class="modal-body">
                              <div class="row">
                                    <div class="col-12">
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                          </button>
                                    </div>
                                    <br>
                                    <div class="col-12">
                                          <div id="insub" class="carousel slide" data-ride="carousel" style="padding: 10px;">
                                                <ol class="carousel-indicators">
                                                      <li data-target="#insub" data-slide-to="0" class="active"></li>
                                                      <li data-target="#insub" data-slide-to="1"></li>
                                                      <li data-target="#insub" data-slide-to="2"></li>
                                                </ol>
                                                <div class="carousel-inner">
                                                      <div class="carousel-item active">
                                                            <img src="assets/img/pay1.png" class="d-block w-100" alt="...">
                                                      </div>
                                                      <div class="carousel-item">
                                                            <img src="assets/img/pay2.png" class="d-block w-100" alt="...">
                                                      </div>
                                                      <div class="carousel-item">
                                                            <img src="assets/img/pay3.png" class="d-block w-100" alt="...">
                                                      </div>
                                                      <div class="carousel-item">
                                                            <img src="assets/img/pay4.png" class="d-block w-100" alt="...">
                                                      </div>
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-target="#insub" data-slide="prev">
                                                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                      <span class="sr-only">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-target="#insub" data-slide="next">
                                                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                      <span class="sr-only">Next</span>
                                                </button>
                                          </div>
                                    </div>
                              </div>

                        </div>
                        <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal" style> ปิด</button>
                        </div>
                  </div>
            </div>
      </div>
      <style>
            body {
                  background-color: #131315;
            }

            .color {
                  background-color: #131315;
            }

            .text-color {
                  color: white;
            }
            .edit{ 
                  color: white;
            }
      </style>