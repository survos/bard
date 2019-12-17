<?php 
// get the requested letter
$letter = $_GET['Letter'];

// page title 
$title = "Shakespeare concordance: word forms beginning with $letter"; 
// set up include directory
$includedir = $_SERVER['DOCUMENT_ROOT'] . "/inc/";
// include the header file, which starts the main table and the document
include($includedir . "main_header.php");

// get total wordforms for the requested letter
$sqlgetwords = "SELECT Count(*) as TotalForms
				FROM WordForms 
				WHERE PlainText LIKE '$letter%'";
$letterwords = mysqli_query($sqlgetwords);
$letterinfo = mysqli_fetch_array($letterwords);
$totalforms = $letterinfo['TotalForms'];
?>

<table align='center' width='500'>
	<tr>
		<td>
<h1><?="Shakespeare concordance:<br>word forms beginning with $letter"?></h1>
<p align="center"><img src="/images/three-leaf_dingbat.gif" alt="W" width="27" height="28" border="0"></p>
<p align="center" class="normalsans"><strong><?=number_format($totalforms)?> total word forms</strong></p>
<p align="center" class="normalsans"><strong>Select a word to see where it occurs<br>
  in the texts, as well as related words.</strong></p>
      <p align="center" class="normalsans">Numbers indicate the total occurences 
        of each word form. </p>
<p>
			<?php
			// get all the wordforms beginning with that letter
			$sqlgetwords = "SELECT *
							FROM WordForms 
							WHERE PlainText LIKE '$letter%'
							GROUP BY PlainText;";
			$letterwords = mysqli_query($sqlgetwords);
			while ($letterword = mysqli_fetch_array($letterwords)) {
				$wordid = $letterword['WordFormID'];
				$wordplain = $letterword['PlainText'];
				$wordstem = $letterword['StemText'];
				$wordphonetic = $letterword['PhoneticText'];
				$wordoccur = $letterword['Occurences'];
				print "<a href='o?i=$wordid'><b>$wordplain</b></a> (" . number_format($wordoccur) . ")<br>";
			}
			?>
			</p>
		</td>
	</tr>
</table>

<h2 align='center'><strong><a href="/concordance"><img src='/images/arrow_left.gif' width='21' height='12' border='0' alt=']' align='absmiddle'> 
Back to the concordance menu</a></strong></h2>
			
<?php
//include the footer, which closes the table and the document
include($includedir . "main_footer.php");
?>