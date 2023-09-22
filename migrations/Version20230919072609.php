<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230919072609 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bulletin_groupe_competences DROP FOREIGN KEY FK_A0016ADA89034830');
        $this->addSql('DROP INDEX IDX_A0016ADA89034830 ON bulletin_groupe_competences');
        $this->addSql('ALTER TABLE bulletin_groupe_competences CHANGE groupe_competence_id groupe_competences_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bulletin_groupe_competences ADD CONSTRAINT FK_A0016ADAC1218EC1 FOREIGN KEY (groupe_competences_id) REFERENCES groupe_competences (id)');
        $this->addSql('CREATE INDEX IDX_A0016ADAC1218EC1 ON bulletin_groupe_competences (groupe_competences_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bulletin_groupe_competences DROP FOREIGN KEY FK_A0016ADAC1218EC1');
        $this->addSql('DROP INDEX IDX_A0016ADAC1218EC1 ON bulletin_groupe_competences');
        $this->addSql('ALTER TABLE bulletin_groupe_competences CHANGE groupe_competences_id groupe_competence_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bulletin_groupe_competences ADD CONSTRAINT FK_A0016ADA89034830 FOREIGN KEY (groupe_competence_id) REFERENCES groupe_competences (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_A0016ADA89034830 ON bulletin_groupe_competences (groupe_competence_id)');
    }
}
