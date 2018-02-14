<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180213232013 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE gamehub.fos_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE gamehub.fos_user (id INT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(255) NOT NULL, first_name VARCHAR(64) DEFAULT NULL, last_name VARCHAR(64) DEFAULT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled BOOLEAN NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, roles TEXT NOT NULL, avatar VARCHAR(255) DEFAULT NULL, hash VARCHAR(24) DEFAULT NULL, facebook_id VARCHAR(255) DEFAULT NULL, facebook_access_token VARCHAR(255) DEFAULT NULL, google_id VARCHAR(255) DEFAULT NULL, google_access_token VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_356FE4B892FC23A8 ON gamehub.fos_user (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_356FE4B8E7927C74 ON gamehub.fos_user (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_356FE4B8A0D96FBF ON gamehub.fos_user (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_356FE4B8C05FB297 ON gamehub.fos_user (confirmation_token)');
        $this->addSql('COMMENT ON COLUMN gamehub.fos_user.roles IS \'(DC2Type:array)\'');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE gamehub.fos_user_id_seq CASCADE');
        $this->addSql('DROP TABLE gamehub.fos_user');
    }
}
