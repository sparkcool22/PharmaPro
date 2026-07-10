

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>O&M&mdash;Login page</title>
	<link rel="stylesheet" href="css/bootmy.css" >
	<link rel="stylesheet" type="text/css" href="css/my-login.css">
</head>
<?php
include('../include/config.php');
include('../include/common.php');

// Read parameters
$sACT =  isset($_REQUEST['act']) ? $_REQUEST['act'] : '';

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
		Redirect('../index.php');

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
// echo $_SESSION["au_privilege"]["Administrator"];
$oDB->Close();
?>

<body class="my-login-page">
	<form name="frmlogin"  method="post" action="">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand1" style="text-align: center;" >
						<p></p>
						<img style=" height: auto;width: 30%;" src="../img/omlogo.png" alt="logo">
						<p></p>
					</div>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Login</h4>
							<form method="POST" class="my-login-validation" novalidate="">
								<div class="form-group">
									<label for="name">User</label>
									<input id="user" type="text" class="form-control" name="user" value="" required autofocus>
									<div class="invalid-feedback">
										User is invalid
									</div>
								</div>

								<div class="form-group">
									<label for="password">Password
									</label>
									<input id="pass" type="password" class="form-control" name="pass" required data-eye>
								    <div class="invalid-feedback">
								    	Password is required
							    	</div>
								</div>

								<div class="form-group">
									<div class="custom-checkbox custom-control">
										<input type="checkbox" name="remember" id="remember" class="custom-control-input">
										<!-- <label for="remember" class="custom-control-label">Remember Me</label> -->
									</div>
								</div>

								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block">
										Login
									</button>
									<input name="act" type="hidden" id="act" value="login" />
								</div>
								<div class="mt-4 text-center">
									กลับไปหน้าหลัก <a href="../index.php">คลิก</a>
								</div>
							</form>
						</div>
					</div>
					<div class="footer">
						Copyright &copy; 2021 &mdash; Operations and Maintenance CATV
					</div>
				</div>
			</div>
		</div>
	</section>
	</form>
	<script src="js/invalidation.js" ></script>
	<script src="js/popper.min.js" ></script>
	<script src="js/bootstrap.minCJ.js"></script>
	<script src="js/my-login.js"></script>
</body>
</html>
