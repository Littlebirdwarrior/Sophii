<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230914220820 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bulletin_eleve DROP FOREIGN KEY FK_35B241AFA6CC7B2');
        $this->addSql('ALTER TABLE bulletin_eleve DROP FOREIGN KEY FK_35B241AFD1AAB236');
        $this->addSql('DROP TABLE bulletin_eleve');
        $this->addSql('ALTER TABLE bulletin ADD date DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bulletin_eleve (bulletin_id INT NOT NULL, eleve_id INT NOT NULL, INDEX IDX_35B241AFD1AAB236 (bulletin_id), INDEX IDX_35B241AFA6CC7B2 (eleve_id), PRIMARY KEY(bulletin_id, eleve_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bulletin_eleve ADD CONSTRAINT FK_35B241AFA6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bulletin_eleve ADD CONSTRAINT FK_35B241AFD1AAB236 FOREIGN KEY (bulletin_id) REFERENCES bulletin (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bulletin DROP date');
    }
}
