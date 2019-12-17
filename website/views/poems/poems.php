<?php 
// page title 
$title = "Shakespeare's poems"; 
// set up include directory
$includedir = $_SERVER['DOCUMENT_ROOT'] . "/inc/";
// include the header file, which starts the main table and the document
include($includedir . "main_header.php");
?> 

      
<table align="center" cellpadding='10'>
  <tr> 
    <td> <h1>Shakespeare's poems</h1>
      <p class='normalsans'>These five poems are all the poetry we have from Shakespeare, <br>
      except the <a href="../sonnets/sonnets.php">Sonnets</a>. Links lead to the plays' full texts.</p></td>
  </tr>
  <tr> 
    <td align='left' valign='top'>
		<p>
      <?php 

// Get poem list
$sqlquery = "SELECT WorkID, Title, Date FROM Works WHERE GenreType='p' ORDER BY Title";
$queryexe = mysqli_query($sqlquery);

while($currentrow = mysqli_fetch_array($queryexe)) {
   $poemid = $currentrow["WorkID"];
   $poemtitle = $currentrow["Title"];
   $poemdate = $currentrow["Date"];
   // start the item
   print("<p class='normalsans'><img src='/images/small_dingbat.gif' alt='+' width='7' height='9' border='0' align='middle'>
		  <a href='poem_view.php?WorkID=$poemid'>
          <strong>$poemtitle</strong></a> <em>($poemdate)</em></p>");
}
?>
	</p>
  </tr>
</table>
<?php
//include the footer, which closes the table and the document
include($includedir . "main_footer.php");
?>
