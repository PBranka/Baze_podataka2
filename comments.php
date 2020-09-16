<!-- Prikaz svih komentara svih korisnika. -->

<?php

$sql = "SELECT * FROM komentar WHERE {$sifraFilma} = film_sifraFilma";

// Nije isti rezultat kao u movie.php, a buduci da uvlacimo kod, mora se razlikovati ime.
if ($Rezultat = mysqli_query ($con, $sql))
{
    // Jako je bitan redoslijed u tabeli komentar.
    // datum tekst korisnik_korisnickoIme film_sifraFilma
    if (mysqli_num_rows ($Rezultat) > 0)
    {
        while ($Red = mysqli_fetch_array ($Rezultat))
        {
            ?>

            <br>

            <div class = "row">
                <div class = "col">
                    <p class = "font-italic text-warning"> 
                        <?php print $Red[0].' '.$Red[2]; ?>
                    </p>
                </div>

                 <!-- Za brisanje komentara. -->
                <?php
               
               if ($korisnickoIme <> "")
               {
                   $sql = "SELECT * FROM administrator WHERE korisnik_korisnickoIme = '$korisnickoIme'";
                   $temp = "0";

                   if ($rez = mysqli_query ($con, $sql))
                        if (mysqli_num_rows ($rez) > 0)
                            $temp = "1"; // Administrator je ulogovan.

                    // Komentare moze brisati vlasnik komentara ili administrator.
                   if ($korisnickoIme == $Red[2] || $temp == "1") 
                   {
                ?>
                        <div class = "col">

                
                        <?php
                            $date = substr ($Red[0].'', 0, 10); // Ne mozemo drugacije proslijediti kroz link.
                            $time = substr ($Red[0].'', 11);
                        ?>

                            <form action = "movie.php" method = "POST">
                                <input type = "hidden" name = "sifraFilma" value = <?php print $sifraFilma; ?>> <!-- Samo za prosljedjivanje sifre filma. -->
                                <input type = "hidden" name = "korisnickoIme" value = <?php print $korisnickoIme; ?>> <!-- Samo za prosljedjivanje korisnickog imena. -->
                                <input type = "hidden" name = "date" value = <?php print $date; ?>> <!-- Samo za prosljedjivanje datuma komentara. -->
                                <input type = "hidden" name = "time" value = <?php print $time; ?>> <!-- Samo za prosljedjivanje vremena komentara. -->
                                <input type = "hidden" name = "korisnickoIme" value = "<?php print $Red[2]; ?>"> <!-- Samo za prosljedjivanje davaoca komentara. -->
                                <button type = "submit" class = "btn btn-sm active text-white shadow-lg float-right" style = "background-color: #004d40; border:0.5px solid #1de9b6;"> Obriši </button>
                            </form>

                        </div>
                <?php
                   }
                }
                ?>
               
            </div>

            <div class = "row ml-1 mr-1" style = "background-color: #fff8e1; border: 3px solid #1de9b6; box-shadow: 0px 24px 24px -6px rgba(0,0,0,.5);">
                <div class = "col">
                    <p>
                        <?php print $Red[1]; ?>
                    </p>
                </div>
            </div>

            <?php
        }
    }
    else // Nema komentara.
    {
        ?>

        <h6 class = "display-6 text-white"> Film dosad nije komentarisan. </h6>
    
        <?php
    }

}
else // Greska pri konekciji sa bazom.
{
    ?>

    <h6 class = "display-6 text-white"> Žao nam je, naišli smo na grešku pri konekciji. </h6>

     <?php
}

?>

