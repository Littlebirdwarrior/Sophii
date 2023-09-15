<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230915125613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bulletin_bulletin_groupe_competences DROP FOREIGN KEY FK_C9941856D1AAB236');
        $this->addSql('ALTER TABLE bulletin_bulletin_groupe_competences DROP FOREIGN KEY FK_C9941856E4AC6CD');
        $this->addSql('DROP TABLE bulletin_bulletin_groupe_competences');
        $this->addSql('ALTER TABLE bulletin_groupe_competences ADD bulletin_id INT DEFAULT NULL, ADD groupe_competence_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bulletin_groupe_competences ADD CONSTRAINT FK_A0016ADAD1AAB236 FOREIGN KEY (bulletin_id) REFERENCES bulletin (id)');
        $this->addSql('ALTER TABLE bulletin_groupe_competences ADD CONSTRAINT FK_A0016ADA89034830 FOREIGN KEY (groupe_competence_id) REFERENCES groupe_competences (id)');
        $this->addSql('CREATE INDEX IDX_A0016ADAD1AAB236 ON bulletin_groupe_competences (bulletin_id)');
        $this->addSql('CREATE INDEX IDX_A0016ADA89034830 ON bulletin_groupe_competences (groupe_competence_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bulletin_bulletin_groupe_competences (bulletin_id INT NOT NULL, bulletin_groupe_competences_id INT NOT NULL, INDEX IDX_C9941856E4AC6CD (bulletin_groupe_competences_id), INDEX IDX_C9941856D1AAB236 (bulletin_id), PRIMARY KEY(bulletin_id, bulletin_groupe_competences_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bulletin_bulletin_groupe_competences ADD CONSTRAINT FK_C9941856D1AAB236 FOREIGN KEY (bulletin_id) REFERENCES bulletin (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bulletin_bulletin_groupe_competences ADD CONSTRAINT FK_C9941856E4AC6CD FOREIGN KEY (bulletin_groupe_competences_id) REFERENCES bulletin_groupe_competences (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bulletin_groupe_competences DROP FOREIGN KEY FK_A0016ADAD1AAB236');
        $this->addSql('ALTER TABLE bulletin_groupe_competences DROP FOREIGN KEY FK_A0016ADA89034830');
        $this->addSql('DROP INDEX IDX_A0016ADAD1AAB236 ON bulletin_groupe_competences');
        $this->addSql('DROP INDEX IDX_A0016ADA89034830 ON bulletin_groupe_competences');
        $this->addSql('ALTER TABLE bulletin_groupe_competences DROP bulletin_id, DROP groupe_competence_id');
    }
}
