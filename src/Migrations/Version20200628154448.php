<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200628154448 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE movie_planning (id INT AUTO_INCREMENT NOT NULL, planning_id INT NOT NULL, movie_id INT NOT NULL, starting_time DATETIME NOT NULL, ending_time DATETIME NOT NULL, INDEX IDX_86F247B3D865311 (planning_id), INDEX IDX_86F247B8F93B6FC (movie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planning (id INT AUTO_INCREMENT NOT NULL, starting_date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movie_planning ADD CONSTRAINT FK_86F247B3D865311 FOREIGN KEY (planning_id) REFERENCES planning (id)');
        $this->addSql('ALTER TABLE movie_planning ADD CONSTRAINT FK_86F247B8F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id)');
        $this->addSql('DROP TABLE movies');
        $this->addSql('ALTER TABLE cinema CHANGE phone_number phone_number INT DEFAULT NULL, CHANGE image_path image_path VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE movie ADD name VARCHAR(255) NOT NULL, ADD tmdb_link VARCHAR(255) DEFAULT NULL, DROP movie_name, DROP release_date, DROP rating, DROP run_time, DROP production_companies, CHANGE plot plot LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE reset_password_request CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE movie_planning DROP FOREIGN KEY FK_86F247B3D865311');
        $this->addSql('CREATE TABLE movies (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE movie_planning');
        $this->addSql('DROP TABLE planning');
        $this->addSql('ALTER TABLE cinema CHANGE phone_number phone_number INT DEFAULT NULL, CHANGE image_path image_path VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE movie ADD movie_name VARCHAR(75) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD release_date DATE NOT NULL, ADD rating DOUBLE PRECISION DEFAULT \'NULL\', ADD run_time VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, ADD production_companies VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, DROP name, DROP tmdb_link, CHANGE plot plot VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE reset_password_request CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
