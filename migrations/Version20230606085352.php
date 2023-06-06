<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230606085352 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reset_password (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, expired_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', token VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B9983CE5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, question_id INT DEFAULT NULL, comment_id INT DEFAULT NULL, is_liked TINYINT(1) NOT NULL, INDEX IDX_5A108564F675F31B (author_id), INDEX IDX_5A1085641E27F6BF (question_id), INDEX IDX_5A108564F8697D13 (comment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reset_password ADD CONSTRAINT FK_B9983CE5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085641E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CBCB134CE');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C541DB185');
        $this->addSql('DROP INDEX IDX_9474526C541DB185 ON comment');
        $this->addSql('DROP INDEX IDX_9474526CBCB134CE ON comment');
        $this->addSql('ALTER TABLE comment ADD question_id INT NOT NULL, ADD author_id INT NOT NULL, DROP comment_user_id, DROP questions_id');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_9474526C1E27F6BF ON comment (question_id)');
        $this->addSql('CREATE INDEX IDX_9474526CF675F31B ON comment (author_id)');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EA9B20688');
        $this->addSql('DROP INDEX IDX_B6F7494EA9B20688 ON question');
        $this->addSql('ALTER TABLE question ADD author_id INT NOT NULL, DROP question_user_id');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494EF675F31B ON question (author_id)');
        $this->addSql('ALTER TABLE user ADD firstname VARCHAR(255) NOT NULL, ADD lastname VARCHAR(255) NOT NULL, ADD picture VARCHAR(255) NOT NULL, DROP first_name, DROP last_name, DROP image');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reset_password DROP FOREIGN KEY FK_B9983CE5A76ED395');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564F675F31B');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A1085641E27F6BF');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564F8697D13');
        $this->addSql('DROP TABLE reset_password');
        $this->addSql('DROP TABLE vote');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C1E27F6BF');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF675F31B');
        $this->addSql('DROP INDEX IDX_9474526C1E27F6BF ON comment');
        $this->addSql('DROP INDEX IDX_9474526CF675F31B ON comment');
        $this->addSql('ALTER TABLE comment ADD comment_user_id INT DEFAULT NULL, ADD questions_id INT DEFAULT NULL, DROP question_id, DROP author_id');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CBCB134CE FOREIGN KEY (questions_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C541DB185 FOREIGN KEY (comment_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_9474526C541DB185 ON comment (comment_user_id)');
        $this->addSql('CREATE INDEX IDX_9474526CBCB134CE ON comment (questions_id)');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EF675F31B');
        $this->addSql('DROP INDEX IDX_B6F7494EF675F31B ON question');
        $this->addSql('ALTER TABLE question ADD question_user_id INT DEFAULT NULL, DROP author_id');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EA9B20688 FOREIGN KEY (question_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494EA9B20688 ON question (question_user_id)');
        $this->addSql('ALTER TABLE user ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL, ADD image VARCHAR(255) NOT NULL, DROP firstname, DROP lastname, DROP picture');
    }
}
