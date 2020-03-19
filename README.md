# bard
http://opensourceshakespeare.com/ rewritten to use Symfony5 and SQLite, in order to produce the plays in .fountain format

## Local Setup

### SQLite

Unzip the mysql database, convert it to sqlite sql and import it.

    unzip ~/Downloads/shakespeare-oss-db-full.zip 
    # source: https://stackoverflow.com/questions/3890518/convert-mysql-to-sqlite
    bin/mysqltosqlite ~/Downloads/oss-db-full.sql > bard.sql
    sqlite3 var/data.db < bard.sql

####  Configure .env.local

    DATABASE_URL=sqlite:///%kernel.project_dir%/var/data.db

### MySQL/MariaDB

Alternatively, load it to a local MySQL database

Create a mysql database and load the .sql

    mysql -u root
    create database bard;
    CREATE USER 'william'@'localhost' IDENTIFIED BY 'hamlet';
    grant ALL on *.* to 'william'@'localhost';
    \q
    
     mysql -u william -p -D bard < data/oss-db-full.sql
     
####  Configure .env.local

      DATABASE_URL=mysql://william:hamlet@127.0.0.1:3306/bard?serverVersion=5.7
       
## Reset chapter reference

The database isn't properly normalized for Chapters, so this utility fixes that.

    bin/console doctrine:schema:update --dump-sql --force
    bin/console app:fix-database --chapters
    
Heroku doesn't support sqlite, and the free databases are limited to 10,000 rows.  There are over 35,000 paragraphs, so we need to merge those paragraphs into each chapter (a "scene" in other systems).

  @removed since sqlite works 
  
    bin/console app:fix-database --paragraphs
    
Now we no longer need the Word tables

    bin/console doctrine:query:sql "DROP TABLE Words"    
    bin/console doctrine:query:sql "DROP TABLE WordForms" 
    
## Full-text search

For full-text search, we'll use ElasticSearch, since it's free on Heroku.  Unforunately, FOSElasticBundle doesn't work with ES7, so we'll use the lower-level runfin/elastica library.  Good opportunity to exercise the new features!

    composer require ruflin/elastica:dev-master
    
Of course, we should be using docker at this point, to install ElasticSearch.  Someday.  For now, install ES7 locally. (https://linuxize.com/post/how-to-install-elasticsearch-on-ubuntu-18-04/)

### Building the index

Quick and Easy: Use a controller to go through the works and index them.    
       
## Step-by-Step Rebuilding Tutorial

Here are the steps to rebuild this application from scratch.  Note that Survos/LandingBundle does a lot of the setup.  Follow the README there to get to the point of having a Symfony application with a landing page.

Then follow the instructions above to convert the database to SQLite and set the .env DATABASE_URL to the sqlite file.

At this point, you can run

     bin/console doctrine:query:sql "select count(*) from Works"
     
 I then inspected the fields of each table to create the ORM entities.
 
     bin/console make:entity Work
     
 Since I didn't want the plural entities names, I had to go into the Work.php file and set @ORM\Table(name="Works") to get the right table name.  I also had to add the capitalized name to the fields, though there's probably a way to configure the doctrine name method, but I gave up trying to figure it out.
 
I also changed the "extends" in the Word table to use SurvosBaseEntity.  This gives access to a RP (RouteParameters) method that makes it much easier to use slugs instead of numeric ids for the routes.  It requires getUniqueIdentifiers to be defined (in this case, id IS the slug, not an integer).

```php
    function getUniqueIdentifiers()
    {
        return ['id' => $this->getId()];
    }
``` 
 
 To browse the database, install easyadmin and configure it to point to the tables:
 
     composer req admin
     bin/console survos:confgure easyadmin (@TODO!!)
     
 This inspects the ORM and creates 
 
 ```yaml
 easy_admin:
     design:
         menu:
             - { label: 'Homepage', route: 'app_homepage', rel: 'index' }
             - { entity: Work }
             - { entity: Chapter }
             - { entity: Paragraph }
             - { entity: Character }
         # ...
 
     entities:
         # List the entity class name you want to manage
         - App\Entity\Work
         - App\Entity\Chapter
         - App\Entity\Paragraph
         - App\Entity\Character
```
     
Let's install datatables to make it easy to find a play.    

    yarn add datatables.net-bs4
    
And create a basic controller to display the works

     bin/console make:controller AppController
     
 Change the index method and template.  Since we want a datatable with search and sort, we'll change app.js to call the datatable.  There's a lot more than can be done with datatables, though.
 
 We want to display the play in both fountain format, so we create AppService to do the work.
 
 ```php
    public function workToFountain(Work $work): string
    {
        foreach ($work->getChapters() as $chapter) {
            $this->push('.' . $chapter->getDescription(), true);
            foreach ($chapter->getParagraphs() as $paragraph) {
                $this->push(strtoupper($paragraph->getCharId()));

         etc

```
  
 Create the methods in AppController, and add the links in index.
 
 ## Add the API
 
     composer req api
     
 Update the Work.php entity with ApiPlatform

```php
  * @ApiResource(
  *     normalizationContext={"groups"={"read"}},
  *     denormalizationContext={"groups"={"write"}}
  * ) */

```
 
 ## Add DataTables
 
     yarn add datatables.net-bs4
     
Other sources

http://www.gutenberg.org/files/53734/53734-0.txt

http://www.gutenberg.org/ebooks/subject/3360
http://www.gutenberg.org/wiki/Gutenberg:Terms_of_Use
https://www.hesherman.com/2018/12/20/setting-free-the-plays-of-1923/
https://library.owu.edu/playsinthepublicdomain
http://es.feedbooks.com/books?category=FBDRA000000
https://www.systemeyescomputerstore.com/scripts/Children_of_Eden/index.html
 
 ## Deploying to Heroku
 
Modify composer.json to enable pdo sqlite (not just ext-sqlite, which is enabled by default):
 
    composer req ext-pdo_sqlite:"*"
    composer req ext-sqlite3:"*"

 
 We now have 
  