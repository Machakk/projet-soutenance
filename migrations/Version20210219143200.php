<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210219143200 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users ADD pseudo VARCHAR(255) NOT NULL, ADD niveau VARCHAR(255) NOT NULL, ADD fichier VARCHAR(255) DEFAULT NULL, ADD linksite VARCHAR(255) DEFAULT NULL, ADD linkgit VARCHAR(255) DEFAULT NULL, ADD linkfacebook VARCHAR(255) DEFAULT NULL, ADD linkedin VARCHAR(255) DEFAULT NULL, ADD imgprofil VARCHAR(255) DEFAULT NULL, ADD description VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP pseudo, DROP niveau, DROP fichier, DROP linksite, DROP linkgit, DROP linkfacebook, DROP linkedin, DROP imgprofil, DROP description');
    }
}
