<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130829155655 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, theme_id INT DEFAULT NULL, teacher_id INT DEFAULT NULL, question LONGTEXT NOT NULL, variants LONGTEXT NOT NULL COMMENT '(DC2Type:array)', answer LONGTEXT NOT NULL, rate SMALLINT NOT NULL, type SMALLINT NOT NULL, INDEX IDX_B6F7494E59027487 (theme_id), INDEX IDX_B6F7494E41807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE question ADD CONSTRAINT FK_B6F7494E59027487 FOREIGN KEY (theme_id) REFERENCES theme (id)");
        $this->addSql("ALTER TABLE question ADD CONSTRAINT FK_B6F7494E41807E1D FOREIGN KEY (teacher_id) REFERENCES user (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE question");
    }
}
