<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220201165453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attributes DROP FOREIGN KEY FK_319B9E70A21214B7');
        $this->addSql('ALTER TABLE attributes ADD CONSTRAINT FK_319B9E70A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AA76ED395');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AD9A7F869');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AD9A7F869 FOREIGN KEY (reservations_id) REFERENCES reservations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96A76ED395');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96FE142757');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96FE142757 FOREIGN KEY (conversations_id) REFERENCES conversations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE payments DROP FOREIGN KEY FK_65D29B32A76ED395');
        $this->addSql('ALTER TABLE payments ADD CONSTRAINT FK_65D29B32A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE properties DROP FOREIGN KEY FK_87C331C7A21214B7');
        $this->addSql('ALTER TABLE properties DROP FOREIGN KEY FK_87C331C7A76ED395');
        $this->addSql('ALTER TABLE properties ADD CONSTRAINT FK_87C331C7A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE properties ADD CONSTRAINT FK_87C331C7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE properties_gallery DROP FOREIGN KEY FK_D9AE79173691D1CA');
        $this->addSql('ALTER TABLE properties_gallery ADD CONSTRAINT FK_D9AE79173691D1CA FOREIGN KEY (properties_id) REFERENCES properties (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reports DROP FOREIGN KEY FK_F11FA7453691D1CA');
        $this->addSql('ALTER TABLE reports DROP FOREIGN KEY FK_F11FA745A76ED395');
        $this->addSql('ALTER TABLE reports DROP FOREIGN KEY FK_F11FA74563379586');
        $this->addSql('ALTER TABLE reports DROP FOREIGN KEY FK_F11FA745CC5EBC32');
        $this->addSql('ALTER TABLE reports ADD CONSTRAINT FK_F11FA7453691D1CA FOREIGN KEY (properties_id) REFERENCES properties (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reports ADD CONSTRAINT FK_F11FA745A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reports ADD CONSTRAINT FK_F11FA74563379586 FOREIGN KEY (comments_id) REFERENCES comments (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reports ADD CONSTRAINT FK_F11FA745CC5EBC32 FOREIGN KEY (reportscategories_id) REFERENCES reports_categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA2393691D1CA');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239BBC61482');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239A76ED395');
        $this->addSql('ALTER TABLE reservations CHANGE is_approuved is_approuved TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE is_cancelled is_cancelled TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE is_paid is_paid TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA2393691D1CA FOREIGN KEY (properties_id) REFERENCES properties (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239BBC61482 FOREIGN KEY (payments_id) REFERENCES payments (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attributes DROP FOREIGN KEY FK_319B9E70A21214B7');
        $this->addSql('ALTER TABLE attributes ADD CONSTRAINT FK_319B9E70A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AA76ED395');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AD9A7F869');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AD9A7F869 FOREIGN KEY (reservations_id) REFERENCES reservations (id)');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96FE142757');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96A76ED395');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96FE142757 FOREIGN KEY (conversations_id) REFERENCES conversations (id)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE payments DROP FOREIGN KEY FK_65D29B32A76ED395');
        $this->addSql('ALTER TABLE payments ADD CONSTRAINT FK_65D29B32A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE properties DROP FOREIGN KEY FK_87C331C7A21214B7');
        $this->addSql('ALTER TABLE properties DROP FOREIGN KEY FK_87C331C7A76ED395');
        $this->addSql('ALTER TABLE properties ADD CONSTRAINT FK_87C331C7A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE properties ADD CONSTRAINT FK_87C331C7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE properties_gallery DROP FOREIGN KEY FK_D9AE79173691D1CA');
        $this->addSql('ALTER TABLE properties_gallery ADD CONSTRAINT FK_D9AE79173691D1CA FOREIGN KEY (properties_id) REFERENCES properties (id)');
        $this->addSql('ALTER TABLE reports DROP FOREIGN KEY FK_F11FA745CC5EBC32');
        $this->addSql('ALTER TABLE reports DROP FOREIGN KEY FK_F11FA7453691D1CA');
        $this->addSql('ALTER TABLE reports DROP FOREIGN KEY FK_F11FA74563379586');
        $this->addSql('ALTER TABLE reports DROP FOREIGN KEY FK_F11FA745A76ED395');
        $this->addSql('ALTER TABLE reports ADD CONSTRAINT FK_F11FA745CC5EBC32 FOREIGN KEY (reportscategories_id) REFERENCES reports_categories (id)');
        $this->addSql('ALTER TABLE reports ADD CONSTRAINT FK_F11FA7453691D1CA FOREIGN KEY (properties_id) REFERENCES properties (id)');
        $this->addSql('ALTER TABLE reports ADD CONSTRAINT FK_F11FA74563379586 FOREIGN KEY (comments_id) REFERENCES comments (id)');
        $this->addSql('ALTER TABLE reports ADD CONSTRAINT FK_F11FA745A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239BBC61482');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA2393691D1CA');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239A76ED395');
        $this->addSql('ALTER TABLE reservations CHANGE is_approuved is_approuved TINYINT(1) NOT NULL, CHANGE is_cancelled is_cancelled TINYINT(1) NOT NULL, CHANGE is_paid is_paid TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239BBC61482 FOREIGN KEY (payments_id) REFERENCES payments (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA2393691D1CA FOREIGN KEY (properties_id) REFERENCES properties (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }
}
