<?php 
// page title 
$title = "Site history "; 
// set up include directory
$includedir = $_SERVER['DOCUMENT_ROOT'] . "/inc/";
// include the header file, which starts the main table and the document
include($includedir . "main_header.php");
?> 
<style type="text/css">
<!--
.audiences {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	list-style-type: decimal;
	line-height: 15px;
	padding-bottom: 15px;
}
-->
</style>
<style type="text/css">
<!--
.infobodytext {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	line-height: 18px;
}
-->
</style>
<h1>The history of <br>
  Open Source Shakespeare</h1>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr align="left" valign="top"> 
    <td align="right"> <img src="/images/o-dropcap.gif" alt="O" width="23" height="27" align="left"></td>
    <td><p class='infobodytext'>pen Source Shakespeare, like many offspring, is 
        the fruit of love and boredom. For a couple of years, the creator of OSS, 
        Eric Johnson (at right), reviewed plays for The Washington Times. He saw 
        many of Washington's first-rate productions, including those of the <a href="http://www.folger.edu/public/theater/menu.asp" target="folger"><strong>Folger 
        Theatre</strong></a> and the <a href="http://www.shakespearedc.org/" target="shakedc"><strong>Shakespeare 
        Theatre</strong></a>. Though it wasn't his full-time job, it was an interesting 
        diversion from his <strong><a href="http://www.washingtontimes.com" target="twt">normal 
        duties at the paper</a></strong>. </p>
      <p class='infobodytext'>Because he wanted to be a conscientious reviewer, 
        Eric read the play before he saw it, even if he had read it before. Being 
        an Internet-enabled kind of guy, he favored using electronic texts to 
        look up passages for the reviews (though he preferred reading from a copy 
        of G.B. Harrison's superb <a href="http://www.amazon.com/exec/obidos/tg/detail/-/0155805304/qid=1071345831/sr=1-1/ref=sr_1_1/102-8618127-5553765?v=glance&s=books"><strong><em>Shakespeare: 
        The Complete Works</em></strong></a>.) </p>
      <p class='infobodytext'>In 2001, Eric began a Shakespeare repository site, 
        just for fun. He created a rudimentary parser that fed &quot;As You Like 
        It&quot; into a database. However, the responsibilities of his day job 
        precluded turning the idea into reality. Also, his wife and children deserved 
        more attention than an interesting computer project, so the &quot;Shakespeare 
        database project,&quot; as he called it, lay fallow. </p>
      <p>&nbsp;</p>
      </td>
    <td><p align="center"><img src="/images/eric-nasiriyah.jpg" alt="Thinking about Shakespeare " width="215" height="212" border="0"><br>
        <em>Thinking about Shakespeare<br>
        while in Iraq</em></p></td>
  </tr>
  <tr align="left" valign="top">
    <td align="right"><strong><img src="../images/i-dropcap.gif" alt="I" width="23" height="27"></strong></td>
    <td><p class='infobodytext'>n the summer of 2003, Eric found himself in Kuwait, 
        with not a lot to do. During the war with Iraq, he had been attached to 
        an infantry battalion with a team of fellow Marine reservists, clearing 
        civilians away from battle areas so they wouldn't get hurt or killed. 
        After the war, they helped get our province's infrastructure up and running. 
        Then they were redeployed back to Kuwait, awaiting &quot;contingencies.&quot; 
      </p>
      <p class='infobodytext'>What are &quot;contingencies,&quot; you may ask? 
        Good question. No one figured that out. Mainly, Eric and his comrades 
        sat in a desert camp, wondering when they would be sent home. After a 
        few weeks of sitting around watching DVDs, playing &quot;<a href="http://www.praetoriansgame.com/" target="praetorians"><strong>Praetorians</strong></a>,&quot; 
        and looking at his watch, Eric decided that he would do something productive. 
        The &quot;Shakespeare database project&quot; was reborn. </p>
      <p>&nbsp;</p>
      </td>
    <td>&nbsp;</td>
  </tr>
  <tr align="left" valign="top">
    <td align="right"><strong><img src="../images/t-dropcap.gif" alt="T" width="23" height="27"></strong></td>
    <td><p class='infobodytext'>he first question he asked was, &quot;Has anyone 
        else done this before?&quot; After looking on the Web, he concluded that, 
        surprisingly, there were very few comprehensive Shakespeare Web sites 
        out there. The ones that were comprehensive were not free, and the free 
        ones were not comprehensive. The only one that was both free and comprehensive 
        was <a href="http://www.it.usyd.edu.au/%7Ematty/Shakespeare/" target="twotb"><strong>The 
        Works of the Bard</strong></a>, a venerable site with an arcane yet powerful 
        search mechanism. </p>
      <p class='infobodytext'>Eric decided that OSS had to be at least as powerful 
        as TWOTB, but with a more friendly interface. He wanted to make it useful 
        to four groups of people: </p>
      <ol>
        <li class="audiences">Scholars who either lack access to the expensive 
          commercial sites, or who want a quick way to look up passages;</li>
        <li class="audiences">Actors and directors, who would not only benefit 
          from the research tools, but could print acts, scenes, or characters' 
          lines; </li>
        <li class="audiences">Programmers who might like an example of how to 
          store, retrieve, search, and manipulate a collection of texts; and</li>
        <li class="audiences">Anyone who happened to like Shakespeare.</li>
      </ol>
      <p class='infobodytext'>With the help of a very slow Internet connection 
        &mdash; one that made a dial-up connection look speedy &mdash; he downloaded 
        Shakespeare's plays and the necessary software. These things having been 
        installed on his laptop, he started the first version of Open Source Shakespeare. 
      </p>
      <p class='infobodytext'>Sitting at one of the tables in the middle of the 
        long tent, he was frequently interrupted by curious Marines. As the Marine 
        Corps is a haven for eccentrics, they did not think it odd to see someone 
        creating a Web site in a desolate camp in one of the most God-forsaken 
        places on Earth. </p>
      <p class='playtext'><span class="infobodytext">The site progressed to the 
        point where it had all the essentials: the parser read the texts into 
        the database, which the Web site used to display the texts, search for 
        keywords, and display all of a character's lines. Open Source Shakespeare's 
        foundation had been laid. </span> </p>
      <p>&nbsp;</p>
      </td>
    <td>&nbsp;</td>
  </tr>
  <tr align="left" valign="top">
    <td align="right"><img src="../images/b-dropcap.gif" alt="B" width="23" height="27"></td>
    <td><p class='infobodytext'>esides love of Shakespeare and the boredom of 
        Camp Commando, Eric had one other motivation to complete OSS: he needed 
        a thesis to complete his master's in English at <a href="http://www.gmu.edu"><strong>George 
        Mason University</strong></a>. Because his concentration was in <strong><a href="http://www.gmu.edu/departments/english/grad/gradpwe.html">Professional 
        Writing and Editing</a></strong>, he did not necessarily have to write 
        a traditional paper in order to satisfy the thesis requirement. As of 
        this writing (December 13, 2003), the project has not been approved as 
        a thesis, but he is hopeful that it will be soon. </p>
      <p class='infobodytext'>Also as of this writing, there is a lot to do on 
        Open Source Shakespeare. The source code and database are not yet available 
        for downloading, so it is not truly &quot;open source.&quot; Strangely, 
        the simple keyword search isn't finished, but a working version of the 
        advanced search is. </p>
      <p class='infobodytext'>By the time OSS is submitted as a thesis, all of 
        the plays will be indexed to the word level, instead of to individual 
        characters' lines. That means you'll be able to click on a word and see 
        where variations of that word occur in other works, for example. Shakespeare's 
        sonnets and other poems will be included at some point, too. </p>
      <p class='infobodytext'>For now, you can e-mail the management at <a href="mailto:oss@bernini-communications.com"><strong>oss@bernini-communications.com</strong></a> 
        if you have any questions, comments, complaints, idle threats, or aspersions 
        to cast. That address will disappear in favor of a response form, as the 
        management gets too much spam right now. </p>
      <p>&nbsp;</p>
      </td>
    <td>&nbsp;</td>
  </tr>
  <tr align="left" valign="top">
    <td align="right">&nbsp;</td>
    <td><p class='infobodytext'><em>If you would like to read about OSS's technical 
        details, there's <a href="technicaldetails.php"><strong>a dedicated page 
        for that</strong></a>. News about the site <a href="news.php"><strong>is 
        posted here</strong></a>. You can search OSS using the <strong><a href="../search/search-keyword.php">simple</a></strong> 
        or <a href="../search/search-advanced.php"><strong>advanced</strong></a> 
        search functions, if you want to see how it all works, or<strong><a href="../views/plays/plays.php"> 
        browse the plays</a></strong> at your leisure. </em></p></td>
    <td>&nbsp;</td>
  </tr>
  <tr align="left" valign="top">
    <td align="right">&nbsp;</td>
    <td><p>&nbsp;</p>
      <p align="center"><strong><a href="/">Back to the main page</a></strong></p></td>
    <td>&nbsp;</td>
  </tr>
</table>
      <p>&nbsp;</p>
<?php
//include the footer, which closes the table and the document
include($includedir . "main_footer.php");
?>
