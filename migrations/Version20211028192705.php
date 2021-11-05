<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211028192705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE properties (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, rooms INT NOT NULL, address VARCHAR(255) NOT NULL, booking INT NULL, city VARCHAR(255) NOT NULL, lat NUMERIC(8, 5) NOT NULL, longitude NUMERIC(8, 5) NOT NULL, bedrooms INT NOT NULL, surface NUMERIC(6, 3) NOT NULL, reference VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, capacity INT NOT NULL, zip_code INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE properties');
    }
}
