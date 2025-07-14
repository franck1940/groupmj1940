<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250628171134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE activities (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, ac_title VARCHAR(180) NOT NULL, act_description VARCHAR(255) DEFAULT NULL, create_date DATE NOT NULL, end_date DATE DEFAULT NULL, status VARCHAR(100) NOT NULL, INDEX IDX_B5F1AFE5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_online (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, start_date DATE NOT NULL, checkout_date DATE DEFAULT NULL, INDEX IDX_FB60A5D7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE activities ADD CONSTRAINT FK_B5F1AFE5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_online ADD CONSTRAINT FK_FB60A5D7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE activities DROP FOREIGN KEY FK_B5F1AFE5A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_online DROP FOREIGN KEY FK_FB60A5D7A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE activities
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_online
        SQL);
    }
}
