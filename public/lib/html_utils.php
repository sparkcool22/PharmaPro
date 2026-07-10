<?php
/****************************************************************************
 *	Create by Artit P.
 *	on July 9, 2005
 *	Last modified on November 8, 2005
 ****************************************************************************
 *	Copyright by Artit P., You can freely use this script without
 *	modified it. I don't responsible for any damage cause by
 *	this script.
 ****************************************************************************
 *
 ****************************************************************************
	Redirect($sUrl)
	JSRedirect($sUrl)
	JSOpenWin($sUrl, $sName = '', $sOptions = '')
	SetCookieHeader($sName, $sValue = '', $iExpires = 0, $sPath = '/', $sDomain = '', $iSecure = 0)
	DeleteCookieHeader($name, $path = '/', $domain = '')
	RemoveAllCookies()
	GetMIMEType($sExt)
	GenerateHiddenFieldFrom($asField, $sPrefix='du_')
 ****************************************************************************/

function Redirect($sUrl) {
	if (headers_sent()) {
		JSRedirect($sUrl);
	} else {
		header('Location: '.$sUrl);
	}
}

function JSRedirect($sUrl) {
	echo('<script language="JavaScript">window.location.href="'.$sUrl.'";</script>');
}

function JSOpenWin($sUrl, $sName='', $sOptions='') {
	return '<script language="JavaScript">window.open("'.$sUrl.'", "'.$sName.'", "'.$sOptions.'");</script>';
}

function SetCookieHeader($sName, $sValue='', $iExpires=0, $sPath='/', $sDomain='', $iSecure=0) {
	return setcookie($sName, $sValue, $iExpire*60, $sPath, $sDomain, $iSecure);
}

function DeleteCookieHeader($sName, $sPath='/', $sDomain='') {
	return setcookie($sName, FALSE, time() - 3600, $sPath, $sDomain);
}

function RemoveAllCookies() {
	foreach ($_COOKIE as $sName => $sValue) {
		if ($sName != session_name()) {
			DeleteCookieHeader($sName);
		}
	}
}

function GetMIMEType($sExt) {
	$sExt = strtolower($sExt);
	if ($sExt == 'gif') {
		return 'image/gif';
	} elseif ($sExt == 'jpg' || $sExt == 'jpe' || $sExt == 'jpeg') {
		return 'image/jpg';
	} elseif ($sExt == 'png') {
		return 'image/png';
	} elseif ($sExt == 'html' || $sExt == 'htm') {
		return 'text/html';
	} elseif ($sExt == 'txt') {
		return 'text/plain';
	} elseif ($sExt == 'doc') {
		return 'application/msword';
	} elseif ($sExt == 'pdf') {
		return 'application/pdf';
	} elseif ($sExt == 'ppt') {
		return 'application/vnd.ms-powerpoint';
	} elseif ($sExt == 'xls') {
		return 'application/vnd.ms-excel';
	} elseif ($sExt == 'zip') {
		return 'application/zip';
	} else {
		return 'application/x-unknown-content-type';
	}
}

function GenerateHiddenFieldFrom($asField, $sPrefix='du_', $asSave=NULL, $asNotSave=NULL) {
	$asData = array();
	foreach ($asField as $sKey => $xVal) {
		if (substr($sKey, 0, strlen($sPrefix)) == $sPrefix) {
			$bAdd = FALSE;
			if (is_null($asSave) || in_array($sKey, $asSave)) {
				$bAdd = TRUE;
			}
			if (!is_null($asNotSave) && in_array($sKey, $asNotSave)) {
				$bAdd = FALSE;
			}			
			if ($bAdd) {
				if (is_array($xVal)) {
					for ($i = 0; $i < count($xVal); $i++) {
						$asData[] = '<input type="hidden" value="'.$xVal[$i].'" name="'.$sKey.'[]" id="'.$sKey.'">';
					}
				} else {
					$asData[] = '<input type="hidden" value="'.$xVal.'" name="'.$sKey.'" id="'.$sKey.'">';
				}
			}
		}
	}
	return implode("\n", $asData);
}
?>