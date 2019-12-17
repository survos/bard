<?php 
// Connect to the database server
include("inc/dbconnect.php");
?>

<html>
<head>
<title>Open Source Shakespeare: search Shakespeare's works, read the texts</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META name="description" content="">
<link href="/styles/oss-main.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#BF3000" background="/images/backtile.gif">
<table width="760" border="1" cellpadding="0" cellspacing="0" bordercolorlight="#000000" bordercolordark="#000000" bgcolor="#FEF3DE">
<tr> 
    <td> 
      <div align="center"><img src="/images/oss-biglogo.gif" width="760" height="76" alt="Open Source Shakespeare"></div>    </td>
  </tr>
  <tr> 
    <td ><table width="760" border="0" align="center" cellspacing="15" bgcolor="#FEF3DE">
        <tr align="left" valign="top"> 
          
        <td width="33%"> <p><b><font size="4">WHAT IS OPEN SOURCE SHAKESPEARE? 
            </font></b></p>
          <p>Open Source Shakespeare was created to be the best free resource 
            for scholars, thespians, and Shakespeare lovers. It will not replace 
            the expensive, subscription-only sites at libraries or research institutions 
            -- though many features are comparable. </p>
          <p><strong>Power.</strong> The advanced search will pinpoint the passages 
            you're seeking. </p>
          <p><strong>Flexibility. </strong>The features are designed to accomodate 
            multiple ways of searching and viewing the text. </p>
          <p><strong>Friendliness.</strong> You need not have a degree in computer 
            science to find this site useful, as it's designed to be easily understood 
            and navigated. </p>
          <p><strong>Openness.</strong> You can download the code and the database 
            that runs this site, and use them in your non-commercial project as 
            you see fit. As long as you link to Open Source Shakespeare on your 
            site (if you post your project to the Web), you're welcome to use 
            any or all of the OSS. </p>
          <p><em><a href="/info/aboutsite.php"><strong>READ MORE ABOUT OPEN SOURCE 
            SHAKESPEARE...</strong></a></em></p>
          </td>
          <td width="34%"> 
            <p align="center"><img src="/images/shakespeare-sepia.jpg" width="184" height="216" alt="William Shakespeare" border="0"><br>
              William Shakespeare<br>
              1564-1616</p>
                  
          <p align="left"><b><font size="4">SITE NEWS AND ANNOUNCEMENTS</font></b></p>
          <p align="left"><a href="/info/news.php#107630020965441887">&gt;&gt; 
            Feb. 6: <strong>ALL WORKS NOW AVAILABLE</strong></a></p>
          <p align="left"><a href="/info/news.php#107579305153641667">&gt;&gt; 
            Feb. 3: All sonnets now available. </a></p>
          <p align="left">&gt;&gt; <a href="/info/news.php#107465741680539300">Jan. 
            20: New play views added; user comments added.</a> </p>
          <p align="left"><a href="/info/news.php#107448258307369609">&gt;&gt; 
            Jan. 16: <strong>ALL PLAYS ADDED TO THE DATABASE</strong></a></p>
          </td>
          
        <td width="33%"> <p><b><font size="4">READ AND SEARCH THE COMPLETE WORKS</font></b></p>
          <p>Here are a few popular plays, but you can read all of the plays or 
            poetry by following the links below. </p>
          <p class="normalsans"><a href="views/plays/playmenu.php?WorkID=hamlet"><strong>Hamlet</strong></a><br>
            <strong><a href="views/plays/playmenu.php?WorkID=12night">Twelfth 
            Night</a></strong><br>
            <strong><a href="views/plays/playmenu.php?WorkID=romeojuliet">Romeo 
            and Juliet</a></strong><br>
            <strong><a href="views/plays/playmenu.php?WorkID=henry5">Henry V</a></strong><br>
            <strong><a href="views/plays/playmenu.php?WorkID=kinglear">King Lear</a></strong><br>
            <strong><a href="views/plays/playmenu.php?WorkID=asyoulikeit">As You 
            Like It</a></strong><br>
            <strong><a href="views/plays/playmenu.php?WorkID=macbeth">Macbeth</a></strong></p>
          <p><strong><a href="/views/plays/plays.php"> <img src="/images/small_dingbat.gif" alt="+" width="7" height="9" border="0" align="middle"> 
            List all the plays</a> </strong><br>
            &nbsp; <a href="/views/plays/plays_alpha.php">alphabetically</a><br>
            &nbsp; <a href="/views/plays/plays.php">by genre</a> <br>
            &nbsp; <a href="/views/plays/plays_date.php">by date<br>
            </a>&nbsp; <a href="/views/plays/plays_numlines.php">by number of 
            lines<br>
            </a><strong><a href="/views/plays/plays.php"><img src="/images/small_dingbat.gif" alt="+" width="7" height="9" border="0" align="middle"> 
            </a><a href="views/poems/poems.php">Poems</a><br>
            </strong><strong><a href="/views/plays/plays.php"><img src="/images/small_dingbat.gif" alt="+" width="7" height="9" border="0" align="middle"> 
            </a><a href="views/sonnets/sonnets.php">Sonnets</a></strong></p>
          <p><strong><b><font size="4">USE THE TOOLS</font></b></strong></p>
          <p>Search the texts with ease, or use the concordance to research Shakespeare's 
            word usage.</p>
          <p><img src="/images/small_dingbat.gif" alt="+" width="7" height="9" border="0" align="middle"> 
            <a href="/search/search-advanced.php"><strong>Advanced search</strong></a><br>
            <img src="/images/small_dingbat.gif" alt="+" width="7" height="9" border="0" align="middle"> 
            <strong><a href="/concordance">Concordance</a></strong></p>
          <p><strong><b><font size="4">GET INFORMATION</font></b></strong></p>
          <p><a href="/search/search-advanced.php"><strong></strong></a><strong><strong><a href="/views/plays/plays.php"><img src="/images/small_dingbat.gif" alt="+" width="7" height="9" border="0" align="middle"> 
            </a></strong><a href="/info/aboutsite.php"><strong>History of this 
            site</strong></a><strong><br>
            <a href="/search/search-advanced.php"><strong></strong></a><strong><a href="/views/plays/plays.php"></a><a href="/views/plays/plays.php"><img src="/images/small_dingbat.gif" alt="+" width="7" height="9" border="0" align="middle"> 
            </a></strong><a href="/info/technicaldetails.php"><strong>Technical 
            details</strong></a><strong><br>
            <a href="/search/search-advanced.php"><strong></strong></a><strong><a href="/views/plays/plays.php"></a></strong></strong></strong><strong><a href="/views/plays/plays.php"><img src="/images/small_dingbat.gif" alt="+" width="7" height="9" border="0" align="middle"> 
            </a></strong><a href="/info/links.php">Links to Shakespeare sites</a></strong></p>
          </td>
        </tr>
        <tr align="left" valign="top">
          <td colspan="3"><p align="center">E-mail the management at <a href="mailto:oss@bernini-communications.com"><strong>oss@bernini-communications.com</strong></a> 
            <br>
            if you have any questions, comments, complaints, idle threats, or 
            aspersions to cast. </p>          </td>
        </tr>
      </table>

<?php
//include the footer, which closes the table and the document
$nonav = TRUE;
include("inc/main_footer.php");
?>
