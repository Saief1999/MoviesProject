<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200610181824 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE movie_genre (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE registered_user_movie_genre (registered_user_id INT NOT NULL, movie_genre_id INT NOT NULL, INDEX IDX_EED0CDD7A6A12EC1 (registered_user_id), INDEX IDX_EED0CDD79E604892 (movie_genre_id), PRIMARY KEY(registered_user_id, movie_genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE registered_user_movie_genre ADD CONSTRAINT FK_EED0CDD7A6A12EC1 FOREIGN KEY (registered_user_id) REFERENCES registered_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE registered_user_movie_genre ADD CONSTRAINT FK_EED0CDD79E604892 FOREIGN KEY (movie_genre_id) REFERENCES movie_genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cinema CHANGE phone_number phone_number INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE registered_user_movie_genre DROP FOREIGN KEY FK_EED0CDD79E604892');
        $this->addSql('DROP TABLE movie_genre');
        $this->addSql('DROP TABLE registered_user_movie_genre');
        $this->addSql('ALTER TABLE cinema CHANGE phone_number phone_number INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
