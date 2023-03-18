<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230318203842 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creation of JuryMember table as a relation with Member and Contest';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE jury_member (id INT AUTO_INCREMENT NOT NULL, member_id INT NOT NULL, contest_id INT NOT NULL, invitation_date DATETIME NOT NULL, acceptance_date DATETIME NOT NULL, INDEX IDX_B06D92E17597D3FE (member_id), INDEX IDX_B06D92E11CD0F0DE (contest_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE jury_member ADD CONSTRAINT FK_B06D92E17597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id)');
        $this->addSql('ALTER TABLE jury_member ADD CONSTRAINT FK_B06D92E11CD0F0DE FOREIGN KEY (contest_id) REFERENCES `contest` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE jury_member DROP FOREIGN KEY FK_B06D92E17597D3FE');
        $this->addSql('ALTER TABLE jury_member DROP FOREIGN KEY FK_B06D92E11CD0F0DE');
        $this->addSql('DROP TABLE jury_member');
    }
}
