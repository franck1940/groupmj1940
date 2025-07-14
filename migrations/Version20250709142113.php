<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250709142113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE pagecontents CHANGE content_text content_text VARCHAR(2048) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users CHANGE city city VARCHAR(10) NOT NULL, CHANGE country country VARCHAR(20) NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE users CHANGE city city VARCHAR(100) NOT NULL, CHANGE country country VARCHAR(100) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pagecontents CHANGE content_text content_text VARCHAR(512) DEFAULT NULL
        SQL);
    }
}
