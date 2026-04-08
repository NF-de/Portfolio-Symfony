<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260402123213 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__formations AS SELECT id, titre, etablissement, description, date_debut, date_fin, ville, image, rapport_pdf FROM formations');
        $this->addSql('DROP TABLE formations');
        $this->addSql('CREATE TABLE formations (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, etablissement VARCHAR(255) DEFAULT NULL, description CLOB DEFAULT NULL, date_debut DATE DEFAULT NULL, date_fin DATE DEFAULT NULL, ville VARCHAR(100) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, rapport_pdf VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO formations (id, titre, etablissement, description, date_debut, date_fin, ville, image, rapport_pdf) SELECT id, titre, etablissement, description, date_debut, date_fin, ville, image, rapport_pdf FROM __temp__formations');
        $this->addSql('DROP TABLE __temp__formations');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__formations AS SELECT id, titre, etablissement, description, date_debut, date_fin, ville, image, rapport_pdf FROM formations');
        $this->addSql('DROP TABLE formations');
        $this->addSql('CREATE TABLE formations (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, etablissement VARCHAR(255) DEFAULT NULL, description CLOB DEFAULT NULL, date_debut DATE DEFAULT NULL, date_fin DATE DEFAULT NULL, ville VARCHAR(100) DEFAULT NULL, image VARCHAR(255) NOT NULL, rapport_pdf VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO formations (id, titre, etablissement, description, date_debut, date_fin, ville, image, rapport_pdf) SELECT id, titre, etablissement, description, date_debut, date_fin, ville, image, rapport_pdf FROM __temp__formations');
        $this->addSql('DROP TABLE __temp__formations');
    }
}
