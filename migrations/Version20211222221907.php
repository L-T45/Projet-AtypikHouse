<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211222221907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE categories_categories_attributes');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AA76ED395');
        $this->addSql('DROP INDEX IDX_5F9E962AA76ED395 ON comments');
        $this->addSql('ALTER TABLE comments DROP user_id');
        $this->addSql('ALTER TABLE properties DROP FOREIGN KEY FK_87C331C7A76ED395');
        $this->addSql('DROP INDEX IDX_87C331C7A76ED395 ON properties');
        $this->addSql('ALTER TABLE properties DROP user_id');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239A76ED395');
        $this->addSql('DROP INDEX IDX_4DA239A76ED395 ON reservations');
        $this->addSql('ALTER TABLE reservations DROP user_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories_categories_attributes (categories_id INT NOT NULL, categories_attributes_id INT NOT NULL, INDEX IDX_7C1C04524EC5F032 (categories_attributes_id), INDEX IDX_7C1C0452A21214B7 (categories_id), PRIMARY KEY(categories_id, categories_attributes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE categories_categories_attributes ADD CONSTRAINT FK_7C1C04524EC5F032 FOREIGN KEY (categories_attributes_id) REFERENCES categories_attributes (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categories_categories_attributes ADD CONSTRAINT FK_7C1C0452A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comments ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5F9E962AA76ED395 ON comments (user_id)');
        $this->addSql('ALTER TABLE properties ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE properties ADD CONSTRAINT FK_87C331C7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_87C331C7A76ED395 ON properties (user_id)');
        $this->addSql('ALTER TABLE reservations ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_4DA239A76ED395 ON reservations (user_id)');
    }
}
