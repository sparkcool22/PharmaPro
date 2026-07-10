<?php
error_reporting( error_reporting() & ~E_NOTICE );
// error_reporting(~E_NOTICE);
define('WEB_NAME', 'http://PharmaPro');

# -------------------------------------------
// Home path tvsengineering
# -------------------------------------------
// define('HOME_PATH', '/var/www/html/PharmaPro/');
// define('HOME_URL', '/PharmaPro/');
define('HOME_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('HOME_URL', '/PharmaPro/');

define('UPLOAD_PATH', HOME_PATH.'upload/');
define('UPLOAD_URL', HOME_URL.'upload/');

define('APP_PATH', HOME_PATH.'app/');
define('APP_URL', HOME_URL.'app/');

define('HTML_PATH', HOME_PATH.'html/');
define('HTML_URL', HOME_URL.'html/');

define('INC_PATH', HOME_PATH.'include/');
define('TEMPLATE_PATH', HOME_PATH.'smarty/templates_c/');

define('PUBLIC_PATH', HOME_PATH.'public/');
define('LIB_PATH', PUBLIC_PATH.'lib/');

define('FILESIMG_PATH', UPLOAD_PATH.'files_images/');
define('FILESIMG_URL', UPLOAD_URL.'files_images/');

define('USERIMG_PATH', UPLOAD_PATH.'user_images/');
define('USERIMG_URL', UPLOAD_URL.'user_images/');

# -------------------------------------------
// Database Config
# -------------------------------------------
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'tedinno!!@@##');
define('DB_NAME', 'db_pharmapro');

// ***********************************************
// config use all web
// ***********************************************
$sUser_IP =$_SERVER['REMOTE_ADDR'];
$sNow_DateTime = date('Y-m-d H:i:s');
$sNow_Date = date('Y-m-d');
$sNow_Time = date('H:i:s');
$sUser_URLreferer =$_SERVER['HTTP_REFERER'];

// ย้อนหลัง 1 อาทิตย์
$sBefor_7_Day = date("Y-m-d H:i:s", mktime(date("H"), date("i")+0, date("s")+0, date("m")+0 , date("d")-7, date("Y")+0));
// ย้อนหลัง 24 ชั่วโมง
$sBefor_24_Hr = date('Y-m-d H:i:s', mktime(date("H")-24, date("i")+0, date("s")+0))."";

$asStatus = array(
	'A' => 'Active',
	'N' => 'Inactive'
);
$asSA11 = array(
	'N' => 'No',
	'Y' => 'Yes'
);
$asPrescription = array(
	'N' => 'No',
	'Y' => 'Yes'
);

// user&member
$asUserLevel = array(
	//'S' => 'Super Admin',
	'A' => 'Open',
	'U' => 'Lock',
);
$asTitle= array(
	'0' => 'Other',
	'1' => 'Mr.',
	'2' => 'Ms.',
);
$asฺำBEtype= array(
	'0' => 'Inactive',
	'1' => 'Active',
);

// ***********************************************
// for channel lineup
// ***********************************************
$asOptionchannel = array(
	'Y' => 'Yes',
	'N' => 'No'
);
$asAudiotype = array(
	'D' => 'Dual',
	'S' => 'Stereo'
);
$asOptionradio = array(
	'Y' => 'Yes',
	'N' => 'No'
);
$asOptionlineup = array(
	'A' => 'Analog CATV',
	'D' => 'Digital'
);

// ***********************************************
// Streamming TV
// ***********************************************
$asChanneltype = array(
	'W' => 'WindowsMedia',
	'F' => 'FlashPlayer'
);

// ***********************************************
// for forum
// ***********************************************
function filter($string){
	$badwords = array(
		"fucking",
		"fuck",
		"fuck you",
		"fuck u",
		"f u c k",
		"f.u.c.k",
		"มึง",
		"มึ ง",
		"ม ึ ง",
		"ม ึง",
		"มงึ",
		"มึ.ง",
		"มึ_ง",
		"มึ-ง",
		"มึ+ง",
		"กู",
		"ควย",
		"ค ว ย",
		"ค-ว-ย",
		"ค.ว.ย",
		"คอวอยอ",
		"คอ วอ ยอ",
		"คอ-วอ-ยอ",
		"ปี้",
		"เหี้ย",
		"เหี้-ย",
		"ไอ้***",
		"เฮี้ย",
		"ชาติหมา",
		"ชาดหมา",
		"ช า ด ห ม า",
		"ช.า.ด.ห.ม.า",
		"ช า ติ ห ม า",
		"ช.า.ติ.ห.ม.า",
		"สัดหมา",
		"สัด",
		"สาด",
		"ส า ด",
		"หี",
		"สันดาน",
		"ส้นตีน",
		"แตด",
		"สาด",
		"แดก",
		"แหม่งง",
		"แม่ง",
		"แหม่ง",
		"ไอ้สัด",
		"โครตแม่ง",
		"โคดแม่ง",
		"สันดาน",
		"เย็ด",
		"โครตพ่อ",
		"โคดพ่อ",
		"โครตแม่",
		"โคดแม่",
	) ;
	
	$filtered = str_replace($badwords, "<font color=\"#ff0000\"> *** </font>", $string);
	return $filtered;
}

// ***********************************************
// for user online
// ***********************************************
function getBrowser() 
{ 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'macintosh';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
    
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    } 
    elseif(preg_match('/Firefox/i',$u_agent)) 
    { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    } 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)) 
    { 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 
    } 
    elseif(preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    } 
    elseif(preg_match('/Netscape/i',$u_agent)) 
    { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    } 
    
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
    
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
    
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
    
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
} 

// ***********************************************
// streaming tv
// ***********************************************
function CheckUserLogin_StreamingTV() {
	$oLogin = new LoginManager();
	if (!$oLogin->IsLogin()) {
		Redirect('streamingtv_login.php');
		exit();
		
	} elseif (!$oLogin->IsAdmin()) {
		Redirect('streamingtv_login.php?message=No Pemission');
		exit();
		
	}
}

// ***********************************************
// หลังบ้าน - administrator
// ***********************************************
function CheckUserLogin_Backend() {
	$oLogin = new LoginManager();
	if (!$oLogin->IsLogin()) {
		Redirect('../../index.php');
		// exit();
		
	} elseif (!$oLogin->IsAdmin()) {
		Redirect('index.php?message=No Pemission');
		// exit();
		
	}
}

// ***********************************************
// หน้าบ้าน - front page
// ***********************************************
function CheckUserLogin_Fornt() {
	$oLogin = new LoginManager();
	if (!$oLogin->IsLogin()) {
		Redirect('login.php');
		exit();
		
	} elseif (!$oLogin->IsAdmin()) {
		Redirect('index.php');
		
	}
}

// for TRD ----------------
function CheckUserLogin_TRD() {
	$oLogin = new LoginManager();
	if (!$oLogin->IsLogin()) {
		Redirect('../login.php');
		exit();
		
	/*} elseif (!$oLogin->IsAdmin()) {
		Redirect('../home.php?message=No Pemission');
		exit();*/
		
	}
}

// ***********************************************
// for ??
// ***********************************************
function SqlDateFormat($sDate) {
	if ($sDate != '') {
		$sDate = trim($sDate);
		$sYear = substr($sDate, 0, 4);
		$sMonth = substr($sDate, 4, 2);
		$sDay = substr($sDate, 6, 2);
		$sTime = substr($sDate, 9, 8);
		
		$sSqlDate = $sYear.'-'.$sMonth.'-'.$sDay.' '.$sTime;
		return $sSqlDate;
		
	} else {
		return FALSE;
		
	}
}

// ***********************************************
// send mail config 
// ***********************************************

// ***********************************************
// mail function
// ***********************************************
function sock_mail($auth,$to, $cc, $subj, $body, $head, $from)
{

	$sTo = $to;
	$sCC = $cc;
	
	$sHeaders=$head;
	
	$mail = new PHPMailer();
	
	$mail->IsSMTP();
	$mail->Host = "172.19.3.75"; // เฉพาะวงในเท่านั้น
	//$mail->Host = "172.22.234.180"; // ส่งได้ทั้งวงนอกและวงใน
	$mail->SMTPAuth = false;
	//**********************************************
	//**********************************************
	$mail->Username = "";
	$mail->Password = "";
	//**********************************************
	//**********************************************
	$mail->charset = "windows-874";
	$mail->IsHTML(true);  

	$mail->From     = $from;
	
	// TO Email ----------------------
	for ($y=0; $y<=100; $y++) {
		if($sTo[$y]!=""){
			$mail->AddAddress($sTo[$y]); 
		}
	}
	
	// CC Email ----------------------
	for ($z=0; $z<=100; $z++) {
		if($sCC[$z]!=""){
			$mail->AddCC($sCC[$z]);
		}
	}
	
	$mail->Subject  =  $subj;
	$mail->Body     =  $body;
	if ($mail->Send()) {
		echo(" OK\n");
	} else {
		echo(" ERROR\n");
	}
return 1;
}

// ***********************************************
// mail function
// ***********************************************
function sock_mail_external($auth,$to, $cc, $subj, $body, $head, $from)
{

	$sTo = $to;
	$sCC = $cc;
	
	$sHeaders=$head;
	
	$mail = new PHPMailer();
	
	$mail->IsSMTP();
	$mail->Host = "172.19.3.75";
	//$mail->Host = "172.22.201.211";
	//$mail->Host = "172.22.234.180";
	$mail->SMTPAuth = false;
	//**********************************************
	//**********************************************
	$mail->Username = "";
	$mail->Password = "";
	//**********************************************
	//**********************************************
	$mail->charset = "windows-874";
	$mail->IsHTML(true);  

	$mail->From     = $from;
	
	// TO Email ----------------------
	for ($y=0; $y<=100; $y++) {
		if($sTo[$y]!=""){
			$mail->AddAddress($sTo[$y]); 
		}
	}
	
	// CC Email ----------------------
	for ($z=0; $z<=100; $z++) {
		if($sCC[$z]!=""){
			$mail->AddCC($sCC[$z]);
		}
	}
	
	$mail->Subject  =  $subj;
	$mail->Body     =  $body;
	if ($mail->Send()) {
		echo(" OK\n");
	} else {
		echo(" ERROR\n");
	}
return 1;
}

// ***********************************************
// config display list / page
// ***********************************************
define('REC_PER_PAGE_FRONT', 30);
define('REC_PER_PAGE_BACKEND', 30);
define('REC_PER_PAGE_FORUM', 15);
define('DEBUG', 0);
?>