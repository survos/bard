<?php 
// This include file renders one or more sonnets. 

$sqlquery = "SELECT PlainText, Chapter
			 FROM Paragraphs 
			 WHERE (WorkID='sonnets')
			   AND (Chapter >= $firstsonnet)
			   AND (Chapter <= $lastsonnet)
			 ORDER BY Chapter";
$sonnetquery = mysqli_query($sqlquery);

// loop through the sonnet(s) and display them
while ($sonnetinfo = mysqli_fetch_array($sonnetquery)) {
	$sonnettext = $sonnetinfo["PlainText"];
	$currentsonnet = $sonnetinfo["Chapter"];

	// replace paragraph breaks with HTML breaks
	$sonnettext = str_replace("[p]", "<br>", $sonnettext);

	// replace double spaces with HTML non-breaking spaces, 
	// so there will be a neat indent on the last two lines
	$sonnettext = str_replace("  ", "&nbsp;&nbsp;&nbsp;&nbsp;", $sonnettext);
	
	// see if we're using smalltext
	if ($smalltext == TRUE) {
		$sonnetstyle = 'playtextsmall';
	}
	else {
		$sonnetstyle = 'normalsans';
	}
	
	print "<div align='center'><h2>SONNET " . IntToRoman($currentsonnet) . "<br></h2></div>
	<p class='$sonnetstyle'>$sonnettext<br>
	<div align='center'><img src='/images/sonnet_separator.gif' width='25' height='17' border='0' alt='O'></div>
	</p>";
}
?> 

