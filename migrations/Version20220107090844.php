<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220107090844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attributes ADD categories_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE attributes ADD CONSTRAINT FK_319B9E70A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_319B9E70A21214B7 ON attributes (categories_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attributes DROP FOREIGN KEY FK_319B9E70A21214B7');
        $this->addSql('DROP INDEX IDX_319B9E70A21214B7 ON attributes');
        $this->addSql('ALTER TABLE attributes DROP categories_id');
    }
}
