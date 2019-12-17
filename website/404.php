<?php 
// page title 
$title = "Page not found"; 
// set up include directory
$includedir = $_SERVER['DOCUMENT_ROOT'] . "/inc/";
// include the header file, which starts the main table and the document
$nonav = TRUE;
include($includedir . "main_header.php");
?> 
         <table width="500" border="0" align="center">
            <tr>
               
    <td> <h1 class="notfoundtitle">PAGE NOT FOUND!</h1>
      <p class='normalsans'>The page you requested could not be found in Open Source Shakespeare. 
	  You might want to go back to the page that referred you: </p>
	  <blockquote><p class='normalsans'><a href='<?= $_SERVER["HTTP_REFERER"] ?>'><strong><?= $_SERVER["HTTP_REFERER"] ?></strong></a></p></blockquote>
      <p class='normalsans'>If you think the page you requested (http://<?php print $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>) 
        is correct, please <a href="mailto:oss@bernini-communications.com"><strong>e-mail the management </strong></a> 
	  and let us know.</p>
	  
	  <p class='normalsans'>Here are some pages you might have been looking for: </p>
	  <blockquote>
      <p class='normalsans'><strong><a href="/">The main page</a>: </strong>introduces the OSS site</p>
      <p class='normalsans'><strong><a href="../views/plays/plays.php">List of plays</a>:</strong> 
        Shows all of the plays available for searching</p>
      <p class='normalsans'><strong><a href="../search/search-keyword.php">Keyword search</a>: </strong>performs 
        simple searches</p>
      <p class='normalsans'><strong><a href="/search/search-advanced.php">Advanced search</a>: 
        </strong>for searching on the <em>wild side</em>...</p>
	  </blockquote>
      </td>
            </tr>
         </table>
         
      <p class='normalsans'>&nbsp;</p>
	  
<?php
//include the footer, which closes the table and the document
$nonav = TRUE;
include($includedir . "main_footer.php");
?>

