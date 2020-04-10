<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200409115540 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE question_historic (id INT NOT NULL, question_id INT NOT NULL, old_title VARCHAR(100) DEFAULT NULL, new_title VARCHAR(100) DEFAULT NULL, old_updated TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, new_updated TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, old_status VARCHAR(100) DEFAULT NULL, new_status VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CE5A5F5A1E27F6BF ON question_historic (question_id)');
        $this->addSql('ALTER TABLE question_historic ADD CONSTRAINT FK_CE5A5F5A1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE question_historic');
    }
}
