<htmL>
<head>

    <?php require ('bootstrap.php'); ?>

</head>

<body>

<!-- Treba nam za tooltip. -->
<script>

$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});

</script>

<!-- Treba nam za toast. -->
<script>

$(document).ready(function(){
  $('.toast').toast('show');
});

</script>

<!-- Kontejner za sve na ovoj strani. vh = view height -->
<div class = "container-fluid text-white" style = "background-color: #004d40; height: 100vh; overflow: auto;">

<?php

// Odvojen nam je od ostalih php fajlova, pa moramo ponovo uvoziti connect.php.
require ('connect.php');

// Pamtimo korisnika ako je isti ulogovan.
$korisnickoIme = "";

if (isset($_GET['korisnickoIme']))
    $korisnickoIme = $_GET['korisnickoIme'];
else
    if (isset($_POST['korisnickoIme']))
         $korisnickoIme = $_POST['korisnickoIme'];

// Prikaz informacija o jednom filmu.

if (isset($_GET['sifraFilma']))
    $sifraFilma = $_GET['sifraFilma'];
else
    if (isset($_POST['sifraFilma']))
         $sifraFilma = $_POST['sifraFilma'];

$toast = "";

// Ukoliko je neko ocijenio film, azuriramo ocjenu u bazi.
if (isset ($_GET['range']))
{   
    $sql = "UPDATE film SET ocjena = {$_GET['range']} WHERE sifraFilma = $sifraFilma";
    mysqli_query ($con, $sql);

    $toast = "ocijenili film";
}

// Ukoliko je neko komentarisao film, unosimo komentar u bazu. 
if (isset ($_POST['tekstKomentara']))
{   
    $sql = "INSERT into komentar (tekst, korisnik_korisnickoIme, film_sifraFilma) VALUES ('{$_POST['tekstKomentara']}', '{$korisnickoIme}', {$sifraFilma})";
    mysqli_query ($con, $sql);

    $toast = "dodali komentar";
}


// Ukoliko je neko obrisao komentar vezan za film, brisemo isti iz baze.
if (isset ($_POST['date'])) // Dovoljno je da datum bude aktiviran da bismo znali kako se neki komentar brise.
{
    $sql = "DELETE from komentar WHERE datum = '{$_POST['date']} {$_POST['time']}' and BINARY korisnik_korisnickoIme = '{$_POST['korisnickoIme']}' and film_sifraFilma = {$sifraFilma}";
    mysqli_query ($con, $sql);

    $toast = "obrisali komentar.";
}

// Ukoliko kriticar dodaje prikazivanje.
if (isset ($_POST['datumPrikazivanja']))
{
    // Unosimo prikazivanje.
    $sql1 = "INSERT into prikazi (datumPrikazivanja, termin, odobreni_film_sifraFilma, sala_idSale) values
                        ('{$_POST['datumPrikazivanja']}', '{$_POST['termin']}', {$sifraFilma}, {$_POST['sala']})"; 

    // Trebalo bi da unesemo karte za dato prikazivanje, ovdje malo sporije ucitava zbog petlji.
    $sql2 = "SELECT brojRedova, brojMjesta FROM sala WHERE idSale = {$_POST['sala']}";

    if (mysqli_query ($con, $sql1))
    {
        $toast = "dodali prikazivanje filma.";

        if ($rez = mysqli_query ($con, $sql2))
        {
            $red = mysqli_fetch_array ($rez);

            for ($i = 1; $i <= $red[0]; $i++) // Prolazimo kroz redove sale.
                for ($j = 1; $j <= $red[1]; $j++) // Prolazimo kroz mjesta u redu.
                {
                    $sql3 = "INSERT into karta
                    (red, brojSjedista, prikazi_datumPrikazivanja, prikazi_termin, prikazi_odobreni_film_sifraFilma, prikazi_sala_idSale) values 
                    ({$i} , {$j}, '{$_POST['datumPrikazivanja']}', '{$_POST['termin']}', {$sifraFilma}, {$_POST['sala']})";

                    mysqli_query ($con, $sql3);
                }
        }

    } 
}

// Ukoliko kriticar brise prikazivanje.
if (isset ($_GET['datumPrikazivanja']))
{
    $sql = "DELETE from prikazi WHERE datumPrikazivanja = '{$_GET['datumPrikazivanja']}' and termin = '{$_GET['termin']}' and odobreni_film_sifraFilma = {$sifraFilma} and sala_idSale = {$_GET['idSale']}";
    mysqli_query ($con, $sql);
}

// Prikazuje informacije o interakciji sa stranicom movie.php.
if ($toast <> "")
{
    ?>
        
    <div class = "toast" data-autohide = "false" style = "border: 1.5px solid #1de9b6; box-shadow: 0px 24px 24px -6px rgba(0,0,0,.5);">

        <div class = "toast-header" style = "background-color: #004d40;">
            <button type = "button" class = "close" data-dismiss = "toast"> <p class = "text-primary"> &times; </p> </button>
        </div>
        <div class = "toast-body text-dark" style = "background-color: #fff8e1;">
             Uspješno ste <?php print $toast; ?>. 
        </div>

    </div>  

    <?php
}

$sql = "SELECT avatar, naziv, godina, trailer, sadrzaj, glumci, zanr, ocjena, trajanje FROM film WHERE sifraFilma = {$sifraFilma}";

if ($rezultat = mysqli_query ($con, $sql))
{
    if (mysqli_num_rows ($rezultat) > 0) // Trebalo bi da je 1, ali neka toga za svaki slucaj.
    {
        $red = mysqli_fetch_array ($rezultat); // Informacije o filmu.
        
        ?>

        <title> <?php print $red[1].' ('.$red[2].')'; ?> </title> <!-- Naziv stranice. -->

        <br>
        <!-- Sve ce biti u tabeli zbog poravnanja. -->
        <div class = "table">
            <table class = "table table-borderless">
  
                <!-- Prikazujemo avatar filma i informacije o glumcima, sadrzaju, te trajanju filma. -->
                <div class = "row">

                    <div class = "col-md-4">
                        <img src = "images/<?php print $red[0] ?>" class = "float-left" alt = "Slika nije dostupna." style = "height: 400px; box-shadow: 0px 16px 14px -6px rgba(0,0,0,.5);">
                    </div>

                    <div class = "col-md-8 shadow-lg text-white">

                        <!-- Omogucava povratak na pocetnu stranu. -->
                        <a href = "home.php<?php if ($korisnickoIme <> "") print '?korisnickoIme='.$korisnickoIme; ?>" class = "btn text-warning float-right" role = "button" style ="background-color: #004d40; border:0.5px solid #1de9b6;"> Početna </a>

                        <p class = "text-left text-warning"> Glumci: </p> 
                        <?php print $red[5] ?>

                        <p class = "text-left text-warning"> Sadržaj: </p> 
                        <?php print $red[4] ?>

                        <p class = "text-left text-warning"> Trajanje: </p> 
                        <?php print $red[8].' min' ?>

                    </div>

                </div>

                <!-- Naziv filma. -->
                <div class = "row">

                    <div class = "col text-info">
                        <br>
                        <h2> <?php print $red[1].' ('.$red[2].')'; ?> </h2>
                    </div>

                </div>

                <!-- Trejler i prikazivanja filma. -->
                <div class = "row">

                    <div class = "col-md">
                        <br>
                        <iframe width = "640" height = "360" src = "<?php print $red[3]; ?>?mute=1" frameborder = "0" allow = "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen> </iframe>
                    </div>

                    <div class = "col-md">
                        <?php require ('display.php'); ?>
                    </div>
                    
                </div>

                <!-- Ocjena. -->
                <div class = "row">

                    <div class = "col">
                        <form action= "movie.php" method = "GET">
                        <!-- Nisam znala drugacije proslijediti sifru filma pa sam ovako. -->
                            <input type = "hidden" name = "sifraFilma" value = <?php print $sifraFilma; ?>>
                            <input type = "hidden" name = "korisnickoIme" value = "<?php if ($korisnickoIme <> "") print $korisnickoIme; ?>">
                            <div class = "form-group">
                                <!-- Range je ocjena koju korisnik da kada pritisne na dugme Ocijeni. -->
                                <!-- Prvo se pritisne na traku pa na dugme. -->
                                <input type = "range" class = "form-control-range" name = "range" min = "0" max = "10" step = "0.1" style = "width: 640px;" value = <?php print $red[7]; ?> data-toggle = "tooltip" title = "<?php if ($red[7] == 0) print 'Ocjena korisnika: N/A.'; else print "Ocjena korisnika: {$red[7]}."; ?>">
                            </div>
                            <button type = "submit" class = "btn text-white" style ="background-color: #004d40; border:0.5px solid #1de9b6;" data-toggle = "tooltip" title = "Prvo kliknite na traku iznad gdje želite, a onda pritisnite ovo dugme." > Ocijeni </button>
                        </form>   
                    </div>

                </div> 

                <br>

                <!-- Komentarisanje. -->
                <div class = "row">

                    <div class = "col">
                        <div id = "accordion">
                  
                            <!-- Prikaz svih komentara za dati film. -->
                            <div class = "card" style = "border: 0;">

                                <div class = "card-header" style = "background-color: #004d40; border:0.5px solid #1de9b6;">
                                    <a class = "card-link" data-toggle = "collapse" href = "#komentari">
                                        <p class = "text-white"> Komentari </p>
                                    </a>
                                </div> 

                                <div id = "komentari" class = "collapse" data-parent = "#accordion">
                                    <div class = "card-body" style = "background-color: #004d40;">
                                        <?php require ('comments.php'); ?>
                                    </div>
                                </div>
                            
                            </div>

                            <br>

                            <?php 
                            if ($korisnickoIme <> "")
                            {
                            ?>
                                <!-- Dodavanje komentara. -->
                                <div class = "card" style = "border: 0;">

                                     <div class = "card-header" style = "background-color: #004d40; border:0.5px solid #1de9b6;">
                                         <a class = "card-link" data-toggle = "collapse" href = "#dodajKomentar">
                                             <p class = "text-white"> Dodaj komentar </p>
                                         </a>
                                     </div> 

                                    <div id = "dodajKomentar" class = "collapse" data-parent = "#accordion">
                                         <div class = "card-body" style = "background-color: #004d40;">
                                             <?php require ('addComment.php'); ?>
                                        </div>
                                    </div>

                                 </div>
                            <?php
                            }
                            ?>
                      
                        </div>
                    </div>

                </div>
       
            </table>
        </div>

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

</div>

</body>
</html>


