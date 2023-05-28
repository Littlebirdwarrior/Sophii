<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230528215517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activite (id INT AUTO_INCREMENT NOT NULL, groupeconsignes_id INT DEFAULT NULL, titre VARCHAR(150) NOT NULL, validation TINYINT(1) NOT NULL, INDEX IDX_B875551532465C36 (groupeconsignes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activite_feuille_route (activite_id INT NOT NULL, feuille_route_id INT NOT NULL, INDEX IDX_6EF2BF3D9B0F88B1 (activite_id), INDEX IDX_6EF2BF3DAC0556AA (feuille_route_id), PRIMARY KEY(activite_id, feuille_route_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activite_groupe_competences (activite_id INT NOT NULL, groupe_competences_id INT NOT NULL, INDEX IDX_E7CBAD469B0F88B1 (activite_id), INDEX IDX_E7CBAD46C1218EC1 (groupe_competences_id), PRIMARY KEY(activite_id, groupe_competences_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bulletin (id INT AUTO_INCREMENT NOT NULL, niveau_id INT DEFAULT NULL, trimeste INT NOT NULL, INDEX IDX_2B7D8942B3E9C81 (niveau_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bulletin_groupe_competences (bulletin_id INT NOT NULL, groupe_competences_id INT NOT NULL, INDEX IDX_A0016ADAD1AAB236 (bulletin_id), INDEX IDX_A0016ADAC1218EC1 (groupe_competences_id), PRIMARY KEY(bulletin_id, groupe_competences_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, groupecompetences_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, acquisition TINYINT(1) NOT NULL, INDEX IDX_94D4687F9545A4ED (groupecompetences_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consigne (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, validation TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consigne_groupe_consignes (consigne_id INT NOT NULL, groupe_consignes_id INT NOT NULL, INDEX IDX_720806A58C063686 (consigne_id), INDEX IDX_720806A59F75AFC2 (groupe_consignes_id), PRIMARY KEY(consigne_id, groupe_consignes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eleve (id INT AUTO_INCREMENT NOT NULL, famille_id INT DEFAULT NULL, classe_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, nom_usage VARCHAR(50) NOT NULL, genre VARCHAR(1) DEFAULT NULL, anniversaire DATETIME DEFAULT NULL, droit_image TINYINT(1) NOT NULL, INDEX IDX_ECA105F797A77B84 (famille_id), INDEX IDX_ECA105F78F5EA509 (classe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enseignant (id INT AUTO_INCREMENT NOT NULL, classe_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, nom_usage VARCHAR(50) NOT NULL, mail VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL, tel VARCHAR(13) NOT NULL, UNIQUE INDEX UNIQ_81A72FA18F5EA509 (classe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE famille (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feuille_route (id INT AUTO_INCREMENT NOT NULL, eleve_id INT DEFAULT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, semaine INT DEFAULT NULL, validation TINYINT(1) NOT NULL, INDEX IDX_6EB74052A6CC7B2 (eleve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_competences (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(150) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_consignes (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parent_eleve (id INT AUTO_INCREMENT NOT NULL, famille_id INT DEFAULT NULL, authorite TINYINT(1) NOT NULL, qualite VARCHAR(7) NOT NULL, nom VARCHAR(50) NOT NULL, nom_usage VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, profession VARCHAR(50) NOT NULL, situation_familiale INT NOT NULL, adresse VARCHAR(100) DEFAULT NULL, cp VARCHAR(10) NOT NULL, ville VARCHAR(100) NOT NULL, mail VARCHAR(100) NOT NULL, tel VARCHAR(13) NOT NULL, password VARCHAR(255) NOT NULL, INDEX IDX_2090915497A77B84 (famille_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B875551532465C36 FOREIGN KEY (groupeconsignes_id) REFERENCES groupe_consignes (id)');
        $this->addSql('ALTER TABLE activite_feuille_route ADD CONSTRAINT FK_6EF2BF3D9B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activite_feuille_route ADD CONSTRAINT FK_6EF2BF3DAC0556AA FOREIGN KEY (feuille_route_id) REFERENCES feuille_route (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activite_groupe_competences ADD CONSTRAINT FK_E7CBAD469B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activite_groupe_competences ADD CONSTRAINT FK_E7CBAD46C1218EC1 FOREIGN KEY (groupe_competences_id) REFERENCES groupe_competences (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bulletin ADD CONSTRAINT FK_2B7D8942B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE bulletin_groupe_competences ADD CONSTRAINT FK_A0016ADAD1AAB236 FOREIGN KEY (bulletin_id) REFERENCES bulletin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bulletin_groupe_competences ADD CONSTRAINT FK_A0016ADAC1218EC1 FOREIGN KEY (groupe_competences_id) REFERENCES groupe_competences (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT FK_94D4687F9545A4ED FOREIGN KEY (groupecompetences_id) REFERENCES groupe_competences (id)');
        $this->addSql('ALTER TABLE consigne_groupe_consignes ADD CONSTRAINT FK_720806A58C063686 FOREIGN KEY (consigne_id) REFERENCES consigne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE consigne_groupe_consignes ADD CONSTRAINT FK_720806A59F75AFC2 FOREIGN KEY (groupe_consignes_id) REFERENCES groupe_consignes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F797A77B84 FOREIGN KEY (famille_id) REFERENCES famille (id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F78F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE enseignant ADD CONSTRAINT FK_81A72FA18F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE feuille_route ADD CONSTRAINT FK_6EB74052A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
        $this->addSql('ALTER TABLE parent_eleve ADD CONSTRAINT FK_2090915497A77B84 FOREIGN KEY (famille_id) REFERENCES famille (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B875551532465C36');
        $this->addSql('ALTER TABLE activite_feuille_route DROP FOREIGN KEY FK_6EF2BF3D9B0F88B1');
        $this->addSql('ALTER TABLE activite_feuille_route DROP FOREIGN KEY FK_6EF2BF3DAC0556AA');
        $this->addSql('ALTER TABLE activite_groupe_competences DROP FOREIGN KEY FK_E7CBAD469B0F88B1');
        $this->addSql('ALTER TABLE activite_groupe_competences DROP FOREIGN KEY FK_E7CBAD46C1218EC1');
        $this->addSql('ALTER TABLE bulletin DROP FOREIGN KEY FK_2B7D8942B3E9C81');
        $this->addSql('ALTER TABLE bulletin_groupe_competences DROP FOREIGN KEY FK_A0016ADAD1AAB236');
        $this->addSql('ALTER TABLE bulletin_groupe_competences DROP FOREIGN KEY FK_A0016ADAC1218EC1');
        $this->addSql('ALTER TABLE competence DROP FOREIGN KEY FK_94D4687F9545A4ED');
        $this->addSql('ALTER TABLE consigne_groupe_consignes DROP FOREIGN KEY FK_720806A58C063686');
        $this->addSql('ALTER TABLE consigne_groupe_consignes DROP FOREIGN KEY FK_720806A59F75AFC2');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F797A77B84');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F78F5EA509');
        $this->addSql('ALTER TABLE enseignant DROP FOREIGN KEY FK_81A72FA18F5EA509');
        $this->addSql('ALTER TABLE feuille_route DROP FOREIGN KEY FK_6EB74052A6CC7B2');
        $this->addSql('ALTER TABLE parent_eleve DROP FOREIGN KEY FK_2090915497A77B84');
        $this->addSql('DROP TABLE activite');
        $this->addSql('DROP TABLE activite_feuille_route');
        $this->addSql('DROP TABLE activite_groupe_competences');
        $this->addSql('DROP TABLE bulletin');
        $this->addSql('DROP TABLE bulletin_groupe_competences');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE consigne');
        $this->addSql('DROP TABLE consigne_groupe_consignes');
        $this->addSql('DROP TABLE eleve');
        $this->addSql('DROP TABLE enseignant');
        $this->addSql('DROP TABLE famille');
        $this->addSql('DROP TABLE feuille_route');
        $this->addSql('DROP TABLE groupe_competences');
        $this->addSql('DROP TABLE groupe_consignes');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE parent_eleve');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
