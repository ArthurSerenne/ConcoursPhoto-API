<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320130054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cities DROP FOREIGN KEY FK_D95DB16B9A7316F4');
        $this->addSql('DROP INDEX IDX_D95DB16B9A7316F4 ON cities');
        $this->addSql('ALTER TABLE cities ADD department_code INT DEFAULT NULL, DROP department_code_id');
        $this->addSql('ALTER TABLE cities ADD CONSTRAINT FK_D95DB16BD50F57CD FOREIGN KEY (department_code) REFERENCES departments (code)');
        $this->addSql('CREATE INDEX IDX_D95DB16BD50F57CD ON cities (department_code)');
        $this->addSql('ALTER TABLE departments DROP FOREIGN KEY FK_16AEB8D43CC88F90');
        $this->addSql('DROP INDEX IDX_16AEB8D43CC88F90 ON departments');
        $this->addSql('ALTER TABLE departments ADD region_code INT DEFAULT NULL, DROP region_code_id, CHANGE code code INT NOT NULL');
        $this->addSql('ALTER TABLE departments ADD CONSTRAINT FK_16AEB8D4AEB327AF FOREIGN KEY (region_code) REFERENCES regions (code)');
        $this->addSql('CREATE INDEX IDX_16AEB8D4AEB327AF ON departments (region_code)');
        $this->addSql('ALTER TABLE regions CHANGE code code INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cities DROP FOREIGN KEY FK_D95DB16BD50F57CD');
        $this->addSql('DROP INDEX IDX_D95DB16BD50F57CD ON cities');
        $this->addSql('ALTER TABLE cities ADD department_code_id INT NOT NULL, DROP department_code');
        $this->addSql('ALTER TABLE cities ADD CONSTRAINT FK_D95DB16B9A7316F4 FOREIGN KEY (department_code_id) REFERENCES departments (id)');
        $this->addSql('CREATE INDEX IDX_D95DB16B9A7316F4 ON cities (department_code_id)');
        $this->addSql('ALTER TABLE departments DROP FOREIGN KEY FK_16AEB8D4AEB327AF');
        $this->addSql('DROP INDEX IDX_16AEB8D4AEB327AF ON departments');
        $this->addSql('ALTER TABLE departments ADD region_code_id INT NOT NULL, DROP region_code, CHANGE code code VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE departments ADD CONSTRAINT FK_16AEB8D43CC88F90 FOREIGN KEY (region_code_id) REFERENCES regions (id)');
        $this->addSql('CREATE INDEX IDX_16AEB8D43CC88F90 ON departments (region_code_id)');
        $this->addSql('ALTER TABLE regions CHANGE code code VARCHAR(255) NOT NULL');
    }
}
