<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200421092250 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ProjectTranslation DROP FOREIGN KEY ProjectTranslation_ibfk_1');
        $this->addSql('ALTER TABLE ProjectTranslation ADD CONSTRAINT FK_145EF9C22C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES Project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE BlockTranslation DROP FOREIGN KEY BlockTranslation_ibfk_1');
        $this->addSql('ALTER TABLE BlockTranslation ADD CONSTRAINT FK_2B6C4AD62C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES Block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Project ADD short_book_en VARCHAR(255) DEFAULT NULL, ADD short_book_ru VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE BlockTranslation DROP FOREIGN KEY FK_2B6C4AD62C2AC5D3');
        $this->addSql('ALTER TABLE BlockTranslation ADD CONSTRAINT BlockTranslation_ibfk_1 FOREIGN KEY (translatable_id) REFERENCES Block (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE Project DROP short_book_en, DROP short_book_ru');
        $this->addSql('ALTER TABLE ProjectTranslation DROP FOREIGN KEY FK_145EF9C22C2AC5D3');
        $this->addSql('ALTER TABLE ProjectTranslation ADD CONSTRAINT ProjectTranslation_ibfk_1 FOREIGN KEY (translatable_id) REFERENCES Project (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
