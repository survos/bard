<?php 
// before calling the header, which play are we looking at?

// this is to catch legacy links
// this is the current version
if ($_GET['WorkID'] != '') {
	$playid = $_GET['WorkID'];
}

// Connect to the database server
$includedir = $_SERVER['DOCUMENT_ROOT'] . "/inc/";
include($includedir . "dbconnect.php");

// Get play info
$sqlquery = "SELECT Works.WorkID, Works.Title, Works.Date, Works.GenreType, Chapters.ChapterID 
			 FROM Works, Chapters 
			 WHERE Chapters.WorkID='$playid' 
			 	AND Works.WorkID='$playid' 
			 ORDER BY ChapterID;";

$queryexe = mysqli_query($dbcnx, $sqlquery);
$currentrow = mysqli_fetch_array($queryexe);

$playtitle = $currentrow["Title"];
$playdate = $currentrow["Date"];
$playfirstscene = $currentrow["ChapterID"];

// now do the header 
// page title 
$title = "$playtitle"; 
// include the header file, which starts the main table and the document
// don't connect to the database again
$connectrequest = 'no';
include($includedir . "main_header.php");

print("<h2 class='playtitle'>$playtitle <em>($playdate)</em></h2>\n
<img src='/images/fancy_long_line.gif' width='760' height='8' border='0' align='---'>\n");

print("<table width='700' cellspacing='0' cellpadding='0' align='center'>\n");
print("<tr><td align='left' valign='top'>\n");

// Loop through acts
$sqlquery = "SELECT DISTINCT Section
				 FROM Chapters 
				 WHERE WorkID='$playid' 
				 ORDER BY Section";
$actquery = mysqli_query($dbcnx, $sqlquery);

print("<h2 style='font-size:17px;'><strong>Scenes<br><span style='font-size:10px'>(" . mysqli_numrows($queryexe) . " total)</span></strong></h2>\n");

while($currentrow = mysqli_fetch_array($actquery)) {
	$act = $currentrow["Section"];

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

	// Loop through scenes
	$sqlquery = "SELECT Chapter, Description, ChapterID
					FROM Chapters 
					WHERE WorkID='$playid' 
						AND Section=$act 
					ORDER BY Chapter";
	$scenequery = mysqli_query($sqlquery);
	
	// get the first scene, so we know where to start rendering the entire act
	$currentscene = mysqli_fetch_array($scenequery);
	$actfirstscene = $currentscene["ChapterID"];
	$scene = $currentscene["Chapter"];
	$setting = $currentscene["Description"];
	$sceneid = $actfirstscene;
	
	//put the scene in the variable that's going to be displayed as HTML
	$actdisplay = "<li class='scenelist'><a href='scene_view.php?WorkID=$playid&SceneStart=$sceneid&SceneEnd=$sceneid&ShowLinks=scene'><strong>Scene $scene.</strong></a> $setting</li>\n";
	
	while($currentscene = mysqli_fetch_array($scenequery)) {		
		$scene = $currentscene["Chapter"];
		$setting = $currentscene["Description"];
		$sceneid = $currentscene["ChapterID"];
		$actdisplay .= "<li class='scenelist'><a href='scene_view.php?WorkID=$playid&SceneStart=$sceneid&SceneEnd=$sceneid&ShowLinks=scene'><strong>Scene $scene.</strong></a> $setting</li>\n";
	}
  
	// grab the last sceneid to make it the last scene of the act
	$actlastscene = $sceneid;

	print("<h2><a href='scene_view.php?WorkID=$playid&SceneStart=$actfirstscene&SceneEnd=$actlastscene&ShowLinks=act'><strong>$fancyact</strong></a></h2><ul>\n");
	print("$actdisplay</ul>\n");
}

// grab the last scene in the entire play
$playlastscene = $sceneid;

print("<h2><a href='scene_view.php?WorkID=$playid&SceneStart=$playfirstscene&SceneEnd=$playlastscene&ShowLinks=entire'><strong>Entire Text</strong></a></h2>");

print("</td><td width='30'>&nbsp;</td><td align='left' valign='top' width='300'>\n");

//show each character in the play
$sqlquery = "SELECT CharID, CharName, Description
				 FROM Characters
				 WHERE Works LIKE '%$playid%' 
				 ORDER BY CharName";
$queryexe = mysqli_query($sqlquery);

//show each character in the play
print("<h2 style='font-size:17px;'><strong>Characters<br><span style='font-size:10px'>(" . mysqli_numrows($queryexe) . " total)</span></strong></h2>\n<ul>");

while($currentrow = mysqli_fetch_array($queryexe)) {
   $charid = $currentrow["CharID"];
   $charname = $currentrow["CharName"];
   $chardesc = $currentrow["Description"];
   print("<li class='charnames'><a href='characters/charlines.php?CharID=$charid&WorkID=$playid'><strong>$charname</strong></a>");
   if ($chardesc != '') { 
      print(", $chardesc"); 
	}
	print("</li>\n");
}
print("</ul>");

?>
<p>&nbsp;</p>



      </td></tr></table>

<?php
//include the footer, which closes the table and the document
include($includedir . "main_footer.php");
?>
