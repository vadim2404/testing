<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140323231851 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE result_test (id INT AUTO_INCREMENT NOT NULL, test_id INT DEFAULT NULL, student_id INT DEFAULT NULL, INDEX IDX_484465421E5D0459 (test_id), INDEX IDX_48446542CB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE result_question (id INT AUTO_INCREMENT NOT NULL, result_test_id INT DEFAULT NULL, question_id INT DEFAULT NULL, answer LONGTEXT NOT NULL, result DOUBLE PRECISION NOT NULL, INDEX IDX_11F256AD7C6486BD (result_test_id), INDEX IDX_11F256AD1E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE result_test ADD CONSTRAINT FK_484465421E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)");
        $this->addSql("ALTER TABLE result_test ADD CONSTRAINT FK_48446542CB944F1A FOREIGN KEY (student_id) REFERENCES user (id)");
        $this->addSql("ALTER TABLE result_question ADD CONSTRAINT FK_11F256AD7C6486BD FOREIGN KEY (result_test_id) REFERENCES result_test (id)");
        $this->addSql("ALTER TABLE result_question ADD CONSTRAINT FK_11F256AD1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE result_question DROP FOREIGN KEY FK_11F256AD7C6486BD");
        $this->addSql("DROP TABLE result_test");
        $this->addSql("DROP TABLE result_question");
    }
}
