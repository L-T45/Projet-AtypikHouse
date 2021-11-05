<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211030232510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories_categories_attributes (categories_id INT NOT NULL, categories_attributes_id INT NOT NULL, INDEX IDX_7C1C0452A21214B7 (categories_id), INDEX IDX_7C1C04524EC5F032 (categories_attributes_id), PRIMARY KEY(categories_id, categories_attributes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categories_categories_attributes ADD CONSTRAINT FK_7C1C0452A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categories_categories_attributes ADD CONSTRAINT FK_7C1C04524EC5F032 FOREIGN KEY (categories_attributes_id) REFERENCES categories_attributes (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE categories_categories_attributes');
    }
}
