<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20181208172413 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('ALTER TABLE donor ADD COLUMN access_code VARCHAR(255) NOT NULL DEFAULT ""');
        $this->addSQL('UPDATE donor SET access_code = LOWER(HEX(RANDOMBLOB(16))) WHERE access_code=""');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__donor AS SELECT id, name, email, submitted, knows_receiver FROM donor');
        $this->addSql('DROP TABLE donor');
        $this->addSql('CREATE TABLE donor (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, submitted BOOLEAN NOT NULL, knows_receiver BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO donor (id, name, email, submitted, knows_receiver) SELECT id, name, email, submitted, knows_receiver FROM __temp__donor');
        $this->addSql('DROP TABLE __temp__donor');
    }
}
