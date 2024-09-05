<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240905110406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE controle (id INT AUTO_INCREMENT NOT NULL, courrier_demande_id INT DEFAULT NULL, statut_demande TINYINT(1) NOT NULL, statut_controle TINYINT(1) DEFAULT NULL, date_controle DATE DEFAULT NULL, UNIQUE INDEX UNIQ_E39396E14637FB9 (courrier_demande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE controle ADD CONSTRAINT FK_E39396E14637FB9 FOREIGN KEY (courrier_demande_id) REFERENCES courrier (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE controle DROP FOREIGN KEY FK_E39396E14637FB9');
        $this->addSql('DROP TABLE controle');
    }
}
