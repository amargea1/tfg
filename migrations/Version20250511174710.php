<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250511174710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE administrador (id INT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, fecha_creacion DATETIME NOT NULL, fecha_ultimo_acceso DATETIME NOT NULL, esta_activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE familiar (id INT NOT NULL, socio_id INT NOT NULL, cuota_id INT DEFAULT NULL, relacion VARCHAR(50) NOT NULL, INDEX IDX_8A34CA5EDA04E6A9 (socio_id), INDEX IDX_8A34CA5E6A7CF079 (cuota_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE no_socio (id INT NOT NULL, colectivo VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE socio (id INT NOT NULL, cuota_id INT DEFAULT NULL, fecha_registro DATETIME NOT NULL, orden_registro INT NOT NULL, colectivo VARCHAR(50) NOT NULL, INDEX IDX_38B653096A7CF079 (cuota_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE administrador ADD CONSTRAINT FK_44F9A521BF396750 FOREIGN KEY (id) REFERENCES usuario (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE familiar ADD CONSTRAINT FK_8A34CA5EDA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE familiar ADD CONSTRAINT FK_8A34CA5E6A7CF079 FOREIGN KEY (cuota_id) REFERENCES cuota (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE familiar ADD CONSTRAINT FK_8A34CA5EBF396750 FOREIGN KEY (id) REFERENCES usuario (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE no_socio ADD CONSTRAINT FK_DEF14FDABF396750 FOREIGN KEY (id) REFERENCES usuario (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE socio ADD CONSTRAINT FK_38B653096A7CF079 FOREIGN KEY (cuota_id) REFERENCES cuota (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE socio ADD CONSTRAINT FK_38B65309BF396750 FOREIGN KEY (id) REFERENCES usuario (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_reclamaciones DROP FOREIGN KEY FK_7EFDEEFA642B8210
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_reclamaciones ADD CONSTRAINT FK_7EFDEEFA642B8210 FOREIGN KEY (admin_id) REFERENCES administrador (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_consultas DROP FOREIGN KEY FK_9334CBD5642B8210
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_consultas ADD CONSTRAINT FK_9334CBD5642B8210 FOREIGN KEY (admin_id) REFERENCES administrador (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_seguimientos DROP FOREIGN KEY FK_148B327642B8210
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_seguimientos ADD CONSTRAINT FK_148B327642B8210 FOREIGN KEY (admin_id) REFERENCES administrador (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta DROP FOREIGN KEY FK_A6FE3FDE10C20D71
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta DROP FOREIGN KEY FK_A6FE3FDE5B04E448
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta DROP FOREIGN KEY FK_A6FE3FDEDA04E6A9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta ADD CONSTRAINT FK_A6FE3FDE10C20D71 FOREIGN KEY (familiar_id) REFERENCES familiar (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta ADD CONSTRAINT FK_A6FE3FDE5B04E448 FOREIGN KEY (no_socio_id) REFERENCES no_socio (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta ADD CONSTRAINT FK_A6FE3FDEDA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion DROP FOREIGN KEY FK_3AE0B2210C20D71
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion DROP FOREIGN KEY FK_3AE0B22DA04E6A9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion ADD CONSTRAINT FK_3AE0B2210C20D71 FOREIGN KEY (familiar_id) REFERENCES familiar (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion ADD CONSTRAINT FK_3AE0B22DA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE usuario DROP FOREIGN KEY FK_2265B05D6A7CF079
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE usuario DROP FOREIGN KEY FK_2265B05DDA04E6A9
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_2265B05DDA04E6A9 ON usuario
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_2265B05D6A7CF079 ON usuario
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE usuario DROP cuota_id, DROP socio_id, DROP fecha_registro, DROP orden_registro, DROP colectivo, DROP relacion, DROP username, DROP password, DROP fecha_creacion, DROP fecha_ultimo_acceso, DROP esta_activo
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_reclamaciones DROP FOREIGN KEY FK_7EFDEEFA642B8210
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_consultas DROP FOREIGN KEY FK_9334CBD5642B8210
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_seguimientos DROP FOREIGN KEY FK_148B327642B8210
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta DROP FOREIGN KEY FK_A6FE3FDE10C20D71
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion DROP FOREIGN KEY FK_3AE0B2210C20D71
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta DROP FOREIGN KEY FK_A6FE3FDE5B04E448
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta DROP FOREIGN KEY FK_A6FE3FDEDA04E6A9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion DROP FOREIGN KEY FK_3AE0B22DA04E6A9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE administrador DROP FOREIGN KEY FK_44F9A521BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE familiar DROP FOREIGN KEY FK_8A34CA5EDA04E6A9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE familiar DROP FOREIGN KEY FK_8A34CA5E6A7CF079
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE familiar DROP FOREIGN KEY FK_8A34CA5EBF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE no_socio DROP FOREIGN KEY FK_DEF14FDABF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE socio DROP FOREIGN KEY FK_38B653096A7CF079
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE socio DROP FOREIGN KEY FK_38B65309BF396750
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE administrador
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE familiar
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE no_socio
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE socio
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE usuario ADD cuota_id INT DEFAULT NULL, ADD socio_id INT NOT NULL, ADD fecha_registro DATETIME DEFAULT NULL, ADD orden_registro INT DEFAULT NULL, ADD colectivo VARCHAR(50) DEFAULT NULL, ADD relacion VARCHAR(50) DEFAULT NULL, ADD username VARCHAR(255) DEFAULT NULL, ADD password VARCHAR(255) DEFAULT NULL, ADD fecha_creacion DATETIME DEFAULT NULL, ADD fecha_ultimo_acceso DATETIME DEFAULT NULL, ADD esta_activo TINYINT(1) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE usuario ADD CONSTRAINT FK_2265B05D6A7CF079 FOREIGN KEY (cuota_id) REFERENCES cuota (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE usuario ADD CONSTRAINT FK_2265B05DDA04E6A9 FOREIGN KEY (socio_id) REFERENCES usuario (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2265B05DDA04E6A9 ON usuario (socio_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2265B05D6A7CF079 ON usuario (cuota_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_consultas DROP FOREIGN KEY FK_9334CBD5642B8210
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_consultas ADD CONSTRAINT FK_9334CBD5642B8210 FOREIGN KEY (admin_id) REFERENCES usuario (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion DROP FOREIGN KEY FK_3AE0B2210C20D71
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion DROP FOREIGN KEY FK_3AE0B22DA04E6A9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion ADD CONSTRAINT FK_3AE0B2210C20D71 FOREIGN KEY (familiar_id) REFERENCES usuario (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion ADD CONSTRAINT FK_3AE0B22DA04E6A9 FOREIGN KEY (socio_id) REFERENCES usuario (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta DROP FOREIGN KEY FK_A6FE3FDEDA04E6A9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta DROP FOREIGN KEY FK_A6FE3FDE10C20D71
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta DROP FOREIGN KEY FK_A6FE3FDE5B04E448
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta ADD CONSTRAINT FK_A6FE3FDEDA04E6A9 FOREIGN KEY (socio_id) REFERENCES usuario (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta ADD CONSTRAINT FK_A6FE3FDE10C20D71 FOREIGN KEY (familiar_id) REFERENCES usuario (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta ADD CONSTRAINT FK_A6FE3FDE5B04E448 FOREIGN KEY (no_socio_id) REFERENCES usuario (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_reclamaciones DROP FOREIGN KEY FK_7EFDEEFA642B8210
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_reclamaciones ADD CONSTRAINT FK_7EFDEEFA642B8210 FOREIGN KEY (admin_id) REFERENCES usuario (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_seguimientos DROP FOREIGN KEY FK_148B327642B8210
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_seguimientos ADD CONSTRAINT FK_148B327642B8210 FOREIGN KEY (admin_id) REFERENCES usuario (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
    }
}
