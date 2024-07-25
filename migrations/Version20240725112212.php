<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240725112212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE historique (id INT AUTO_INCREMENT NOT NULL, courrier_id_id INT DEFAULT NULL, envoyeur_id INT NOT NULL, receveur_id INT NOT NULL, date DATETIME NOT NULL, action VARCHAR(255) NOT NULL, is_read TINYINT(1) NOT NULL, INDEX IDX_EDBFD5ECB71D1F67 (courrier_id_id), INDEX IDX_EDBFD5EC4795A786 (envoyeur_id), INDEX IDX_EDBFD5ECB967E626 (receveur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE piece_jointe (id INT AUTO_INCREMENT NOT NULL, lien VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_courrier (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, matricule VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D64912B2DC9C (matricule), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5ECB71D1F67 FOREIGN KEY (courrier_id_id) REFERENCES courrier (id)');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5EC4795A786 FOREIGN KEY (envoyeur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5ECB967E626 FOREIGN KEY (receveur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE courrier ADD type_courrier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE courrier ADD CONSTRAINT FK_BEF47CAAC0EDCA56 FOREIGN KEY (type_courrier_id) REFERENCES type_courrier (id)');
        $this->addSql('CREATE INDEX IDX_BEF47CAAC0EDCA56 ON courrier (type_courrier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE courrier DROP FOREIGN KEY FK_BEF47CAAC0EDCA56');
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5ECB71D1F67');
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5EC4795A786');
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5ECB967E626');
        $this->addSql('DROP TABLE historique');
        $this->addSql('DROP TABLE piece_jointe');
        $this->addSql('DROP TABLE type_courrier');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_BEF47CAAC0EDCA56 ON courrier');
        $this->addSql('ALTER TABLE courrier DROP type_courrier_id');
    }
}
