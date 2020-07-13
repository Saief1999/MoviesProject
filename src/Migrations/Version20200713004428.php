<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200713004428 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cinema CHANGE phone_number phone_number INT DEFAULT NULL, CHANGE image_path image_path VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE cinema_rating ADD user_id INT NOT NULL, DROP name, CHANGE cinema_id cinema_id INT DEFAULT NULL, CHANGE rating rating INT DEFAULT NULL, CHANGE enabled enabled TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE cinema_rating ADD CONSTRAINT FK_31610C88A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_31610C88A76ED395 ON cinema_rating (user_id)');
        $this->addSql('ALTER TABLE movie CHANGE tmdb_link tmdb_link VARCHAR(255) DEFAULT NULL, CHANGE imdb_link imdb_link VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE reset_password_request CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tbl_comment ADD user_id INT NOT NULL, DROP comment_sender_name');
        $this->addSql('ALTER TABLE tbl_comment ADD CONSTRAINT FK_CF275A18A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CF275A18A76ED395 ON tbl_comment (user_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cinema CHANGE phone_number phone_number INT DEFAULT NULL, CHANGE image_path image_path VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE cinema_rating DROP FOREIGN KEY FK_31610C88A76ED395');
        $this->addSql('DROP INDEX IDX_31610C88A76ED395 ON cinema_rating');
        $this->addSql('ALTER TABLE cinema_rating ADD name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, DROP user_id, CHANGE cinema_id cinema_id INT DEFAULT NULL, CHANGE rating rating INT DEFAULT NULL, CHANGE enabled enabled TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE movie CHANGE tmdb_link tmdb_link VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE imdb_link imdb_link VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE reset_password_request CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tbl_comment DROP FOREIGN KEY FK_CF275A18A76ED395');
        $this->addSql('DROP INDEX IDX_CF275A18A76ED395 ON tbl_comment');
        $this->addSql('ALTER TABLE tbl_comment ADD comment_sender_name VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP user_id');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
