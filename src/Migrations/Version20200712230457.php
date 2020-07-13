<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200712230457 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cinema_rating (id INT AUTO_INCREMENT NOT NULL, cinema_id INT DEFAULT NULL, my_cinema_id INT DEFAULT NULL, rating INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, INDEX IDX_31610C88B4CB84B6 (cinema_id), INDEX IDX_31610C88529A8A22 (my_cinema_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cinema_rating ADD CONSTRAINT FK_31610C88B4CB84B6 FOREIGN KEY (cinema_id) REFERENCES cinema (id)');
        $this->addSql('ALTER TABLE cinema_rating ADD CONSTRAINT FK_31610C88529A8A22 FOREIGN KEY (my_cinema_id) REFERENCES cinema (id)');
        $this->addSql('ALTER TABLE cinema CHANGE phone_number phone_number INT DEFAULT NULL, CHANGE image_path image_path VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE movie CHANGE tmdb_link tmdb_link VARCHAR(255) DEFAULT NULL, CHANGE imdb_link imdb_link VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6B4CB84B6 FOREIGN KEY (cinema_id) REFERENCES cinema (id)');
        $this->addSql('CREATE INDEX IDX_D499BFF6B4CB84B6 ON planning (cinema_id)');
        $this->addSql('ALTER TABLE reset_password_request CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE cinema_rating');
        $this->addSql('ALTER TABLE cinema CHANGE phone_number phone_number INT DEFAULT NULL, CHANGE image_path image_path VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE movie CHANGE tmdb_link tmdb_link VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE imdb_link imdb_link VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF6B4CB84B6');
        $this->addSql('DROP INDEX IDX_D499BFF6B4CB84B6 ON planning');
        $this->addSql('ALTER TABLE reset_password_request CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
