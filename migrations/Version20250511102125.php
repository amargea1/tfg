<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250511102125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE administrador_entity (id INT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, fecha_creacion DATETIME NOT NULL, fecha_ultimo_acceso DATETIME NOT NULL, esta_activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE admin_reclamaciones (admin_id INT NOT NULL, reclamacion_id INT NOT NULL, INDEX IDX_7EFDEEFA642B8210 (admin_id), INDEX IDX_7EFDEEFA8F120099 (reclamacion_id), PRIMARY KEY(admin_id, reclamacion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE admin_consultas (admin_id INT NOT NULL, consulta_id INT NOT NULL, INDEX IDX_9334CBD5642B8210 (admin_id), INDEX IDX_9334CBD5E38D288B (consulta_id), PRIMARY KEY(admin_id, consulta_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE admin_seguimientos (admin_id INT NOT NULL, seguimiento_id INT NOT NULL, INDEX IDX_148B327642B8210 (admin_id), INDEX IDX_148B327D5CBBFEB (seguimiento_id), PRIMARY KEY(admin_id, seguimiento_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE consulta_entity (id INT AUTO_INCREMENT NOT NULL, socio_id INT DEFAULT NULL, familiar_id INT DEFAULT NULL, no_socio_id INT DEFAULT NULL, atencion VARCHAR(50) NOT NULL, asunto VARCHAR(255) NOT NULL, fecha_apertura DATETIME NOT NULL, fecha_cierre DATETIME NOT NULL, estado VARCHAR(255) NOT NULL, consulta VARCHAR(500) NOT NULL, INDEX IDX_66CFC66EDA04E6A9 (socio_id), INDEX IDX_66CFC66E10C20D71 (familiar_id), INDEX IDX_66CFC66E5B04E448 (no_socio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE cuota_entity (id INT AUTO_INCREMENT NOT NULL, importe NUMERIC(8, 2) NOT NULL, modo_pago VARCHAR(50) NOT NULL, tipo VARCHAR(50) NOT NULL, periodicidad VARCHAR(50) NOT NULL, iban VARCHAR(255) DEFAULT NULL, bizum VARCHAR(255) DEFAULT NULL, fecha_pago DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE familiar_entity (id INT NOT NULL, socio_id INT NOT NULL, cuota_id INT DEFAULT NULL, relacion VARCHAR(50) NOT NULL, INDEX IDX_E2C744CADA04E6A9 (socio_id), INDEX IDX_E2C744CA6A7CF079 (cuota_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE no_socio_entity (id INT NOT NULL, colectivo VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE reclamacion_entity (id INT AUTO_INCREMENT NOT NULL, familiar_id INT DEFAULT NULL, socio_id INT DEFAULT NULL, fecha_apertura DATETIME NOT NULL, fecha_cierre DATETIME NOT NULL, atencion VARCHAR(50) NOT NULL, es_familiar TINYINT(1) NOT NULL, numero_socio VARCHAR(255) NOT NULL, sector VARCHAR(50) NOT NULL, asunto VARCHAR(255) NOT NULL, reclamacion VARCHAR(255) NOT NULL, estado VARCHAR(255) NOT NULL, prioridad VARCHAR(50) NOT NULL, INDEX IDX_185CF58410C20D71 (familiar_id), INDEX IDX_185CF584DA04E6A9 (socio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE seguimiento_entity (id INT AUTO_INCREMENT NOT NULL, reclamacion_id INT DEFAULT NULL, fecha DATETIME NOT NULL, comentario LONGTEXT NOT NULL, INDEX IDX_CC2CE2028F120099 (reclamacion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE socio_entity (id INT NOT NULL, cuota_id INT DEFAULT NULL, fecha_registro DATETIME NOT NULL, orden_registro INT NOT NULL, colectivo VARCHAR(50) NOT NULL, INDEX IDX_4281B19B6A7CF079 (cuota_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE usuario_entity (id INT AUTO_INCREMENT NOT NULL, rol VARCHAR(20) NOT NULL, nombre VARCHAR(255) NOT NULL, apellidos VARCHAR(255) NOT NULL, dni VARCHAR(255) NOT NULL, fecha_nacimiento DATETIME NOT NULL, sexo VARCHAR(20) NOT NULL, dirección VARCHAR(255) NOT NULL, localidad VARCHAR(255) NOT NULL, provincia VARCHAR(255) NOT NULL, codigo_postal VARCHAR(255) NOT NULL, telefono VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, tip VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE administrador_entity ADD CONSTRAINT FK_8652ECD8BF396750 FOREIGN KEY (id) REFERENCES usuario_entity (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_reclamaciones ADD CONSTRAINT FK_7EFDEEFA642B8210 FOREIGN KEY (admin_id) REFERENCES administrador_entity (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_reclamaciones ADD CONSTRAINT FK_7EFDEEFA8F120099 FOREIGN KEY (reclamacion_id) REFERENCES reclamacion_entity (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_consultas ADD CONSTRAINT FK_9334CBD5642B8210 FOREIGN KEY (admin_id) REFERENCES administrador_entity (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_consultas ADD CONSTRAINT FK_9334CBD5E38D288B FOREIGN KEY (consulta_id) REFERENCES consulta_entity (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_seguimientos ADD CONSTRAINT FK_148B327642B8210 FOREIGN KEY (admin_id) REFERENCES administrador_entity (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_seguimientos ADD CONSTRAINT FK_148B327D5CBBFEB FOREIGN KEY (seguimiento_id) REFERENCES seguimiento_entity (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta_entity ADD CONSTRAINT FK_66CFC66EDA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio_entity (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta_entity ADD CONSTRAINT FK_66CFC66E10C20D71 FOREIGN KEY (familiar_id) REFERENCES familiar_entity (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta_entity ADD CONSTRAINT FK_66CFC66E5B04E448 FOREIGN KEY (no_socio_id) REFERENCES no_socio_entity (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE familiar_entity ADD CONSTRAINT FK_E2C744CADA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio_entity (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE familiar_entity ADD CONSTRAINT FK_E2C744CA6A7CF079 FOREIGN KEY (cuota_id) REFERENCES cuota_entity (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE familiar_entity ADD CONSTRAINT FK_E2C744CABF396750 FOREIGN KEY (id) REFERENCES usuario_entity (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE no_socio_entity ADD CONSTRAINT FK_B579F01EBF396750 FOREIGN KEY (id) REFERENCES usuario_entity (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion_entity ADD CONSTRAINT FK_185CF58410C20D71 FOREIGN KEY (familiar_id) REFERENCES familiar_entity (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion_entity ADD CONSTRAINT FK_185CF584DA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio_entity (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE seguimiento_entity ADD CONSTRAINT FK_CC2CE2028F120099 FOREIGN KEY (reclamacion_id) REFERENCES reclamacion_entity (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE socio_entity ADD CONSTRAINT FK_4281B19B6A7CF079 FOREIGN KEY (cuota_id) REFERENCES cuota_entity (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE socio_entity ADD CONSTRAINT FK_4281B19BBF396750 FOREIGN KEY (id) REFERENCES usuario_entity (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE administrador_entity DROP FOREIGN KEY FK_8652ECD8BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_reclamaciones DROP FOREIGN KEY FK_7EFDEEFA642B8210
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_reclamaciones DROP FOREIGN KEY FK_7EFDEEFA8F120099
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_consultas DROP FOREIGN KEY FK_9334CBD5642B8210
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_consultas DROP FOREIGN KEY FK_9334CBD5E38D288B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_seguimientos DROP FOREIGN KEY FK_148B327642B8210
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_seguimientos DROP FOREIGN KEY FK_148B327D5CBBFEB
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
            ALTER TABLE familiar_entity DROP FOREIGN KEY FK_E2C744CADA04E6A9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE familiar_entity DROP FOREIGN KEY FK_E2C744CA6A7CF079
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE familiar_entity DROP FOREIGN KEY FK_E2C744CABF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE no_socio_entity DROP FOREIGN KEY FK_B579F01EBF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion_entity DROP FOREIGN KEY FK_185CF58410C20D71
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion_entity DROP FOREIGN KEY FK_185CF584DA04E6A9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE seguimiento_entity DROP FOREIGN KEY FK_CC2CE2028F120099
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE socio_entity DROP FOREIGN KEY FK_4281B19B6A7CF079
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE socio_entity DROP FOREIGN KEY FK_4281B19BBF396750
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE administrador_entity
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE admin_reclamaciones
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE admin_consultas
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE admin_seguimientos
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE consulta_entity
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE cuota_entity
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE familiar_entity
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE no_socio_entity
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE reclamacion_entity
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE seguimiento_entity
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE socio_entity
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE usuario_entity
        SQL);
    }
}
