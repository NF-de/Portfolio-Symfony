<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260316103233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, contenu CLOB NOT NULL, created_at DATETIME DEFAULT NULL, auteur_id_id INTEGER NOT NULL, commentaire_id INTEGER NOT NULL, CONSTRAINT FK_23A0E6675F8742E FOREIGN KEY (auteur_id_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_23A0E66BA9CD190 FOREIGN KEY (commentaire_id) REFERENCES commentaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_23A0E6675F8742E ON article (auteur_id_id)');
        $this->addSql('CREATE INDEX IDX_23A0E66BA9CD190 ON article (commentaire_id)');
        $this->addSql('CREATE TABLE commentaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contenu CLOB NOT NULL, created_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE TABLE competences (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, niveau INTEGER DEFAULT NULL, categorie VARCHAR(50) DEFAULT NULL, icone VARCHAR(50) DEFAULT NULL)');
        $this->addSql('CREATE TABLE experiences (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, poste VARCHAR(255) NOT NULL, entreprise VARCHAR(255) DEFAULT NULL, description CLOB DEFAULT NULL, type VARCHAR(50) DEFAULT NULL, date_debut DATE DEFAULT NULL, date_fin DATE DEFAULT NULL)');
        $this->addSql('CREATE TABLE formations (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, etablissement VARCHAR(255) DEFAULT NULL, description CLOB DEFAULT NULL, date_debut DATE DEFAULT NULL, date_fin DATE DEFAULT NULL, ville VARCHAR(100) DEFAULT NULL)');
        $this->addSql('CREATE TABLE projets (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description CLOB NOT NULL, technologies VARCHAR(255) DEFAULT NULL, lien_demo VARCHAR(255) DEFAULT NULL, lien_github VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, date_creation DATE NOT NULL, en_vedette BOOLEAN NOT NULL)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, commentaire_id INTEGER NOT NULL, CONSTRAINT FK_8D93D649BA9CD190 FOREIGN KEY (commentaire_id) REFERENCES commentaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_8D93D649BA9CD190 ON user (commentaire_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
        $this->addSql('CREATE TABLE veille_technologique (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description CLOB NOT NULL, url_source VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, date_publication DATETIME DEFAULT NULL)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 ON messenger_messages (queue_name, available_at, delivered_at, id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE competences');
        $this->addSql('DROP TABLE experiences');
        $this->addSql('DROP TABLE formations');
        $this->addSql('DROP TABLE projets');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE veille_technologique');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
