<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181231110332 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(25) NOT NULL, password VARCHAR(64) NOT NULL, first_name VARCHAR(40) NOT NULL, email VARCHAR(60) NOT NULL, city VARCHAR(60) NOT NULL, address VARCHAR(60) NOT NULL, phone VARCHAR(60) NOT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE administrator (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, hall_id INT DEFAULT NULL, file_path VARCHAR(100) NOT NULL, INDEX IDX_C53D045F52AFCFD6 (hall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rent (id INT AUTO_INCREMENT NOT NULL, booking_id INT DEFAULT NULL, approved_by_id INT DEFAULT NULL, amount INT DEFAULT NULL, UNIQUE INDEX UNIQ_2784DCC3301C60 (booking_id), INDEX IDX_2784DCC2D234F6A (approved_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT NOT NULL, pesel VARCHAR(50) NOT NULL, salary INT NOT NULL, birth_date DATETIME DEFAULT NULL, last_name VARCHAR(40) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, hall_id INT DEFAULT NULL, client_id INT DEFAULT NULL, date_from DATETIME DEFAULT NULL, date_to DATETIME DEFAULT NULL, peoples_count INT DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, INDEX IDX_E00CEDDE52AFCFD6 (hall_id), INDEX IDX_E00CEDDE19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE price (id INT AUTO_INCREMENT NOT NULL, hall_id INT DEFAULT NULL, date_from DATETIME NOT NULL, date_to DATETIME NOT NULL, value INT NOT NULL, INDEX IDX_CAC822D952AFCFD6 (hall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hall (id INT AUTO_INCREMENT NOT NULL, employee_id INT DEFAULT NULL, name_h VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, area INT NOT NULL, INDEX IDX_1B8FA83F8C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hall_option (hall_id INT NOT NULL, option_id INT NOT NULL, INDEX IDX_BC7F56D652AFCFD6 (hall_id), INDEX IDX_BC7F56D6A7C41D6F (option_id), PRIMARY KEY(hall_id, option_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE options (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE administrator ADD CONSTRAINT FK_58DF0651BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F52AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCC3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCC2D234F6A FOREIGN KEY (approved_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE52AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE19EB6921 FOREIGN KEY (client_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE price ADD CONSTRAINT FK_CAC822D952AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id)');
        $this->addSql('ALTER TABLE hall ADD CONSTRAINT FK_1B8FA83F8C03F15C FOREIGN KEY (employee_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE hall_option ADD CONSTRAINT FK_BC7F56D652AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id)');
        $this->addSql('ALTER TABLE hall_option ADD CONSTRAINT FK_BC7F56D6A7C41D6F FOREIGN KEY (option_id) REFERENCES options (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE administrator DROP FOREIGN KEY FK_58DF0651BF396750');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455BF396750');
        $this->addSql('ALTER TABLE rent DROP FOREIGN KEY FK_2784DCC2D234F6A');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1BF396750');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE19EB6921');
        $this->addSql('ALTER TABLE hall DROP FOREIGN KEY FK_1B8FA83F8C03F15C');
        $this->addSql('ALTER TABLE rent DROP FOREIGN KEY FK_2784DCC3301C60');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F52AFCFD6');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE52AFCFD6');
        $this->addSql('ALTER TABLE price DROP FOREIGN KEY FK_CAC822D952AFCFD6');
        $this->addSql('ALTER TABLE hall_option DROP FOREIGN KEY FK_BC7F56D652AFCFD6');
        $this->addSql('ALTER TABLE hall_option DROP FOREIGN KEY FK_BC7F56D6A7C41D6F');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE administrator');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE rent');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE price');
        $this->addSql('DROP TABLE hall');
        $this->addSql('DROP TABLE hall_option');
        $this->addSql('DROP TABLE options');
    }
}
