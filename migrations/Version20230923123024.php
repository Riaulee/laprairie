<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230923123024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D9F78B59E FOREIGN KEY (fkposttype_id) REFERENCES post_type (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D9F78B59E ON post (fkposttype_id)');
        $this->addSql('ALTER TABLE user ADD pseudo VARCHAR(45) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP pseudo');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D9F78B59E');
        $this->addSql('DROP INDEX IDX_5A8A6C8D9F78B59E ON post');
    }
}
