<?php 
// page title 
$title = "View Shakespeare sonnets"; 
// set up include directory
$includedir = $_SERVER['DOCUMENT_ROOT'] . "/inc/";
// include the header file, which starts the main table and the document
include($includedir . "main_header.php");

// the following code was written by Hugh Bothwell
// found at http://www.phpbuilder.com/lists/php-db/2003061/0349.php
function RomanDigit($dig, $one, $five, $ten) { 
  switch($dig) { 
      case 0: return ""; 
      case 1: return "$one"; 
      case 2: return "$one$one"; 
      case 3: return "$one$one$one"; 
      case 4: return "$one$five"; 
      case 5: return "$five"; 
      case 6: return "$five$one"; 
      case 7: return "$five$one$one"; 
      case 8: return "$five$one$one$one"; 
      case 9: return "$one$ten"; 
  } 
} 

function IntToRoman($num) { 
  $num = (int) $num; 
  if (($num < 1) || ($num > 3999)) 
      return("No corresponding Roman number!"); 
  $m = (int) ($num * 0.001); $num -= $m*1000; 
  $c = (int) ($num * 0.01); $num -= $c*100; 
  $x = (int) ($num * 0.1); $num -= $x*10; 
  $i = (int) ($num); 

// echo "m = $m, c = $c, x = $x, i = $i "; 
  return( 
       RomanDigit($m, 'M', '', '') 
      . RomanDigit($c, 'C', 'D', 'M') 
      . RomanDigit($x, 'X', 'L', 'C') 
      . RomanDigit($i, 'I', 'V', 'X') 
  ); 
} 

?> 
<h1>View sonnets</h1>
<table align="center" cellpadding='10'>
  <tr>
	  <td align='left' valign='top' >
	  <?php 
	  
	  if ($_REQUEST["sidebyside"] !='compare') {
	  
	  // get the requested sonnet, which will be an URL variable if it exists
	  $requestedsonnet = $_REQUEST["Sonnet"];

	  // see if we're merely viewing one sonnet
	  if ($requestedsonnet != '') {
		$firstsonnet = $requestedsonnet;
		$lastsonnet = $requestedsonnet;
	  }
	  
	  // see if we're viewing all sonnets
	  if ($requestedsonnet == 'all') {
		$firstsonnet = 1;
		$lastsonnet = 154;
	  }	  

	  // see if this is a range of sonnets
	  if ($_REQUEST["range"] == 'view range') {
		$firstsonnet = $_REQUEST["sonnetrange1"];
		$lastsonnet = $_REQUEST["sonnetrange2"];
		
		// if the last sonnet is bigger than the first, then switch the values
		if ($firstsonnet > $lastsonnet) {
			$tradevalue = $firstsonnet;
			$firstsonnet = $lastsonnet;
			$lastsonnet = $tradevalue; 
		}
	  }	  
	  
	  // display the sonnet(s)
	  require("sonnet_render.php");
	  }
	  else 
	  {
		  // show side by side comparison, as long as there is something to companre
		  
		  // use small text 
		  $smalltext = TRUE;
		  
		  $sonnetcompare1 = $_REQUEST["sonnetcompare1"];
		  if ($sonnetcompare1 != "--") {
			 $firstsonnet = $sonnetcompare1; 
			 $lastsonnet = $sonnetcompare1; 
			 require("sonnet_render.php");
		  }
		  $sonnetcompare2 = $_REQUEST["sonnetcompare2"];
		  if ($sonnetcompare2 != "--") {
		     print "</td><td align='left' valign='top'>"; 
			 $firstsonnet = $sonnetcompare2; 
			 $lastsonnet = $sonnetcompare2; 
			 require("sonnet_render.php");
		  }
	  }
	  ?>
	  </td>
  </tr>
</table>
<?php
//include the footer, which closes the table and the document
include($includedir . "main_footer.php");
?>