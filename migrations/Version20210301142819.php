<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210301142819 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users_skills (users_id INT NOT NULL, skills_id INT NOT NULL, INDEX IDX_DAD698E067B3B43D (users_id), INDEX IDX_DAD698E07FF61858 (skills_id), PRIMARY KEY(users_id, skills_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_skills ADD CONSTRAINT FK_DAD698E067B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_skills ADD CONSTRAINT FK_DAD698E07FF61858 FOREIGN KEY (skills_id) REFERENCES skills (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE skills_users');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE skills_users (skills_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_B9EC4E897FF61858 (skills_id), INDEX IDX_B9EC4E8967B3B43D (users_id), PRIMARY KEY(skills_id, users_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE skills_users ADD CONSTRAINT FK_B9EC4E8967B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skills_users ADD CONSTRAINT FK_B9EC4E897FF61858 FOREIGN KEY (skills_id) REFERENCES skills (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE users_skills');
    }
}
