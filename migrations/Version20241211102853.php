<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241211102853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, contenu LONGTEXT NOT NULL, date_commentaire DATE NOT NULL, auteur VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, organisteur_id_id INT NOT NULL, notification_id INT NOT NULL, inscription_id INT NOT NULL, commentaire_id INT NOT NULL, tittre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, lieu VARCHAR(255) NOT NULL, date DATETIME NOT NULL, capacite INT NOT NULL, programme VARCHAR(255) NOT NULL, INDEX IDX_B26681EF822FFA8 (organisteur_id_id), INDEX IDX_B26681EEF1A9D84 (notification_id), INDEX IDX_B26681E5DAC5993 (inscription_id), INDEX IDX_B26681EBA9CD190 (commentaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, registration_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, message VARCHAR(255) NOT NULL, sent_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paiement (id INT AUTO_INCREMENT NOT NULL, inscription_id_id INT NOT NULL, montant INT NOT NULL, reference VARCHAR(255) NOT NULL, mode_paiement VARCHAR(255) NOT NULL, payment_date DATE NOT NULL, UNIQUE INDEX UNIQ_B1DC7A1E2D0DCA1A (inscription_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, inscription_id INT NOT NULL, commentaire_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, INDEX IDX_D79F6B115DAC5993 (inscription_id), INDEX IDX_D79F6B11BA9CD190 (commentaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statistique (id INT AUTO_INCREMENT NOT NULL, evenement_id_id INT NOT NULL, total_participants INT NOT NULL, total_revenue INT NOT NULL, UNIQUE INDEX UNIQ_73A038ADECEE32AF (evenement_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EF822FFA8 FOREIGN KEY (organisteur_id_id) REFERENCES organisateur (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EEF1A9D84 FOREIGN KEY (notification_id) REFERENCES notification (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E5DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EBA9CD190 FOREIGN KEY (commentaire_id) REFERENCES commentaire (id)');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E2D0DCA1A FOREIGN KEY (inscription_id_id) REFERENCES inscription (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B115DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B11BA9CD190 FOREIGN KEY (commentaire_id) REFERENCES commentaire (id)');
        $this->addSql('ALTER TABLE statistique ADD CONSTRAINT FK_73A038ADECEE32AF FOREIGN KEY (evenement_id_id) REFERENCES evenement (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EF822FFA8');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EEF1A9D84');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E5DAC5993');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EBA9CD190');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E2D0DCA1A');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B115DAC5993');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B11BA9CD190');
        $this->addSql('ALTER TABLE statistique DROP FOREIGN KEY FK_73A038ADECEE32AF');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE organisateur');
        $this->addSql('DROP TABLE paiement');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE statistique');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
