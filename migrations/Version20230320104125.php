<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320104125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_organization (user_id INT NOT NULL, organization_id INT NOT NULL, INDEX IDX_41221F7EA76ED395 (user_id), INDEX IDX_41221F7E32C8A3DE (organization_id), PRIMARY KEY(user_id, organization_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_organization ADD CONSTRAINT FK_41221F7EA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_organization ADD CONSTRAINT FK_41221F7E32C8A3DE FOREIGN KEY (organization_id) REFERENCES `organization` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contest ADD organization_id INT NOT NULL');
        $this->addSql('ALTER TABLE contest ADD CONSTRAINT FK_1A95CB532C8A3DE FOREIGN KEY (organization_id) REFERENCES `organization` (id)');
        $this->addSql('CREATE INDEX IDX_1A95CB532C8A3DE ON contest (organization_id)');
        $this->addSql('ALTER TABLE organization DROP zip_code, CHANGE city city_zip_code VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE photo ADD member_id INT NOT NULL, ADD contest_id INT NOT NULL');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784187597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784181CD0F0DE FOREIGN KEY (contest_id) REFERENCES `contest` (id)');
        $this->addSql('CREATE INDEX IDX_14B784187597D3FE ON photo (member_id)');
        $this->addSql('CREATE INDEX IDX_14B784181CD0F0DE ON photo (contest_id)');
        $this->addSql('ALTER TABLE user CHANGE zip_code member_id INT NOT NULL, CHANGE city city_zip_code VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6497597D3FE ON user (member_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_organization DROP FOREIGN KEY FK_41221F7EA76ED395');
        $this->addSql('ALTER TABLE user_organization DROP FOREIGN KEY FK_41221F7E32C8A3DE');
        $this->addSql('DROP TABLE user_organization');
        $this->addSql('ALTER TABLE `contest` DROP FOREIGN KEY FK_1A95CB532C8A3DE');
        $this->addSql('DROP INDEX IDX_1A95CB532C8A3DE ON `contest`');
        $this->addSql('ALTER TABLE `contest` DROP organization_id');
        $this->addSql('ALTER TABLE `organization` ADD zip_code INT NOT NULL, CHANGE city_zip_code city VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE `photo` DROP FOREIGN KEY FK_14B784187597D3FE');
        $this->addSql('ALTER TABLE `photo` DROP FOREIGN KEY FK_14B784181CD0F0DE');
        $this->addSql('DROP INDEX IDX_14B784187597D3FE ON `photo`');
        $this->addSql('DROP INDEX IDX_14B784181CD0F0DE ON `photo`');
        $this->addSql('ALTER TABLE `photo` DROP member_id, DROP contest_id');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6497597D3FE');
        $this->addSql('DROP INDEX UNIQ_8D93D6497597D3FE ON `user`');
        $this->addSql('ALTER TABLE `user` CHANGE member_id zip_code INT NOT NULL, CHANGE city_zip_code city VARCHAR(255) NOT NULL');
    }
}
