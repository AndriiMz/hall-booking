<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181021184526 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cena (id INT AUTO_INCREMENT NOT NULL, sala_id INT DEFAULT NULL, data_do DATETIME NOT NULL, data_od DATETIME NOT NULL, wartosc INT NOT NULL, INDEX IDX_870099DDC51CDF3F (sala_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE klient (id INT AUTO_INCREMENT NOT NULL, nazwa VARCHAR(255) NOT NULL, telefon VARCHAR(15) NOT NULL, email VARCHAR(50) NOT NULL, miasto VARCHAR(50) NOT NULL, adress VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE opcja (id INT AUTO_INCREMENT NOT NULL, nazwa VARCHAR(255) NOT NULL, opis VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rezerwacja (id INT AUTO_INCREMENT NOT NULL, sala_id INT DEFAULT NULL, klient_id INT DEFAULT NULL, data_od DATETIME DEFAULT NULL, data_do DATETIME DEFAULT NULL, ilosc_os INT DEFAULT NULL, komentarz VARCHAR(255) DEFAULT NULL, INDEX IDX_8268B0CBC51CDF3F (sala_id), INDEX IDX_8268B0CBA233CB39 (klient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pracownik (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(50) NOT NULL, passwrd VARCHAR(50) NOT NULL, nazwisko VARCHAR(50) NOT NULL, imie VARCHAR(50) NOT NULL, data_ur DATETIME DEFAULT NULL, telefon VARCHAR(20) NOT NULL, email VARCHAR(50) DEFAULT NULL, miasto VARCHAR(50) DEFAULT NULL, adres VARCHAR(50) NOT NULL, pesel VARCHAR(50) NOT NULL, pensja INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wynajencie (id INT AUTO_INCREMENT NOT NULL, rezewacja_id INT DEFAULT NULL, suma INT DEFAULT NULL, UNIQUE INDEX UNIQ_A38D12B0A9947340 (rezewacja_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sala (id INT AUTO_INCREMENT NOT NULL, pracownik_id INT DEFAULT NULL, nazwa VARCHAR(255) NOT NULL, miasto VARCHAR(255) NOT NULL, adresa VARCHAR(255) NOT NULL, powierzchnia INT NOT NULL, INDEX IDX_E226041C51E53502 (pracownik_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE opcja_sali (id_sali INT NOT NULL, id_opcji INT NOT NULL, INDEX IDX_F635977A67DD902C (id_sali), INDEX IDX_F635977AB917D985 (id_opcji), PRIMARY KEY(id_sali, id_opcji)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cena ADD CONSTRAINT FK_870099DDC51CDF3F FOREIGN KEY (sala_id) REFERENCES sala (id)');
        $this->addSql('ALTER TABLE rezerwacja ADD CONSTRAINT FK_8268B0CBC51CDF3F FOREIGN KEY (sala_id) REFERENCES sala (id)');
        $this->addSql('ALTER TABLE rezerwacja ADD CONSTRAINT FK_8268B0CBA233CB39 FOREIGN KEY (klient_id) REFERENCES klient (id)');
        $this->addSql('ALTER TABLE wynajencie ADD CONSTRAINT FK_A38D12B0A9947340 FOREIGN KEY (rezewacja_id) REFERENCES rezerwacja (id)');
        $this->addSql('ALTER TABLE sala ADD CONSTRAINT FK_E226041C51E53502 FOREIGN KEY (pracownik_id) REFERENCES pracownik (id)');
        $this->addSql('ALTER TABLE opcja_sali ADD CONSTRAINT FK_F635977A67DD902C FOREIGN KEY (id_sali) REFERENCES sala (id)');
        $this->addSql('ALTER TABLE opcja_sali ADD CONSTRAINT FK_F635977AB917D985 FOREIGN KEY (id_opcji) REFERENCES opcja (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rezerwacja DROP FOREIGN KEY FK_8268B0CBA233CB39');
        $this->addSql('ALTER TABLE opcja_sali DROP FOREIGN KEY FK_F635977AB917D985');
        $this->addSql('ALTER TABLE wynajencie DROP FOREIGN KEY FK_A38D12B0A9947340');
        $this->addSql('ALTER TABLE sala DROP FOREIGN KEY FK_E226041C51E53502');
        $this->addSql('ALTER TABLE cena DROP FOREIGN KEY FK_870099DDC51CDF3F');
        $this->addSql('ALTER TABLE rezerwacja DROP FOREIGN KEY FK_8268B0CBC51CDF3F');
        $this->addSql('ALTER TABLE opcja_sali DROP FOREIGN KEY FK_F635977A67DD902C');
        $this->addSql('DROP TABLE cena');
        $this->addSql('DROP TABLE klient');
        $this->addSql('DROP TABLE opcja');
        $this->addSql('DROP TABLE rezerwacja');
        $this->addSql('DROP TABLE pracownik');
        $this->addSql('DROP TABLE wynajencie');
        $this->addSql('DROP TABLE sala');
        $this->addSql('DROP TABLE opcja_sali');
    }
}
