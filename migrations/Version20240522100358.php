<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240522100358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__character AS SELECT id, health, name, bag FROM character');
        $this->addSql('DROP TABLE character');
        $this->addSql('CREATE TABLE character (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, health INTEGER NOT NULL, name VARCHAR(255) NOT NULL UNIQUE, bag CLOB NOT NULL)');
        $this->addSql('INSERT INTO character (id, health, name, bag) SELECT id, health, name, bag FROM __temp__character');
        $this->addSql('DROP TABLE __temp__character');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__character AS SELECT id, health, name, bag FROM character');
        $this->addSql('DROP TABLE character');
        $this->addSql('CREATE TABLE character (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, health INTEGER NOT NULL, name VARCHAR(255) NOT NULL, bag CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO character (id, health, name, bag) SELECT id, health, name, bag FROM __temp__character');
        $this->addSql('DROP TABLE __temp__character');
    }
}
