<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210910125743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE User_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE Chapters (ChapterID VARCHAR(255) NOT NULL, Section INT NOT NULL, Chapter VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, WorkID VARCHAR(255) NOT NULL, PRIMARY KEY(ChapterID))');
        $this->addSql('CREATE INDEX IDX_3E5721276E954463 ON Chapters (WorkID)');
        $this->addSql('CREATE INDEX chapter_idx ON Chapters (ChapterId)');
        $this->addSql('COMMENT ON COLUMN Chapters.WorkID IS \'String identifier from MySQL database\'');
        $this->addSql('CREATE TABLE Characters (CharID VARCHAR(255) NOT NULL, CharName VARCHAR(48) NOT NULL, Description VARCHAR(255) NOT NULL, PRIMARY KEY(CharID))');
        $this->addSql('CREATE TABLE GutenbergBook (id INT NOT NULL, title VARCHAR(255) NOT NULL, rdf TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE Paragraphs (ParagraphID VARCHAR(255) NOT NULL, PlainText TEXT DEFAULT NULL, Section INT NOT NULL, CharID VARCHAR(32) DEFAULT NULL, ParagraphType VARCHAR(1) DEFAULT NULL, WorkID VARCHAR(255) NOT NULL, Chapter VARCHAR(255) DEFAULT NULL, PRIMARY KEY(ParagraphID))');
        $this->addSql('CREATE INDEX IDX_F7921F376E954463 ON Paragraphs (WorkID)');
        $this->addSql('CREATE INDEX IDX_F7921F37363C8CB2 ON Paragraphs (Chapter)');
        $this->addSql('COMMENT ON COLUMN Paragraphs.WorkID IS \'String identifier from MySQL database\'');
        $this->addSql('CREATE TABLE "User" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, isVerified BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2DA17977E7927C74 ON "User" (email)');
        $this->addSql('CREATE TABLE Works (WorkID VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, LongTitle VARCHAR(255) DEFAULT NULL, ShortTitle VARCHAR(255) NOT NULL, source VARCHAR(32) DEFAULT NULL, totalWords INT NOT NULL, totalParagraphs INT NOT NULL, GenreType VARCHAR(1) DEFAULT NULL, Date INT NOT NULL, PRIMARY KEY(WorkID))');
        $this->addSql('COMMENT ON COLUMN Works.WorkID IS \'String identifier from MySQL database\'');
        $this->addSql('ALTER TABLE Chapters ADD CONSTRAINT FK_3E5721276E954463 FOREIGN KEY (WorkID) REFERENCES Works (WorkID) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE Paragraphs ADD CONSTRAINT FK_F7921F376E954463 FOREIGN KEY (WorkID) REFERENCES Works (WorkID) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE Paragraphs ADD CONSTRAINT FK_F7921F37363C8CB2 FOREIGN KEY (Chapter) REFERENCES Chapters (ChapterID) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE Paragraphs DROP CONSTRAINT FK_F7921F37363C8CB2');
        $this->addSql('ALTER TABLE Chapters DROP CONSTRAINT FK_3E5721276E954463');
        $this->addSql('ALTER TABLE Paragraphs DROP CONSTRAINT FK_F7921F376E954463');
        $this->addSql('DROP SEQUENCE User_id_seq CASCADE');
        $this->addSql('DROP TABLE Chapters');
        $this->addSql('DROP TABLE Characters');
        $this->addSql('DROP TABLE GutenbergBook');
        $this->addSql('DROP TABLE Paragraphs');
        $this->addSql('DROP TABLE "User"');
        $this->addSql('DROP TABLE Works');
    }
}
