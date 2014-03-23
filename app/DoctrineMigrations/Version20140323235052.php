<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140323235052 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE result_test ADD plan_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE result_test ADD CONSTRAINT FK_48446542E899029B FOREIGN KEY (plan_id) REFERENCES plan (id)");
        $this->addSql("CREATE INDEX IDX_48446542E899029B ON result_test (plan_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE result_test DROP FOREIGN KEY FK_48446542E899029B");
        $this->addSql("DROP INDEX IDX_48446542E899029B ON result_test");
        $this->addSql("ALTER TABLE result_test DROP plan_id");
    }
}
