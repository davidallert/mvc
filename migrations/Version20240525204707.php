<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240525204707 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE room ADD COLUMN completed BOOLEAN DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__room AS SELECT id, background, story, forward_room_id, backward_room_id, left_room_id, right_room_id FROM room');
        $this->addSql('DROP TABLE room');
        $this->addSql('CREATE TABLE room (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, background VARCHAR(255) NOT NULL, story CLOB DEFAULT NULL, forward_room_id INTEGER DEFAULT NULL, backward_room_id INTEGER DEFAULT NULL, left_room_id INTEGER DEFAULT NULL, right_room_id INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO room (id, background, story, forward_room_id, backward_room_id, left_room_id, right_room_id) SELECT id, background, story, forward_room_id, backward_room_id, left_room_id, right_room_id FROM __temp__room');
        $this->addSql('DROP TABLE __temp__room');
    }
}
