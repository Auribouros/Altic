<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190207191138 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE entrainement (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, duree INT NOT NULL, date DATE NOT NULL, INDEX IDX_A27444E5FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jeu (id INT AUTO_INCREMENT NOT NULL, chemin_acces VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau (id INT AUTO_INCREMENT NOT NULL, jeu_id INT NOT NULL, personnagejouable_id INT DEFAULT NULL, numero INT NOT NULL, ecart_entre_les_reponses INT NOT NULL, nombre_de_reponses INT NOT NULL, nb_reponses_proposees_de_la_meme_table INT NOT NULL, reponses_similaires TINYINT(1) NOT NULL, temps_disponible INT DEFAULT NULL, ordre_des_questions VARCHAR(20) NOT NULL, questions_atrous TINYINT(1) NOT NULL, INDEX IDX_4BDFF36B8C9E392E (jeu_id), INDEX IDX_4BDFF36B9F6741CC (personnagejouable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau_entrainement (niveau_id INT NOT NULL, entrainement_id INT NOT NULL, INDEX IDX_D8FB9F7FB3E9C81 (niveau_id), INDEX IDX_D8FB9F7FA15E8FD (entrainement_id), PRIMARY KEY(niveau_id, entrainement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau_utilisateur (niveau_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_F89D5138B3E9C81 (niveau_id), INDEX IDX_F89D5138FB88E14F (utilisateur_id), PRIMARY KEY(niveau_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personnage_jouable (id INT AUTO_INCREMENT NOT NULL, personnage_debloque TINYINT(1) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pnj (id INT AUTO_INCREMENT NOT NULL, region_id INT NOT NULL, image VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_FDA97F2D98260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, entrainement_id INT DEFAULT NULL, libelle VARCHAR(10) NOT NULL, reponse_enfant INT NOT NULL, INDEX IDX_B6F7494EA15E8FD (entrainement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_reponse_propose (question_id INT NOT NULL, reponse_propose_id INT NOT NULL, INDEX IDX_707CC5741E27F6BF (question_id), INDEX IDX_707CC574E164760E (reponse_propose_id), PRIMARY KEY(question_id, reponse_propose_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, tabledemultiplication_id INT NOT NULL, nom VARCHAR(20) NOT NULL, img_magicien VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_F62F176B19628D7 (tabledemultiplication_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse_propose (id INT AUTO_INCREMENT NOT NULL, reponse INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE table_de_multiplication (id INT AUTO_INCREMENT NOT NULL, numero INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE table_de_multiplication_niveau (table_de_multiplication_id INT NOT NULL, niveau_id INT NOT NULL, INDEX IDX_CF72D3989D3437F8 (table_de_multiplication_id), INDEX IDX_CF72D398B3E9C81 (niveau_id), PRIMARY KEY(table_de_multiplication_id, niveau_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, avatar VARCHAR(255) NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, est_enseignant TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_personnage_jouable (utilisateur_id INT NOT NULL, personnage_jouable_id INT NOT NULL, INDEX IDX_A652D440FB88E14F (utilisateur_id), INDEX IDX_A652D44078B79E04 (personnage_jouable_id), PRIMARY KEY(utilisateur_id, personnage_jouable_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entrainement ADD CONSTRAINT FK_A27444E5FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE niveau ADD CONSTRAINT FK_4BDFF36B8C9E392E FOREIGN KEY (jeu_id) REFERENCES jeu (id)');
        $this->addSql('ALTER TABLE niveau ADD CONSTRAINT FK_4BDFF36B9F6741CC FOREIGN KEY (personnagejouable_id) REFERENCES personnage_jouable (id)');
        $this->addSql('ALTER TABLE niveau_entrainement ADD CONSTRAINT FK_D8FB9F7FB3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE niveau_entrainement ADD CONSTRAINT FK_D8FB9F7FA15E8FD FOREIGN KEY (entrainement_id) REFERENCES entrainement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE niveau_utilisateur ADD CONSTRAINT FK_F89D5138B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE niveau_utilisateur ADD CONSTRAINT FK_F89D5138FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pnj ADD CONSTRAINT FK_FDA97F2D98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EA15E8FD FOREIGN KEY (entrainement_id) REFERENCES entrainement (id)');
        $this->addSql('ALTER TABLE question_reponse_propose ADD CONSTRAINT FK_707CC5741E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_reponse_propose ADD CONSTRAINT FK_707CC574E164760E FOREIGN KEY (reponse_propose_id) REFERENCES reponse_propose (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE region ADD CONSTRAINT FK_F62F176B19628D7 FOREIGN KEY (tabledemultiplication_id) REFERENCES table_de_multiplication (id)');
        $this->addSql('ALTER TABLE table_de_multiplication_niveau ADD CONSTRAINT FK_CF72D3989D3437F8 FOREIGN KEY (table_de_multiplication_id) REFERENCES table_de_multiplication (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE table_de_multiplication_niveau ADD CONSTRAINT FK_CF72D398B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_personnage_jouable ADD CONSTRAINT FK_A652D440FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_personnage_jouable ADD CONSTRAINT FK_A652D44078B79E04 FOREIGN KEY (personnage_jouable_id) REFERENCES personnage_jouable (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE niveau_entrainement DROP FOREIGN KEY FK_D8FB9F7FA15E8FD');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EA15E8FD');
        $this->addSql('ALTER TABLE niveau DROP FOREIGN KEY FK_4BDFF36B8C9E392E');
        $this->addSql('ALTER TABLE niveau_entrainement DROP FOREIGN KEY FK_D8FB9F7FB3E9C81');
        $this->addSql('ALTER TABLE niveau_utilisateur DROP FOREIGN KEY FK_F89D5138B3E9C81');
        $this->addSql('ALTER TABLE table_de_multiplication_niveau DROP FOREIGN KEY FK_CF72D398B3E9C81');
        $this->addSql('ALTER TABLE niveau DROP FOREIGN KEY FK_4BDFF36B9F6741CC');
        $this->addSql('ALTER TABLE utilisateur_personnage_jouable DROP FOREIGN KEY FK_A652D44078B79E04');
        $this->addSql('ALTER TABLE question_reponse_propose DROP FOREIGN KEY FK_707CC5741E27F6BF');
        $this->addSql('ALTER TABLE pnj DROP FOREIGN KEY FK_FDA97F2D98260155');
        $this->addSql('ALTER TABLE question_reponse_propose DROP FOREIGN KEY FK_707CC574E164760E');
        $this->addSql('ALTER TABLE region DROP FOREIGN KEY FK_F62F176B19628D7');
        $this->addSql('ALTER TABLE table_de_multiplication_niveau DROP FOREIGN KEY FK_CF72D3989D3437F8');
        $this->addSql('ALTER TABLE entrainement DROP FOREIGN KEY FK_A27444E5FB88E14F');
        $this->addSql('ALTER TABLE niveau_utilisateur DROP FOREIGN KEY FK_F89D5138FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_personnage_jouable DROP FOREIGN KEY FK_A652D440FB88E14F');
        $this->addSql('DROP TABLE entrainement');
        $this->addSql('DROP TABLE jeu');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE niveau_entrainement');
        $this->addSql('DROP TABLE niveau_utilisateur');
        $this->addSql('DROP TABLE personnage_jouable');
        $this->addSql('DROP TABLE pnj');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE question_reponse_propose');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE reponse_propose');
        $this->addSql('DROP TABLE table_de_multiplication');
        $this->addSql('DROP TABLE table_de_multiplication_niveau');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE utilisateur_personnage_jouable');
    }
}
