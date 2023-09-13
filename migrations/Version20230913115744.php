<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230913115744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT FK_653627B84B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('CREATE INDEX IDX_653627B84B89032C ON post_like (post_id)');
        $this->addSql('ALTER TABLE visual ADD CONSTRAINT FK_EBC9881F9514AA5C FOREIGN KEY (id_post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE visual RENAME INDEX idx_ebc9881f212c041e TO IDX_EBC9881F9514AA5C');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_like DROP FOREIGN KEY FK_653627B84B89032C');
        $this->addSql('DROP INDEX IDX_653627B84B89032C ON post_like');
        $this->addSql('ALTER TABLE visual DROP FOREIGN KEY FK_EBC9881F9514AA5C');
        $this->addSql('ALTER TABLE visual RENAME INDEX idx_ebc9881f9514aa5c TO IDX_EBC9881F212C041E');
    }
}
