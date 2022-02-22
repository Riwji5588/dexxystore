      <!-- Data Owner -->
      <h3 class="text-center mt-4 mb-4" style="color: white;">--- ID Netflixถูกจำหน่ายแล้ว ---</h3>
      <div class="row">
        <div class="col-12 col-md-6">
          <div class="form-group">
            <div class="btn btn-success w-100" onclick="dosomething('active')">
              ไอดียังไม่หมดประกัน
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="form-group">
            <div class="btn btn-danger w-100" onclick="dosomething('expired')">
              ไอดีหมดประกันแล้ว
            </div>
          </div>
        </div>
      </div>
      <div id="active" class="mt-3">
        <table id="myTable" class="table table-hover text-center w-100">
          <thead class="hyper-bg-dark">
            <tr>
              <th scope="col" style="width:100px;">ออเดอร์ที่</th>
              <th scope="col">สินค้า</th>
              <th scope="col">บัญชีผู้ใช้</th>
              <th scope="col">เจ้าของ</th>
              <th scope="col">จำนวนการเคลม</th>
              <th scope="col">วันที่ซื้อ</th>
              <th scope="col">สถานะ</th>
              <th scope="col" style="width: 200px;">เมนู</th>
            </tr>
          </thead>
          <tbody id="body">
          </tbody>
        </table>
        <div id="loading" class="container" style="color: #FFF;" align="center">
          <div class="spinner-border" role="status">
          </div>
        </div>
      </div>

      <div id="expired" class="mt-3">
        <table id="myTable1" class="table table-hover text-center w-100">
          <thead class="hyper-bg-dark">
            <tr>
              <th scope="col" style="width:100px;">ออเดอร์ที่</th>
              <th scope="col">สินค้า</th>
              <th scope="col">บัญชีผู้ใช้</th>
              <th scope="col">เจ้าของ</th>
              <th scope="col">จำนวนการเคลม</th>
              <th scope="col">วันที่ซื้อ</th>
              <th scope="col">สถานะ</th>
              <th scope="col" style="width: 200px;">เมนู</th>
            </tr>
          </thead>
          <tbody id="body1">
          </tbody>
        </table>
        <div id="loading1" class="container" style="color: #FFF;" align="center">
          <div class="spinner-border" role="status">
          </div>
        </div>
      </div>


      <!-- End Data Owner  -->
      <script>
        const isSandbox = window.location.origin == "https://sandbox.dexystore.me";
        const host = window.location.origin == "http://localhost" ? "http://localhost/dexystore" : isSandbox ? "https://sandbox.dexystore.me" : "https://dexystore.me";
        const url = host + '/plugin/getDataowner.php';
        let active = false;
        let isexpired = window.location.href.slice(window.location.href.indexOf('&') + 1).split('=')[1] == 'true' ? true : false;
        if (isexpired) {
          active = false;
        } else {
          active = true;
        }
        $(document).ready(async () => {
          $('#result').hide();
          if (active) {
            $('#active').show();
            $('#expired').hide();
            getData();
          } else {
            $('#active').hide();
            $('#expired').show();
            getData(1);
          }
        })

        function dosomething(type) {
          if (type == 'active') {
            if (!isexpired) {
              $('#active').show();
              $('#expired').hide();
              active = true;
              getData();
            } else {
              window.open('./dataowner', '_blank');
            }
          } else if (type == 'expired') {
            if (isexpired) {
              $('#active').hide();
              $('#expired').show();
              active = false;
              getData(1);
            } else {
              window.open('./dataowner?expired=true', '_blank');
            }
          } else {
            console.log('don\'t have type');
          }
        }

        function getData(exp = 0) {
          $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            data: {
              action: 'getdataowner',
              exp: exp
            },
            success: function(json) {
              if (json.code == 200) {
                let body = '';
                const data1 = json.data;
                for (let i = 0; i < data1.length; i++) {
                  let data = data1[i];
                  body +=
                    `
                      <tr id="row${data.selled_id}">
                        <td>${data.selled_id}</td>
                        <td>${data.card_id == null ? 'Unknow' : data.card_title+"-"+data.card_price}</td>
                        <td>${data.selled_data_username}</td>
                        <td>${data.account_username}</td>
                        <td>${data.claim_count}</td>
                        <td>${data.selled_date}</td>
                        <td>${data.expire < 1 ? "หมดประกัน" : "ยังไม่หมดประกัน"}</td>
                        <td width="100px">
                            <button class="btn btn-sm hyper-btn-notoutline-success" type="button" data-toggle="modal" data-target="#editownermodal${data.selled_data_id}" onclick="LodingModal(${data.selled_data_id})"><i class="fal fa-info-circle mr-1"></i> เพิ่มเติม</button>
                            <button onclick="DelData(this)" value="${data.selled_id}" class="btn btn-sm hyper-btn-notoutline-danger my-1 mt-0" type="button"><i class="fal fa-trash-alt mr-1"></i> ลบ</button>
                        </td>
                      </tr>
                    `;
                }
                let checkisactive = document.getElementById('row' + json.data[0].selled_id) != null;
                if (!checkisactive) {
                  if (active) {
                    $('#body').html(body);
                    $('#myTable').DataTable();
                    $('#loading').hide();
                  } else {
                    $('#body1').html(body);
                    $('#myTable1').DataTable();
                    $('#loading1').hide();
                  }
                  console.log('added');
                } else {
                  console.log('already have');
                }

              } else {
                console.log(json.message);
              }
            },
            error: function(data) {
              console.log(data.responseText);
              $('#myTable').DataTable();
              html =
                `
                <tr>
                    <td colspan="7">ไม่มีข้อมูลในขณะนี้</td>
                </tr>
                `
              $('#body').html(html);
              $('#loading').remove();
            }
          });
        }

        function LodingModal(dataid) {
          $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            data: {
              action: 'getmodal',
              dataid: dataid
            },
            success: function(json) {
              if (json.code == 200) {
                let modal = '';
                const data1 = json.data;

                for (let i = 0; i < data1.length; i++) {
                  let data = data1[i];
                  let password = decodeURIComponent(escape(window.atob(data.selled_data_password)));
                  modal += `
                            <!-- Edit Game Data Modal -->
                            <div class="modal fade" id="editownermodal${data.selled_data_id}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered ">
                                <div class="modal-content border-0 radius-border-2 hyper-bg-white">
                                  <div class="modal-header hyper-bg-dark">
                                    <h6 class="modal-title"><i class="fal fa-info-circle mr-1"></i></i> ข้อมูล</h6>
                                  </div>
                                  <div class="modal-body text-center p-1">

                                    <form method="POST" enctype="multipart/form-data">

                                    <img src="assets/img/item/${data.card_img}" width="99px" height="99px" class="ml-auto mr-auto mb-2" style="border-radius: 50%"></br>
                                    <font class="text-muted">${data.card_id == null ? 'Unknow' : data.card_title+" - "+data.card_price}</font>
                                    <div class="container-fluid px-5">
                                      <div class="row" style="padding: 5px 2px 0px 2px;text-align: left !important;">
                                        <div class="col-3 pr-0">
                                            <span>ชื่อผู้ใช้งาน</span>
                                        </div>
                                        <div class="col-9 p-0">
                                          <input type="text" id="username${data.selled_data_id}" value="${data.selled_data_username}" onkeyup="revalue(${data.selled_data_id})" style="background-color: #fff;border-radius: 0px;border: 0px">
                                          <button style="margin-left: -25px;" class="btn btn-dark btn-sm" type="button" onclick="copy(this,'username${data.selled_data_id}')"><i class='far fa-copy'></i> คัดลอก</button>
                                        </div>
                                      </div> 
                                      
                                      <div class="row" style="padding: 5px 2px 0px 2px;text-align: left !important;">
                                        <div class="col-3 pr-0">
                                            <span>รหัสผ่าน</span>
                                        </div>
                                        <div class="col-9 p-0">
                                            <input type="text" id="password${data.selled_data_id}" value="${password}" onkeyup="revalue(${data.selled_data_id})" style="background-color: #fff;border-radius: 0px;border: 0px">
                                            <button style="margin-left: -25px;" class="btn btn-dark btn-sm" type="button" onclick="copy(this,'password${data.selled_data_id}')"><i class='far fa-copy'></i> คัดลอก</button>
                                        </div>
                                      </div> 

                                      <div class="row" style="padding: 5px 2px 0px 2px;text-align: left !important;">
                                        <div class="col-3 pr-0">
                                            <span>จอ</span>
                                        </div>
                                        <div class="col-9 p-0">
                                            <input type="text" id="display${data.selled_data_id}" value="${data.selled_data_display}" onkeyup="revalue(${data.selled_data_id})" style="background-color: #fff;border-radius: 0px;border: 0px">
                                        </div>
                                      </div> 

                                      <div class="row" style="padding: 5px 2px 0px 2px;text-align: left !important;">
                                        <div class="col-3 pr-0">
                                            <span>วันหมดประกัน</span>
                                        </div>
                                        <div class="col-9 p-0">
                                            <input type="text" id="exp${data.selled_data_id}" value="${data.expire}" readonly style="background-color: #fff;border-radius: 0px;border: 0px">
                                        </div>
                                      </div> 
                                    </div>

                                    

                                      <button type="submit" id="updatedata${data.selled_data_id}" class="d-none"></button>
                                    </form>
                                    
                                    <input type="hidden" id="copy${data.selled_data_id}" value="${data.selled_data_username+":"+password+":"+data.selled_data_display}">
                                  </div>
                                  <div class="modal-footer p-2 border-0">
                                    <button type="button" class="btn btn-danger btn-sm mx-2" onclick="DelData(this)" value="${data.selled_id}"><i class="fal fa-trash-alt mr-1"></i> ลบข้อมูล</button>
                                    <a class="btn btn-warning btn-sm mx-2" href="./orderlog&order=${data.selled_id}" target="_blank"><i class="fas fa-external-link-alt"></i> ข้อมูลเพิ่มเติม</a>
                                    <button type="button" class="btn btn-dark btn-sm mx-2" onclick="copyfile(this,${data.selled_data_id})"><i class="far fa-copy"></i> คัดลอก</button>
                                    <button type="button" class="btn btn-success btn-sm mx-2" onclick="updatedata(${data.selled_data_id})"><i class="far fa-plus-square"></i> อัพเดทข้อมูล</button>
                                    <button type="button" class="btn btn-secondary btn-sm mx-2" data-dismiss="modal"><i class="fad fa-times-circle mr-1"></i> ปิด</button>
                                </div>
                              </div>
                            </div>
                            <!-- End Edit Game Data Modal -->
                          `;
                }

                let checkmodal = $(`#editownermodal${data1[0].selled_data_id}`).html() != undefined

                if (!checkmodal) {
                  $('body').append(modal)
                  console.log('added')
                } else {
                  console.log('already added')
                }

              } else {
                console.log(json.message)
              }
            },
            error: function(data) {
              console.log(data.responseText);
              console.log('error')
            }
          });
        }

        function copyfile(input, dataid) {
          let copyText = document.getElementById(`copy${dataid}`);
          copyText.type = "text";
          copyText.select();
          copyText.setSelectionRange(0, 99999)
          document.execCommand("copy");
          copyText.type = "hidden";
          input.innerHTML = "<i class='far fa-copy'></i> คัดลอกแล้ว";
          input.className = "btn btn-success btn-sm mx-2";
          setTimeout(function() {
            input.innerHTML = "<i class='far fa-copy'></i> คัดลอก";
            input.className = "btn btn-dark btn-sm mx-2";
          }, 1000);
        }

        function copy(input, id) {
          var copyText = document.getElementById(id);
          copyText.select();
          copyText.setSelectionRange(0, 99999)
          document.execCommand("copy");
          input.innerHTML = "<i class='far fa-copy'></i> คัดลอกแล้ว";
          input.className = "btn btn-success btn-sm";
          setTimeout(function() {
            input.innerHTML = "<i class='far fa-copy'></i> คัดลอก";
            input.className = "btn btn-dark btn-sm";
          }, 2000);
        }

        /** Delete Data */
        function DelData(id) {
          var id = id.value;
          swal({
              title: 'ต้องการลบข้อมูลที่ ' + id,
              text: "ถ้าลบแล้วจำไม่สามารถกู้กลับมาได้",
              icon: "warning",
              buttons: {
                confirm: {
                  text: 'ลบข้อมูล',
                  className: 'hyper-btn-notoutline-danger'
                },
                cancel: 'ยกเลิก'
              },
              closeOnClickOutside: false,
            })
            .then((willDelete) => {
              if (willDelete) {
                $.ajax({

                  type: "POST",
                  url: "plugin/del_owner_data.php",
                  dataType: "json",
                  data: {
                    id: id
                  },

                  beforeSend: function() {
                    swal("กำลังลบข้อมูล กรุณารอสักครู่...", {
                      button: false,
                      closeOnClickOutside: false,
                      timer: 500,
                    });

                  },

                  success: function(data) {
                    setTimeout(() => {
                      if (data.code == "200") {
                        swal("ลบข้อมูล สำเร็จ!", "ระบบกำลังพาท่านไป...", "success", {
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
                    }, 600);

                  }

                });
              }
            });
        }

        function revalue(data_id) {
          $('#copy' + data_id).val($('#username' + data_id).val() + ":" + $('#password' + data_id).val() + ":" + $('#display' + data_id).val());
        }

        /** Update Data */
        function updatedata(id) {

          $("#updatedata" + id).submit();

          $("#updatedata" + id).submit(function(updateData) {
            updateData.preventDefault();

            swal({
                title: 'ต้องการอัพเดทข้อมูล',
                text: "คุณต้องการอัพเดทข้อมูลใช่หรือไม่",
                icon: "info",
                buttons: {
                  confirm: {
                    text: 'อัพเดท',
                    className: 'hyper-btn-notoutline-success'
                  },
                  cancel: 'ยกเลิก'
                },
                closeOnClickOutside: false,
              })
              .then((willDelete) => {
                if (willDelete) {

                  var updatedata = new FormData();
                  var did = id;
                  var username = $('#username' + id).val();
                  var password = $('#password' + id).val();
                  var detail = $('#detail' + id).val();
                  var display = $('#display' + id).val();

                  updatedata.append('data_id', did);
                  updatedata.append('username', username);
                  updatedata.append('password', password);
                  updatedata.append('detail', detail);
                  updatedata.append('display', display);

                  $.ajax({

                    type: "POST",
                    url: "plugin/edit_owner_data.php",
                    dataType: "json",
                    data: updatedata,
                    cache: false,
                    contentType: false,
                    processData: false,

                    beforeSend: function() {
                      swal("กำลังอัพเดทข้อมูล กรุณารอสักครู่...", {
                        button: false,
                        closeOnClickOutside: false,
                        timer: 500,
                      });

                    },

                    success: function(data) {
                      setTimeout(() => {
                        if (data.code == "200") {
                          swal("อัพเดทข้อมูล สำเร็จ!", "ระบบกำลังบันทึกข้อมูล...", "success", {
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
                      }, 600);
                    }

                  });

                }
              });

          });
        }
      </script>
      <style>
        body {
          background-color: #131315;
        }

        label {
          color: white;
        }

        #datatable_info {
          color: white;
        }

        .es:hover {
          background-color: white;
        }

        .table-hover:hover {
          background-color: #ddd;
        }
      </style>