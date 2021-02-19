<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210219195502 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE metiers (id INT AUTO_INCREMENT NOT NULL, metier VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE articles ADD metier_id INT NOT NULL');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168ED16FA20 FOREIGN KEY (metier_id) REFERENCES metiers (id)');
        $this->addSql('CREATE INDEX IDX_BFDD3168ED16FA20 ON articles (metier_id)');
        $this->addSql('ALTER TABLE users ADD metier_id INT NOT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9ED16FA20 FOREIGN KEY (metier_id) REFERENCES metiers (id)');
        $this->addSql('CREATE INDEX IDX_1483A5E9ED16FA20 ON users (metier_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168ED16FA20');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9ED16FA20');
        $this->addSql('DROP TABLE metiers');
        $this->addSql('DROP INDEX IDX_BFDD3168ED16FA20 ON articles');
        $this->addSql('ALTER TABLE articles DROP metier_id');
        $this->addSql('DROP INDEX IDX_1483A5E9ED16FA20 ON users');
        $this->addSql('ALTER TABLE users DROP metier_id');
    }
}
