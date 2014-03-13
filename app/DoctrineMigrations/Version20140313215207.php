<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140313215207 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE plan ADD planedby_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE plan ADD CONSTRAINT FK_DD5A5B7DF629D998 FOREIGN KEY (planedby_id) REFERENCES user (id)");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_DD5A5B7DF629D998 ON plan (planedby_id)");
        $this->addSql("ALTER TABLE test_theme DROP PRIMARY KEY");
        $this->addSql("ALTER TABLE test_theme ADD PRIMARY KEY (test_id, theme_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE plan DROP FOREIGN KEY FK_DD5A5B7DF629D998");
        $this->addSql("DROP INDEX UNIQ_DD5A5B7DF629D998 ON plan");
        $this->addSql("ALTER TABLE plan DROP planedby_id");
        $this->addSql("ALTER TABLE test_theme DROP PRIMARY KEY");
        $this->addSql("ALTER TABLE test_theme ADD PRIMARY KEY (theme_id, test_id)");
    }
}
