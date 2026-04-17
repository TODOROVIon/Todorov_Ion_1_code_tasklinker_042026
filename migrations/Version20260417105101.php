<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260417105101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP CONSTRAINT fk_2fb3d0ee6bf700bd');
        $this->addSql('ALTER TABLE project DROP CONSTRAINT fk_2fb3d0eebad26311');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE6BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)');
        $this->addSql('ALTER TABLE tache DROP CONSTRAINT fk_93872075b3e79f4b');
        $this->addSql('ALTER TABLE tache DROP CONSTRAINT fk_93872075ebc2bc9a');
        $this->addSql('ALTER TABLE tache DROP CONSTRAINT fk_9387207579f37ae5');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075B3E79F4B FOREIGN KEY (id_project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075EBC2BC9A FOREIGN KEY (id_status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_9387207579F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE time_table DROP CONSTRAINT fk_b35b6e3a79f37ae5');
        $this->addSql('ALTER TABLE time_table DROP CONSTRAINT fk_b35b6e3a82f8b1ac');
        $this->addSql('ALTER TABLE time_table ADD CONSTRAINT FK_B35B6E3A79F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE time_table ADD CONSTRAINT FK_B35B6E3A82F8B1AC FOREIGN KEY (id_tache_id) REFERENCES tache (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP CONSTRAINT FK_2FB3D0EE6BF700BD');
        $this->addSql('ALTER TABLE project DROP CONSTRAINT FK_2FB3D0EEBAD26311');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT fk_2fb3d0ee6bf700bd FOREIGN KEY (status_id) REFERENCES status (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT fk_2fb3d0eebad26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tache DROP CONSTRAINT FK_93872075B3E79F4B');
        $this->addSql('ALTER TABLE tache DROP CONSTRAINT FK_93872075EBC2BC9A');
        $this->addSql('ALTER TABLE tache DROP CONSTRAINT FK_9387207579F37AE5');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT fk_93872075b3e79f4b FOREIGN KEY (id_project_id) REFERENCES project (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT fk_93872075ebc2bc9a FOREIGN KEY (id_status_id) REFERENCES status (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT fk_9387207579f37ae5 FOREIGN KEY (id_user_id) REFERENCES users (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE time_table DROP CONSTRAINT FK_B35B6E3A79F37AE5');
        $this->addSql('ALTER TABLE time_table DROP CONSTRAINT FK_B35B6E3A82F8B1AC');
        $this->addSql('ALTER TABLE time_table ADD CONSTRAINT fk_b35b6e3a79f37ae5 FOREIGN KEY (id_user_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE time_table ADD CONSTRAINT fk_b35b6e3a82f8b1ac FOREIGN KEY (id_tache_id) REFERENCES tache (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP INDEX UNIQ_1483A5E9E7927C74');
    }
}
