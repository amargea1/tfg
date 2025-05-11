<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250511102830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion_entity DROP FOREIGN KEY FK_185CF58410C20D71
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta_entity DROP FOREIGN KEY FK_66CFC66E10C20D71
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta_entity DROP FOREIGN KEY FK_66CFC66E5B04E448
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_seguimientos DROP FOREIGN KEY FK_148B327642B8210
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_reclamaciones DROP FOREIGN KEY FK_7EFDEEFA642B8210
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_consultas DROP FOREIGN KEY FK_9334CBD5642B8210
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion_entity DROP FOREIGN KEY FK_185CF584DA04E6A9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta_entity DROP FOREIGN KEY FK_66CFC66EDA04E6A9
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE Usuario (id INT AUTO_INCREMENT NOT NULL, cuota_id INT DEFAULT NULL, socio_id INT NOT NULL, rol VARCHAR(20) NOT NULL, nombre VARCHAR(255) NOT NULL, apellidos VARCHAR(255) NOT NULL, dni VARCHAR(255) NOT NULL, fecha_nacimiento DATETIME NOT NULL, sexo VARCHAR(20) NOT NULL, dirección VARCHAR(255) NOT NULL, localidad VARCHAR(255) NOT NULL, provincia VARCHAR(255) NOT NULL, codigo_postal VARCHAR(255) NOT NULL, telefono VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, tipo_usuario VARCHAR(255) NOT NULL, fecha_registro DATETIME DEFAULT NULL, orden_registro INT DEFAULT NULL, colectivo VARCHAR(50) DEFAULT NULL, relacion VARCHAR(50) DEFAULT NULL, username VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, fecha_creacion DATETIME DEFAULT NULL, fecha_ultimo_acceso DATETIME DEFAULT NULL, esta_activo TINYINT(1) DEFAULT NULL, INDEX IDX_EDD889C16A7CF079 (cuota_id), INDEX IDX_EDD889C1DA04E6A9 (socio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Usuario ADD CONSTRAINT FK_EDD889C16A7CF079 FOREIGN KEY (cuota_id) REFERENCES cuota_entity (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Usuario ADD CONSTRAINT FK_EDD889C1DA04E6A9 FOREIGN KEY (socio_id) REFERENCES Usuario (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE familiar_entity DROP FOREIGN KEY FK_E2C744CADA04E6A9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE familiar_entity DROP FOREIGN KEY FK_E2C744CABF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE familiar_entity DROP FOREIGN KEY FK_E2C744CA6A7CF079
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE no_socio_entity DROP FOREIGN KEY FK_B579F01EBF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE administrador_entity DROP FOREIGN KEY FK_8652ECD8BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE socio_entity DROP FOREIGN KEY FK_4281B19BBF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE socio_entity DROP FOREIGN KEY FK_4281B19B6A7CF079
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE familiar_entity
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE no_socio_entity
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE administrador_entity
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE socio_entity
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE usuario_entity
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_reclamaciones DROP FOREIGN KEY FK_7EFDEEFA642B8210
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_reclamaciones ADD CONSTRAINT FK_7EFDEEFA642B8210 FOREIGN KEY (admin_id) REFERENCES Usuario (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_consultas DROP FOREIGN KEY FK_9334CBD5642B8210
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_consultas ADD CONSTRAINT FK_9334CBD5642B8210 FOREIGN KEY (admin_id) REFERENCES Usuario (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_seguimientos DROP FOREIGN KEY FK_148B327642B8210
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_seguimientos ADD CONSTRAINT FK_148B327642B8210 FOREIGN KEY (admin_id) REFERENCES Usuario (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta_entity DROP FOREIGN KEY FK_66CFC66EDA04E6A9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta_entity DROP FOREIGN KEY FK_66CFC66E5B04E448
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta_entity DROP FOREIGN KEY FK_66CFC66E10C20D71
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta_entity ADD CONSTRAINT FK_66CFC66EDA04E6A9 FOREIGN KEY (socio_id) REFERENCES Usuario (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta_entity ADD CONSTRAINT FK_66CFC66E5B04E448 FOREIGN KEY (no_socio_id) REFERENCES Usuario (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta_entity ADD CONSTRAINT FK_66CFC66E10C20D71 FOREIGN KEY (familiar_id) REFERENCES Usuario (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion_entity DROP FOREIGN KEY FK_185CF584DA04E6A9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion_entity DROP FOREIGN KEY FK_185CF58410C20D71
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion_entity ADD CONSTRAINT FK_185CF584DA04E6A9 FOREIGN KEY (socio_id) REFERENCES Usuario (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion_entity ADD CONSTRAINT FK_185CF58410C20D71 FOREIGN KEY (familiar_id) REFERENCES Usuario (id)
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
            ALTER TABLE consulta_entity DROP FOREIGN KEY FK_66CFC66EDA04E6A9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta_entity DROP FOREIGN KEY FK_66CFC66E10C20D71
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta_entity DROP FOREIGN KEY FK_66CFC66E5B04E448
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion_entity DROP FOREIGN KEY FK_185CF58410C20D71
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion_entity DROP FOREIGN KEY FK_185CF584DA04E6A9
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE familiar_entity (id INT NOT NULL, socio_id INT NOT NULL, cuota_id INT DEFAULT NULL, relacion VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_E2C744CA6A7CF079 (cuota_id), INDEX IDX_E2C744CADA04E6A9 (socio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE no_socio_entity (id INT NOT NULL, colectivo VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE administrador_entity (id INT NOT NULL, username VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, fecha_creacion DATETIME NOT NULL, fecha_ultimo_acceso DATETIME NOT NULL, esta_activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE socio_entity (id INT NOT NULL, cuota_id INT DEFAULT NULL, fecha_registro DATETIME NOT NULL, orden_registro INT NOT NULL, colectivo VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_4281B19B6A7CF079 (cuota_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE usuario_entity (id INT AUTO_INCREMENT NOT NULL, rol VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nombre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, apellidos VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, dni VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, fecha_nacimiento DATETIME NOT NULL, sexo VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, dirección VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, localidad VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, provincia VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, codigo_postal VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, telefono VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, tip VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE familiar_entity ADD CONSTRAINT FK_E2C744CADA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio_entity (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE familiar_entity ADD CONSTRAINT FK_E2C744CABF396750 FOREIGN KEY (id) REFERENCES usuario_entity (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE familiar_entity ADD CONSTRAINT FK_E2C744CA6A7CF079 FOREIGN KEY (cuota_id) REFERENCES cuota_entity (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE no_socio_entity ADD CONSTRAINT FK_B579F01EBF396750 FOREIGN KEY (id) REFERENCES usuario_entity (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE administrador_entity ADD CONSTRAINT FK_8652ECD8BF396750 FOREIGN KEY (id) REFERENCES usuario_entity (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE socio_entity ADD CONSTRAINT FK_4281B19BBF396750 FOREIGN KEY (id) REFERENCES usuario_entity (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE socio_entity ADD CONSTRAINT FK_4281B19B6A7CF079 FOREIGN KEY (cuota_id) REFERENCES cuota_entity (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Usuario DROP FOREIGN KEY FK_EDD889C16A7CF079
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Usuario DROP FOREIGN KEY FK_EDD889C1DA04E6A9
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE Usuario
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion_entity DROP FOREIGN KEY FK_185CF58410C20D71
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion_entity DROP FOREIGN KEY FK_185CF584DA04E6A9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion_entity ADD CONSTRAINT FK_185CF58410C20D71 FOREIGN KEY (familiar_id) REFERENCES familiar_entity (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion_entity ADD CONSTRAINT FK_185CF584DA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio_entity (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta_entity DROP FOREIGN KEY FK_66CFC66EDA04E6A9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta_entity DROP FOREIGN KEY FK_66CFC66E10C20D71
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta_entity DROP FOREIGN KEY FK_66CFC66E5B04E448
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta_entity ADD CONSTRAINT FK_66CFC66EDA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio_entity (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta_entity ADD CONSTRAINT FK_66CFC66E10C20D71 FOREIGN KEY (familiar_id) REFERENCES familiar_entity (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta_entity ADD CONSTRAINT FK_66CFC66E5B04E448 FOREIGN KEY (no_socio_id) REFERENCES no_socio_entity (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_seguimientos DROP FOREIGN KEY FK_148B327642B8210
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_seguimientos ADD CONSTRAINT FK_148B327642B8210 FOREIGN KEY (admin_id) REFERENCES administrador_entity (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_reclamaciones DROP FOREIGN KEY FK_7EFDEEFA642B8210
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_reclamaciones ADD CONSTRAINT FK_7EFDEEFA642B8210 FOREIGN KEY (admin_id) REFERENCES administrador_entity (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_consultas DROP FOREIGN KEY FK_9334CBD5642B8210
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_consultas ADD CONSTRAINT FK_9334CBD5642B8210 FOREIGN KEY (admin_id) REFERENCES administrador_entity (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
    }
}
