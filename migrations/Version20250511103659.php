<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250511103659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_seguimientos DROP FOREIGN KEY FK_148B327D5CBBFEB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Usuario DROP FOREIGN KEY FK_EDD889C16A7CF079
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_consultas DROP FOREIGN KEY FK_9334CBD5E38D288B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_reclamaciones DROP FOREIGN KEY FK_7EFDEEFA8F120099
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE consulta (id INT AUTO_INCREMENT NOT NULL, socio_id INT DEFAULT NULL, familiar_id INT DEFAULT NULL, no_socio_id INT DEFAULT NULL, atencion VARCHAR(50) NOT NULL, asunto VARCHAR(255) NOT NULL, fecha_apertura DATETIME NOT NULL, fecha_cierre DATETIME NOT NULL, estado VARCHAR(255) NOT NULL, consulta VARCHAR(500) NOT NULL, INDEX IDX_A6FE3FDEDA04E6A9 (socio_id), INDEX IDX_A6FE3FDE10C20D71 (familiar_id), INDEX IDX_A6FE3FDE5B04E448 (no_socio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE cuota (id INT AUTO_INCREMENT NOT NULL, importe NUMERIC(8, 2) NOT NULL, modo_pago VARCHAR(50) NOT NULL, tipo VARCHAR(50) NOT NULL, periodicidad VARCHAR(50) NOT NULL, iban VARCHAR(255) DEFAULT NULL, bizum VARCHAR(255) DEFAULT NULL, fecha_pago DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE reclamacion (id INT AUTO_INCREMENT NOT NULL, familiar_id INT DEFAULT NULL, socio_id INT DEFAULT NULL, fecha_apertura DATETIME NOT NULL, fecha_cierre DATETIME NOT NULL, atencion VARCHAR(50) NOT NULL, es_familiar TINYINT(1) NOT NULL, numero_socio VARCHAR(255) NOT NULL, sector VARCHAR(50) NOT NULL, asunto VARCHAR(255) NOT NULL, reclamacion VARCHAR(255) NOT NULL, estado VARCHAR(255) NOT NULL, prioridad VARCHAR(50) NOT NULL, INDEX IDX_3AE0B2210C20D71 (familiar_id), INDEX IDX_3AE0B22DA04E6A9 (socio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE seguimiento (id INT AUTO_INCREMENT NOT NULL, reclamacion_id INT DEFAULT NULL, fecha DATETIME NOT NULL, comentario LONGTEXT NOT NULL, INDEX IDX_1B2181D8F120099 (reclamacion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta ADD CONSTRAINT FK_A6FE3FDEDA04E6A9 FOREIGN KEY (socio_id) REFERENCES usuario (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta ADD CONSTRAINT FK_A6FE3FDE10C20D71 FOREIGN KEY (familiar_id) REFERENCES usuario (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta ADD CONSTRAINT FK_A6FE3FDE5B04E448 FOREIGN KEY (no_socio_id) REFERENCES usuario (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion ADD CONSTRAINT FK_3AE0B2210C20D71 FOREIGN KEY (familiar_id) REFERENCES usuario (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion ADD CONSTRAINT FK_3AE0B22DA04E6A9 FOREIGN KEY (socio_id) REFERENCES usuario (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE seguimiento ADD CONSTRAINT FK_1B2181D8F120099 FOREIGN KEY (reclamacion_id) REFERENCES reclamacion (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE seguimiento_entity DROP FOREIGN KEY FK_CC2CE2028F120099
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta_entity DROP FOREIGN KEY FK_66CFC66E10C20D71
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta_entity DROP FOREIGN KEY FK_66CFC66E5B04E448
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta_entity DROP FOREIGN KEY FK_66CFC66EDA04E6A9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion_entity DROP FOREIGN KEY FK_185CF58410C20D71
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion_entity DROP FOREIGN KEY FK_185CF584DA04E6A9
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE seguimiento_entity
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE cuota_entity
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE consulta_entity
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE reclamacion_entity
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Usuario ADD CONSTRAINT FK_2265B05D6A7CF079 FOREIGN KEY (cuota_id) REFERENCES cuota (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Usuario RENAME INDEX idx_edd889c16a7cf079 TO IDX_2265B05D6A7CF079
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Usuario RENAME INDEX idx_edd889c1da04e6a9 TO IDX_2265B05DDA04E6A9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_reclamaciones DROP FOREIGN KEY FK_7EFDEEFA8F120099
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_reclamaciones ADD CONSTRAINT FK_7EFDEEFA8F120099 FOREIGN KEY (reclamacion_id) REFERENCES reclamacion (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_consultas DROP FOREIGN KEY FK_9334CBD5E38D288B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_consultas ADD CONSTRAINT FK_9334CBD5E38D288B FOREIGN KEY (consulta_id) REFERENCES consulta (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_seguimientos DROP FOREIGN KEY FK_148B327D5CBBFEB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_seguimientos ADD CONSTRAINT FK_148B327D5CBBFEB FOREIGN KEY (seguimiento_id) REFERENCES seguimiento (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_consultas DROP FOREIGN KEY FK_9334CBD5E38D288B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE usuario DROP FOREIGN KEY FK_2265B05D6A7CF079
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_reclamaciones DROP FOREIGN KEY FK_7EFDEEFA8F120099
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_seguimientos DROP FOREIGN KEY FK_148B327D5CBBFEB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE seguimiento_entity (id INT AUTO_INCREMENT NOT NULL, reclamacion_id INT DEFAULT NULL, fecha DATETIME NOT NULL, comentario LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_CC2CE2028F120099 (reclamacion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE cuota_entity (id INT AUTO_INCREMENT NOT NULL, importe NUMERIC(8, 2) NOT NULL, modo_pago VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, tipo VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, periodicidad VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, iban VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, bizum VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, fecha_pago DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE consulta_entity (id INT AUTO_INCREMENT NOT NULL, socio_id INT DEFAULT NULL, familiar_id INT DEFAULT NULL, no_socio_id INT DEFAULT NULL, atencion VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, asunto VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, fecha_apertura DATETIME NOT NULL, fecha_cierre DATETIME NOT NULL, estado VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, consulta VARCHAR(500) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_66CFC66E5B04E448 (no_socio_id), INDEX IDX_66CFC66E10C20D71 (familiar_id), INDEX IDX_66CFC66EDA04E6A9 (socio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE reclamacion_entity (id INT AUTO_INCREMENT NOT NULL, familiar_id INT DEFAULT NULL, socio_id INT DEFAULT NULL, fecha_apertura DATETIME NOT NULL, fecha_cierre DATETIME NOT NULL, atencion VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, es_familiar TINYINT(1) NOT NULL, numero_socio VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, sector VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, asunto VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, reclamacion VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, estado VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prioridad VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_185CF584DA04E6A9 (socio_id), INDEX IDX_185CF58410C20D71 (familiar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE seguimiento_entity ADD CONSTRAINT FK_CC2CE2028F120099 FOREIGN KEY (reclamacion_id) REFERENCES reclamacion_entity (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta_entity ADD CONSTRAINT FK_66CFC66E10C20D71 FOREIGN KEY (familiar_id) REFERENCES Usuario (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta_entity ADD CONSTRAINT FK_66CFC66E5B04E448 FOREIGN KEY (no_socio_id) REFERENCES Usuario (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consulta_entity ADD CONSTRAINT FK_66CFC66EDA04E6A9 FOREIGN KEY (socio_id) REFERENCES Usuario (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion_entity ADD CONSTRAINT FK_185CF58410C20D71 FOREIGN KEY (familiar_id) REFERENCES Usuario (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion_entity ADD CONSTRAINT FK_185CF584DA04E6A9 FOREIGN KEY (socio_id) REFERENCES Usuario (id) ON UPDATE NO ACTION ON DELETE NO ACTION
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
            ALTER TABLE reclamacion DROP FOREIGN KEY FK_3AE0B2210C20D71
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamacion DROP FOREIGN KEY FK_3AE0B22DA04E6A9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE seguimiento DROP FOREIGN KEY FK_1B2181D8F120099
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE consulta
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE cuota
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE reclamacion
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE seguimiento
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_consultas DROP FOREIGN KEY FK_9334CBD5E38D288B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_consultas ADD CONSTRAINT FK_9334CBD5E38D288B FOREIGN KEY (consulta_id) REFERENCES consulta_entity (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_reclamaciones DROP FOREIGN KEY FK_7EFDEEFA8F120099
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_reclamaciones ADD CONSTRAINT FK_7EFDEEFA8F120099 FOREIGN KEY (reclamacion_id) REFERENCES reclamacion_entity (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE usuario ADD CONSTRAINT FK_EDD889C16A7CF079 FOREIGN KEY (cuota_id) REFERENCES cuota_entity (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE usuario RENAME INDEX idx_2265b05dda04e6a9 TO IDX_EDD889C1DA04E6A9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE usuario RENAME INDEX idx_2265b05d6a7cf079 TO IDX_EDD889C16A7CF079
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_seguimientos DROP FOREIGN KEY FK_148B327D5CBBFEB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE admin_seguimientos ADD CONSTRAINT FK_148B327D5CBBFEB FOREIGN KEY (seguimiento_id) REFERENCES seguimiento_entity (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
    }
}
