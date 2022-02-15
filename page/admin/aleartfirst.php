<meta name="viewport" content="width=device-width, initial-scale=1">
<div class="br-icon1 text-center btn btn-danger" onclick="selectAll()">
    <span>เลือกทั้งหมด</span>
</div>
<div class="table-responsive mt-3">

    <div id="delAll" class="br-icon1 text-center btn btn-danger" style="display: none;" onclick="delAll()">
        <span>ลบที่เลือก</span>
    </div>

    <table id="myTable" class="table table-hover text-center w-100">
        <thead class="hyper-bg-dark">
            <tr>
                <th>เลือก</th>
                <th scope="col" style="width:120px;">ลำดับการเคลม</th>
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
    $(document).ready(async () => {
        let isSandbox = window.location.origin == "https://sandbox.dexystore.me";
        let host = window.location.origin == "http://localhost" ? "http://localhost/dexystore" : isSandbox ? "https://sandbox.dexystore.me" : "https://dexystore.me";
        let url = host + '/plugin/getReport.php';
        let getid = window.location.search.split('id=')[1] || false;
        $.ajax({

            type: "POST",
            url: url,
            dataType: "json",
            data: {
                action: 'getreport',
                type: 2
            },
            success: function(json) {
                if (json.code == 200) {
                    const data = json.data;
                    let body = $('#body').html();
                    let html = '';
                    for (let i = 0; i < data.length; i++) {
                        data[i].data_result_password != "N/A" ? data[i].data_result_password = atob(data[i].data_result_password) : data[i].data_result_password = "N/A";
                        data[i].claim_data_confirm != 0 ? canSelect.push(data[i].id) : '';
                        body += `
                        <tr ${data[i].claim_data_confirm != 0 ? 'style="background-color: #DADDE2;"' : getid && getid == data[i].claim_data_id ? 'style="background-color: #E7B91F"' : ''}>
                            <td>
                            ${data[i].claim_data_confirm != 0 ? `<input type="checkbox" id="check${data[i].id}" name="check${data[i].claim_data_id}" value="${data[i].id}" onclick="checkedL(this)">` : '-'}
                            </td>
                            <td>
                                ${data[i].claim_data_confirm != 0 ? i+1 : '-'}
                            </td>
                            <td>${data[i].username}</td>
                            <td>${data[i].claim_data_date}</td>
                            <td>${getid && 
                                getid == data[i].claim_data_id ? '<span style="color: #fff;">รอดำเนินการ</span>' : 
                                data[i].claim_data_confirm == 0 ? '<span class="text-warning">รอดำเนินการ</span>' : 
                                data[i].claim_data_confirm == 1 ? '<span class="text-success">กลับเข้าสต๊อก</span>' : 
                                data[i].claim_data_confirm == 2 ? '<span class="text-danger">ตรวจสอบแล้ว</span>' : 
                                '-'}
                            </td>
                            <td>
                                <button class="btn btn-sm hyper-btn-notoutline-success" type="button" data-toggle="modal" data-target="#editusermodal${i}" onclick="loadimg(${data[i].claim_data_id}, ${data[i].id})"><i class="fal fa-info-circle mr-1"></i> แสดงไอดี</button>
                                ${data[i].claim_data_confirm != 0 ? `<button onclick="DelLog(${data[i].id})" class="btn btn-sm hyper-btn-notoutline-danger my-1 my-sm-0" type="button"><i class="fal fa-trash-alt mr-1"></i> ลบ</button>` : ''}
                            </td>
                        </tr>
                        `;
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
                                                    <div class="col-7">
                                                        <div class="container justify-content-center">
                                                            <div class="row" style="padding: 5px 2px 0px 2px;">
                                                                <div class="col-3 col-md-4">
                                                                    <span>ออเดอร์</span>
                                                                </div>
                                                                <div class="col-9 col-md-8">
                                                                    <input type="text" id="id${data[i].claim_data_id}" value="${data[i].claim_data_id}" readonly style="background-color: #fff;border-radius: 0px;border: 0px">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-5">
                                                ${data[i].claim_data_confirm == 0 ? `
                                                        <div class="mr-2 mb-1">
                                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                                <button id="confirmbtn${data[i].claim_data_id}" type="submit" class="btn btn-success btn-sm p-1 px-2" onclick="doConfirm(${data[i].claim_data_id})">เข้าสต๊อก</button>
                                                                <button id="rejectbtn${data[i].claim_data_id}" type="submit" class="btn btn-danger btn-sm p-1 px-2" onclick="doReject(${data[i].claim_data_id})">ตรวจแล้ว</button>
                                                            </div>
                                                        </div>` : ''}
                                                    </div>
                                                </div>
                                            <div class="container">
                                                <div class="row" style="padding: 5px 2px 0px 2px;">
                                                    <div class="col-3 col-md-4">
                                                        <span>ชื่อผู้ใช้งาน</span>
                                                    </div>
                                                    <div class="col-9 col-md-8">
                                                        <input type="text" id="username${data[i].claim_data_id}1" value="${data[i].data_result_username}" readonly style="background-color: #fff;border-radius: 0px;border: 0px">
                                                        <button style="margin-left: -25px;" class="btn btn-dark btn-sm" type="button" onclick="copy(this,'username${data[i].claim_data_id}1')"><i class='far fa-copy'></i> คัดลอก</button>
                                                    </div>
                                                </div>
                                                <div class="row" style="padding: 5px 2px 0px 2px;">
                                                    <div class="col-3 col-md-4">
                                                        <span>รหัสผ่าน</span>
                                                    </div>
                                                    <div class="col-9 col-md-8">
                                                        <input type="text" id="password${data[i].claim_data_id}1" value="${data[i].data_result_password}" readonly style="background-color: #fff;border-radius: 0px;border: 0px">
                                                        <button style="margin-left: -25px;" class="btn btn-dark btn-sm" type="button" onclick="copy(this,'password${data[i].claim_data_id}1')"><i class='far fa-copy'></i> คัดลอก</button>
                                                    </div>
                                                </div>
                                                <div class="row" style="padding: 5px 2px 0px 2px;">
                                                    <div class="col-3 col-md-4">
                                                        <span>จอ</span>
                                                    </div>
                                                    <div class="col-9 col-md-8">
                                                        <input type="text" value="${data[i].data_result_display}" readonly style="background-color: #fff;border-radius: 0px;border: 0px">
                                                    </div>
                                                </div>
                                                <div class="row" style="padding: 5px 2px 0px 2px;">
                                                    <div class="col-3 col-md-4">
                                                        <span>วันที่ซื้อ</span>
                                                    </div>
                                                    <div class="col-9 col-md-8">
                                                        <input type="text" value="${data[i].selled_date}" readonly style="background-color: #fff;border-radius: 0px;border: 0px">
                                                    </div>
                                                </div>
                                                <div class="row" style="padding: 5px 2px 0px 2px;">
                                                    <div class="col-3 col-md-4">
                                                        <span>สาเหตุในการเคลม</span>
                                                    </div>
                                                    <div class="col-9 col-md-8">
                                                        <p>${data[i].claim_data_detail}</p>
                                                    </div>
                                                </div>
                                                <div class="row" style="padding: 5px 2px 0px 2px;">
                                                    <div class="col-3 col-md-4">
                                                        <span>รูปภาพที่อัพโหลด</span>
                                                    </div>
                                                    <div class="col-9 col-md-8">
                                                    <button id="showimgbtn${data[i].id}" class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-target="#showimg${data[i].id}" onclick="loadimg(${data[i].claim_data_id}, ${data[i].id})">เปิดรูป</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer p-2 border-0">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fad fa-times-circle mr-1"></i>ปิด</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        <!-- img modal -->
                            <div class="modal fade" id="showimg${data[i].id}" data-backdrop="static">
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
                                                <div id="carouselExampleIndicators${data[i].id}" class="carousel slide" data-ride="carousel">
                                                    <ol class="carousel-indicators" id="imgindicators${data[i].id}">
                                                    </ol>
                                                    <div class="carousel-inner" id="imgcarousel${data[i].id}">
                                                    </div>
                                                    <button class="carousel-control-prev" type="button" data-target="#carouselExampleIndicators${data[i].id}" data-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="sr-only">Previous</span>
                                                    </button>
                                                    <button class="carousel-control-next" type="button" data-target="#carouselExampleIndicators${data[i].id}" data-slide="next">
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
                    }
                    $('#body').html(body);
                    $('body').append(html);
                    $('#myTable').DataTable();
                    $('#loading').remove();
                }
            },
            error: function(data) {
                console.log(data.responseText);
                $('#myTable').DataTable();
                html =
                    `
                <tr>
                    <td colspan="6">ไม่มีข้อมูลในขณะนี้</td>
                </tr>
                `
                $('#body').html(html);
                $('#loading').remove();
            }
        });

    })

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

    async function doConfirm(id) {
        document.getElementById('confirmbtn' + id).disabled = true;
        document.getElementById('rejectbtn' + id).disabled = true;
        await submit(id, 1);
    }

    async function doReject(id) {
        document.getElementById('confirmbtn' + id).disabled = true;
        document.getElementById('rejectbtn' + id).disabled = true;
        await submit(id, 2);
    }

    async function sendline(message, token) {
        let tokenList = token.split(',');
        const urlLine = 'https://linenotifyapi.herokuapp.com/';
        $.ajax({
            url: urlLine,
            type: 'POST',
            headers: {
                'Access-Control-Allow-Origin': '*',
                'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE, OPTIONS',
                'Access-Control-Allow-Headers': 'Content-Type, Authorization, X-Requested-With',
            },
            data: {
                message: message,
                token: tokenList
            }
        }).then(function() {
            setTimeout(() => {
                window.location.reload();
            }, 100);
        });
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
        // console.log(total_del);
    }

    function delAll() {
        document.getElementById('del').value = total_del.join(',');
        // console.log($('#del').val());
        let title = total_del.length > 1 ? 'คุณต้องการลบ ' + total_del.length + ' ข้อมูลนี้หรือไม่?' : 'คุณต้องการลบข้อมูลนี้หรือไม่?'
        DelLog($('#del').val(), title);

    }

    function DelLog(id, title = 'คุณต้องการลบข้อมูลนี้หรือไม่?') {
        swal({
                title: title,
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
                        url: "plugin/del_log.php",
                        dataType: "json",
                        data: {
                            id: id,
                            table: "data_claim_first"
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

    function submit(id, type) {
        // console.log(id);
        // console.log(response);
        $.ajax({

            type: "POST",
            url: "plugin/claimcheck.php",
            dataType: "json",
            data: {
                id: id,
                type: type,
            },

            beforeSend: function() {
                swal("กำลังดำเนินการ กรุณารอสักครู่...", {
                    button: false,
                    closeOnClickOutside: false,
                    timer: 500,
                });

            },

            success: function(data) {
                if (data.code == "200") {
                    swal(data.msg, '\n', "success", {
                        button: false,
                        closeOnClickOutside: false,
                    });
                    // console.log(data.line);
                    sendline(data.line[0].massage, data.line[1].token);
                } else {
                    swal(data.msg, "\n", "error", {
                        button: {
                            className: 'hyper-btn-notoutline-danger',
                        },
                        closeOnClickOutside: false,
                    });
                }
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

    function loadimg(claim_id, id) {
        $.ajax({
            type: "POST",
            url: "plugin/claim_img.php",
            dataType: "json",
            data: {
                action: 'getimg',
                type: 1,
                claim_id: claim_id
            },
            success: function(data) {
                if (data.code == "200") {
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