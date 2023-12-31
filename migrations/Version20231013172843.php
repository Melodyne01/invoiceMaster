<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231013172843 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, supplier_id INT DEFAULT NULL, billing_address_id INT DEFAULT NULL, delivery_address_id INT DEFAULT NULL, number VARCHAR(255) DEFAULT NULL, price_ht DOUBLE PRECISION NOT NULL, INDEX IDX_906517442ADD6D8C (supplier_id), INDEX IDX_9065174479D0C0E4 (billing_address_id), INDEX IDX_90651744EBF23851 (delivery_address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_906517442ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_9065174479D0C0E4 FOREIGN KEY (billing_address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_90651744EBF23851 FOREIGN KEY (delivery_address_id) REFERENCES address (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_906517442ADD6D8C');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_9065174479D0C0E4');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_90651744EBF23851');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE product');
    }
}
