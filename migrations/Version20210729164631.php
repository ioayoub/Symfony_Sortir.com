<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210729164631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trips ADD is_organizer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trips ADD CONSTRAINT FK_AA7370DAA7D2AE04 FOREIGN KEY (is_organizer_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AA7370DAA7D2AE04 ON trips (is_organizer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trips DROP FOREIGN KEY FK_AA7370DAA7D2AE04');
        $this->addSql('DROP INDEX IDX_AA7370DAA7D2AE04 ON trips');
        $this->addSql('ALTER TABLE trips DROP is_organizer_id');
    }
}
