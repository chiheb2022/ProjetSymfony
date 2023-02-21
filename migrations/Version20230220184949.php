<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230220184949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog (id INT AUTO_INCREMENT NOT NULL, idut_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, date DATE NOT NULL, description_b VARCHAR(255) NOT NULL, image_b VARCHAR(255) NOT NULL, INDEX IDX_C01551435C48DF52 (idut_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_d (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_p (id INT AUTO_INCREMENT NOT NULL, nom_c VARCHAR(255) NOT NULL, description_cat LONGTEXT DEFAULT NULL, date_creation DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE collecte (id INT AUTO_INCREMENT NOT NULL, idusercollect_id INT DEFAULT NULL, iddon_id INT DEFAULT NULL, etat_c INT NOT NULL, typevehicule VARCHAR(255) DEFAULT NULL, contact VARCHAR(255) DEFAULT NULL, INDEX IDX_55AE4A3D36200F3A (idusercollect_id), UNIQUE INDEX UNIQ_55AE4A3D1F813DCD (iddon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, idpanier_id INT DEFAULT NULL, totalproduit INT NOT NULL, date_cm DATE NOT NULL, adresselivraison VARCHAR(255) NOT NULL, prixtot DOUBLE PRECISION NOT NULL, status_cm INT NOT NULL, UNIQUE INDEX UNIQ_6EEAA67D89663B89 (idpanier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, id_blog_id INT DEFAULT NULL, date_cm DATE NOT NULL, texte VARCHAR(255) NOT NULL, auteur VARCHAR(255) NOT NULL, isactive INT NOT NULL, INDEX IDX_67F068BC47DD7E7 (id_blog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE don (id INT AUTO_INCREMENT NOT NULL, iduserdon_id INT DEFAULT NULL, id_categorie_id INT DEFAULT NULL, poids INT DEFAULT NULL, description_d VARCHAR(255) DEFAULT NULL, etat INT NOT NULL, date DATE DEFAULT NULL, INDEX IDX_F8F081D9DE6F9A9F (iduserdon_id), INDEX IDX_F8F081D99F34925F (id_categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, iduserpanier_id INT DEFAULT NULL, date DATE NOT NULL, quantite INT NOT NULL, prixtotal DOUBLE PRECISION NOT NULL, INDEX IDX_24CC0DF240AA24C7 (iduserpanier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier_produit (panier_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_D31F28A6F77D927C (panier_id), INDEX IDX_D31F28A6F347EFB (produit_id), PRIMARY KEY(panier_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, iduserproduit_id INT DEFAULT NULL, idcategorie_p_id INT DEFAULT NULL, idcat_p_id INT DEFAULT NULL, nom_p VARCHAR(255) NOT NULL, prix_p DOUBLE PRECISION NOT NULL, description_p LONGTEXT NOT NULL, image_p VARCHAR(255) NOT NULL, stock INT DEFAULT NULL, quantiteproduit INT DEFAULT NULL, INDEX IDX_29A5EC275330C349 (iduserproduit_id), INDEX IDX_29A5EC27B52A75BE (idcategorie_p_id), INDEX IDX_29A5EC27649DDC1E (idcat_p_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendezvous (id INT AUTO_INCREMENT NOT NULL, idcollecte_id INT DEFAULT NULL, date_rv DATE DEFAULT NULL, adresse_rv VARCHAR(255) DEFAULT NULL, etat_rv INT NOT NULL, UNIQUE INDEX UNIQ_C09A9BA8B7CBEA69 (idcollecte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, photo VARCHAR(255) DEFAULT NULL, datenaissance DATE NOT NULL, cin INT DEFAULT NULL, region VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, isactive INT NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C01551435C48DF52 FOREIGN KEY (idut_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE collecte ADD CONSTRAINT FK_55AE4A3D36200F3A FOREIGN KEY (idusercollect_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE collecte ADD CONSTRAINT FK_55AE4A3D1F813DCD FOREIGN KEY (iddon_id) REFERENCES don (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D89663B89 FOREIGN KEY (idpanier_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC47DD7E7 FOREIGN KEY (id_blog_id) REFERENCES blog (id)');
        $this->addSql('ALTER TABLE don ADD CONSTRAINT FK_F8F081D9DE6F9A9F FOREIGN KEY (iduserdon_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE don ADD CONSTRAINT FK_F8F081D99F34925F FOREIGN KEY (id_categorie_id) REFERENCES categorie_d (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF240AA24C7 FOREIGN KEY (iduserpanier_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE panier_produit ADD CONSTRAINT FK_D31F28A6F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE panier_produit ADD CONSTRAINT FK_D31F28A6F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC275330C349 FOREIGN KEY (iduserproduit_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27B52A75BE FOREIGN KEY (idcategorie_p_id) REFERENCES categorie_d (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27649DDC1E FOREIGN KEY (idcat_p_id) REFERENCES categorie_p (id)');
        $this->addSql('ALTER TABLE rendezvous ADD CONSTRAINT FK_C09A9BA8B7CBEA69 FOREIGN KEY (idcollecte_id) REFERENCES collecte (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C01551435C48DF52');
        $this->addSql('ALTER TABLE collecte DROP FOREIGN KEY FK_55AE4A3D36200F3A');
        $this->addSql('ALTER TABLE collecte DROP FOREIGN KEY FK_55AE4A3D1F813DCD');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D89663B89');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC47DD7E7');
        $this->addSql('ALTER TABLE don DROP FOREIGN KEY FK_F8F081D9DE6F9A9F');
        $this->addSql('ALTER TABLE don DROP FOREIGN KEY FK_F8F081D99F34925F');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF240AA24C7');
        $this->addSql('ALTER TABLE panier_produit DROP FOREIGN KEY FK_D31F28A6F77D927C');
        $this->addSql('ALTER TABLE panier_produit DROP FOREIGN KEY FK_D31F28A6F347EFB');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC275330C349');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27B52A75BE');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27649DDC1E');
        $this->addSql('ALTER TABLE rendezvous DROP FOREIGN KEY FK_C09A9BA8B7CBEA69');
        $this->addSql('DROP TABLE blog');
        $this->addSql('DROP TABLE categorie_d');
        $this->addSql('DROP TABLE categorie_p');
        $this->addSql('DROP TABLE collecte');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE don');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE panier_produit');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE rendezvous');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
