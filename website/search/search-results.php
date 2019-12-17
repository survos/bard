<?php 
// Connect to the database first, and do the header later, so we can display 
// play information from the database in the header
$includedir = $_SERVER['DOCUMENT_ROOT'] . "/inc/";
include($includedir . "dbconnect.php");

//---------------------------------------------------------------------------------------
// get all the variables we need to build things

// test to see if we're getting data from the links
if ($_GET["link"] == 'con') {
	$keyword[1] = $_GET["keyword1"];
	$keyword[2] = $_GET["keyword2"];
	$keyword[3] = $_GET["keyword3"];
	$keyword[4] = $_GET["keyword4"];
	$keyword[5] = $_GET["keyword5"];
	$keyword[6] = $_GET["keyword6"];

	$works = split(",", $_GET["works"]);
	if ($works[0] == '') { $works[0] = '*'; }

	$characters = $_GET["characters"];
	if ($characters == '') { $characters = '*'; }

	$genres = $_GET["genres"];
	if ($genres == '') { $genres = '*'; }

	$lowdate = $_GET["lowdate"];
	if ($lowdate == '') { $lowdate = '1'; }

	$highdate = $_GET["highdate"];
	if ($highdate == '') { $highdate = '9999'; }

	$sortby = $_GET["sortby"];
	if ($sortby == '') { $sortby = 'WorkName'; }

	$searchtype = $_GET["searchtype"];
	if ($searchtype == '') { $searchtype = 'regexp'; }
}
else {
	// grab all the form data
	// searchtype
	$searchtype = $_REQUEST["searchtype"];
	// keywords, trimming away any excess spaces before or after a word
	for ($i=1; $i<=6; $i++) {
	  $keyword[$i] = trim($_REQUEST["keyword$i"]);
	}
	// ...then the conjunctions
	for ($i=1; $i<=5; $i++) {
	  $conjunction[$i] = $_REQUEST["conjunction$i"];
	}
	$works = $_REQUEST["works"];
	$characters = $_REQUEST["characters"];
	$genres = $_REQUEST["genres"];
	$lowdate = $_REQUEST["lowdate"];
	$highdate = $_REQUEST["highdate"];
	$sortby = $_REQUEST["sortby"];
}
//---------------------------------------------------------------------------------------


//---------------------------------------------------------------------------------------
// Build the initial clauses of the query
$searchquery = "SELECT Paragraphs.*, Characters.CharName, Works.Title, Genres.GenreType
             FROM Paragraphs
			 CROSS JOIN Characters
			   ON Characters.CharID = Paragraphs.CharID 
			 CROSS JOIN Works
			   ON Works.WorkID = Paragraphs.WorkID 
			 CROSS JOIN Genres
			   ON Genres.GenreType = Works.GenreType
			 WHERE ";

//---------------------------------------------------------------------------------------
// loop through the keywords, and add them to the query if they aren't blank
// start by assuming that the keywords fields are empty
$emptykeywords = 1; 
for ($i=1; $i<=6; $i++) {
  if ($keyword[$i]) {
    // keep count of how many keywords we have
	$keywordcount++;
    // prepend the conjunction if this isn't the first keyword
	if ($i == 1) {
	  $tempconj = '';
	}
	else
	{
	  $tempconj = $conjunction[$i-1];
	}
    $searchquery .= "$keywordclause $tempconj (PlainText LIKE '%$keyword[$i]%')"; 
	$emptykeywords = 0; // there are indeed keywords
    }
}
if ($emptykeywords != 1) {
	$searchquery .= " AND"; // set up the WHERE clause for the next field
}

//---------------------------------------------------------------------------------------
// add date range
$searchquery .= " (Works.Date BETWEEN $lowdate AND $highdate)";

//----------------------------------------------------------------------------------------------
// loop through works
// if "ALL" is selected, then don't do anything; otherwise, loop through the result array
if ($works[0] != '*') {
   $searchquery .= " AND (";
   for ($i=0; $i<=(count($works)-1); $i++) {
      $searchquery .= "(Paragraphs.WorkID='$works[$i]') OR ";
   }
   // remove the extraneous trailing " OR"
   $searchquery = substr($searchquery, 0, strlen($searchquery)-4);
   // add the close parenthesis
   $searchquery .= ")";
}

//----------------------------------------------------------------------------------------------
// loop through characters
// if "ALL" is selected, then don't do anything; otherwise, loop through the result array
if ($characters[0] != '*') {
   $searchquery .= " AND (";
   for ($i=0; $i<=(count($characters)-1); $i++) {
      $searchquery .= "(Paragraphs.CharID='$characters[$i]') OR ";
   }
   // remove the extraneous trailing " OR"
   $searchquery = substr($searchquery, 0, strlen($searchquery)-4);
   // add the close parenthesis
   $searchquery .= ")";
}

//----------------------------------------------------------------------------------------------
// loop through genres
// if "ALL" is selected, then don't do anything; otherwise, loop through the result array
if ($genres[0] != '*') {
   $searchquery .= " AND (";
   for ($i=0; $i<=(count($genres)-1); $i++) {
      $searchquery .= "(Works.GenreType='$genres[$i]') OR ";
   }
   // remove the extraneous trailing " OR"
   $searchquery = substr($searchquery, 0, strlen($searchquery)-4);
   // add the close parenthesis
   $searchquery .= ")";
}

//---------------------------------------------------------------------------------------
// sort according to the selected field
switch ($sortby) {
   case 'WorkName':
      $searchquery .= " ORDER BY Works.Title, Characters.CharName";
	  break;
   case 'CharName':
      $searchquery .= " ORDER BY Characters.CharName, Works.Title";
	  break;
}

//---------------------------------------------------------------------------------------
// if this is an exact query, then change the query to reflect that
if ($searchtype == 'regexp') {
	$searchquery = str_replace('LIKE', "REGEXP", $searchquery);
	$searchquery = str_replace('%', "[^a-z\'\-]", $searchquery);
}

//---------------------------------------------------------------------------------------
// get the lines that meet the search criteria
$searchdata = mysqli_query($searchquery);

// NOW we want to includer the header, with no db connection
$title = "Search Results";
$connectrequest = 'no';
include($includedir . "main_header.php");
?> 
<style type="text/css">
<!--
.keyword1 {
	background-color: #FFA6A6;
	border: 1px dashed;
	font-weight: bold;
}
.keyword2 {
	background-color: #C1C1FF;
	border: 1px dashed;
	font-weight: bold;
}
.keyword3 {
	background-color: #FFFF82;
	border: 1px dashed;
	font-weight: bold;
}
.keyword4 {
	background-color: #FF80FF;
	border: 1px dashed;
	font-weight: bold;
}
.keyword5 {
	background-color: #00F000;
	border: 1px dashed;
	font-weight: bold;
}
.keyword6 {
	background-color: #FFB546;
	border: 1px dashed;
	font-weight: bold;
}
-->
</style>
<h1>Search results</h1>
<p align="center"><strong>
<?php
// show the SQL query -- only for troubleshooting, natch
//print "<p>$searchquery</p>"; 

// Display the number of rows, and make the word "result" plural if there is more than one result.

$totalresults = mysqli_num_rows($searchdata);
if ($totalresults!=1) { 
	$s = 's';
}  
print "$totalresults line$s retrieved</strong></p>\n";

if ($keywordcount !=1 ) { 
   $s = 's';
   }
   else
   {
   $s = '';
}  

// start the table
print "<table border='0' cellspacing='0' cellpadding='5' width='700' align='center'><tr><td colspan='6'>";
print "<p class='normalsans'><strong>KEYWORD" . strtoupper($s) . ":</strong> ";

if ($emptykeywords != 1) {
	// loop through the keywords, show them with their respective colors
	for ($i=1; $i<=6; $i++) {
	  if ($keyword[$i]) {
		print "<span class='keyword$i'>" . stripslashes($keyword[$i]) . "</span> ";
	  }
	}
}
else
{
print "none";
}
print "</p></td></tr>";

// only show data if we need to show them
if ($totalresults) {
	print "
	<tr bgcolor='#770A0A'>\n
	   <td align='right'><p style='color:#FEF3DE'><strong>#</strong></p></td>
	   <td align='left'><p style='color:#FEF3DE'><strong>Play</strong></p></td>
	   <td align='left'><p style='color:#FEF3DE'><strong>Character</strong></p></td>
	   <td align='left'><p style='color:#FEF3DE'><strong>Line</strong></p></td>
	   <td align='left'><p style='color:#FEF3DE'><strong>Text</strong></p></td>
	</tr>";

	$charlinenum = 1;
	$currentrowcolor = '#FFFFFF';
	while($currentcharline = mysqli_fetch_array($searchdata)) {
	   $playid = $currentcharline["WorkID"];
	   $playtitle = $currentcharline["Title"];
	   $act = $currentcharline["Section"];
	   $scene = $currentcharline["Chapter"];
	   $sceneid = $currentcharline["ChapterID"];
	   $charid = $currentcharline["CharID"];
	   $charname = $currentcharline["CharName"];
	   $linenum = $currentcharline["ParagraphNum"];
	   $linetext = $currentcharline["PlainText"];
		// convert the paragraph break markers to line breaks
		$linetext = str_replace('[p]', "<br>\n", $linetext);
		
		// loop through the keywords and highlight them within the line text
		for ($i=1; $i<=6; $i++) {
		  if ($keyword[$i]) {
		  	// build the replace values
			$searchstring = "([^a-zA-Z])(" . sql_regcase($keyword[$i]) . ")([^a-zA-Z])";
			$replacestring = "\\1<span class='keyword$i'>\\2</span>\\3";
			//print "searchstring=$searchstring<br>replacestring=$replacestring";
			$linetext = ereg_replace($searchstring, $replacestring, $linetext);
		  }
		}
		
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
	
	   print("<tr bgcolor='$currentrowcolor'>\n");
	   print("   <td align='right' valign='top'><p class='playtextsmall'>$charlinenum</p></td>\n");
	   print("   <td align='left' valign='top'><p class='playtextsmall'><a href='/views/plays/playmenu.php?WorkID=$playid'><strong>$playtitle</strong></a><br>
	             [<a href='/views/plays/scene_view.php?WorkID=$playid&Act=$act&Scene=$scene&ShowLinks=scene'>$fancyact, $scene</a>]</p></td>\n");
//	   print("   <td align='left' valign='top'><p class='playtextsmall'><a href='/views/plays/scene_view.php?WorkID=$playid&Act=$act&Scene=$scene&ShowLinks=scene'>$fancyact,$scene</a></p></td>\n");
	   print("   <td align='left' valign='top'><p class='playtextsmall'><a href='/views/plays/characters/charlines.php?CharID=$charid&WorkID=$playid'><strong>$charname</strong></a></p></td>\n");
	   print("   <td align='left' valign='top'><p class='playtextsmall'><a href='/views/plays/scene_view.php?WorkID=$playid&Act=$act&Scene=$scene&LineHighlight=$linenum#$linenum'>$linenum</a></p></td>\n");
	   print("   <td align='left' valign='top' width='55%'>");
	   //if (strlen($linetext) >=100) {
	   //   $linetext = substr($linetext, 0, 100)."...";
	   //}
	   print("   <p class='playtextsmall'>$linetext</p></td>\n</tr>\n");
	   $charlinenum++;
	   // swap row colors
	    if ($currentrowcolor == '#FFFFFF') {
			$currentrowcolor = '#EEEEEE';
		}
		else 
		{
			$currentrowcolor = '#FFFFFF';
		}
	}
}
	print "</table>";

if ($_GET["link"] == 'con') {
	print "<h2 align='center'><strong><a href='/concordance'><img src='/images/arrow_left.gif' width='21' height='12' border='0' alt=']' align='absmiddle'> 
	       Back to the concordance menu</a></strong></h2>";
}
//include the footer, which closes the table and the document
include($includedir . "main_footer.php");
?>
