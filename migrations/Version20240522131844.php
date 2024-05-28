<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240522131844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__bag AS SELECT id, serialized_items FROM bag');
        $this->addSql('DROP TABLE bag');
        $this->addSql('CREATE TABLE bag (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, character_id INTEGER DEFAULT NULL, serialized_items CLOB DEFAULT NULL --(DC2Type:json)
        , CONSTRAINT FK_1B2268411136BE75 FOREIGN KEY (character_id) REFERENCES character (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO bag (id, serialized_items) SELECT id, serialized_items FROM __temp__bag');
        $this->addSql('DROP TABLE __temp__bag');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1B2268411136BE75 ON bag (character_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__bag AS SELECT id, serialized_items FROM bag');
        $this->addSql('DROP TABLE bag');
        $this->addSql('CREATE TABLE bag (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, serialized_items CLOB DEFAULT NULL --(DC2Type:json)
        )');
        $this->addSql('INSERT INTO bag (id, serialized_items) SELECT id, serialized_items FROM __temp__bag');
        $this->addSql('DROP TABLE __temp__bag');
    }
}
