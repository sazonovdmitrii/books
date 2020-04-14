<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200414071855 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Orders ADD project_id INT DEFAULT NULL, ADD external_payment_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE Orders ADD CONSTRAINT FK_E283F8D8166D1F9C FOREIGN KEY (project_id) REFERENCES Project (id)');
        $this->addSql('CREATE INDEX IDX_E283F8D8166D1F9C ON Orders (project_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Orders DROP FOREIGN KEY FK_E283F8D8166D1F9C');
        $this->addSql('DROP INDEX IDX_E283F8D8166D1F9C ON Orders');
        $this->addSql('ALTER TABLE Orders DROP project_id, DROP external_payment_id');
    }
}
