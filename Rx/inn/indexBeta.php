<?php
include 'include/config.php';
include 'include/common.php';

// Read parameters
$sACT = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';

// Config page
define('FORM_PAGE', 'login.htm');
define('RESULT_PAGE', 'login_result.htm');
define('LOGOUT_PAGE', 'logout_result.htm');

$oDB = new DBI();
$oTmp = new TemplateEngine();
$oLogin = new LoginManager();

if ($sACT == 'login') {
    $sUser = base64_encode($_POST['user']);
    $sPass = base64_encode($_POST['pass']);

    $oLogin->SetDBConnection($oDB);
    if (!$oLogin->Login($sUser, $sPass)) {
        //$oTmp->assign('message', '! ชื่อผู้ใช้งานหรือรหัสผิดพลาด กรุณาลองใหม่อีกครั้งหรือขอความช่วยเหลือ โทร.9132');

    } elseif ($oLogin->IsAdmin()) {
        //$oTmp->assign('message', 'ยินดีต้อนรับเข้าสู่ TVS-Engineering');
        Redirect('indexBeta.php?result=wrong');

    } else {
        $oLogin->Logout();
        //$oTmp->assign('message', '* ชื่อผู้ใช้งานนี่ยังไม่ได้รับสิทธิ์ให้เข้าใช้งานระบบ กรุณายืนยันตัวตนจากอีเมล์ที่ท่านได้รับจากระบบหรือขอความช่วยเหลือที่ โทร.9132 ขอบคุณครับ');
    }

} elseif ($sACT == 'logout') {
    $oLogin->Logout();
    //Redirect('home.php');

    $oTmp->assign('message', ' สักครู่... กำลังออกจากระบบ.');
    $oTmp->assign('message_status', '3');
    //$oTmp->display(LOGOUT_PAGE);

} elseif ($sACT == 'tvonline') {
    $oLogin->Logout();
    Redirect('tvonline_index.php');

} else {
    if ($sUserID) {
        Redirect('home.php');
    } else {
        $oTmp->assign('message', 'กรุณาลงชื่อก่อนเข้าใช้งานระบบ ขอบคุณ.');
        //$oTmp->display(FORM_PAGE);
    }
}

$sUserID = isset($_SESSION['au_member_id']) ? $_SESSION['au_member_id'] : '';
$sACT = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';

$sStatus = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
$sID = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';

if ($sUserID) {
    $dataUserinfo = $oDB->QueryRow("SELECT * FROM tbl_user_login WHERE id='" . $sUserID . "'", DBI_ASSOC);
    $dataUserinfo['pic_url'] = USERIMG_URL . $dataUserinfo['picture'];
}



function randomWelcome($randomPo)
{
    $randomNumber = random_int(0, 5);
    $arrayWelcomeS = array("ขอให้ฝนไม่ตกตอนออกจากออฟฟิศนะ!",
        "ขอให้วันนี้เป็นวันที่ดีนะครับ!", "ออฟฟิศเรามันหนาว ดูแลตัวเองด้วยนะ!", "อย่าลืมเติมกำลังด้วยกาแฟ!", "ไม่จำเป็นต้องรอสิ้นเดือนก็กินชาบูได้นะ!",
        "ขอให้วันนี้ไม่เจอบั๊กนะ!");

    return $arrayWelcomeS[$randomNumber];
}

if (!true) {
    echo "UserID : " . $_SESSION['au_member_id'] . " | DebugMode is ON!" . "\r";
}

$target = strval($_SESSION['au_member_id']);
//echo $target;

$count_row = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME)->query("SELECT Status FROM tbl_job_test WHERE userRespon =' $target' AND Status != '3' AND Status != '4'");
$row_countResult = $count_row->num_rows;

$taskToDoReviewRequest = 0;
$taskToDoAppoveRequest = 0;

while ($checkResult = mysqli_fetch_array($count_row)) {
    if ($checkResult["Status"] == "1") {
        $taskToDoReviewRequest = $taskToDoReviewRequest + 1;
    } elseif ($checkResult["Status"] == "2") {
        $taskToDoAppoveRequest = $taskToDoAppoveRequest + 1;
    }
}

// echo 'taskToDoReviewRequest '.$taskToDoReviewRequest;
// echo 'taskToDoAppoveRequest '.$taskToDoAppoveRequest;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventoty Control : Operation and Maintenance CATV</title>
    <link rel="stylesheet" href="./bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./public/customCSS/siwadolCUSTOM.css">

    <style>
    @import url('https://fonts.googleapis.com/css2?family=Prompt&display=swap');

    body {
        font-family: 'Prompt', sans-serif;
        padding-bottom: 100px;
    }

    .noClick {
        pointer-events: none;
        filter: grayscale(100%);
    }
    </style>

</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark navbarCustom cardActionShadowC">
        <div class="container-fluid">

            <a class="navbar-brand" href="#">
                <img class="img-fluid mx-2" style="max-height: 40px;filter: drop-shadow(3px 3px 3px rgba(0, 0, 0, 0.6));" src="./img/newNarLogo.png" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#" hidden>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#" hidden></a>
                    </li>
                    <li class="nav-item dropdown" hidden>
                        <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Regist Equipment</a></li>
                            <li><a class="dropdown-item" href="#">Move Between Floor</a></li>
                            <li><a class="dropdown-item" href="#">Incoming Equipment</a></li>
                            <li><a class="dropdown-item" href="#">Outgoing Equipment</a></li>
                            <li><a class="dropdown-item" href="#">Write Off</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Job Activity</a></li>
                            <li><a class="dropdown-item" href="#">Equipemt Monitoring</a></li>
                            <li><a class="dropdown-item" href="#">Log Monitoring</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="./index.php">Back to Home</a></li>
                            <li><a class="dropdown-item" href="formpage/admin/user_list.php">User List</a></li>
                            <li><a class="dropdown-item" href="formpage/sap_list.php">SAP list</a></li>
                            <!-- <li><hr class="dropdown-divider"></li> -->
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true" hidden>Disabled</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <?php if (!isset($_SESSION['au_member_id'])) {
    $showmenu = 'hidden';
    echo '<a type="button" class="btn btn-light mx-1" href="formpage/newLoginPage.php" aria-expanded="false"><i class="bi bi-key"></i> Login</a>';
} else if ($_SESSION["au_privilege"]["Administrator"]) {
    $showmenu = '';

    //echo '<a class="btn btn-light mx-1" aria-expanded="false" href="formpage\JobActivity.php"><i class="bi bi-list-task"></i> Request <span class="badge bg-danger">'.$row_countResult.'</span></a>';

    echo '<div class="btn-group mx-1">';
    echo '<button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown"';
    echo 'aria-expanded="false">';
    echo '<i class="bi bi-list-task"></i> Request <span class="badge bg-danger">' . $row_countResult . '</span>';
    echo '</button>';
    echo '<ul class="dropdown-menu dropdown-menu-lg-center">';
    echo '<li><a class="dropdown-item" href="formpage\JobActivity.php">Review &nbsp;Request : <span class="badge bg-danger">' . $taskToDoReviewRequest . '</span></a></li>';
    echo '<li><a class="dropdown-item" href="formpage\JobActivity.php">Appove Request : <span class="badge bg-danger">' . $taskToDoAppoveRequest . '</span></a></li>';
    echo '<li><hr class="dropdown-divider"></li>';
    echo '<li><a class="dropdown-item" href="formpage\JobActivity.php">Go to Job Activity</a></li>';
    echo '</div>';

    echo '<div class="btn-group">';
    echo '<button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown"';
    echo 'aria-expanded="false">';
    echo '<i class="bi bi-menu-app"></i>';
    echo '</button>';
    echo '<ul class="dropdown-menu dropdown-menu-lg-end">';
    echo '<li><a class="dropdown-item" href="#">Regist Equipment</a></li>';
    echo '<li><a class="dropdown-item" href="#">Move Between Floor</a></li>';
    echo '<li><a class="dropdown-item" href="#">Incoming Equipment</a></li>';
    echo '<li><a class="dropdown-item" href="#">Outgoing Equipment</a></li>';
    echo '<li><a class="dropdown-item" href="#">Write Off</a></li>';
    echo '<li>';
    echo '<hr class="dropdown-divider">';
    echo '</li>';
    echo '<li><a class="dropdown-item" href="formpage/JobActivity.php">Job Activity <span class="badge bg-danger">' . $row_countResult . '</span></a></li>';
    echo '<li><a class="dropdown-item" href="#">Equipemt Monitoring</a></li>';
    echo '<li><a class="dropdown-item" href="#">Log Monitoring</a></li>';
    echo '<li>';
    echo '<hr class="dropdown-divider">';
    echo '</li>';
    echo '<li><a class="dropdown-item" href="./index.php">Back to Home</a></li>';
    echo '<li><a class="dropdown-item" href="formpage/admin/user_list.php">User List</a></li>';
    echo '<li><a class="dropdown-item" href="formpage/sap_list.php">SAP list</a></li>';
    echo '<!-- <li><hr class="dropdown-divider"></li> -->';
    echo '</ul>';
    echo '</div>';
    echo '<a class="btn btn-light mx-1" aria-expanded="false" href="formpage\logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a>';
}

?>

                </div>
            </div>
        </div>
    </nav>
    <!-- navbar end -->
    <div class=" container">

        <?php
if (isset($_GET["result"]) and $_GET["result"] == "worng") {
    echo '<div class="row">';
    echo '<div class="col-12">';
    echo '<div class="alert alert-danger w-100 welcomeAlert text-white mt-3" role="alert">
          <span class="fw-bold">เข้ารู้ระบบไม่สำเร็จ!</span>
            ชื่อผู้ใช้ หรือ รหัสผ่าน ไม่ถูกต้อง

          </div>';
    echo '</div>';
    echo '</div>';
}
?>

        <?php
if (!empty($showmenu)) {
    echo '<div class="row">';
    echo '<div class="col-12">';
    echo '<a class="card cardActionShadowC text-white mt-3 cardActionRegister" style="border:none;" href="formpage/newLoginPage.php">';
    echo '<img src="./img/notLogin.jpg" class="card-img" alt="NotLogin">';
    echo '<div class="card-img-overlay d-flex flex-column">';
    echo '<h1 class="mt-auto ms-3 fw-bold" style="filter: drop-shadow(5px 5px 5px rgba(0, 0, 0, 0.7));">โปรดเข้าสู่ระบบก่อนเริ่มใช้งาน</h1>';
    echo '<h5 class="ms-3 fw-bold" style="filter: drop-shadow(5px 5px 5px rgba(0, 0, 0, 0.7));">คลิกที่นี่เพื่อเข้าสู่ระบบ...</h5>';
    echo '</div>';
    echo '</a>';
    echo '</div>';
    echo '</div>';
}
?>



        <div class="row mt-3" <?php echo $showmenu ?>>
            <div class="col-12">
                <div class="alert alert-danger w-100 welcomeAlert text-white" role="alert">
                    <span class="fw-bold">ยินดีต้อนรับ!</span>
                    <?php echo "คุณ" . $dataUserinfo['firstname'] . " " . $dataUserinfo['lastname'] . " " . randomWelcome($randomNumber); ?>
                    <?php
                    if($row_countResult != '0'){
                        echo '<hr><h6 class="mb-0 fw-bold">คุณมีคำรองที่ต้องดำเนินการจำนวน <span class="badge bg-warning text-dark">'.$row_countResult.' </span> รายการ</h6>';
                    }
                    ?>

                </div>
            </div>
        </div>

        <div class="row gy-3 gx-3" <?php echo $showmenu ?>>


            <div class="col-sm-12 col-md-6 col-lg-4">
                <a class="card cardActionShadowC text-white cardActionIndex" href="index.php" data-bs-toggle="modal" data-bs-target="#registerEquipment">
                    <img src="./img/registerEq.jpg" class="card-img" alt="RegistEquipment">
                    <div class="card-img-overlay d-flex flex-column">
                        <h3 class="card-title mt-auto ms-3 fw-bold">Register Equipment</h3>
                    </div>
                </a>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-4">
                <a class="card cardActionShadowC text-white cardActionIndex noClick" href="index.php">
                    <img src="./img/MoveBetweenFloor.jpg" class="card-img" alt="MoveBetweenFloor">
                    <div class="card-img-overlay d-flex flex-column">
                        <h3 class="card-title mt-auto ms-3 fw-bold">Move Between Floor<sup>WIP</sup></h3>
                    </div>
                </a>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-4">
                <a class="card cardActionShadowC text-white cardActionIndex noClick" href="index.php">
                    <img src="./img/IncomingEquipment.jpg" class="card-img" alt="IncomingEquipment">
                    <div class="card-img-overlay d-flex flex-column">
                        <h3 class="card-title mt-auto ms-3 fw-bold">Incoming Equipment<sup>WIP</sup></h3>
                    </div>
                </a>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-4">
                <a class="card cardActionShadowC text-white cardActionIndex noClick" href="index.php">
                    <img src="./img/OutgoingEquipment.jpg" class="card-img" alt="OutgoingEquipment">
                    <div class="card-img-overlay d-flex flex-column">
                        <h3 class="card-title mt-auto ms-3 fw-bold">Outgoing Equipment<sup>WIP</sup></h3>
                    </div>
                </a>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-4">
                <a class="card cardActionShadowC text-white cardActionIndex noClick" href="index.php">
                    <img src="./img/ReturnPartner.jpg" class="card-img" alt="ReturnPartner">
                    <div class="card-img-overlay d-flex flex-column">
                        <h3 class="card-title mt-auto ms-3 fw-bold">Return Partner<sup>WIP</sup></h3>
                    </div>
                </a>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-4">
                <a class="card cardActionShadowC text-white cardActionIndex noClick" href="index.php">
                    <img src="./img/WriteOff.jpg" class="card-img" alt="WriteOff">
                    <div class="card-img-overlay d-flex flex-column">
                        <h3 class="card-title mt-auto ms-3 fw-bold">Write Off<sup>WIP</sup></h3>
                    </div>
                </a>
            </div>
            


        </div>


    </div>

    <footer class="fixed-bottom footerCustom">
        <div class="w-100 text-center text-white my-2">
            <h6>Copyright &copy; 2022 &mdash; Operations and Maintenance CATV</h6>
        </div>
    </footer>

    <!-- Modal -->
    <div class="modal fade" id="registerEquipment" tabindex="-1" aria-labelledby="fact" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerEquipmentTitle">Register Equipment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row gy-0 gx-1">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <a class="card cardActionShadowC text-white cardActionRegister" href="./formpage/sap_list.php">
                                <img src="./img/SAP_R.jpg" class="card-img" alt="nonSAP_R">
                                <div class="card-img-overlay d-flex flex-column">
                                    <h4 class="card-title mt-auto ms-3 fw-bold actionHeaderText">Register with SAP's Data</h4>
                                    <h6 class="ms-3">Use equipment's data form<br>SAP to Register<br>ลงทะเบียนอุปกรณ์เชื่อมโยงข้อมูลจากระบบ SAP</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <a class="card cardActionShadowC text-white cardActionRegister noClick" href="#">
                                <img src="./img/nonSAP_R.jpg" class="card-img" alt="SAP_R">
                                <div class="card-img-overlay d-flex flex-column">
                                    <h4 class="card-title mt-auto ms-3 fw-bold actionHeaderText">Register non-SAP<sup>WIP</sup></h4>
                                    <h6 class="ms-3">New equipment or equipment's data <br><span class="fw-bold">IS NOT</span> on SAP.<br>สำหรับอุปกรณ์ใหม่หรือไม่มีข้อมูลบนระบบ SAP</h6>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
                <!-- <div class=" modal-footer">
                    <button type="submit" form="loadLog" class="btn btn-primary"><i class="bi bi-box-arrow-down"></i>
                        Load Data</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i>
                        Close</button>
                </div> -->

            </div>
        </div>
    </div>

    <script src="formpage/jquery-1.9.1.min.js.download"></script>
    <script src="./bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
</body>

</html>