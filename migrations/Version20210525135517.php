<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210525135517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_event ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE users_event ADD CONSTRAINT FK_DCD9AEEEA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_DCD9AEEEA76ED395 ON users_event (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_event DROP FOREIGN KEY FK_DCD9AEEEA76ED395');
        $this->addSql('DROP INDEX IDX_DCD9AEEEA76ED395 ON users_event');
        $this->addSql('ALTER TABLE users_event DROP user_id');
    }
}
