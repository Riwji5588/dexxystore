<h3 class="text-center mt-4 mb-4" style="color: white;">--- ประวัติการลบ ---</h3>
<div id="selectAll" class="br-icon1 text-center btn btn-danger" onclick="selectAll()">
    <span>เลือกทั้งหมด</span>
</div>
<div class="row">
    <div class="col-12 col-md-4">
        <div class="form-group">
            <div class="btn btn-primary w-100" onclick="dosomething('claim')">
                เคลม
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="form-group">
            <div class="btn btn-secondary w-100" onclick="dosomething('claim_first')">
                เคลมครั้งแรก
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="form-group">
            <div class="btn btn-success w-100" onclick="dosomething('data_selled')">
                ไอดีของสินค้าที่ขายแล้ว
            </div>
        </div>
    </div>
</div>

<div id="delAll" class="br-icon1 text-center btn btn-danger" style="display: none;" onclick="delAll()">
    <span>ลบที่เลือก</span>
</div>

<div id="claim" class="mt-3">
    <table id="myTable" class="table table-hover text-center w-100">
        <thead class="hyper-bg-dark">
            <tr>
                <th style="width:50px;">เลือก</th>
                <th scope="col" style="width:100px;">ลำดับการเคลม</th>
                <th scope="col" style="width:85px;">ออเดอร์ที่</th>
                <th scope="col">ผู้เคลม</th>
                <th scope="col">วันที่เคลม</th>
                <th scope="col">สถานะ</th>
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

<div id="selled_data" class="mt-3">
    <table id="myTable" class="table table-hover text-center w-100">
        <thead class="hyper-bg-dark">
            <tr>
                <th scope="col" style="width:50px;">เลือก</th>
                <th scope="col" style="width:85px;">ออเดอร์ที่</th>
                <th scope="col">สินค้า</th>
                <th scope="col">บัญชีผู้ใช้</th>
                <th scope="col">เจ้าของ</th>
                <th scope="col">จำนวนการเคลม</th>
                <th scope="col">วันที่ซื้อ</th>
                <th scope="col">สถานะ</th>
                <th scope="col" style="width: 100px;">เมนู</th>
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

<input type="hidden" id="del" name="del" value="">
<style>
    .table-hover:hover {
        background-color: #ddd;
    }

    input {
        border-radius: 15px;

    }

    input.expdate {
        width: 35%;
    }

    input.detail {
        width: auto;

    }

    input.pass {
        width: 45%;
    }

    input.user {
        width: 45%;
    }

    .drop {
        border-radius: 15px;
    }

    #detailnew {
        height: 70px;
        min-height: 70px;
        max-height: 120px;
        width: 300px;

    }

    body {
        background-color: #131315;
    }

    label {
        color: white;
    }

    #datatable_info {
        color: white;
    }
</style>

<script>
    const canSelect = [];
    const isSandbox = window.location.origin == "https://sandbox.dexystore.me";
    const host = window.location.origin == "http://localhost" ? "http://localhost/dexystore" : isSandbox ? "https://sandbox.dexystore.me" : "https://dexystore.me";
    const url = host + '/plugin/getDelete.php';
    let type = window.location.href.slice(window.location.href.indexOf('/') + 1).split('?')[1];
    $('#delAll').hide();

    if (!!type) {
        if (type == 'claim') {
            $('#claim').show();
            $('#selled_data').remove();
            loadData('claim');
        } else if (type == 'claim_first') {
            $('#claim').show();
            $('#selled_data').remove();
            loadData('claim_first');
        } else if (type == 'data_selled') {
            $('#claim').remove();
            $('#selled_data').show();
            loadData('data_selled');
        } else {
            $('#claim').remove();
            $('#selled_data').remove();
        }
    } else {
        window.open(host + '/dellog?claim', '_self');
    }

    const dosomething = (type1) => {
        if (type1 != type) {
            window.open('./dellog?' + type1, '_blank');
        }
    };

    function loadData(type1) {
        $('#loading').show();
        $('#body').html('');
        $.ajax({
            url: url + '?type=' + type1,
            type: 'GET',
            success: function(jsond) {
                $('#loading').hide();
                const json = JSON.parse(jsond);
                if (json.code == 200) {
                    let body = '';
                    if (json.data != null && json.data.length > 0) {
                        let body = '';
                        let html = '';
                        const data1 = json.data;
                        if (type1 != 'data_selled') {
                            let i = 0;
                            data1.forEach(data => {
                                canSelect.push(data.id);
                                body +=
                                    `
                                    <tr>
                                        <td>
                                        ${data.claim_data_confirm != 0 ? `<input type="checkbox" id="check${data.id}" name="check${data.claim_data_id}" value="${data.id}" onclick="checkedL(this)">` : '-'}
                                        </td>
                                        <td>
                                            ${data.claim_data_confirm != 0 ? i+1 : '-'}
                                        </td>
                                        <td>${data.claim_data_id}</td>
                                        <td>${data.username}</td>
                                        <td>${data.claim_data_date}</td>
                                        <td>${ data.claim_data_confirm == 0 ? '<span class="text-warning">รอดำเนินการ</span>' : 
                                            data.claim_data_confirm == 1 ? '<span class="text-success">อนุมัติ</span>' : 
                                            data.claim_data_confirm == 2 ? '<span class="text-danger">ปฏิเสธ</span>' : 
                                            '-'}
                                        </td>
                                        <td>
                                            <button class="btn btn-sm hyper-btn-notoutline-success" type="button" onclick="restore(${data.id})"><i class="far fa-undo"></i> คืนค่า</button>
                                            <button class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-target="#editusermodal${i}" onclick="loadimg(${data.id})"><i class="fal fa-info-circle mr-1"></i> แสดงไอดี</button>
                                            <button onclick="DelLog(${data.id})" value="${data.selled_id}" class="btn btn-sm hyper-btn-notoutline-danger my-1 my-sm-0" type="button"><i class="fal fa-trash-alt mr-1"></i> ลบ</button>
                                        </td>
                                    </tr>
                                    `
                                html += `
                            <!-- aleart Data Modal -->
                                <div class="modal fade" id="editusermodal${i}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 radius-border-2 hyper-bg-white">
                                            <div class="modal-header hyper-bg-dark">
                                                <h5 class="modal-title"><i class="fal fa-info-circle mr-1"></i> ข้อมูลไอดีที่เคลม</h5>
                                                <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-left">
                                                <div class="row">
                                                    <div class="col-8">
                                                        <div class="container justify-content-center">
                                                            <div class="row" style="padding: 5px 2px 0px 2px;">
                                                                <div class="col-3 col-md-4">
                                                                    <span>ออเดอร์</span>
                                                                </div>
                                                                <div class="col-9 col-md-8">
                                                                    <input type="text" id="id${data.claim_data_id}" value="${data.claim_data_id}" readonly style="background-color: #fff;border-radius: 0px;border: 0px">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                ${data.claim_data_confirm == 0 ? `
                                                        <div class="mr-2 mb-1">
                                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                                <button id="confirmbtn${data.claim_data_id}" type="button" class="btn btn-success btn-sm p-1 px-2" onclick="submit(${data.claim_data_id},2)">อนุมัติ</button>
                                                                <button id="confirmbtnr${data.claim_data_id}" type="button" class="btn btn-danger btn-sm p-1 px-2" data-toggle="modal" data-target="#reject${data.id}">ปฏิเสธ</button>
                                                            </div>
                                                        </div>` : ''}
                                                    </div>
                                                </div>
                                                <div class="container justify-content-center">
                                                    <div class="row" style="padding: 5px 2px 0px 2px;">
                                                        <div class="col-3 col-md-4">
                                                            <span>จำนวนการเคลม</span>
                                                        </div>
                                                        <div class="col-9 col-md-8">
                                                            <input type="text" id="count${data.claim_data_id}" value="${data.count_claim}" readonly style="background-color: #fff;border-radius: 0px;border: 0px">
                                                        </div>
                                                    </div>
                                                    <div class="row" style="padding: 5px 2px 0px 2px;">
                                                        <div class="col-3 col-md-4">
                                                            <span>ชื่อผู้ใช้งาน</span>
                                                        </div>
                                                        <div class="col-9 col-md-8">
                                                            <input type="text" id="username${data.claim_data_id}1" value="${data.data_result_username}" readonly style="background-color: #fff;border-radius: 0px;border: 0px">
                                                            <button style="margin-left: -25px;" class="btn btn-dark btn-sm" type="button" onclick="copy(this,'username${data.claim_data_id}1')"><i class='far fa-copy'></i> คัดลอก</button>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="padding: 5px 2px 0px 2px;">
                                                        <div class="col-3 col-md-4">
                                                            <span>รหัสผ่าน</span>
                                                        </div>
                                                        <div class="col-9 col-md-8">
                                                            <input type="text" id="password${data.claim_data_id}1" value="${data.data_result_password}" readonly style="background-color: #fff;border-radius: 0px;border: 0px">
                                                            <button style="margin-left: -25px;" class="btn btn-dark btn-sm" type="button" onclick="copy(this,'password${data.claim_data_id}1')"><i class='far fa-copy'></i> คัดลอก</button>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="padding: 5px 2px 0px 2px;">
                                                        <div class="col-3 col-md-4">
                                                            <span>จอ</span>
                                                        </div>
                                                        <div class="col-9 col-md-8">
                                                            <input type="text" value="${data.data_result_display}" readonly style="background-color: #fff;border-radius: 0px;border: 0px">
                                                        </div>
                                                    </div>
                                                    <div class="row" style="padding: 5px 2px 0px 2px;">
                                                        <div class="col-3 col-md-4">
                                                            <span>วันที่ซื้อ</span>
                                                        </div>
                                                        <div class="col-9 col-md-8">
                                                            <input type="text" value="${data.selled_date}" readonly style="background-color: #fff;border-radius: 0px;border: 0px">
                                                        </div>
                                                    </div>
                                                    <div class="row" style="padding: 5px 2px 0px 2px;">
                                                        <div class="col-3 col-md-4">
                                                            <span>สาเหตุในการเคลม</span>
                                                        </div>
                                                        <div class="col-9 col-md-8">
                                                            <p>${data.claim_data_detail}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="padding: 5px 2px 0px 2px;">
                                                        <div class="col-3 col-md-4">
                                                            <span>รูปภาพที่อัพโหลด</span>
                                                        </div>
                                                        <div class="col-9 col-md-8">
                                                        <button id="showimgbtn${data.id}" class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-target="#showimg${data.id}" onclick="loadimg(${data.claim_data_id}, ${data.id})">เปิดรูป</button>
                                                        </div>
                                                    </div>
                                                </div>
    
                                                <div class="modal-footer p-2 border-0">
                                                
                                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fad fa-times-circle mr-1"></i>ปิด</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- sub modal -->
                                <div class="modal fade" id="reject${data.id}" data-backdrop="static">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">ปฏิเสธการเคลม</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="">สาเหตุที่ปฏิเสธ</label>
                                                            <textarea id="response${data.claim_data_id}" class="form-control" id="reject_detail${data.claim_data_id}" rows="3" placeholder="กรุณากรอกสาเหตุที่ปฏิเสธ"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button  id="rejectbtn${data.claim_data_id}" type="button" class="btn btn-success" onclick="doReject(${data.claim_data_id})">ยืนยัน</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- img modal -->
                                <div class="modal fade" id="showimg${data.id}" data-backdrop="static">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">รูปภาพที่อัพโหลด</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                    <div id="carouselExampleIndicators${data.id}" class="carousel slide" data-ride="carousel">
                                                        <ol class="carousel-indicators" id="imgindicators${data.id}">
                                                        </ol>
                                                        <div class="carousel-inner" id="imgcarousel${data.id}">
                                                        </div>
                                                        <button class="carousel-control-prev" type="button" data-target="#carouselExampleIndicators${data.id}" data-slide="prev">
                                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                            <span class="sr-only">Previous</span>
                                                        </button>
                                                        <button class="carousel-control-next" type="button" data-target="#carouselExampleIndicators${data.id}" data-slide="next">
                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                            <span class="sr-only">Next</span>
                                                        </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                `;
                                i++;
                            })
                        } else {
                            data1.forEach(data => {
                                canSelect.push(data.selled_id);
                                body +=
                                    `
                                    <tr id="row${data.selled_id}">
                                        <td><input type="checkbox" id="check${data.selled_id}" name="check${data.selled_id}" value="${data.selled_id}" onclick="checkedL(this)"></td>
                                        <td>${data.selled_id}</td>
                                        <td>${data.card_id == null ? 'Unknow' : data.card_title+"-"+data.card_price}</td>
                                        <td>${data.selled_data_username}</td>
                                        <td>${data.account_username}</td>
                                        <td>${data.claim_count}</td>
                                        <td>${data.selled_date}</td>
                                        <td>${data.expire < 1 ? "หมดประกัน" : "ยังไม่หมดประกัน"}</td>
                                        <td width="100px">
                                            <button class="btn btn-sm hyper-btn-notoutline-success" type="button" onclick="restore(${data.selled_id})"><i class="far fa-undo"></i> คืนค่า</button>
                                            <button class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-target="#editownermodal${data.selled_data_id}" onclick="LodingModal(${data.selled_data_id})"><i class="fal fa-info-circle mr-1"></i> เพิ่มเติม</button>
                                            <button onclick="DelLog(${data.selled_id})" value="${data.selled_id}" class="btn btn-sm hyper-btn-notoutline-danger my-1 mt-0" type="button"><i class="fal fa-trash-alt mr-1"></i> ลบ</button>
                                        </td>
                                    </tr>
                                `
                            })
                        }
                        $('#body').html(body);
                        $('body').append(html);
                        $('#myTable').DataTable();
                        $('#loading').remove();

                    } else {
                        $('#selectAll').hide();
                        $('#body').html('<tr><td colspan="10" class="text-center" style="background-color: white;">ไม่พบข้อมูล</td></tr>');
                    }
                } else {
                    console.log(json.message);
                }
            }
        });
    };

    function LodingModal(dataid) {
        $.ajax({
            type: "POST",
            url: host + '/plugin/getDataowner.php',
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

    var total_del = [];

    function checkedL(data) {
        var value = data.value;
        var id = data.id
        var check = $('#' + id).is(':checked');
        if (check) {
            total_del.push(value);
            $('#delAll').show()
            document.getElementById('delAll').style.animation = "fadeIn 300ms";

        } else {
            index = total_del.indexOf(value);
            if (index > -1) {
                total_del.splice(index, 1);
            }

            if (total_del.length == 0) {
                document.getElementById('delAll').style.animation = "fadeOut 1s";
                $('#delAll').hide();
            }
        }
    }

    function delAll() {
        document.getElementById('del').value = total_del.join(',');
        let title = total_del.length > 1 ? 'คุณต้องการลบ ' + total_del.length + ' ข้อมูลนี้หรือไม่?' : 'คุณต้องการลบข้อมูลนี้หรือไม่?'
        DelLog($('#del').val(), title);

    }

    function DelLog(id, title = 'คุณต้องการลบข้อมูลนี้หรือไม่?') {
        swal({
                title: title,
                text: "ถ้าลบแล้วจำไม่สามารถกู้กลับมาได้ และถ้าออเดอร์ยังไม่หมดอายุ ก็จะถูกลบไปด้วย",
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
                        url: "plugin/actionDel.php",
                        dataType: "json",
                        data: {
                            id: id,
                            action: 'delete',
                            table: type
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
                                    }, 2000);
                                } else {
                                    swal(data.msg, "", "error", {
                                        button: {
                                            className: 'hyper-btn-notoutline-danger',
                                        },
                                        closeOnClickOutside: false,
                                    });
                                }
                            }, 600)
                        }

                    });
                }
            });
    }

    function selectAll() {
        total_del = canSelect
        total_del.forEach(function(value) {
            $('#check' + value).prop('checked', true);
        });
        $('#delAll').show()
    }

    function restore(id) {
        swal({
                title: 'คุณต้องการคืนค่าข้อมูลนี้หรือไม่?',
                icon: "info",
                buttons: {
                    confirm: {
                        text: 'คืนค่า',
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
                        url: "plugin/actionDel.php",
                        dataType: "json",
                        data: {
                            action: 'restore',
                            id: id,
                            table: type
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
                                    }, 1000);
                                } else {
                                    swal(data.msg, "", "error", {
                                        button: {
                                            className: 'hyper-btn-notoutline-danger',
                                        },
                                        closeOnClickOutside: false,
                                    });
                                }
                            }, 600)
                        }

                    });
                }
            });
    }

    function loadimg(id) {
        console.log(id);
        $.ajax({
            type: "POST",
            url: "plugin/claim_img.php",
            dataType: "json",
            data: {
                action: 'getimg',
                type: 2,
                claim_id: id
            },
            success: function(data) {
                if (data.code == "200") {
                    console.log(data.data);
                    if (data.data.length > 0) {
                        let html = '';
                        let inner = '';
                        let i = 0;
                        data.data.forEach((img) => {
                            if (i == 0) {
                                html += `
                                        <li data-target="#carouselExampleIndicators${id}" data-slide-to="${i}" class="active"></li>
                                    `;
                                inner += `
                                        <div class="carousel-item active">
                                            <img src="${img.image_name}" class="d-block w-100">
                                        </div>
                                `;
                            } else {
                                html += `
                                        <li data-target="#carouselExampleIndicators${id}" data-slide-to="${i}"></li>
                                    `;
                                inner += `
                                    <div class="carousel-item">
                                        <img src="${img.image_name}" class="d-block w-100">
                                    </div>
                                `;
                            }
                            i++;
                        })

                        $('#imgindicators' + id).html(html);
                        $('#imgcarousel' + id).html(inner);
                    } else {
                        $('#showimgbtn' + id).attr('disabled', true);
                        document.getElementById('showimgbtn' + id).innerHTML = 'ไม่มีรูปภาพ';
                    }
                } else {
                    // $('#img').html('<div class="text-center"><h5>ไม่มีรูปภาพ</h5></div>');
                    console.log(data.message);
                }
            }
        });
    }
</script>