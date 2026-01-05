<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251210170127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Séparation creneau en date et heure';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservations ADD creneau_heure VARCHAR(20) DEFAULT NULL, CHANGE creneau creneau_date DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservations DROP creneau_heure, CHANGE creneau_date creneau DATE NOT NULL');
    }
}
