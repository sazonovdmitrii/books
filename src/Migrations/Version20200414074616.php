<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200414074616 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Orders ADD transaction_id INT DEFAULT NULL, ADD email VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE Orders ADD CONSTRAINT FK_E283F8D82FC0CB0F FOREIGN KEY (transaction_id) REFERENCES Transaction (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E283F8D82FC0CB0F ON Orders (transaction_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Orders DROP FOREIGN KEY FK_E283F8D82FC0CB0F');
        $this->addSql('DROP INDEX UNIQ_E283F8D82FC0CB0F ON Orders');
        $this->addSql('ALTER TABLE Orders DROP transaction_id, DROP email');
    }
}
