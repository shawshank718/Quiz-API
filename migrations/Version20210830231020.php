<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210830231020 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE question_options (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, question_id INTEGER DEFAULT NULL, option_text CLOB NOT NULL, answer BOOLEAN NOT NULL)');
        $this->addSql('CREATE INDEX IDX_DEE92F9A1E27F6BF ON question_options (question_id)');
        $this->addSql('CREATE TABLE questions (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, question CLOB NOT NULL)');
        $this->addSql('CREATE TABLE quiz_question_mappings (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, quiz_id INTEGER NOT NULL, question_id INTEGER NOT NULL, weight SMALLINT NOT NULL)');
        $this->addSql('CREATE INDEX IDX_FD36FE96853CD175 ON quiz_question_mappings (quiz_id)');
        $this->addSql('CREATE INDEX IDX_FD36FE961E27F6BF ON quiz_question_mappings (question_id)');
        $this->addSql('CREATE TABLE quizzes (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, slug VARCHAR(100) NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE question_options');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE quiz_question_mappings');
        $this->addSql('DROP TABLE quizzes');
    }
}
