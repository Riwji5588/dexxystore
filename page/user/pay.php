      <!-- Pay Form -->
      <div class="card color radius-border">
            <div class="card-body p-0 text-center pt-4">

                  <img src="assets/img/tw.png" style="width: 15%;" class="mb-4 pr-4 border-right">
                  <img src="assets/img/wallet-logo.png" style="width: 40%;" class="mb-4 pl-4">
                  </p>

                  <h3 class="text-color m-3 " style="color: #ffb700" ;>ระบบเติมเงินอัตโนมัติ 24 ชม. ผ่านทรูวอลเลต</h3>
                  <h6 class="text-color m-1">หากสนใจเติมเงินผ่านธนาคาร <br>โปรดแจ้งสลิปทางไลน์ร้าน</h6>
                  <h5 class="text-color m-4"><br></h5>


                  <input type="text" id="ref" class="text-center form-control form-control-sm hyper-form-control ml-auto mr-auto" placeholder="กรอกลิ้งซองอั่งเปา" style="max-width:350px;width:80%;border: 1px solid #343a40;" autocomplete="off">
                  <small id="giftlinkHelp" class="form-text text-color" style="opacity: 0.7;">ตัวอย่างลิ้ง : https://gift.truemoney.com/campaign/?v=cofi9...</small>
                  <h3 class="text-color m-4">ใส่ลิ้งซองของขวัญ</h3>
                  <div class="form-group mt-5">
                        <div class="row justify-content-center">
                              <div class="col-12 col-md-4">
                                    <button type="button" class="btn btn-sm hyper-btn-orange my-2 my-sm-0 mr-2 w-100" data-toggle="modal" data-target="#sub" style="max-width:350px;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z" />
                                          </svg>&nbsp; วิธีการเติมเงิน</button>
                              </div>
                              <div class="col-12 col-md-4">
                                    <button onclick="Pay()" type="button" class="btn btn-sm hyper-btn-success my-2 my-sm-0 mr-2 w-100" style="max-width:350px;"><i class="far fa-check-circle pr-1 pt-1"></i> ตรวจสอบการทำรายการ</button></br>
                              </div>
                        </div>
                  </div>

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
                                                      timer: 500,
                                                });

                                          },

                                          success: function(data) {
                                                if (data.code == "200") {
                                                      swal("ทำรายการ สำเร็จ!", "ระบบกำลังพาท่านไป...", "success", {
                                                            button: false,
                                                            closeOnClickOutside: false,
                                                      });
                                                      setTimeout(function() {
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
                                                <div class="carousel-inner" align="center">
                                                      <div class="carousel-item active" align="center">
                                                            <img src="assets/img/pay1.png" class="d-block w-100 carousel" alt="...">
                                                      </div>
                                                      <div class="carousel-item" align="center">
                                                            <img src="assets/img/pay2.png" class="d-block w-100 carousel" alt="...">
                                                      </div>
                                                      <div class="carousel-item" align="center">
                                                            <img src="assets/img/pay3.png" class="d-block w-100 carousel" alt="...">
                                                      </div>
                                                      <div class="carousel-item" align="center">
                                                            <img src="assets/img/pay4.png" class="d-block w-100 carousel" alt="...">
                                                      </div>
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-target="#insub" data-slide="prev">
                                                      <span class="carousel-control-prev-icon color-icon" aria-hidden="true"></span>
                                                      <span class="sr-only">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-target="#insub" data-slide="next">
                                                      <span class="carousel-control-next-icon color-icon" aria-hidden="true"></span>
                                                      <span class="sr-only color-icon">Next</span>
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

            .edit {
                  color: white;

            }

            .color-icon {
                  width: 60%;
                  height: 5%;

                  background-color: #000;
                  border-radius: 50%;
            }
      </style>