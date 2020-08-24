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
  `datum` DATETIME  NOT NULL DEFAULT current_timestamp,
  `tekst` LONGTEXT NOT NULL,
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


-- CHECK u obliku okidaca za provjeru godine i trajanja filma:
DELIMITER $$
CREATE TRIGGER film_check BEFORE INSERT ON `bioskop`.`film`
	FOR EACH ROW
    BEGIN
    IF (NEW.godina<=1900 OR NEW.godina>YEAR(CURRENT_DATE)) THEN 
		 SIGNAL SQLSTATE '45000'
         SET MESSAGE_TEXT='Godina filma nije validna!';
	END IF;
    IF (NEW.trajanje<=30) THEN 
		 SIGNAL SQLSTATE '45000'
         SET MESSAGE_TEXT='Greska: Film je kraci od 30 minuta!';
         ELSEIF (NEW.trajanje>=180) THEN
         SIGNAL SQLSTATE '45000'
         SET MESSAGE_TEXT='Greska: Film je duzi od 180 minuta!';
	END IF;
	END$$
    DELIMITER ;
    
-- TRIGGER koji prilikom ocjenjivanja filma mijenja prosjecnu ocjenu filma i broj korisnika:
DELIMITER $$
CREATE TRIGGER film_ocjena BEFORE UPDATE ON `bioskop`.`film`
	FOR EACH ROW
    BEGIN 
    IF (OLD.ocjena = 0) THEN SET NEW.brojKorisnika=1;
    ELSE
    SET NEW.ocjena=((OLD.ocjena * OLD.brojKorisnika) + NEW.ocjena)/(OLD.brojKorisnika + 1), NEW.brojKorisnika=OLD.brojKorisnika + 1;
    END IF;
	END$$
    DELIMITER ;
    
-- Indeksi za pretragu:
ALTER TABLE `bioskop`.`film` ADD INDEX USING HASH (`avatar`);

ALTER TABLE `bioskop`.`film` ADD INDEX USING BTREE (`naziv`);

ALTER TABLE `bioskop`.`film` ADD INDEX USING BTREE (`zanr`);

-- CHECK u obliku okidaca za promjenu termina filma:
DELIMITER $$
CREATE TRIGGER prikazivanje BEFORE INSERT ON `bioskop`.`prikazi`
FOR EACH ROW 
BEGIN
DECLARE mali,veliki TIME;
DECLARE malitrajanje, temp, novitrajanje INT; 

IF(SECOND(NEW.termin) <> '00') THEN   -- Unos sekundi u terminu filma je blokiran
		 SIGNAL SQLSTATE '45000'
         SET MESSAGE_TEXT='Greska: Nije potrebno unositi sekunde!';
		END IF;

IF(NEW.termin NOT BETWEEN '16:00:00' AND '23:00:00') THEN -- Dozvoljeni su samo termini izmedju 16:00 i 23:00
	     SIGNAL SQLSTATE '45000'
         SET MESSAGE_TEXT='Greska: Termin filma nije validan!';
		END IF;

SET novitrajanje=(SELECT trajanje FROM film WHERE sifraFilma=NEW.odobreni_film_sifraFilma); -- trajanje novog filma kojeg unosimo u tabelu prikazi
SET temp=HOUR(NEW.termin)*60+MINUTE(NEW.termin); -- termin filma koji unosimo u bazu u INT (racunamo u kojem minutu dana pocinje film)
SELECT MAX(termin) INTO mali FROM prikazi WHERE sala_idSale=NEW.sala_idSale AND datumPrikazivanja=NEW.datumPrikazivanja AND termin<NEW.termin; -- termin filma koji je prije termina novog,koji je u istoj sali istog datuma 
SELECT MIN(termin) INTO veliki FROM prikazi WHERE sala_idSale=NEW.sala_idSale AND datumPrikazivanja=NEW.datumPrikazivanja AND termin>NEW.termin; -- termin filma koji je poslije termina novog
IF(mali IS NOT NULL) THEN
	SET malitrajanje=(SELECT trajanje FROM film WHERE sifraFilma IN (SELECT odobreni_film_sifraFilma FROM prikazi WHERE sala_idSale=NEW.sala_idSale AND datumPrikazivanja=NEW.datumPrikazivanja AND termin = mali)); -- trajanje filma koji je prije novog
	IF ((HOUR(mali)*60+MINUTE(mali)+malitrajanje+15) > temp) THEN
					SIGNAL SQLSTATE '45000' 
                    SET MESSAGE_TEXT='Temin ulazi u termin prikazivanja drugog filma!';
	END IF;
END IF;
IF(veliki IS NOT NULL) THEN
					IF((temp+novitrajanje+15) > (HOUR(veliki)*60+MINUTE(veliki))) THEN
                    	SIGNAL SQLSTATE '45000' 
                        SET MESSAGE_TEXT='Temin ulazi u termin prikazivanja drugog filma!';
                    END IF;
END IF;
END$$
DELIMITER ;

-- EVENT za brisanje filma cije prikazivanje je isteklo:
/* SET GLOBAL EVENT_SCHEDULER="ON";
CREATE EVENT `DatumPrikazivanja` ON SCHEDULE EVERY 1 DAY STARTS '2020-_-_00:00:00' ON 
COMPLETION PRESERVE ENABLE
DO DELETE FROM `bioskop`.`prikazi` WHERE datumPrikazivanja > CURRENT_DATE; */

-- KOD ZA VALIDACIJU EMAIL-a
/*DELIMITER $$
CREATE TRIGGER validan_email BEFORE INSERT ON `bioskop`.`korisnik`
FOR EACH ROW
BEGIN   
IF (NEW.mail NOT LIKE '%[^a-z,0-9,@,.,!,#,$,%%,&,'',*,+,--,/,=,?,^,_,`,{,|,},~]%' 
        AND NEW.mail LIKE '%_@_%_.__%'
        AND NEW.mail NOT LIKE '%@%@%'  
        AND NEW.mail NOT LIKE '%..%'
        AND NEW.mail NOT LIKE '.%'
        AND NEW.mail NOT LIKE '%.')
THEN SET NEW.mail=NEW.mail;
        ELSE
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT='Greska: Mail nije validan!';
    END IF;
    END$$
    DELIMITER ;*/  
    