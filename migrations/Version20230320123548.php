<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320123548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cities (id INT AUTO_INCREMENT NOT NULL, department_code_id INT NOT NULL, insee_code VARCHAR(255) DEFAULT NULL, zip_code VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, gps_lat INT NOT NULL, gps_lng INT NOT NULL, INDEX IDX_D95DB16B9A7316F4 (department_code_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departments (id INT AUTO_INCREMENT NOT NULL, region_code_id INT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_16AEB8D43CC88F90 (region_code_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE regions (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cities ADD CONSTRAINT FK_D95DB16B9A7316F4 FOREIGN KEY (department_code_id) REFERENCES departments (id)');
        $this->addSql('ALTER TABLE departments ADD CONSTRAINT FK_16AEB8D43CC88F90 FOREIGN KEY (region_code_id) REFERENCES regions (id)');
        $this->addSql('ALTER TABLE contest DROP region, DROP department, DROP city');
        $this->addSql('ALTER TABLE member ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA78A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_70E4FA78A76ED395 ON member (user_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497597D3FE');
        $this->addSql('DROP INDEX UNIQ_8D93D6497597D3FE ON user');
        $this->addSql('ALTER TABLE user DROP member_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cities DROP FOREIGN KEY FK_D95DB16B9A7316F4');
        $this->addSql('ALTER TABLE departments DROP FOREIGN KEY FK_16AEB8D43CC88F90');
        $this->addSql('DROP TABLE cities');
        $this->addSql('DROP TABLE departments');
        $this->addSql('DROP TABLE regions');
        $this->addSql('ALTER TABLE `contest` ADD region VARCHAR(255) NOT NULL, ADD department VARCHAR(255) NOT NULL, ADD city VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE `member` DROP FOREIGN KEY FK_70E4FA78A76ED395');
        $this->addSql('DROP INDEX UNIQ_70E4FA78A76ED395 ON `member`');
        $this->addSql('ALTER TABLE `member` DROP user_id');
        $this->addSql('ALTER TABLE `user` ADD member_id INT NOT NULL');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6497597D3FE FOREIGN KEY (member_id) REFERENCES member (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6497597D3FE ON `user` (member_id)');
    }
}
