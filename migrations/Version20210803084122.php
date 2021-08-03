<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210803084122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trips ADD trips_place_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trips ADD CONSTRAINT FK_AA7370DA6B184570 FOREIGN KEY (trips_place_id) REFERENCES place (id)');
        $this->addSql('CREATE INDEX IDX_AA7370DA6B184570 ON trips (trips_place_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE trip');
        $this->addSql('ALTER TABLE trips DROP FOREIGN KEY FK_AA7370DA6B184570');
        $this->addSql('DROP INDEX IDX_AA7370DA6B184570 ON trips');
        $this->addSql('ALTER TABLE trips DROP trips_place_id');
    }
}
