<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231116110853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE `currency`
                    (
                        `id` INT AUTO_INCREMENT PRIMARY KEY,
                        `name` VARCHAR(50) NOT NULL,
                        `code` VARCHAR(3) NOT NULL UNIQUE
                    );'
        );
        $this->addSql(
            'CREATE TABLE `exchange_rate` 
                    (
                        `id` INT AUTO_INCREMENT PRIMARY KEY,
                        `currency_id` INT NOT NULL,
                        `date_time` DATETIME NOT NULL,
                        `rate` DECIMAL(10, 4) NOT NULL,
                        FOREIGN KEY (`currency_id`) REFERENCES `currency`(`id`)
                    );'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `exchange_rate`;');
        $this->addSql('DROP TABLE `currency`;');
    }
}
