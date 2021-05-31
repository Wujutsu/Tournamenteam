<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210531201651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE convertation ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE convertation ADD CONSTRAINT FK_978B1651A76ED395 FOREIGN KEY (user_id) REFERENCES contact (id)');
        $this->addSql('CREATE INDEX IDX_978B1651A76ED395 ON convertation (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE convertation DROP FOREIGN KEY FK_978B1651A76ED395');
        $this->addSql('DROP INDEX IDX_978B1651A76ED395 ON convertation');
        $this->addSql('ALTER TABLE convertation DROP user_id');
    }
}
