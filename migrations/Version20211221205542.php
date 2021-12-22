<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211221205542 extends AbstractMigration
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
        $this->addSql('CREATE TABLE conversations (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipements (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, conversations_id INT DEFAULT NULL, body LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_DB021E96FE142757 (conversations_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payments (id INT AUTO_INCREMENT NOT NULL, amount DOUBLE PRECISION NOT NULL, is_paidback TINYINT(1) NOT NULL, paidback_state VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE properties (id INT AUTO_INCREMENT NOT NULL, categories_id INT DEFAULT NULL, propertiesgallery_id INT DEFAULT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, rooms INT NOT NULL, address VARCHAR(255) NOT NULL, booking INT NOT NULL, lat NUMERIC(8, 5) NOT NULL, longitude NUMERIC(8, 5) NOT NULL, bedrooms INT NOT NULL, surface NUMERIC(6, 3) NOT NULL, reference VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, capacity INT NOT NULL, zip_code INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_87C331C7A21214B7 (categories_id), INDEX IDX_87C331C71E56FA6E (propertiesgallery_id), INDEX IDX_87C331C7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE properties_equipements (properties_id INT NOT NULL, equipements_id INT NOT NULL, INDEX IDX_3DDB17F23691D1CA (properties_id), INDEX IDX_3DDB17F2852CCFF5 (equipements_id), PRIMARY KEY(properties_id, equipements_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE properties_gallery (id INT AUTO_INCREMENT NOT NULL, picture VARCHAR(255) NOT NULL, alt VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reports (id INT AUTO_INCREMENT NOT NULL, reportscategories_id INT DEFAULT NULL, report_state VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_F11FA745CC5EBC32 (reportscategories_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reports_categories (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservations (id INT AUTO_INCREMENT NOT NULL, payments_id INT DEFAULT NULL, properties_id INT DEFAULT NULL, user_id INT DEFAULT NULL, startdate DATE NOT NULL, end_date DATE NOT NULL, is_approuved TINYINT(1) NOT NULL, is_cancelled TINYINT(1) NOT NULL, is_paid TINYINT(1) NOT NULL, participants_nbr INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_4DA239BBC61482 (payments_id), INDEX IDX_4DA2393691D1CA (properties_id), INDEX IDX_4DA239A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservations_comments (reservations_id INT NOT NULL, comments_id INT NOT NULL, INDEX IDX_3E78518BD9A7F869 (reservations_id), INDEX IDX_3E78518B63379586 (comments_id), PRIMARY KEY(reservations_id, comments_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, phone INT NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, birthdate DATE NOT NULL, zip_code INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', emailvalidated TINYINT(1) DEFAULT NULL, firstname VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, is_blocked TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categories_categories_attributes ADD CONSTRAINT FK_7C1C0452A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categories_categories_attributes ADD CONSTRAINT FK_7C1C04524EC5F032 FOREIGN KEY (categories_attributes_id) REFERENCES categories_attributes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96FE142757 FOREIGN KEY (conversations_id) REFERENCES conversations (id)');
        $this->addSql('ALTER TABLE properties ADD CONSTRAINT FK_87C331C7A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE properties ADD CONSTRAINT FK_87C331C71E56FA6E FOREIGN KEY (propertiesgallery_id) REFERENCES properties_gallery (id)');
        $this->addSql('ALTER TABLE properties ADD CONSTRAINT FK_87C331C7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE properties_equipements ADD CONSTRAINT FK_3DDB17F23691D1CA FOREIGN KEY (properties_id) REFERENCES properties (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE properties_equipements ADD CONSTRAINT FK_3DDB17F2852CCFF5 FOREIGN KEY (equipements_id) REFERENCES equipements (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reports ADD CONSTRAINT FK_F11FA745CC5EBC32 FOREIGN KEY (reportscategories_id) REFERENCES reports_categories (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239BBC61482 FOREIGN KEY (payments_id) REFERENCES payments (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA2393691D1CA FOREIGN KEY (properties_id) REFERENCES properties (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservations_comments ADD CONSTRAINT FK_3E78518BD9A7F869 FOREIGN KEY (reservations_id) REFERENCES reservations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservations_comments ADD CONSTRAINT FK_3E78518B63379586 FOREIGN KEY (comments_id) REFERENCES comments (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories_categories_attributes DROP FOREIGN KEY FK_7C1C0452A21214B7');
        $this->addSql('ALTER TABLE properties DROP FOREIGN KEY FK_87C331C7A21214B7');
        $this->addSql('ALTER TABLE categories_categories_attributes DROP FOREIGN KEY FK_7C1C04524EC5F032');
        $this->addSql('ALTER TABLE reservations_comments DROP FOREIGN KEY FK_3E78518B63379586');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96FE142757');
        $this->addSql('ALTER TABLE properties_equipements DROP FOREIGN KEY FK_3DDB17F2852CCFF5');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239BBC61482');
        $this->addSql('ALTER TABLE properties_equipements DROP FOREIGN KEY FK_3DDB17F23691D1CA');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA2393691D1CA');
        $this->addSql('ALTER TABLE properties DROP FOREIGN KEY FK_87C331C71E56FA6E');
        $this->addSql('ALTER TABLE reports DROP FOREIGN KEY FK_F11FA745CC5EBC32');
        $this->addSql('ALTER TABLE reservations_comments DROP FOREIGN KEY FK_3E78518BD9A7F869');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AA76ED395');
        $this->addSql('ALTER TABLE properties DROP FOREIGN KEY FK_87C331C7A76ED395');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239A76ED395');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE categories_categories_attributes');
        $this->addSql('DROP TABLE categories_attributes');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE conversations');
        $this->addSql('DROP TABLE equipements');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE payments');
        $this->addSql('DROP TABLE properties');
        $this->addSql('DROP TABLE properties_equipements');
        $this->addSql('DROP TABLE properties_gallery');
        $this->addSql('DROP TABLE reports');
        $this->addSql('DROP TABLE reports_categories');
        $this->addSql('DROP TABLE reservations');
        $this->addSql('DROP TABLE reservations_comments');
        $this->addSql('DROP TABLE user');
    }
}