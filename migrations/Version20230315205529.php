<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230315205529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initialization of the database';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `ad_space` (id INT AUTO_INCREMENT NOT NULL, status TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, height_px INT NOT NULL, width_px INT NOT NULL, reference_prize INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `contest` (id INT AUTO_INCREMENT NOT NULL, organization_id INT NOT NULL, status TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, theme VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, visual VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, rules VARCHAR(255) NOT NULL, prizes VARCHAR(255) NOT NULL, creation_date DATETIME NOT NULL, publication_date DATETIME NOT NULL, submission_start_date DATETIME NOT NULL, submission_end_date DATETIME NOT NULL, voting_start_date DATETIME NOT NULL, voting_end_date DATETIME NOT NULL, results_date DATETIME NOT NULL, jury_vote_pourcentage INT NOT NULL, vote_max INT NOT NULL, prizes_count INT NOT NULL, age_min INT NOT NULL, age_max INT NOT NULL, country VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, department VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, INDEX IDX_1A95CB532C8A3DE (organization_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `member` (id INT AUTO_INCREMENT NOT NULL, status TINYINT(1) NOT NULL, username VARCHAR(255) NOT NULL, registration_date DATETIME NOT NULL, deletion_date DATETIME NOT NULL, update_date DATETIME NOT NULL, last_login_date DATETIME NOT NULL, photo VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, situation VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, website VARCHAR(255) NOT NULL, social_media VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member_photo (member_id INT NOT NULL, photo_id INT NOT NULL, INDEX IDX_769611EB7597D3FE (member_id), INDEX IDX_769611EB7E9E4C8C (photo_id), PRIMARY KEY(member_id, photo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member_contest (member_id INT NOT NULL, contest_id INT NOT NULL, INDEX IDX_BE5DEB217597D3FE (member_id), INDEX IDX_BE5DEB211CD0F0DE (contest_id), PRIMARY KEY(member_id, contest_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member_won_contest (member_id INT NOT NULL, contest_id INT NOT NULL, INDEX IDX_C12D85347597D3FE (member_id), INDEX IDX_C12D85341CD0F0DE (contest_id), PRIMARY KEY(member_id, contest_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `organization` (id INT AUTO_INCREMENT NOT NULL, status TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, logo VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, zip_code INT NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, website VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organization_ad_space (organization_id INT NOT NULL, ad_space_id INT NOT NULL, INDEX IDX_FB0A591D32C8A3DE (organization_id), INDEX IDX_FB0A591DC94F5E90 (ad_space_id), PRIMARY KEY(organization_id, ad_space_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organization_contest (organization_id INT NOT NULL, contest_id INT NOT NULL, INDEX IDX_CC7BD4F632C8A3DE (organization_id), INDEX IDX_CC7BD4F61CD0F0DE (contest_id), PRIMARY KEY(organization_id, contest_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `photo` (id INT AUTO_INCREMENT NOT NULL, member_id INT NOT NULL, contest_id INT NOT NULL, status TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, submission_date DATETIME NOT NULL, file VARCHAR(255) NOT NULL, vote_count INT NOT NULL, prize_won TINYINT(1) NOT NULL, prize_rank INT NOT NULL, INDEX IDX_14B784187597D3FE (member_id), INDEX IDX_14B784181CD0F0DE (contest_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, member_id INT DEFAULT NULL, status TINYINT(1) NOT NULL, creation_date DATETIME NOT NULL, gender VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, birthdate DATETIME NOT NULL, address VARCHAR(255) NOT NULL, zip_code INT NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D6497597D3FE (member_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_organization (user_id INT NOT NULL, organization_id INT NOT NULL, INDEX IDX_41221F7EA76ED395 (user_id), INDEX IDX_41221F7E32C8A3DE (organization_id), PRIMARY KEY(user_id, organization_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `contest` ADD CONSTRAINT FK_1A95CB532C8A3DE FOREIGN KEY (organization_id) REFERENCES `organization` (id)');
        $this->addSql('ALTER TABLE member_photo ADD CONSTRAINT FK_769611EB7597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_photo ADD CONSTRAINT FK_769611EB7E9E4C8C FOREIGN KEY (photo_id) REFERENCES `photo` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_contest ADD CONSTRAINT FK_BE5DEB217597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_contest ADD CONSTRAINT FK_BE5DEB211CD0F0DE FOREIGN KEY (contest_id) REFERENCES `contest` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_won_contest ADD CONSTRAINT FK_C12D85347597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_won_contest ADD CONSTRAINT FK_C12D85341CD0F0DE FOREIGN KEY (contest_id) REFERENCES `contest` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organization_ad_space ADD CONSTRAINT FK_FB0A591D32C8A3DE FOREIGN KEY (organization_id) REFERENCES `organization` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organization_ad_space ADD CONSTRAINT FK_FB0A591DC94F5E90 FOREIGN KEY (ad_space_id) REFERENCES `ad_space` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organization_contest ADD CONSTRAINT FK_CC7BD4F632C8A3DE FOREIGN KEY (organization_id) REFERENCES `organization` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organization_contest ADD CONSTRAINT FK_CC7BD4F61CD0F0DE FOREIGN KEY (contest_id) REFERENCES `contest` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `photo` ADD CONSTRAINT FK_14B784187597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id)');
        $this->addSql('ALTER TABLE `photo` ADD CONSTRAINT FK_14B784181CD0F0DE FOREIGN KEY (contest_id) REFERENCES `contest` (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6497597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id)');
        $this->addSql('ALTER TABLE user_organization ADD CONSTRAINT FK_41221F7EA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_organization ADD CONSTRAINT FK_41221F7E32C8A3DE FOREIGN KEY (organization_id) REFERENCES `organization` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `contest` DROP FOREIGN KEY FK_1A95CB532C8A3DE');
        $this->addSql('ALTER TABLE member_photo DROP FOREIGN KEY FK_769611EB7597D3FE');
        $this->addSql('ALTER TABLE member_photo DROP FOREIGN KEY FK_769611EB7E9E4C8C');
        $this->addSql('ALTER TABLE member_contest DROP FOREIGN KEY FK_BE5DEB217597D3FE');
        $this->addSql('ALTER TABLE member_contest DROP FOREIGN KEY FK_BE5DEB211CD0F0DE');
        $this->addSql('ALTER TABLE member_won_contest DROP FOREIGN KEY FK_C12D85347597D3FE');
        $this->addSql('ALTER TABLE member_won_contest DROP FOREIGN KEY FK_C12D85341CD0F0DE');
        $this->addSql('ALTER TABLE organization_ad_space DROP FOREIGN KEY FK_FB0A591D32C8A3DE');
        $this->addSql('ALTER TABLE organization_ad_space DROP FOREIGN KEY FK_FB0A591DC94F5E90');
        $this->addSql('ALTER TABLE organization_contest DROP FOREIGN KEY FK_CC7BD4F632C8A3DE');
        $this->addSql('ALTER TABLE organization_contest DROP FOREIGN KEY FK_CC7BD4F61CD0F0DE');
        $this->addSql('ALTER TABLE `photo` DROP FOREIGN KEY FK_14B784187597D3FE');
        $this->addSql('ALTER TABLE `photo` DROP FOREIGN KEY FK_14B784181CD0F0DE');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6497597D3FE');
        $this->addSql('ALTER TABLE user_organization DROP FOREIGN KEY FK_41221F7EA76ED395');
        $this->addSql('ALTER TABLE user_organization DROP FOREIGN KEY FK_41221F7E32C8A3DE');
        $this->addSql('DROP TABLE `ad_space`');
        $this->addSql('DROP TABLE `contest`');
        $this->addSql('DROP TABLE `member`');
        $this->addSql('DROP TABLE member_photo');
        $this->addSql('DROP TABLE member_contest');
        $this->addSql('DROP TABLE member_won_contest');
        $this->addSql('DROP TABLE `organization`');
        $this->addSql('DROP TABLE organization_ad_space');
        $this->addSql('DROP TABLE organization_contest');
        $this->addSql('DROP TABLE `photo`');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_organization');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
