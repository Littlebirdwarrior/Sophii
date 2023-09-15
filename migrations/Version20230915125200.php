<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230915125200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bulletin (id INT AUTO_INCREMENT NOT NULL, trimestre_id INT DEFAULT NULL, eleve_id INT DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_2B7D8942B9DB5D9D (trimestre_id), INDEX IDX_2B7D8942A6CC7B2 (eleve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bulletin_bulletin_groupe_competences (bulletin_id INT NOT NULL, bulletin_groupe_competences_id INT NOT NULL, INDEX IDX_C9941856D1AAB236 (bulletin_id), INDEX IDX_C9941856E4AC6CD (bulletin_groupe_competences_id), PRIMARY KEY(bulletin_id, bulletin_groupe_competences_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bulletin_groupe_competences (id INT AUTO_INCREMENT NOT NULL, acquisition TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bulletin ADD CONSTRAINT FK_2B7D8942B9DB5D9D FOREIGN KEY (trimestre_id) REFERENCES trimestre (id)');
        $this->addSql('ALTER TABLE bulletin ADD CONSTRAINT FK_2B7D8942A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
        $this->addSql('ALTER TABLE bulletin_bulletin_groupe_competences ADD CONSTRAINT FK_C9941856D1AAB236 FOREIGN KEY (bulletin_id) REFERENCES bulletin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bulletin_bulletin_groupe_competences ADD CONSTRAINT FK_C9941856E4AC6CD FOREIGN KEY (bulletin_groupe_competences_id) REFERENCES bulletin_groupe_competences (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bulletin DROP FOREIGN KEY FK_2B7D8942B9DB5D9D');
        $this->addSql('ALTER TABLE bulletin DROP FOREIGN KEY FK_2B7D8942A6CC7B2');
        $this->addSql('ALTER TABLE bulletin_bulletin_groupe_competences DROP FOREIGN KEY FK_C9941856D1AAB236');
        $this->addSql('ALTER TABLE bulletin_bulletin_groupe_competences DROP FOREIGN KEY FK_C9941856E4AC6CD');
        $this->addSql('DROP TABLE bulletin');
        $this->addSql('DROP TABLE bulletin_bulletin_groupe_competences');
        $this->addSql('DROP TABLE bulletin_groupe_competences');
    }
}
