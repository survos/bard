=============================================================================================
                               README.txt for Open Source Shakespeare
                                    www.opensourceshakespeare.org
=============================================================================================
Open Source Shakespeare (OSS) is free for personal use. You may use the code and/or the 
database in your personal, non-commercial projects. Commercial use is prohibited without 
the permission of Bernini Communications LLC. Inquiries, compliments, complaints, and 
idle threats should be e-mailed to oss@bernini-communications.com. 

Below is a description of the file hierarchy for the OSS site, along with a description of 
most of the files. 

=============================================================================================
/						Home directory
---------------------------------------------------------------------------------------------
404.php					Error page
favicon.ico				Icon for Internet Explorer browsers
index.php				Front page
README.txt				This here document you're reading
robots.txt				Blank file for search engine robots, just to be polite

---------------------------------------------------------------------------------------------
/concordance			Concordance function
---------------------------------------------------------------------------------------------
findform.php			Find a word form, and display the results
index.php				Shows all the letters, with links from each to wordformlist.php
wordformlist.php		Shows all the wordforms that begin with a particular letter

---------------------------------------------------------------------------------------------
/concordance/o
---------------------------------------------------------------------------------------------
index.php				Shows the instances of one word form, grouped by work

---------------------------------------------------------------------------------------------
/downloads				OSS files available for downloading
---------------------------------------------------------------------------------------------
index.php				Description of each file
oss-lite.zip			Microsoft Access database, without the stemmed or phonetic paragraphs
oss-textdb.zip			Text database, with the stemmed or phonetic paragraphs
oss-www.tar.gz			The OSS site codebase, from which you got this file
oss.zip					Microsoft Access database, with the stemmed or phonetic paragraphs

---------------------------------------------------------------------------------------------
/images					Various images
---------------------------------------------------------------------------------------------
*						

---------------------------------------------------------------------------------------------
/inc					Various include files
---------------------------------------------------------------------------------------------
dbconnect.php			Connects to the db (password has been changed to "xxx" for security)
main_footer.php			Bottom of all the pages
main_header.php			Top of all the pages
navbar.htm				The navigation bar that appears at the top and bottom of the pages

---------------------------------------------------------------------------------------------
/info					Information about the site 
---------------------------------------------------------------------------------------------
aboutsite.php			About the site
links.php				Links to other Shakespeare databases
news.php				Site news (will be outdated -- live site is updated with Blogger)
technicaldetails.php	Shows the technologies and techniques used to build OSS

---------------------------------------------------------------------------------------------
/info/reviews
---------------------------------------------------------------------------------------------
*						Reviews of plays by the management

---------------------------------------------------------------------------------------------
/search
---------------------------------------------------------------------------------------------
search-advanced.php		Advanced search function
search-keyword.php		Keyword search function
search-results.php		Search results, taking user data from multiple pages

---------------------------------------------------------------------------------------------
/styles
---------------------------------------------------------------------------------------------
oss-main.css			Main stylesheet

---------------------------------------------------------------------------------------------
/views					Root directory for viewing works
---------------------------------------------------------------------------------------------
*

---------------------------------------------------------------------------------------------
/views/plays			Play viewing
---------------------------------------------------------------------------------------------
playmenu.php			Shows the menu for an individual play
plays_alpha.php			List plays alphabetically by name
plays_date.php			List plays in chronological order
plays_numlines.php		List plays by number of lines in each play, in descending order
plays.php				List plays by genre (default view)
scene_render.php		Display scene from a play
scene_view.php			Wrapper for scene_render.php

---------------------------------------------------------------------------------------------
/views/plays/characters	Character functions
---------------------------------------------------------------------------------------------
charlines.php			Show all lines from one play's character

---------------------------------------------------------------------------------------------
/views/poems			Poems
---------------------------------------------------------------------------------------------
poems.php				List poems alphabetically
poem_view.php			View one poem

---------------------------------------------------------------------------------------------
/views/sonnets			Sonnets
---------------------------------------------------------------------------------------------
sonnet_render.php		Display one sonnet
sonnets.php				Index page for showing the sonnets various ways
sonnet_view.php			Wrapper for sonnet_render.php