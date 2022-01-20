<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220115233147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reports ADD properties_id INT DEFAULT NULL, ADD comments_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reports ADD CONSTRAINT FK_F11FA7453691D1CA FOREIGN KEY (properties_id) REFERENCES properties (id)');
        $this->addSql('ALTER TABLE reports ADD CONSTRAINT FK_F11FA74563379586 FOREIGN KEY (comments_id) REFERENCES comments (id)');
        $this->addSql('ALTER TABLE reports ADD CONSTRAINT FK_F11FA745A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F11FA7453691D1CA ON reports (properties_id)');
        $this->addSql('CREATE INDEX IDX_F11FA74563379586 ON reports (comments_id)');
        $this->addSql('CREATE INDEX IDX_F11FA745A76ED395 ON reports (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reports DROP FOREIGN KEY FK_F11FA7453691D1CA');
        $this->addSql('ALTER TABLE reports DROP FOREIGN KEY FK_F11FA74563379586');
        $this->addSql('ALTER TABLE reports DROP FOREIGN KEY FK_F11FA745A76ED395');
        $this->addSql('DROP INDEX IDX_F11FA7453691D1CA ON reports');
        $this->addSql('DROP INDEX IDX_F11FA74563379586 ON reports');
        $this->addSql('DROP INDEX IDX_F11FA745A76ED395 ON reports');
        $this->addSql('ALTER TABLE reports DROP properties_id, DROP comments_id, DROP user_id');
    }
}
