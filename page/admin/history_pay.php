      <!-- Data Pay -->
      <h3 class="text-center mt-4 mb-4" style="color: white;">--- ประวัติรายได้ ---</h3>
      <br>
      <h4 style="color: #fff;text-align:center;">รายได้ <span class="sumtoday"></span> บาท</h4>
      <br>
      <div class="row">
        <div class="col-12 col-md-6">
          <div class="form-group">
            <div class="btn btn-danger w-100" id="picker">
              <i class="fa fa-calendar"></i> &nbsp;
              <span id="time"></span>
            </div>
          </div>
          <script>
            $('#time').html(moment().format('D/M/Y') + ' - ' + moment().format('D/M/Y'));
            $('#picker').daterangepicker({
              opens: 'center',
              datepicker: true,
              locale: {
                format: 'D/M/Y',
              }

            }, function(start, end) {
              $('#time').html(start.format('D/M/Y') + ' - ' + end.format('D/M/Y'));
              RangeIncome(start.format('Y-M-D'), end.format('Y-M-D'));
            });
          </script>
        </div>
        <div class="col-12 col-md-6">
          <div class="form-group">
            <div class="btn btn-dark w-100" onclick="AllIncome()">
              คลิกเพื่อโหลดประวัติการเติมเงินทั้งหมด
            </div>
          </div>
        </div>
      </div>
      <div class="table-responsive mt-3">
        <table id="myTable" class="table table-hover text-center w-100">
          <thead class="hyper-bg-dark">
            <tr>
              <th scope="col" style="width:120px;">เลขที่รายการ</th>
              <th scope="col">บัญชีผู้ใช้</th>
              <th scope="col">Link</th>
              <th scope="col">จำนวน</th>
              <th scope="col" style="width: 170px;">วันที่-เวลา</th>
            </tr>
          </thead>
          <tbody id="body">
          </tbody>
          </tbody>
        </table>
        <div id="loading" class="container" style="color: #FFF;" align="center">
          <div class="spinner-border" role="status">
          </div>
        </div>
        <br>
      </div>
      <!-- End Pay  -->

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
      <script>
        let isSandbox = window.location.origin == "https://sandbox.dexystore.me";
        let host = window.location.origin == "http://localhost" ? "http://localhost/dexystore" : isSandbox ? "https://sandbox.dexystore.me" : "https://dexystore.me";
        let url = host + '/plugin/getincome.php';
        let getid = window.location.search.split('id=')[1] || false;

        $(document).ready(async () => {
          await RangeIncome(moment().format('Y-M-D'), moment().format('Y-M-D'));
        })

        function RangeIncome(start, end) {
          $('#myTable').DataTable().destroy();
          $('#body').html('');
          $('#loading').show();
          $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            data: {
              action: 'todayincome',
              start: start,
              end: end
            },
            success: function(json) {
              console.log(json);
              if (json.code == 200) {
                const data = json.data;
                let body = $('#body').html();
                let html = '';
                let total = 0;
                for (let i = 0; i < data.length; i++) {
                  body += `
                  <tr>
                    <td>${i+1}</th>
                    <td>${data[i].username}</th>
                    <td>${data[i].link}</th>
                    <td>${data[i].amount}</th>
                    <td>${data[i].date}</th>
                  </tr>
                `;
                  total += parseInt(data[i].amount);
                }

                $('#body').html(body);
                $('#myTable').DataTable();
                $('.dataTables_empty').html('ยังไม่มีรายได้ในขณะนี้');
                $('.sumtoday').html(new Intl.NumberFormat().format(total));
                $('#loading').hide();
              }
            },
            error: function(data) {
              console.log(data.responseText);
              $('#myTable').DataTable();
              html =
                `
                  <tr>
                      <td colspan="6">เกิดข้อผิดพลาด</td>
                  </tr>
                `
              $('#body').html(html);
              $('#loading').remove();
            }
          });
        }

        function AllIncome() {
          $('#myTable').DataTable().destroy();
          $('#body').html('');
          $('#loading1').show();
          $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            data: {
              action: 'getincome'
            },
            success: function(json) {
              console.log(json);
              if (json.code == 200) {
                const data = json.data;
                let body = $('#body').html();
                let html = '';
                let total = 0;
                for (let i = 0; i < data.length; i++) {
                  body += `
                            <tr>
                              <td>${i+1}</th>
                              <td>${data[i].username}</th>
                              <td>${data[i].link}</th>
                              <td>${data[i].amount}</th>
                              <td>${data[i].date}</th>
                            </tr>
                          `;
                  total += parseInt(data[i].amount);
                }
                $('#body').html(body);
                $('#myTable').DataTable();
                $('.dataTables_empty').html('ยังไม่มีรายได้ในขณะนี้');
                $('.sumtoday').html(new Intl.NumberFormat().format(total))
                $('#loading1').hide();
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
        }
      </script>