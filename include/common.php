<?php
// Include all library 
include_once(HOME_PATH.'public/lib/utils.php');
include_once(HOME_PATH.'public/lib/mysql_dbi.php');
include_once(HOME_PATH.'public/lib/dbi.php');
include_once(HOME_PATH.'public/lib/db_data.php');
include_once(HOME_PATH.'public/lib/authen.php');
include_once(HOME_PATH.'public/lib/calendar.php');
include_once(HOME_PATH.'public/lib/error.php');
include_once(HOME_PATH.'public/lib/pagination.php');

include_once(HOME_PATH.'public/lib/smarty/Smarty.class.php');

// Common code
// Start session
@session_start();

// Set language
if ($_REQUEST['lang'] == 'en') {
	$sLang = 'en';
} elseif ($_REQUEST['lang'] == 'th') {
	$sLang = 'th';
}

if ($sLang != '') {
	$_SESSION['lang'] = $sLang;
} elseif ($_SESSION['lang'] != '') {
	$sLang = $_SESSION['lang'];
} else {
	$sLang = 'th';
	$_SESSION['lang'] = $sLang;
}

// Check debug from config
//$bDebug = (DEBUG == 1)? TRUE: FALSE;
// Check debug from session
if ($_REQUEST['debug'] == 'ON') {
	$_SESSION['ss_debug'] = 1;
} elseif ($_REQUEST['debug'] == 'OFF') {
	$_SESSION['ss_debug'] = 0;
}
// Assign debug state
if (!$bDebug && ($_SESSION['ss_debug'] == 1)) {
	$bDebug = TRUE;
} elseif ($_REQUEST['debug'] == 'SHOW') {
	$bDebug = TRUE;
}

if ($_REQUEST['view'] == 'SESSION') {
	print_r($_SESSION);
}

// Check debug from session
if ($_REQUEST['smartydebug'] == 'ON') {
	$_SESSION['ss_smartydebug'] = 1;
} elseif ($_REQUEST['smartydebug'] == 'OFF') {
	$_SESSION['ss_smartydebug'] = 0;
} elseif ($_REQUEST['smartydebug'] == 'SHOW') {
	$_SESSION['ss_smartydebug'] = 2;
}

// Setup Classes

/**
 *	Setup Smarty Template Engine
 */
class TemplateEngine extends Smarty {
	function TemplateEngine() {
		// Parent Class Constructor.
		$this->Smarty();

		// Init all smarty variables
		$this->template_dir = HOME_PATH.'html/';

		$this->compile_id = str_replace('/', '_', substr(ExtractParentDir($_SERVER['SCRIPT_NAME']), 1));
		$this->force_compile = FALSE;
		$this->caching = FALSE;

		$this->compile_dir = HOME_PATH.'smarty/templates_c/';
		$this->config_dir = HOME_PATH.'smarty/configs/';
		$this->cache_dir = HOME_PATH.'smarty/cache/';

		$this->left_delimiter = '<%';
		$this->right_delimiter = '%>';

		// Init site template variables
		// Login section
		$oLogin = new LoginManager();
		if ($oLogin->IsLogin()) {
			$this->assign('login', 1);
			$this->assign('username', $_SESSION['ss_username']);
			$this->assign('priv', $_SESSION['ss_privilege']);
		} else {
			$this->assign('login', 0);
			$this->assign('username', '');
		}
		
		// Smarty debug
		if ($_SESSION['ss_smarty_debug'] == 1) {
			$this->debugging = TRUE;
		}
		
		$sQS = $_SERVER['QUERY_STRING'];
		$sQS = str_replace('lang=th&', '', $sQS);
		$sQS = str_replace('lang=en&', '', $sQS);
		$this->assign('current_query_string', $sQS);
	}
}

class LoginManager extends Authentication {
	function LoginManager() {
		parent::Authentication(FALSE, 'user', 'pass', 'tbl_user_login', TRUE, FALSE, FALSE);
	}
	
	function Login($sUser, $sPass) {
		$bPass = parent::Login($sUser, $sPass);
		if ($bPass) {
			$this->oDB->Update('tbl_user_login', array('login_date' => '@SYSDATE()'), 'id='.$this->sMemberID);
		}
		return $bPass;
	}
	
	function GetMemberData() {
		// For override
		$this->axMemberData = $this->oDB->QueryRow("SELECT full_name, user_level, user_status FROM $this->sUserTable WHERE id=$this->sMemberID AND user_status='A' ", DBI_ASSOC);
		if ($this->oDB->IsError()) {
			echo($this->oDB->Error());
		}
		if ($this->axMemberData['user_level'] == 'admin') {
			$this->axMemberData['admin'] = '1';
		} else {
			$this->axMemberData['admin'] = '0';
		}
		
		// Get Permission
		$asPermission = array(
			
			'1' => 'Administrator',
			
			'2' => 'Backend_ActiveStart',
			'3' => 'Backend_ChannelLineup',
			'4' => 'Backend_Informations',
			'5' => 'Backend_PGM_Config',
			
		);
        	
		$oRes = $this->oDB->Query("SELECT au_id FROM tbl_permission WHERE user_id=".$this->sMemberID);
		if ($oRes) {
			while ($axRow = $oRes->FetchRow(DBI_ASSOC)) {
				
				$au_id  = $this->oDB->QueryOne("SELECT au_name  FROM tbl_authen WHERE au_id ='".$axRow['au_id']."' AND au_status='A' " );
				
				//$this->axMemberData['privilege'][$asPermission[$axRow['au_id']]] = 1;
				if ($au_id){
				$this->axMemberData['privilege'][$au_id] = 1;
				}
			}
		}
	}
	
	function GetMemberID() {
		// For override
		$this->sMemberID = $this->oDB->QueryOne("SELECT id FROM $this->sUserTable WHERE $this->sUserCondition");
		
		if ($this->oDB->IsError()) {
			echo($this->oDB->Error());
		}
	}
}

class DBI extends DBInterface {
	function DBI($sServer='', $sUser='', $sPassword='', $sDB='', $bPersistent=TRUE) {
		if ($sServer != '') {
			parent::DBInterface($sServer, $sUser, $sPassword, $sDB, $bPersistent);
		} else {
			parent::DBInterface(DB_HOST, DB_USER, DB_PASS, DB_NAME, FALSE);
		}
		$this->bAutoEscape = TRUE;
		//$this->Execute('SET NAMES TIS620');
	}
}

function export_excel($tableName) {
	$rs = mysql_query("select * from ".$tableName) or die("�������ö�ӧҹ���������� <!-- ".mysql_error()." -->");
	for($i=0;$i < mysql_num_fields($rs);$i++) { $header.="\"".mysql_field_name($rs, $i).'",'; }
	while($rw=mysql_fetch_row($rs))			{
		$line = "";
		foreach($rw as $value)			{
			if(!isset($value) || $value == "") $value = "\"\",";
			else { $value = str_replace('"', '""', $value); $value = '"' . $value . '"' . ","; } $line .= $value;
		}
		$data .= trim($line)."\n";
	}
	if(!$handle = fopen($tableName.".csv", 'w')) {	 print "Cannot open file ($tableName.csv)";			 exit;		}
	if(!fwrite($handle, $header."\n".$data)) {		print "Cannot write to file ($tableName.csv)";		exit;		}       
	fclose($handle);
}

/* �ѧ������������Ţ����� ��§�кؤ������ҧ �� GenNum ( 5 ) */
function GenNum ( $width )
	{
        $txt = "1234567890"; 
        srand( ( double )microtime()*1000000 ); 
        for( $i=0; $i<$width; $i++ ) 
                $num .= $txt[rand()%strlen( $txt )]; 
        return $num; 
	}

/* �ѧ������������ѡ�â���� ��§�кؤ������ҧ �� GenTxt ( 5 ) */ 
function GenTxt ( $width )
	{
        $txt = "abcdefghijklmnopqrstuvwxyz"; 
        srand( ( double )microtime()*1000000 ); 
        for( $i=0; $i<$width; $i++ ) 
                $word .= $txt[rand()%strlen( $txt )]; 
        return $word; 
	}

function GetTableDef($sTableName) {
	$oTable = NULL;
	if ($sTableName == 'ted_nmr'){
		$oTable = new DBTableDef('ted_nmr');
		$oTable->AddField(array(
				'id'			=> 'NUMBER',
				'user_insert'	=> 'NUMBER',
				'user_update'	=> 'NUMBER',
				'title'	=> 'TEXT',
				'equipment'	=> 'NUMBER',
				'location'	=> 'NUMBER',
				'room'	=> 'NUMBER',
				'system'			=> 'TEXT',
				'service'			=> 'TEXT',
				'channel'			=> 'TEXT',
				'start_date'	=> 'TEXT',
				'end_date'	=> 'TEXT',
				'start_time'	=> 'TEXT',
				'end_time'	=> 'TEXT',
				'i_time'	=> 'TEXT',
				'p_time'		=> 'TEXT',
				'impact'		=> 'TEXT',
				'complete'		=> 'TEXT',
				'curdate'	=> 'TEXT',
				'eventID'		=> 'TEXT',
				'details'		=> 'TEXT',
				'correction'	=> 'TEXT',
				'result'		=> 'TEXT',
				'co_ordinator'		=> 'TEXT',
				'remark'	=> 'TEXT',
				'afile'		=> 'TEXT',
				'insert_date'		=> 'TEXT',
				'update_date'		=> 'TEXT',
				'approve_status'		=> 'TEXT',
				'cat_id'		=> 'TEXT'
			));
		$oTable->SetIndex('id', 'NUMBER');
	}
	
	if ($sTableName == 'ted_liveevent'){
		$oTable = new DBTableDef('ted_liveevent');
		$oTable->AddField(array(
				'id'			=> 'NUMBER',
				'start_date'	=> 'DATETIME',
				'start_time'	=> 'DATETIME',
				'end_date'	=> 'DATETIME',
				'end_time'	=> 'DATETIME',
				'title'		=> 'TEXT',
				'channel'		=> 'TEXT',
				'idserver'		=> 'TEXT'
			));
		$oTable->SetIndex('id', 'NUMBER');
	}
	return $oTable;
}

?>