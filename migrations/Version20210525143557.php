<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210525143557 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE games_event ADD game_id INT NOT NULL, ADD event_id INT NOT NULL');
        $this->addSql('ALTER TABLE games_event ADD CONSTRAINT FK_C4BE181BE48FD905 FOREIGN KEY (game_id) REFERENCES games (id)');
        $this->addSql('ALTER TABLE games_event ADD CONSTRAINT FK_C4BE181B71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_C4BE181BE48FD905 ON games_event (game_id)');
        $this->addSql('CREATE INDEX IDX_C4BE181B71F7E88B ON games_event (event_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE games_event DROP FOREIGN KEY FK_C4BE181BE48FD905');
        $this->addSql('ALTER TABLE games_event DROP FOREIGN KEY FK_C4BE181B71F7E88B');
        $this->addSql('DROP INDEX IDX_C4BE181BE48FD905 ON games_event');
        $this->addSql('DROP INDEX IDX_C4BE181B71F7E88B ON games_event');
        $this->addSql('ALTER TABLE games_event DROP game_id, DROP event_id');
    }
}
