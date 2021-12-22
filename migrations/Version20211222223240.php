<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211222223240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE reservations_comments');
        $this->addSql('ALTER TABLE comments ADD reservations_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AD9A7F869 FOREIGN KEY (reservations_id) REFERENCES reservations (id)');
        $this->addSql('CREATE INDEX IDX_5F9E962AD9A7F869 ON comments (reservations_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservations_comments (reservations_id INT NOT NULL, comments_id INT NOT NULL, INDEX IDX_3E78518B63379586 (comments_id), INDEX IDX_3E78518BD9A7F869 (reservations_id), PRIMARY KEY(reservations_id, comments_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE reservations_comments ADD CONSTRAINT FK_3E78518B63379586 FOREIGN KEY (comments_id) REFERENCES comments (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservations_comments ADD CONSTRAINT FK_3E78518BD9A7F869 FOREIGN KEY (reservations_id) REFERENCES reservations (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AD9A7F869');
        $this->addSql('DROP INDEX IDX_5F9E962AD9A7F869 ON comments');
        $this->addSql('ALTER TABLE comments DROP reservations_id');
    }
}
