<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200610143433 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cinema ADD opening_time TIME NOT NULL, ADD closing_time TIME NOT NULL, CHANGE phone_number phone_number INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cinema_owner ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE cinema_owner ADD CONSTRAINT FK_44EF797AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_44EF797AA76ED395 ON cinema_owner (user_id)');
        $this->addSql('ALTER TABLE registered_user ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE registered_user ADD CONSTRAINT FK_8B903F56A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8B903F56A76ED395 ON registered_user (user_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cinema DROP opening_time, DROP closing_time, CHANGE phone_number phone_number INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cinema_owner DROP FOREIGN KEY FK_44EF797AA76ED395');
        $this->addSql('DROP INDEX UNIQ_44EF797AA76ED395 ON cinema_owner');
        $this->addSql('ALTER TABLE cinema_owner DROP user_id');
        $this->addSql('ALTER TABLE registered_user DROP FOREIGN KEY FK_8B903F56A76ED395');
        $this->addSql('DROP INDEX UNIQ_8B903F56A76ED395 ON registered_user');
        $this->addSql('ALTER TABLE registered_user DROP user_id');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
