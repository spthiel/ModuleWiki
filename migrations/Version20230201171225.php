<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201171225 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE changelog (id INT AUTO_INCREMENT NOT NULL, version_id INT DEFAULT NULL, type INT NOT NULL, message LONGTEXT NOT NULL, INDEX IDX_C84226014BBC2705 (version_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE element (id INT AUTO_INCREMENT NOT NULL, module_id INT NOT NULL, since_id INT NOT NULL, type VARCHAR(20) NOT NULL, name VARCHAR(40) NOT NULL, extended_name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, example LONGTEXT DEFAULT NULL, permission VARCHAR(255) DEFAULT NULL, INDEX IDX_41405E39AFC2B591 (module_id), INDEX IDX_41405E3920473888 (since_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE element_element (element_source INT NOT NULL, element_target INT NOT NULL, INDEX IDX_B6AB1E6DD69D76E7 (element_source), INDEX IDX_B6AB1E6DCF782668 (element_target), PRIMARY KEY(element_source, element_target)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE link (id INT AUTO_INCREMENT NOT NULL, element_id INT NOT NULL, url VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_36AC99F11F1F2A24 (element_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE version (id INT AUTO_INCREMENT NOT NULL, module_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, major INT NOT NULL, minor INT NOT NULL, patch INT NOT NULL, addition VARCHAR(10) NOT NULL, INDEX IDX_BF1CD3C3AFC2B591 (module_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE changelog ADD CONSTRAINT FK_C84226014BBC2705 FOREIGN KEY (version_id) REFERENCES version (id)');
        $this->addSql('ALTER TABLE element ADD CONSTRAINT FK_41405E39AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
        $this->addSql('ALTER TABLE element ADD CONSTRAINT FK_41405E3920473888 FOREIGN KEY (since_id) REFERENCES version (id)');
        $this->addSql('ALTER TABLE element_element ADD CONSTRAINT FK_B6AB1E6DD69D76E7 FOREIGN KEY (element_source) REFERENCES element (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE element_element ADD CONSTRAINT FK_B6AB1E6DCF782668 FOREIGN KEY (element_target) REFERENCES element (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE link ADD CONSTRAINT FK_36AC99F11F1F2A24 FOREIGN KEY (element_id) REFERENCES element (id)');
        $this->addSql('ALTER TABLE version ADD CONSTRAINT FK_BF1CD3C3AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE changelog DROP FOREIGN KEY FK_C84226014BBC2705');
        $this->addSql('ALTER TABLE element DROP FOREIGN KEY FK_41405E39AFC2B591');
        $this->addSql('ALTER TABLE element DROP FOREIGN KEY FK_41405E3920473888');
        $this->addSql('ALTER TABLE element_element DROP FOREIGN KEY FK_B6AB1E6DD69D76E7');
        $this->addSql('ALTER TABLE element_element DROP FOREIGN KEY FK_B6AB1E6DCF782668');
        $this->addSql('ALTER TABLE link DROP FOREIGN KEY FK_36AC99F11F1F2A24');
        $this->addSql('ALTER TABLE version DROP FOREIGN KEY FK_BF1CD3C3AFC2B591');
        $this->addSql('DROP TABLE changelog');
        $this->addSql('DROP TABLE element');
        $this->addSql('DROP TABLE element_element');
        $this->addSql('DROP TABLE link');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE version');
    }
}
