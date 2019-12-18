# bard
http://opensourceshakespeare.com/ rewritten to use Symfony5 and SQLite, in order to produce the plays in .fountain format

## Local Setup

Unzip the mysql database, convert it to sqlite sql and import it.

    unzip ~/Downloads/shakespeare-oss-db-full.zip 
    bin/mysqltosqlite ~/Downloads/oss-db-full.sql > bard.sql
    sqlite3 var/data.db < bard.sql

Alterntively, load it to a local MySQL database

Create a mysql database and load the .sql

    mysql -u root
    create database bard;
    CREATE USER 'william'@'localhost' IDENTIFIED BY 'hamlet';
    grant ALL on *.* to 'william'@'localhost';
    \q
    
     mysql -u william -p -D bard < data/oss-db-full.sql

##  Configure .env.local

    # DATABASE_URL=sqlite:///%kernel.project_dir%/var/data.db
      DATABASE_URL=mysql://william:hamlet@127.0.0.1:3306/bard?serverVersion=5.7
       
## Reset chapter reference

The chapter table isn't normalized as expected.  Fix it by adding ?fix to the index page 

    