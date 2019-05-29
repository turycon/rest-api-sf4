<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190507181659 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, create_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_profile (id INT AUTO_INCREMENT NOT NULL, pax INT DEFAULT NULL, budget NUMERIC(12, 2) DEFAULT NULL, balance NUMERIC(12, 2) DEFAULT NULL, balance_date DATE DEFAULT NULL, billing NUMERIC(12, 2) DEFAULT NULL, billing_date DATE DEFAULT NULL, revenue_prospection NUMERIC(12, 2) DEFAULT NULL, revenue_percent SMALLINT DEFAULT NULL, revenue NUMERIC(12, 2) DEFAULT NULL, payment_date DATE DEFAULT NULL, payment_days INT DEFAULT NULL, financial_status TINYINT(1) DEFAULT NULL, billing_status TINYINT(1) DEFAULT NULL, operation_status TINYINT(1) DEFAULT NULL, audit_status TINYINT(1) DEFAULT NULL, audit_status_incomplete TINYINT(1) DEFAULT NULL, create_date DATETIME DEFAULT NULL, update_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE billing (id INT AUTO_INCREMENT NOT NULL, number VARCHAR(120) DEFAULT NULL, date DATE DEFAULT NULL, amount NUMERIC(12, 2) DEFAULT NULL, category VARCHAR(45) DEFAULT NULL, status VARCHAR(45) DEFAULT NULL, create_date DATETIME DEFAULT NULL, payment_date DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE main_configuration ADD gob_days INT DEFAULT NULL, ADD asoc_days INT DEFAULT NULL, ADD corp_days INT DEFAULT NULL, ADD min_percent_revenue INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_profile');
        $this->addSql('DROP TABLE billing');
        $this->addSql('ALTER TABLE main_configuration DROP gob_days, DROP asoc_days, DROP corp_days, DROP min_percent_revenue');
    }
}
