<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140228223434 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE test ADD teacher_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE test ADD CONSTRAINT FK_D87F7E0C41807E1D FOREIGN KEY (teacher_id) REFERENCES user (id)");
        $this->addSql("CREATE INDEX IDX_D87F7E0C41807E1D ON test (teacher_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0C41807E1D");
        $this->addSql("DROP INDEX IDX_D87F7E0C41807E1D ON test");
        $this->addSql("ALTER TABLE test DROP teacher_id");
    }
}
