<?php
include '../include/config.php';
include '../include/common.php';
include '../include/setting.php';

CheckUserLogin_Fornt();

// Read parameters
$sACT = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';

$oDB = new DBI();


$sUserID = isset($_SESSION['aupro_member_id']) ? $_SESSION['aupro_member_id'] : '';

$sStatus = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
$sID = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
$sSALEID = isset($_REQUEST['saleid']) ? $_REQUEST['saleid'] : '';

if ($sUserID) {
    $dataUserinfo = $oDB->QueryRow("SELECT * FROM tbl_user_login WHERE id='" . $sUserID . "'", DBI_ASSOC);
    $dataUserinfo['pic_url'] = USERIMG_URL . $dataUserinfo['picture'];
}

$axSql_Customer = $oDB->Query("SELECT * FROM tbl_customer WHERE approve_status = 'A' ");
while ($asResult = $axSql_Customer->FetchRow(DBI_ASSOC)) {
	if ($asResult['member'] == 'M') {
	   $asResult['smember'] = 'Member';
	}elseif ($asResult['member'] =='P' ){
	   $asResult['smember'] = 'Premium Member';
	}elseif ($asResult['member']=='V'){
	  $asResult['smember'] = 'VIP Member';
	}
  	$asCustomer[] = $asResult;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PharmaPro: RoongRuang Pharmacy</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="/PharmaPro/alte/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/PharmaPro/alte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/PharmaPro/alte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

    <!-- sweetalert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Theme style -->
    <link rel="stylesheet" href="/PharmaPro/alte/plugins/daterangepicker/daterangepicker.css">

    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="/PharmaPro/alte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="/PharmaPro/alte/plugins/select2/css/select2.min.css">
    <!--  ต้องอยู่ต่ำกว่า all.min.css -->
    <link rel="stylesheet" href="/PharmaPro/alte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Theme style -->

    <link rel="stylesheet" href="/PharmaPro/alte/plugins/summernote/summernote-bs4.min.css">

    <link rel="stylesheet" href="../public/customCSS/custom_css1.css">
    <link rel="stylesheet" href="/PharmaPro/alte/dist/css/adminlte.min.css">


    <script src="/PharmaPro/alte/plugins/jquery/jquery.min.js"></script>

    <style>
    /* ซ่อน textarea เริ่มต้น */
    #du_detail {
        display: none;
    }
    </style>

    <style>
    /* เมื่อมี element ข้างในถูก focus (เช่น radio) */
    .payment-card:focus-within {
        background-color: #525252ff !important;
        /* color: #605ca8; */
        border: 5px solid #000000ff !important;
    }

    .button-focus-card .btn-success:focus,
    .button-focus-card .btn-success:focus-visible {
        outline: none;
        box-shadow: 0 0 10px 4px rgba(40, 167, 69, 0.8);
        /* เขียวเข้ม + หนา */
        transition: box-shadow 0.15s ease-in-out;
    }

    .button-focus-card .btn-warning:focus,
    .button-focus-card .btn-warning:focus-visible {
        outline: none;
        box-shadow: 0 0 10px 4px rgba(255, 193, 7, 0.8);
        /* เหลืองเข้ม + หนา */
        transition: box-shadow 0.15s ease-in-out;
    }
    </style>

</head>

<body class="hold-transition sidebar-collapse layout-top-nav" onload="updateTime()">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include("l_main_head.php"); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include("l_menu.php"); ?>


        <?php
		if ($sACT == 'edit') {
			$axSql = $oDB->Query("SELECT * FROM tbl_sales WHERE sale_id='" . $sSALEID . "' ");
			while ($asResult = $axSql->FetchRow(DBI_ASSOC)) {

				$asData = $asResult;
			}

            $axSql_items = $oDB->Query("SELECT si.quantity, si.price, si.discount, si.total_price, p.id AS product_id, p.brand_name, p.quantity_in_stock
            FROM tbl_sale_items si
            LEFT JOIN tbl_product p ON si.product_id = p.id
            WHERE si.sale_id = '" . $sSALEID . "' AND si.approve_status = 'A'
            ");			
            while ($asResult_items = $axSql_items->FetchRow(DBI_ASSOC)) {

				$asData_items[] = $asResult_items;
			}

            echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                var orderRowCount = $("#ordertable tbody tr").length + 1;';
                
            foreach ($asData_items as $item) {
                $drugid = $item['product_id'];
                $productName = addslashes($item['brand_name']);
                $quantity = $item['quantity'];
                $price = $item['price'];
                $discount = $item['discount'];
                $quantityStock = $item['quantity_in_stock'];
            
                // คำนวณ total
                $total = ($price * $quantity) - $discount;
            
                echo "
                var newRow = `
                    <tr>
                        <td data-drugid=\"{$drugid}\">\${orderRowCount}</td>
                        <td><div style=\"text-align: left; padding-left:10px\">{$productName}</div></td>
                        <td class=\"quantity\" data-quantity-stock=\"{$quantityStock}\">{$quantity}</td>
                        <td>" . number_format($price, 2) . "</td>
                        <td class=\"discount\">" . number_format($discount, 0) . "</td>
                        <td class=\"total\">" . number_format($total, 2) . "</td>
                        <td>
                            <i class=\"fas fa-search\" style=\"font-size: 16px; color: #FD7E14 ; margin-right: 10px; cursor: pointer;\"
                               data-toggle=\"modal\" data-target=\"#viewDrug\"
                               onclick=\"sendValueDrug('{$drugid}','sDrug')\"></i>
                            <i class=\"fa-regular fa-rectangle-xmark delete-btn\" style=\"color: red; font-size:20px; padding-top:5px; cursor: pointer;\" data-toggle=\"tooltip\" title=\"\"></i>
                        </td>
                    </tr>
                `;
                $('#ordertable tbody').append(newRow);
                orderRowCount++;
                ";
            }
            
            // เตรียม remark
            $remarkJS = json_encode($asData['remark']);
            
            echo "
                // ตั้งค่า remark และควบคุมการแสดงผลของ summernote
                setTimeout(function() {
                    var remarkContent = {$remarkJS};
            
                    if (typeof $('#remark').summernote === 'function') {
                        $('#remark').summernote('code', remarkContent);
            
                        if (remarkContent.trim() !== '') {
                            $('#summernote-container').slideDown(400);
                            $('#toggleButton').text('ซ่อนรายละเอียดเพิ่มเติม');
                        } else {
                            $('#summernote-container').hide();
                            $('#toggleButton').text('แสดงรายละเอียดเพิ่มเติม');
                        }
                    }
                }, 800);
            ";
            
            echo '
                calculateTotals();
                setupEditableListeners();
            });
            </script>';
                                    
            $action = 'update';
            
        } elseif ($sACT == 'update') {

        }
        ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <!-- Main content -->
            <section class="content pt-3 px-4">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                            <div class="card card-info" style="background-color: #72C585;">
                                <div class="card-header" style="background-color: #DC3545;">
                                    <!-- <h3 class="card-title">ข้อมูลสินค้า</h3> -->
                                </div>
                                <div class="row mt-3 mx-3">

                                    <!-- first -->
                                    <div class="col-sm-2">

                                        <div class="row justify-content-center custom-row">
                                            <div class="col-md-12">
                                                <div class="card w-100" style="border-radius: 15px;">
                                                    <div class="card-body d-flex justify-content-center align-items-center"
                                                        style="background-color: #605ca8; font-size: 20px; color: white; border: 5px solid #DEE2E6; border-radius: 15px; height: 80px;">
                                                        <?php echo "คุณ " . $dataUserinfo['full_name']; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row justify-content-center custom-row">
                                            <div class="col-md-12 d-flex justify-content-center">
                                                <div class="card text-center w-100" style="border-radius: 15px;">
                                                    <!-- เพิ่ม border-radius ที่การ์ด -->
                                                    <div class="card-body"
                                                        style="background-color: #F012BE; color: white; border: 5px solid #DEE2E6; border-radius: 15px;">
                                                        <!-- เพิ่ม border-radius ที่การ์ดบอดี้ -->
                                                        <p
                                                            style="color: #FCFF84; text-align: center; padding-top:10px; font-size: 26px;">
                                                            ข้อมูลประจำวัน</p>
                                                        <p id="rowTotalToday"
                                                            style="text-align: center; padding-top:5px; font-size: 20px;">
                                                            รายการสินค้า 0 รายการ</p>
                                                        <p id="quantityTotalToday"
                                                            style="text-align: center; padding-top:5px; font-size: 20px;">
                                                            จำนวนสินค้า 0 ชิ้น</p>
                                                        <p id="cashTotalToday"
                                                            style="text-align: center; padding-top:5px; font-size: 20px;">
                                                            เงินสด 0 บาท</p>
                                                        <p id="transferTotalToday"
                                                            style="text-align: center; padding-top:5px; font-size: 20px;">
                                                            เงินสด 0 บาท</p>
                                                        <p id="totalAmountToday"
                                                            style="text-align: center; padding-top:5px; font-size: 20px;">
                                                            จำนวนเงิน 0 บาท</p>
                                                        <p id="profitToday"
                                                            style="text-align: center; padding-top:5px; font-size: 20px;">
                                                                กำไร 0 บาท
                                                            </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- first -->

                                    <!-- second  -->
                                    <div class="col-sm-7">

                                        <div class="row">
                                            <div class="col-md-12 ">
                                                <div class="card w-100"
                                                    style="background-color: #E83E8C; margin-bottom:10px;border: 5px solid #DEE2E6; border-radius: 10px;">
                                                    <div class="card-body"
                                                        style="padding-top: 15px;padding-bottom: 0px;">
                                                        <div class="row">
                                                            <!-- คอลัมน์ที่ 1 -->
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <select class="form-control select2"
                                                                        name="member_customer" id="member_customer"
                                                                        onchange="showSelectedValue()">
                                                                        <?php foreach ($asCustomer as $sCustomer) { ?>
                                                                        <option value="<?php echo $sCustomer['id']; ?>"
                                                                            data-member="<?php echo $sCustomer['member']; ?>"
                                                                            <?= ($sCustomer['id'] == $asData['customer_id']) ? 'selected' : ''; ?>>
                                                                            <?php echo $sCustomer['customer_name']; ?>
                                                                        </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div> <!-- คอลัมน์ที่ 2 -->
                                                            <div class="col-md-7"
                                                                style="display: flex; justify-content: center; align-items: center; height: 100%;">
                                                                <div style="text-align: center;">
                                                                    <p style="display: inline-block; font-size: 22px; color: white; margin: 0;"
                                                                        id="selected-customer_info"></p>
                                                                    <!-- <p style="display: inline-block; font-size: 22px; color: white; margin: 0;">&nbsp;|&nbsp;</p>
													<p style="display: inline-block; font-size: 22px; color: white; margin: 0;">Basic Member</p> -->
                                                                </div>

                                                            </div>
                                                            <!-- คอลัมน์ที่ 3 -->
                                                            <div class="col-md-2 text-right">
                                                                <button type="button" class="btn btn-warning"
                                                                    data-toggle="modal" data-target="#searchproduct"
                                                                    id="btnSearchProduct">ค้นหาสินค้า</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <table id="ordertable">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>ชื่อทางการค้า</th>
                                                                <th>จำนวน</th>
                                                                <th>มูลค่า</th>
                                                                <th>ส่วนลด</th>
                                                                <th>รวม</th>
                                                                <th>ลบ</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-5">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-info w-20 mb-2"
                                                        id="toggleButton">แสดงรายละเอียดเพิ่มเติม</button>
                                                    <br>
                                                    <div id="summernote-container">
                                                        <textarea name="remark" id="remark" rows="20"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- col-sm-8  -->
                                    <!-- second -->

                                    <!-- third -->
                                    <div class="col-sm-3">

                                        <div class="row justify-content-center custom-row">
                                            <div class="col-md-8 d-flex justify-content-center">
                                                <div class="card text-center w-100"
                                                    style="background-color: #FD7E14; color: white; border: 5px solid #DEE2E6;">
                                                    <div class="card-body">
                                                        <h3>
                                                            <p id="curdate"></p>
                                                        </h3>
                                                        <h3>
                                                            <p id="curtime"></p>
                                                        </h3>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 d-flex justify-content-center">
                                                <div class="card text-center w-100">
                                                    <div class="card-body pl-0 pr-0 py-0">
                                                        <img src="<?php echo $dataUserinfo['pic_url']; ?>"
                                                            class="img-fluid img-thumbnail"
                                                            style="width: auto; height: 145px;" alt="Photo">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center custom-row">
                                            <div class="col-md-12 d-flex justify-content-center ">
                                                <div class="card  w-100"
                                                    style="background-color: #0066CB; color: #FCFF84; border: 5px solid #DEE2E6;">
                                                    <div class="card-body py-1">

                                                        <p style="text-align: center; padding-top:30px; font-size: 26px; color:white;"
                                                            id=totalRows></p>
                                                        <p style="text-align: center; padding-top:0px; font-size: 26px; color:white;"
                                                            id=totalNumber></p>
                                                        <p style="text-align: center; padding-top:0px; font-size: 26px; color:white;"
                                                            id=totalDiscount></p>
                                                        <p style="text-align: center; padding-top:10px; padding-bottom:10px; font-size: 36px;"
                                                            id=total></p>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="payment-card" class="card-body payment-card" tabindex="-1"
                                            style="background-color: #265e1eff; color: white; border: 5px solid #DEE2E6; margin-bottom: 6px;">
                                            <!-- เพิ่ม border-radius ที่การ์ดบอดี้ -->
                                            <div class="d-flex justify-content-between align-items-center pl-5 pr-5">
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input custom-control-input-red"
                                                        type="radio" id="customRadio1" name="sPayment" value="C"
                                                        <?= ($asData['payment'] != 'T') ? 'checked' : '' ?>>
                                                    <label for="customRadio1"
                                                        class="custom-control-label">เงินสด</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input custom-control-input-red"
                                                        type="radio" id="customRadio2" name="sPayment" value="T"
                                                        <?= ($asData['payment'] == 'T') ? 'checked' : '' ?>>
                                                    <label for="customRadio2"
                                                        class="custom-control-label">โอนเงิน</label>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row justify-content-center custom-row">
                                            <div class="col-md-12 d-flex justify-content-center">
                                                <div class="card text-center w-100"
                                                    style="background-color: #FD7E14; color: white; border: 5px solid #DEE2E6;">
                                                    <div class="card-body d-flex align-items-center mt-2">
                                                        <p class="mb-0"
                                                            style="width: 30%; text-align: center; font-size:24px; margin-right: -10px;">
                                                            รับเงิน</p>
                                                        <input type="number" name="recieve_cash" id="recieve_cash"
                                                            value="" class="form-control"
                                                            style="width: 40%; font-size: 24px;" placeholder="฿"
                                                            min="0">
                                                        <p class="mb-0"
                                                            style="width: 30%; text-align: center; font-size:24px; margin-left: -15px;">
                                                            บาท</p>
                                                    </div>
                                                    <p class="mb-3"
                                                        style="text-align: center; font-size:30px; margin-top: 0px;"
                                                        id="change">เงินทอน: 0 บาท</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center custom-row">
                                            <div class="col-md-12 d-flex justify-content-center">
                                                <div class="card text-center w-100 button-focus-card">
                                                    <div class="card-body d-flex justify-content-between py-4">
                                                        <button type="submit" class="btn btn-success w-50 mx-2"
                                                            value="save">บันทึกข้อมูล</button>
                                                        <button type="submit" class="btn btn-warning w-50 mx-2"
                                                            value="clear"
                                                            onclick="confirmClearOrderTable()">ล้างข้อมูล</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- third -->

                                    <!-- Model -->
                                    <div class="modal fade" id="searchproduct">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Drug List</h4>
                                                    <button type="button" class="close"
                                                        data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <table id="s_product" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>ชื่อสามัญของยา</th>
                                                                <th>ชื่อการค้าของยา</th>
                                                                <th>หมายเลขล็อต</th>
                                                                <th>ผู้จัดจำหน่าย</th>
                                                                <th>จำนวนคงเหลือ</th>
                                                                <th>ราคาทุน</th>
                                                                <th>ราคาขายปลีก</th>
                                                                <th>ราคาสมาชิก</th>
                                                                <th>วันหมดอายุ</th>
                                                                <th>เลือก</th>
                                                            </tr>
                                                        </thead>
                                                        <!-- ผลลัพธ์จะแสดงที่นี่ -->
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Model -->
                                    <!-- Model Customer-->
                                    <div class="modal fade" id="viewCustomer" tabindex="-1" role="dialog"
                                        aria-labelledby="viewCustomerLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="viewCustomerLabel"><strong>Customer
                                                            Datails</strong> <small>(รายละเอียดของลูกค้า)</small>
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" id="modalCustomer">
                                                    <!-- เนื้อหา Modal -->
                                                    <!-- ข้อมูลลูกค้าแสดงที่นี่ -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Model -->
                                    <!-- Model Drug-->
                                    <div class="modal fade" id="viewDrug" tabindex="-1" role="dialog"
                                        aria-labelledby="viewCustomerLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="viewCustomerLabel"><strong>Drug
                                                            Datails</strong> <small>(รายละเอียดของยา)</small></h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" id="modalDrug">
                                                    <!-- เนื้อหา Modal -->
                                                    <!-- ข้อมูลลูกค้าแสดงที่นี่ -->
                                                </div>
                                                <!-- <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		</div> -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Model -->


                                </div> <!-- row -->
                                <!-- third -->
                                <div class="card-footer">
                                    <!-- <button type="submit" class="btn btn-success btn-block" value="save" onClick="return chkPass();">Save</button>
									<input name="du_id" type="hidden" id="du_id" value="1" />
								<input name="act" type="hidden" id="act" value="" /> -->
                                </div>
                            </div> <!-- card card-info -->

                        </div> <!-- col-12 -->
                    </div> <!-- row -->

                </div> <!-- container-fluid  -->

            </section>

        </div>

        <!-- /.content-wrapper -->

        <?php include("l_footer.php");  ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <!-- AdminLTE App -->

    <!-- Script ตาราง -->
    <!-- <script src="/PharmaPro/alte/plugins/jquery/jquery.min.js"></script> -->

    <!-- <script src="/PharmaPro/alte/plugins/datatables/jquery.dataTables.min.js"></script> -->
    <script src="/PharmaPro/alte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="/PharmaPro/alte/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/PharmaPro/alte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/PharmaPro/alte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/PharmaPro/alte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="/PharmaPro/alte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/PharmaPro/alte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>

    <script src="/PharmaPro/alte/plugins/select2/js/select2.full.min.js"></script>
    <!-- InputMask -->
    <script src="/PharmaPro/alte/plugins/moment/moment.min.js"></script>

    <!-- date-range-picker -->
    <script src="/PharmaPro/alte/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="/PharmaPro/alte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>



    <script src="/PharmaPro/alte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="/PharmaPro/alte/plugins/summernote/summernote-bs4.min.js"></script>

    <!-- AdminLTE App -->
    <script src="/PharmaPro/alte/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="/PharmaPro/alte/dist/js/demo.js"></script>

    <!-- Page specific script -->
    <script src="/PharmaPro/alte/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script>
    $(function() {
        bsCustomFileInput.init();
    });
    </script>

    <script>
    $(function() {
        $("#s_product").DataTable({
            "responsive": false,
            "lengthChange": false,
            "autoWidth": false,
            "pageLength": 10,
            columnDefs: [{
                    targets: [1, 4],
                    visible: false
                }, // ซ่อนคอลัมน์ index 1
            ]

        });
        $('#example2').DataTable({
            "paging": true,
            "pageLength": 20,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
    </script>
    <script>
    $(function() {

        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        $('#reservationdate').datetimepicker({
            format: 'YYYY-MM-DD'
        });

        //Date and time picker
        $('#reservationdatetime').datetimepicker({
            icons: {
                time: 'far fa-clock'
            }
        });

        //Timepicker
        $('#timepicker').datetimepicker({
            format: 'HH:mm:ss'
        })

        // Summernote
        $('#remark').summernote({
            placeholder: 'กรอกรายละเอียด',
            height: 100, // กำหนดความสูงของ summernote เท่ากับ 500px ซึ่งประมาณ 20 rows
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'fontname']], //Specific toolbar display
                ['color', ['color']],
            ],
        });
    })
    </script>


    <script>
    function updateTime() {
        var currentTime = new Date(); // สร้างออบเจ็กต์ Date

        // กำหนดชื่อเดือนเป็นภาษาไทย
        var monthNamesThai = [
            "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน",
            "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม",
            "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
        ];

        var day = String(currentTime.getDate()).padStart(2, '0');
        // var month = String(currentTime.getMonth() + 1).padStart(2, '0'); // เดือนเริ่มจาก 0
        var month = monthNamesThai[currentTime.getMonth()]; // ดึงชื่อเดือนภาษาไทย
        var year = currentTime.getFullYear();

        var hours = String(currentTime.getHours()).padStart(2, '0');
        var minutes = String(currentTime.getMinutes()).padStart(2, '0');
        var seconds = String(currentTime.getSeconds()).padStart(2, '0');

        // แสดงวันที่และเวลาในรูปแบบที่ต้องการ
        // var dateTimeString = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
        var dateString = day + ' ' + month + ' ' + year;
        var TimeString = hours + ':' + minutes + ':' + seconds;
        document.getElementById('curdate').textContent = dateString;
        document.getElementById('curtime').textContent = TimeString;
    }

    // อัปเดตเวลาในทุกๆ วินาที
    setInterval(updateTime, 700);
    </script>

    <script>
    $(document).ready(function() {
        // เริ่มต้น Summernote editor
        $('#du_description').summernote({
            height: 400, // ตั้งค่าความสูงของ editor
        });

        // เริ่มต้นซ่อน Summernote container
        $('#summernote-container').hide();

        // เมื่อคลิกที่ปุ่ม toggle
        $('#toggleButton').click(function() {
            // สลับการแสดงผลของ Summernote container โดยค่อยๆ เลื่อนขึ้นลง
            $('#summernote-container').slideToggle(400, function() {
                // ใช้ callback function หลังจากที่การ toggle เสร็จสิ้น
                if ($('#summernote-container').is(':visible')) {
                    $('#toggleButton').text('ซ่อนรายละเอียดเพิ่มเติม');
                } else {
                    $('#toggleButton').text('แสดงรายละเอียดเพิ่มเติม');
                }
            });
        });
    });
    </script>

    <!-- Fetch Data -->
    <script>
    function sendValueCustomer(selectedValue, sCustomer) {
        fetch("fetch_data.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "selectedValue=" + encodeURIComponent(selectedValue) + "&sCustomer=" + encodeURIComponent(
                    sCustomer)
            })
            .then(response => response.text())
            .then(data => {
                // แสดงผลลัพธ์ที่ได้รับจาก PHP ใน Modal
                document.getElementById("modalCustomer").innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
    }

    function sendValueDrug(drugid, sDrug) {
        fetch("fetch_data.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "drugid=" + encodeURIComponent(drugid) + "&sDrug=" + encodeURIComponent(sDrug)
            })
            .then(response => response.text())
            .then(data => {
                // แสดงผลลัพธ์ที่ได้รับจาก PHP ใน Modal
                document.getElementById("modalDrug").innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
    }
    </script>

    <!-- แสดงค่าเมื่อ เลือกลูกค้า -->
    <script>
    function confirmClearOrderTable() {
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "คุณต้องการล้างข้อมูลหรือไม่?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ล้างข้อมูล',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                clearOrderTable(); // เรียกใช้ฟังก์ชันล้างข้อมูลเมื่อกด OK
                // รีเซ็ตค่า member_customer กลับเป็นค่าเริ่มต้น
                var selectElement = document.getElementById('member_customer');
                selectElement.value = selectElement.options[0].value; // ตั้งค่าเป็นตัวเลือกแรก
                selectElement.dispatchEvent(new Event('change')); // เรียก onchange เพื่อให้ค่าใหม่มีผล
            }
        });
    }

    function clearOrderTable() {
        var table = document.getElementById('ordertable');
        var tbody = table.getElementsByTagName('tbody')[0];

        // ลบแถวทั้งหมดใน tbody
        while (tbody.firstChild) {
            tbody.removeChild(tbody.firstChild);
        }
        document.getElementById("recieve_cash").value = '';

        $('#remark').summernote('code', ''); // ล้างข้อมูลใน Summernote
        $('#summernote-container').slideUp(400, function() {
            $('#toggleButton').text('แสดงรายละเอียดเพิ่มเติม');
        });

        calculateTotals(); // อัปเดตผลรวมหลังล้างข้อมูล
    }

    function showSelectedValue() {
        var select = document.getElementById("member_customer");
        var selectedOption = select.options[select.selectedIndex];
        var selectedValue = selectedOption.value;
        var selectedText = selectedOption.text;
        var selectedMember = selectedOption.getAttribute("data-member");

        // ตั้งค่าชื่อสมาชิกตามค่าใน data-member
        var memberType;
        if (selectedMember === 'M') {
            memberType = "Basic Member";
        } else if (selectedMember === 'P') {
            memberType = "Premium Member";
        } else if (selectedMember === 'V') {
            memberType = "VIP Member";
        } else {
            memberType = "Basic Member"; // หรือค่าพื้นฐานสำหรับกรณีอื่นๆ
        }

        // สร้างไอคอน `<i>` โดยส่ง selectedValue ไปยังฟังก์ชัน sendValueWithFetch()
        var infoElement = document.getElementById("selected-customer_info");
        var iconHtml = `<i class="fas fa-search" style="font-size: 16px; color: #AEAEAE ; margin-left: 5px; cursor: pointer;" 
                      data-toggle="modal" data-target="#viewCustomer" 
                      onclick="sendValueCustomer('${selectedValue}','sCustomer')"></i>`;

        // แสดงค่าที่เลือกใน <p> ที่มี id="selected-info"
        infoElement.innerHTML = `${selectedText} | ${memberType} ${iconHtml}`;
        infoElement.style.color = selectedMember === 'P' ? "yellow" : "white";

        // เรียกใช้ฟังก์ชัน clearOrderTable เพื่อล้างข้อมูลตาราง
        clearOrderTable();
    }
    // เรียกใช้ฟังก์ชันนี้ทันทีเมื่อโหลดหน้าเว็บ
    // window.onload = showSelectedValue;
    // window.addEventListener("load", showSelectedValue);
    </script>

    <!-- คำนวน จำนวนทั้งหมด -->
    <script>
    var totalColumn6 = 0;

    // ฟังก์ชันสำหรับคำนวณเงินทอน
    function updateChange() {
        var receivedCash = parseFloat(document.getElementById('recieve_cash').value); // รับค่าที่ป้อนในฟิลด์รับเงินสด
        var change = receivedCash - totalColumn6; // คำนวณเงินทอน
        var changeElement = document.getElementById('change');

        // แสดงผลลัพธ์ในแท็ก <p> ที่มี id="change" และเปลี่ยนสีหากเงินทอนน้อยกว่า 0
        changeElement.innerText = "เงินทอน: " + (isNaN(change) ? 0 : change.toFixed(2)) + " บาท";

        // เปลี่ยนสีเป็นสีแดงถ้าเงินทอนน้อยกว่า 0, สีขาวถ้าเป็นบวกหรือศูนย์
        if (change < 0) {
            changeElement.style.color = 'red';
        } else {
            changeElement.style.color = 'white';
        }
        // เรียกใช้ฟังก์ชัน updateChange เมื่อมีการพิมพ์ใน input
        document.getElementById('recieve_cash').addEventListener('input', updateChange);
    }

    // ฟังก์ชันสำหรับคำนวณผลรวมของคอลัมน์ที่ 3, 5 และ 6 และอัปเดตตัวแปร totalColumn6
    function calculateTotals() {
        var table = document.getElementById('ordertable'); // เลือกตาราง
        var rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr'); // เลือกแถวใน tbody
        var totalColumn3 = 0;
        var totalColumn5 = 0;
        totalColumn6 = 0;
        var totalRows = rows.length;

        // วนลูปผ่านแต่ละแถวและรวมค่าของคอลัมน์ที่ต้องการ
        for (var i = 0; i < rows.length; i++) {
            // คอลัมน์ที่ 3
            var cell3 = rows[i].getElementsByTagName('td')[2];
            var value3 = parseFloat(cell3.innerText);
            totalColumn3 += isNaN(value3) ? 0 : value3;

            // คอลัมน์ที่ 4 (สำหรับการคำนวณ)
            var cell4 = rows[i].getElementsByTagName('td')[3];
            var value4 = parseFloat(cell4.innerText);

            // คอลัมน์ที่ 5
            var cell5 = rows[i].getElementsByTagName('td')[4];
            var value5 = parseFloat(cell5.innerText);
            totalColumn5 += isNaN(value5) ? 0 : value5;

            // คำนวณคอลัมน์ที่ 6: (คอลัมน์ 3 * คอลัมน์ 4) - คอลัมน์ 5
            var result6 = (isNaN(value3) ? 0 : value3) * (isNaN(value4) ? 0 : value4) - (isNaN(value5) ? 0 : value5);
            totalColumn6 += result6;

            // อัพเดตค่าของคอลัมน์ที่ 6 ในแถวปัจจุบัน
            var cell6 = rows[i].getElementsByTagName('td')[5];
            cell6.innerText = isNaN(result6) ? 0 : result6.toFixed(2); // แสดงผลเป็นทศนิยม 2 ตำแหน่ง
        }

        // อัพเดตค่าผลรวมในแท็ก <p> ที่มี id="totalRows", "totalNumber", "totalColumn5", "totalColumn6"
        document.getElementById('totalRows').innerText = "รายการสินค้า: " + totalRows + " รายการ";
        document.getElementById('totalNumber').innerText = "จำนวนสิ้นค้า: " + totalColumn3 + " ชิ้น";
        document.getElementById('totalDiscount').innerText = "ราคาส่วนลด: " + totalColumn5 + " บาท";
        document.getElementById('total').innerText = "ราคารวม: " + totalColumn6 + " บาท";
        updateChange(); // คำนวณเงินทอนทุกครั้งที่อัปเดตผลรวม
    }

    // ฟังก์ชันสำหรับคำนวณเงินทอนเมื่อกด Enter ในฟิลด์รับเงินสด
    document.getElementById('recieve_cash').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') { // ตรวจสอบว่าปุ่มที่กดคือ Enter
            var receivedCash = parseFloat(this.value); // รับค่าที่ป้อนในฟิลด์
            var change = receivedCash - totalColumn6; // คำนวณเงินทอน

            // แสดงผลลัพธ์ในแท็ก <p> ที่มี id="change"
            document.getElementById('change').innerText = "เงินทอน: " + (isNaN(change) ? 0 : change) + " บาท";
        }
    });

    // ฟังก์ชันสำหรับตรวจจับการเปลี่ยนแปลงค่าในเซลล์
    function setupEditableListeners() {
        var table = document.getElementById('ordertable');
        var rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        for (var i = 0; i < rows.length; i++) {
            // เลือกคอลัมน์ที่ 3, 5, และ 6 ของแต่ละแถว
            var cell3 = rows[i].getElementsByTagName('td')[2];
            var cell5 = rows[i].getElementsByTagName('td')[4];
            var cell6 = rows[i].getElementsByTagName('td')[5];

            // เพิ่ม Event Listener keydown เพื่อป้องกันการป้อนอักขระที่ไม่ใช่ตัวเลข
            cell3.addEventListener('keydown', function(event) {
                // อนุญาตเฉพาะตัวเลข (0-9), Backspace, Delete, และลูกศร
                if (!event.key.match(/[0-9]/) &&
                    event.key !== 'Backspace' &&
                    event.key !== 'Delete' &&
                    event.key !== 'ArrowLeft' &&
                    event.key !== 'ArrowRight') {
                    event.preventDefault();
                }
            });

            cell5.addEventListener('keydown', function(event) {
                // อนุญาตเฉพาะตัวเลข (0-9), Backspace, Delete, และลูกศร
                if (!event.key.match(/[0-9]/) &&
                    event.key !== 'Backspace' &&
                    event.key !== 'Delete' &&
                    event.key !== 'ArrowLeft' &&
                    event.key !== 'ArrowRight') {
                    event.preventDefault();
                }
            });

            // อัพเดตการคำนวณผลรวมทุกครั้งที่เปลี่ยนแปลงค่าในคอลัมน์ 3, 5, หรือ 6
            cell3.addEventListener('input', calculateTotals);
            cell5.addEventListener('input', calculateTotals);
            cell6.addEventListener('input', calculateTotals);
        }
    }
    // เรียกใช้ฟังก์ชันเมื่อโหลดหน้าเว็บเสร็จ
    document.addEventListener('DOMContentLoaded', function() {
        calculateTotals(); // คำนวณผลรวมเมื่อโหลดหน้าเว็บครั้งแรก
        setupEditableListeners(); // ตั้งค่าการตรวจจับการเปลี่ยนแปลงค่า
    });
    </script>

    <!-- เลือกข้อมูลในตาราง s_product เพื่อนำไปใส่ในตาราง ordertable -->
    <script>
    $(document).ready(function() {
        // จับการคลิกที่ปุ่มเลือกใน s_product
        $('#s_product').on('click', '.select-btn', function() {

            // ดึงข้อมูลของตัวเลือกที่เลือกใน <select>
            var select = document.getElementById("member_customer");
            var selectedOption = select.options[select.selectedIndex];
            var selectedValue = selectedOption.getAttribute("data-member");
            const drugid = this.dataset.id;

            // ดึงข้อมูลจากแถวที่ถูกคลิก
            var row = $(this).closest('tr');
            var productName = row.find('.product-name').text().trim();
            var quantityStock = parseFloat(row.find('.quantity-in-stock').text().trim());
            var retailPrice

            if (selectedValue == 'P') {
                retailPrice = parseFloat(row.find('.member-price').text().trim());
            } else {
                retailPrice = parseFloat(row.find('.retail-price').text().trim());
            }

            // ตรวจสอบค่าที่ไม่ว่างเปล่า
            if (productName === "" || isNaN(retailPrice)) {
                alert("ไม่สามารถดึงข้อมูลได้");
                s_product
                return; // ออกจากฟังก์ชันหากข้อมูลว่างเปล่า
            }

            // กำหนดลำดับใหม่สำหรับแถวใน ordertable
            var orderRowCount = $('#ordertable tbody tr').length + 1;

            // สร้างแถวใหม่ในตาราง ordertable
            var newRow = `
                <tr>
                    <td data-drugid="${drugid}">${orderRowCount}</td>
                    <td><div style="text-align: left; padding-left:10px">${productName}</div></td>
                    <td contenteditable="true" onkeypress="acceptOnEnter(event)" class="quantity" data-quantity-stock="${quantityStock}" style="font-weight: bold; font-size:16px">1</td>
                    <td>${retailPrice.toFixed(2)}</td>
                    <td contenteditable="true" onkeypress="acceptOnEnter(event)" class="discount" style="font-weight: bold; font-size:16px">0</td>
                    <td class="total"></td>
                    <td>
					<i class="fas fa-search" style="font-size: 16px; color: #FD7E14 ; margin-right: 10px; cursor: pointer;" 
                      data-toggle="modal" data-target="#viewDrug" 
                      onclick="sendValueDrug('${drugid}','sDrug')"></i>
					<i class="fa-regular fa-rectangle-xmark delete-btn" style="color: red; font-size:20px; padding-top:5px; cursor: pointer; " data-toggle="tooltip" title=""></i>
					</td>
                </tr>
            `;

            // เพิ่มแถวใหม่ในตาราง ordertable และคำนวณผลรวม
            $('#ordertable tbody').append(newRow);
            calculateTotals();

            // เพิ่ม Event Listener สำหรับเซลล์ที่แก้ไขได้ในแถวใหม่
            setupEditableListeners();
        });

        // ลบแถวเมื่อคลิกปุ่มลบ
        $('#ordertable').on('click', '.delete-btn', function() {
            $(this).closest('tr').remove();
            reorderRows(); // เรียงลำดับหมายเลขใหม่
            calculateTotals(); // อัปเดตผลรวมเมื่อแถวถูกลบ
        });

        // เปิดใช้งาน Bootstrap ToolTip
        $('[data-toggle="tooltip"]').tooltip();

        // ตั้งค่า title สำหรับ ToolTip เมื่อ mouseenter
        $('#ordertable').on('mouseenter', '.delete-btn', function() {
            var column2Text = 'ลบ ' + $(this).closest('tr').find('td:eq(1)').text().trim();
            $(this).attr('title', column2Text).tooltip('_fixTitle').tooltip('show');
        });

        // การลบแถวเมื่อคลิกที่ไอคอน delete-btn
        $('#ordertable').on('click', '.delete-btn', function() {
            var $icon = $(this);

            // ซ่อนและล้าง ToolTip ก่อนลบแถว
            $icon.tooltip('hide').tooltip('dispose');

            // ลบ ToolTip ออกจาก DOM โดยตรงหากยังค้างอยู่
            $('.tooltip').remove();

            // ลบแถวออกจาก DOM
            $icon.closest('tr').remove();
        });

        // ฟังก์ชันตรวจสอบค่าในคอลัมน์ quantity
        $('#ordertable').on('blur', '.quantity', function() {
            var quantity = parseInt($(this).text().trim());
            var quantityStock = $(this).data('quantity-stock');

            if (quantity > quantityStock) {
                Swal.fire({
                    icon: 'warning',
                    title: 'จำนวนยาเหลือไม่เพียงพอ',
                    text: 'ต้องการยา ' + quantity + ' รายการ แต่ยาเหลือในสต๊อก ' +
                        quantityStock + ' รายการ',
                    confirmButtonText: 'OK'
                });
                $(this).text("1"); // กำหนดค่าเป็น 1
            }
        });

        // ฟังก์ชันสำหรับเรียงลำดับคอลัมน์แรกใหม่
        function reorderRows() {
            $('#ordertable tbody tr').each(function(index) {
                $(this).find('td:first').text(index + 1); // อัปเดตคอลัมน์แรกให้เป็นลำดับใหม่
            });
        }

        // ฟังก์ชันอัปเดตข้อมูลในแต่ละแถว
        function updateRowTotal(row) {
            var quantity = parseInt(row.find('.quantity').text()) || 0;
            var retailPrice = parseFloat(row.find('td').eq(3).text());
            var discount = parseFloat(row.find('.discount').text()) || 0;
            var total = (quantity * retailPrice) - discount;
            row.find('.total').text(total.toFixed(2));
        }

        // ฟังก์ชันคำนวณผลรวมทั้งหมด
        function calculateTotals() {
            var totalColumn3 = 0;
            var totalColumn5 = 0;
            totalColumn6 = 0;
            $('#ordertable tbody tr').each(function() {
                var row = $(this);
                var quantity = parseFloat(row.find('.quantity').text()) || 0;
                var retailPrice = parseFloat(row.find('td').eq(3).text()) || 0;
                var discount = parseFloat(row.find('.discount').text()) || 0;
                var total = (quantity * retailPrice) - discount;

                // อัปเดตค่ารวม
                totalColumn3 += quantity;
                totalColumn5 += discount;
                totalColumn6 += total;

                // อัปเดตค่าในเซลล์ผลรวมของแถว
                row.find('.total').text(total.toFixed(2));
            });

            // อัปเดตข้อมูลในส่วนแสดงผลรวมทั้งหมด
            document.getElementById('totalRows').innerText = "รายการสินค้า: " + $('#ordertable tbody tr')
                .length + " รายการ";
            document.getElementById('totalNumber').innerText = "จำนวนสิ้นค้า: " + totalColumn3 + " ชิ้น";
            document.getElementById('totalDiscount').innerText = "ราคาส่วนลด: " + totalColumn5 + " บาท";
            document.getElementById('total').innerText = "ราคารวม: " + totalColumn6.toFixed(2) + " บาท";
            updateChange(); // อัปเดตเงินทอน
        }

        // ฟังก์ชันตั้งค่า Event Listener ให้เซลล์ที่แก้ไขได้
        function setupEditableListeners() {
            // สำหรับ quantity
            $('#ordertable .quantity').off('keydown').on('keydown', function(event) {
                // อนุญาตเฉพาะตัวเลข (0-9), Backspace, Delete, Tab, Enter และลูกศรซ้ายขวา
                if (!event.key.match(/[0-9]/) &&
                    event.key !== 'Backspace' &&
                    event.key !== 'Delete' &&
                    event.key !== 'Tab' &&
                    event.key !== 'ArrowLeft' &&
                    event.key !== 'ArrowRight' &&
                    event.key !== 'Enter') {
                    event.preventDefault(); // ป้องกันการพิมพ์อักขระอื่น
                }

                // ยืนยันค่าเมื่อกด Enter
                if (event.key === 'Enter') {
                    event.preventDefault(); // ป้องกันการขึ้นบรรทัดใหม่
                    this.blur(); // ออกจากโหมดแก้ไข
                }
            }).off('blur').on('blur', function() {
                // ตรวจสอบให้ quantity เป็นจำนวนเต็มบวกอย่างน้อย 1
                let value = this.innerText.replace(/[^0-9]/g, ''); // ลบอักขระที่ไม่ใช่ตัวเลขออก
                value = value === "" ? 1 : Math.max(1, parseInt(value, 10));
                this.innerText = value;

                var row = $(this).closest('tr');
                updateRowTotal(row);
                calculateTotals(); // อัปเดตผลรวมเมื่อมีการเปลี่ยนแปลงค่า
            });

            // สำหรับ discount
            $('#ordertable .discount').off('keydown').on('keydown', function(event) {
                // อนุญาตเฉพาะตัวเลข (0-9), Backspace, Delete, Tab, Enter และลูกศรซ้ายขวา
                if (!event.key.match(/[0-9]/) &&
                    event.key !== 'Backspace' &&
                    event.key !== 'Delete' &&
                    event.key !== 'Tab' &&
                    event.key !== 'ArrowLeft' &&
                    event.key !== 'ArrowRight' &&
                    event.key !== 'Enter') {
                    event.preventDefault(); // ป้องกันการพิมพ์อักขระอื่น
                }

                // ยืนยันค่าเมื่อกด Enter
                if (event.key === 'Enter') {
                    event.preventDefault(); // ป้องกันการขึ้นบรรทัดใหม่
                    this.blur(); // ออกจากโหมดแก้ไข
                }
            }).off('blur').on('blur', function() {
                // ตรวจสอบให้ discount เป็นจำนวนเต็มบวกอย่างน้อย 0
                let value = this.innerText.replace(/[^0-9]/g, ''); // ลบอักขระที่ไม่ใช่ตัวเลขออก
                value = value === "" ? 0 : Math.max(0, parseInt(value, 10));
                this.innerText = value;

                var row = $(this).closest('tr');
                updateRowTotal(row);
                calculateTotals(); // อัปเดตผลรวมเมื่อมีการเปลี่ยนแปลงค่า
            });
        }

        // ฟังก์ชันอัปเดตเงินทอน
        function updateChange() {
            var receivedCash = parseFloat(document.getElementById('recieve_cash').value) || 0;
            var change = receivedCash - totalColumn6;
            var changeElement = document.getElementById('change');

            // แสดงผลลัพธ์ในแท็ก <p> ที่มี id="change" และเปลี่ยนสีหากเงินทอนน้อยกว่า 0
            changeElement.innerText = "เงินทอน: " + (isNaN(change) ? 0 : change.toFixed(2)) + " บาท";
            changeElement.style.color = change < 0 ? 'red' : 'white';
        }

        // เรียกใช้การคำนวณและการตั้งค่าเริ่มต้นเมื่อโหลดหน้าเว็บ
        calculateTotals();
        setupEditableListeners();
    });
    </script>

    <!-- เมื่อกด Enter -->
    <script>
    function acceptOnEnter(event) {
        if (event.key === "Enter") {
            event.preventDefault(); // ป้องกันการเพิ่มบรรทัดใหม่ใน `<td>`
            event.target.blur(); // ออกจากโหมดแก้ไขเพื่อยืนยันค่า
            // เพิ่มโค้ดที่คุณต้องการให้ทำงานเมื่อค่าถูกยอมรับ เช่น บันทึกค่า หรือแสดงข้อความ
            console.log("Value accepted: " + event.target.innerText);
        }
    }
    </script>

    <script>
    $(document).ready(function() {
        $('#btnSearchProduct').on('click', function() {
            $.ajax({
                url: 'fetch_products.php',
                method: 'GET',
                success: function(response) {
                    console.log("Data loaded successfully");

                    if ($.fn.DataTable.isDataTable('#s_product')) {
                        $('#s_product').DataTable().clear().destroy();
                    }

                    $('#s_product tbody').html(response);
                    $('#searchproduct').modal('show');

                    setTimeout(function() {
                        const table = $('#s_product').DataTable({
                            responsive: false,
                            lengthChange: false,
                            autoWidth: false,
                            pageLength: 10,
                            columnDefs: [{ targets: [1, 4], visible: false }]
                        });

                        // ✅ โฟกัสช่องค้นหาเมื่อเปิด modal
                        const searchInput = $('#s_product_wrapper .dataTables_filter input');
                        searchInput.focus();

                        // ✅ เมื่อคลิกปุ่ม "เลือก" → ล้างช่องค้นหาและโฟกัสใหม่
                        $('#s_product').on('click', '.select-btn', function() {
                            searchInput.val('').focus();
                        });
                    }, 300);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error loading data: ", textStatus, errorThrown);
                    $('#s_product tbody').html(
                        '<tr><td colspan="9" style="color:red;">ไม่สามารถโหลดข้อมูลได้</td></tr>'
                    );
                }
            });
        });
    });
    </script>

    <!-- บันทึกข้อมูลลงในตาราง tbl_sales -->
    <script>
    // ✅ วางไว้ตรงนี้ ก่อน addEventListener
    const act = <?= json_encode($sACT === 'edit' ? 'update' : 'new') ?>;

    document.querySelector('.btn-success').addEventListener('click', function(event) {
        event.preventDefault(); // ป้องกันการ submit ฟอร์มทันที

        const table = document.getElementById("ordertable");
        const rowCount = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr").length;

        // ตรวจสอบว่ามีข้อมูลในตารางหรือไม่
        if (rowCount === 0 && act === 'new') {
            Swal.fire({
                icon: 'warning',
                title: 'ไม่มีข้อมูลสินค้า',
                text: 'กรุณาเพิ่มรายการสินค้าก่อนบันทึก',
            });
            return; // หยุดการทำงานถ้าไม่มีข้อมูล
        }

        Swal.fire({
            title: 'Are you sure?',
            text: "ต้องการบันทึกข้อมูลนี้หรือไม่?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ต้องการบันทึก!',
            cancelButtonText: 'ไม่, ยกเลิก!'
        }).then((result) => {
            if (result.isConfirmed) {
                // ดึงข้อมูลจากตาราง
                const table = document.getElementById("ordertable");
                let orderItems = [];

                let receivedCash = parseFloat(document.getElementById('recieve_cash').value) || 0;
                let change = receivedCash - totalColumn6;
                let select = document.getElementById("member_customer");
                let selectedOption = select.options[select.selectedIndex];
                let selectedValue = selectedOption.value;

                let selectedPayment = document.querySelector('input[name="sPayment"]:checked').value;
                let userID = <?= json_encode($sUserID) ?>; // แปลง PHP variable ให้เป็น JavaScript

                const d = new Date();
                d.setHours(d.getHours() + 7);

                const sale_id = act === 'update' ?
                    <?= json_encode($sSALEID) ?> :
                    d.toISOString().replace(/[-:T]/g, '').slice(2, 14);

                const now = new Date();
                const curDate =
                    `${now.getFullYear()}-${(now.getMonth() + 1).toString().padStart(2, '0')}-${now.getDate().toString().padStart(2, '0')} ${now.getHours().toString().padStart(2, '0')}:${now.getMinutes().toString().padStart(2, '0')}:${now.getSeconds().toString().padStart(2, '0')}`;

                const remark = document.getElementById("remark").value;

                // console.log("จ่ายเงิน " + selectedPayment);
                // console.log("รหัสลูกค้า " + selectedValue);
                // console.log("ยอดรวม " + totalColumn6);
                // console.log("รับเงินสด " + receivedCash);
                // console.log("เงินทอน " + change);
                // console.log("ผู้ใช้ " + userID);
                // console.log("วันที่ " + curDate);

                for (let i = 1, row; row = table.rows[i]; i++) {
                    let drugidCell = row.cells[0]; // อ้างอิงเซลล์แรกที่มี data-drugid
                    let quantityCell = row.querySelector('.quantity');

                    let item = {
                        drugid: drugidCell.getAttribute("data-drugid"),
                        quantityStock: quantityCell.getAttribute("data-quantity-stock"),
                        quantity: row.cells[2].innerText.trim(),
                        price: row.cells[3].innerText.trim(),
                        discount: row.cells[4].innerText.trim(),
                        total: row.cells[5].innerText.trim()
                    };
                    orderItems.push(item);
                }

                // ส่งข้อมูลไปยัง API หรือไฟล์ PHP เพื่อบันทึกในฐานข้อมูล
                fetch('fetch_save_order.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            act: act,
                            sale_id: <?= json_encode($sSALEID) ?>,
                            userID: userID,
                            sale_id: sale_id,
                            selectedPayment: selectedPayment,
                            selectedValue: selectedValue,
                            totalColumn6: totalColumn6,
                            receivedCash: receivedCash,
                            change: change,
                            curDate: curDate,
                            orders: orderItems,
                            remark: remark
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'บันทึก!',
                                text: 'คำสั่งขายถูกบันทึก.',
                                icon: 'success'
                            }).then(() => {
                                // 👉 Redirect ไปยัง order.php
                                window.location.href = 'order.php';
                            });

                        } else {
                            Swal.fire({
                                title: 'ผิดพลาด!',
                                text: 'เกิดปัญหาในการบันทึกข้อมูลการขาย.',
                                icon: 'error'
                            });
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'ผิดพลาด!',
                            text: 'เกิดปัญหาในการบันทึกข้อมูลการขาย.',
                            icon: 'error'
                        });
                    });
            }
        });
    });

    // เรียกฟังก์ชันเมื่อหน้าเว็บโหลดครั้งแรก
    window.onload = function() {
        fetchTotalAmountToday();
    };

    // ฟังก์ชันสำหรับดึงข้อมูลยอดรวมของวันนี้
    function fetchTotalAmountToday() {
        fetch('fetch_total_amount_today.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {

                    const totalAmount = data.total_amount || 0;
                    document.getElementById("totalAmountToday").textContent =
                        `จำนวนเงิน ${totalAmount} บาท`;

                    const cashTotal = data.cash_total || 0;
                    document.getElementById("cashTotalToday").textContent =
                        `เงินสด ${cashTotal} บาท`;

                    const transferTotal = data.transfer_total || 0;
                    document.getElementById("transferTotalToday").textContent =
                        `เงินโอน ${transferTotal} บาท`;

                    const quantityTotal = data.total_quantity || 0;
                    document.getElementById("quantityTotalToday").textContent =
                        `จำนวนสินค้า ${quantityTotal} ชิ้น`;

                    const rowTotal = data.row_count || 0;
                    document.getElementById("rowTotalToday").textContent =
                        `รายการสินค้า ${rowTotal} รายการ`;

                    const totalProfit = data.total_profit || 0;
                    document.getElementById("profitToday").textContent =
                        `กำไร ${parseFloat(totalProfit).toFixed(2)} บาท`;

                    console.log("ยอดรวมของวันนี้: " + totalAmount);
                    console.log("ยอดกำไรของวันนี้: " + totalProfit);

                } else {
                    console.error("ไม่สามารถดึงยอดรวมของวันนี้ได้");
                }
            })
            .catch(error => console.error("Error fetching total amounts:", error));
    }

</script>

    <script>
    window.addEventListener("load", function() {
        var select = document.getElementById("member_customer");
        var selectedOption = select.options[select.selectedIndex];
        var selectedValue = selectedOption.value;
        var selectedText = selectedOption.text;
        var selectedMember = selectedOption.getAttribute("data-member");

        var memberType;
        if (selectedMember === 'M') {
            memberType = "Basic Member";
        } else if (selectedMember === 'P') {
            memberType = "Premium Member";
        } else if (selectedMember === 'V') {
            memberType = "VIP Member";
        } else {
            memberType = "Basic Member";
        }

        var iconHtml = `<i class="fas fa-search" style="font-size: 16px; color: #AEAEAE ; margin-left: 5px; cursor: pointer;" 
                      data-toggle="modal" data-target="#viewCustomer" 
                      onclick="sendValueCustomer('${selectedValue}','sCustomer')"></i>`;

        var infoElement = document.getElementById("selected-customer_info");
        infoElement.innerHTML = `${selectedText} | ${memberType} ${iconHtml}`;
        infoElement.style.color = selectedMember === 'P' ? "yellow" : "white";
    });
    </script>
    <script>
    $(function() {
        const $card = $('#payment-card');

        function focusCurrentRadio() {
            const $radios = $card.find('input[type="radio"]');
            let $current = $radios.filter(':checked');
            if ($current.length === 0) {
                $current = $radios.eq(0).prop('checked', true).trigger('change');
            }
            $current.focus();
        }

        // เมื่อ card-body ได้โฟกัส ให้ย้ายไปโฟกัส radio ที่ถูกเลือก
        $card.on('focus', function(e) {
            if (e.target === this) {
                focusCurrentRadio();
            }
        });

        // ใช้ปุ่มลูกศรสลับตัวเลือก
        $card.on('keydown', function(e) {
            if (!['ArrowRight', 'ArrowDown', 'ArrowLeft', 'ArrowUp'].includes(e.key)) return;

            const $radios = $card.find('input[type="radio"]');
            let idx = $radios.index($radios.filter(':checked'));
            if (idx < 0) idx = 0;

            if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
                idx = (idx + 1) % $radios.length;
            } else {
                idx = (idx - 1 + $radios.length) % $radios.length;
            }

            $radios.eq(idx).prop('checked', true).trigger('change').focus();
            e.preventDefault();
        });

        // ถ้ามี modal แล้วอยากโฟกัสกลับมาที่การ์ด
        $('#searchproduct').on('hidden.bs.modal', function() {
            setTimeout(function() {
                $card.focus();
            }, 150);
        });
    });
    </script>

</body>

</html>