<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190520144816 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE venue ADD create_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE country ADD create_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user ADD create_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE market ADD create_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE client ADD create_date DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client DROP create_date');
        $this->addSql('ALTER TABLE country DROP create_date');
        $this->addSql('ALTER TABLE market DROP create_date');
        $this->addSql('ALTER TABLE user DROP create_date');
        $this->addSql('ALTER TABLE venue DROP create_date');
    }
}
