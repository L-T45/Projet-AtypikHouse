<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211221205330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories_categories_attributes (categories_id INT NOT NULL, categories_attributes_id INT NOT NULL, INDEX IDX_7C1C0452A21214B7 (categories_id), INDEX IDX_7C1C04524EC5F032 (categories_attributes_id), PRIMARY KEY(categories_id, categories_attributes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories_attributes (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, body LONGTEXT NOT NULL, value INT NOT NULL, username VARCHAR(255) NOT NULL, userpicture VARCHAR(255) NOT NULL, propertypicture VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_5F9E962AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, phone INT NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, birthdate DATE NOT NULL, zip_code INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', emailvalidated TINYINT(1) DEFAULT NULL, firstname VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, is_blocked TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categories_categories_attributes ADD CONSTRAINT FK_7C1C0452A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categories_categories_attributes ADD CONSTRAINT FK_7C1C04524EC5F032 FOREIGN KEY (categories_attributes_id) REFERENCES categories_attributes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE properties ADD user_id INT DEFAULT NULL, DROP city');
        $this->addSql('ALTER TABLE properties ADD CONSTRAINT FK_87C331C7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_87C331C7A76ED395 ON properties (user_id)');
        $this->addSql('ALTER TABLE reservations ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4DA239A76ED395 ON reservations (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories_categories_attributes DROP FOREIGN KEY FK_7C1C0452A21214B7');
        $this->addSql('ALTER TABLE properties DROP FOREIGN KEY FK_87C331C7A21214B7');
        $this->addSql('ALTER TABLE categories_categories_attributes DROP FOREIGN KEY FK_7C1C04524EC5F032');
        $this->addSql('ALTER TABLE reservations_comments DROP FOREIGN KEY FK_3E78518B63379586');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AA76ED395');
        $this->addSql('ALTER TABLE properties DROP FOREIGN KEY FK_87C331C7A76ED395');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239A76ED395');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE categories_categories_attributes');
        $this->addSql('DROP TABLE categories_attributes');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_87C331C7A76ED395 ON properties');
        $this->addSql('ALTER TABLE properties ADD city VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP user_id');
        $this->addSql('DROP INDEX IDX_4DA239A76ED395 ON reservations');
        $this->addSql('ALTER TABLE reservations DROP user_id');
    }
}
