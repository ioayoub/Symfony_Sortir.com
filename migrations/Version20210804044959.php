<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210804044959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trips ADD is_registered TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE trips_user DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE trips_user ADD PRIMARY KEY (user_id, trips_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trips DROP is_registered');
        $this->addSql('ALTER TABLE trips_user DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE trips_user ADD PRIMARY KEY (trips_id, user_id)');
    }
}
