<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200324075257 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Transaction (id INT AUTO_INCREMENT NOT NULL, entity_id INT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL, data LONGTEXT DEFAULT NULL, INDEX IDX_F4AB8A0681257D5D (entity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Orders (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, created DATETIME NOT NULL, comment LONGTEXT DEFAULT NULL, payment_method_code VARCHAR(12) DEFAULT NULL, payment_link VARCHAR(150) DEFAULT NULL, INDEX IDX_E283F8D8A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Transaction ADD CONSTRAINT FK_F4AB8A0681257D5D FOREIGN KEY (entity_id) REFERENCES Orders (id)');
        $this->addSql('ALTER TABLE Orders ADD CONSTRAINT FK_E283F8D8A76ED395 FOREIGN KEY (user_id) REFERENCES Users (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Transaction DROP FOREIGN KEY FK_F4AB8A0681257D5D');
        $this->addSql('DROP TABLE Transaction');
        $this->addSql('DROP TABLE Orders');
    }
}
