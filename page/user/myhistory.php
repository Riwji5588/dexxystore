<!-- MyID -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">



<div class="row justify-content-center">
  <!--card-->
  <div class="card col-12 col-md-3 col-sm-2">
    <div class="card-body">
      <span>Order : <b>111</b> </span>
      <span>สินค้า : <b>111</b> </span><br> <span>วันที่ซื้อสินค้า : <b>111</b> </span>
      <p> สถานะ : ยังไม่หมดอายุ</p>
    
        <button class="btn btn-success btn-sm" type="button" data-toggle="modal" data-target="#datamodal<?= $selled['selled_id']; ?>">แสดงไอดี</button>
        <button class="btn btn-warning btn-sm" type="button" data-toggle="modal" data-target="#datamodal1<?= $selled['selled_id']; ?>" style="color: ;"><i class="fas fa-exclamation-triangle"></i> แจ้งปัญหา</button>
 
    </div>
  </div>

  











</div>


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

  .table-hover:hover {
    background-color: #ddd;
  }

  .card {
    margin-bottom: 12px;
    margin-left: 12px;
  }
</style>