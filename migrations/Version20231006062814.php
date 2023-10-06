<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231006062814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE bed_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE bed (id INT NOT NULL, type_bed_id INT NOT NULL, number_of_bed INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E647FCFFABBFE081 ON bed (type_bed_id)');
        $this->addSql('ALTER TABLE bed ADD CONSTRAINT FK_E647FCFFABBFE081 FOREIGN KEY (type_bed_id) REFERENCES bed_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE bed_id_seq CASCADE');
        $this->addSql('ALTER TABLE bed DROP CONSTRAINT FK_E647FCFFABBFE081');
        $this->addSql('DROP TABLE bed');
    }
}
