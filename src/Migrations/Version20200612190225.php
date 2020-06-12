<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200612190225 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cinema ADD name VARCHAR(50) NOT NULL, CHANGE phone_number phone_number INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cinema_owner ADD cinema_id INT NOT NULL');
        $this->addSql('ALTER TABLE cinema_owner ADD CONSTRAINT FK_44EF797AB4CB84B6 FOREIGN KEY (cinema_id) REFERENCES cinema (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_44EF797AB4CB84B6 ON cinema_owner (cinema_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cinema DROP name, CHANGE phone_number phone_number INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cinema_owner DROP FOREIGN KEY FK_44EF797AB4CB84B6');
        $this->addSql('DROP INDEX UNIQ_44EF797AB4CB84B6 ON cinema_owner');
        $this->addSql('ALTER TABLE cinema_owner DROP cinema_id');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
