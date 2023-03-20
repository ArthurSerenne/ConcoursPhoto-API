<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320131834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_D95DB16B41FD3AD2 ON cities');
        $this->addSql('ALTER TABLE cities CHANGE departments_code department_code INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cities ADD CONSTRAINT FK_D95DB16BD50F57CD FOREIGN KEY (department_code) REFERENCES departments (code)');
        $this->addSql('CREATE INDEX IDX_D95DB16BD50F57CD ON cities (department_code)');
        $this->addSql('ALTER TABLE contest ADD CONSTRAINT FK_1A95CB532C8A3DE FOREIGN KEY (organization_id) REFERENCES `organization` (id)');
        $this->addSql('ALTER TABLE departments ADD CONSTRAINT FK_16AEB8D4AEB327AF FOREIGN KEY (region_code) REFERENCES regions (code)');
        $this->addSql('ALTER TABLE jury_member ADD CONSTRAINT FK_B06D92E17597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id)');
        $this->addSql('ALTER TABLE jury_member ADD CONSTRAINT FK_B06D92E11CD0F0DE FOREIGN KEY (contest_id) REFERENCES `contest` (id)');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA78A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784187597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784181CD0F0DE FOREIGN KEY (contest_id) REFERENCES `contest` (id)');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCC32C8A3DE FOREIGN KEY (organization_id) REFERENCES `organization` (id)');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCCC94F5E90 FOREIGN KEY (ad_space_id) REFERENCES `ad_space` (id)');
        $this->addSql('ALTER TABLE sponsor ADD CONSTRAINT FK_818CC9D432C8A3DE FOREIGN KEY (organization_id) REFERENCES `organization` (id)');
        $this->addSql('ALTER TABLE sponsor ADD CONSTRAINT FK_818CC9D41CD0F0DE FOREIGN KEY (contest_id) REFERENCES `contest` (id)');
        $this->addSql('ALTER TABLE user_organization ADD CONSTRAINT FK_41221F7EA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_organization ADD CONSTRAINT FK_41221F7E32C8A3DE FOREIGN KEY (organization_id) REFERENCES `organization` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085647597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085647E9E4C8C FOREIGN KEY (photo_id) REFERENCES `photo` (id)');
        $this->addSql('ALTER TABLE win ADD CONSTRAINT FK_B0CA3B767597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id)');
        $this->addSql('ALTER TABLE win ADD CONSTRAINT FK_B0CA3B761CD0F0DE FOREIGN KEY (contest_id) REFERENCES `contest` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cities DROP FOREIGN KEY FK_D95DB16BD50F57CD');
        $this->addSql('DROP INDEX IDX_D95DB16BD50F57CD ON cities');
        $this->addSql('ALTER TABLE cities CHANGE department_code departments_code INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_D95DB16B41FD3AD2 ON cities (departments_code)');
        $this->addSql('ALTER TABLE `contest` DROP FOREIGN KEY FK_1A95CB532C8A3DE');
        $this->addSql('ALTER TABLE departments DROP FOREIGN KEY FK_16AEB8D4AEB327AF');
        $this->addSql('ALTER TABLE jury_member DROP FOREIGN KEY FK_B06D92E17597D3FE');
        $this->addSql('ALTER TABLE jury_member DROP FOREIGN KEY FK_B06D92E11CD0F0DE');
        $this->addSql('ALTER TABLE `member` DROP FOREIGN KEY FK_70E4FA78A76ED395');
        $this->addSql('ALTER TABLE `photo` DROP FOREIGN KEY FK_14B784187597D3FE');
        $this->addSql('ALTER TABLE `photo` DROP FOREIGN KEY FK_14B784181CD0F0DE');
        $this->addSql('ALTER TABLE rent DROP FOREIGN KEY FK_2784DCC32C8A3DE');
        $this->addSql('ALTER TABLE rent DROP FOREIGN KEY FK_2784DCCC94F5E90');
        $this->addSql('ALTER TABLE sponsor DROP FOREIGN KEY FK_818CC9D432C8A3DE');
        $this->addSql('ALTER TABLE sponsor DROP FOREIGN KEY FK_818CC9D41CD0F0DE');
        $this->addSql('ALTER TABLE user_organization DROP FOREIGN KEY FK_41221F7EA76ED395');
        $this->addSql('ALTER TABLE user_organization DROP FOREIGN KEY FK_41221F7E32C8A3DE');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A1085647597D3FE');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A1085647E9E4C8C');
        $this->addSql('ALTER TABLE win DROP FOREIGN KEY FK_B0CA3B767597D3FE');
        $this->addSql('ALTER TABLE win DROP FOREIGN KEY FK_B0CA3B761CD0F0DE');
    }
}
