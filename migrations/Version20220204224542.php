<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220204224542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attributes_answers (id INT AUTO_INCREMENT NOT NULL, properties_id INT DEFAULT NULL, attributes_id INT DEFAULT NULL, response_string VARCHAR(255) DEFAULT NULL, response_bool TINYINT(1) DEFAULT NULL, response_nbr INT DEFAULT NULL, INDEX IDX_DCDFCC3C3691D1CA (properties_id), INDEX IDX_DCDFCC3CBAAF4009 (attributes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attributes_answers ADD CONSTRAINT FK_DCDFCC3C3691D1CA FOREIGN KEY (properties_id) REFERENCES properties (id)');
        $this->addSql('ALTER TABLE attributes_answers ADD CONSTRAINT FK_DCDFCC3CBAAF4009 FOREIGN KEY (attributes_id) REFERENCES attributes (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE attributes_answers');
    }
}
