<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240830084652 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evaluation DROP INDEX UNIQ_1323A5752298D193, ADD INDEX IDX_1323A5752298D193 (stage_id)');
        $this->addSql('ALTER TABLE evaluation CHANGE stage_id stage_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evaluation DROP INDEX IDX_1323A5752298D193, ADD UNIQUE INDEX UNIQ_1323A5752298D193 (stage_id)');
        $this->addSql('ALTER TABLE evaluation CHANGE stage_id stage_id INT NOT NULL');
    }
}
