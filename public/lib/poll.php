<?php
/****************************************************************************
 *	Create by Artit P.
 *	on January 5, 2006
 *	Last modified on January 17, 2006 21:46
 ****************************************************************************
 *	Copyright by Artit P., You can freely use this script without
 *	modified it. I don't responsible for any damage cause by
 *	this script.
 ****************************************************************************
 *	Database Poll class
 ****************************************************************************
	Class DBPoll
 ****************************************************************************/

class DBPoll {
	var $sQuestion;
	var $axAnswer;
	var $iAllVote;
	var $iQuestionID;
	var $oDB;
	var $sQuestionTable;
	var $sAnswerTable;
	
	function DBPoll(&$oDB, $sQTable='tbl_poll_question', $sATable='tbl_poll_answer', $iQID=NULL) {
		$this->oDB =& $oDB;
		$this->sQuestionTable = $sQTable;
		$this->sAnswerTable = $sATable;
		$this->iAllVote = 0;
		if (!is_null($iQID)) {
			$this->iQuestionID = $iQID;
		}
	}
	
	function AddQuestion($sQuestion, $sStatus='A') {
		$this->oDB->Insert($this->sQuestionTable, array('question'=>$sQuestion, 'insert_date'=>'@SYSDATE()', 'status'=>$sStatus));
	}
	
	function RemoveQuestion() {
		$this->oDB->Execute("DELETE FROM ".$this->sQuestionTable." WHERE quest_id=".$this->iQuestionID);
		$this->oDB->Execute("DELETE FROM ".$this->sAnswerTable." WHERE quest_id=".$this->iQuestionID);
	}
	
	function UpdateQuestion($sQuestion) {
		$this->oDB->Update($this->sQuestionTable, array('question'=>$sQuestion), 'quest_id='.$this->iQuestionID);
	}
	
	function AddAnswer($sAnswer, $iVote=0) {
		if ($this->oDB->QueryOne("SELECT quest_id FROM ".$this->sQuestionTable." WHERE quest_id=".$this->iQuestionID)) {
			// Question exists, do insert answer
			$this->oDB->Insert($this->sAnswerTable, array('quest_id'=>$this->iQuestionID, 'answer'=>$sAnswer, 'vote'=>$iVote));
		}
	}
	
	function RemoveAnswer($iAID) {
		$this->oDB->Execute("DELETE FROM ".$this->sAnswerTable." WHERE quest_id=".$this->iQuestionID." AND ans_id=$iAID");
	}
	
	function UpdateAnswer($iAID, $sAnswer, $iVote=NULL) {
		$axData['answer'] = $sAnswer;
		if ($iVote != NULL) {
			$axData['vote'] = $iVote;
		}
		$this->oDB->Update($this->sAnswerTable, $axData, "quest_id=".$this->iQuestionID." AND ans_id=$iAID");
	}
	
	function Vote($iAID, $iVote=1) {
		$this->oDB->Execute("UPDATE ".$this->sQuestionTable." SET all_vote=all_vote+1, last_vote=SYSDATE() WHERE quest_id=".$this->iQuestionID);
		$this->oDB->Execute("UPDATE ".$this->sAnswerTable." SET vote=vote+1 WHERE quest_id=".$this->iQuestionID." AND ans_id=$iAID");
	}
	
	function SetQuestionID($iQID) {
		$this->iQuestionID = $iQID;
	}
	
	function GetAllQuestion() {
		$oRes = $this->oDB->Query("SELECT * FROM ".$this->sQuestionTable, DBI_ASSOC);
		if ($oRes) {
			return $oRes->FetchAllRow();
		} else {
			return FALSE;
		}
	}
	
	function GetAllAnswer() {
		return $this->axAnswer;
	}
	
	function ReadPoll() {
		list($this->sQuestion, $this->iAllVote) = $this->oDB->QueryRow("SELECT question, all_vote FROM ".$this->sQuestionTable." WHERE quest_id=".$this->iQuestionID);
		$oRes = $this->oDB->Query("SELECT * FROM ".$this->sAnswerTable." WHERE quest_id=".$this->iQuestionID, DBI_ASSOC);
		$this->axAnswer = $oRes->FetchAllRow();
		// Calculate result
		$this->adRatio = array();
		for ($i = 0; $i < count($this->axAnswer); $i++) {
			if ($this->iAllVote > 0) {
				$this->axAnswer[$i]['ratio'] = $this->axAnswer[$i]['vote']/$this->iAllVote;
			} else {
				$this->axAnswer[$i]['ratio'] = 0;
			}
		}
	}
}
?>