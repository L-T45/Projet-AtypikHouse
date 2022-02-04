<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220204175208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attributes ADD value VARCHAR(255) DEFAULT NULL, ADD required TINYINT(1) NOT NULL, ADD response_string VARCHAR(255) DEFAULT NULL, ADD response_bool TINYINT(1) NOT NULL, ADD response_nbr INT DEFAULT NULL, ADD response_type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE equipements DROP value, DROP required, DROP response_string, DROP response_bool, DROP response_nbr, DROP response_type');
        $this->addSql('ALTER TABLE payments ADD stripe_session LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attributes DROP value, DROP required, DROP response_string, DROP response_bool, DROP response_nbr, DROP response_type');
        $this->addSql('ALTER TABLE equipements ADD value VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD required TINYINT(1) NOT NULL, ADD response_string VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD response_bool TINYINT(1) NOT NULL, ADD response_nbr INT DEFAULT NULL, ADD response_type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE payments DROP stripe_session');
    }
}
