<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250628201318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE user_history_online (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, start_date DATE NOT NULL, checkout_date DATE DEFAULT NULL, INDEX IDX_26382D40A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_history_online ADD CONSTRAINT FK_26382D40A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_online DROP FOREIGN KEY FK_FB60A5D7A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_online
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE user_online (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, start_date DATE NOT NULL, checkout_date DATE DEFAULT NULL, INDEX IDX_FB60A5D7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_online ADD CONSTRAINT FK_FB60A5D7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_history_online DROP FOREIGN KEY FK_26382D40A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_history_online
        SQL);
    }
}
