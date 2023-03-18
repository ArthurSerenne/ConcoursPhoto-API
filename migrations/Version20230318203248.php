<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230318203248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creation of Vote table as a relation with Member and Photo';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, member_id INT NOT NULL, photo_id INT NOT NULL, date_vote DATETIME NOT NULL, INDEX IDX_5A1085647597D3FE (member_id), INDEX IDX_5A1085647E9E4C8C (photo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085647597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085647E9E4C8C FOREIGN KEY (photo_id) REFERENCES `photo` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A1085647597D3FE');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A1085647E9E4C8C');
        $this->addSql('DROP TABLE vote');
    }
}
