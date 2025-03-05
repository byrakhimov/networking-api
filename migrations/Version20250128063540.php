<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250128063540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add Contact entity image , relate to MediaObject ';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E6383DA5256D FOREIGN KEY (image_id) REFERENCES media_object (id)');
        $this->addSql('CREATE INDEX IDX_4C62E6383DA5256D ON contact (image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E6383DA5256D');
        $this->addSql('DROP INDEX IDX_4C62E6383DA5256D ON contact');
        $this->addSql('ALTER TABLE contact ADD image VARCHAR(255) DEFAULT NULL, DROP image_id');
    }
}
