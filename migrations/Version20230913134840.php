<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230913134840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trimestre (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bulletin DROP FOREIGN KEY FK_2B7D8942B3E9C81');
        $this->addSql('DROP INDEX IDX_2B7D8942B3E9C81 ON bulletin');
        $this->addSql('ALTER TABLE bulletin DROP trimeste, CHANGE niveau_id trimestre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bulletin ADD CONSTRAINT FK_2B7D8942B9DB5D9D FOREIGN KEY (trimestre_id) REFERENCES trimestre (id)');
        $this->addSql('CREATE INDEX IDX_2B7D8942B9DB5D9D ON bulletin (trimestre_id)');
        $this->addSql('ALTER TABLE bulletin_groupe_competences DROP FOREIGN KEY FK_A0016ADAC1218EC1');
        $this->addSql('ALTER TABLE bulletin_groupe_competences DROP FOREIGN KEY FK_A0016ADAD1AAB236');
        $this->addSql('DROP INDEX IDX_A0016ADAC1218EC1 ON bulletin_groupe_competences');
        $this->addSql('ALTER TABLE bulletin_groupe_competences ADD id INT AUTO_INCREMENT NOT NULL, ADD groupe_competence_id INT DEFAULT NULL, ADD acquisition TINYINT(1) DEFAULT NULL, DROP groupe_competences_id, CHANGE bulletin_id bulletin_id INT DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE bulletin_groupe_competences ADD CONSTRAINT FK_A0016ADA89034830 FOREIGN KEY (groupe_competence_id) REFERENCES groupe_competences (id)');
        $this->addSql('ALTER TABLE bulletin_groupe_competences ADD CONSTRAINT FK_A0016ADAD1AAB236 FOREIGN KEY (bulletin_id) REFERENCES bulletin (id)');
        $this->addSql('CREATE INDEX IDX_A0016ADA89034830 ON bulletin_groupe_competences (groupe_competence_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bulletin DROP FOREIGN KEY FK_2B7D8942B9DB5D9D');
        $this->addSql('DROP TABLE trimestre');
        $this->addSql('DROP INDEX IDX_2B7D8942B9DB5D9D ON bulletin');
        $this->addSql('ALTER TABLE bulletin ADD trimeste INT NOT NULL, CHANGE trimestre_id niveau_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bulletin ADD CONSTRAINT FK_2B7D8942B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_2B7D8942B3E9C81 ON bulletin (niveau_id)');
        $this->addSql('ALTER TABLE bulletin_groupe_competences MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE bulletin_groupe_competences DROP FOREIGN KEY FK_A0016ADA89034830');
        $this->addSql('ALTER TABLE bulletin_groupe_competences DROP FOREIGN KEY FK_A0016ADAD1AAB236');
        $this->addSql('DROP INDEX IDX_A0016ADA89034830 ON bulletin_groupe_competences');
        $this->addSql('DROP INDEX `PRIMARY` ON bulletin_groupe_competences');
        $this->addSql('ALTER TABLE bulletin_groupe_competences ADD groupe_competences_id INT NOT NULL, DROP id, DROP groupe_competence_id, DROP acquisition, CHANGE bulletin_id bulletin_id INT NOT NULL');
        $this->addSql('ALTER TABLE bulletin_groupe_competences ADD CONSTRAINT FK_A0016ADAC1218EC1 FOREIGN KEY (groupe_competences_id) REFERENCES groupe_competences (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bulletin_groupe_competences ADD CONSTRAINT FK_A0016ADAD1AAB236 FOREIGN KEY (bulletin_id) REFERENCES bulletin (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_A0016ADAC1218EC1 ON bulletin_groupe_competences (groupe_competences_id)');
        $this->addSql('ALTER TABLE bulletin_groupe_competences ADD PRIMARY KEY (bulletin_id, groupe_competences_id)');
    }
}
