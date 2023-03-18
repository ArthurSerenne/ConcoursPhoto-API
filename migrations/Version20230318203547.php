<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230318203547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creation of Sponsor table as a relation with Organization and Contest';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sponsor (id INT AUTO_INCREMENT NOT NULL, organization_id INT NOT NULL, contest_id INT NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, sponsor_rank INT NOT NULL, amount INT NOT NULL, INDEX IDX_818CC9D432C8A3DE (organization_id), INDEX IDX_818CC9D41CD0F0DE (contest_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sponsor ADD CONSTRAINT FK_818CC9D432C8A3DE FOREIGN KEY (organization_id) REFERENCES `organization` (id)');
        $this->addSql('ALTER TABLE sponsor ADD CONSTRAINT FK_818CC9D41CD0F0DE FOREIGN KEY (contest_id) REFERENCES `contest` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sponsor DROP FOREIGN KEY FK_818CC9D432C8A3DE');
        $this->addSql('ALTER TABLE sponsor DROP FOREIGN KEY FK_818CC9D41CD0F0DE');
        $this->addSql('DROP TABLE sponsor');
    }
}
