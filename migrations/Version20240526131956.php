<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240526131956 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item ADD COLUMN opacity DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__item AS SELECT id, name, x, y, rotation, image_url, room_id, interaction, usage, visibility FROM item');
        $this->addSql('DROP TABLE item');
        $this->addSql('CREATE TABLE item (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, x INTEGER NOT NULL, y INTEGER NOT NULL, rotation INTEGER NOT NULL, image_url CLOB DEFAULT NULL, room_id INTEGER DEFAULT NULL, interaction VARCHAR(255) NOT NULL, usage VARCHAR(255) NOT NULL, visibility BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO item (id, name, x, y, rotation, image_url, room_id, interaction, usage, visibility) SELECT id, name, x, y, rotation, image_url, room_id, interaction, usage, visibility FROM __temp__item');
        $this->addSql('DROP TABLE __temp__item');
    }
}
