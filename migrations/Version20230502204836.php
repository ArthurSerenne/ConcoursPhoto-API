<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502204836 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE social_network ADD CONSTRAINT FK_EFFF522132C8A3DE FOREIGN KEY (organization_id) REFERENCES `organization` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EFFF522132C8A3DE ON social_network (organization_id)');
        $this->addSql('ALTER TABLE sponsor ADD logo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498BAC62AF');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499CEB97F7');
        $this->addSql('DROP INDEX IDX_8D93D6499CEB97F7 ON user');
        $this->addSql('DROP INDEX IDX_8D93D6498BAC62AF ON user');
        $this->addSql('ALTER TABLE user ADD zip_code VARCHAR(255) DEFAULT NULL, ADD city VARCHAR(255) DEFAULT NULL, DROP zip_code_id, DROP city_id, CHANGE status status TINYINT(1) DEFAULT NULL, CHANGE creation_date creation_date DATETIME DEFAULT NULL, CHANGE gender gender VARCHAR(255) DEFAULT NULL, CHANGE firstname firstname VARCHAR(255) DEFAULT NULL, CHANGE lastname lastname VARCHAR(255) DEFAULT NULL, CHANGE birthdate birthdate DATETIME DEFAULT NULL, CHANGE address address VARCHAR(255) DEFAULT NULL, CHANGE country country VARCHAR(255) DEFAULT NULL, CHANGE phone phone VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE social_network DROP FOREIGN KEY FK_EFFF522132C8A3DE');
        $this->addSql('DROP INDEX UNIQ_EFFF522132C8A3DE ON social_network');
        $this->addSql('ALTER TABLE sponsor DROP logo');
        $this->addSql('ALTER TABLE `user` ADD zip_code_id INT DEFAULT NULL, ADD city_id INT DEFAULT NULL, DROP zip_code, DROP city, CHANGE status status TINYINT(1) NOT NULL, CHANGE creation_date creation_date DATETIME NOT NULL, CHANGE gender gender VARCHAR(255) NOT NULL, CHANGE firstname firstname VARCHAR(255) NOT NULL, CHANGE lastname lastname VARCHAR(255) NOT NULL, CHANGE birthdate birthdate DATETIME NOT NULL, CHANGE address address VARCHAR(255) NOT NULL, CHANGE country country VARCHAR(255) NOT NULL, CHANGE phone phone VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6498BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6499CEB97F7 FOREIGN KEY (zip_code_id) REFERENCES department (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6499CEB97F7 ON `user` (zip_code_id)');
        $this->addSql('CREATE INDEX IDX_8D93D6498BAC62AF ON `user` (city_id)');
    }
}
