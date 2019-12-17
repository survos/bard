<?php 
// page title 
$title = "Technical details "; 
// set up include directory
$includedir = $_SERVER['DOCUMENT_ROOT'] . "/inc/";
// include the header file, which starts the main table and the document
include($includedir . "main_header.php");
?> 
<h1>The technology used for<br>
  Open Source Shakespeare</h1>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr align="left" valign="top"> 
    <td><strong></strong> <p>Eventually, this page will have a comprehensive overview 
        of how OSS is constructed. Right now, it's a general description. </p>
      <p><strong>Texts: </strong>A variety of sources. The first four plays are 
        from the <a href="http://gutenberg.net/browse/IA_S.HTM" target="gutenberg"><strong>Gutenberg 
        Project</strong></a>, but the management has found that the <a href="http://the-tech.mit.edu/Shakespeare/" target="moby"><strong>Complete 
        Moby Shakespeare</strong></a> has better-edited texts that are more conducive 
        to parsing. </p>
      <p><strong>Parser: </strong>For the uninitiated, a parser is something that 
        reads a document and does something with it. In this case, the parser 
        reads the texts and feeds it into the database. The OSS parser is written 
        in Perl. </p>
      <p><strong>Database: </strong>Originally it was Microsoft Access, but switched 
        to <a href="http://www.mysql.com" target="mysql"><strong>mySQL</strong></a> 
        because it's cheaper to find a Web host that supports mySQL. Plus, in 
        the management's temperate, considered, intellectual opinion, Microsoft 
        sucks and we hate them. </p>
      <p><strong>Web server: </strong>The OSS campus has a test server running 
        Apache 1.3.29, but there's no reason it couldn't run on Apache 2.0, or 
        IIS for that matter. It has not been tested on any other platform. </p>
      <p><strong>Page language:</strong> All of the pages are written in PHP, 
        with the exception of a few HTML pages here and there. Again, this was 
        done because most <em>el cheapo</em> hosting companies support PHP. It's 
        also a mature scripting language that has a tremendous amount of free 
        support on the Web, and we like that. </p>
      <p>&nbsp;</p></td>
  </tr>
  <tr align="left" valign="top"> 
    <td><div align="center">
        <p><strong><a href="/">Back to the main page</a></strong></p>
      </div></td>
  </tr>
</table>
      <p>&nbsp;</p>
<?php
//include the footer, which closes the table and the document
include($includedir . "main_footer.php");
?>
