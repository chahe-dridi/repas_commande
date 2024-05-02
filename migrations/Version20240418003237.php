<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240418003237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D1D236AAA');
        $this->addSql('DROP INDEX IDX_6EEAA67D1D236AAA ON commande');
        $this->addSql('ALTER TABLE commande ADD id_repas VARCHAR(300) NOT NULL, DROP repas_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD repas_id INT DEFAULT NULL, DROP id_repas');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D1D236AAA FOREIGN KEY (repas_id) REFERENCES repas (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D1D236AAA ON commande (repas_id)');
    }
}
