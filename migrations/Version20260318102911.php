<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260318102911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__projets AS SELECT id, titre, description, technologies, lien_demo, lien_github, image, date_creation, en_vedette, rapport_pdf FROM projets');
        $this->addSql('DROP TABLE projets');
        $this->addSql('CREATE TABLE projets (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description CLOB NOT NULL, technologies VARCHAR(255) DEFAULT NULL, lien_demo VARCHAR(255) DEFAULT NULL, lien_github VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, date_creation DATE DEFAULT NULL, en_vedette BOOLEAN NOT NULL, rapport_pdf VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO projets (id, titre, description, technologies, lien_demo, lien_github, image, date_creation, en_vedette, rapport_pdf) SELECT id, titre, description, technologies, lien_demo, lien_github, image, date_creation, en_vedette, rapport_pdf FROM __temp__projets');
        $this->addSql('DROP TABLE __temp__projets');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__projets AS SELECT id, titre, description, technologies, lien_demo, lien_github, image, date_creation, rapport_pdf, en_vedette FROM projets');
        $this->addSql('DROP TABLE projets');
        $this->addSql('CREATE TABLE projets (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description CLOB NOT NULL, technologies VARCHAR(255) DEFAULT NULL, lien_demo VARCHAR(255) DEFAULT NULL, lien_github VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, date_creation DATE NOT NULL, rapport_pdf VARCHAR(255) DEFAULT NULL, en_vedette BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO projets (id, titre, description, technologies, lien_demo, lien_github, image, date_creation, rapport_pdf, en_vedette) SELECT id, titre, description, technologies, lien_demo, lien_github, image, date_creation, rapport_pdf, en_vedette FROM __temp__projets');
        $this->addSql('DROP TABLE __temp__projets');
    }
}
