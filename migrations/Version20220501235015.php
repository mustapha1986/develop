<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220501235015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adress DROP FOREIGN KEY FK_5CECC7BE979B1AD6');
        $this->addSql('DROP INDEX IDX_5CECC7BE979B1AD6 ON adress');
        $this->addSql('ALTER TABLE adress DROP company_id');
        $this->addSql('ALTER TABLE company ADD adress_id INT DEFAULT NULL, DROP adress');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F8486F9AC FOREIGN KEY (adress_id) REFERENCES adress (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FBF094F8486F9AC ON company (adress_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adress ADD company_id INT NOT NULL');
        $this->addSql('ALTER TABLE adress ADD CONSTRAINT FK_5CECC7BE979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('CREATE INDEX IDX_5CECC7BE979B1AD6 ON adress (company_id)');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F8486F9AC');
        $this->addSql('DROP INDEX UNIQ_4FBF094F8486F9AC ON company');
        $this->addSql('ALTER TABLE company ADD adress VARCHAR(255) NOT NULL, DROP adress_id');
    }
}
