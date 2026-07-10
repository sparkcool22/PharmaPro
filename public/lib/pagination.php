<?php
/****************************************************************************
 *	Create by Artit P.
 *	on July 9, 2005
 *	Last modified on September 30, 2005
 ****************************************************************************
 *	Copyright by Artit P., You can freely use this script without
 *	modified it. I don't responsible for any damage cause by
 *	this script.
 ****************************************************************************
 *	Handle record paging
 ****************************************************************************/
class Pagination {
	var $iStartPage;
	var $iStopPage;
	var $iStartRec;
	var $iStopRec;
	var $iTotalPage;
	var $iNextPage;
	var $iPrevPage;
	
	var $iTotalRec;
	var $iCurPage;
	var $iPerPage;
	var $iPageInNav;
	var $sNextText;
	var $sPrevText;
	var $sFirstText;
	var $sLastText;
	var $sLinkUrl;
	var $sPageText;
	var $sCurPageText;
	var $sSeparator;
	var $bCenterCurPage;
	var $bAutoFPNL;
	
	function Pagination($iTR=0, $sLU='', $iCP=1, $iPP=15, $iPN=10, $sFT='<<', $sPT='<', $sNT='>', $sLT='>>', $sT='{i}', $sCT='<b>{i}</b>', $sS=' ', $bCC=FALSE, $bAuto=TRUE) {
		$this->iStartRec = 0;
		$this->iStopRec = 0;
		$this->iStartPage = 0;
		$this->iStopPage = 0;
		$this->iTotalPage = 0;
		$this->iTotalRec = $iTR;
		$this->sLinkUrl = $sLU;
		$this->iCurPage = $iCP;
		$this->iPerPage = $iPP;
		$this->iPageInNav = $iPN;
		$this->sFirstText = $sFT;
		$this->sPrevText = $sPT;
		$this->sNextText = $sNT;
		$this->sLastText = $sLT;
		$this->sPageText = $sT;
		$this->sCurPageText = $sCT;
		$this->sSeparator = $sS;
		$this->bCenterCurPage = $bCC;
		$this->bAutoFPNL = $bAuto;
	}
	
	function SetPageInfo($iTR=0, $sLU='', $iCP=1, $iPP=15, $iPN=10) {
		$this->iTotalRec = $iTR;
		$this->sLinkUrl = $sLU;
		$this->iCurPage = $iCP;
		$this->iPerPage = $iPP;
		$this->iPageInNav = $iPN;
	}
	
	function SetPageText($sFT='<<', $sPT='<', $sNT='>', $sLT='>>', $sT='{i}', $sCT='<b>{i}</b>', $sS=' ') {
		$this->sFirstText = $sFT;
		$this->sPrevText = $sPT;
		$this->sNextText = $sNT;
		$this->sLastText = $sLT;
		$this->sPageText = $sT;
		$this->sCurPageText = $sCT;
		$this->sSeparator = $sS;
	}
	
	function SetCurPage($iCP) {
		$this->iCurPage = $iCP;
	}

	function SetTotalRec($iTR) {
		$this->iTotalRec = $iTR;
	}
	
	function GetTotalRec() {
		return $this->iTotalRec;
	}
	
	function GetStartPage() {
		return $this->iStartPage;
	}
	
	function GetStopPage() {
		return $this->iStopPage;
	}
	
	function GetStartRec() {
		return $this->iStartRec;
	}
	
	function GetStopRec() {
		return $this->iStopRec;
	}
	
	function GetNextPage() {
		return $this->iNextPage;
	}
	
	function GetPrevPage() {
		return $this->iPrevPage;
	}
	
	function GetLastPage() {
		return $this->iTotalPage;
	}
	
	function GetPerPage() {
		return $this->iPerPage;
	}
	
	function DoValid() {
		if (!is_numeric($this->iTotalRec) || ($this->iTotalRec < 0)) {
			$this->iTotalRec = 0;
		}
		if (!is_numeric($this->iPerPage) || ($this->iPerPage <= 0)) {
			$this->iPerPage = 15;
		}
		if (!is_numeric($this->iCurPage) || ($this->iCurPage <= 0)) {
			$this->iCurPage = 1;
		}
		if (!is_numeric($this->iPageInNav) || ($this->iPageInNav <= 0)) {
			$this->iPageInNav = 10;
		}
		$this->iTotalPage = ceil($this->iTotalRec/$this->iPerPage);
		if ($this->iCurPage > $this->iTotalPage) {
			$this->iCurPage = $this->iTotalPage;
		}
	}

	function DoPaging() {
		$this->DoValid();
		if ($this->bCenterCurPage) {
			$this->iStartPage = $this->iCurPage - ceil($this->iPageInNav/2);
			$this->iStopPage = $this->iStartPage + $this->iPageInNav;
			$this->iStartPage++;
		} else {
			$this->iStartPage = (ceil($this->iCurPage/$this->iPageInNav) - 1)*$this->iPageInNav;
			$this->iStopPage = $this->iStartPage + $this->iPageInNav;
			$this->iStartPage++;
		}
		if ($this->iStartPage <= 0) {
			$this->iStartPage = 1;
		} elseif ($this->iStartPage > $this->iTotalPage) {
			$this->iStartPage = $this->iTotalPage;
		}
		if ($this->iStopPage > $this->iTotalPage) {
			$this->iStopPage = $this->iTotalPage;
		}
		
		$this->iStartRec = ($this->iCurPage - 1)*$this->iPerPage;
		if ($this->iStartRec < 0) {
			$this->iStartRec = 0;
		}
		
		$this->iStopRec = $this->iStartRec + $this->iPerPage;
		if ($this->iStopRec > $this->iTotalRec) {
			$this->iStopRec = $this->iTotalRec;
		}
		
		$this->iNextPage = $this->iCurPage + 1;
		if ($this->iNextPage > $this->iTotalPage) {
			$this->iNextPage = $this->iTotalPage;
		}
		$this->iPrevPage = $this->iCurPage - 1;
		if ($this->iPrevPage <= 0) {
			$this->iPrevPage = 1;
		}
	}

	function GetPageLink() {
		$sLink = '';
		for ($i = $this->iStartPage; $i <= $this->iStopPage; $i++) {
			if ($i != $this->iStartPage) {
				$sLink .= $this->sSeparator;
			}
			if ($i == $this->iCurPage) {
				$sLink .= str_replace('{i}', $i, $this->sCurPageText);
			} else {
				$sLink .= '<a href="'.str_replace('{i}', $i, $this->sLinkUrl).'">'.str_replace('{i}', $i, $this->sPageText).'</a>';
			}
		}
		return $sLink;
	}
	
	function GetNextLink() {
		if ($this->sNextText != '') {
			if ($this->bAutoFPNL && ($this->iCurPage >= $this->iTotalPage)) {
				return '';
			}
			return '<a href="'.str_replace('{i}', $this->iNextPage, $this->sLinkUrl).'">'.$this->sNextText.'</a>';
		} else {
			return '';
		}
	}
	
	function GetPrevLink() {
		if ($this->sPrevText != '') {
			if ($this->bAutoFPNL && ($this->iCurPage <= 1)) {
				return '';
			}
			return '<a href="'.str_replace('{i}', $this->iPrevPage, $this->sLinkUrl).'">'.$this->sPrevText.'</a>';
		} else {
			return '';
		}
	}
	
	function GetFirstLink() {
		if ($this->sFirstText != '') {
			if ($this->bAutoFPNL && ($this->iCurPage <= 1)) {
				return '';
			}
			return '<a href="'.str_replace('{i}', '1', $this->sLinkUrl).'">'.$this->sFirstText.'</a>';
		} else {
			return '';
		}
	}
	
	function GetLastLink() {
		if ($this->sLastText != '') {
			if ($this->bAutoFPNL && ($this->iCurPage >= $this->iTotalPage)) {
				return '';
			}
			return '<a href="'.str_replace('{i}', $this->iTotalPage, $this->sLinkUrl).'">'.$this->sLastText.'</a>';
		} else {
			return '';
		}
	}
	
	function GetNavLink() {
		return $this->GetFirstLink().' '.$this->GetPrevLink().' '.$this->GetPageLink().' '.$this->GetNextLink().' '.$this->GetLastLink();
	}
}
?>