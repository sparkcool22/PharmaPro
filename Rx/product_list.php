<?php
include '../include/config.php';
include '../include/common.php';
include '../include/setting.php';

CheckUserLogin_Fornt();

// Read parameters
$sACT = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';

$oDB = new DBI();

$sUserID = isset($_SESSION['aupro_member_id']) ? $_SESSION['aupro_member_id'] : '';
$sACT = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';

$sStatus = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
$sID = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
$sExpireDate = $oDB->QueryOne("SELECT nom_expire FROM tbl_setting WHERE id = 1 AND approve_status = 'A' ");

if ($sUserID) {
    $dataUserinfo = $oDB->QueryRow("SELECT * FROM tbl_user_login WHERE id='" . $sUserID . "'", DBI_ASSOC);
    $dataUserinfo['pic_url'] = USERIMG_URL . $dataUserinfo['picture'];
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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/PharmaPro/alte/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/PharmaPro/alte/dist/css/adminlte.min.css">

    <!--Style ตาราง -->
    <link rel="stylesheet" href="/PharmaPro/alte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <!-- <link rel="stylesheet" href="/PharmaPro/alte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css"> -->
    <link rel="stylesheet" href="/PharmaPro/alte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/PharmaPro/alte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="/PharmaPro/alte/plugins/daterangepicker/daterangepicker.css">

    <link rel="stylesheet" href="../public/customCSS/custom_css.css">

    <script src="/PharmaPro/alte/plugins/jquery/jquery.min.js"></script>
    <style>
    #example1_wrapper .dataTables_length {
        margin-left: 15px;
        /* เพิ่มระยะห่างระหว่าง Show กับ Search */

    }

    .order-s1 {
        order: 1;
    }

    .order-s2 {
        order: 2;
    }
    </style>

</head>

<body class="hold-transition sidebar-collapse layout-top-nav">
    <div class="wrapper">

        <!-- Navbar -->
        <?php include("l_main_head.php"); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include("l_menu.php"); ?>

        <!-- Content Wrapper. Contains page content -->
        <?php //include("l_head_content.php"); ?>

        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 mt-2">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Drug Info List <i class="fa-solid fa-angles-right"
                                            style="color:red; font-size:14px; padding-right:10px; padding-left:5px;"></i>
                                        <small>
                                            รายการที่จำนวนคงเหลือในคลังมากกว่า 0
                                            และ สถานะ Active</small>
                                    </h3>
                                    <div class="d-flex justify-content-end align-items-center mb-2">
                                        <label class="mr-2 mb-0">เลือกช่วงวันที่รับเข้า:</label>
                                        <input type="text" id="dateRange" class="form-control form-control-sm mr-3"
                                            style="max-width: 220px;" />

                                        <a class="btn btn-success btn-sm" href="product_form.php?act=new">
                                            <i class="fas fa-plus-circle"></i> Create Drug
                                        </a>
                                    </div>

                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Create User</th>
                                                <th>Update User</th>
                                                <th>Barcode</th>
                                                <th>ชื่อสามัญทางยา</th>
                                                <th>ชื่อทางการค้า</th>
                                                <th>ประเภทของยา</th>
                                                <th>ล็อคของยา</th>
                                                <th>ฉลากยา</th>
                                                <th>ต้องใช้ใบสั่งยาหรือไม่</th>
                                                <th>ขย11</th>
                                                <th>วันหมดอายุ</th>
                                                <th>จำนวนคงเหลือที่น้อยที่สุด</th>
                                                <th>จำนวนที่รับเข้า</th>
                                                <th>จำนวนคงเหลือในคลัง</th>
                                                <th>ราคาต่อหน่วย</th>
                                                <th>ราคาขายปลีก</th>
                                                <th>ราคาขายส่ง</th>
                                                <th>รายละเอียดของยา</th>
                                                <th>Supplier</th>
                                                <th>Picture</th>
                                                <th>วันที่รับเข้า</th>
                                                <th>วันที่อัพเดท</th>
                                                <th>สถานะ</th>
                                                <th>Tools</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section> <!-- /.content -->
        </div>
        <!-- /.content -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <?php include("l_footer.php"); ?>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <!-- AdminLTE App -->
    <script src="/PharmaPro/alte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/PharmaPro/alte/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="/PharmaPro/alte/dist/js/demo.js"></script>

    <!-- Script ตาราง -->
    <!-- <script src="/PharmaPro/alte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <script src="/PharmaPro/alte/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/PharmaPro/alte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/PharmaPro/alte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/PharmaPro/alte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="/PharmaPro/alte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/PharmaPro/alte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="/PharmaPro/alte/plugins/jszip/jszip.min.js"></script>
    <script src="/PharmaPro/alte/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="/PharmaPro/alte/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="/PharmaPro/alte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="/PharmaPro/alte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="/PharmaPro/alte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="/PharmaPro/alte/plugins/moment/moment.min.js"></script>
    <script src="/PharmaPro/alte/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Page specific script -->

    <script>

    $(function() {
        let startDate = null;
        let endDate = null;

        $('#dateRange').daterangepicker({
            showDropdowns: true,
            autoUpdateInput: false,
            locale: {
                format: 'DD-MM-YYYY',
                applyLabel: "ตกลง",
                cancelLabel: "ยกเลิก",
                daysOfWeek: ["อา", "จ", "อ", "พ", "พฤ", "ศ", "ส"],
                monthNames: ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.",
                    "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."
                ],
                firstDay: 0
            }
        });

        const table = $("#example1").DataTable({
            processing: true,
            serverSide: true,
            responsive: false,
            lengthChange: true,
            autoWidth: false,
            pageLength: 25,
            order: [[0, "desc"]],
            scrollX: true,

            ajax: {
                url: "product_list_serverside.php",
                type: "POST",
                data: function(d) {
                    d.start_date = startDate ? startDate.format("YYYY-MM-DD") : "";
                    d.end_date = endDate ? endDate.format("YYYY-MM-DD") : "";
                }
            },

            dom: '<"row"<"col-md-6 d-flex align-items-center"<"order-s1" B><"order-s2 ml-2" l>><"col-md-6 d-flex justify-content-end" f>>tip',

            buttons: [
                "csv",
                "excel",
                "pdf",
                "colvis",
                {
                    text: "Product All",
                    action: function() {
                        window.location.href = "product_list_all.php";
                    }
                }
            ],

            columnDefs: [{
                targets: [1, 2, 3, 4, 8, 9, 10, 18, 20, 22],
                visible: false
            }],

            columns: [
                { data: "no" },
                { data: "createuser" },
                { data: "updateuser" },
                { data: "barcode" },
                { data: "genaric_name" },
                { data: "brand_name" },
                { data: "categoryid" },
                { data: "batch_no" },
                { data: "medicine_label" },
                { data: "prescription_required_html", orderable: false, searchable: false },
                { data: "saleaccount_11_html", orderable: false, searchable: false },
                { data: "expiration_date_html" },
                { data: "min_quantity" },
                { data: "quantity" },
                { data: "quantity_in_stock" },
                { data: "price_per_unit" },
                { data: "retail_price" },
                { data: "member_price" },
                { data: "description" },
                { data: "supplierid" },
                { data: "picture" },
                { data: "insert_date" },
                { data: "update_date" },
                { data: "status_html", orderable: false, searchable: false },
                { data: "tools_html", orderable: false, searchable: false }
            ]
        });

        table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $('#dateRange').on('apply.daterangepicker', function(ev, picker) {
            startDate = picker.startDate;
            endDate = picker.endDate;

            $(this).val(
                picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY')
            );

            table.draw();
        });

        $('#dateRange').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            startDate = null;
            endDate = null;
            table.draw();
        });
    });
    </script>

</body>

</html>