      <!-- Data User -->
      <h3 class="text-center mt-4 mb-4" style="color: white ;">--- จัดการผู้ใช้งาน ---</h3>

      <div class="mt-3" id="loading" style="display: block;">
        <table id="myTable" class="table table-hover text-center w-100">
          <thead class="hyper-bg-dark">
            <tr>
              <th scope="col" style="width:120px;">เลขที่บัญชี</th>
              <th scope="col">บัญชีผู้ใช้</th>
              <th scope="col">บาท</th>
              <th scope="col">ระดับ</th>
              <th scope="col" style="width: 170px;">เมนู</th>
            </tr>
          </thead>
          <tbody id="body">
          </tbody>
        </table>
      </div>
      <!-- End User  -->

      <script>
        $(document).ready(async () => {
          let host = window.location.origin == "http://localhost" ? "http://localhost/dexxystore" : "https://dexystore.me";
          let url = host + '/plugin/getAll.php';
          const response = await fetch(url, {
            method: 'GET', // *GET, POST, PUT, DELETE, etc.
            mode: 'no-cors', // no-cors, *cors, same-origin
            credentials: 'same-origin', // include, *same-origin, omit
            headers: {
              'Content-Type': 'application/json'
              // 'Content-Type': 'application/x-www-form-urlencoded',
            },
          });
          const json = await response.json();
          if (json.code == 200) {
            const data = json.data;
            let body = $('#body').html();

            for (let i = 0; i < data.length; i++) {
              body += `
              <tr>
                <td>${data[i].ac_id}</td>
                <td>${data[i].username}</td>
                <td>${data[i].points}</td>
                <td>${data[i].role == 779 ? 'ผู้ดูแลระบบ' : 'ผู้ใช้งาน'}</td>
                <td>
                  <button class="btn btn-sm hyper-btn-notoutline-success" type="button" data-toggle="modal" data-target="#editusermodal${data[i].ac_id}"><i class="fal fa-edit mr-1"></i> แก้ไข</button>
                  <button onclick="DelUser(this)" value="${data[i].ac_id}" class="btn btn-sm hyper-btn-notoutline-danger my-1 my-sm-0" type="button"><i class="fal fa-trash-alt mr-1"></i> ลบ</button>

                  <!-- Edit Game Data Modal -->
                  <div class="modal fade" id="editusermodal${data[i].ac_id}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content border-0 radius-border-2 hyper-bg-white">
                        <div class="modal-header hyper-bg-dark">
                          <h6 class="modal-title"><i class="fal fa-plus-square mr-1"></i> อัพเดทข้อมูล</h6>
                        </div>
                        <div class="modal-body text-center">

                          <form method="POST" enctype="multipart/form-data">

                            <img src="assets/img/logoani_236x236.jpg" width="99px" class="img-fluid rounded-circle ml-auto mr-auto mb-2"></br>
                            <font class="text-muted">Username</font>
                            <h5><b>${data[i].username}</b></h5>

                            <div class="input-group input-group-sm mb-3 mt-4">
                              <div class="input-group-prepend">
                                <span class="input-group-text hyper-bg-dark border-dark">E-mail</span>
                              </div>
                              <input id="email${data[i].ac_id}" value="${data[i].email}" type="email" class="form-control form-control-sm hyper-form-control" placeholder="E-mail" required>
                            </div>

                            <div class="input-group input-group-sm mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text hyper-bg-dark border-dark">บาท</span>
                              </div>
                              <input id="point${data[i].ac_id}" value="${data[i].points}" type="number" class="form-control form-control-sm hyper-form-control" placeholder="Point" required>
                            </div>

                            <div class="input-group input-group-sm">
                              <div class="input-group-prepend">
                                <label class="input-group-text hyper-bg-dark border-dark" for="inputGroupSelect01">ระดับผู้ใช้งาน</label>
                              </div>
                              <select id="role${data[i].ac_id}" class="custom-select hyper-form-control" id="inputGroupSelect01">
                                <option ${data[i].role == 1 ? 'selected' : ''} value="1">ผู้ใช้งาน</option>
                                <option ${data[i].role == 779 ? 'selected' : ''} value="779">ผู้ดูแลระบบ</option>
                              </select>
                            </div>

                            <button type="submit" id="updatedata${data[i].ac_id}" class="d-none"></button>
                          </form>

                        </div>
                        <div class="modal-footer p-2 border-0">
                          <button type="button" onclick="updatedata('${data[i].ac_id}')" class="btn hyper-btn-notoutline-success"><i class="fal fa-plus-square mr-1"></i>อัพเดทข้อมูล</button>
                          <button type="button" class="btn hyper-btn-notoutline-danger" data-dismiss="modal"><i class="fad fa-times-circle mr-1"></i>ยกเลิก</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- End Edit Game Data Modal -->

                </td>
                </tr>
              `;
            }
            $('#body').html(body);
            $('#myTable').DataTable();
          }

        })
        /** Delete Data */
        function DelUser(id) {
          var id = id.value;
          swal({
              title: 'ต้องการลบผู้ใช้งานที่ ' + id,
              text: "ถ้าลบแล้วจำไม่สามารถกู้กลับมาได้",
              icon: "warning",
              buttons: {
                confirm: {
                  text: 'ลบผู้ใช้งาน',
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
                  url: "plugin/del_user.php",
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
                        swal("ลบผู้ใช้งาน สำเร็จ!", "ระบบกำลังพาท่านไป...", "success", {
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



        /** Update Data */
        function updatedata(id) {

          $("#updatedata" + id).submit();

          $("#updatedata" + id).submit(function(updateData) {
            updateData.preventDefault();

            swal({
                title: 'ต้องการอัพเดทผู้ใช้งาน',
                text: "คุณต้องการอัพเดทผู้ใช้งานใช่หรือไม่",
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
                  var uid = id;
                  var point = $('#point' + id).val();
                  var email = $('#email' + id).val();
                  var role = $('#role' + id).val();

                  updatedata.append('user_id', uid);
                  updatedata.append('point', point);
                  updatedata.append('email', email);
                  updatedata.append('role', role);

                  $.ajax({

                    type: "POST",
                    url: "plugin/edit_user.php",
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
                          swal("อัพเดทผู้ใช้งาน สำเร็จ!", "ระบบกำลังบันทึกข้อมูล...", "success", {
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