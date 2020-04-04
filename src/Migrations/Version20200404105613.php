<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200404105613 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Transaction ADD event VARCHAR(255) DEFAULT NULL, ADD external_id VARCHAR(255) DEFAULT NULL, ADD status VARCHAR(255) DEFAULT NULL, ADD amount VARCHAR(255) DEFAULT NULL, ADD captured_at VARCHAR(255) DEFAULT NULL, ADD triggered_at VARCHAR(255) DEFAULT NULL, ADD description VARCHAR(255) DEFAULT NULL, ADD method VARCHAR(255) DEFAULT NULL, ADD card_first VARCHAR(255) DEFAULT NULL, ADD card_last VARCHAR(255) DEFAULT NULL, ADD title VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE Transaction DROP event, DROP external_id, DROP status, DROP amount, DROP captured_at, DROP triggered_at, DROP description, DROP method, DROP card_first, DROP card_last, DROP title');
    }
}
