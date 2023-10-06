<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231006063610 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bed ADD bedroom_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE bed ADD CONSTRAINT FK_E647FCFFE75580BF FOREIGN KEY (bedroom_id_id) REFERENCES bedroom (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_E647FCFFE75580BF ON bed (bedroom_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE bed DROP CONSTRAINT FK_E647FCFFE75580BF');
        $this->addSql('DROP INDEX IDX_E647FCFFE75580BF');
        $this->addSql('ALTER TABLE bed DROP bedroom_id_id');
    }
}
