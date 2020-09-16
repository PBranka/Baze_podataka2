<?php

// Prikazuje filmove bilo da su to svi filmovi, filmovi iz odredjenog
// zanra ili filmovi sa odredjenim nazivom.

// Ukoliko trazimo po zanru.
if (isset($_GET['zanr']))
    $sql = "SELECT sifraFilma, avatar, naziv, godina, ocjena from film JOIN odobreni ON sifraFilma = film_sifraFilma WHERE zanr LIKE '%{$_GET['zanr']}%' ORDER BY naziv, godina";
    else if (isset($_GET['search'])) // Ukoliko trazimo po naslovu, stringovi se u SQL-u porede ne gledajuci velika i mala slova.
        $sql = "SELECT sifraFilma, avatar, naziv, godina, ocjena from film JOIN odobreni ON sifraFilma = film_sifraFilma WHERE naziv LIKE '%{$_GET['search']}%' ORDER BY naziv, godina";
        else
             $sql = "SELECT sifraFilma, avatar, naziv, godina, ocjena from film JOIN odobreni ON sifraFilma = film_sifraFilma ORDER BY naziv, godina"; // Prikazuje sve odobrene filmove.

if ($rezultat = mysqli_query ($con, $sql)) // Ako nema greske pri nabavci podataka...
{   
    if (mysqli_num_rows ($rezultat) > 0) // Ako uopste imamo podatke...
    {
        ?>

        <div class = "table">
            <table class = "table table-borderless">

        <?php

        $brojac = 0; // Samo pet filmova u jednom redu.

        ?>      
        
                <div class = "row"> 
        
        <?php

                while ($red = mysqli_fetch_array ($rezultat))
                {
                    $brojac++;  
        ?>          
        
                    <div class = "col"> 
                    
        <?php
                     $sifraFilma = $red[0];
                     $avatar = $red[1];
                     $naziv = $red[2];
                     $godina = $red[3];
                     $ocjena = $red[4]; 
                
                     require ('avatar.php'); // Za prikaz avatara jednog filma.

        ?> 
        
                    </div> 
                    
        <?php

                    if ($brojac % 5 == 0 && $brojac <> mysqli_num_rows ($rezultat)) // Ako red ima pet filmova, pravimo novi red.
                    {
        ?>      
        
                </div> 
                <div class = "row"> 
                
        <?php  
                    }
        }
        
        $brojac = $brojac % 5; // Treba nam ostatak da bismo napravili raspored ikonica u jednom redu ako je njihov broj manji od 5.
        if ($brojac > 0)
        {   
            while ($brojac < 5)
            {    
        ?>      
                     <div class = "col"> </div>
    
        <?php
                $brojac++;
            }
        }
        ?> 
                 </div> <!-- Zatvaramo posljednji red. -->
            </table> <!-- Zatvaramo tabelu -->
        </div> 
        
        <?php  
    }
    else // Nema takvih filmova medju odobrenima.
    {
        ?>

        <h5 class = "display-5"> Žao nam je, trenutno nema rezultata. </h5>

        <?php
    }
}
else // Greska pri konekciji sa bazom.
    {
        ?>

        <h5 class = "display-5"> Žao nam je, naišli smo na grešku pri konekciji. </h5>

        <?php
    }
?>

