<!-- Za toast. -->
<script>

$(document).ready(function(){
$('.toast').toast('show');
});
        
</script>

<?php

// Dodavanje karte u bazu.

if (isset ($_GET['rezR']))
{ 
    $temp = "rezervisali mjesto.";

    if (isset ($_GET['brisanje'])) // Brisemo kartu.
    {
        $temp = "obrisali rezervaciju.";
        $sql = "DELETE FROM rezervisi WHERE 
                BINARY korisnik_korisnickoIme = '{$_GET['ime']}' and karta_prikazi_datumPrikazivanja = '{$_GET['datumPrikazivanja']}' and
                karta_prikazi_termin = '{$_GET['termin']}' and karta_prikazi_odobreni_film_sifraFilma = {$_GET['sifraFilma']} and
                karta_prikazi_sala_idSale = {$_GET['idSale']} and karta_red = {$_GET['rezR']} and karta_brojSjedista = {$_GET['rezM']}";
    }
    else // Dodajemo kartu.
        $sql = "INSERT into rezervisi 
        (korisnik_korisnickoIme, karta_prikazi_datumPrikazivanja, karta_prikazi_termin, karta_prikazi_odobreni_film_sifraFilma, karta_prikazi_sala_idSale, karta_red, karta_brojSjedista)
        values 
        ('{$_GET['korisnickoIme']}', '{$_GET['datumPrikazivanja']}', '{$_GET['termin']}', {$_GET['sifraFilma']}, {$_GET['idSale']}, {$_GET['rezR']}, {$_GET['rezM']})";
    
    if ($rezultat = mysqli_query ($con, $sql))
    {
        ?>
        <!-- Obavijest o tome da li je karta dodata ili ne. -->
        <div class = "toast" data-autohide = "false" style = "border: 1.5px solid #1de9b6; box-shadow: 0px 24px 24px -6px rgba(0,0,0,.5);">
      
            <div class = "toast-header" style = "background-color: #263238;">
                <button type = "button" class = "close" data-dismiss = "toast"> <p class = "text-info"> &times; </p> </button>
            </div>
      
            <div class = "toast-body text-dark" style = "background-color: #b2ebf2;">
                <p> Uspješno ste <?php print $temp; ?>. </p>
            </div>

      </div>
     
      <?php
    }         
}


      
  
       
  
       

