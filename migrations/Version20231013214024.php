<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231013214024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_invoice (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, invoice_id INT DEFAULT NULL, quantity INT NOT NULL, size VARCHAR(255) NOT NULL, price_ht DOUBLE PRECISION NOT NULL, color VARCHAR(255) NOT NULL, INDEX IDX_41BC0CF44584665A (product_id), INDEX IDX_41BC0CF42989F1FD (invoice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_invoice ADD CONSTRAINT FK_41BC0CF44584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_invoice ADD CONSTRAINT FK_41BC0CF42989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_invoice DROP FOREIGN KEY FK_41BC0CF44584665A');
        $this->addSql('ALTER TABLE product_invoice DROP FOREIGN KEY FK_41BC0CF42989F1FD');
        $this->addSql('DROP TABLE product_invoice');
    }
}
