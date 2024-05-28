<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240523094859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE character ADD COLUMN current_room INTEGER');
        $this->addSql('CREATE TEMPORARY TABLE __temp__item AS SELECT id, name, x, y, image_url, room_id, rotation, interaction, usage, visibility FROM item');
        $this->addSql('DROP TABLE item');
        $this->addSql('CREATE TABLE item (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, x INTEGER NOT NULL, y INTEGER NOT NULL, image_url CLOB DEFAULT NULL, room_id INTEGER DEFAULT NULL, rotation INTEGER NOT NULL, interaction VARCHAR(255) NOT NULL, usage VARCHAR(255), visibility BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO item (id, name, x, y, image_url, room_id, rotation, interaction, usage, visibility) SELECT id, name, x, y, image_url, room_id, rotation, interaction, usage, visibility FROM __temp__item');
        $this->addSql('DROP TABLE __temp__item');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__character AS SELECT id, bag_id, health, name FROM character');
        $this->addSql('DROP TABLE character');
        $this->addSql('CREATE TABLE character (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, bag_id INTEGER DEFAULT NULL, health INTEGER NOT NULL, name VARCHAR(255) NOT NULL, CONSTRAINT FK_937AB0346F5D8297 FOREIGN KEY (bag_id) REFERENCES bag (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO character (id, bag_id, health, name) SELECT id, bag_id, health, name FROM __temp__character');
        $this->addSql('DROP TABLE __temp__character');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_937AB0346F5D8297 ON character (bag_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__item AS SELECT id, name, x, y, rotation, image_url, room_id, interaction, usage, visibility FROM item');
        $this->addSql('DROP TABLE item');
        $this->addSql('CREATE TABLE item (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, x INTEGER NOT NULL, y INTEGER NOT NULL, rotation INTEGER NOT NULL, image_url CLOB DEFAULT NULL, room_id INTEGER DEFAULT NULL, interaction VARCHAR(255) DEFAULT NULL, usage VARCHAR(255) DEFAULT NULL, visibility BOOLEAN DEFAULT NULL)');
        $this->addSql('INSERT INTO item (id, name, x, y, rotation, image_url, room_id, interaction, usage, visibility) SELECT id, name, x, y, rotation, image_url, room_id, interaction, usage, visibility FROM __temp__item');
        $this->addSql('DROP TABLE __temp__item');
    }
}
