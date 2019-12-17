<?php 

// connect to the db unless the connect variable is set to 'no'
if ($connectrequest != 'no') {
	include("dbconnect.php");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title> <?php print $title ?> :|: Open Source Shakespeare &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="/styles/oss-main.css" rel="stylesheet" type="text/css">
<?php 
// insert Blogger script in the top if this is the news page
if ($blogpage = TRUE) {
	print "<script type='text/javascript' src='http://www.haloscan.com/load.php?user=leobinus'></script>";
}
?>
</head>

<body bgcolor="#BF3000" background="/images/backtile.gif">
<table width="760" border="1" cellpadding="0" cellspacing="0" bordercolorlight="#000000" bordercolordark="#000000" bgcolor="#FEF3DE">
  <tr> 
    <td> 
	  <div align="center"><p>
      <a href="/"><img src="/images/oss-smalllogo.gif" alt="Open Source Shakespeare" width="760" height="43" border="0"></a>
<?php 
if ($nonav == FALSE) {
	include("navbar.htm");
}
?>
	  </p></div>
