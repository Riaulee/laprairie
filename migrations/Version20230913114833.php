<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230913114833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_like DROP FOREIGN KEY FK_653627B871F7E88B');
        $this->addSql('ALTER TABLE visual DROP FOREIGN KEY FK_EBC9881F212C041E');
        $this->addSql('CREATE TABLE ext_log_entries (id INT AUTO_INCREMENT NOT NULL, action VARCHAR(8) NOT NULL, logged_at DATETIME NOT NULL, object_id VARCHAR(64) DEFAULT NULL, object_class VARCHAR(191) NOT NULL, version INT NOT NULL, data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', username VARCHAR(191) DEFAULT NULL, INDEX log_class_lookup_idx (object_class), INDEX log_date_lookup_idx (logged_at), INDEX log_user_lookup_idx (username), INDEX log_version_lookup_idx (object_id, object_class, version), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB ROW_FORMAT = DYNAMIC');
        $this->addSql('CREATE TABLE ext_translations (id INT AUTO_INCREMENT NOT NULL, locale VARCHAR(8) NOT NULL, object_class VARCHAR(191) NOT NULL, field VARCHAR(32) NOT NULL, foreign_key VARCHAR(64) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX translations_lookup_idx (locale, object_class, foreign_key), INDEX general_translations_lookup_idx (object_class, foreign_key), UNIQUE INDEX lookup_unique_idx (locale, object_class, field, foreign_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB ROW_FORMAT = DYNAMIC');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, title VARCHAR(255) NOT NULL, subtitle VARCHAR(255) DEFAULT NULL, content VARCHAR(255) NOT NULL, facebook_flag TINYINT(1) DEFAULT NULL, instagram_flag TINYINT(1) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', update_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_5A8A6C8D79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA779F37AE5');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP INDEX IDX_653627B871F7E88B ON post_like');
        $this->addSql('ALTER TABLE post_like CHANGE event_id post_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT FK_653627B84B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('CREATE INDEX IDX_653627B84B89032C ON post_like (post_id)');
        $this->addSql('DROP INDEX IDX_EBC9881F212C041E ON visual');
        $this->addSql('ALTER TABLE visual CHANGE id_event_id id_post_id INT NOT NULL');
        $this->addSql('ALTER TABLE visual ADD CONSTRAINT FK_EBC9881F9514AA5C FOREIGN KEY (id_post_id) REFERENCES post (id)');
        $this->addSql('CREATE INDEX IDX_EBC9881F9514AA5C ON visual (id_post_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_like DROP FOREIGN KEY FK_653627B84B89032C');
        $this->addSql('ALTER TABLE visual DROP FOREIGN KEY FK_EBC9881F9514AA5C');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, subtitle VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, content VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, facebook_flag TINYINT(1) DEFAULT NULL, instagram_flag TINYINT(1) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', update_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_3BAE0AA779F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA779F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D79F37AE5');
        $this->addSql('DROP TABLE ext_log_entries');
        $this->addSql('DROP TABLE ext_translations');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP INDEX IDX_653627B84B89032C ON post_like');
        $this->addSql('ALTER TABLE post_like CHANGE post_id event_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT FK_653627B871F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_653627B871F7E88B ON post_like (event_id)');
        $this->addSql('DROP INDEX IDX_EBC9881F9514AA5C ON visual');
        $this->addSql('ALTER TABLE visual CHANGE id_post_id id_event_id INT NOT NULL');
        $this->addSql('ALTER TABLE visual ADD CONSTRAINT FK_EBC9881F212C041E FOREIGN KEY (id_event_id) REFERENCES event (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_EBC9881F212C041E ON visual (id_event_id)');
    }
}
