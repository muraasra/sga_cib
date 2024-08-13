<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240813153828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evaluation (id INT AUTO_INCREMENT NOT NULL, stage_id INT NOT NULL, assuiduite VARCHAR(255) DEFAULT NULL, ponctualite VARCHAR(255) DEFAULT NULL, disponibilite VARCHAR(255) DEFAULT NULL, interet VARCHAR(255) DEFAULT NULL, respect VARCHAR(255) DEFAULT NULL, esprit VARCHAR(255) DEFAULT NULL, aptitude VARCHAR(255) DEFAULT NULL, organisation VARCHAR(255) DEFAULT NULL, application VARCHAR(255) DEFAULT NULL, recherche VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_1323A5752298D193 (stage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A5752298D193 FOREIGN KEY (stage_id) REFERENCES stage (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A5752298D193');
        $this->addSql('DROP TABLE evaluation');
    }
}
