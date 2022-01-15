<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220115214252 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A7C5EAD31');
        $this->addSql('DROP INDEX IDX_5F9E962A7C5EAD31 ON comments');
        $this->addSql('ALTER TABLE comments DROP reports_id');
        $this->addSql('ALTER TABLE properties DROP FOREIGN KEY FK_87C331C77C5EAD31');
        $this->addSql('DROP INDEX IDX_87C331C77C5EAD31 ON properties');
        $this->addSql('ALTER TABLE properties DROP reports_id');
        $this->addSql('ALTER TABLE reports ADD users_id INT DEFAULT NULL, ADD comments_id INT DEFAULT NULL, ADD properties_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reports ADD CONSTRAINT FK_F11FA74567B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reports ADD CONSTRAINT FK_F11FA74563379586 FOREIGN KEY (comments_id) REFERENCES comments (id)');
        $this->addSql('ALTER TABLE reports ADD CONSTRAINT FK_F11FA7453691D1CA FOREIGN KEY (properties_id) REFERENCES properties (id)');
        $this->addSql('CREATE INDEX IDX_F11FA74567B3B43D ON reports (users_id)');
        $this->addSql('CREATE INDEX IDX_F11FA74563379586 ON reports (comments_id)');
        $this->addSql('CREATE INDEX IDX_F11FA7453691D1CA ON reports (properties_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497C5EAD31');
        $this->addSql('DROP INDEX IDX_8D93D6497C5EAD31 ON user');
        $this->addSql('ALTER TABLE user DROP reports_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments ADD reports_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A7C5EAD31 FOREIGN KEY (reports_id) REFERENCES reports (id)');
        $this->addSql('CREATE INDEX IDX_5F9E962A7C5EAD31 ON comments (reports_id)');
        $this->addSql('ALTER TABLE properties ADD reports_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE properties ADD CONSTRAINT FK_87C331C77C5EAD31 FOREIGN KEY (reports_id) REFERENCES reports (id)');
        $this->addSql('CREATE INDEX IDX_87C331C77C5EAD31 ON properties (reports_id)');
        $this->addSql('ALTER TABLE reports DROP FOREIGN KEY FK_F11FA74567B3B43D');
        $this->addSql('ALTER TABLE reports DROP FOREIGN KEY FK_F11FA74563379586');
        $this->addSql('ALTER TABLE reports DROP FOREIGN KEY FK_F11FA7453691D1CA');
        $this->addSql('DROP INDEX IDX_F11FA74567B3B43D ON reports');
        $this->addSql('DROP INDEX IDX_F11FA74563379586 ON reports');
        $this->addSql('DROP INDEX IDX_F11FA7453691D1CA ON reports');
        $this->addSql('ALTER TABLE reports DROP users_id, DROP comments_id, DROP properties_id');
        $this->addSql('ALTER TABLE user ADD reports_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497C5EAD31 FOREIGN KEY (reports_id) REFERENCES reports (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6497C5EAD31 ON user (reports_id)');
    }
}
