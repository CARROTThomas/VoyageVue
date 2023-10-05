<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231004112529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE bedroom_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE bedroom (id INT NOT NULL, property_id_id INT NOT NULL, name VARCHAR(255) NOT NULL, m2 INT NOT NULL, price INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E6154351B9575F5A ON bedroom (property_id_id)');
        $this->addSql('ALTER TABLE bedroom ADD CONSTRAINT FK_E6154351B9575F5A FOREIGN KEY (property_id_id) REFERENCES property (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE bedroom_id_seq CASCADE');
        $this->addSql('ALTER TABLE bedroom DROP CONSTRAINT FK_E6154351B9575F5A');
        $this->addSql('DROP TABLE bedroom');
    }
}
