<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211030232121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE categories_categoriesattributes');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories_categoriesattributes (categories_id INT NOT NULL, categoriesattributes_id INT NOT NULL, INDEX IDX_49FC450DA21214B7 (categories_id), INDEX IDX_49FC450D5EF148B6 (categoriesattributes_id), PRIMARY KEY(categories_id, categoriesattributes_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE categories_categoriesattributes ADD CONSTRAINT FK_49FC450D5EF148B6 FOREIGN KEY (categoriesattributes_id) REFERENCES categories_attributes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categories_categoriesattributes ADD CONSTRAINT FK_49FC450DA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
    }
}
