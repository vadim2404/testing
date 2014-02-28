<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140228213735 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE test_question");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE test_question (question_id INT NOT NULL, test_id INT NOT NULL, INDEX IDX_239442181E27F6BF (question_id), INDEX IDX_239442181E5D0459 (test_id), PRIMARY KEY(question_id, test_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE test_question ADD CONSTRAINT FK_239442181E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE test_question ADD CONSTRAINT FK_239442181E5D0459 FOREIGN KEY (test_id) REFERENCES test (id) ON DELETE CASCADE");
    }
}
