-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mytiendaPeliculas
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `mytiendaPeliculas` ;

-- -----------------------------------------------------
-- Schema mytiendaPeliculas
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mytiendaPeliculas` DEFAULT CHARACTER SET utf8 ;
-- -----------------------------------------------------
-- Schema mytiendapeliculas
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `mytiendapeliculas` ;

-- -----------------------------------------------------
-- Schema mytiendapeliculas
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mytiendapeliculas` DEFAULT CHARACTER SET utf8 ;
USE `mytiendaPeliculas` ;

-- -----------------------------------------------------
-- Table `plataforma`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `plataforma` ;

CREATE TABLE IF NOT EXISTS `plataforma` (
  `id_plataforma` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `icono` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_plataforma`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `genero`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `genero` ;

CREATE TABLE IF NOT EXISTS `genero` (
  `id_genero` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id_genero`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pelicula`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pelicula` ;

CREATE TABLE IF NOT EXISTS `pelicula` (
  `id_pelicula` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(255) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `imagen` VARCHAR(255) NOT NULL,
  `id_plataforma` INT NOT NULL,
  `id_genero` INT NOT NULL,
  PRIMARY KEY (`id_pelicula`),
  CONSTRAINT `fk_pelicula_plataforma`
    FOREIGN KEY (`id_plataforma`)
    REFERENCES `plataforma` (`id_plataforma`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pelicula_genero1`
    FOREIGN KEY (`id_genero`)
    REFERENCES `genero` (`id_genero`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `usuario` ;

CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `contrasenia` VARCHAR(255) NOT NULL,
  `es_admin` TINYINT NOT NULL,
  PRIMARY KEY (`id_usuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `alquiler`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `alquiler` ;

CREATE TABLE IF NOT EXISTS `alquiler` (
  `id_alquiler` INT NOT NULL AUTO_INCREMENT,
  `id_usuario` INT NOT NULL,
  `id_pelicula` INT NOT NULL,
  `fecha_prestamo` DATETIME NOT NULL,
  `fecha_devolucion` DATETIME NULL,
  PRIMARY KEY (`id_alquiler`),
  CONSTRAINT `fk_alquiler_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_alquiler_pelicula1`
    FOREIGN KEY (`id_pelicula`)
    REFERENCES `pelicula` (`id_pelicula`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `mytiendapeliculas` ;

-- -----------------------------------------------------
-- Table `genero`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `genero` ;

CREATE TABLE IF NOT EXISTS `genero` (
  `id_genero` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id_genero`))
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `plataforma`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `plataforma` ;

CREATE TABLE IF NOT EXISTS `plataforma` (
  `id_plataforma` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `icono` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_plataforma`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `pelicula`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pelicula` ;

CREATE TABLE IF NOT EXISTS `pelicula` (
  `id_pelicula` INT(11) NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(255) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `imagen` VARCHAR(255) NOT NULL,
  `id_plataforma` INT(11) NOT NULL,
  `id_genero` INT(11) NOT NULL,
  PRIMARY KEY (`id_pelicula`),
  CONSTRAINT `fk_pelicula_genero1`
    FOREIGN KEY (`id_genero`)
    REFERENCES `genero` (`id_genero`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pelicula_plataforma`
    FOREIGN KEY (`id_plataforma`)
    REFERENCES `plataforma` (`id_plataforma`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 17
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `usuario` ;

CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `contrasenia` VARCHAR(255) NOT NULL,
  `es_admin` TINYINT(4) NOT NULL,
  PRIMARY KEY (`id_usuario`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `continuarviendo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `continuarviendo` ;

CREATE TABLE IF NOT EXISTS `continuarviendo` (
  `id_continuarViendo` INT(11) NOT NULL AUTO_INCREMENT,
  `id_pelicula` INT(11) NOT NULL,
  `id_usuario` INT(11) NOT NULL,
  PRIMARY KEY (`id_continuarViendo`),
  CONSTRAINT `fk_continuarViendo_pelicula1`
    FOREIGN KEY (`id_pelicula`)
    REFERENCES `pelicula` (`id_pelicula`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_continuarViendo_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `plataforma`
-- -----------------------------------------------------
START TRANSACTION;
USE `mytiendaPeliculas`;
INSERT INTO `plataforma` (`id_plataforma`, `nombre`, `icono`) VALUES (1, 'Netflix', './imagenes/icon/netflix.png');
INSERT INTO `plataforma` (`id_plataforma`, `nombre`, `icono`) VALUES (2, 'HBO', './imagenes/icon/hbo.png');
INSERT INTO `plataforma` (`id_plataforma`, `nombre`, `icono`) VALUES (3, 'Disney', './imagenes/icon/disney-icon.png');

COMMIT;


-- -----------------------------------------------------
-- Data for table `genero`
-- -----------------------------------------------------
START TRANSACTION;
USE `mytiendaPeliculas`;
INSERT INTO `genero` (`id_genero`, `nombre`) VALUES (1, 'Acción');
INSERT INTO `genero` (`id_genero`, `nombre`) VALUES (2, 'Aventura');
INSERT INTO `genero` (`id_genero`, `nombre`) VALUES (3, 'Comedia');
INSERT INTO `genero` (`id_genero`, `nombre`) VALUES (4, 'Drama');
INSERT INTO `genero` (`id_genero`, `nombre`) VALUES (5, 'Ciencia Ficción');
INSERT INTO `genero` (`id_genero`, `nombre`) VALUES (6, 'Fantasía');

COMMIT;


-- -----------------------------------------------------
-- Data for table `pelicula`
-- -----------------------------------------------------
START TRANSACTION;
USE `mytiendaPeliculas`;
INSERT INTO `pelicula` (`titulo`, `descripcion`, `imagen`, `id_plataforma`, `id_genero`)
VALUES (
    'Spider-Man',
    'Un joven adquiere habilidades de araña y lucha contra el crimen en Nueva York.',
    './imagenes/peliculas-series/spiderman.png',
    3, -- Disney
    1  -- Acción
);

-- Película 2: Rambo
INSERT INTO `pelicula` (`titulo`, `descripcion`, `imagen`, `id_plataforma`, `id_genero`)
VALUES (
    'Rambo',
    'Un veterano de guerra utiliza sus habilidades para sobrevivir en situaciones extremas.',
    './imagenes/peliculas-series/rambo.png',
    1, -- Netflix
    1  -- Acción
);

-- Película 3: Armageddon
INSERT INTO `pelicula` (`titulo`, `descripcion`, `imagen`, `id_plataforma`, `id_genero`)
VALUES (
    'Armageddon',
    'Un equipo de perforadores viaja al espacio para salvar a la Tierra de un asteroide gigante.',
    './imagenes/peliculas-series/armageddon.png',
    2, -- HBO
    5  -- Ciencia Ficción
);

-- Película 4: Hard Die
INSERT INTO `pelicula` (`titulo`, `descripcion`, `imagen`, `id_plataforma`, `id_genero`)
VALUES (
    'Hard Die',
    'Una historia llena de acción con intensos momentos de supervivencia y heroísmo.',
    './imagenes/peliculas-series/hard-fie.png',
    1, -- Netflix
    1  -- Acción
);

-- Película 5: El señor de los anillos: Anillos de poder
INSERT INTO `pelicula` (`titulo`, `descripcion`, `imagen`, `id_plataforma`, `id_genero`)
VALUES (
    'El señor de los anillos: Anillos de poder',
    'Explora la creación de los anillos y el surgimiento de grandes poderes en la Tierra Media.',
    './imagenes/peliculas-series/anillos.png',
    2, -- HBO
    4  -- Fantasía
);

-- Película 6: John Wick
INSERT INTO `pelicula` (`titulo`, `descripcion`, `imagen`, `id_plataforma`, `id_genero`)
VALUES (
    'John Wick',
    'Un exasesino regresa al mundo del crimen para vengar la muerte de su perro.',
    './imagenes/peliculas-series/johnwick.png',
    2, -- HBO
    1  -- Acción
);

-- Película 7: Scarface
INSERT INTO `pelicula` (`titulo`, `descripcion`, `imagen`, `id_plataforma`, `id_genero`)
VALUES (
    'Scarface',
    'La historia de un inmigrante que asciende al poder en el mundo del narcotráfico.',
    './imagenes/peliculas-series/scars-face.png',
    1, -- Netflix
    3  -- Drama
);

-- Película 8: Terminator 2
INSERT INTO `pelicula` (`titulo`, `descripcion`, `imagen`, `id_plataforma`, `id_genero`)
VALUES (
    'Terminator 2',
    'Un cyborg debe proteger a un joven para asegurar el futuro de la humanidad.',
    './imagenes/peliculas-series/terminator-2.png',
    2, -- HBO
    5  -- Ciencia Ficción
);

-- Película 9: Pulp Fiction
INSERT INTO `pelicula` (`titulo`, `descripcion`, `imagen`, `id_plataforma`, `id_genero`)
VALUES (
    'Pulp Fiction',
    'Historias entrelazadas de crimen y redención con un estilo único.',
    './imagenes/peliculas-series/pulp-fiction.png',
    2, -- HBO
    3  -- Drama
);

-- Película 10: Fast & Furious
INSERT INTO `pelicula` (`titulo`, `descripcion`, `imagen`, `id_plataforma`, `id_genero`)
VALUES (
    'Fast & Furious',
    'Carreras clandestinas y acción explosiva en una saga inolvidable.',
    './imagenes/peliculas-series/fast-furious.png',
    1, -- Netflix
    1  -- Acción
);

-- Película 11: Star Wars
INSERT INTO `pelicula` (`titulo`, `descripcion`, `imagen`, `id_plataforma`, `id_genero`)
VALUES (
    'Star Wars',
    'La lucha entre el Imperio y la Rebelión en una galaxia muy, muy lejana.',
    './imagenes/peliculas-series/star-wars.png',
    3, -- Disney
    4  -- Fantasía
);
-- Película 12: Terminator 1
INSERT INTO `pelicula` (`titulo`, `descripcion`, `imagen`, `id_plataforma`, `id_genero`)
VALUES (
    'Terminator 1',
    'Un cyborg asesino es enviado del futuro para eliminar a una mujer cuyo hijo será clave en la lucha contra las máquinas.',
    'imagenes/peliculas-series/terminator-1.png',
    2, -- Disney
    1  -- Acción
);
INSERT INTO `pelicula` (`titulo`, `descripcion`, `imagen`, `id_plataforma`, `id_genero`)
VALUES 
    (
        'Ace Ventura', -- pelicula 13
        'Un excéntrico detective de mascotas debe resolver casos hilarantes mientras enfrenta situaciones absurdas.',
        './imagenes/peliculas-series/ace-ventura.png',
        1, -- Netflix
        3  -- Comedia
    ),
    (
        'American Pie', -- pelicula 14
        'Un grupo de adolescentes atraviesa situaciones cómicas y embarazosas mientras exploran la amistad, el amor y la madurez.',
        './imagenes/peliculas-series/american-pie.png',
        1, -- Netflix
        3  -- Comedia
    ),
    (
        'Avatar 2', -- pelicula 15
        'Jake Sully y su familia enfrentan nuevos desafíos en Pandora mientras protegen su hogar de una amenaza externa.',
        './imagenes/peliculas-series/avatar-2.png',
        2, -- HBO Max
        5  -- Ciencia ficción
    ),
    (
        'Indiana Jones', -- pelicula 16
        'El intrépido arqueólogo se embarca en emocionantes aventuras mientras busca artefactos antiguos y enfrenta peligros mortales.',
        './imagenes/peliculas-series/indiana-jones.png',
        2, -- HBO Max
        1  -- Acción
    );
COMMIT;


-- -----------------------------------------------------
-- Data for table `usuario`
-- -----------------------------------------------------
START TRANSACTION;
USE `mytiendaPeliculas`;
INSERT INTO `usuario` (`id_usuario`, `nombre`, `email`, `contrasenia`, `es_admin`) VALUES (1, 'alejandro', 'hermsale@gmail.com', 'alejandro2024', 1);
INSERT INTO `usuario` (`id_usuario`, `nombre`, `email`, `contrasenia`, `es_admin`) VALUES (2, 'agustin', 'agustintejero@gmail.com', 'agustin2024', 0);

COMMIT;

