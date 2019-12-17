<?php
// disconnect from db
mysqli_close();

if ($nonav == FALSE) {
	print "   <p align='center'>";
	include("navbar.htm");
	print "	  </p></div>
		  <p>&nbsp;</p>";
 }
 ?>   
    </td>
  </tr>
  <tr> 
    <td colspan="3"> 
      <div align="center">
      <p class="copyright">Program code and database &copy;2003-2004 Bernini Communications LLC.<br>
        If copyrighted, texts are the property of their respective owners.</p>
      </div>
    </td>
  </tr>
</table>
<?php 
$time_end = getmicrotime();
$time = sprintf('%.3f', $time_end - $time_start);

print "<p style='color:#ffffff'>";
//print "time start: $time_start<br>";
//print "time end: $time_end<br>";
print "executed in $time seconds</p>";
?>
</body>
</html>
