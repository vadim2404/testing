<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130828172105 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE user ADD pulpit_id INT DEFAULT NULL, ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL, ADD middle_name VARCHAR(255) NOT NULL");
        $this->addSql("ALTER TABLE user ADD CONSTRAINT FK_8D93D6495C515D0A FOREIGN KEY (pulpit_id) REFERENCES pulpit (id)");
        $this->addSql("CREATE INDEX IDX_8D93D6495C515D0A ON user (pulpit_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495C515D0A");
        $this->addSql("DROP INDEX IDX_8D93D6495C515D0A ON user");
        $this->addSql("ALTER TABLE user DROP pulpit_id, DROP first_name, DROP last_name, DROP middle_name");
    }
}
