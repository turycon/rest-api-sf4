<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190508202343 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE main_configuration ADD usuario_id INT NOT NULL');
        $this->addSql('ALTER TABLE main_configuration ADD CONSTRAINT FK_1746164ADB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1746164ADB38439E ON main_configuration (usuario_id)');
        $this->addSql('ALTER TABLE project ADD usuario_id INT NOT NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEDB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EEDB38439E ON project (usuario_id)');
        $this->addSql('ALTER TABLE project_profile ADD usuario_id INT NOT NULL');
        $this->addSql('ALTER TABLE project_profile ADD CONSTRAINT FK_1749A66ADB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1749A66ADB38439E ON project_profile (usuario_id)');
        $this->addSql('ALTER TABLE market ADD usuario_id INT NOT NULL');
        $this->addSql('ALTER TABLE market ADD CONSTRAINT FK_6BAC85CBDB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6BAC85CBDB38439E ON market (usuario_id)');
        $this->addSql('ALTER TABLE billing ADD usuario_id INT NOT NULL');
        $this->addSql('ALTER TABLE billing ADD CONSTRAINT FK_EC224CAADB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_EC224CAADB38439E ON billing (usuario_id)');
        $this->addSql('ALTER TABLE client ADD usuario_id INT NOT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455DB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C7440455DB38439E ON client (usuario_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE billing DROP FOREIGN KEY FK_EC224CAADB38439E');
        $this->addSql('DROP INDEX IDX_EC224CAADB38439E ON billing');
        $this->addSql('ALTER TABLE billing DROP usuario_id');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455DB38439E');
        $this->addSql('DROP INDEX IDX_C7440455DB38439E ON client');
        $this->addSql('ALTER TABLE client DROP usuario_id');
        $this->addSql('ALTER TABLE main_configuration DROP FOREIGN KEY FK_1746164ADB38439E');
        $this->addSql('DROP INDEX IDX_1746164ADB38439E ON main_configuration');
        $this->addSql('ALTER TABLE main_configuration DROP usuario_id');
        $this->addSql('ALTER TABLE market DROP FOREIGN KEY FK_6BAC85CBDB38439E');
        $this->addSql('DROP INDEX IDX_6BAC85CBDB38439E ON market');
        $this->addSql('ALTER TABLE market DROP usuario_id');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEDB38439E');
        $this->addSql('DROP INDEX IDX_2FB3D0EEDB38439E ON project');
        $this->addSql('ALTER TABLE project DROP usuario_id');
        $this->addSql('ALTER TABLE project_profile DROP FOREIGN KEY FK_1749A66ADB38439E');
        $this->addSql('DROP INDEX IDX_1749A66ADB38439E ON project_profile');
        $this->addSql('ALTER TABLE project_profile DROP usuario_id');
    }
}
