<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<div class="table-responsive mt-3">
    <table id="datatable" class="table table-hover text-center w-100">
        <thead class="hyper-bg-dark">
            <tr>
                <th scope="col" style="width:120px;">เลขที่บัญชี</th>
                <th scope="col">บัญชีผู้ใช้</th>
                <th scope="col">Point</th>
                <th scope="col">ระดับ</th>
                <th scope="col" style="width: 170px;">เมนู</th>
            </tr>
        </thead>
        <tbody>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <button class="btn btn-sm hyper-btn-notoutline-success" type="button" data-toggle="modal" data-target="#editusermodal"><i class="fal fa-edit mr-1"></i> แก้ไข</button>
                    <button type="button" class="btn btn-sm  btn-warning" data-toggle="modal" data-target="#editusermodal1"><i class="fas fa-exclamation-triangle"></i>แก้ไขปัญหา</button>
                </td>
                <!-- aleart Data Modal -->
                <div class="modal fade" id="editusermodal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 radius-border-2 hyper-bg-white">
                            <div class="modal-header 1hyper-modal-header" style="   background-color: #ffc107;">
                                <h6 class="modal-title"><i class="fal fa-info-circle mr-1"></i> แจ้งปัญหาในการใช้งาน</h6>
                            </div>
                            <div class="modal-body text-left">

                                <span><b>ชื่อผู้ใช้งาน</b></span><br>
                                <input class="w3-input w3-border user" type="text" value=" dsadasda" readonly></input><br>
                                <span><b>รหัสผ่าน</b></span><br>
                                <input class="w3-input w3-border pass" type="text" value="" readonly> </input><br>
                                <span><b>รายละเอียด</b></span><br>
                                <input class="w3-input w3-border detail" type="text" value="" readonly> </input><br>
                                <span><b>วันหมดอายุ</b></span>
                                <br>
                                <input class="w3-input w3-border expdate" type="text" value="" readonly> </input>
                                <br>
                                <div class="input-group   input-group-sm">
                                    <span><b>แจ้งปัญหาการใช้งาน</b></span><br>

                                </div>
                                <textarea id="detailnew" name="detailnew" class="form-control form-control-sm hyper-form-control h" readonly></textarea>


                                <div class="modal-footer p-2 border-0">

                                    <button type="button" class="btn hyper-btn-notoutline-danger" data-dismiss="modal"><i class="fad fa-times-circle mr-1"></i>ปิดหน้าต่าง</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End aleart Data Modal -->
                <!-- accept Data Modal -->
                <div class="modal fade" id="editusermodal1" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 radius-border-2 hyper-bg-white">
                            <div class="modal-header hyper-modal-header " style=" background-color: #36A558;">
                                <h6 class="modal-title" style=" color: white;"><i class="fal fa-info-circle mr-1"></i> แก้ไขปัญหา</h6>
                            </div>
                            <div class="modal-body text-left">
                                <span><b>ปัญหา</b></span><br>
                                <select id="language" class="selectpicker drop">
                                    <option value="user">ปัญหาด้านลูกค้า</option>
                                    <option value="tec">ปัญหาด้านเทคนิค</option>
                                </select><br><br>
                                <div id="value">
                                <span><b>คำแนะนำให้ลูกค้า</b></span>
                                <textarea id="detailnew" name="detailnew" class="form-control form-control-sm hyper-form-control h" readonly></textarea>
                                </div>
                                <script type="text/javascript">
                                    function update() {
                                        var select = document.getElementById('language');
                                        var option = select.options[select.selectedIndex];

                                        document.getElementById('value').value = option.value;
                                        document.getElementById('text').value = option.text;
                                    }

                                    update();
                                </script>




                                <div class="modal-footer p-2 border-0">
                                    <button type="button" class="btn hyper-btn-notoutline-danger" data-dismiss="modal"><i class="fad fa-times-circle mr-1"></i>ปิดหน้าต่าง</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- End accept Data Modal -->

                </td>
            </tr>

        </tbody>
    </table>
</div>
<style>
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
</style>