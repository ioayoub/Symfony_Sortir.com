<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210729143033 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trips DROP FOREIGN KEY FK_AA7370DA849CB65B');
        $this->addSql('DROP INDEX IDX_AA7370DA849CB65B ON trips');
        $this->addSql('ALTER TABLE trips CHANGE statement_id campus_id INT NOT NULL');
        $this->addSql('ALTER TABLE trips ADD CONSTRAINT FK_AA7370DAAF5D55E1 FOREIGN KEY (campus_id) REFERENCES campus (id)');
        $this->addSql('CREATE INDEX IDX_AA7370DAAF5D55E1 ON trips (campus_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trips DROP FOREIGN KEY FK_AA7370DAAF5D55E1');
        $this->addSql('DROP INDEX IDX_AA7370DAAF5D55E1 ON trips');
        $this->addSql('ALTER TABLE trips CHANGE campus_id statement_id INT NOT NULL');
        $this->addSql('ALTER TABLE trips ADD CONSTRAINT FK_AA7370DA849CB65B FOREIGN KEY (statement_id) REFERENCES campus (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_AA7370DA849CB65B ON trips (statement_id)');
    }
}
