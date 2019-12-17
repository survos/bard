<?php 
// page title 
$title = "Complete list of Shakespeare's plays, by number of lines"; 
// set up include directory
$includedir = $_SERVER['DOCUMENT_ROOT'] . "/inc/";
// include the header file, which starts the main table and the document
include($includedir . "main_header.php");

// get total lines of all plays put together
$sqlquery = "SELECT Count(*) AS TotalLineCount FROM Paragraphs
			 CROSS JOIN Works ON Works.WorkID=Paragraphs.WorkID 
			 WHERE Works.GenreType='h' OR Works.GenreType='c' OR Works.GenreType='t'";
$queryexe = mysqli_query($sqlquery);
$currentrow = mysqli_fetch_array($queryexe);
$totallinecount = $currentrow['TotalLineCount'];

// get total number of plays 
$sqlquery = "SELECT Count(*) AS TotalPlays FROM Works 
			 WHERE GenreType='h' OR GenreType='c' OR GenreType='t'";
$queryexe = mysqli_query($sqlquery);
$currentrow = mysqli_fetch_array($queryexe);
$totalplays = $currentrow['TotalPlays'];

// calculate average number of lines per play
$lineaverage = $totallinecount / $totalplays; 

// format the numbers for human consumption
$totallinecount = number_format($totallinecount);
$totalplays = number_format($totalplays);
$lineaverage = round($lineaverage);
?> 

      <table align="center" cellpadding='10'>
        <tr> 
    <td colspan='3'> 
 	  <h1>Shakespeare's plays,<br>
        listed by number of lines</h1>
      <h2 align="center">List plays <a href="plays.php">by genre</a> <img src="../../images/small_dingbat.gif" alt="+" width="7" height="9" border="0" align="middle"> 
        <a href="plays_alpha.php">alphabetically</a> <img src="../../images/small_dingbat.gif" alt="+" width="7" height="9" border="0" align="middle"> 
        <a href="plays_date.php">by date</a></h2>
      <p class='normalsans'><strong>Total lines in all plays:</strong> 
        <?=$totallinecount?>
        <br>
        <strong>Total plays:</strong> 
        <?=$totalplays?>
        <br>
        <strong>Average per play:</strong> 
        <?=$lineaverage?>
      </p>
      <p class='normalsans'> <strong>Note:<br>
        </strong>A &quot;line&quot; is either words spoken by a character, or 
        <br>
        a stage direction &mdash; anything from a one-word shout <br>
        to a full soliloquy.</p>
      </td> 
  </tr> 
<?php 

/*------------------------------------------------------------------------------------------ 
Get all plays, sort by the number of lines in the play, reverse order
------------------------------------------------------------------------------------------*/

// Get play list
$sqlquery = "SELECT Paragraphs.WorkID, Works.Title, Genres.GenreName, Count(*) AS LineCount 
FROM Paragraphs
CROSS JOIN Works
  ON Works.WorkID = Paragraphs.WorkID 
CROSS JOIN Genres
  ON Genres.GenreType = Works.GenreType 
WHERE Works.GenreType='h' OR Works.GenreType='c' OR Works.GenreType='t'
GROUP BY WorkID
ORDER BY LineCount DESC";

$queryexe = mysqli_query($sqlquery);

// begin the play list table
print("<table cellpadding='0' cellspacing='0' align='center'>");

// header row
print("
   <tr>
      <td align='right' valign='bottom'>
	     <p><strong>&nbsp;&nbsp;Lines</strong>
      </td>
      <td>&nbsp;</td>
      <td align='left' valign='bottom'>
	     <p><strong>Play</strong>
      </td>
      <td>&nbsp;</td>
      <td align='left' valign='bottom'>
	     <p><strong>Genre</strong>
      </td>
   </tr>");
   
print("<tr><td colspan='5'><hr size='1' noshade></td></tr>");

while($currentrow = mysqli_fetch_array($queryexe)) {
   $playid = $currentrow["WorkID"];
   $playtitle = $currentrow["Title"];
   $playgenre = $currentrow["GenreName"];
   $playlinecount = number_format($currentrow["LineCount"]);
   $playactive = 1;

   // start the row
   print("<tr>");
 
   // Line count
   print ("  <td align='right'><span class='normalsans'>$playlinecount</span></td>\n");
   
   // spacer cell
   print("   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>");

   // Play name
   print("   <td>");

   // if the play is active, insert a link to it
   if ($playactive) {
      print("<a href='playmenu.php?WorkID=$playid'>");
   }

   // show the title regardless
   print("<span class='normalsans'><strong>$playtitle</strong></span>");

   // end the the link if necessary
   if ($playactive) {
      print("</a>");
   }
   print("</td>");
   
   // spacer cell
   print("   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>");

   // Genre 
   print("<td><span class='normalsans'>$playgenre</span></td>");

   // end the row
   print("</tr>\n");

   // set previousdate to the current date
   $previousdate = $playdate;
}
?>
</table>

<h2 align="center" class='normalsans' style='font-size:14px; font-weight=bold;'>List 
  plays <a href="plays.php">by genre</a> <img src="../../images/small_dingbat.gif" alt="+" width="7" height="9" border="0" align="middle"> 
  <a href="plays_alpha.php">alphabetically</a> <img src="../../images/small_dingbat.gif" alt="+" width="7" height="9" border="0" align="middle"> 
  <a href="plays_date.php">by date</a></h2>


<?php
//include the footer, which closes the table and the document
include($includedir . "main_footer.php");
?>