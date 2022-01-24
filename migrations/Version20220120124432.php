<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220120124432 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE regrouper DROP FOREIGN KEY regrouper_article0_FK');
        $this->addSql('DROP INDEX regrouper_article0_fk ON regrouper');
        $this->addSql('CREATE INDEX IDX_1D5FD813DCA7A716 ON regrouper (id_article)');
        $this->addSql('ALTER TABLE regrouper ADD CONSTRAINT regrouper_article0_FK FOREIGN KEY (id_article) REFERENCES article (id_article)');
        $this->addSql('ALTER TABLE utilisateur CHANGE date_inscription date_inscription DATE DEFAULT \'NULL\', CHANGE ip_inscription ip_inscription VARCHAR(50) DEFAULT \'NULL\', CHANGE tracker tracker VARCHAR(50) DEFAULT \'NULL\', CHANGE role_user role_user VARCHAR(100) DEFAULT \'NULL\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE regrouper DROP FOREIGN KEY FK_1D5FD813DCA7A716');
        $this->addSql('DROP INDEX idx_1d5fd813dca7a716 ON regrouper');
        $this->addSql('CREATE INDEX regrouper_article0_FK ON regrouper (id_article)');
        $this->addSql('ALTER TABLE regrouper ADD CONSTRAINT FK_1D5FD813DCA7A716 FOREIGN KEY (id_article) REFERENCES article (id_article)');
        $this->addSql('ALTER TABLE utilisateur CHANGE date_inscription date_inscription DATE NOT NULL, CHANGE ip_inscription ip_inscription VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE tracker tracker VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE role_user role_user VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`');
    }
}
