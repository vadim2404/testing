<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140225182023 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE test_theme (theme_id INT NOT NULL, test_id INT NOT NULL, INDEX IDX_9CAB410359027487 (theme_id), INDEX IDX_9CAB41031E5D0459 (test_id), PRIMARY KEY(theme_id, test_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE test_question (question_id INT NOT NULL, test_id INT NOT NULL, INDEX IDX_239442181E27F6BF (question_id), INDEX IDX_239442181E5D0459 (test_id), PRIMARY KEY(question_id, test_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, subject_id INT DEFAULT NULL, type SMALLINT NOT NULL, title VARCHAR(255) NOT NULL, max_questions INT NOT NULL, INDEX IDX_D87F7E0C23EDC87 (subject_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE variant (id INT AUTO_INCREMENT NOT NULL, test_id INT DEFAULT NULL, number INT NOT NULL, INDEX IDX_F143BFAD1E5D0459 (test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE test_theme ADD CONSTRAINT FK_9CAB410359027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE test_theme ADD CONSTRAINT FK_9CAB41031E5D0459 FOREIGN KEY (test_id) REFERENCES test (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE test_question ADD CONSTRAINT FK_239442181E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE test_question ADD CONSTRAINT FK_239442181E5D0459 FOREIGN KEY (test_id) REFERENCES test (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE test ADD CONSTRAINT FK_D87F7E0C23EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id)");
        $this->addSql("ALTER TABLE variant ADD CONSTRAINT FK_F143BFAD1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE test_theme DROP FOREIGN KEY FK_9CAB41031E5D0459");
        $this->addSql("ALTER TABLE test_question DROP FOREIGN KEY FK_239442181E5D0459");
        $this->addSql("ALTER TABLE variant DROP FOREIGN KEY FK_F143BFAD1E5D0459");
        $this->addSql("DROP TABLE test_theme");
        $this->addSql("DROP TABLE test_question");
        $this->addSql("DROP TABLE test");
        $this->addSql("DROP TABLE variant");
    }
}
