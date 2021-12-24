      <!-- Data Pay -->
      <h3 class="text-center mt-4 mb-4" style="color: white;">--- ประวัติรายได้ทั้งหมด ---</h3>

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
        $(document).ready(async () => {
          let isSandbox = window.location.origin == "https://sandbox.dexystore.me";
          let host = window.location.origin == "http://localhost" ? "http://localhost/dexxystore" : isSandbox ? "https://sandbox.dexystore.me" : "https://dexystore.me";
          let url = host + '/plugin/getincome.php';
          let getid = window.location.search.split('id=')[1] || false;
          $.ajax({

            type: "POST",
            url: url,
            dataType: "json",
            data: {
              action: 'getincome',
              type: 1
            },
            success: function(json) {
              if (json.code == 200) {
                const data = json.data;
                let body = $('#body').html();
                let html = '';
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
                }
                $('#body').html(body);
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
      </script>