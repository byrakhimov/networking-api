<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250129162057 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'added property relationship to entity Contact, related to Contact';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact ADD relationship_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E6382C41D668 FOREIGN KEY (relationship_id) REFERENCES contact (id)');
        $this->addSql('CREATE INDEX IDX_4C62E6382C41D668 ON contact (relationship_id)');
        $this->addSql('ALTER TABLE meeting DROP FOREIGN KEY FK_F515E139217BBB47');
        $this->addSql('DROP INDEX IDX_F515E139217BBB47 ON meeting');
        $this->addSql('ALTER TABLE meeting CHANGE person_id contact_id INT NOT NULL');
        $this->addSql('ALTER TABLE meeting ADD CONSTRAINT FK_F515E139E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
        $this->addSql('CREATE INDEX IDX_F515E139E7A1254A ON meeting (contact_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meeting DROP FOREIGN KEY FK_F515E139E7A1254A');
        $this->addSql('DROP INDEX IDX_F515E139E7A1254A ON meeting');
        $this->addSql('ALTER TABLE meeting CHANGE contact_id person_id INT NOT NULL');
        $this->addSql('ALTER TABLE meeting ADD CONSTRAINT FK_F515E139217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('CREATE INDEX IDX_F515E139217BBB47 ON meeting (person_id)');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E6382C41D668');
        $this->addSql('DROP INDEX IDX_4C62E6382C41D668 ON contact');
        $this->addSql('ALTER TABLE contact DROP relationship_id');
    }
}
