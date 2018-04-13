<?php
Function SendMail($myName,$myFrom,$myReplyTo,$myTo, $myCCList, $myBCCList, $mySubject,$myMsg, $MailFormat)
{
	global $WU_DATA;

	if(!isset($MailFormat) || ($MailFormat!=0 && $MailFormat!=1))
		$MailFormat = 1;

	if($MailFormat==1)
	{
		$myMsgTop = "<table border='0' cellspacing='0' cellpadding='2' width='95%'>
			<tr><td><font face='verdana' size='2'>";

		$myMsgBottom = "</font></td></tr></table>";
	}
	else
	{
		$myMsg = strip_tags($myMsg);
		//$myMsg = str_replace("\n","",$myMsg);
		$myMsg = str_replace("\t","",$myMsg);
		$myMsg = str_replace("&nbsp;","",$myMsg);
		$myMsgTop = "";
		$myMsgBottom = "";
	}

	$headers = "From: $myName < $myFrom >\n";
	$headers .= "X-Sender: < $myFrom >\n";
	$headers .= "X-Mailer: PHP\n"; // mailer
	$headers .= "Return-Path: < $myFrom >\n";  // Return path for errors

	if($MailFormat == 1)
		$headers .= "Content-Type: text/html; charset=iso-8859-1\n"; // Mime type

	if(isset($myCCList) && strlen(trim($myCCList)) > 0)
		$headers .= "cc: $myCCList\n";

	if(isset($myBCCList) && strlen(trim($myBCCList)) > 0)
		$headers .= "bcc: $myBCCList\n";

	if(isset($myReplyTo) && strlen(trim($myReplyTo)) > 0)
		$headers .= "Reply-to: < $myReplyTo >\n";

	$receipient = $myTo;
	$subject = $mySubject;
	$message = $myMsgTop.$myMsg.$myMsgBottom;
	@mail($receipient,$subject,$message,$headers);
}
function setGPC($val,$act)
{
	# use this function to display/insert values coming from Get/Post/Cookie.
	# parameter "act" should have a value "display" if it is being used for displaying value.
	# in case of database update/insert the "act" can be left blank.

	if(!get_magic_quotes_gpc())
		$val = addslashes(trim($val));

	if($act == "display")
		$val = stripslashes($val);

	return $val;
}

$Adminbd = "Dear Admin,\n\n";

$bd = "Name: " . setGPC($_POST['name'],"display") . "\n";
$bd .= "Company Name: " . setGPC($_POST['company_name'],"display") . "\n";
$bd .= "Email Address: " . setGPC($_POST['email_address'],"display") . "  Ext: ".setGPC($TelExt,"display")."\n";
$bd .= "Phone Number: " . setGPC($_POST['phone'],"display") . "\n\n";
$bd .= "Origin of Shipment: " . setGPC(($_POST['origin_city']."&nbsp;|&nbsp;".$_POST['origin_state']."&nbsp;|&nbsp;".$_POST['origin_country']),"display") . "\n\n";
$bd .= "Destination of Shipment: " . setGPC(($_POST['destin_city']."&nbsp;|&nbsp;".$_POST['destin_state']."&nbsp;|&nbsp;".$_POST['destin_country']),"display") . "\n";
$bd .= "Commodity: " . setGPC($_POST['commodity'],"display") . "\n";
$bd .= "Number of Cartons: " . setGPC($_POST['cartons'],"display") . "\n";
$bd .= "Weight in lbs.: " . setGPC($_POST['weight'],"display") . "\n";
$bd .= "Dimensions in Inches: " . setGPC(("length:".$_POST['length']." inches width:".$_POST['width']." inches height:".$_POST['height']." inches"),"display") . "\n";
$bd .= "Method of Transportation : " . $_POST['Ocean'] . "\n";
$bd .= "Brief Description of Cargo: " . setGPC($_POST['description'],"display") . "\n";
$bd .= "Other Comments: " . setGPC($_POST['comments'],"display") . "\n";

$Adminbd = $Adminbd.$bd;
# admin email

$From_Display = "Admin";
$Subject = "Quote Request InterCustom.com ";
$From_Email = "admin@intercustom.com";
$Reply_To =  "gladysp@intercustom.com";

$To = "gladysp@intercustom.com";

SendMail($From_Display, $From_Email, $Reply_To, $To, "", "", $Subject, $Adminbd, 0);
echo "<script language='javascript'>document.location='thanks.html';</script>";
?>
