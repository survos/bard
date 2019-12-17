<?php 
// Connect to the database server
$includedir = $_SERVER['DOCUMENT_ROOT'] . "/inc/";
include($includedir . "dbconnect.php");

/* 

pseudo code for determining previous, current, and next scene info

1. query for sceneid-1 to sceneid+1
2. see if the first row has playid = playid in URL variables
      Y: then populate the Act, Scene, ChapterID variables
	  N: this is the first scene in the play. don't display label
3. get the variables from the second row
4. check the third row to see that it's got playid = current playid
      Y: populate the Act, Scene, ChapterID variables
	  N: this is the last scene of the play, so don't display label 

 */


// what is the range of scenes are we looking at?

// this is to catch legacy links
if ($_GET['PlayID'] != '') {
	$playid = $_GET['PlayID'];
}

// this is the current version
if ($_GET['WorkID'] != '') {
	$playid = $_GET['WorkID'];
}

$scenestart = $_GET['SceneStart'];
$sceneend = $_GET['SceneEnd'];
// ...or if we're not looking at a range of scenes, then which one? 
$act = $_GET['Act'];
$scene = $_GET['Scene'];
// show where we are in the play, with links to the other scenes? 
$showlinks = $_GET['ShowLinks'];
// are we highlighting a character's line? 
$LineHighlight = $_GET['LineHighlight'];

// If this is a single scene, as indicated in the Act/Scene URL variables, then get the ChapterID
if ($act) {
	$onescenequery = "SELECT ChapterID 
					  FROM Chapters
					  WHERE Section=$act
						AND Chapter=$scene
						AND WorkID='$playid'";
	$onescene = mysqli_query($onescenequery); 
	$sceneinfo = mysqli_fetch_array($onescene);
	$scenestart = $sceneinfo["ChapterID"];
	$sceneend = $sceneinfo["ChapterID"];
}

// Get play info by selecting all scenes
$sqlquery = "SELECT Works.Title, Works.Date, Works.GenreType, Chapters.ChapterID, 
                    Chapters.Section, Chapters.Chapter
			 FROM Works, Chapters 
			 WHERE Works.WorkID='$playid' 
			   AND Chapters.WorkID='$playid' 
			 ORDER BY Chapters.ChapterID;";
$queryexe = mysqli_query($sqlquery);

// get most of the play info from first row, and don't loop through the rest of the query yet
$currentrow = mysqli_fetch_array($queryexe);
$playtitle = $currentrow["Title"];
$playdate = $currentrow["Date"];
$playgenre = $currentrow["GenreType"];
$playfirstact = $currentrow["Section"];
$playfirstscene = $currentrow["Chapter"];
$playfirstsceneid = $currentrow["ChapterID"];

// begin to build a list of scenes
$scenelist = 			  "<p>Scene List<br>";
$scenelist = $scenelist . "Act $playfirstact<br>\n&nbsp;&nbsp;Scene " . $currentrow["Chapter"] . "<br>\n";

// loop through the rest of the scenes
while ($currentrow = mysqli_fetch_array($queryexe)) {
	$currentact = $currentrow["Section"];
	$currentscene = $currentrow["Chapter"];
	$currentsceneid = $currentrow["ChapterID"];
	if ($currentscene==1) {
		 $scenelist = $scenelist . "Act $currentact<br>\n&nbsp;&nbsp;Scene $currentscene<br>\n";
	}
	else {
	$scenelist = $scenelist . 	"&nbsp;&nbsp;Scene " . $currentscene . "<br>\n";
	}
}
$scenelist = $scenelist . "</p>";

// get the last scene info
$playlastact = $currentact;
$playlastscene = $currentscene;
$playlastsceneid = $currentsceneid;

// NOW insert the header, because we've got the play name
// figure out the title
   $title = "\"$playtitle,\" $scenestart";
if ($sceneend > $scenestart) {
   $title = $title . " through $sceneend";
}
// include the header file, which starts the main table and the document
$connectrequest = 'no';
include($includedir . "main_header.php");

//print "playfirstact: $playfirstact<br>";
//print "playlastact: $playlastact";

$playnav = 			  " 	<table width='760' border='0' align='center' cellspacing='10' class='navlinks'>\n";
$playnav .= "        <tr>\n";
$playnav .= "          <td width='70' align='left'>&nbsp;</td>\n";

           switch ($showlinks) {
		     case 'scene':
			   $playnav .= "<td align='left' width='200'>";
			   // only display the previous scene if this isn't the first scene in the play
			   if ($scenestart != $playfirstsceneid) 
			   {
			   $previousscene = $scenestart - 1; 
			   $playnav .= "<span class='normalsans'><a href='/views/plays/scene_view.php?WorkID=$playid&SceneStart=$previousscene&SceneEnd=$previousscene&ShowLinks=$showlinks'>
			   <img src='/images/arrow_left.gif' width='21' height='12' border='0' alt=']' align='absmiddle'> 
			   Previous scene</a></span>";
			   } else {
			   $playnav .= "&nbsp;"; 
			   }
			   $playnav .= "</td>\n";
			   $playnav .= "<td align='center' width='200'><span class='normalsans'><a href='/views/plays/playmenu.php?WorkID=$playid'><img src='/images/arrow_up.gif' width='12' height='21' border='0' alt=']' align='absmiddle'> Play menu</a></span></td>\n";
			   $playnav .= "<td align='right' width='200'>";
			   // only display the next scene if this isn't the last scene in the play
   			   if ($sceneend != $playlastsceneid) 
			   {
			   $nextscene = $sceneend + 1; 
			   $playnav .= "<span class='normalsans'><a href='/views/plays/scene_view.php?WorkID=$playid&SceneStart=$nextscene&SceneEnd=$nextscene&ShowLinks=$showlinks'>Next scene <img src='/images/arrow_right.gif' width='21' height='12' border='0' alt=']' align='absmiddle'></a></span>";
			   } else {
			   $playnav .= "<td>&nbsp;</td>\n"; 
			   }

			 break;
		     case 'act':
			   $playnav .= "<td align='left' width='200'><span class='normalsans'><a href='/views/plays/scene_view.php?WorkID=$playid'><img src='/images/arrow_left.gif' width='21' height='12' border='0' alt=']' align='absmiddle'> Previous Act</a></span></td>\n";
			   $playnav .= "<td align='center' width='200'><span class='normalsans'><a href='/views/plays/playmenu.php?WorkID=$playid'><img src='/images/arrow_up.gif' width='12' height='21' border='0' alt=']' align='absmiddle'> Play menu</a></span></td>\n";
			   $playnav .= "<td align='right' width='200'><span class='normalsans'><a href='/views/plays/scene_view.php?WorkID=$playid'>Next Act <img src='/images/arrow_right.gif' width='21' height='12' border='0' alt=']' align='absmiddle'></a></span></td>\n";
			 break;
		     case 'entire':
			   $playnav .= "<td>&nbsp;</td>\n";
			   $playnav .= "<td align='center' width='200'><a href='/views/plays/playmenu.php?WorkID=$playid'>^ Play menu</a></td>\n";
			   $playnav .= "<td>&nbsp;</td>\n";
			 break;
			}
$playnav .= "          <td width='70' align='left'>&nbsp;</td>\n";
$playnav .= "        </tr>\n";
$playnav .= " 	</table>\n";

print $playnav;
?>

<h2 class='playtitle'><?php echo $playtitle ?></h2>

<?php 
//loop through all of the scenes requested
for ($i=$scenestart; $i<=$sceneend; $i++) {
	$sceneid = $i;
	global $sceneid; 	//must be global so we can pass it to the include file
	include("scene_render.php"); 
}

// show play nav at the bottom
print $playnav;

?>

<?php
//include the footer, which closes the table and the document
include($includedir . "main_footer.php");
?>
