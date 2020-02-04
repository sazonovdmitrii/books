<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200204072504 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Block (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, visible TINYINT(1) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE PageUrl (id INT AUTO_INCREMENT NOT NULL, entity_id INT DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, created DATETIME DEFAULT NULL, INDEX IDX_69819C0681257D5D (entity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Page (id INT AUTO_INCREMENT NOT NULL, meta_keywords LONGTEXT DEFAULT NULL, meta_description LONGTEXT DEFAULT NULL, created DATETIME DEFAULT NULL, updated DATETIME DEFAULT NULL, visible TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE PageUrl ADD CONSTRAINT FK_69819C0681257D5D FOREIGN KEY (entity_id) REFERENCES Page (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE PageUrl DROP FOREIGN KEY FK_69819C0681257D5D');
        $this->addSql('DROP TABLE Block');
        $this->addSql('DROP TABLE PageUrl');
        $this->addSql('DROP TABLE Page');
    }
}
