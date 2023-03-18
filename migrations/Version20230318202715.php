<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230318202715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creation of Rent table as a relation with Organization and AdSpace';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rent (id INT AUTO_INCREMENT NOT NULL, organization_id INT NOT NULL, ad_space_id INT NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, click_url INT NOT NULL, alt_tag VARCHAR(255) NOT NULL, price_sold INT NOT NULL, click_count INT NOT NULL, INDEX IDX_2784DCC32C8A3DE (organization_id), INDEX IDX_2784DCCC94F5E90 (ad_space_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCC32C8A3DE FOREIGN KEY (organization_id) REFERENCES `organization` (id)');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCCC94F5E90 FOREIGN KEY (ad_space_id) REFERENCES `ad_space` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rent DROP FOREIGN KEY FK_2784DCC32C8A3DE');
        $this->addSql('ALTER TABLE rent DROP FOREIGN KEY FK_2784DCCC94F5E90');
        $this->addSql('DROP TABLE rent');
    }
}
