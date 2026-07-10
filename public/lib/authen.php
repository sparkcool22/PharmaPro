<?php
/****************************************************************************
 *	Create by Artit P.
 *	on July 9, 2005
 *	Last modified on August 28, 2005
 ****************************************************************************
 *	Copyright by Artit P., You can freely use this script without
 *	modified it. I don't responsible for any damage cause by
 *	this script.
 ****************************************************************************

 ****************************************************************************
	Class Authentication
	Class GroupManager
 ****************************************************************************/
include_once('dbi.php');

class Authentication {
	var $sUser;
	var $sPass;
	var $iLevel;
	var $asGroup;
	var $axMemberData;
	var $oDB;
	var $sUserCondition;
	var $sMemberID;
	
	var $sUserField;
	var $sPassField;
	var $sUserTable;
	var $bPassEncode;
	var $bMemberLevel;
	var $bMemberGroup;
	var $bStoreData;
	var $bStoreDataInSession;
	var $bStoreDataInCookie;
	var $sPrefix;	

	function Authentication($bPassEncode=FALSE, $sUserField='username', $sPassField='passwd', 
			$sUserTable='tbl_user', $bStoreData=FALSE, $bMemberLevel=FALSE, $bMemberGroup=FALSE, $sPrefix='aupro_') {
		$this->iLevel = 99;
		$this->asGroup = array();
		$this->bStoreDataInSession = TRUE;
		$this->bStoreDataInCookie = FALSE;
		$this->sUserField = $sUserField;
		$this->sPassField = $sPassField;
		$this->sUserTable = $sUserTable;
		$this->bPassEncode = $bPassEncode;
		$this->bStoreData = $bStoreData;
		$this->bMemberLevel = $bMemberLevel;
		$this->bMemberGroup = $bMemberGroup;
		$this->sPrefix = $sPrefix;
	}
	
	function SetDBConnection(&$oDB) {
		$this->oDB =& $oDB;
	}

	function Login($sUser, $sPass) {
		if ($this->bPassEncode) {
			$this->sUserCondition = "$this->sUserField='$sUser' AND $this->sPassField=PASSWORD('$sPass')";
		} else {
			$this->sUserCondition = "$this->sUserField='$sUser' AND $this->sPassField='$sPass'";
		}
		$axRow = $this->oDB->QueryRow("SELECT COUNT(*) FROM $this->sUserTable WHERE $this->sUserCondition", DBI_NUM);
		if ($axRow) {
			if ($axRow[0] >= 1) {
				$this->sUser = $sUser;
				$this->sPass = $sPass;
				$this->GetMemberID();
				$_SESSION[$this->sPrefix.'member_id'] = $this->sMemberID;
				if ($this->bStoreData) {
					$this->StoreMemberData();
				}
				if ($this->bMemberLevel) {
					$this->StoreMemberLevel();
				}
				if ($this->bMemberGroup) {
					$this->StoreMemberGroup();
				}
				return TRUE;
			} else {
				return FALSE;
			}
		}
	}
	
	function Logout() {
		foreach ($_SESSION as $sKey => $sValue) {
			if (substr($sKey, 0, strlen($this->sPrefix)) == $this->sPrefix) {
				$_SESSION[$sKey] = NULL;
			}
		}
		foreach ($_COOKIE as $sKey => $sValue) {
			if (substr($sKey, 0, strlen($this->sPrefix)) == $this->sPrefix) {
				setcookie($sKey, FALSE);
			}
		}
	}
	
	function IsLogin() {
		return $_SESSION[$this->sPrefix.'member_id'] !== NULL;
	}
	
	function IsAdmin() {
		return $_SESSION[$this->sPrefix.'admin'] == 1;
	}
	
	function GetLevel() {
		return $_SESSION[$this->sPrefix.'level'];
	}
	
	function GetGroup() {
		return $_SESSION[$this->sPrefix.'group'];
	}
	
	function GetMemberID() {
		return $_SESSION[$this->sPrefix.'member_id'];
	}
	
	function GetSessionVar($sVarName) {
		return $_SESSION[$this->sPrefix.$sVarName];
	}
	
	function StoreMemberData() {
		$this->GetMemberData();
		if ($this->bStoreDataInSession) {
			foreach ($this->axMemberData as $sKey => $xValue) {
				$_SESSION[$this->sPrefix.$sKey] = $xValue;
			}
		}
		if ($this->bStoreDataInCookie) {
			foreach ($this->axMemberData as $sKey => $xValue) {
				setcookie($this->sPrefix.$sKey, $xValue);
			}
		}
	}
	
	function StoreMemberLevel() {
		$this->GetMemberLevel();
		if ($this->bStoreDataInSession) {
			$_SESSION[$this->sPrefix.'level'] = $this->iLevel;
		}
		if ($this->bStoreDataInCookie) {
			setcookie($this->sPrefix.'level', $this->iLevel);
		}
	}
	
	function StoreMemberGroup() {
		$this->GetMemberGroup();
		if ($this->bStoreDataInSession) {
			$_SESSION[$this->sPrefix.'group'] = implode(',', $this->asGroup);
		}
		if ($this->bStoreDataInCookie) {
			setcookie($this->sPrefix.'group', implode(',', $this->asGroup));
		}
	}
	
	function QueryMemberData() {
		$this->axMemberData = $this->oDB->QueryRow("SELECT firstname, lastname, email FROM $this->sUserTable WHERE $this->sUserCondition", DBI_ASSOC);
		if ($this->oDB->IsError()) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	function QueryMemberLevel() {
		$this->iLevel = $this->oDB->QueryOne("SELECT level FROM $this->sUserTable WHERE $this->sUserCondition");
		if ($this->oDB->IsError()) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	function QueryMemberGroup() {
		$oRes = $this->oDB->Query("SELECT g.name FROM tbl_user_group AS ug, tbl_group AS g WHERE ug.member_id='$this->sMemberID' AND ug.group_id=g.id", DBI_NUM);
		// Clear old group data
		$this->asGroup = array();
		if ($oRes) {
			while ($asRow = $oRes->FetchRow()) {
				$this->asGroup[] = $asRow[0];
			}
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function QueryMemberID() {
		$this->sMemberID = $this->oDB->QueryOne("SELECT member_id FROM $this->sUserTable WHERE $this->sUserCondition");
		if ($this->oDB->IsError()) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
}

class GroupManager {
	var $oDB;
	var $sUserTable;
	var $sGroupTable;
	var $sUserGroupTable;

	function GroupManager(&$oDB, $sUT = 'tbl_user', $sGT = 'tbl_group', $sUGT = 'tbl_user_group') {
		$this->oDB =& $oDB;
		$this->sUserTable = $sUT;
		$this->sGroupTable = $sGT;
		$this->sUserGroupTable = $sUGT;
	}
	
	function AddGroup($sName) {
		$this->oDB->Insert($this->sGroupTable, array('name' => $sName));
	}
	
	function RemoveGroup($sID) {
		$this->oDB->Execute("DELETE FROM $this->sGroupTable WHERE id=$sID");
	}
	
	function UpdateGroup($sID, $sName) {
		$this->oDB->Update($this->sGroupTable, array('name' => $sName), "id=$sID");
	}
	
	function AddToGroup($sMemberID, $sGroupID) {
		$this->oDB->Insert($this->sUserGroupTable, array('member_id' => $sMemberID, 'group_id' => $sGroupID));
	}
	
	function RemoveFromGroup($sMemberID, $sGroupID) {
		$this->Execute("DELETE FROM $this->sUserGroupTable WHERE member_id='$sMemberID' AND group_id=$sGroupID");
	}
	
	function GetGroup() {
		$oRes = $this->oDB->Query("SELECT id, name FROM $this->sGroupTable");
		$asGroup = array();
		while ($asRow = $oRes->FetchRow()) {
			$asGroup[$asRow[0]] = $asRow[1];
		}
		return $asGroup;
	}

	function GetUserInGroup($sID) {
		$oRes = $this->oDB->Query("SELECT member_id FROM $this->sUserGroupTable WHERE group_id=$sID");
		$asMember = array();
		while ($asRow = $oRes->FetchRow()) {
			$asMember[] = $asRow[0];
		}
		return $asMember;
	}

	function GetUserNotInGroup($sID) {
		$oRes = $this->oDB->Query("SELECT u.member_id FROM $this->sUserTable AS u LEFT OUTER JOIN $this->sUserGroupTable AS ug USING(member_id) WHERE ug.group_id=$sID AND ug.member_id IS NULL");
		$asMember = array();
		while ($asRow = $oRes->FetchRow()) {
			$asMember[] = $asRow[0];
		}
		return $asMember;
	}

	function GetUserGroup($sID) {
		$oRes = $this->oDB->Query("SELECT g.id, g.name FROM $this->sUserGroupTable AS ug, $this->GroupTable AS g WHERE ug.member_id='$sID' AND ug.group_id=g.id");
		$asGroup = array();
		while ($asRow = $oRes->FetchRow()) {
			$asGroup[$asRow[0]] = $asRow[1];
		}
		return $asGroup;
	}

	function GetNotUserGroup($sID) {
		$oRes = $this->oDB->Query("SELECT g.id, g.name FROM $this->GroupTable AS g LEFT OUTER JOIN $this->sUserGroupTable AS ug ON (g.id=ug.group_id) WHERE ug.member_id IS NULL");
		$asGroup = array();
		while ($asRow = $oRes->FetchRow()) {
			$asGroup[$asRow[0]] = $asRow[1];
		}
		return $asGroup;
	}
}
?>