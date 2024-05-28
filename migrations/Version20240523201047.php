<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240523201047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__character AS SELECT id, bag_id, health, name, current_room FROM character');
        $this->addSql('DROP TABLE character');
        $this->addSql('CREATE TABLE character (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, bag_id INTEGER DEFAULT NULL, health INTEGER NOT NULL, name VARCHAR(255) NOT NULL, current_room INTEGER DEFAULT 1 NOT NULL, CONSTRAINT FK_937AB0346F5D8297 FOREIGN KEY (bag_id) REFERENCES bag (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO character (id, bag_id, health, name, current_room) SELECT id, bag_id, health, name, current_room FROM __temp__character');
        $this->addSql('DROP TABLE __temp__character');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_937AB0346F5D8297 ON character (bag_id)');
        $this->addSql('ALTER TABLE room ADD COLUMN story CLOB DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__character AS SELECT id, bag_id, health, name, current_room FROM character');
        $this->addSql('DROP TABLE character');
        $this->addSql('CREATE TABLE character (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, bag_id INTEGER DEFAULT NULL, health INTEGER NOT NULL, name VARCHAR(255) NOT NULL, current_room INTEGER DEFAULT 1, CONSTRAINT FK_937AB0346F5D8297 FOREIGN KEY (bag_id) REFERENCES bag (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO character (id, bag_id, health, name, current_room) SELECT id, bag_id, health, name, current_room FROM __temp__character');
        $this->addSql('DROP TABLE __temp__character');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_937AB0346F5D8297 ON character (bag_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__room AS SELECT id, background FROM room');
        $this->addSql('DROP TABLE room');
        $this->addSql('CREATE TABLE room (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, background VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO room (id, background) SELECT id, background FROM __temp__room');
        $this->addSql('DROP TABLE __temp__room');
    }
}
