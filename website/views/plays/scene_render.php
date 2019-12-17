<?php 
/* 
This include file renders an entire scene. The only thing necessary is to feed it 
the $sceneid variable; this file takes care of everything else. 
 */

// Get scene info
$sqlquery = "SELECT Section, Chapter, Description
			 FROM Chapters 
			 WHERE (ChapterID=$sceneid)";
$scenequery = mysqli_query($sqlquery);
$sceneinfo = mysqli_fetch_array($scenequery);
$act = $sceneinfo["Section"];
$scene = $sceneinfo["Chapter"];
$setting = $sceneinfo["Description"];

// convert the Acts to Roman numerals
switch($act) { 
	case 0: $fancyact = "Prologue"; 
			break;
	case 1: $fancyact = "Act I"; 
			break;
	case 2: $fancyact = "Act II"; 
			break;
	case 3: $fancyact = "Act III"; 
			break;
	case 4: $fancyact = "Act IV"; 
			break;
	case 5: $fancyact = "Act V"; 
			break;
	case 6: $fancyact = "Act VI"; 
			break;
	case 7: $fancyact = "Act VII"; 
			break;
	case 8: $fancyact = "Act VIII"; 
			break;
	case 9: $fancyact = "Act IX"; 
}
?>

<img src='/images/fancy_long_line.gif' width='760' height='8' border='0' align='---'>
<h3 class='playsubhead'><?php echo $fancyact ?>, Scene <?php echo $scene ?></h3>
<img src='/images/long_line.gif' width='760' height='2' border='0' align='---'>

<table width='100%' cellspacing='30'>
	<tr>
		<td>
			<p class='stagedir'>SETTING: <?php echo $setting ?></p>
<?php
// loop through the lines of the scene
$sqlquery = "SELECT ParagraphID, CharID, PlainText, ParagraphType, ParagraphNum
			 FROM Paragraphs
			 WHERE (Section=$act) AND (Chapter=$scene) AND (WorkID='$playid')
			 ORDER BY ParagraphID";
$linequery = mysqli_query($sqlquery);

while($currentline = mysqli_fetch_array($linequery)) {
	$lineid = $currentline["ParagraphID"];
	$charid = $currentline["CharID"];
	$linetext = $currentline["PlainText"];
	$linetype = $currentline["ParagraphType"];
	$linenum = $currentline["ParagraphNum"];
	
	$sqlquery = "SELECT CharName
				 	 FROM Characters
				 	 WHERE CharID='$charid'";
	$charquery = mysqli_query($sqlquery);
	$charget = mysqli_fetch_array($charquery);
	$charname = $charget["CharName"];
	
	// print character name if this isn't a stage direction
	if ($charid != 'xxx') { 
		// convert the paragraph break markers to line breaks
		$linetext = str_replace('[p]', "<br>", $linetext);
		
		print("<ul><li class='playtext'><strong>");
		if ($LineHighlight == $linenum) { print("<span style='background-color: #EEAAAA; border: thin solid #000000;'>"); }
		print("$charname");
		if ($LineHighlight == $linenum) { print("</span>"); }
		print(". </strong>"); 
	} 
	else {
		print("</li></ul><p class='stagedir'>");
	}
	print("<a name='$linenum'></a>$linetext");
	if ($linetype == 's') { 
		print("</p>");
	}
	else {
		print("</li></ul>\n\n");
	}
}
?>
</td></tr></table>
