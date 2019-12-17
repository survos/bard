<?php 
// don't call the header yet -- figure out the character name
// set up include directory
$includedir = $_SERVER['DOCUMENT_ROOT'] . "/inc/";
// call the db
include($includedir . "dbconnect.php");

// whose lines do we want? 
$charid = $_GET['CharID'];
$playid = $_GET['WorkID'];

// get the character's name
$sqlquery = "SELECT CharName
			   FROM Characters
			   WHERE CharID='$charid'";
$queryexe = mysqli_query($sqlquery);
$charinfo = mysqli_fetch_array($queryexe);
$charname = $charinfo["CharName"];

// get the play name
$sqlquery = "SELECT Title
			   FROM Works
			   WHERE WorkID='$playid'";
$queryexe = mysqli_query($sqlquery);
$playinfo = mysqli_fetch_array($queryexe);
$playtitle = $playinfo["Title"];

// page title 
$title = "Character lines for $charname in \"$playtitle\""; 
// include the header file, which starts the main table and the document
$connectrequest = 'no';
include($includedir . "main_header.php");

//get the lines
$sqlquery = "SELECT ParagraphID, ParagraphNum, PlainText, Section, Chapter
             FROM Paragraphs
             WHERE (CharID='$charid') 
				 	AND (WorkID = '$playid')";
$queryexe = mysqli_query($sqlquery);

?>


<table border='0' cellspacing='5' width='700' align='center'>
	<tr>
		<td colspan='4'>
		<h2 align='center'><strong>Lines for <?php print("$charname in \"$playtitle\"")?></strong></h2>
		</td>
	</tr>
	<tr>
	   <td align='left' valign='bottom'>&nbsp;</td>
	   <td align='right' valign='bottom'><p><strong>Line</strong></p></td>
	   <td align='center' valign='bottom'><p><strong>Act,<br>Scene</strong></p></td>
	   <td align='left' valign='bottom'><p><strong>Text</strong></p></td>
	</tr>
<?php 
//show each character as a different row in the table
$charlinenum = 1;
while($currentcharline = mysqli_fetch_array($queryexe)) {
   $linenum = $currentcharline["ParagraphNum"];
   $linetext = $currentcharline["PlainText"];
   $act = $currentcharline["Section"];
   $scene = $currentcharline["Chapter"];
	// convert the paragraph break markers to line breaks
	$linetext = str_replace('[p]', "<br>\n", $linetext);
	
	// convert the Acts to Roman numerals
    switch($act) { 
        case 0: $fancyact = "Prologue"; 
		        break;
        case 1: $fancyact = "I"; 
		        break;
        case 2: $fancyact = "II"; 
		        break;
        case 3: $fancyact = "III"; 
		        break;
        case 4: $fancyact = "IV"; 
		        break;
        case 5: $fancyact = "V"; 
		        break;
        case 6: $fancyact = "VI"; 
		        break;
        case 7: $fancyact = "VII"; 
		        break;
        case 8: $fancyact = "VIII"; 
		        break;
        case 9: $fancyact = "IX"; 
    } 

   print("<tr>\n");
   print("   <td align='left' valign='top'><p>$charlinenum</p></td>\n");
   print("   <td align='right' valign='top'><p><a href='../scene_view.php?WorkID=$playid&Act=$act&Scene=$scene&LineHighlight=$linenum#$linenum'>$linenum</a></p></td>\n");
   print("   <td align='center' valign='top'><p><a href='../scene_view.php?WorkID=$playid&Act=$act&Scene=$scene'>$fancyact,$scene</a></p></td>\n");
   print("   <td align='left' valign='top'>");
   if (strlen($linetext) >=100) {
      $linetext = substr($linetext, 0, 100)."...";
   }
   print("   <p class='normalsans'>$linetext</p></td>\n</tr>\n");
$charlinenum++;
}
?>   
</table>

<?php
print "<h2 align='center'><a href='../playmenu.php?WorkID=$playid'>Return to the \"$playtitle\" menu</a></h2>";

//include the footer, which closes the table and the document
include($includedir . "main_footer.php");
?>
