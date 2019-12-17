<?php 
// Connect to the database server
$includedir = $_SERVER['DOCUMENT_ROOT'] . "/inc/";
include($includedir . "dbconnect.php");

// Get poem info
$poemid = $_GET['WorkID'];

$chapterquery = "SELECT Works.LongTitle, Works.Date, Chapters.Chapter, Chapters.Description, Chapters.ChapterID 
			 FROM Works 
			 CROSS JOIN Chapters 
			   ON Works.WorkID=Chapters.WorkID 
			 WHERE Chapters.WorkID='$poemid'
			 ORDER BY Chapters.ChapterID";
$chapterdata = mysqli_query($chapterquery);

$currentrow = mysqli_fetch_array($chapterdata);
$poemtitle = $currentrow["LongTitle"];
$poemdate = $currentrow["Date"];
// reset the counter back to the first row, so looping through the chapters will start with the first one
mysqli_data_seek($chapterdata, 0);

// NOW insert the header, because we've got the play name
$title = $poemtitle;
// include the header file, which starts the main table and the document
$connectrequest = 'no';
include($includedir . "main_header.php");

?> 
<h1><?=$poemtitle?><br><span class="normalsans"><?=$poemdate?></span></h1>
<table align="center" cellpadding='10'>
  <tr>
    <td align='left' valign='top' >
	  <?php 
	  // display the poem according to which poem it is
	  // loop through the chapters 
	  
	  while ($currentchapterdata = mysqli_fetch_array($chapterdata)) {
	      $currentchapter = $currentchapterdata["Chapter"];
	      $description = $currentchapterdata["Description"];
		  $sqlquery = "SELECT PlainText, Chapter
					   FROM Paragraphs 
					   WHERE (WorkID='$poemid')
						 AND (Chapter=$currentchapter)";
		  $poemquery = mysqli_query($sqlquery);
		  
		  // show chapter title if it is Rape of Lucrece, Passionate Pilgrim, or Venus and Adonis
		  if ($poemid == 'rapelucrece' or $poemid == 'venusadonis' or $poemid == 'passionatepilgrim') {
		  	if (substr($description, 0, 3) != '---') { print "<h2><strong>$description</strong></h2>"; }
		  }
			
		  // loop through the poem's stanzas
		  while ($poeminfo = mysqli_fetch_array($poemquery)) {
			$poemtext = $poeminfo["PlainText"];
		
			// replace paragraph breaks with HTML breaks
			$poemtext = str_replace("[p]", "<br>", $poemtext);
		
			// display the poem's stanze
			print "<p class='normalsans'>$poemtext</p>";
		  }
		  print "<div align='center'><img src='../../images/fancy_circle_separator.gif' width='77' height='14' alt='---'></div>";
		  $currentchapter++;
	  }
	  ?>
		
      <div align='center'><p><strong><a href="poems.php">Back to the poems</a></strong></p></div>
	 </td>
  </tr>
</table>
<?php
//include the footer, which closes the table and the document
include($includedir . "main_footer.php");
?>