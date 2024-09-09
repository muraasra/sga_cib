<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240906142325 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pv (id INT AUTO_INCREMENT NOT NULL, courrier_demande_id INT DEFAULT NULL, date_pv DATE NOT NULL, path_pv VARCHAR(255) DEFAULT NULL, INDEX IDX_D780BF0014637FB9 (courrier_demande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pv ADD CONSTRAINT FK_D780BF0014637FB9 FOREIGN KEY (courrier_demande_id) REFERENCES controle (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pv DROP FOREIGN KEY FK_D780BF0014637FB9');
        $this->addSql('DROP TABLE pv');
    }
}
