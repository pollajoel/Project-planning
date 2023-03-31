<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230305122538 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, phone VARCHAR(255) NOT NULL, zip_code VARCHAR(6) NOT NULL, city VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_type (id INT AUTO_INCREMENT NOT NULL, type_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projects (id INT AUTO_INCREMENT NOT NULL, project_type_id INT NOT NULL, users_id INT DEFAULT NULL, manager_id INT DEFAULT NULL, project_name VARCHAR(255) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_5C93B3A4535280F6 (project_type_id), INDEX IDX_5C93B3A467B3B43D (users_id), INDEX IDX_5C93B3A4783E3463 (manager_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, user_address_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, birth_date DATE DEFAULT NULL, email VARCHAR(255) NOT NULL, login VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D64952D06999 (user_address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A4535280F6 FOREIGN KEY (project_type_id) REFERENCES project_type (id)');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A467B3B43D FOREIGN KEY (users_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A4783E3463 FOREIGN KEY (manager_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D64952D06999 FOREIGN KEY (user_address_id) REFERENCES address (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A4535280F6');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A467B3B43D');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A4783E3463');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64952D06999');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE project_type');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE test');
        $this->addSql('DROP TABLE `user`');
    }
}
