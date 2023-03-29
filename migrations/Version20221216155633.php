<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221216155633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE auto_service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE basket (id INT AUTO_INCREMENT NOT NULL, consignment_id INT NOT NULL, cost DOUBLE PRECISION NOT NULL, INDEX IDX_2246507B97B177ED (consignment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, surname VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, mid_name VARCHAR(255) NOT NULL, phone INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consignment (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, vehicle_id INT NOT NULL, service_id INT NOT NULL, date VARCHAR(255) NOT NULL, INDEX IDX_32B8F88CA76ED395 (user_id), INDEX IDX_32B8F88C545317D1 (vehicle_id), INDEX IDX_32B8F88CED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detail (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, cost DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, cost DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE part_install (id INT AUTO_INCREMENT NOT NULL, detail_id INT NOT NULL, basket_id INT NOT NULL, INDEX IDX_AF964A72D8D003BB (detail_id), INDEX IDX_AF964A721BE1FB52 (basket_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, basket_id INT NOT NULL, job_id INT NOT NULL, INDEX IDX_E19D9AD21BE1FB52 (basket_id), INDEX IDX_E19D9AD2BE04EA9 (job_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, brand_id INT NOT NULL, client_id INT NOT NULL, model VARCHAR(255) NOT NULL, release_date INT NOT NULL, vin VARCHAR(255) NOT NULL, INDEX IDX_1B80E48644F5D008 (brand_id), INDEX IDX_1B80E48619EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE basket ADD CONSTRAINT FK_2246507B97B177ED FOREIGN KEY (consignment_id) REFERENCES consignment (id)');
        $this->addSql('ALTER TABLE consignment ADD CONSTRAINT FK_32B8F88CA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE consignment ADD CONSTRAINT FK_32B8F88C545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE consignment ADD CONSTRAINT FK_32B8F88CED5CA9E6 FOREIGN KEY (service_id) REFERENCES auto_service (id)');
        $this->addSql('ALTER TABLE part_install ADD CONSTRAINT FK_AF964A72D8D003BB FOREIGN KEY (detail_id) REFERENCES detail (id)');
        $this->addSql('ALTER TABLE part_install ADD CONSTRAINT FK_AF964A721BE1FB52 FOREIGN KEY (basket_id) REFERENCES basket (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD21BE1FB52 FOREIGN KEY (basket_id) REFERENCES basket (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E48644F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E48619EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE basket DROP FOREIGN KEY FK_2246507B97B177ED');
        $this->addSql('ALTER TABLE consignment DROP FOREIGN KEY FK_32B8F88CA76ED395');
        $this->addSql('ALTER TABLE consignment DROP FOREIGN KEY FK_32B8F88C545317D1');
        $this->addSql('ALTER TABLE consignment DROP FOREIGN KEY FK_32B8F88CED5CA9E6');
        $this->addSql('ALTER TABLE part_install DROP FOREIGN KEY FK_AF964A72D8D003BB');
        $this->addSql('ALTER TABLE part_install DROP FOREIGN KEY FK_AF964A721BE1FB52');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD21BE1FB52');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2BE04EA9');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E48644F5D008');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E48619EB6921');
        $this->addSql('DROP TABLE auto_service');
        $this->addSql('DROP TABLE basket');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE consignment');
        $this->addSql('DROP TABLE detail');
        $this->addSql('DROP TABLE job');
        $this->addSql('DROP TABLE part_install');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE vehicle');
    }
}
