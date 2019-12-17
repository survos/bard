<?php 
// page title 
$title = "Links to other Shakespeare sites"; 
// set up include directory
$includedir = $_SERVER['DOCUMENT_ROOT'] . "/inc/";
// include the header file, which starts the main table and the document
include($includedir . "main_header.php");
?> 
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><h1>Links to other <strong>Shakespeare</strong> sites</h1>
      <hr align="center" size="1" noshade>
      <p class="sitecategory"><strong>Search sites</strong></p>
      <p><span class="sitetitle"><a href="http://efts.lib.uchicago.edu/efts/OTA-SHK/restricted/search.form.html" target="ffs"><strong>First 
        Folio of Shakespeare</strong></a><strong><em> at the University of Chicago 
        (USA) </em></strong></span><br>
        <span class="sitedescription"> Full-text searching of their First Folio 
        text, with a few extras such as searching within genres and proximity 
        searches. </span></p>
      <p><span class="sitetitle"><a href="http://www.shakespeare.com/FirstFolio/" target="shakecom"><strong>First 
        Web Folio Edition</strong></a><strong><em> at shakespeare.com</em></strong></span><br>
        <span class="sitedescription">Only offers simple keyword searching. Texts 
        based on the <a href="http://the-tech.mit.edu/Shakespeare/" target="moby">Complete 
        Moby Shakespeare</a> edition. </span></p>
      <p><span class="sitetitle"><a href="http://www.bartleby.com/70/" target="bartleby"><strong>The 
        Oxford Shakespeare (1914)</strong></a><strong><em> at Bartleby.com </em></strong></span><br>
        <span class="sitedescription">Includes line numbering and keyword searching. 
        Also has notes for non-modern words and word usage. </span></p>
      <p><span class="sitetitle"><a href="http://web.uvic.ca/shakespeare/index.html" target="uvic"><strong>Shakespeare 
        Internet Editions</strong></a><strong><em> at the University of Victoria 
        (Canada)</em></strong></span><br>
        <span class="sitedescription">Original spelling, line numbering embedded 
        in text. Includes multiple editions of the texts. </span></p>
      <p><span class="sitetitle"><a href="http://www.it.usyd.edu.au/%7Ematty/Shakespeare/" target="twotb"><strong>The 
        Works of the Bard</strong></a><strong><em> at the University of Sydney 
        (Australia) </em></strong></span><br>
        <span class="sitedescription">Over a decade old, and still the most powerful 
        free search apparatus on the Internet. Many of the features on Open Source 
        Shakespeare are duplications of <a href="http://www.it.usyd.edu.au/%7Ematty/Shakespeare/test.html" target="twotb">the 
        search engine</a>; in many ways, when OSS is complete, it will be an enhancement 
        of TWOTB's existing features in a more user-friendly packaging. Its main 
        problem is the arcane search syntax, which few will take the time to master. 
        </span> </p>
      <hr align="center" size="1" noshade>
      <h2 class="sitecategory"><strong>Commercial sites</strong></h2>
      <p class="normalsans">The management does not endorse any of these 
        sites; they are presented for comparison. That means we're trying to show 
        you what you get on this site for free. </p>
      <p><a href="http://collections.chadwyck.com/html/eas/help/eassrch.htm" target="chad" class="sitetitle">Chadwyck-Healey 
        Editions and Adaptations of Shakespeare</a><br>
        <span class="sitedescription">This informational page shows how you could 
        search the Chadwyck-Healey collection &mdash; assuming your institution 
        subscribes to it. </span></p>
      <p><a href="http://www.shkspr.uni-muenster.de/SDB2010.html" target="sdb" class="sitetitle">Shakespeare 
        Database Project</a><br>
        <span class="sitedescription">Outdated and apparently under-developed, 
        the Shakespeare Database Project is nevertheless the most ambitious compilation 
        of Shakespeare's plays. (See the database's complexity <a href="http://www.shkspr.uni-muenster.de/SDB3000.html" target="sdb">for 
        yourself</a>.) Not being a philologist, I am unfamiliar with many of the 
        terms they use, but I gather that every word in the texts is parsed and 
        categorized a zillion different ways. </span></p>
      <hr align="center" size="1" noshade>
      <h2 class="sitecategory"><strong>Text collections</strong></h2>
      <p><span class="sitetitle"><a href="http://the-tech.mit.edu/Shakespeare/" target="moby">Complete 
        Moby Shakespeare</a> <em>at MIT</em></span><br>
        <span class="sitedescription">Public domain HTML versions of the plays, 
        but no poems. There's a note on the site saying, &quot;The poetry and 
        other services, including the search engine and forums, will return shortly,&quot; 
        but visitors might be skeptical because the note is dated November 13, 
        2000. </span></p>
      <p><a href="http://dewey.library.upenn.edu/sceti/printedbooksNew/index.cfm?textID=firstfolio&PagePosition=1" target="fff" class="sitetitle">First 
        Folio facsimile: Schoenberg Center for Electronic Text &amp; Image</a> 
        <br>
        <span class="sitedescription">Exactly what it sounds like: facsimile images 
        of the First Folio. </span></p>
      <p><a href="http://gutenberg.net/browse/IA_S.HTM" target="gutenberg" class="sitetitle">Gutenberg 
        Project</a> <br>
        <span class="sitedescription">Many, many Shakespeare texts, free for personal 
        use. Some are even in German. (Scroll down to see Gutenberg's complete 
        list of Shakespeare's works.) </span></p>
      <p align="center"><strong><a href="/">Back to the main page</a></strong></p>
      </td>
  </tr>
</table>
<p> 
  <?php
//include the footer, which closes the table and the document
include($includedir . "main_footer.php");
?>
</p>
