<?php 
// page title 
$title = "Keyword search"; 
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
			  WHERE Active=1 
			  ORDER BY Title";
$workdata = mysqli_query($workquery);

?>

      <p align="center">This will be for simple searches <br>
        for keywords or short phrases. </p>
      <p align="center"> For now, the only working search <br>
  is the <a href="search-advanced.php"><strong>advanced search</strong></a>. <br>
        But the advanced search is better anyway. </p>
      <p align="center">&nbsp;</p>

<?php
//include the footer, which closes the table and the document
include($includedir . "main_footer.php");
?>
