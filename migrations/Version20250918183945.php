<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250918183945 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE menu ADD menu_route VARCHAR(200) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pagecontents ADD expired_date DATETIME DEFAULT NULL, CHANGE create_date create_date DATETIME NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_history_online CHANGE start_date start_date DATETIME NOT NULL, CHANGE checkout_date checkout_date DATETIME DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE user_history_online CHANGE start_date start_date DATE NOT NULL, CHANGE checkout_date checkout_date DATE DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pagecontents DROP expired_date, CHANGE create_date create_date DATE NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE menu DROP menu_route
        SQL);
    }
}
