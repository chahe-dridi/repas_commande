<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240329004140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE information_personnele DROP FOREIGN KEY information_personnele_ibfk_1');
        $this->addSql('ALTER TABLE information_personnele CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE information_personnele ADD CONSTRAINT FK_8D1F5773A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE plan_alim DROP FOREIGN KEY plan_alim_ibfk_1');
        $this->addSql('ALTER TABLE plan_alim CHANGE id_regime id_regime INT DEFAULT NULL');
        $this->addSql('ALTER TABLE plan_alim ADD CONSTRAINT FK_71F97CC78CB1FF91 FOREIGN KEY (id_regime) REFERENCES regime (id)');
        $this->addSql('ALTER TABLE recette CHANGE id_ingredients id_ingredients VARCHAR(256) NOT NULL');
        $this->addSql('ALTER TABLE regime DROP FOREIGN KEY regime_ibfk_1');
        $this->addSql('ALTER TABLE regime CHANGE id_repas id_repas INT DEFAULT NULL');
        $this->addSql('ALTER TABLE regime ADD CONSTRAINT FK_AA864A7C46561083 FOREIGN KEY (id_repas) REFERENCES repas (id)');
        $this->addSql('ALTER TABLE request_nut DROP FOREIGN KEY request_nut_ibfk_1');
        $this->addSql('ALTER TABLE request_nut CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE request_nut ADD CONSTRAINT FK_750246E2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE information_personnele DROP FOREIGN KEY FK_8D1F5773A76ED395');
        $this->addSql('ALTER TABLE information_personnele CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE information_personnele ADD CONSTRAINT information_personnele_ibfk_1 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plan_alim DROP FOREIGN KEY FK_71F97CC78CB1FF91');
        $this->addSql('ALTER TABLE plan_alim CHANGE id_regime id_regime INT NOT NULL');
        $this->addSql('ALTER TABLE plan_alim ADD CONSTRAINT plan_alim_ibfk_1 FOREIGN KEY (id_regime) REFERENCES regime (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette CHANGE id_ingredients id_ingredients VARCHAR(256) NOT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE regime DROP FOREIGN KEY FK_AA864A7C46561083');
        $this->addSql('ALTER TABLE regime CHANGE id_repas id_repas INT NOT NULL');
        $this->addSql('ALTER TABLE regime ADD CONSTRAINT regime_ibfk_1 FOREIGN KEY (id_repas) REFERENCES repas (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE request_nut DROP FOREIGN KEY FK_750246E2A76ED395');
        $this->addSql('ALTER TABLE request_nut CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE request_nut ADD CONSTRAINT request_nut_ibfk_1 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
