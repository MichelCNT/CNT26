<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230709140333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F361093CB796C');
        $this->addSql('DROP INDEX IDX_8C9F361093CB796C ON file');
        $this->addSql('ALTER TABLE file CHANGE file_id files_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610A3E65B2F FOREIGN KEY (files_id) REFERENCES file (id)');
        $this->addSql('CREATE INDEX IDX_8C9F3610A3E65B2F ON file (files_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610A3E65B2F');
        $this->addSql('DROP INDEX IDX_8C9F3610A3E65B2F ON file');
        $this->addSql('ALTER TABLE file CHANGE files_id file_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F361093CB796C FOREIGN KEY (file_id) REFERENCES file (id)');
        $this->addSql('CREATE INDEX IDX_8C9F361093CB796C ON file (file_id)');
    }
}
