<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220203222035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipements ADD value VARCHAR(255) DEFAULT NULL, ADD required TINYINT(1) NOT NULL, ADD response_string VARCHAR(255) DEFAULT NULL, ADD response_bool TINYINT(1) NOT NULL, ADD response_nbr INT DEFAULT NULL, ADD response_type VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipements DROP value, DROP required, DROP response_string, DROP response_bool, DROP response_nbr, DROP response_type');
    }
}
