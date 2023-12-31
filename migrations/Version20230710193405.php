<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230710193405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_497DD6345E237E06 ON categorie (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8C9F36105E237E06 ON file (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7E8585C8E7927C74 ON newsletter (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_497DD6345E237E06 ON categorie');
        $this->addSql('DROP INDEX UNIQ_8C9F36105E237E06 ON file');
        $this->addSql('DROP INDEX UNIQ_7E8585C8E7927C74 ON newsletter');
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677 ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
    }
}
