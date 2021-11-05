<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211030215619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE properties ADD propertiesgallery_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE properties ADD CONSTRAINT FK_87C331C71E56FA6E FOREIGN KEY (propertiesgallery_id) REFERENCES properties_gallery (id)');
        $this->addSql('CREATE INDEX IDX_87C331C71E56FA6E ON properties (propertiesgallery_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE properties DROP FOREIGN KEY FK_87C331C71E56FA6E');
        $this->addSql('DROP INDEX IDX_87C331C71E56FA6E ON properties');
        $this->addSql('ALTER TABLE properties DROP propertiesgallery_id');
    }
}
