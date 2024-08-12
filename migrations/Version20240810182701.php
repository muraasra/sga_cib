<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240810182701 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stagiaire ADD encadreur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stagiaire ADD CONSTRAINT FK_4F62F731A625A0FD FOREIGN KEY (encadreur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4F62F731A625A0FD ON stagiaire (encadreur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stagiaire DROP FOREIGN KEY FK_4F62F731A625A0FD');
        $this->addSql('DROP INDEX IDX_4F62F731A625A0FD ON stagiaire');
        $this->addSql('ALTER TABLE stagiaire DROP encadreur_id');
    }
}
