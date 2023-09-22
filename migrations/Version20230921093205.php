<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230921093205 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, eleve_id INT DEFAULT NULL, user_id INT DEFAULT NULL, activite_id INT DEFAULT NULL, feuille_route_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_C53D045FA6CC7B2 (eleve_id), INDEX IDX_C53D045FA76ED395 (user_id), INDEX IDX_C53D045F9B0F88B1 (activite_id), INDEX IDX_C53D045FAC0556AA (feuille_route_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FA6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F9B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FAC0556AA FOREIGN KEY (feuille_route_id) REFERENCES feuille_route (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FA6CC7B2');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FA76ED395');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F9B0F88B1');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FAC0556AA');
        $this->addSql('DROP TABLE image');
    }
}
