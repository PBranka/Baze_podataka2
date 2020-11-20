<!-- Unosimo podatke o jednom filmu, tj. dodajemo ga. -->

<!-- Treba nam za tooltip. -->
<script>

$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});

</script>

<?php

    $zanrovi = array ('akcija', 'animacija', 'avantura', 'drama', 'fantazija', 'horor', 'komedija', 'misterja', 'mjuzikl', 'ratni', 'romansa', 'triler', 'vestern');
    
    if (isset($_POST['naziv'])) // Neko pokusava da doda film.
    {
        $pom = ""; 
        $datum = date ('Y-m-d'); // Trenutni datum.

        for ($i = 0; $i < count ($zanrovi); $i++)
            if (isset($_POST[$zanrovi[$i]]))
                $pom = $pom.''.$zanrovi[$i].' ';

      
        if ($pom <> "") // Mora biti odabran zanr.
        {   
            if (isset ($_POST['sadrzaj']))
                $sadrzaj = $_POST['sadrzaj'];
            else
                $sadrzaj = "";

            $sql1 = "INSERT into film 
                    (avatar, naziv, godina, trailer, sadrzaj, glumci, zanr, trajanje, datumFilma, kriticar_korisnik_korisnickoIme) values
                    ('{$_POST['avatar']}', '{$_POST['naziv']}', {$_POST['godina']}, '{$_POST['trailer']}', '{$sadrzaj}', '{$_POST['glumci']}', '{$pom}', {$_POST['trajanje']}, '{$datum}', '{$_GET['korisnickoIme']}')"; 

            mysqli_query ($con, $sql1);
        }
    }

?>

<style>

    input[type = text], input[type = number], input[type = url]
    {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: 1.5px solid #1de9b6;
        box-shadow: 0px 16px 14px -6px rgba(0,0,0,.5); 
        background: #fff8e1;
    }
           
</style>
  
<!-- Modal za dodavanje filma. -->
<div class = "modal fade" id = "myModal">
    <div class = "modal-dialog">
        <div class = "modal-content">

            <div class = "modal-header text-white" style = "background-color: #004d40; border: 3px solid #1de9b6;">
                <h4 class = "modal-title"> Dodavanje filma </h4>
                <button type = "button" class = "close" data-dismiss = "modal"><p class = "text-info"> &times; </p></button>
            </div>
             
            <div class = "modal-body text-warning" style = "background-color: #004d40; border: 3px solid #1de9b6;">
                <form action = "moviesSettings.php<?php print '?korisnickoIme='.$_GET['korisnickoIme']; ?>" method = "POST"> 

                    <label for = "name"> Naziv </label>
                    <input type = "text" placeholder = "Unesite naziv filma..." name = "naziv" id= "naziv" required>

                    <label for = "year"> Godina filma </label> <br>
                    <input type = "number" placeholder = "Unesite godinu filma..." name = "godina" id = "godina" required>
                    

                    <label for = "avatar"> Avatar </label>
                    <input type = "text" placeholder = "Unesite adresu avatara..." data-toggle = "tooltip" data-placement = "right" title = "naziv_filma (godina).format_slike" name = "avatar" id = "avatar" required>
             
                   
                    <label for = "trailer"> Trailer </label> <br>
                    <input type = "url" placeholder = "Unesite URL trejlera..." data-toggle = "tooltip" data-placement = "right" title = "u URL watch?v= zamijeniti sa embed/" name = "trailer" id = "trailer" required>
                    

                    <label for = "content"> Sadržaj </label>
                    <input type = "text" placeholder = "Unesite kratak sadržaj filma..." name = "sadrzaj" id = "sadrzaj">

                    <label for = "actors"> Glumci </label>
                    <input type = "text" placeholder = "Unesite ime i prezime glumaca..." data-toggle = "tooltip" data-placement = "right" title = "Brad Pitt, Angelina Jolie" name = "glumci" id = "glumci" required>

                    <label for = "genre"> Žanr filma </label><br> 

                    <div class = "container-fluid text-body text-bold" data-toggle = "tooltip" data-placement = "right" title = "Obavezno odabrati bar jedan žanr." style = "background-image: url('images/Wallpaper2.jpg'); background-size: cover; background-color: #004d40;"> <!-- Treba nam zbog pozadine. -->

                    <?php 

                        for ($i = 0; $i < count ($zanrovi); $i++)
                        {
                            ?>
                            
                            <div class = "form-check">
                                <label class = "form-check-label">
                                    <input type = "checkbox" class = "form-check-input" name = <?php print $zanrovi[$i]; ?>>
                                        <b> <?php print $zanrovi[$i]; ?> </b>
                                </label>
                            </div>

                            <?php
                        }
                    
                    ?>
                  
                    </div><br> <!-- Zatvaramo kontejner. -->

                    <label for = "lasting"> Trajanje </label> <br>
                    <input type = "number" placeholder = "Unesite trajanje filma..." data-toggle = "tooltip" data-placement = "right" title = "Unose se minute (30 - 180)." name = "trajanje" id = "trajanje" required> <br> 
      
                    <button type = "submit" class = "btn text-white" style ="background-color: #004d40; border:0.5px solid #1de9b6;"> Dodaj </button>
                
                </form>
            </div>
           
         </div>
    </div>
</div>  
