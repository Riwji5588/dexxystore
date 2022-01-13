 <!-- 

  Ban status:

  0 = not banned
  1 = banned buy
  2 = banned claim
  3 = banned first claim
  999 = banned all

  -->


 <!-- Data User -->
 <h3 class="text-center mt-4 mb-4" style="color: white ;">--- จัดการผู้ใช้งาน ---</h3>
 <div class="mt-3">
   <table id="myTable" class="table table-hover text-center w-100">
     <thead class="hyper-bg-dark">
       <tr>
         <th scope="col" style="width:120px;">เลขที่บัญชี</th>
         <th scope="col">บัญชีผู้ใช้</th>
         <th scope="col">อีเมล์</th>
         <th scope="col">ระดับ</th>
         <th scope="col" style="width: 170px;">เมนู</th>
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
 <!-- End User  -->


 <script>
   let orders_list = "";
   var isSandbox = window.location.origin == "https://sandbox.dexystore.me";
   var host = window.location.origin == "http://localhost" ? "http://localhost/dexystore" : isSandbox ? "https://sandbox.dexystore.me" : "https://dexystore.me";
   var url = host + '/plugin/getAll.php';

   var total_del = [];

   $(document).ready(async () => {
     renderPage(host, url);
   })

   function renderPage(host, url, type = true) {
     $.ajax({

       type: "POST",
       url: url,
       dataType: "json",
       data: {
         action: 'getalluser'
       },
       success: function(json) {
         if (json.code == 200) {
           const data = json.data;
           const ban = json.ban;
           let [body, modal] = "";

           for (let i = 0; i < data.length; i++) {
             body +=
               `
                <tr ${ban['ac'+data[i].ac_id] != undefined && ban['ac'+data[i].ac_id].ac_id == data[i].ac_id ? ban['ac'+data[i].ac_id].buy == 1 || ban['ac'+data[i].ac_id].claim == 1 || ban['ac'+data[i].ac_id].claim_first == 1 ? 'style="color: red;"' : '' : '' }>
                  <td>${i+1}</td>
                  <td>${data[i].username}</td>
                  <td>${data[i].email}</td>
                  ${data[i].role == 779 ? '<td class="text-danger">ผู้ดูแลระบบ</td>' : '<td>ผู้ใช้งาน</td>'}
                  <td>
                    <button id="clickmodal${data[i].ac_id}" class="btn btn-sm hyper-btn-notoutline-success" type="button" data-toggle="modal" data-target="#editusermodal${data[i].ac_id}" onclick="LoadOrder(${data[i].ac_id}, ${false})"><i class="fal fa-edit mr-1"></i> แก้ไข</button>
                    <button onclick="DelUser(this)" value="${data[i].ac_id}" class="btn btn-sm hyper-btn-notoutline-danger my-1 my-sm-0" type="button"><i class="fal fa-trash-alt mr-1"></i> ลบ</button>
                  </td>
                </tr>
              `;
           }
           if (type) {
             $('#body').html(body);
             $('#myTable').DataTable();
             $('#loading').remove();

             //  addCache(host, body);
           } else {
             //  addCache(host, body);
           }
         }
       },
       error: function(data) {
         console.log(data.responseText);
       }
     });
   }

   function addCache(host, data) {
     $.ajax({
       type: "POST",
       url: host + '/plugin/userCache.php',
       dataType: "json",
       data: {
         action: 'AddCache',
         table: data
       },
       success: function(json) {
         if (json.code == 200) {
           console.log(json.message);
         }
       },
       error: function(data) {
         console.log(data.responseText);
       }
     });
   }

   function LoadOrder(ac_id, type = true) {
     let isSandbox = window.location.origin == "https://sandbox.dexystore.me";
     let host = window.location.origin == "http://localhost" ? "http://localhost/dexystore" : isSandbox ? "https://sandbox.dexystore.me" : "https://dexystore.me";
     let url = host + '/plugin/getAll.php';
     $.ajax({
       url: url,
       type: 'POST',
       dataType: 'json',
       data: {
         'action': 'getusermodal',
         'id': ac_id
       },
       success: function(json) {
         if (json.code == 200) {
           const orders_id = json.order_id;
           const ban = json.ban;
           const data = json.data;
           let modal = '';


           if (type) {
             let data_append = '';
             let ordersList = $('#orderslist' + ac_id);
             orders_id.forEach((order) => {
               data_append += `
                 <div class="form-check form-check-inline">
                  <input class="form-check-input" value="${order.id}" type="checkbox" id="order${order.id}" onclick="checkedL(${ac_id}, this)" ${order.ban ? "checked" : ""}>
                  <label class="form-check-label" for="order${order.id}" style="color: #000">&nbsp;ออเดอร์ ${order.id}</label>
                 </div> `;
               if (order.ban) {
                 total_del.push(order.id);
                 $('#banlist' + ac_id).val(total_del.join(','));
               }
             })

             if (ordersList.children('div.form-check.form-check-inline').length != orders_id.length) {
               ordersList.html(data_append);
             }

             $('#loadingOrder' + ac_id).remove();
           } else {
             modal +=
               `
                  <!-- Edit Game Data Modal -->
                    <input type="hidden" id="banlist${data[0].ac_id}" value="">
                    <div class="modal fade" id="editusermodal${data[0].ac_id}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 radius-border-2 hyper-bg-white">
                          <div class="modal-header hyper-bg-dark">
                            <h6 class="modal-title"><i class="fal fa-plus-square mr-1"></i> อัพเดทข้อมูล</h6>
                          </div>
                          <div class="modal-body text-center">
  
                            <form method="POST" enctype="multipart/form-data">
  
                              <img src="assets/img/logoani_236x236.jpg" width="99px" class="img-fluid rounded-circle ml-auto mr-auto mb-2"></br>
                              <font class="text-muted">Username</font>
                              <h5><b>${data[0].username}</b></h5>
  
                              <div class="input-group input-group-sm mb-3 mt-4">
                                <div class="input-group-prepend">
                                  <span class="input-group-text hyper-bg-dark border-dark">อีเมล์</span>
                                </div>
                                <input id="email${data[0].ac_id}" value="${data[0].email}" type="email" class="form-control form-control-sm hyper-form-control" placeholder="E-mail" required>
                              </div>
  
                              <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text hyper-bg-dark border-dark">เงิน</span>
                                </div>
                                <input id="point${data[0].ac_id}" value="${data[0].points}" type="number" class="form-control form-control-sm hyper-form-control" placeholder="Point" required>
                              </div>
  
                              <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                  <label class="input-group-text hyper-bg-dark border-dark" for="role${data[0].ac_id}">ระดับผู้ใช้งาน</label>
                                </div>
                                <select id="role${data[0].ac_id}" class="custom-select hyper-form-control">
                                  <option ${data[0].role==1 ? 'selected' : '' } value="1">ผู้ใช้งาน</option>
                                  <option ${data[0].role==779 ? 'selected' : '' } value="779">ผู้ดูแลระบบ</option>
                                </select>
                              </div>
  
                                <button type="submit" id="updatedata${data[0].ac_id}" class="d-none"></button>
                              </form>
                              
                              </div>
                              <div align="center">
                              <div class="col-6" >
                                <button class="btn mb-3 w-100 hyper-btn-danger btn-sm" data-toggle="modal" data-target="#banmodal${data[0].ac_id}" onclick="LoadOrder(${data[0].ac_id})">แบน</button>
                              </div>
                              </div>
                          <div class="modal-footer p-2 border-0">
                            <button type="button" onclick="updatedata('${data[0].ac_id}')" class="btn btn-success"><i class="fal fa-plus-square mr-1"></i>อัพเดทข้อมูล</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="total_del = []"><i class="fad fa-times-circle mr-1"></i>ยกเลิก</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- End Edit Game Data Modal -->
  
                    <!-- Ban Modal -->
                    <div class="modal fade" id="banmodal${data[0].ac_id}"  data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                          <div class="modal-body">
                            <div class="card-body">
                              <hr>
                              <fieldset class="form-group" align="start" style="border: 0;">
                                <div class="row">
                                  <legend class="col-form-label col-sm-4 pt-0">แบน</legend>
                                  <div class="col-sm-8">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" id="banbuy${data[0].ac_id}"${ban[0].ac_id == data[0].ac_id && ban[0].buy == 1 ? 'checked' : ''} >
                                      <label class="form-check-label" for="banbuy${data[0].ac_id}" style="color: #000">
                                      แบนการซื้อ
                                      </label>
                                    </div>
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" id="banclaim${data[0].ac_id}"${ban[0].ac_id == data[0].ac_id && ban[0].claim == 1 ? 'checked' : ''}>
                                      <label class="form-check-label" for="banclaim${data[0].ac_id}" style="color: #000">
                                      แบนการเคลม
                                      </label>
                                    </div>
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" id="banclaimfirst${data[0].ac_id}"${ban[0].ac_id == data[0].ac_id && ban[0].claim_first == 1 ? 'checked' : ''}>
                                      <label class="form-check-label" for="banclaimfirst${data[0].ac_id}" style="color: #000">
                                      แบนการเคลม (ครั้งแรก)
                                      </label>
                                    </div>
                                  </div>
                                </div>
                              </fieldset>
                              <hr>
                              <fieldset class="form-group" align="start" style="border: 0;">
                                <div class="row">
                                  <legend class="col-form-label col-sm-4 pt-0">แบนออเดอร์</legend>
                                  <div id="orderslist${data[0].ac_id}" class="col-sm-8">
                                    
                                    <div id="loadingOrder${data[0].ac_id}" class="form-check form-check-inline">
                                      <div class="spinner-border" role="status"></div>
                                    </div>
                                                                              
                                  </div>
                                </div>
                              </fieldset>
                            </div>
                          </div>
                          <div class="modal-footer px-2 pb-2">
                            <button type="button" onclick="updatedata('${data[0].ac_id}')" class="btn btn-success"><i class="fal fa-plus-square mr-1"></i>อัพเดทข้อมูล</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fad fa-times-circle mr-1"></i>ยกเลิก</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  <!-- End Ban Modal -->
                  
                 `
             // jquery check is have element
             let checkEdituser = $(`#editusermodal${data[0].ac_id}`).html() != undefined
             let checkBan = $(`#banmodal${data[0].ac_id}`).html() != undefined


             if (!checkEdituser && !checkBan) {
               $('body').append(modal)
               console.log('added')
             } else {
               console.log('already added')
             }
           }


         } else {
           console.log(json.message);
         }
       },
       error: function(data) {
         console.log(data.responseText);
       }
     })
   }



   function checkedL(ac_id, data) {
     var value = parseInt(data.value);
     var id = data.id
     var check = $('#' + id).is(':checked');
     if (check) {
       total_del.push(value);
     } else {
       index = total_del.indexOf(value);
       if (index > -1) {
         total_del.splice(index, 1);
       }
     }
     $('#banlist' + ac_id).val(total_del.join(','));
   }

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
                   renderPage(host, url, false);
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
             var buyChecked = $('#banbuy' + id).is(':checked') ? 1 : 0;
             var claimChecked = $('#banclaim' + id).is(':checked') ? 1 : 0;
             var claimfirstChecked = $('#banclaimfirst' + id).is(':checked') ? 1 : 0;
             var banlist = $('#banlist' + id).val();

             updatedata.append('user_id', uid);
             updatedata.append('point', point);
             updatedata.append('email', email);
             updatedata.append('role', role);
             updatedata.append('banbuy', buyChecked);
             updatedata.append('banclaim', claimChecked);
             updatedata.append('banclaimfirst', claimfirstChecked);
             updatedata.append('banorders', banlist);

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
                     renderPage(host, url, false);
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