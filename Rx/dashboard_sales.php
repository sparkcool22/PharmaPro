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
    <link rel="stylesheet" href="/PharmaPro/alte/dist/css/adminlte.min.css">

    <!--Style ตาราง -->
    <link rel="stylesheet" href="/PharmaPro/alte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/PharmaPro/alte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/PharmaPro/alte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="/PharmaPro/alte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/PharmaPro/alte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="/PharmaPro/alte/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/PharmaPro/alte/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/PharmaPro/alte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/PharmaPro/alte/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="/PharmaPro/alte/plugins/summernote/summernote-bs4.min.css">
</head>

<body class="hold-transition sidebar-collapse layout-top-nav">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="../img/rp.png" alt="AdminLTELogo" height="150" width="150">
        </div>

        <!-- Navbar -->
        <?php include("l_main_head.php"); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include("l_menu.php"); ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content" style="padding: 20px 20px;">
                <div class="container-fluid">
                    <!-- 🔥 เพิ่มส่วนนี้ -->
                    <div class="row mb-3 ml-2">
                        <div class="col-md-2">
                            <label>เลือกช่วงวันที่:</label>
                            <input type="text" class="form-control" id="daterange">
                        </div>
                    </div>
                    <!-- 🔥 ส่วนนี้จบ -->

                    <!-- Small boxes (Stat box) -->
                    <div class="d-flex flex-wrap">
                        <!-- กล่อง 1: จำนวนเงิน -->
                        <div class="col-md-2">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3 id="total-amount-display">0</h3> <!-- ให้ id="total-amount-display" -->
                                    <p>จำนวนเงิน (บาท)</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-coins"></i>
                                </div>
                                <a class="small-box-footer">Information <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- กล่อง 2: รายการสินค้า -->
                        <div class="col-md-2">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3 id="total-items-display">0</h3> <!-- มี id -->
                                    <p>รายการสินค้า (รายการ)</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                                <a class="small-box-footer">Information <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- กล่อง 3: จำนวนสินค้า -->
                        <div class="col-md-2">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3 id="total-quantity-display">0</h3>
                                    <p>จำนวนสินค้า (ชิ้น)</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-boxes"></i>
                                </div>
                                <a class="small-box-footer">Information <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- กล่อง 5: เงินโอน -->
                        <div class="col-md-2">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3 id="cash-amount-display">0</h3>
                                    <p>เงินสด (บาท)</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <a class="small-box-footer">Information <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3 id="transfer-amount-display">0</h3>
                                    <p>เงินโอน (บาท)</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-exchange-alt"></i>
                                </div>
                                <a class="small-box-footer">Information <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="small-box bg-secondary">
                                <div class="inner">
                                    <h3 id="buyer-amount-display">0</h3>
                                    <p>จำนวนลูกค้า (คน)</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <a class="small-box-footer">Information <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                    </div>
                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-4 connectedSortable">
                            <!-- Custom tabs (Charts with tabs)-->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">กราฟสรุปยอดขาย</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="salesChart" style="height: 305px;"></canvas>
                                </div>
                            </div>

                            <!-- /.card -->

                        </section>
                        <!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <section class="col-lg-4 connectedSortable">

                            <!-- solid sales graph -->
                            <!-- กราฟขายรายชั่วโมง -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">ยอดขายรายชั่วโมง</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="hourlySalesChart" style="height: 300px;"></canvas>
                                </div>
                            </div>
                            <!-- /.card -->

                        </section>
                        <section class="col-lg-4 connectedSortable">

                            <!-- solid sales graph -->
                            <!-- กราฟ Top 5 สินค้า -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Top 5 สินค้าขายดี</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="topProductsChart" style="height: 300px;"></canvas>
                                </div>
                            </div>
                            <!-- /.card -->

                        </section>
                        <!-- right col -->
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-body table-responsive p-2" style="max-height: 600px;">
                                    <table class="table table-bordered table-striped" id="salesDetailTable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Sale ID</th>
                                                <th>ชื่อทางการค้า</th>
                                                <th>ขย11</th>
                                                <th>Lot No</th>
                                                <th>การชำระเงิน</th>
                                                <th>จำนวน</th>
                                                <th>มูลค่า</th>
                                                <th>ส่วนลด</th>
                                                <th>รวม</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <div id="table-loading" class="text-center text-muted mt-2" style="display: none;">
                                        <i class="fas fa-spinner fa-spin"></i> กำลังโหลดข้อมูล...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- Main Footer -->
        <?php include("l_footer.php"); ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="/PharmaPro/alte/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="/PharmaPro/alte/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
    $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="/PharmaPro/alte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="/PharmaPro/alte/plugins/chart.js/Chart.min.js"></script>
    <script>
    // ⭐⭐ วางตรงนี้ ⭐⭐

    // Plugin วาดข้อความตรงกลาง ถ้าไม่มีข้อมูล (Chart.js v2.x)
    Chart.plugins.register({
        beforeDraw: function(chart) {
            if (chart.config.options.elements && chart.config.options.elements.center) {
                var ctx = chart.chart.ctx;
                var centerConfig = chart.config.options.elements.center;
                var txt = centerConfig.text;
                var color = centerConfig.color || '#000';
                var fontStyle = centerConfig.fontStyle || 'Arial';
                var sidePadding = centerConfig.sidePadding || 20;
                var maxFontSize = centerConfig.maxFontSize || 24;
                ctx.save();
                ctx.font = "20px " + fontStyle;

                var stringWidth = ctx.measureText(txt).width;
                var width = chart.chartArea.right - chart.chartArea.left;
                var sidePaddingCalculated = (sidePadding / 100) * width;
                var availableWidth = width - sidePaddingCalculated;
                var fontSize = Math.min(maxFontSize, Math.floor(availableWidth / stringWidth * 20));

                ctx.font = fontSize + "px " + fontStyle;
                ctx.fillStyle = color;
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                var centerX = (chart.chartArea.left + chart.chartArea.right) / 2;
                var centerY = (chart.chartArea.top + chart.chartArea.bottom) / 2;
                ctx.fillText(txt, centerX, centerY);
                ctx.restore();
            }
        }
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
    <!-- Sparkline -->
    <script src="/PharmaPro/alte/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->

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
    <script src="/PharmaPro/alte/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="/PharmaPro/alte/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="/PharmaPro/alte/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="/PharmaPro/alte/plugins/moment/moment.min.js"></script>
    <script src="/PharmaPro/alte/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="/PharmaPro/alte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="/PharmaPro/alte/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="/PharmaPro/alte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/PharmaPro/alte/dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="/PharmaPro/alte/dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="/PharmaPro/alte/dist/js/pages/dashboard.js"></script>
    <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
    <script>
    function resetCanvas(canvasId) {
        const oldCanvas = document.getElementById(canvasId);
        const parent = oldCanvas.parentNode;

        const newCanvas = document.createElement('canvas');
        newCanvas.id = canvasId;
        newCanvas.width = oldCanvas.width; // ⭐ สำคัญ ต้อง set width ใหม่
        newCanvas.height = oldCanvas.height; // ⭐ สำคัญ ต้อง set height ใหม่
        newCanvas.style.width = oldCanvas.style.width;
        newCanvas.style.height = oldCanvas.style.height;

        parent.replaceChild(newCanvas, oldCanvas);
    }
    </script>

    <!-- ✅ ฟังก์ชันโหลดข้อมูลกล่อง 5 ช่อง ต้องอยู่นอก $(function) -->
    <script>
    function loadDashboardData(startDate, endDate) {
        $.ajax({
            url: 'fetch_dashboard_data.php',
            method: 'POST',
            dataType: 'json',
            data: {
                start: startDate,
                end: endDate
            },
            success: function(response) {
                console.log('🔥 Debug Response:', response);
                animateCountFix('total-amount-display', response.total_amount);
                animateCountFix('total-items-display', response.total_items);
                animateCountFix('total-quantity-display', response.total_quantity);
                animateCountFix('cash-amount-display', response.cash_amount);
                animateCountFix('transfer-amount-display', response.transfer_amount);
                animateCountFix('buyer-amount-display', response.buyer_amount);
            },
            error: function(xhr, status, error) {
                console.error('โหลดข้อมูลผิดพลาด:', error);
            }
        });
    }
    </script>

    <script>
    // ✅ นับเลขลื่น (animate) สำหรับกล่อง
    function animateCountFix(elementId, endValue) {
        const el = document.getElementById(elementId);
        const duration = 1000;
        const startTimestamp = performance.now();
        const isFloat = endValue % 1 !== 0;

        function step(currentTimestamp) {
            const progress = Math.min((currentTimestamp - startTimestamp) / duration, 1);
            const currentValue = endValue * progress;

            if (isFloat) {
                el.textContent = currentValue.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            } else {
                el.textContent = Math.floor(currentValue).toLocaleString();
            }

            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                el.classList.add('animated-bounce');
                setTimeout(() => {
                    el.classList.remove('animated-bounce');
                }, 500);
            }
        }
        requestAnimationFrame(step);
    }
    </script>

    <!-- 🎨 เพิ่มเอฟเฟกต์กระเด้งเวลาเลขขึ้น -->
    <style>
    .animated-bounce {
        animation: bounce 0.5s;
    }

    @keyframes bounce {
        0% {
            transform: scale(1);
        }

        30% {
            transform: scale(1.2);
        }

        50% {
            transform: scale(0.9);
        }

        70% {
            transform: scale(1.1);
        }

        100% {
            transform: scale(1);
        }
    }
    </style>

    <script>
    let salesChart;
    let clickedIndex = null;

    function loadSalesChart(startDate, endDate) {
        $.ajax({
            url: '/PharmaPro/Rx/fetch_sales_by_date.php',
            method: 'POST',
            data: {
                start: startDate,
                end: endDate
            },
            success: function(response) {
                if (salesChart) salesChart.destroy();

                const labels = response.map(item => item.date);
                const salesData = response.map(item => item.total);

                const ctx = document.getElementById('salesChart').getContext('2d');
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(60,141,188,0.8)');
                gradient.addColorStop(1, 'rgba(60,141,188,0.1)');

                salesChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'ยอดขาย (บาท)',
                            data: salesData,
                            borderColor: 'rgba(60,141,188,1)',
                            backgroundColor: gradient,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: labels.map((_, idx) => idx ===
                                clickedIndex ? 'red' : 'white'),
                            pointBorderColor: labels.map((_, idx) => idx === clickedIndex ?
                                'red' : 'rgba(60,141,188,1)'),
                            pointRadius: labels.map((_, idx) => idx === clickedIndex ? 8 :
                                4),
                            pointHoverRadius: 8,
                            pointHoverBackgroundColor: 'rgba(60,141,188,1)',
                            pointHoverBorderColor: '#fff',
                            pointBorderWidth: labels.map((_, idx) => idx === clickedIndex ?
                                4 : 2),
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                top: 20 // ⭐ เผื่อพื้นที่บนหัวตัวเลข
                            }
                        },
                        plugins: [ChartDataLabels], // ⭐ เปิด DataLabels
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                },
                                gridLines: {
                                    color: 'rgba(0,0,0,0.05)'
                                }
                            }],
                            xAxes: [{
                                gridLines: {
                                    display: false
                                },
                                ticks: {
                                    callback: function(value) {
                                        return formatDate(value);
                                    }
                                }
                            }]
                        },
                        legend: {
                            labels: {
                                fontColor: '#333',
                                fontSize: 14
                            }
                        },
                        tooltips: {
                            backgroundColor: 'rgba(0,0,0,0.7)',
                            titleFontSize: 16,
                            bodyFontSize: 14,
                            cornerRadius: 4,
                            callbacks: {
                                title: function(tooltipItems) {
                                    return formatDate(tooltipItems[0].label);
                                },
                                label: function(tooltipItem) {
                                    return 'ยอดขาย: ' + tooltipItem.yLabel.toLocaleString() +
                                        ' บาท';
                                }
                            }
                        },
                        plugins: {
                            datalabels: {
                                anchor: 'end',
                                align: 'top', // ⭐ ขยับขึ้นไปบนหัวจุด
                                offset: 1, // ⭐ ขยับสูงขึ้นอีกนิด
                                color: '#000',
                                font: {
                                    weight: 'bold',
                                    size: 12
                                },
                                formatter: function(value) {
                                    return value.toLocaleString();
                                }
                            }
                        },
                        animation: {
                            duration: 1500,
                            easing: 'easeOutQuart'
                        },
                        onClick: function(event, elements) {
                            if (elements.length > 0) {
                                clickedIndex = elements[0]._index;
                                const clickedDate = this.data.labels[clickedIndex];
                                loadDashboardData(clickedDate, clickedDate);
                                loadSalesChart(startDate, endDate);
                                loadTopProductsChart(clickedDate, clickedDate);
                                loadHourlySalesChart(clickedDate, clickedDate);
                                showFloatingDate(clickedDate);
                                loadSalesDetailTable(clickedDate, clickedDate);
                            }
                        }
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('❌ Load Chart Failed:', error);
            }
        });
    }

    // ฟังก์ชันแปลงวันที่
    function formatDate(dateStr) {
        const [year, month, day] = dateStr.split('-');
        return `${day}-${month}-${year}`;
    }
    </script>

    <script>
    // ✅ โหลดหน้าแรก
    $(function() {
        $('#daterange').daterangepicker({
            startDate: moment(),
            endDate: moment(),
            locale: {
                format: 'DD-MM-YYYY',
                separator: ' ถึง ',
                applyLabel: 'ตกลง',
                cancelLabel: 'ยกเลิก',
                fromLabel: 'ตั้งแต่',
                toLabel: 'ถึง',
                customRangeLabel: 'กำหนดเอง',
                weekLabel: 'W',
                daysOfWeek: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
                monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
                    'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
                ],
                firstDay: 0
            }
        });

        const today = moment().format('YYYY-MM-DD');
        loadSalesChart(today, today); // โหลดกราฟ
        loadDashboardData(today, today); // โหลดกล่อง 5 ช่อง
        loadHourlySalesChart(today, today); // ⭐ โหลดรายชั่วโมงของวันนี้ด้วย
        loadTopProductsChart(today, today); // โหลดสินค้าขายดีของวันนี้ด้วย
        loadSalesDetailTable(today, today); // ✅ โหลดตารางขาย

        $('#daterange').on('apply.daterangepicker', function(ev, picker) {
            let startDate = picker.startDate.format('YYYY-MM-DD');
            let endDate = picker.endDate.format('YYYY-MM-DD');

            clickedIndex = null; // ⭐ reset วงกลมแดงทุกครั้งที่เลือกช่วงใหม่

            loadSalesChart(startDate, endDate);
            loadDashboardData(startDate, endDate);
            loadTopProductsChart(today, today); // โหลดสินค้าขายดีของวันนี้ด้วย
            loadTopProductsChart(startDate, endDate); // ⭐ โหลด Top 5
            loadHourlySalesChart(startDate, endDate);
            loadSalesDetailTable(startDate, endDate);
        });
    });
    </script>

    <div id="floating-date" style="
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(0,0,0,0.8);
    color: #ffffff;
    padding: 10px 20px;
    border-radius: 12px;
    font-size: 18px;
    font-weight: bold;
    display: none;
    z-index: 9999;
    box-shadow: 0 8px 20px rgba(0,0,0,0.5);
    opacity: 0;
    transition: opacity 0.5s ease; /* ⭐ นุ่ม ๆ */
    pointer-events: none; /* กดทะลุได้ */
"></div>

    <script>
    function showFloatingDate(dateText) {
        const floatingDiv = document.getElementById('floating-date');
        floatingDiv.textContent = "📅 วันที่เลือก: " + moment(dateText).format('DD-MM-YYYY');
        floatingDiv.style.display = 'block';

        // ⭐ ทำ Fade in
        setTimeout(() => {
            floatingDiv.style.opacity = 1;
        }, 50);

        // ⭐ แล้วหายไป (Fade out) หลัง 5 วินาที
        setTimeout(() => {
            floatingDiv.style.opacity = 0;
            setTimeout(() => {
                floatingDiv.style.display = 'none';
            }, 500); // ต้องรอให้ fade-out เสร็จก่อน
        }, 10000);
    }
    </script>


    <script>
    let hourlySalesChart;

    function loadHourlySalesChart(startDate, endDate) {
        if (hourlySalesChart) {
            hourlySalesChart.destroy();
            hourlySalesChart = null;
        }

        $.ajax({
            url: '/PharmaPro/Rx/fetch_sales_by_hour.php',
            method: 'POST',
            data: {
                start: startDate,
                end: endDate
            },
            success: function(response) {
                const ctx = document.getElementById('hourlySalesChart').getContext('2d');
                ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height); // เคลียร์ canvas เดิมก่อน

                if (!response || response.length === 0) {
                    const canvas = document.getElementById('hourlySalesChart');
                    const dpr = window.devicePixelRatio || 1;
                    const rect = canvas.getBoundingClientRect();

                    // ปรับ canvas ให้ชัดบนหน้าจอความละเอียดสูง
                    canvas.width = rect.width * dpr;
                    canvas.height = rect.height * dpr;
                    canvas.style.width = rect.width + "px";
                    canvas.style.height = rect.height + "px";

                    const ctx = canvas.getContext('2d');
                    ctx.scale(dpr, dpr);
                    ctx.clearRect(0, 0, rect.width, rect.height);

                    const img = new Image();
                    img.onload = function() {
                        const imgWidth = 300;
                        const imgHeight = 200;
                        const x = (rect.width - imgWidth) / 2;
                        const y = (rect.height - imgHeight) / 2;

                        ctx.drawImage(img, x, y, imgWidth, imgHeight);
                    };
                    img.src = '../img/no_data.png'; // ✅ เปลี่ยน path ตามที่คุณใช้จริง

                    return;
                }

                const labels = response.map(item => item.hour);
                const salesData = response.map(item => item.total);

                // ✅ เพิ่ม gradient
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(60,141,188,0.9)');
                gradient.addColorStop(1, 'rgba(60,141,188,0.2)');


                hourlySalesChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'ยอดขาย (บาท)',
                            data: salesData,
                            backgroundColor: gradient, // ✅ ใช้ gradient
                            borderColor: 'rgba(60,141,188,1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                },
                                gridLines: {
                                    color: 'rgba(0,0,0,0.05)'
                                }
                            }],
                            xAxes: [{
                                gridLines: {
                                    display: false
                                }
                            }]
                        },
                        legend: {
                            display: false
                        },
                        tooltips: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return 'ยอดขาย: ' + tooltipItem.yLabel.toLocaleString() +
                                        ' บาท';
                                }
                            }
                        },
                        animation: {
                            duration: 1500,
                            easing: 'easeOutQuart'
                        }
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('❌ Load Hourly Chart Failed:', error);
            }
        });
    }
    </script>

    <script>
    let topProductsChart;

    function loadTopProductsChart(startDate, endDate) {
        if (topProductsChart) {
            topProductsChart.destroy();
            topProductsChart = null;
        }

        $.ajax({
            url: '/PharmaPro/Rx/fetch_top_products.php',
            method: 'POST',
            data: {
                start: startDate,
                end: endDate
            },
            success: function(response) {
                const ctx = document.getElementById('topProductsChart').getContext('2d');
                ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);

                if (!response || response.length === 0) {
                    const canvas = document.getElementById('topProductsChart');
                    const dpr = window.devicePixelRatio || 1;
                    const rect = canvas.getBoundingClientRect();

                    // ปรับ canvas ให้แสดงคมชัดบนจอ HiDPI
                    canvas.width = rect.width * dpr;
                    canvas.height = rect.height * dpr;
                    canvas.style.width = rect.width + "px";
                    canvas.style.height = rect.height + "px";

                    const ctx = canvas.getContext('2d');
                    ctx.scale(dpr, dpr);
                    ctx.clearRect(0, 0, rect.width, rect.height);

                    const img = new Image();
                    img.onload = function() {
                        const imgWidth = 300;
                        const imgHeight = 200;

                        const x = (rect.width - imgWidth) / 2;
                        const y = (rect.height - imgHeight) / 2;

                        ctx.drawImage(img, x, y, imgWidth, imgHeight);
                    };

                    img.src = '../img/no_data.png'; // ✅ รูปของคุณ

                    return;
                }

                const labels = response.map(item => item.name);
                const quantities = response.map(item => item.quantity);

                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(60,141,188,0.9)');
                gradient.addColorStop(1, 'rgba(60,141,188,0.2)');



                topProductsChart = new Chart(ctx, {
                    type: 'horizontalBar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'จำนวนขาย (ชิ้น)',
                            data: quantities,
                            backgroundColor: gradient, // ✅ ใช้ gradient
                            borderColor: 'rgba(60,141,188,1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                right: 50
                            }
                        },
                        plugins: [ChartDataLabels],
                        scales: {
                            xAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value) {
                                        return value.toLocaleString();
                                    }
                                },
                                gridLines: {
                                    color: 'rgba(0,0,0,0.05)'
                                }
                            }],
                            yAxes: [{
                                gridLines: {
                                    display: false
                                }
                            }]
                        },
                        legend: {
                            display: false
                        },
                        tooltips: {
                            enabled: true
                        },
                        plugins: {
                            datalabels: {
                                anchor: 'end',
                                align: 'right',
                                offset: 10,
                                color: '#000',
                                font: {
                                    weight: 'bold',
                                    size: 12
                                },
                                formatter: function(value) {
                                    return value.toLocaleString() + ' ชิ้น';
                                }
                            }
                        },
                        animation: {
                            duration: 1500,
                            easing: 'easeOutBounce'
                        }
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('❌ Load Top Products Failed:', error);
            }
        });
    }
    </script>

    <!-- <script>
    $(function() {
        $("#salesDetailTable").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "pageLength": 25,
            "buttons": ["csv", "excel", "pdf", "print", "colvis"],
            "dom": '<"row"<"col-md-6 d-flex justify-content-start align-items-center"<"order-s1" B><"order-s2" l>><"col-md-6 d-flex justify-content-end" f>>tip'
        }).buttons().container().appendTo('#salesDetailTable_wrapper .col-md-6:eq(0)');
    });
    </script>
 -->
    <script>
    function loadSalesDetailTable(startDate, endDate) {
        if ($.fn.DataTable.isDataTable('#salesDetailTable')) {
            $('#salesDetailTable').DataTable().clear().destroy(); // ✅ เคลียร์ DataTable เก่า
        }

        $('#salesDetailTable').DataTable({
            processing: true,
            destroy: true,
            ajax: {
                url: '/PharmaPro/Rx/fetch_sales_detail.php',
                type: 'POST',
                data: {
                    start: startDate,
                    end: endDate
                },
                dataSrc: 'data'
            },
            columns: [{
                    data: 'no'
                },
                {
                    data: 'sale_date',
                    render: d => moment(d).format('DD-MM-YYYY')
                },
                {
                    data: 'sale_time'
                },
                {
                    data: 'sale_id'
                },
                {
                    data: 'brand_name'
                },
                {
                    data: 'saleaccount_11'
                },
                {
                    data: 'batch_no'
                },
                {
                    data: 'payment',
                },
                {
                    data: 'quantity'
                },
                {
                    data: 'price',
                    render: d => parseFloat(d).toFixed(2)
                },
                {
                    data: 'discount',
                    render: d => parseFloat(d).toFixed(2)
                },
                {
                    data: 'total_price',
                    render: d => parseFloat(d).toFixed(2)
                }
            ],
            dom: '<"d-flex justify-content-between align-items-center mb-2"<"d-flex align-items-center" B <"ml-2" l>><"ml-auto" f>>t<"d-flex justify-content-between" i p>',
            buttons: ['excel', 'pdf', 'print'],
            responsive: true,
            autoWidth: false,
            language: {
                search: "ค้นหา:",
                lengthMenu: "แสดง _MENU_ รายการ",
                info: "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                paginate: {
                    previous: "ก่อนหน้า",
                    next: "ถัดไป"
                },
                zeroRecords: "ไม่มีข้อมูล"
            }
        });
    }
    </script>

</body>

</html>