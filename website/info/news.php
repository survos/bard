<?php 
// page title 
$title = "Current news"; 
// set up include directory
$includedir = $_SERVER['DOCUMENT_ROOT'] . "/inc/";
// include the header file, which starts the main table and the document
include($includedir . "main_header.php");
?> 
<table width="700" border="0" align="center">
            <tr>
               <td>
			   <h1>Current news</h1>
			   
      <p><span class="playlist"><a name="20040113" id="20040113"></a></span><span class="playlist"><strong>January 
        13, 2004:</strong> All comedies finished. Only five more plays remain, 
        all of them histories and three of them beginning with &quot;Henry VI.&quot; 
        </span><strong><span class="playlist"><br>
        <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/views/plays/playmenu.php?PlayID=cymbeline">Cymbeline</a><br>
        </strong></span></strong><strong><span class="playlist"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/views/plays/playmenu.php?PlayID=kingjohn">King 
        John </a></strong></span></strong><br>
        <strong><span class="playlist"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/views/plays/playmenu.php?PlayID=merrywives">Merry 
        Wives of Windsor</a></strong></span></strong><br>
        <strong><span class="playlist"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/views/plays/playmenu.php?PlayID=pericles">Pericles, 
        Prince of Tyre</a></strong></span></strong><br>
        <strong><span class="playlist"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/views/plays/playmenu.php?PlayID=richard2">Richard 
        II</a></strong></span></strong></p>
      <p><span class="playlist"><span class="playlist"><a name="20040109" id="20040109"></a></span><strong>January 
        9, 2004</strong>: Yet another significant batch of plays, all of them 
        (except &quot;Troilus&quot;) comedies. Ten more to go. Here are the new 
        ones: </span><strong><span class="playlist"><br>
        <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/views/plays/playmenu.php?PlayID=troilus">Troilus 
        and Cressida</a><br>
        </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><a href="/views/plays/playmenu.php?PlayID=tempest">The 
        Tempest</a><br>
        <span class="playlist">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><a href="/views/plays/playmenu.php?PlayID=twogents">Two 
        Gentlemen of Verona</a><br>
        <span class="playlist">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><a href="/views/plays/playmenu.php?PlayID=winterstale">The 
        Winter's Tale</a></strong></p>
      <p><span class="playlist"><strong><a name="20040108" id="20040108"></a><strong>January 
        8, 2004: </strong></strong>Two new histories, completing the Henry IV/V 
        cycle of plays: <strong>&quot;<a href="/views/plays/playmenu.php?PlayID=henry4p1"><strong>Henry 
        IV</strong></a>&quot; </strong>and<strong> &quot;<strong><a href="/views/plays/playmenu.php?PlayID=henry5">Henry 
        V</a></strong>.&quot; Plus, a slew of comedies: <br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/views/plays/playmenu.php?PlayID=allswell">All's 
        Well That Ends Well</a><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/views/plays/playmenu.php?PlayID=comedyerrors">Comedy 
        of Errors</a><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/views/plays/playmenu.php?PlayID=loveslabours">Love's 
        Labour's Lost</a><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/views/plays/playmenu.php?PlayID=measure">Measure 
        for Measure</a><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/views/plays/playmenu.php?PlayID=merchant">Merchant 
        of Venice</a><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/views/plays/playmenu.php?PlayID=midsummer">A 
        Midsummer Night's Dream</a><br>
        </strong>With this latest batch of plays,well over half of the plays are 
        available. Only 15 of the 37 plays remain to be parsed.. </span></p>
      <p><strong><a name="20040105" id="20040105"></a></strong><strong>January 
        5, 2004: </strong>A landmark in OSS history &mdash; all of the tragedies 
        are now available. Thus five additional plays were posted: &quot;<a href="/views/plays/playmenu.php?PlayID=antonycleo"><strong>Antony 
        and Cleopatra</strong></a>,&quot; &quot;<a href="/views/plays/playmenu.php?PlayID=coriolanus"><strong>Coriolanus</strong></a>,&quot; 
        &quot;<a href="/views/plays/playmenu.php?PlayID=juliuscaesar"><strong>Julius 
        Caesar</strong></a>,&quot; &quot;<a href="/views/plays/playmenu.php?PlayID=titus"><strong>Titus 
        Andronicus</strong></a>,&quot; and &quot;<strong><a href="/views/plays/playmenu.php?PlayID=timonathens">Timon 
        of Athens</a></strong>.&quot; The parser now reads character information 
        from the database, so the characters are only entered once.</p>
      <p><strong><a name="20031228" id="20031228"></a></strong><strong>December 
        28, 2003: </strong>&quot;<a href="views/plays/playmenu.php?PlayID=macbeth"><strong>Macbeth</strong></a>,&quot; 
        &quot;<a href="views/plays/playmenu.php?PlayID=muchado"><strong>Much Ado</strong></a>,&quot; 
        &quot;<a href="views/plays/playmenu.php?PlayID=othello"><strong>Othello</strong></a>,&quot; 
        &quot;<strong><a href="views/plays/playmenu.php?PlayID=romeojuliet">Romeo 
        and Juliet</a></strong>&quot;</strong> added. The management wrote a script 
        that automates the formatting of the texts. Now a text can be prepared 
        with three small manual steps, plus running the script; characters still 
        have to be manually entered into the database and the parser. The characters 
        will still have to be entered manually, but there has to be a way to avoid 
        entering them twice. </p>
      <p><strong></strong><strong><a name="20031221"></a>December 21, 2003: </strong>&quot;<a href="/views/plays/playmenu.php?PlayID=hamlet"><strong>Hamlet</strong></a>&quot; 
        added to the database. </p>
      <p><strong></strong><strong><a name="20031214" id="20031214"></a>December 
        14, 2003: </strong>Open Source Shakespeare released to the public, with 
        many features unfinished. This is deliberate, because the management wanted 
        to solicit public comments. There are four plays available: &quot;<a href="http://oss/views/plays/playmenu.php?PlayID=asyoulikeit"><strong>As 
        You Like It</strong></a>,&quot; &quot;<a href="http://oss/views/plays/playmenu.php?PlayID=henry4p2"><strong>Henry 
        IV, Part II</strong></a>,&quot; &quot;<a href="http://oss/views/plays/playmenu.php?PlayID=kinglear"><strong>King 
        Lear</strong></a>,&quot; and &quot;<a href="http://oss/views/plays/playmenu.php?PlayID=tamingshrew"><strong>Taming 
        of the Shrew</strong></a>.&quot; E-mail <a href="mailto:oss@bernini-communications.com"><strong>oss@bernini-communications.com</strong></a> 
        if you have anything to say about the site. </p>
                  <h3 align="center">Works to be added</h3>
                  <ul>
                     <li>
                        
          <p>Remaining plays</p>
                     </li>
                     <li>
                        <p>All sonnets</p>
                     </li>
                     <li>
                        <p>All poems</p>
                     </li>
                  </ul>
                  <h3 align="center">Planned features</h3>
                  
      <ul>
        <li> 
          <p>View page source function </p>
        </li>
        <li> 
          <p>View SQL statement used to generate results</p>
        </li>
        <li> 
          <p>Sample queries that populate the advanced search function</p>
        </li>
        <li> 
          <p>Proximity searching</p>
        </li>
        <li> 
          <p>&quot;Search within this work&quot; link in a play's main menu</p>
        </li>
        <li> 
          <p>Summary at top of search results</p>
        </li>
        <li> 
          <p>Personal bookmarking</p>
        </li>
      </ul>
      <p align="center"><strong><a href="/">Back to the main page</a></strong></p></td>
            </tr>
         </table>
         
      <p>&nbsp;</p>
	  
<?php
//include the footer, which closes the table and the document
include($includedir . "main_footer.php");
?>
