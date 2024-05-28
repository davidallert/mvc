<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240525185920 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE room ADD COLUMN forward_room_id INTEGER DEFAULT NULL');
        $this->addSql('ALTER TABLE room ADD COLUMN backward_room_id INTEGER DEFAULT NULL');
        $this->addSql('ALTER TABLE room ADD COLUMN left_room_id INTEGER DEFAULT NULL');
        $this->addSql('ALTER TABLE room ADD COLUMN right_room_id INTEGER DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__room AS SELECT id, background, story FROM room');
        $this->addSql('DROP TABLE room');
        $this->addSql('CREATE TABLE room (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, background VARCHAR(255) NOT NULL, story CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO room (id, background, story) SELECT id, background, story FROM __temp__room');
        $this->addSql('DROP TABLE __temp__room');
    }
}
