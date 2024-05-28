<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240522094109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE character ADD COLUMN bag CLOB');
        $this->addSql('CREATE TEMPORARY TABLE __temp__item AS SELECT id, name, x, y, image_url, room_id, rotation FROM item');
        $this->addSql('DROP TABLE item');
        $this->addSql('CREATE TABLE item (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, x INTEGER NOT NULL, y INTEGER NOT NULL, image_url CLOB DEFAULT NULL, room_id INTEGER DEFAULT NULL, rotation INTEGER NOT NULL)');
        $this->addSql('INSERT INTO item (id, name, x, y, image_url, room_id, rotation) SELECT id, name, x, y, image_url, room_id, rotation FROM __temp__item');
        $this->addSql('DROP TABLE __temp__item');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__character AS SELECT id, health, name FROM character');
        $this->addSql('DROP TABLE character');
        $this->addSql('CREATE TABLE character (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, health INTEGER NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO character (id, health, name) SELECT id, health, name FROM __temp__character');
        $this->addSql('DROP TABLE __temp__character');
        $this->addSql('CREATE TEMPORARY TABLE __temp__item AS SELECT id, name, x, y, rotation, image_url, room_id FROM item');
        $this->addSql('DROP TABLE item');
        $this->addSql('CREATE TABLE item (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, x INTEGER NOT NULL, y INTEGER NOT NULL, rotation INTEGER DEFAULT NULL, image_url CLOB DEFAULT NULL, room_id INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO item (id, name, x, y, rotation, image_url, room_id) SELECT id, name, x, y, rotation, image_url, room_id FROM __temp__item');
        $this->addSql('DROP TABLE __temp__item');
    }
}
