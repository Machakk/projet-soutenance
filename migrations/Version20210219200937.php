<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210219200937 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_forum ADD metier_id INT NOT NULL');
        $this->addSql('ALTER TABLE post_forum ADD CONSTRAINT FK_12303222ED16FA20 FOREIGN KEY (metier_id) REFERENCES metiers (id)');
        $this->addSql('CREATE INDEX IDX_12303222ED16FA20 ON post_forum (metier_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_forum DROP FOREIGN KEY FK_12303222ED16FA20');
        $this->addSql('DROP INDEX IDX_12303222ED16FA20 ON post_forum');
        $this->addSql('ALTER TABLE post_forum DROP metier_id');
    }
}
