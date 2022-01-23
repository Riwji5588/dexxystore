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
                                <h4>ข้อมูลปัจจุบันของออเดอร์&nbsp;
                                    <span id="orderidreq">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </span>
                                </h4>
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
                <div class="card-body">
                    Hello, Logs
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
            console.log(orderid);
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
                    data.claim = json.data[0].claim;
                    data.claim_first = json.data[0].claim_first;
                    data.renew = json.data[0].renew;
                    data_id = present.data_id;

                    console.log(present.selled_id);
                    const username = present.username;
                    const password = atob(present.password);
                    const display = present.display;
                    const selled_date = new Date(present.selled_date);
                    const exp_date = new Date(present.exp_date);
                    const now = new Date();
                    const status = (exp_date.getTime() - now.getTime()) > 0 ? 'ยังไม่หมดประกัน' : 'หมดประกัน';



                    $('#orderidreq').html(present.selled_id)

                    document.getElementById('cardimg').src += present.image_name;
                    $('#carddetail').html(present.card_title + '-' + present.card_price);
                    $('#username').val(username);
                    $('#password').val(password);
                    $('#display').val(display);
                    $('#banstatus').val(present.ban == 1 ? 'ถูกแบน' : 'ไม่ได้ถูกแบน');
                    $('#status').val(status);
                    $('#selled_date').val(selled_date.toISOString().split('T')[0]);
                    $('#exp_date').val(exp_date.toISOString().split('T')[0]);
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

                    $('#orderidreq').html(present.selled_id)
                    document.getElementById('cardimg').src += present.image_name;
                    $('#carddetail').html(present.card_title + '-' + present.card_price);
                    $('#username').val(username);
                    $('#password').val(password);
                    $('#display').val(display);
                    $('#banstatus').val(present.ban == 1 ? 'ถูกแบน' : 'ไม่ได้ถูกแบน');
                    $('#status').val(status);
                    $('#selled_date').val(selled_date.toISOString().split('T')[0]);
                    $('#exp_date').val(exp_date.toISOString().split('T')[0]);
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
            }
        })
    }

    $("#form").submit(function(e) {
        e.preventDefault();
        orderid = $("#orderid").val();
        window.location.href = "./orderlog&order=" + orderid;

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
</script>

<style>
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