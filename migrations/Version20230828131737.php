<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230828131737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parent_eleve ADD email VARCHAR(180) NOT NULL, ADD roles JSON NOT NULL, ADD is_verified TINYINT(1) NOT NULL, DROP mail, CHANGE tel tel VARCHAR(13) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_20909154E7927C74 ON parent_eleve (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_20909154E7927C74 ON parent_eleve');
        $this->addSql('ALTER TABLE parent_eleve ADD mail VARCHAR(100) NOT NULL, DROP email, DROP roles, DROP is_verified, CHANGE tel tel VARCHAR(13) NOT NULL');
    }
}
