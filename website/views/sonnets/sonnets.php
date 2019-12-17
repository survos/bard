<?php 
// page title 
$title = "Shakespeare's complete sonnets"; 
// set up include directory
$includedir = $_SERVER['DOCUMENT_ROOT'] . "/inc/";
// include the header file, which starts the main table and the document
include($includedir . "main_header.php");
?> 

<table align="center" cellpadding='10'>
  <tr> 
    <td colspan='2'> <h1>Shakespeare's complete sonnets</h1></td>
  </tr>
  <tr align="left" valign="middle"> 
    <td width="30%" valign="middle"> 
      <h2>View several sonnets</h2>
      <p class="normalsans">Select a range of sonnets <br>
        you would like to view. </p>
      </td>
    <td> 
      <form name="viewrange" method="post" action="sonnet_view.php">
        <select name="sonnetrange1" id="select7">
          <option value="--" selected>--</option>
		  <?php
		  // show all 154 sonnets as options
		  for ($i=1; $i<=154; $i++) {
          	print "<option value='$i'>$i</option>\n";
		  }
		  ?>
        </select>
        <select name="sonnetrange2" id="select8">
          <option value="--" selected>--</option>
		  <?php
		  // show all 154 sonnets as options
		  for ($i=1; $i<=154; $i++) {
          	print "<option value='$i'>$i</option>\n";
		  }
		  ?>
        </select>
        <input name="range" type="submit" id="view" value="view range" class='formbutton'>
      </form> </td>
  </tr>
  <tr> 
    <td colspan='2'> <hr> </td>
  </tr>
  <tr align="left" valign="middle"> 
    <td width="30%" valign="top"> 
      <h2>View all sonnets</h2>
      <p class="normalsans">Be patient while <br>
      all the sonnets <br>
      are loading.</p></td>
    <td> <h2><a href="sonnet_view.php?Sonnet=all">Just view it</a></h2></td>
  </tr>
  <tr> 
    <td colspan='2'> <hr> </td>
  </tr>
  <tr align="left" valign="middle"> 
    <td width="30%" valign="top"> 
      <h2>Side-by-side<br>
        sonnets</h2>
      <p class="normalsans">Select two sonnets to view side by side</p></td>
    <td><form name="form1" method="post" action="sonnet_view.php">
        <select name="sonnetcompare1" id="sonnetcompare1">
          <option value="--" selected>--</option>
		  <?php
		  // show all 154 sonnets as options
		  for ($i=1; $i<=154; $i++) {
          	print "<option value='$i'>$i</option>\n";
		  }
		  ?>
        </select>
        
        <select name="sonnetcompare2" id="sonnetcompare2">
          <option value="--" selected>--</option>
		  <?php
		  // show all 154 sonnets as options
		  for ($i=1; $i<=154; $i++) {
          	print "<option value='$i'>$i</option>\n";
		  }
		  ?>
        </select>
        <input name="sidebyside" type="submit" id="view" value="compare" class='formbutton'>
      </form></td>
  </tr>
  <tr> 
    <td colspan='2'> <hr> </td>
  </tr>
  <tr align="left" valign="middle"> 
    <td width="30%" valign="top"> 
      <h2>Individual<br>
        sonnets </h2>
      </td>
    <td>
      <table cellspacing="0" cellpadding="0" border='0'>
        <tr align="center" valign="top"> 
          <td width="50">
            <p> 
              <?php
		  for ($i=1; $i<=20; $i++) {
		  	print "<a href='sonnet_view.php?Sonnet=$i'>$i</a><br>";
		  }
		  ?>
            </p></td>
          
          <td width="50"> 
            <p> 
              <?php
		  for ($i=21; $i<=40; $i++) {
		  	print "<a href='sonnet_view.php?Sonnet=$i'>$i</a><br>";
		  }
		  ?>
            </p>
			</td>
            <td width="50">  
			<p>
              <?php
		  for ($i=41; $i<=60; $i++) {
		  	print "<a href='sonnet_view.php?Sonnet=$i'>$i</a><br>";
		  }
		  ?>
            </p></td>
          
          <td width="50">  
            <p> 
              <?php
		  for ($i=61; $i<=80; $i++) {
		  	print "<a href='sonnet_view.php?Sonnet=$i'>$i</a><br>";
		  }
		  ?>
            </p></td>
          
          <td width="50"> 
            <p> 
              <?php
		  for ($i=81; $i<=100; $i++) {
		  	print "<a href='sonnet_view.php?Sonnet=$i'>$i</a><br>";
		  }
		  ?>
            </p></td>
          
          <td width="50">  
            <p> 
              <?php
		  for ($i=101; $i<=120; $i++) {
		  	print "<a href='sonnet_view.php?Sonnet=$i'>$i</a><br>";
		  }
		  ?>
            </p></td>
          
          <td width="50">  
            <p> 
              <?php
		  for ($i=121; $i<=140; $i++) {
		  	print "<a href='sonnet_view.php?Sonnet=$i'>$i</a><br>";
		  }
		  ?>
            </p></td>
          
          <td width="50"> 
            <p> 
              <?php
		  for ($i=141; $i<=154; $i++) {
		  	print "<a href='sonnet_view.php?Sonnet=$i'>$i</a><br>";
		  }
		  ?>
            </p></td>
        </tr>
      </table>
	  </td>
  </tr>
</table>
<?php
//include the footer, which closes the table and the document
include($includedir . "main_footer.php");
?>
