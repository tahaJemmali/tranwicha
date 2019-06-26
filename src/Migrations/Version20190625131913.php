<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190625131913 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, date DATETIME NOT NULL, INDEX IDX_6EEAA67DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingrediant (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kit (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(500) NOT NULL, price DOUBLE PRECISION NOT NULL, image VARCHAR(255) NOT NULL, video VARCHAR(255) NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kit_plat (kit_id INT NOT NULL, plat_id INT NOT NULL, INDEX IDX_DD0100643A8E60EF (kit_id), INDEX IDX_DD010064D73DB560 (plat_id), PRIMARY KEY(kit_id, plat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plat (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, recette VARCHAR(1000) NOT NULL, price DOUBLE PRECISION NOT NULL, video VARCHAR(255) DEFAULT NULL, image VARCHAR(255) NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plat_ingrediant (plat_id INT NOT NULL, ingrediant_id INT NOT NULL, INDEX IDX_E7E4EF27D73DB560 (plat_id), INDEX IDX_E7E4EF278AEA29A (ingrediant_id), PRIMARY KEY(plat_id, ingrediant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE kit_plat ADD CONSTRAINT FK_DD0100643A8E60EF FOREIGN KEY (kit_id) REFERENCES kit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE kit_plat ADD CONSTRAINT FK_DD010064D73DB560 FOREIGN KEY (plat_id) REFERENCES plat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plat_ingrediant ADD CONSTRAINT FK_E7E4EF27D73DB560 FOREIGN KEY (plat_id) REFERENCES plat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plat_ingrediant ADD CONSTRAINT FK_E7E4EF278AEA29A FOREIGN KEY (ingrediant_id) REFERENCES ingrediant (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE plat_ingrediant DROP FOREIGN KEY FK_E7E4EF278AEA29A');
        $this->addSql('ALTER TABLE kit_plat DROP FOREIGN KEY FK_DD0100643A8E60EF');
        $this->addSql('ALTER TABLE kit_plat DROP FOREIGN KEY FK_DD010064D73DB560');
        $this->addSql('ALTER TABLE plat_ingrediant DROP FOREIGN KEY FK_E7E4EF27D73DB560');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE ingrediant');
        $this->addSql('DROP TABLE kit');
        $this->addSql('DROP TABLE kit_plat');
        $this->addSql('DROP TABLE plat');
        $this->addSql('DROP TABLE plat_ingrediant');
    }
}
