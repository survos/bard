<?php 
// page title 
$title = "Concordance of Shakespeare's complete works"; 
// set up include directory
$includedir = $_SERVER['DOCUMENT_ROOT'] . "/inc/";
// include the header file, which starts the main table and the document
include($includedir . "main_header.php");
?> 
<h1>Concordance<br>
of Shakespeare's complete works</h1>
<p align="center">
<img src="../images/three-leaf_dingbat.gif" alt="W" width="27" height="28" border="0">
</p>
<table align='center'>
	<tr>
		<td align='left' valign='top'>
			<form name='getform' method='post' action='findform.php'>
				<p><span class='searchtermlabel'>Find a word form</span> 
				  <input name='findword' type='text' size='20'>
				  <input type='submit' name='Submit' value='Search' class='formbutton'>
				</p>
				
        <p> 
          <input name="searchpref" type="radio" class="plainbutton" value="exact" checked>
          <span class='normalsans'><strong>Exact spelling<br>
          </strong></span>
          <input name="searchpref" type="radio" class="plainbutton" value="first">
          <span class='normalsans'><strong>First part</strong> of a word form</span><br>
          <input type="radio" name="searchpref" value="any" class="plainbutton">
          <span class='normalsans'><strong>Any part</strong> of a word form</span></p>
        </form>
		</td>
	</tr>
</table>
<table align="center" cellpadding='5' width='500'>
	 <?php 
	 for ($character = 65; $character < 91; $character++) {
		 $letter = chr($character);
		 $sqlgetforms = "SELECT Count(*) AS LetterCount 
						 FROM WordForms 
						 WHERE PlainText 
						   LIKE '$letter%';";
		 $letterinfo = mysqli_query($sqlgetforms);
		 $lettercount = mysqli_fetch_array($letterinfo);
		 print "<tr>\n";
		 print "<td align='left' valign='bottom'><span class='letterlist'><a href='wordformlist.php?Letter=$letter'>" . strtoupper($letter) . "</a></span></td>\n";
		 print "<td align='right' valign='middle'><span class='copyright'>(" . number_format($lettercount[0]) . ")</span></td>\n";
		 print "<td>&nbsp;</td>\n";
		 if ($character == 65) {
		    print "<td rowspan='26' align='left' valign='top'>

			<p><strong>Choose a letter </strong>to the right to see all 
			the word forms beginning with that letter. The numbers next to the letters indicate 
			how many word forms begin with that letter.</p>

			<p><strong>Do you have to look through hundreds of words to find the word form you're seeking?</strong>
			 Of course not! The OSS management values your time. Enter the exact word form you want in the box above 
			 to search for it.</p> 

			<p><strong>What is a word form?</strong> A word like \"play\" can take several forms, 
			like <em>plays, playing,</em> and <em>played.</em> Each word form is listed in the database,
			along with the number of times the word form occurs in the text collection.</p>
			</td>";
		 }
		 print "</tr>\n";
	  }
	  ?>
</table>


<?php
//include the footer, which closes the table and the document
include($includedir . "main_footer.php");
?>
