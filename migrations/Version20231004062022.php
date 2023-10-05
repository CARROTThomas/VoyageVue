<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231004062022 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info ADD property_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE info ADD url_property VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE info ADD CONSTRAINT FK_CB893157B9575F5A FOREIGN KEY (property_id_id) REFERENCES property (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_CB893157B9575F5A ON info (property_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE info DROP CONSTRAINT FK_CB893157B9575F5A');
        $this->addSql('DROP INDEX IDX_CB893157B9575F5A');
        $this->addSql('ALTER TABLE info DROP property_id_id');
        $this->addSql('ALTER TABLE info DROP url_property');
    }
}
