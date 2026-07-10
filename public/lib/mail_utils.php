<?php
/****************************************************************************
 *	Create by Artit P.
 *	on July 9, 2005
 *	Last modified on July 15, 2005
 ****************************************************************************
 *	Copyright by Artit P., You can freely use this script without
 *	modified it. I don't responsible for any damage cause by
 *	this script.
 ****************************************************************************
 *
 ****************************************************************************
	MailData($sTo, $sFrom, $sSubject, $sData, $asField = array())
	SendMail($sToName, $sToEmail, $sFromName, $sFromEmail, $sCc, $sBcc, 
		$sSubject, $sTemplate, $bFile=FALSE, $asData = array(), $bHtml = FALSE, $sAttach = '', $asHeader = array())
 ****************************************************************************/
include_once('mail.php');

function MailData($sTo, $sFrom, $sSubject, $sData, $asField=array()) {
	$sMessage = "Data List\n---------\n";
	$asTo = explode(',', $sTo);
	// Add select field first
	foreach ($asField as $sField) {
		if (array_key_exists($sField, $asData)) {
			$sMessage .= "$sField : $asData[$sField]\n";
		}
	}
	// Add spliter
	$sMessage .= "\nOther Data\n----------\n";
	// Add other data
	foreach ($asData as $sKey => $sValue) {
		if (!array_key_exists($sKey, $asField)) {
			$sMessage .= "$sKey : $sValue\n";
		}
	}

	// Generate mail header
	$sHeader = "From: $sFrom\r\nReply-To: $sFrom\r\n";
	$bResult = TRUE;
	foreach ($asTo as $sTo) {
		if (!mail($sTo, $sSubject, $sMessage, $sHeader)) {
			$bResult = FALSE;
		}
	}
	return $bResult;
}

function SendMail($sToName, $sToEmail, $sFromName, $sFromEmail, $sCc, $sBcc, 
	$sSubject, $sTemplate, $bFile=FALSE, $asData=array(), $bHtml=FALSE, $sAttach='', $asHeader=array()) {
	
	$oMail = new html_mime_mail();
	if ($sCc != '') {
		array_push($asHeader, "CC: $sCc");
	}
	if ($sBcc != '') {
		array_push($asHeader, "BCC: $sBcc");
	}
	if ($bFile === TRUE) {
		$sLine = implode('', file($sTemplate));
	} else {
		$sLine = $sTemplate;
	}
	foreach ($asData as $sKey => $sValue) {
		$sLine = str_replace($sKey, $sValue, $sLine);
	}

	if ($sAttach != '') {
		$oMail->add_attachment($mail->get_file($sAttach), ExtractFilename($sAttach), GetMIMEType(ExtractFileExt($sAttach)));
	}

	if ($bHtml == TRUE) {
		$oMail->add_html($sLine, '');
	} else {
		$oMail->add_text($sLine, '');
	}
	$oMail->build_message();

	return $oMail->send($sToName, $sToEmail, $sFromName, $sFromEmail, $sSubject, $asHeader);
}
?>