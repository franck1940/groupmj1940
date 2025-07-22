<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250717134107 extends AbstractMigration
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
            CREATE TABLE global_sharing (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(150) NOT NULL, messages VARCHAR(255) NOT NULL, status VARCHAR(40) NOT NULL, sharing_end_date DATE NOT NULL, INDEX IDX_C5052C89A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE htmltemplates (id INT AUTO_INCREMENT NOT NULL, template_name VARCHAR(100) NOT NULL, description VARCHAR(1000) NOT NULL, create_date DATE NOT NULL, front_or_backend VARCHAR(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE logindata (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, userrightmg_id INT DEFAULT NULL, loginname VARCHAR(200) NOT NULL, password VARCHAR(200) NOT NULL, UNIQUE INDEX UNIQ_9ECA1DA367B3B43D (users_id), UNIQUE INDEX UNIQ_9ECA1DA31DA246 (userrightmg_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, parent_id INT DEFAULT NULL, create_date DATE NOT NULL, is_active TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE pagecontents (id INT AUTO_INCREMENT NOT NULL, menu_id INT DEFAULT NULL, content_template_id INT DEFAULT NULL, content_text VARCHAR(2048) DEFAULT NULL, title VARCHAR(100) DEFAULT NULL, picture VARCHAR(100) DEFAULT NULL, create_date DATE NOT NULL, INDEX IDX_3AD21B9FCCD7E912 (menu_id), INDEX IDX_3AD21B9F56F0A53E (content_template_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT '(DC2Type:json)', password VARCHAR(255) NOT NULL, totp_secret VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D64967B3B43D (users_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_user_rights (user_id INT NOT NULL, user_rights_id INT NOT NULL, INDEX IDX_CD2903ABA76ED395 (user_id), INDEX IDX_CD2903ABB176638A (user_rights_id), PRIMARY KEY(user_id, user_rights_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_history_online (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, start_date DATE NOT NULL, checkout_date DATE DEFAULT NULL, INDEX IDX_26382D40A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_right_management (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_right_management_user_rights (user_right_management_id INT NOT NULL, user_rights_id INT NOT NULL, INDEX IDX_8FB02C93884273C2 (user_right_management_id), INDEX IDX_8FB02C93B176638A (user_rights_id), PRIMARY KEY(user_right_management_id, user_rights_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_rights (id INT AUTO_INCREMENT NOT NULL, right_title VARCHAR(100) NOT NULL, abbreviation VARCHAR(40) NOT NULL, create_date DATE DEFAULT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, title VARCHAR(10) DEFAULT NULL, gender VARCHAR(10) NOT NULL, phone_number VARCHAR(20) DEFAULT NULL, birthday DATE NOT NULL, street_name VARCHAR(40) NOT NULL, house_number INT NOT NULL, zipcode INT NOT NULL, city VARCHAR(10) NOT NULL, country VARCHAR(20) NOT NULL, email VARCHAR(100) NOT NULL, picture VARCHAR(40) DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE activities ADD CONSTRAINT FK_B5F1AFE5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE global_sharing ADD CONSTRAINT FK_C5052C89A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE logindata ADD CONSTRAINT FK_9ECA1DA367B3B43D FOREIGN KEY (users_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE logindata ADD CONSTRAINT FK_9ECA1DA31DA246 FOREIGN KEY (userrightmg_id) REFERENCES user_right_management (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pagecontents ADD CONSTRAINT FK_3AD21B9FCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pagecontents ADD CONSTRAINT FK_3AD21B9F56F0A53E FOREIGN KEY (content_template_id) REFERENCES htmltemplates (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD CONSTRAINT FK_8D93D64967B3B43D FOREIGN KEY (users_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_user_rights ADD CONSTRAINT FK_CD2903ABA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_user_rights ADD CONSTRAINT FK_CD2903ABB176638A FOREIGN KEY (user_rights_id) REFERENCES user_rights (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_history_online ADD CONSTRAINT FK_26382D40A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_right_management_user_rights ADD CONSTRAINT FK_8FB02C93884273C2 FOREIGN KEY (user_right_management_id) REFERENCES user_right_management (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_right_management_user_rights ADD CONSTRAINT FK_8FB02C93B176638A FOREIGN KEY (user_rights_id) REFERENCES user_rights (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE activities DROP FOREIGN KEY FK_B5F1AFE5A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE global_sharing DROP FOREIGN KEY FK_C5052C89A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE logindata DROP FOREIGN KEY FK_9ECA1DA367B3B43D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE logindata DROP FOREIGN KEY FK_9ECA1DA31DA246
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pagecontents DROP FOREIGN KEY FK_3AD21B9FCCD7E912
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pagecontents DROP FOREIGN KEY FK_3AD21B9F56F0A53E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP FOREIGN KEY FK_8D93D64967B3B43D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_user_rights DROP FOREIGN KEY FK_CD2903ABA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_user_rights DROP FOREIGN KEY FK_CD2903ABB176638A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_history_online DROP FOREIGN KEY FK_26382D40A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_right_management_user_rights DROP FOREIGN KEY FK_8FB02C93884273C2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_right_management_user_rights DROP FOREIGN KEY FK_8FB02C93B176638A
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE activities
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE global_sharing
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE htmltemplates
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE logindata
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE menu
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE pagecontents
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_user_rights
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_history_online
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_right_management
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_right_management_user_rights
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_rights
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE users
        SQL);
    }
}
