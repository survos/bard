<?php 
// page title 
$title = "Complete list of Shakespeare's plays, by date"; 
// set up include directory
$includedir = $_SERVER['DOCUMENT_ROOT'] . "/inc/";
// include the header file, which starts the main table and the document
include($includedir . "main_header.php");
?> 

      <table align="center" cellpadding='10'>
        <tr> 
    <td colspan='3'> 
 	  <h1>Shakespeare's plays,<br>listed by presumed date of composition</h1>
      <h2 align="center">List plays <a href="plays.php">by genre</a> <img src="../../images/small_dingbat.gif" alt="+" width="7" height="9" border="0" align="middle"> 
        <a href="plays_alpha.php">alphabetically</a>
		<img src="../../images/small_dingbat.gif" alt="+" width="7" height="9" border="0" align="middle"> 
         <a href="plays_numlines.php">by total lines</a></h2>
      <p align="center" class='normalsans'>Links lead to the play's text<br>
        and the <em>dramatis personae</em>.</p>
    </td> 
  </tr> 
   <tr>
      <td align='left' valign='top'>
      <ul>
<?php 

/*------------------------------------------------------------------------------------------ 
Get all plays
------------------------------------------------------------------------------------------*/

// Get play list
$sqlquery = "SELECT WorkID, Title, Date 
             FROM Works 
			 WHERE GenreType='h' OR GenreType='c' OR GenreType='t' 
			 ORDER BY Date";
$queryexe = mysqli_query($sqlquery);

// begin the play list table
print("<table cellpadding='0' cellspacing='0' align='center'>");

while($currentrow = mysqli_fetch_array($queryexe)) {
   $playid = $currentrow["WorkID"];
   $playtitle = $currentrow["Title"];
   $playdate = $currentrow["Date"];
   $playactive = 1;
   print("<tr><td>");

   // show the play's date if it's different than the last date
   if ($playdate > $previousdate) {
      print("<span class='datehighlight'><strong>$playdate</strong></span>");
   } 
   else {
      print("&nbsp;");
   }
   print("</td><td>&nbsp;&nbsp;&nbsp;</td><td>");

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
   print("</td></tr>\n");

   // set previousdate to the current date
   $previousdate = $playdate;
}
?>
</table>

<p align="center" class='normalsans' style='font-size:14px; font-weight=bold;'>List 
  plays <a href="plays.php">by genre</a> <img src="../../images/small_dingbat.gif" alt="+" width="7" height="9" border="0" align="middle"> 
  <a href="plays_alpha.php">alphabetically</a> <img src="../../images/small_dingbat.gif" alt="+" width="7" height="9" border="0" align="middle"> 
  <a href="plays_numlines.php">by total lines</a></p>

</td></tr></table>

<?php
//include the footer, which closes the table and the document
include($includedir . "main_footer.php");
?>