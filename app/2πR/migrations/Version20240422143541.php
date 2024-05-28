<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240422143541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
    // this up() migration is auto-generated, please modify it to your needs
    $this->addSql('CREATE SEQUENCE categorie_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
    $this->addSql('CREATE SEQUENCE "order_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
    $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
    $this->addSql('CREATE SEQUENCE product_cart_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
    $this->addSql('CREATE SEQUENCE product_order_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
    $this->addSql('CREATE SEQUENCE product_wishlist_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
    $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');

    // Create tables
    $this->addSql('CREATE TABLE categorie (id INT NOT NULL DEFAULT nextval(\'categorie_id_seq\'), nom VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
    $this->addSql('CREATE TABLE "order" (id INT NOT NULL DEFAULT nextval(\'order_id_seq\'), total_price INT NOT NULL, creation_date DATE NOT NULL, shipping_address VARCHAR(255) NOT NULL, shipping_city VARCHAR(255) NOT NULL, shipping_state VARCHAR(255) NOT NULL, shipping_postal_code VARCHAR(255) NOT NULL, shipping_country VARCHAR(255) NOT NULL, payment_method VARCHAR(255) NOT NULL, payment_status VARCHAR(255) NOT NULL, user_id INT NOT NULL, PRIMARY KEY(id))');
    $this->addSql('COMMENT ON COLUMN "order".creation_date IS \'(DC2Type:date_immutable)\'');
    $this->addSql('CREATE TABLE product (
        id INT NOT NULL DEFAULT nextval(\'product_id_seq\'), 
        cat_id INT NOT NULL, 
        name VARCHAR(255) NOT NULL, 
        description VARCHAR(255) NOT NULL, 
        photo VARCHAR(255) NOT NULL, 
        price NUMERIC(10, 2) NOT NULL, 
        stock_quantity INT NOT NULL, 
        created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP, 
        PRIMARY KEY(id)
    )');
    $this->addSql('CREATE INDEX IDX_D34A04ADE6ADA943 ON product (cat_id)');
    $this->addSql('CREATE TABLE product_cart (id INT NOT NULL DEFAULT nextval(\'product_cart_id_seq\'), user_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, PRIMARY KEY(id))');
    $this->addSql('CREATE INDEX IDX_864BAA16A76ED395 ON product_cart (user_id)');
    $this->addSql('CREATE INDEX IDX_864BAA164584665A ON product_cart (product_id)');
    $this->addSql('CREATE TABLE product_order (id INT NOT NULL DEFAULT nextval(\'product_order_id_seq\'), order_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, PRIMARY KEY(id))');
    $this->addSql('CREATE INDEX IDX_5475E8C48D9F6D38 ON product_order (order_id)');
    $this->addSql('CREATE INDEX IDX_5475E8C44584665A ON product_order (product_id)');
    $this->addSql('CREATE TABLE product_wishlist (id INT NOT NULL DEFAULT nextval(\'product_wishlist_id_seq\'), user_id INT NOT NULL, product_id INT NOT NULL, PRIMARY KEY(id))');
    $this->addSql('CREATE INDEX IDX_575140A6A76ED395 ON product_wishlist (user_id)');
    $this->addSql('CREATE INDEX IDX_575140A64584665A ON product_wishlist (product_id)');
    $this->addSql('CREATE TABLE "user" (id INT NOT NULL DEFAULT nextval(\'user_id_seq\'), username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
    $this->addSql('COMMENT ON COLUMN "user".created_at IS \'(DC2Type:datetime_immutable)\'');
    $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
    $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
    $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
    $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
    $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
    $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
        BEGIN
            PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
            RETURN NEW;
            END;
    $$ LANGUAGE plpgsql;');
    $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');

    //add Item
    $this->addSql("INSERT INTO categorie (nom) VALUES ('Les Pierres'), ('Les Menhirs'), ('Les Pierres précieuses')");

    $this->addSql("INSERT INTO product (name, description, photo, price, stock_quantity, cat_id) VALUES 
    ('Pierre Plante', 'Un engrais pour tout type de sol', '/Pierres/pierrePlante.png', 99.99, 10, 1),
    ('Pierre Feu', 'Parfait pour allumer un barbecue !', '/Pierres/pierreFeu.png', 99.99, 10, 1),
    ('Pierre Eau', 'Idéal pendant les fortes chaleurs pour s''hydrater !', '/Pierres/pierreEau.png', 99.99, 10, 1),
    ('Pierre Foudre', 'Peut servir comme groupe électrogène ou batterie externe', '/Pierres/pierreFoudre.png', 99.99, 10, 1),
    ('Pierre Lune', 'Avec sa lumière, vous être sûr de voir dans le noir sans aucun problème', '/Pierres/pierreLune.png', 99.99, 10, 1),
    ('Pierre Glace', 'Plus qu''a ajouter le sirop de votre choix et l''été sera incroyable', '/Pierres/pierreGlace.png', 99.99, 10, 1),
    ('Pierre Nuit', 'Une seule vous suffira pour passer une excellente nuit', '/Pierres/pierreNuit.png', 99.99, 10, 1),
    ('Pierre Soleil', 'Avec sa chaleur, l''hiver ne sera plus un problème !', '/Pierres/pierreSoleil.png', 99.99, 10, 1),
    ('Pierre Éclat', 'Appliquer matin et soir pour rendre votre teint éclatant !', '/Pierres/pierreEclat.png', 99.99, 10, 1),
    ('Pierre Aube', 'Elle vous donnera toute l''énergie pour bien commencer la journée', '/Pierres/pierreAube.png', 99.99, 10, 1),
    ('Menhir Classique', 'Le menhir classique. Parfait pour décorer votre jardin.', '/Menhir/Menhir.jpeg', 1049.99, 10, 2),
    ('Menhir à chapeau', 'Un menhir avec un chapeau, d''une grande élégance.', '/Menhir/MenhirChapeau.jpeg', 1549.99, 10, 2),
    ('Menhir Moussu', 'Un menhir recouvert de mousse. Un recontact avec la nature.', '/Menhir/MenhirMousse.jpeg', 1809.99, 10, 2),
    ('Menhir à visage', 'Un menhir avec un visage sculpté, entièrement personnalisable.', '/Menhir/MenhirVisage.jpeg', 2000.99, 10, 2),
    ('StoneHenge', 'Une réplique parfaite. Un objet de collection unique.', '/Menhir/StoneHenge.jpeg', 9999.99, 10, 2),
    ('Améthyste', 'Sérénité violette, source de paix intérieure méditative.', '/Précieuses/Amethyste.jpeg', 49.99, 10, 3),
    ('Saphir', 'Élégance en bleu profond, incarnant la pureté aristocratique.', '/Précieuses/Saphir.jpeg', 149.99, 10, 3),
    ('Émeraude', 'Verdure de renouveau, symbole de croissance éternelle.', '/Précieuses/Émeraude.jpeg', 209.99, 10, 3),
    ('Diamant', 'Brillant d''éternité, témoignage indélébile d''un amour éternel.', '/Précieuses/Diamant.jpeg', 999.99, 10, 3),
    ('Topaze', 'Rayonnement doré, éclat de confiance et de positivité.', '/Précieuses/Topaze.jpeg', 99.99, 10, 3),
    ('Aquamarine', 'Fraîcheur marine, capturant la clarté de l''océan.', '/Précieuses/Aquamarine.jpeg', 199.99, 10, 3),
    ('Pierre de Lune', ' Mystère argenté, révélant la beauté intérieure cachée.', '/Précieuses/Moonstone.jpeg', 299.99, 10, 3),
    ('Onyx', 'Force en noir profond, gardien de la stabilité spirituelle.', '/Précieuses/Onyx.jpeg', 69.99, 10, 3),
    ('Péridot', 'Fraîcheur printanière, inspirant renouveau et croissance personnelle.', '/Précieuses/Péridot.jpeg', 109.99, 10, 3),
    ('Rubis', 'Rouge passion, éclatant de feu et de vitalité éternelle.', '/Précieuses/Rubis.jpeg', 399.99, 10, 3)
    ");

    $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
    $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADE6ADA943 FOREIGN KEY (cat_id) REFERENCES categorie (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    $this->addSql('ALTER TABLE product_cart ADD CONSTRAINT FK_864BAA16A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    $this->addSql('ALTER TABLE product_cart ADD CONSTRAINT FK_864BAA164584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    $this->addSql('ALTER TABLE product_order ADD CONSTRAINT FK_5475E8C48D9F6D38 FOREIGN KEY (order_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    $this->addSql('ALTER TABLE product_order ADD CONSTRAINT FK_5475E8C44584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    $this->addSql('ALTER TABLE product_wishlist ADD CONSTRAINT FK_575140A6A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    $this->addSql('ALTER TABLE product_wishlist ADD CONSTRAINT FK_575140A64584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');


    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE categorie_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "order_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_cart_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_order_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_wishlist_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_D34A04ADE6ADA943');
        $this->addSql('ALTER TABLE product_cart DROP CONSTRAINT FK_864BAA16A76ED395');
        $this->addSql('ALTER TABLE product_cart DROP CONSTRAINT FK_864BAA164584665A');
        $this->addSql('ALTER TABLE product_order DROP CONSTRAINT FK_5475E8C48D9F6D38');
        $this->addSql('ALTER TABLE product_order DROP CONSTRAINT FK_5475E8C44584665A');
        $this->addSql('ALTER TABLE product_wishlist DROP CONSTRAINT FK_575140A6A76ED395');
        $this->addSql('ALTER TABLE product_wishlist DROP CONSTRAINT FK_575140A64584665A');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_cart');
        $this->addSql('DROP TABLE product_order');
        $this->addSql('DROP TABLE product_wishlist');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql("DELETE FROM categorie WHERE nom IN (
            'Les Pierres', 
            'Les Menhirs', 
            'Les Pierres précieuses'
        )");
        }
}
