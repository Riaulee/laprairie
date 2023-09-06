<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230906100324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7A76ED395');
        $this->addSql('DROP INDEX IDX_3BAE0AA7A76ED395 ON event');
        $this->addSql('ALTER TABLE event CHANGE content content VARCHAR(255) NOT NULL, CHANGE user_id id_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA779F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA779F37AE5 ON event (id_user_id)');
        $this->addSql('ALTER TABLE user CHANGE first_name first_name VARCHAR(50) NOT NULL, CHANGE last_name last_name VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE visual DROP FOREIGN KEY FK_EBC9881F71F7E88B');
        $this->addSql('DROP INDEX IDX_EBC9881F71F7E88B ON visual');
        $this->addSql('ALTER TABLE visual CHANGE visual_name visual_name VARCHAR(60) DEFAULT NULL, CHANGE event_id id_event_id INT NOT NULL');
        $this->addSql('ALTER TABLE visual ADD CONSTRAINT FK_EBC9881F212C041E FOREIGN KEY (id_event_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_EBC9881F212C041E ON visual (id_event_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA779F37AE5');
        $this->addSql('DROP INDEX IDX_3BAE0AA779F37AE5 ON event');
        $this->addSql('ALTER TABLE event CHANGE content content LONGTEXT NOT NULL, CHANGE id_user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7A76ED395 ON event (user_id)');
        $this->addSql('ALTER TABLE user CHANGE first_name first_name VARCHAR(45) NOT NULL, CHANGE last_name last_name VARCHAR(45) NOT NULL');
        $this->addSql('ALTER TABLE visual DROP FOREIGN KEY FK_EBC9881F212C041E');
        $this->addSql('DROP INDEX IDX_EBC9881F212C041E ON visual');
        $this->addSql('ALTER TABLE visual CHANGE visual_name visual_name VARCHAR(100) DEFAULT NULL, CHANGE id_event_id event_id INT NOT NULL');
        $this->addSql('ALTER TABLE visual ADD CONSTRAINT FK_EBC9881F71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_EBC9881F71F7E88B ON visual (event_id)');
    }
}
