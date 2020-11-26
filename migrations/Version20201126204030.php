<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201126204030 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Initialize basic user tables';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE link (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', user_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', token VARCHAR(36) NOT NULL, target VARCHAR(255) NOT NULL, views INT NOT NULL, UNIQUE INDEX UNIQ_36AC99F15F37A13B (token), INDEX IDX_36AC99F1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', email VARCHAR(255) NOT NULL, password VARCHAR(255) DEFAULT NULL, social_id VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, last_login DATETIME NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE link ADD CONSTRAINT FK_36AC99F1A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE link DROP FOREIGN KEY FK_36AC99F1A76ED395');
        $this->addSql('DROP TABLE link');
        $this->addSql('DROP TABLE `user`');
    }
}
