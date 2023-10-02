<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230929071147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE property ADD establishment_id INT NOT NULL');
        $this->addSql('ALTER TABLE property ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE property ADD description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE8565851 FOREIGN KEY (establishment_id) REFERENCES establishment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8BF21CDE8565851 ON property (establishment_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE property DROP CONSTRAINT FK_8BF21CDE8565851');
        $this->addSql('DROP INDEX IDX_8BF21CDE8565851');
        $this->addSql('ALTER TABLE property DROP establishment_id');
        $this->addSql('ALTER TABLE property DROP name');
        $this->addSql('ALTER TABLE property DROP description');
    }
}
