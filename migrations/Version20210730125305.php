<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210730125305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trips_user (trips_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_7A93E35C6C2C0C (trips_id), INDEX IDX_7A93E35CA76ED395 (user_id), PRIMARY KEY(trips_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trips_user ADD CONSTRAINT FK_7A93E35C6C2C0C FOREIGN KEY (trips_id) REFERENCES trips (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trips_user ADD CONSTRAINT FK_7A93E35CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE trips_user');
    }
}
