<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211222222448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories_attributes ADD categories_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categories_attributes ADD CONSTRAINT FK_9015DE78A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_9015DE78A21214B7 ON categories_attributes (categories_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories_attributes DROP FOREIGN KEY FK_9015DE78A21214B7');
        $this->addSql('DROP INDEX IDX_9015DE78A21214B7 ON categories_attributes');
        $this->addSql('ALTER TABLE categories_attributes DROP categories_id');
    }
}
