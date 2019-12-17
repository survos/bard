<?php 
// page title 
$title = "Complete list of Shakespeare's plays, by genre"; 
// set up include directory
$includedir = $_SERVER['DOCUMENT_ROOT'] . "/inc/";
// include the header file, which starts the main table and the document
include($includedir . "main_header.php");
?> 

      <table align="center" cellpadding='10'>
        <tr> 
    <td colspan='3'> 
 		<h1>Shakespeare's plays,<br>listed by genre</h1>
    	
      <h2 align="center">List plays <a href="plays_alpha.php">alphabetically</a> 
        <img src="../../images/small_dingbat.gif" alt="+" width="7" height="9" border="0" align="middle"> 
        <a href="plays_date.php">by date</a> <img src="../../images/small_dingbat.gif" alt="+" width="7" height="9" border="0" align="middle"> 
        <a href="plays_numlines.php">by total lines</a></h2> 
      	<p align="center" class='normalsans'>Links lead to the play's text and the 
        <em>dramatis personae</em>.</p>
	  </td> 
  </tr> 
   <tr>
      <td align='left' valign='top' width='40%'><h3><strong>COMEDIES</strong></h3>
      
<?php 

/*------------------------------------------------------------------------------------------ 
Comedies
------------------------------------------------------------------------------------------*/

// Get play list
$sqlquery = "SELECT WorkID, Title, Date FROM Works WHERE GenreType='c' ORDER BY Title";
$queryexe = mysqli_query($sqlquery);

while($currentrow = mysqli_fetch_array($queryexe)) {
   $playid = $currentrow["WorkID"];
   $playtitle = $currentrow["Title"];
   $playdate = $currentrow["Date"];
   $playactive = 1;
   // start the item
   print("   <span class='normalsans'>");
   // if the play is active, insert a link to it
   if ($playactive) {
      print("<a href='playmenu.php?WorkID=$playid'>");
   }
   // show the title regardless
   print("<strong>$playtitle</strong><br>");
   // end the the link if necessary
   if ($playactive) {
      print("</a>");
   }
}
?>      </td><?php

/*------------------------------------------------------------------------------------------ 
Histories
------------------------------------------------------------------------------------------*/
?>
      <td align='top' valign='top' width='30%'><h3><strong>HISTORIES</strong></h3><p>

<?php

// Get play list
$sqlquery = "SELECT WorkID, Title, Date FROM Works WHERE GenreType='h' ORDER BY Title";
$queryexe = mysqli_query($sqlquery);

while($currentrow = mysqli_fetch_array($queryexe)) {
   $playid = $currentrow["WorkID"];
   $playtitle = $currentrow["Title"];
   $playdate = $currentrow["Date"];
   $playactive = 1;
   // start the item
   print("   <span class='normalsans'>");
   // if the play is active, insert a link to it
   if ($playactive) {
      print("<a href='playmenu.php?WorkID=$playid'>");
   }
   // show the title regardless
   print("<strong>$playtitle</strong><br>");
   // end the the link if necessary
   if ($playactive) {
      print("</a>");
   }
   
}

?>
      </p></td><?php

/*------------------------------------------------------------------------------------------ 
Tragedies
------------------------------------------------------------------------------------------*/
?>      <td align='top' valign='top' width='30%'><h3><strong>TRAGEDIES</strong></h3><p>
<?php

// Get play list
$sqlquery = "SELECT WorkID, Title, Date FROM Works WHERE GenreType='t' ORDER BY Title";
$queryexe = mysqli_query($sqlquery);

while($currentrow = mysqli_fetch_array($queryexe)) {
   $playid = $currentrow["WorkID"];
   $playtitle = $currentrow["Title"];
   $playdate = $currentrow["Date"];
   $playactive = 1;
   // start the item
   print("   <span class='normalsans'>");
   // if the play is active, insert a link to it
   if ($playactive) {
      print("<a href='playmenu.php?WorkID=$playid'>");
   }
   // show the title regardless
   print("<strong>$playtitle</strong><br>");
   // end the the link if necessary
   if ($playactive) {
      print("</a>");
   }
}
?>

</p></td></tr></table>
<?php
//include the footer, which closes the table and the document
include($includedir . "main_footer.php");
?>
