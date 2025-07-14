<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250623171744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE pagecontents_htmltemplates DROP FOREIGN KEY FK_90FB251FC5708CEE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pagecontents_htmltemplates DROP FOREIGN KEY FK_90FB251FDCBCE07E
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE pagecontents_htmltemplates
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pagecontents ADD content_template_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pagecontents ADD CONSTRAINT FK_3AD21B9F56F0A53E FOREIGN KEY (content_template_id) REFERENCES htmltemplates (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_3AD21B9F56F0A53E ON pagecontents (content_template_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE pagecontents_htmltemplates (htmlpage_id INT NOT NULL, htmltemplates_id INT NOT NULL, INDEX IDX_90FB251FC5708CEE (htmlpage_id), INDEX IDX_90FB251FDCBCE07E (htmltemplates_id), PRIMARY KEY(htmlpage_id, htmltemplates_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pagecontents_htmltemplates ADD CONSTRAINT FK_90FB251FC5708CEE FOREIGN KEY (htmlpage_id) REFERENCES pagecontents (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pagecontents_htmltemplates ADD CONSTRAINT FK_90FB251FDCBCE07E FOREIGN KEY (htmltemplates_id) REFERENCES htmltemplates (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pagecontents DROP FOREIGN KEY FK_3AD21B9F56F0A53E
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_3AD21B9F56F0A53E ON pagecontents
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pagecontents DROP content_template_id
        SQL);
    }
}
