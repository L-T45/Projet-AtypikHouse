<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220203165415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE properties_gallery ADD file_path VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE reservations CHANGE is_approuved is_approuved TINYINT(1) NOT NULL, CHANGE is_cancelled is_cancelled TINYINT(1) NOT NULL, CHANGE is_paid is_paid TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE properties_gallery DROP file_path');
        $this->addSql('ALTER TABLE reservations CHANGE is_approuved is_approuved TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE is_cancelled is_cancelled TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE is_paid is_paid TINYINT(1) DEFAULT \'0\' NOT NULL');
    }
}
