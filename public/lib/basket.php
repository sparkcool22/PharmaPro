<?php
/****************************************************************************
 *	Create by Artit P.
 *	on July 9, 2005
 *	Last modified on August 21, 2005
 ****************************************************************************
 *	Copyright by Artit P., You can freely use this script without
 *	modified it. I don't responsible for any damage cause by
 *	this script.
 ****************************************************************************
 *	Manage item basket
 *	Default Basket Table Feilds
 *		id						int
 *		name				varchar
 *		member_id	varchar
 *		item_id			int
 ****************************************************************************
	Class BasketManager
 ****************************************************************************/
 include_once('dbi.php');
 
class BasketManager {
	var $oDB;

	var $sBasketTable;
	var $sBasketName;
	var $sMemberID;

	function BasketManager(&$oDB, $sMemberID='', $sBasketName='basket', $sBasketTable='tbl_basket') {
		$this->oDB =& $oDB;
		$this->sBasketTable = $sBasketTable;
		$this->sMemberID = $sMemberID;
		$this->sBasketName = $sBasketName;
	}

	function AddToBasket($sItemID, $sMemberID=NULL, $sBasketName=NULL) {
		if (is_null($sBasketName)) {
			$sBasketName = $this->sBasketName;
		}
		if (is_null($sMemberID)) {
			$sMemberID = $this->sMemberID;
		}
		$this->oDB->Insert($this->sBasketTable, array('name' => $sBasketName, 'member_id' => $sMemberID, 'item_id' => $sItemID));
		if ($this->oDB->IsError()) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function RemoveFromBasket($sItemID, $sMemberID=NULL, $sBasketName=NULL) {
		if (is_null($sBasketName)) {
			$sBasketName = $this->sBasketName;
		}
		if (is_null($sMemberID)) {
			$sMemberID = $this->sMemberID;
		}
		$this->oDB->Execute("DELETE FROM $this->sBasketTable WHERE member_id='$sMemberID' AND name='$sBasketName' AND item_id=$sItemID");
		if ($this->oDB->IsError()) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function EmptyBasket($sMemberID=NULL, $sBasketName=NULL) {
		if (is_null($sBasketName)) {
			$sBasketName = $this->sBasketName;
		}
		if (is_null($sMemberID)) {
			$sMemberID = $this->sMemberID;
		}
		$this->oDB->Execute("DELETE FROM $this->sBasketTable WHERE member_id='$sMemberID' AND name='$sBasketName'");
		if ($this->oDB->IsError()) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function GetItemFromBasket($sMemberID=NULL, $sBasketName=NULL) {
		if (is_null($sBasketName)) {
			$sBasketName = $this->sBasketName;
		}
		if (is_null($sMemberID)) {
			$sMemberID = $this->sMemberID;
		}
		$oRes = $this->oDB->Query("SELECT item_id FROM $this->sBasketTable WHERE member_id='$sMemberID' AND name='$sBasketName'");
		$asItem = array();
		while ($asRow = $oRes->FetchRow()) {
			$asItem[] = $asRow[0];
		}
		return $asItem;
	}

	function CountItemInBasket($sMemberID=NULL, $sBasketName=NULL) {
		if (is_null($sBasketName)) {
			$sBasketName = $this->sBasketName;
		}
		if (is_null($sMemberID)) {
			$sMemberID = $this->sMemberID;
		}
		return (int)$this->oDB->QueryOne("SELECT COUNT(*) FROM $this->sBasketTable WHERE member_id='$sMemberID' AND name='$sBasketName'");
	}

	function InBasket($sItemID, $sMemberID=NULL, $sBasketName=NULL) {
		if (is_null($sBasketName)) {
			$sBasketName = $this->sBasketName;
		}
		if (is_null($sMemberID)) {
			$sMemberID = $this->sMemberID;
		}
		return $this->oDB->QueryOne("SELECT COUNT(*) FROM $this->sBasketTable WHERE member_id='$sMemberID' AND name='$sBasketName' AND item_id='$sItemID'") > 0;
	}
}
?>