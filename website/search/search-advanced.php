<?php 
// page title 
$title = "Advanced search"; 
// set up include directory
$includedir = $_SERVER['DOCUMENT_ROOT'] . "/inc/";
// include the header file, which starts the main table and the document
include($includedir . "main_header.php");

/*---------------------------------------------------------------------------
  Set up the menu options
---------------------------------------------------------------------------*/

// Works
$workquery = "SELECT WorkID, Title 
              FROM Works 
			  ORDER BY Title";
$workdata = mysqli_query($workquery);

// Play dates (list of publication years)
$datequery = "SELECT Date 
			  FROM Works 
			  ORDER BY Date";
$datedata = mysqli_query($datequery);

// Play max/min dates
$dateminmaxquery = "SELECT MAX(Date) AS MaxDate, 
                           MIN(Date) AS MinDate 
			  		FROM Works";
$dateminmaxdata = mysqli_query($dateminmaxquery);
$dateminmaxdataget = mysqli_fetch_array($dateminmaxdata); // get the high and low dates
$maxdate = $dateminmaxdataget["MaxDate"];
$mindate = $dateminmaxdataget["MinDate"];

// Characters
$charquery = "SELECT CharID, CharName
			  FROM Characters 
			  ORDER BY CharName";
$chardata = mysqli_query($charquery); 

// Genres
$genrequery = "SELECT GenreType, GenreName
			   FROM Genres
			   ORDER BY GenreName";
$genredata = mysqli_query($genrequery); 

?> 
<h1>Advanced search </h1>
<form action="search-results.php" method="post" name="searchform">
  <table cellpadding='5'>
    <tr> 
      <td align="right" valign="middle"><span class="searchtermlabel">Search type</span></td>
      <td align="left" valign="middle" colspan="2"><span class="normalsans">
        <input type="radio" name="searchtype" value="like" class="plainbutton" checked>
        All or part of the keyword (faster) 
        <input type="radio" name="searchtype" value="regexp" class="plainbutton">
        Exact (slower)</span></td>
    </tr>
    <tr> 
      <td width="250" rowspan='3' align="right" valign="top"> <p class="searchtermlabel"><strong>Keywords/phrases<br>
          <span class="searchtermnote">Multiple words on a single line<br>
          are interpreted as phrases, <br>
          so you don't have <br>
          to enclose phrases <br>
          in quotation marks.</span></strong></p></td>
      <td><p><span class="keywordlabel">1</span> 
          <input name="keyword1" type="text" id="keyword12" size="15">
          <select name="conjunction1" id="select">
            <option value="AND" selected>AND</option>
            <option value="OR">OR</option>
          </select>
        </p></td>
      <td><p><span class="keywordlabel">2</span> 
          <input name="keyword2" type="text" id="keyword22" size="15">
          <select name="conjunction2" id="select2">
            <option value="AND" selected>AND</option>
            <option value="OR">OR</option>
          </select>
        </p></td>
    </tr>
    <tr> 
      <td><p>&nbsp;&nbsp;&nbsp;<span class="keywordlabel">3</span> 
          <input name="keyword3" type="text" id="keyword33" size="15">
          <select name="conjunction3" id="select7">
            <option value="AND" selected>AND</option>
            <option value="OR">OR</option>
          </select>
        </p></td>
      <td><p>&nbsp;&nbsp;&nbsp;<span class="keywordlabel">4</span> 
          <input name="keyword4" type="text" id="keyword42" size="15">
          <select name="conjunction4" id="select8">
            <option value="AND" selected>AND</option>
            <option value="OR">OR</option>
          </select>
        </p></td>
    </tr>
    <tr> 
      <td><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="keywordlabel">5</span> 
          <input name="keyword5" type="text" id="keyword52" size="15">
          <select name="conjunction5" id="select9">
            <option value="AND" selected>AND</option>
            <option value="OR">OR</option>
          </select>
        </p></td>
      <td><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="keywordlabel">6</span> 
          <input name="keyword6" type="text" id="keyword62" size="15">
        </p></td>
    </tr>
  </table>
  <table cellpadding='5'>
    <tr align="left" valign="top"> 
      <td align="right"> <p class="searchtermlabel"><strong>Works</strong></p></td>
      <td> <select name="works[]" size="10" multiple id="select10">
          <option value="*" selected>ALL WORKS</option>
          <?php 
						   // loop through the works
						   while ($currentrow = mysqli_fetch_array($workdata)) {
						   $currentplayid = $currentrow["WorkID"];
						   $currenttitle = $currentrow["Title"];
						   print "						   <option value='$currentplayid'>$currenttitle</option>\n";
						   }
						   ?>
        </select></td>
      <td align="right"> <p class="searchtermlabel"><strong>Characters</strong></p></td>
      <td> <select name="characters[]" size="10" multiple id="select11">
          <option value="*" selected>ALL CHARACTERS</option>
          <?php 
						   // loop through the characters
						   while ($currentrow = mysqli_fetch_array($chardata)) {
						   $currentcharid = $currentrow["CharID"];
						   $currentcharname = $currentrow["CharName"];
						   print "						   <option value='$currentcharid'>$currentcharname</option>\n";
						   }
						   ?>
        </select> </td>
    </tr>
    <tr align="left" valign="top"> 
      <td rowspan="2" align="right"><p class="searchtermlabel"><strong>Genres</strong></p></td>
      <td rowspan="2"><select name="genres[]" size="6" multiple>
          <option value="*" selected>ALL GENRES</option>
          <?php 
						   // loop through the genres
						   while ($currentrow = mysqli_fetch_array($genredata)) {
						   $currentgenretype = $currentrow["GenreType"];
						   $currentgenrename = $currentrow["GenreName"];
						   print "						   <option value='$currentgenretype'>$currentgenrename</option>\n";
						   }
						   ?>
        </select></td>
      <td align="right"><p class="searchtermlabel"><strong>Date range</strong></p></td>
      <td> <p> 
          <select name="lowdate" id="select14">
            <?php 
						   // loop through the dates
						   while ($currentrow = mysqli_fetch_array($datedata)) {
						   $currentdate = $currentrow["Date"];
						   print "						   <option value='$currentdate'>$currentdate</option>\n";
						   }
						   ?>
          </select>
          <span class="searchtermlabel"><strong>to</strong></span> 
          <select name="highdate" id="select15">
            <?php 
						   // loop through the dates, resetting the date query first
						   mysqli_data_seek($datedata, 0);
						   while ($currentrow = mysqli_fetch_array($datedata)) {
						   $currentdate = $currentrow["Date"];
						   if ($currentdate == $maxdate) { 
						   		$selected = " selected";
						   }
						   print "						   <option value='$currentdate'$selected>$currentdate</option>\n";
						   }
						   ?>
          </select>
        </p></td>
    </tr>
    <tr align="left" valign="top"> 
      <td align="right" class="searchtermlabel"><strong>Sort by</strong></td>
      <td><select name="sortby">
          <option value="WorkName" selected>Name of work</option>
          <option value="CharName">Character name</option>
        </select></td>
    </tr>
    <tr align="center" valign="top"> 
      <td colspan="4">&nbsp; </td>
    </tr>
  </table>  
  <div align="center">
    <input type="submit" name="Search" value="Search" class='formbutton'>
    <input type="reset" name="Reset form" value="Reset form" class='formbutton'>
  </div>
</form>
<?php
//include the footer, which closes the table and the document
include($includedir . "main_footer.php");
?>