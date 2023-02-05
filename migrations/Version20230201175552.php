<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201175552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE changelog ADD element_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE changelog ADD CONSTRAINT FK_C84226011F1F2A24 FOREIGN KEY (element_id) REFERENCES element (id)');
        $this->addSql('CREATE INDEX IDX_C84226011F1F2A24 ON changelog (element_id)');
        $this->addSql('ALTER TABLE version ADD releasedate DATE NOT NULL, DROP name, CHANGE addition addition VARCHAR(10) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE changelog DROP FOREIGN KEY FK_C84226011F1F2A24');
        $this->addSql('DROP INDEX IDX_C84226011F1F2A24 ON changelog');
        $this->addSql('ALTER TABLE changelog DROP element_id');
        $this->addSql('ALTER TABLE version ADD name VARCHAR(255) NOT NULL, DROP releasedate, CHANGE addition addition VARCHAR(10) NOT NULL');
    }
}
