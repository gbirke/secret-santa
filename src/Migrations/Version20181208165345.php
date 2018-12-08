<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181208165345 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE donor (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, submitted BOOLEAN NOT NULL, knows_receiver BOOLEAN NOT NULL)');
        $this->addSql('CREATE TABLE receiver (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, donor_id INTEGER NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3DB88C963DD7B7A7 ON receiver (donor_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE donor');
        $this->addSql('DROP TABLE receiver');
    }
}
