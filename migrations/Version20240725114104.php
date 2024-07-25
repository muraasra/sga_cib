<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240725114104 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE piece_jointe ADD courrier_id INT NOT NULL');
        $this->addSql('ALTER TABLE piece_jointe ADD CONSTRAINT FK_AB5111D48BF41DC7 FOREIGN KEY (courrier_id) REFERENCES courrier (id)');
        $this->addSql('CREATE INDEX IDX_AB5111D48BF41DC7 ON piece_jointe (courrier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE piece_jointe DROP FOREIGN KEY FK_AB5111D48BF41DC7');
        $this->addSql('DROP INDEX IDX_AB5111D48BF41DC7 ON piece_jointe');
        $this->addSql('ALTER TABLE piece_jointe DROP courrier_id');
    }
}
