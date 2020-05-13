# MySQL To SQLite and Doctrine Entities

The process:

* Download the .zipped database dump, and unzip it.
* Import the data into sqlite or mysql
* Configure the environment to point to the database.
* Inspect each table and create an entity and the same proprties.
* Map the field names, which are capitalized in the database :-(, to the properties.
* Drop the tables that are no longer needed.

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
        
Now we no longer need the Word tables, and they take up a lot of space

    bin/console doctrine:query:sql "DROP TABLE Words"    
    bin/console doctrine:query:sql "DROP TABLE WordForms" 
    
This process generates the same sqlite database on s3 that is 