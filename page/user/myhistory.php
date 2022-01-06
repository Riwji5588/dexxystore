<!-- MyID -->
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->

<?php

$sql_select_selled = "SELECT * FROM data_selled WHERE ac_id = $ac_id ORDER BY selled_id DESC";


?>

<h1 class="text-center mt-4 mb-2" style="color: white;">ประวัติการซื้อ</h1><br>
<div class="input-group mb-3 col-12 align-items-center">
  <span style="color: #fff">ค้นหา : &nbsp;</span>
  <input id="search" type="text" class="form-control hyper-form-control col-6 col-md-3 " placeholder="ออเดอร์ สินค้า วันที่ซื้อสินค้า สถานะ" onkeyup="search(this, '<?= $sql_select_selled ?>')">
</div>
<h5 class="text-center mt-1 mb-4" style="color: white;">การต่อวันประกันสินค้า +30 วัน ควรต่อก่อนวันหมดประกันจริง</h5>
<!--card-->


<!-- DATA can be change in plugin/search.php! -->
<div id="result" class="row justify-content-center" style="width: 100%;"></div>

<!-- add img modal -->
<div class="modal fade" id="addimg" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-xl">
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
            <div id="inaddimg" class="carousel slide" data-ride="carousel" style="padding: 10px;">
              <ol class="carousel-indicators">
                <li data-target="#inaddimg" data-slide-to="0" class="active"></li>
              </ol>
              <div class="carousel-inner">
                <div class="carousel-item active" align="center">
                  <img src="assets/img/img.gif" class="d-block w-100" alt="...">
                </div>
              </div>
              <button class="carousel-control-prev" type="button" data-target="#inaddimg" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-target="#inaddimg" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </button>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" href="https://img.in.th" target="_blank">ไปที่เว็บ</a>
        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>

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
              </ol>
              <div class="carousel-inner">
                <div class="carousel-item active" align="center">
                  <img src="assets/img/changeSub.png" class="d-block w-100 carousel" alt="...">
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
        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>
<!-- video modal -->
<div class="modal fade" id="video" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body" align="start">
        <h4 class="mt-5 tabcenter">การเปลี่ยนความชัดวิดีโอ</h4>
        <p class="tabcenter showmb" style="font-weight: bold;">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ความชัดของวิดีโอจะขึ้นอยู่กับความเร็วของตัวเครื่อง <u>ไม่สามารถปรับเองได้</u>
        </p>
        <p class="tabcenter showpc" style="font-weight: bold;">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ความชัดของวิดีโอจะขึ้นอยู่กับความเร็วของตัวเครื่อง <br><u>ไม่สามารถปรับเองได้</u>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>

<script>
  // on Ready Load history Data
  $(document).ready(function() {
    search($('#search'), '<?= $sql_select_selled ?>');
  });

  async function dosomething(id) {
    document.getElementById('claimbtn' + id).disabled = true;
    await claim(id)
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

  // search with ajax
  function search(input, sql) {
    var search = $(input).val();
    // is search empty console.log boolean
    search = search == "" ? 'ttt' : search
    var xhttp = new XMLHttpRequest();
    if (search != '') {
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("result").innerHTML = this.responseText;
        }
      };
      xhttp.open("GET", "plugin/search.php?search=" + search + "&sql=" + sql, true);
      xhttp.send(200);
      document.getElementById("result").innerHTML = XMLHttp.responseText;
    }
  }

  function renew(id) {
    var card_id = $('#card_id' + id).val();
    console.log(card_id);
    swal({
        title: 'ต้องการต่อวันประกันสินค้านี้หรือไม่',
        text: "การต่อวันประกันจะ +30 วัน หลังจากวันหมดประกันเดิม\n" + $('#price' + id).text(),
        icon: "info",
        buttons: {
          confirm: {
            text: 'ยืนยัน',
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
            url: "plugin/buyitem.php",
            dataType: "json",
            data: {
              type: 2,
              id: card_id,
              selled_id: id
            },

            beforeSend: function() {
              swal("กำลังซื้อสินค้า กรุณารอสักครู่...", {
                button: false,
                closeOnClickOutside: false,
                timer: 500,
              });

            },

            success: function(data) {
              setTimeout(() => {
                if (data.code == "200") {
                  swal({
                    title: 'ต่ออายุการใช้งาน สำเร็จ!',
                    text: 'ออเดอร์ที่ ' + data.order + ' ได้ต่ออายุการใช้งานแล้ว!',
                    icon: "success",
                    closeOnClickOutside: false,
                    button: false,
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

  function copy(input) {
    let id = input.id + '1';
    var copyText = document.getElementById(id);
    copyText.select();
    copyText.setSelectionRange(0, 99999)
    document.execCommand("copy");
    input.innerHTML = "คัดลอกแล้ว";
    input.className = "btn btn-success btn-sm";
    setTimeout(function() {
      input.innerHTML = "คัดลอก";
      input.className = "btn btn-dark btn-sm";
    }, 2000);
  }


  function claim(id) {
    var checkdetail = document.getElementById("detail" + id).value;
    // check detail if empty
    detail = checkdetail.substring(0, 2) == " " || checkdetail.substring(0, 1) == " " || checkdetail == "" ? "" : checkdetail;
    $.ajax({

      type: "POST",
      url: "plugin/claim.php",
      dataType: "json",
      data: {
        id: id,
        detail: detail,
        type: 1
      },

      beforeSend: function() {
        swal("กำลังส่งเคลม กรุณารอสักครู่...", {
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
          sendline(data.line[0].massage, data.line[1].token);
        } else {
          swal(data.msg, "\n", "error", {
            button: {
              className: 'hyper-btn-notoutline-danger',
            },
            closeOnClickOutside: false,
          });
          setTimeout(function() {
            window.location.reload();
          }, 1000);
        }

      }

    });
  }
</script>

<style>
  @media screen and (min-width: 1200px) {
    .tabcenter {
      padding-left: 60px;
    }

    .showmb {
      display: none;
    }

  }

  @media screen and (max-width: 1199px) {
    .showpc {
      display: none;
    }

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

  .table-hover:hover {
    background-color: #ddd;
  }

  .card {
    margin-bottom: 12px;
    margin-left: 12px;
  }

  .color {
    background-color: #cfcfcf;
  }

  u {
    color: #b80000;
  }
</style>