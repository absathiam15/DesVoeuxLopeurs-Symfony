<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200703153808 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE batiment (id INT AUTO_INCREMENT NOT NULL, num_batiment VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bourse (id INT AUTO_INCREMENT NOT NULL, bourse VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chambre (id INT AUTO_INCREMENT NOT NULL, num_batiment_id INT DEFAULT NULL, num_chambre VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_C509E4FFAC13C4F3 (num_batiment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant (id INT AUTO_INCREMENT NOT NULL, num_chambre_id INT DEFAULT NULL, bourse_id INT DEFAULT NULL, matricule VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, tel INT NOT NULL, date_naiss DATE NOT NULL, adresse VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_717E22E314003FDF (num_chambre_id), INDEX IDX_717E22E34E67DDD1 (bourse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chambre ADD CONSTRAINT FK_C509E4FFAC13C4F3 FOREIGN KEY (num_batiment_id) REFERENCES batiment (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E314003FDF FOREIGN KEY (num_chambre_id) REFERENCES chambre (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E34E67DDD1 FOREIGN KEY (bourse_id) REFERENCES bourse (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chambre DROP FOREIGN KEY FK_C509E4FFAC13C4F3');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E34E67DDD1');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E314003FDF');
        $this->addSql('DROP TABLE batiment');
        $this->addSql('DROP TABLE bourse');
        $this->addSql('DROP TABLE chambre');
        $this->addSql('DROP TABLE etudiant');
    }
}
