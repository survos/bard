<?php 
// get the requested letter
$wordid = $_GET['i'];

// Connect to the database server
$includedir = $_SERVER['DOCUMENT_ROOT'] . "/inc/";
include($includedir . "dbconnect.php");

// get information about the requested wordform
$sqlgetword = "SELECT * 
       		   FROM WordForms 
			   WHERE WordFormID=$wordid";
$worddata = mysqli_query($sqlgetword);
$wordinfo = mysqli_fetch_array($worddata);
$wordplain = $wordinfo['PlainText'];
$wordstem = $wordinfo['StemText'];
$wordphonetic = $wordinfo['PhoneticText'];
$wordoccur = $wordinfo['Occurences'];

// related words
$sqlgetstems = "SELECT WordFormID, PlainText, StemText
       		    FROM WordForms 
			    WHERE StemText='$wordstem'
			     AND WordFormID<>$wordid";
$stemdata = mysqli_query($sqlgetstems);
$stemtotal = mysqli_num_rows($stemdata);

// instances of the wordform, sorted by work
$sqlgetinstances = "SELECT Title, Paragraphs.WorkID, COUNT(*) AS InstanceCount
					FROM Paragraphs
					  CROSS JOIN Works
					  ON Works.WorkID = Paragraphs.WorkID
					WHERE PlainText REGEXP \"[^a-z\'\-]" . $wordplain . "[^a-z\'\-]\"
					GROUP BY Title";
$instanceinfo = mysqli_query($sqlgetinstances);
$totalworks = mysqli_num_rows($instanceinfo);

// instances of the wordform, total 
// ---------------------------------------> DELETE THIS WHEN DONE TROUBLESHOOTING
$sqlgettotal = "SELECT COUNT(*) AS InstanceCount
					FROM Paragraphs
					WHERE PlainText REGEXP \"[^a-z\'\-]" . $wordplain . "[^a-z\'\-]\"";
$totalinstancedata = mysqli_query($sqlgettotal);
$totalinstanceinfo = mysqli_fetch_array($totalinstancedata);
$totalinstances = $totalinstanceinfo['InstanceCount'];

// page title 
$title = "Shakespeare concordance: \"$wordplain\""; 
// set up include directory
$includedir = $_SERVER['DOCUMENT_ROOT'] . "/inc/";
// include the header file, which starts the main table and the document
// don't connect to the database again
$connectrequest = 'no';
include($includedir . "main_header.php");
?>

<h1><?="Shakespeare concordance:<br>all instances of \"$wordplain\""?></h1>
<p align="center"><img src="/images/three-leaf_dingbat.gif" alt="W" width="27" height="28" border="0"></p>
<table align='center'>
	<tr>
		<td>
			<ul>
			<li class="normalsans">
			<?php 
			if ($wordoccur == 1) { $s = ''; } else { $s = 's'; }
			print "<b>$wordplain</b> occurs <strong>" . number_format($wordoccur) . "</strong> time$s in ";
			if ($totalinstances == 1) { $s = ''; } else { $s = 's'; }
			print "<strong>" . number_format($totalinstances) . "</strong> line$s within ";
			if ($totalworks == 1) { $s = ''; } else { $s = 's'; }
			print "<strong>$totalworks</strong> work$s.<br>";
			?>
			<li class="normalsans">
			<?php
			if ($stemtotal > 0) {
				if ($stemtotal == 1) { $s = ''; } else { $s = 's'; }
				print "Possibly related word$s: ";
				$stemcount = 1;
				while ($currentstem = mysqli_fetch_array($stemdata)) {
					if ($stemcount > 1) { print ", "; }
					print "<a href=../o?i=" . $currentstem['WordFormID'] . "><b>" . $currentstem['PlainText'] . "</b></a>";
					$stemcount++;
				}
			}
			else {
				print "No related words were found.";
			}
			?>
			</li>
			<li class="normalsans">
			<?php print "<a href='http://m-w.com/cgi-bin/dictionary?book=Dictionary&va=" . urlencode($wordplain) . "' target='m-w'><strong>Look up \"$wordplain\"</strong></a> 
			in the Merriam-Webster dictionary<br>(offsite link; may not be found)"; ?>
			</li>
			</ul>
			<ul>
			<li class="normalsans">
			<?php
			// figure out whether "works" should be singular or plural 
			if ($totalworks == 1) {
				$s = '';
				$each = "the";
			}
			else {
				$s = 's';
				$each = "each";
			}
			print "The link$s below will show <strong>$wordplain</strong> in $each listed work";
			if ($totalworks > 1) {
				print ",<br>or you may want to <a href='/search/search-results.php?link=1&works=*&keyword1=$wordplain&sortby=WorkName'><strong>see all the instances at once</strong></a>";
			}
			?>.
			<br>&nbsp;</li>
			</ul>
		</td>
	</tr>
</table>
<table align="center">
	<tr>
		<td>
			<p>
			<?php
			while ($currentinstance = mysqli_fetch_array($instanceinfo)) {
				$worktitle = $currentinstance['Title'];
				$workid = $currentinstance['WorkID'];
				$instances = $currentinstance['InstanceCount'];
				// convert apostrophes to a more palatable format
				print "<a href='/search/search-results.php?link=con&works=$workid&keyword1=" . urlencode($wordplain) . "&sortby=WorkName'><strong>$worktitle</strong></a> (" . number_format($instances) . ")<br>";
			}
			?>
			</p>
		</td>
	</tr>
</table>
<p>&nbsp;</p>
<h2 align='center'><strong><a href="/concordance"><img src='/images/arrow_left.gif' width='21' height='12' border='0' alt=']' align='absmiddle'> 
Back to the concordance menu</a></strong></h2>

<?php
//include the footer, which closes the table and the document
include($includedir . "main_footer.php");
?>