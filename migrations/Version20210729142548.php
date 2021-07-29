<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210729142548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trips (id INT AUTO_INCREMENT NOT NULL, statement_id INT NOT NULL, state_id INT NOT NULL, name VARCHAR(255) NOT NULL, date_start DATE NOT NULL, duration INT NOT NULL, limit_register_date DATE NOT NULL, max_registrations INT NOT NULL, trip_informations LONGTEXT DEFAULT NULL, INDEX IDX_AA7370DA849CB65B (statement_id), INDEX IDX_AA7370DA5D83CC1 (state_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trips ADD CONSTRAINT FK_AA7370DA849CB65B FOREIGN KEY (statement_id) REFERENCES campus (id)');
        $this->addSql('ALTER TABLE trips ADD CONSTRAINT FK_AA7370DA5D83CC1 FOREIGN KEY (state_id) REFERENCES state (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE trips');
    }
}
