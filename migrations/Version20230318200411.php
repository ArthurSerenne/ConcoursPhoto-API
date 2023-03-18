<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230318200411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Fix database by deleting useless tables';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE member_contest DROP FOREIGN KEY FK_BE5DEB211CD0F0DE');
        $this->addSql('ALTER TABLE member_contest DROP FOREIGN KEY FK_BE5DEB217597D3FE');
        $this->addSql('ALTER TABLE member_photo DROP FOREIGN KEY FK_769611EB7597D3FE');
        $this->addSql('ALTER TABLE member_photo DROP FOREIGN KEY FK_769611EB7E9E4C8C');
        $this->addSql('ALTER TABLE member_won_contest DROP FOREIGN KEY FK_C12D85347597D3FE');
        $this->addSql('ALTER TABLE member_won_contest DROP FOREIGN KEY FK_C12D85341CD0F0DE');
        $this->addSql('ALTER TABLE organization_ad_space DROP FOREIGN KEY FK_FB0A591D32C8A3DE');
        $this->addSql('ALTER TABLE organization_ad_space DROP FOREIGN KEY FK_FB0A591DC94F5E90');
        $this->addSql('ALTER TABLE organization_contest DROP FOREIGN KEY FK_CC7BD4F61CD0F0DE');
        $this->addSql('ALTER TABLE organization_contest DROP FOREIGN KEY FK_CC7BD4F632C8A3DE');
        $this->addSql('ALTER TABLE user_organization DROP FOREIGN KEY FK_41221F7EA76ED395');
        $this->addSql('ALTER TABLE user_organization DROP FOREIGN KEY FK_41221F7E32C8A3DE');
        $this->addSql('DROP TABLE member_contest');
        $this->addSql('DROP TABLE member_photo');
        $this->addSql('DROP TABLE member_won_contest');
        $this->addSql('DROP TABLE organization_ad_space');
        $this->addSql('DROP TABLE organization_contest');
        $this->addSql('DROP TABLE user_organization');
        $this->addSql('ALTER TABLE contest DROP FOREIGN KEY FK_1A95CB532C8A3DE');
        $this->addSql('DROP INDEX IDX_1A95CB532C8A3DE ON contest');
        $this->addSql('ALTER TABLE contest DROP organization_id');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784187597D3FE');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784181CD0F0DE');
        $this->addSql('DROP INDEX IDX_14B784181CD0F0DE ON photo');
        $this->addSql('DROP INDEX IDX_14B784187597D3FE ON photo');
        $this->addSql('ALTER TABLE photo DROP member_id, DROP contest_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497597D3FE');
        $this->addSql('DROP INDEX UNIQ_8D93D6497597D3FE ON user');
        $this->addSql('ALTER TABLE user DROP member_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE member_contest (member_id INT NOT NULL, contest_id INT NOT NULL, INDEX IDX_BE5DEB217597D3FE (member_id), INDEX IDX_BE5DEB211CD0F0DE (contest_id), PRIMARY KEY(member_id, contest_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE member_photo (member_id INT NOT NULL, photo_id INT NOT NULL, INDEX IDX_769611EB7597D3FE (member_id), INDEX IDX_769611EB7E9E4C8C (photo_id), PRIMARY KEY(member_id, photo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE member_won_contest (member_id INT NOT NULL, contest_id INT NOT NULL, INDEX IDX_C12D85341CD0F0DE (contest_id), INDEX IDX_C12D85347597D3FE (member_id), PRIMARY KEY(member_id, contest_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE organization_ad_space (organization_id INT NOT NULL, ad_space_id INT NOT NULL, INDEX IDX_FB0A591D32C8A3DE (organization_id), INDEX IDX_FB0A591DC94F5E90 (ad_space_id), PRIMARY KEY(organization_id, ad_space_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE organization_contest (organization_id INT NOT NULL, contest_id INT NOT NULL, INDEX IDX_CC7BD4F61CD0F0DE (contest_id), INDEX IDX_CC7BD4F632C8A3DE (organization_id), PRIMARY KEY(organization_id, contest_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_organization (user_id INT NOT NULL, organization_id INT NOT NULL, INDEX IDX_41221F7EA76ED395 (user_id), INDEX IDX_41221F7E32C8A3DE (organization_id), PRIMARY KEY(user_id, organization_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE member_contest ADD CONSTRAINT FK_BE5DEB211CD0F0DE FOREIGN KEY (contest_id) REFERENCES contest (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_contest ADD CONSTRAINT FK_BE5DEB217597D3FE FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_photo ADD CONSTRAINT FK_769611EB7597D3FE FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_photo ADD CONSTRAINT FK_769611EB7E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_won_contest ADD CONSTRAINT FK_C12D85347597D3FE FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_won_contest ADD CONSTRAINT FK_C12D85341CD0F0DE FOREIGN KEY (contest_id) REFERENCES contest (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organization_ad_space ADD CONSTRAINT FK_FB0A591D32C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organization_ad_space ADD CONSTRAINT FK_FB0A591DC94F5E90 FOREIGN KEY (ad_space_id) REFERENCES ad_space (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organization_contest ADD CONSTRAINT FK_CC7BD4F61CD0F0DE FOREIGN KEY (contest_id) REFERENCES contest (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organization_contest ADD CONSTRAINT FK_CC7BD4F632C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_organization ADD CONSTRAINT FK_41221F7EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_organization ADD CONSTRAINT FK_41221F7E32C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `contest` ADD organization_id INT NOT NULL');
        $this->addSql('ALTER TABLE `contest` ADD CONSTRAINT FK_1A95CB532C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id)');
        $this->addSql('CREATE INDEX IDX_1A95CB532C8A3DE ON `contest` (organization_id)');
        $this->addSql('ALTER TABLE `photo` ADD member_id INT NOT NULL, ADD contest_id INT NOT NULL');
        $this->addSql('ALTER TABLE `photo` ADD CONSTRAINT FK_14B784187597D3FE FOREIGN KEY (member_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE `photo` ADD CONSTRAINT FK_14B784181CD0F0DE FOREIGN KEY (contest_id) REFERENCES contest (id)');
        $this->addSql('CREATE INDEX IDX_14B784181CD0F0DE ON `photo` (contest_id)');
        $this->addSql('CREATE INDEX IDX_14B784187597D3FE ON `photo` (member_id)');
        $this->addSql('ALTER TABLE `user` ADD member_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6497597D3FE FOREIGN KEY (member_id) REFERENCES member (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6497597D3FE ON `user` (member_id)');
    }
}
