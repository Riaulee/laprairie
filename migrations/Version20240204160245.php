<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240204160245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contenu_visual (id INT AUTO_INCREMENT NOT NULL, contenu_visual_name VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, update_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contenu ADD visual_contenu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contenu ADD CONSTRAINT FK_89C2003F5D55C12C FOREIGN KEY (visual_contenu_id) REFERENCES contenu_visual (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_89C2003F5D55C12C ON contenu (visual_contenu_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contenu DROP FOREIGN KEY FK_89C2003F5D55C12C');
        $this->addSql('DROP TABLE contenu_visual');
        $this->addSql('DROP INDEX UNIQ_89C2003F5D55C12C ON contenu');
        $this->addSql('ALTER TABLE contenu DROP visual_contenu_id');
    }
}
