<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230829093659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD famille_id INT DEFAULT NULL, ADD classe_id INT DEFAULT NULL, ADD nom VARCHAR(50) NOT NULL, ADD prenom VARCHAR(50) NOT NULL, ADD nom_usage VARCHAR(50) DEFAULT NULL, ADD autorite TINYINT(1) DEFAULT NULL, ADD qualite INT DEFAULT NULL, ADD profession VARCHAR(100) DEFAULT NULL, ADD adresse VARCHAR(150) DEFAULT NULL, ADD cp VARCHAR(10) DEFAULT NULL, ADD ville VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64997A77B84 FOREIGN KEY (famille_id) REFERENCES famille (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64997A77B84 ON user (famille_id)');
        $this->addSql('CREATE INDEX IDX_8D93D6498F5EA509 ON user (classe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64997A77B84');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498F5EA509');
        $this->addSql('DROP INDEX IDX_8D93D64997A77B84 ON user');
        $this->addSql('DROP INDEX IDX_8D93D6498F5EA509 ON user');
        $this->addSql('ALTER TABLE user DROP famille_id, DROP classe_id, DROP nom, DROP prenom, DROP nom_usage, DROP autorite, DROP qualite, DROP profession, DROP adresse, DROP cp, DROP ville');
    }
}
