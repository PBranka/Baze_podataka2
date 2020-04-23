CREATE SCHEMA IF NOT EXISTS `bioskop` DEFAULT CHARACTER SET utf8 ;
USE `bioskop` ;


CREATE TABLE IF NOT EXISTS `bioskop`.`korisnik` (
  `korisnickoIme` VARCHAR(30) NOT NULL,
  `sifraKorisnika` VARCHAR(30) NOT NULL,
  `mail` VARCHAR(255) NOT NULL,
  `ime` VARCHAR(30) NOT NULL,
  `prezime` VARCHAR(30) NOT NULL,
  `datumRodjenja` DATE NULL,
  PRIMARY KEY (`korisnickoIme`),
  UNIQUE INDEX `mail_UNIQUE` (`mail` ASC))
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `bioskop`.`kriticar` (
  `korisnik_korisnickoIme` VARCHAR(30) NOT NULL,
  PRIMARY KEY (`korisnik_korisnickoIme`),
  CONSTRAINT `fk_kriticar_korisnik1`
    FOREIGN KEY (`korisnik_korisnickoIme`)
    REFERENCES `bioskop`.`korisnik` (`korisnickoIme`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `bioskop`.`film` (
  `sifraFilma` INT NOT NULL AUTO_INCREMENT,
  `avatar` VARCHAR(255) NOT NULL,
  `naziv` VARCHAR(100) NOT NULL,
  `godina` INT NOT NULL,
  `trailer` VARCHAR(255) NOT NULL,
  `sadrzaj` LONGTEXT NULL,
  `glumci` VARCHAR(255) NOT NULL,
  `zanr` VARCHAR(30) NOT NULL,
  `ocjena` FLOAT NOT NULL DEFAULT 0,
  `brojKorisnika` INT NULL,
  `trajanje` INT NOT NULL,
  `datumFilma` DATE NOT NULL,
  `kriticar_korisnik_korisnickoIme` VARCHAR(30) NOT NULL,
  PRIMARY KEY (`sifraFilma`),
  INDEX `fk_film_kriticar1_idx` (`kriticar_korisnik_korisnickoIme` ASC),
  CONSTRAINT `fk_film_kriticar1`
    FOREIGN KEY (`kriticar_korisnik_korisnickoIme`)
    REFERENCES `bioskop`.`kriticar` (`korisnik_korisnickoIme`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `bioskop`.`komentar` (
  `datum` DATE NULL,
  `tekst` LONGTEXT NULL,
  `korisnik_korisnickoIme` VARCHAR(30) NOT NULL,
  `film_sifraFilma` INT NOT NULL,
  PRIMARY KEY (`datum`, `korisnik_korisnickoIme`, `film_sifraFilma`),
  INDEX `fk_komentar_korisnik_idx` (`korisnik_korisnickoIme` ASC),
  INDEX `fk_komentar_film1_idx` (`film_sifraFilma` ASC),
  CONSTRAINT `fk_komentar_korisnik`
    FOREIGN KEY (`korisnik_korisnickoIme`)
    REFERENCES `bioskop`.`korisnik` (`korisnickoIme`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_komentar_film1`
    FOREIGN KEY (`film_sifraFilma`)
    REFERENCES `bioskop`.`film` (`sifraFilma`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `bioskop`.`administrator` (
  `korisnik_korisnickoIme` VARCHAR(30) NOT NULL,
  PRIMARY KEY (`korisnik_korisnickoIme`),
  CONSTRAINT `fk_administrator_korisnik1`
    FOREIGN KEY (`korisnik_korisnickoIme`)
    REFERENCES `bioskop`.`korisnik` (`korisnickoIme`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `bioskop`.`filmofil` (
  `korisnik_korisnickoIme` VARCHAR(30) NOT NULL,
  PRIMARY KEY (`korisnik_korisnickoIme`),
  CONSTRAINT `fk_filmofil_korisnik1`
    FOREIGN KEY (`korisnik_korisnickoIme`)
    REFERENCES `bioskop`.`korisnik` (`korisnickoIme`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `bioskop`.`odobreni` (
  `film_sifraFilma` INT NOT NULL,
  `administrator_korisnik_korisnickoIme` VARCHAR(30) NOT NULL,
  PRIMARY KEY (`film_sifraFilma`),
  INDEX `fk_odobreni_administrator1_idx` (`administrator_korisnik_korisnickoIme` ASC),
  CONSTRAINT `fk_odobreni_film1`
    FOREIGN KEY (`film_sifraFilma`)
    REFERENCES `bioskop`.`film` (`sifraFilma`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_odobreni_administrator1`
    FOREIGN KEY (`administrator_korisnik_korisnickoIme`)
    REFERENCES `bioskop`.`administrator` (`korisnik_korisnickoIme`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `bioskop`.`sala` (
  `idSale` INT NOT NULL AUTO_INCREMENT,
  `brojMjesta` INT NOT NULL,
  PRIMARY KEY (`idSale`))
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `bioskop`.`prikazi` (
  `datumPrikazivanja` DATE NOT NULL,
  `termin` TIME NOT NULL,
  `odobreni_film_sifraFilma` INT NOT NULL,
  `sala_idSale` INT NOT NULL,
  PRIMARY KEY (`datumPrikazivanja`, `termin`, `odobreni_film_sifraFilma`, `sala_idSale`),
  INDEX `fk_prikazi_odobreni1_idx` (`odobreni_film_sifraFilma` ASC),
  INDEX `fk_prikazi_sala1_idx` (`sala_idSale` ASC),
  CONSTRAINT `fk_prikazi_odobreni1`
    FOREIGN KEY (`odobreni_film_sifraFilma`)
    REFERENCES `bioskop`.`odobreni` (`film_sifraFilma`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_prikazi_sala1`
    FOREIGN KEY (`sala_idSale`)
    REFERENCES `bioskop`.`sala` (`idSale`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `bioskop`.`karta` (
  `red` INT NOT NULL,
  `brojSjedista` INT NOT NULL,
  `prikazi_datumPrikazivanja` DATE NOT NULL,
  `prikazi_termin` TIME NOT NULL,
  `prikazi_odobreni_film_sifraFilma` INT NOT NULL,
  `prikazi_sala_idSale` INT NOT NULL,
  PRIMARY KEY (`red`, `brojSjedista`, `prikazi_datumPrikazivanja`, `prikazi_termin`, `prikazi_odobreni_film_sifraFilma`, `prikazi_sala_idSale`),
  INDEX `fk_karta_prikazi1_idx` (`prikazi_datumPrikazivanja` ASC, `prikazi_termin` ASC, `prikazi_odobreni_film_sifraFilma` ASC, `prikazi_sala_idSale` ASC),
  CONSTRAINT `fk_karta_prikazi1`
    FOREIGN KEY (`prikazi_datumPrikazivanja` , `prikazi_termin` , `prikazi_odobreni_film_sifraFilma` , `prikazi_sala_idSale`)
    REFERENCES `bioskop`.`prikazi` (`datumPrikazivanja` , `termin` , `odobreni_film_sifraFilma` , `sala_idSale`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `bioskop`.`rezervisi` (
  `filmofil_korisnik_korisnickoIme` VARCHAR(30) NOT NULL,
  `karta_red` INT NOT NULL,
  `karta_brojSjedista` INT NOT NULL,
  `karta_prikazi_datumPrikazivanja` DATE NOT NULL,
  `karta_prikazi_termin` TIME NOT NULL,
  `karta_prikazi_odobreni_film_sifraFilma` INT NOT NULL,
  `karta_prikazi_sala_idSale` INT NOT NULL,
  INDEX `fk_rezervisi_filmofil1_idx` (`filmofil_korisnik_korisnickoIme` ASC),
  PRIMARY KEY (`karta_red`, `karta_brojSjedista`, `karta_prikazi_datumPrikazivanja`, `karta_prikazi_termin`, `karta_prikazi_odobreni_film_sifraFilma`, `karta_prikazi_sala_idSale`),
  CONSTRAINT `fk_rezervisi_filmofil1`
    FOREIGN KEY (`filmofil_korisnik_korisnickoIme`)
    REFERENCES `bioskop`.`filmofil` (`korisnik_korisnickoIme`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_rezervisi_karta1`
    FOREIGN KEY (`karta_red` , `karta_brojSjedista` , `karta_prikazi_datumPrikazivanja` , `karta_prikazi_termin` , `karta_prikazi_odobreni_film_sifraFilma` , `karta_prikazi_sala_idSale`)
    REFERENCES `bioskop`.`karta` (`red` , `brojSjedista` , `prikazi_datumPrikazivanja` , `prikazi_termin` , `prikazi_odobreni_film_sifraFilma` , `prikazi_sala_idSale`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


