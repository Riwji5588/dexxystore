<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content card mx-2">
            <div class="modal-body card-body">
                <div class="container">
                    <form id="form">
                        <div class="row">
                            <div class="input-group m-3">
                                <input id="orderid" type="text" class="form-control" placeholder="เลขออเดอร์" aria-label="เลขออเดอร์" aria-describedby="requestorderid" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary change" type="submit" id="requestorderid">แสดงประวัติ</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="backdroppp"></div>

<h3 class="text-center mt-4 mb-5" style="color: white;">--- ประวัติออเดอร์ย้อนหลัง ---</h3>

<div class="container align-items-center">
    <div class="row">
        <div class="col-12">
            <div id="loader" class="d-flex justify-content-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="float-right" role="status">
                <button class="btn btn-danger mx-auto mb-3" onclick="reorder()"><i class="fas fa-redo"></i> เปลี่ยนออเดอร์</button>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card align-items-center mb-3">
                <div id="mySidebar" class="sidebar card-body">
                    <a href="#detail" onclick="opentab('detail')"><i class="far fa-address-card"></i> ข้อมูล</a>
                    <a href="#logs" onclick="opentab('logs')"><i class="fas fa-history"></i> ประวัติย้อนหลัง</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-9">
            <div id="detail" class="card active">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-2">
                            <center>
                                <h3>
                                    <b>
                                        ข้อมูลปัจจุบันของออเดอร์&nbsp;
                                        <span class="orderidreq">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </span>
                                    </b>
                                </h3>
                            </center>
                        </div>
                        <div class="col-12 mb-2" align="center">
                            <img src="assets/img/item/" id="cardimg" width="99px" height="99px" class="ml-auto mr-auto mb-2" style="border-radius: 50%"></br>
                            <font class="text-muted" id="carddetail"></font>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <div class="col-12 p-0">
                                    <input type="text" class="form-control" id="username" value="Undefine">
                                    <button class="btn btn-dark btn-sm w-100" type="button" onclick="copy(this,'username')"><i class='far fa-copy'></i> คัดลอก</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="col-12 p-0">
                                    <input type="text" class="form-control" id="password" value="Undefine">
                                    <button class="btn btn-dark btn-sm w-100" type="button" onclick="copy(this,'password')"><i class='far fa-copy'></i> คัดลอก</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="display">จอ</label>
                                <div class="col-12 p-0">
                                    <input type="text" class="form-control" id="display" value="Undefine">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="banstatus">สถานะการแบน</label>
                                <div class="col-12 p-0">
                                    <input type="text" class="form-control" readonly id="banstatus" value="Undefine">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="status">สถานะ</label>
                                <div class="col-12 p-0">
                                    <input type="text" class="form-control" readonly id="status" value="Undefine">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="selled_date">วันที่ซื้อ</label>
                                <div class="col-12 p-0">
                                    <input type="date" class="form-control" id="selled_date" readonly value="Undefine">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="exp_date">วันหมดประกัน</label>
                                <div class="col-12 p-0">
                                    <input type="date" class="form-control" id="exp_date" value="Undefine">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="owner">เจ้าของ</label>
                                <div class="col-12 p-0">
                                    <input type="text" class="form-control" id="owner" readonly value="Undefine">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr>
                        </div>
                        <div class="col-12">
                            <div class="row justify-content-end">
                                <button type="button" class="btn btn-danger btn-sm mx-2" onclick="DelData()"><i class="fal fa-trash-alt mr-1"></i> ลบข้อมูล</button>
                                <button type="button" class="btn btn-primary btn-sm mx-2" onclick="copyfile(this)"><i class="far fa-copy"></i> คัดลอก</button>
                                <button type="button" class="btn btn-success btn-sm mx-2" onclick="updatedata()"><i class="far fa-plus-square"></i> อัพเดทข้อมูล</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="logs" class="card">
                <div class="card-body text-center">
                    <h3><b>
                            ประวัติย้อนหลังออเดอร์ที่&nbsp;
                            <span class="orderidreq">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                        </b>
                        </span>
                    </h3>
                    <div style="text-align: start !important;">
                        <div class="container d-flex justify-content-center" style="height: 500px;overflow-y: scroll;;">
                            <div id="stepper" class="stepper d-flex flex-column mt-3 px-5 pt-3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <button class="btn btn-dark btn-sm w-100" type="button" onclick="copyfile(this)"><i class='far fa-copy'></i> คัดลอก</button> -->
<input type="hidden" id="copyall" value="">

<script>
    const data = [];
    let data_id = 0;
    $(document).ready(function() {
        const check_order = window.location.href.split('&order=')[1] ? true : false;
        if (!check_order) {
            $('#staticBackdrop').modal('show');
        } else {
            $('.backdroppp').remove();
            const orderid = window.location.href.split('&order=')[1].split('#')[0];
            getlog(orderid);
            $('#loader').remove();
        }
    });

    function getlog(orderid) {
        $.ajax({
            url: "plugin/getorderlog.php",
            type: "POST",
            dataType: "json",
            data: {
                action: "getlog",
                orderid: orderid
            },
            success: function(json) {
                let code = json.code;
                if (code == 200) {
                    console.log(json);
                    const present = json.data[0].present;
                    data.push(...json.data[0].claim);
                    data.push(...json.data[0].claim_first);
                    data.push(...json.data[0].renew);
                    data.push({
                        datetime: present.selled_date,
                        datethai: present.selled_date_thai,
                        type: 'selled_date'
                    });
                    data_id = present.data_id;

                    const username = present.username;
                    const password = atob(present.password);
                    const display = present.display;
                    const selled_date = new Date(present.selled_date);
                    const exp_date = new Date(present.exp_date);
                    const now = new Date();
                    const status = (exp_date.getTime() - now.getTime()) > 0 ? 'ยังไม่หมดประกัน' : 'หมดประกัน';
                    const owner = present.owner;

                    status == 'หมดประกัน' ? data.push({
                        datetime: present.exp_date,
                        datethai: present.exp_date_thai,
                        type: 'exp_date'
                    }) : false;

                    $('.orderidreq').html(present.selled_id)

                    document.getElementById('cardimg').src += present.image_name;
                    $('#carddetail').html(present.card_title + '-' + present.card_price);
                    $('#username').val(username);
                    $('#password').val(password);
                    $('#display').val(display);
                    $('#banstatus').val(present.ban == 1 ? 'ถูกแบน' : 'ไม่ได้ถูกแบน');
                    $('#status').val(status);
                    $('#selled_date').val(selled_date.toISOString().split('T')[0]);
                    $('#exp_date').val(exp_date.toISOString().split('T')[0]);
                    $('#owner').val(owner);
                } else {
                    const present = json.present;
                    data_id = present.data_id;

                    const username = present.username;
                    const password = atob(present.password);
                    const display = present.display;
                    const selled_date = new Date(present.selled_date);
                    const exp_date = new Date(present.exp_date);
                    const now = new Date();
                    const status = (exp_date.getTime() - now.getTime()) > 0 ? 'ยังไม่หมดประกัน' : 'หมดประกัน';
                    const owner = present.owner;

                    $('.orderidreq').html(present.selled_id)
                    document.getElementById('cardimg').src += present.image_name;
                    $('#carddetail').html(present.card_title + '-' + present.card_price);
                    $('#username').val(username);
                    $('#password').val(password);
                    $('#display').val(display);
                    $('#banstatus').val(present.ban == 1 ? 'ถูกแบน' : 'ไม่ได้ถูกแบน');
                    $('#status').val(status);
                    $('#selled_date').val(selled_date.toISOString().split('T')[0]);
                    $('#exp_date').val(exp_date.toISOString().split('T')[0]);
                    $('#owner').val(owner);
                    $('#logs').html(`
                    <div class="card">
                        <div class="card-body text-center">
                            <h4>${json.message}</h4>
                        </div>
                    </div>
                    `);
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                $('#detail').html(`
                <div class="card">
                    <div class="card-body text-center">
                        <h4>ไม่มีออเดอร์ที่ ${window.location.href.split('&order=')[1].split('#')[0]} ในระบบ</h4>
                    </div>
                </div>
                `);
                $('#logs').html(`
                    <div class="card">
                        <div class="card-body text-center">
                            <h4>ไม่มีข้อมูลย้อนหลัง</h4>
                        </div>
                    </div>
                    `);
            }
        })
    }

    $("#form").submit(function(e) {
        e.preventDefault();
        orderid = $("#orderid").val();
        if (orderid.match(/\d+/g) != null) {
            window.location.href = "./orderlog&order=" + orderid;
        } else {
            alert('กรุณากรอกหมายเลขออเดอร์ให้ถูกต้อง');
            searchFromEmail(orderid)
        }

    });

    function opentab(tab) {
        $('.card').removeClass('active');
        $('#' + tab).addClass('active');
        if (tab == 'logs') {
            loadlog();
        }
    }

    function reorder() {
        window.location.href = "./orderlog";
    }

    function loadlog() {
        data.sort((a, b) => a.datetime.localeCompare(b.datetime))
        let html = '';
        let i = 0;
        data.forEach(element => {
            let message = element.type == "claim" ? `ส่งเคลม` : element.type == "claim_first" ? `ส่งเคลมครั้งแรก` : element.type == 'selled_date' ? `ซื้อสินค้า` : element.type == 'exp_date' ? `หมดประกัน` : `ต่อประกัน`;
            let icon = "";
            let status = "";
            if (element.type == "claim") {
                if (element.confirm == 0) {
                    icon = `<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                                <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                            </svg>`;
                    status = "สถานะ: รอดำเนินการ";
                } else if (element.confirm == 1) {
                    icon = `<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                            <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                            </svg>`;
                    status = "สถานะ: อนุมัติ";
                } else {
                    icon = `<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                              <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                            </svg>`;
                    status = "สถานะ: ปฏิเสธ";
                }
            } else if (element.type == "claim_first") {
                icon = `<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                            <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                        </svg>`;
            } else {
                if (element.type == "selled_date") {
                    icon = `<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                             <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"/>
                            </svg>`;
                } else if (element.type == "exp_date") {
                    icon = `<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                            </svg>`;
                } else {
                    icon = `<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                            <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                            <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                        </svg>`

                }
            }
            if (i == data.length - 1) {
                html += `
                <div class="d-flex mb-1">
                    <div class="d-flex flex-column pr-4 align-items-center">
                        <div class="rounded-circle p-1 bg-dark text-white mb-1 w-100">${icon}</div>
                        <div class="line h-100 d-none"></div>
                    </div>
                    <div>
                        <h5 class="text-dark">${message}&nbsp;&nbsp;<small class="text-muted" style="font-size: 10pt;font-weight: bold;">${status}</small> </h5>
                        <p class="lead text-muted pb-3">${element.datethai}</p>
                    </div>
                </div>
            `;
            } else {
                html += `
                <div class="d-flex mb-1">
                    <div class="d-flex flex-column pr-4 align-items-center">
                        <div class="rounded-circle p-1 bg-dark text-white mb-1 w-100">${icon}</div>
                        <div class="line h-100"></div>
                    </div>
                    <div>
                        <h5 class="text-dark">${message}&nbsp;&nbsp;<small class="text-muted" style="font-size: 10pt;font-weight: bold;">${status}</small> </h5> 
                        <p class="lead text-muted pb-3">${element.datethai}</p>
                    </div>
                </div>
            `;
            }
            console.log(i == data.length - 1);
            i++
        });
        $('#stepper').html(html);
        console.log(data);
    }

    function copy(input, id) {
        var copyText = document.getElementById(id)
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        input.innerHTML = "<i class='far fa-copy'></i> คัดลอกแล้ว";
        input.className = "btn btn-success btn-sm w-100";
        setTimeout(function() {
            input.innerHTML = "<i class='far fa-copy'></i> คัดลอก";
            input.className = "btn btn-dark btn-sm w-100";
        }, 2000);
    }

    function copyfile(input) {
        let value = $('#username').val() + ":" + $('#password').val() + " " + $('#display').val()
        $('#copyall').val(value);
        let copyText = document.getElementById(`copyall`);
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

    /** Delete Data */
    function DelData() {
        var id = window.location.href.split('&order=')[1].split('#')[0];
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

    /** Update Data */
    function updatedata(id = "") {

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
                    var did = data_id;
                    var orderid = window.location.href.split('&order=')[1].split('#')[0];
                    var username = $('#username').val();
                    var password = $('#password').val();
                    var detail = '';
                    var display = $('#display').val();
                    var exp_date = $('#exp_date').val();

                    updatedata.append('data_id', did);
                    updatedata.append('username', username);
                    updatedata.append('password', password);
                    updatedata.append('detail', detail);
                    updatedata.append('display', display);
                    updatedata.append('exp_date', exp_date);
                    updatedata.append('orderid', orderid);

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

    }

    function searchFromEmail(email) {

    }
</script>

<style>
    .scroll {
        overflow-y: scroll;
        height: 400px;
    }

    .line {
        width: 2px;
        background-color: lightgrey !important;
    }

    .lead {
        font-size: 1.1rem;
    }

    .active {
        display: block !important;
    }

    #detail {
        display: none;
    }

    #logs {
        display: none;
    }

    /* The sidebar menu */
    .sidebar {
        height: 100%;
        /* 100% Full-height */
        width: auto;
        /* 0 width - change this with JavaScript */
        position: relative;
        /* Stay in place */
        z-index: 1;
        /* Stay on top */
        top: 0;
        left: 0;
        /* Black*/
        overflow-x: hidden;
        /* Disable horizontal scroll */
        padding-top: 15px;
        padding-bottom: 15px;
        /* Place content 60px from the top */
        transition: 0.5s;
        /* 0.5 second transition effect to slide in the sidebar */

        /* text-align: center; */
        border-radius: 15px;
    }

    /* The sidebar links */
    .sidebar a {
        padding: 8px 8px 8px 8px;
        text-decoration: none;
        font-size: 18px;
        color: #000;
        display: block;
        transition: 0.3s;
    }

    /* When you mouse over the navigation links, change their color */
    .sidebar a:hover {
        color: rgba(0, 0, 0, 0.5);
    }

    /* Position and style the close button (top right corner) */
    .sidebar .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
    }

    /* The button used to open the sidebar */
    .openbtn {
        font-size: 20px;
        cursor: pointer;
        background-color: #111;
        color: white;
        padding: 10px 15px;
        border: none;
    }

    .openbtn:hover {
        background-color: #444;
    }

    /* Style page content - use this if you want to push the page content to the right when you open the side navigation */
    #main {
        transition: margin-left .5s;
        /* If you want a transition effect */
        padding: 20px;
    }

    /* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
    @media screen and (max-height: 450px) {
        .sidebar {
            padding-top: 15px;
        }

        .sidebar a {
            font-size: 18px;
        }
    }

    @media screen and (max-width: 768px) {
        .sidebar {
            display: inline-flex !important;
        }
    }

    .change {
        color: #007bff !important;
    }

    .change:hover {
        color: #fff !important;
    }

    .backdroppp {
        display: none !important;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1030;
    }

    @media screen and (max-width: 576px) {
        .backdroppp {
            display: block !important;
        }
    }
</style>