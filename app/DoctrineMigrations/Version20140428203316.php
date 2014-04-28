<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140428203316 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE variant_question (variant_id INT NOT NULL, question_id INT NOT NULL, INDEX IDX_292708C63B69A9AF (variant_id), INDEX IDX_292708C61E27F6BF (question_id), PRIMARY KEY(variant_id, question_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE variant_question ADD CONSTRAINT FK_292708C63B69A9AF FOREIGN KEY (variant_id) REFERENCES variant (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE variant_question ADD CONSTRAINT FK_292708C61E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE variant_question");
    }
}
