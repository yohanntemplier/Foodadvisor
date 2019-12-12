<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191211150458 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE paiement (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paiement_restaurant (paiement_id INT NOT NULL, restaurant_id INT NOT NULL, INDEX IDX_7D5A7CCF2A4C4478 (paiement_id), INDEX IDX_7D5A7CCFB1E7706E (restaurant_id), PRIMARY KEY(paiement_id, restaurant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE paiement_restaurant ADD CONSTRAINT FK_7D5A7CCF2A4C4478 FOREIGN KEY (paiement_id) REFERENCES paiement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE paiement_restaurant ADD CONSTRAINT FK_7D5A7CCFB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE caracteristic_restaurant');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE paiement_restaurant DROP FOREIGN KEY FK_7D5A7CCF2A4C4478');
        $this->addSql('CREATE TABLE caracteristic_restaurant (caracteristic_id INT NOT NULL, restaurant_id INT NOT NULL, INDEX IDX_119595FEB1E7706E (restaurant_id), INDEX IDX_119595FE81194CF4 (caracteristic_id), PRIMARY KEY(caracteristic_id, restaurant_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE caracteristic_restaurant ADD CONSTRAINT FK_119595FE81194CF4 FOREIGN KEY (caracteristic_id) REFERENCES caracteristic (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE caracteristic_restaurant ADD CONSTRAINT FK_119595FEB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE paiement');
        $this->addSql('DROP TABLE paiement_restaurant');
    }
}
