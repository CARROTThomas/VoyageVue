<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231004053300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE situation ADD property_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE situation ADD CONSTRAINT FK_EC2D9ACAB9575F5A FOREIGN KEY (property_id_id) REFERENCES property (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_EC2D9ACAB9575F5A ON situation (property_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE situation DROP CONSTRAINT FK_EC2D9ACAB9575F5A');
        $this->addSql('DROP INDEX IDX_EC2D9ACAB9575F5A');
        $this->addSql('ALTER TABLE situation DROP property_id_id');
    }
}
