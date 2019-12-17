<?php 
// page title 
$title = "Shakespeare concordance: search results"; 
// set up include directory
$includedir = $_SERVER['DOCUMENT_ROOT'] . "/inc/";
// include the header file, which starts the main table and the document
include($includedir . "main_header.php");

// get the word form request, scrub it of undesirable characters
$findword = $_REQUEST['findword'];
//$findword = ereg_replace("[^a-z'\-]", "", $findword);

// see what the user's preferred search is
$searchpref = $_REQUEST['searchpref'];
switch ($searchpref) {
case "exact":
	$searchbegin = '';
	$searchend = '';
	$searchtype = "an exact match";
	break;
case "first":
	$searchbegin = '';
	$searchend = '%';
	$searchtype = "first part of word form";
	break;
case "any":
	$searchbegin = '%';
	$searchend = '%';
	$searchtype = "any part of word form";
	break;
}

// get the word forms, if any
$sqlgetwords = "
SELECT WordFormID, PlainText, Occurences
FROM WordForms
WHERE PlainText LIKE '$searchbegin$findword$searchend'
ORDER BY PlainText";

$wordformdata = mysqli_query($sqlgetwords);
if ($wordformdata) {
	$formsfound = mysqli_num_rows($wordformdata);
	}
	else {
	$formsfound = 0;
}

if ($formsfound == 0) {
		$foundline = "No word forms found.";
	}
	else {
		if ($formsfound == 1 ) { $s = ''; } else { $s = 's'; }
			$foundline = "$formsfound word form$s found.";
}

?> 

<h1 align="center">Word form search results<br>for "<?=stripslashes($findword)?>"</h1>
<h2 align="center">Searched for <?=$searchtype?>.<br><?=$foundline?></h2>
<p align="center">
<img src="/images/three-leaf_dingbat.gif" alt="W" width="27" height="28" border="0">
</p>

<?php
print "<table align='center'><tr><td><p>";
if ($formsfound > 0 ) {
	// loop through the words we found 
	while ($currentform = mysqli_fetch_array($wordformdata)) {
		print "		<img src='/images/small_dingbat.gif' alt='+' width='7' height='9' border='0' align='middle'>
		<b><a href='o?i=" . $currentform['WordFormID'] . "'>" . $currentform['PlainText'] . 
		"</a></b> (" . number_format($currentform['Occurences']) . ")<br>\n";
	}
}
print "&nbsp;</p></td></tr></table>";
?>
<table align='center' cellpadding='5'>
	<tr>
		<td><img src='/images/long_line.gif' width='500' height='2'></td>
	<tr>
	<tr>
		<td align='left' valign='top'>
			<form name='getform' method='post' action='findform.php'>
				<p><span class='searchtermlabel'>Find another word form</span> 
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

<h2 align='center'><strong><a href="index.php"><img src='/images/arrow_left.gif' width='21' height='12' border='0' alt=']' align='absmiddle'> 
Back to the concordance menu</a></strong></h2>
<?php
//include the footer, which closes the table and the document
include($includedir . "main_footer.php");
?>
