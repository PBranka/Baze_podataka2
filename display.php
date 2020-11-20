<!-- Termini prikazivanja odredjenog filma. -->

<?php

require ('addDisplay.php'); // Modal za dodavanje prikazivanja.

// Kriticar ce regulisati prikazivanja i rezervacije pa je bitno da ga pamtimo.
$kriticar = 0;

if ($korisnickoIme <> "")
{
    $sql = "SELECT * FROM kriticar WHERE BINARY korisnik_korisnickoIme = '{$korisnickoIme}'";
                  
    if ($rez = mysqli_query ($con, $sql))
        if (mysqli_num_rows ($rez) > 0)
            $kriticar = 1; // Kriticar je ulogovan.
}

?>

<br>

<div class = "dropdown">

    <button type = "button" class = "btn text-white dropdown-toggle" data-toggle = "dropdown" style ="background-color: #004d40; border:0.5px solid #1de9b6;"> Prikazivanja </button>

    <div class = "dropdown-menu scrollable-menu" style ="background-color: #004d40; max-height: 325px; overflow-x: hidden; border:0.5px solid #1de9b6; box-shadow: 0px 24px 24px -6px rgba(0,0,0,.5);">
        <?php

                $sql = "SELECT datumPrikazivanja, termin, sala_idSale as idSale FROM prikazi WHERE odobreni_film_sifraFilma = {$sifraFilma}";
                
                if ($rezultat = mysqli_query ($con, $sql))
                    while ($row = mysqli_fetch_array ($rezultat)) 
                    {
                        ?> 
                        
                        <span class = "dropdown-item-text"> 
                            <p class = "text-warning"> 
                                <?php  
                                    
                                    print $row[0].'  '.substr($row[1], 0, 5).'  <p class = "text-muted"> Sala '.$row[2].'</p>';

                                    // Za brisanje prikazivanja.
                                    if ($kriticar == 1)
                                    {
                                        ?> 
                                        <a href = "movie.php?sifraFilma=<?php print $sifraFilma.'&korisnickoIme='.$korisnickoIme.'&datumPrikazivanja='.$row[0].'&termin='.$row[1].'&idSale='.$row[2]; ?>">
                                            <span class = "fa fa-trash"> </span>
                                        </a>
                                        <?php
                                    } 

                                    // Za rezervaciju karata, samo prijavljeni korisnici.
                                    if ($korisnickoIme <> "")
                                    {
                                        ?> 
                                        <a href = "cards.php?sifraFilma=<?php print $sifraFilma.'&korisnickoIme='.$korisnickoIme.'&datumPrikazivanja='.$row[0].'&termin='.$row[1].'&idSale='.$row[2]; ?>">
                                            <span class = "fas fa-shopping-cart text-info"> </span>
                                        </a>
                                        <?php
                                    }
                                    
                                ?>
                            </p>
                        </span>

                        <?php
                    }
                
                // Za dodavanje prikazivanja.
                if ($kriticar == 1)
                {
                    ?>
                    <div class = "dropdown-divider" style = "border:0.5px solid #1de9b6;"> </div>
                    <button type = "button" class = "btn btn-block text-white active" data-toggle = "modal" data-target = "#myModal" style ="background-color: #004d40; border:0.5px solid #1de9b6;"> Dodaj </button>
                    <?php
                }
          ?>
    </div>

</div>



