<!-- Rezervacija karata. -->

<style>
     .container-fluid
        {
             background-image: url('images/Wallpaper.jpg');
             background-size: cover;
             background-repeat: no-repeat;
             background-color: #004d40; 
             white-space: nowrap;
             overflow: auto;
        }
</style>

<html>
<head>

    <title> Rezervacija </title>

    <?php
        
    require('connect.php');
    require('bootstrap.php');
    
    ?>

</head>
<body>

    <div class = "container-fluid text-white" style = "height: 100vh;">
     
        <br>

        <!-- Dugme za povratak na pocetnu stranu. -->
        <a href = "home.php<?php print '?korisnickoIme='.$_GET['korisnickoIme']; ?>" class = "btn shadow-lg bg-info active float-right"  role = "button" style = "border:0.5px solid #1c2331;">
            <b> Početna </b>
        </a>

        <?php require ('addCard.php'); ?> <!-- Kod za dodavanje karte u bazu. -->

        <br><br>

        <?php

        // Kriticar ce imati pregled korisnickih imena za sva rezervisana mjesta.
        $kriticar = 0;

        $sql = "SELECT * FROM kriticar WHERE BINARY korisnik_korisnickoIme = '{$_GET['korisnickoIme']}'";
                          
        if ($rez = mysqli_query ($con, $sql))
            if (mysqli_num_rows ($rez) > 0)
                $kriticar = 1; // Kriticar je ulogovan.

        // Za predstavljanje sale.
        $sql1 = "SELECT brojRedova, brojMjesta FROM sala WHERE idSale = {$_GET['idSale']}";

        if ($rez1 = mysqli_query ($con, $sql1)) // Upit je prosao.
        {
            $rez1 = mysqli_fetch_array ($rez1);

            $link = '?sifraFilma='.$_GET['sifraFilma'].'&korisnickoIme='.$_GET['korisnickoIme'].'&datumPrikazivanja='.$_GET['datumPrikazivanja'].'&termin='.$_GET['termin'].'&idSale='.$_GET['idSale']; // Trebace nam prilikom dodavanja.
            $brojRedova = $rez1[0];
            $brojMjesta = $rez1[1];

            // Da znamo koja su mjesta rezervisana i od strane koga.
            $sql2 = "SELECT karta_red, karta_brojSjedista, korisnik_korisnickoIme FROM rezervisi WHERE 
                    karta_prikazi_odobreni_film_sifraFilma = {$_GET['sifraFilma']} and karta_prikazi_sala_idSale = {$_GET['idSale']} and 
                    karta_prikazi_datumPrikazivanja = '{$_GET['datumPrikazivanja']}' and karta_prikazi_termin = '{$_GET['termin']}'";

            if ($rez2 = mysqli_query ($con, $sql2))
            {
                $brojRedova2 = mysqli_num_rows ($rez2);

                if ($brojRedova2 > 0) // Postoje zauzeta mjesta.
                {
                    $lista_red = array (); // Pamtimo redove u kojima je neko mjesto zauzeto.
                    $lista_mjesto = array (); // Pamtimo zauzeta mjesta u redovima.
                    $lista_korisnik = array (); // Pamtimo ko je zauzeo mjesto.
                    $brojac1 = 0; // Brojimo zauzeta mjesta kako bi znali koji je korisnik gdje.
                    $brojac2 = 0; // Kako se mjesta ne bi prikazivala vise puta.

                    while ($red = mysqli_fetch_array ($rez2))
                    {
                        $lista_red[] = $red[0];
                        $lista_mjesto[] = $red[1];
                        $lista_korisnik[] = $red[2];
                    }

                    // Pravimo mrezu sjedista i bojimo ih u zavisnosti od zauzetosti.
                    for ($i = 1; $i <= $brojRedova; $i++) // Ovako brojimo, jer redovi pocinju od 1.
                    {
                        for ($j = 1; $j <= $brojMjesta; $j++)
                        {
                            $brojac2 = 0;

                            for ($k = 0; $k < $brojRedova2; $k++) // Prolazi kroz listu zauzetih mjesta.
                                if ($i == $lista_red[$k] && $j == $lista_mjesto[$k])
                                {
                                    print '<button type = "button" class = "btn text-white disabled" style = "background-color: #1c2331;">'; 

                                    // Kriticar vidi sva korisnicka imena zauzetih mjesta, a drugi korisnici samo eventualno svoje. 
                                    // Isto vazi i za ikonicu za brisanje.
                                    if ($kriticar == 1 || strcmp ($_GET['korisnickoIme'], $lista_korisnik[$brojac1]) == 0)
                                    {
                                        print $j.' '.$lista_korisnik[$brojac1].' ';

                                        // Ime sluzi za pamcenje korisnickog imena onoga koga brisemo, a korisnickoIme je korisnicko ime onoga ko je ulogovan.
                                        print '<a href = "'.$link.'&ime='.$lista_korisnik[$brojac1].'&rezR='.$i.'&rezM='.$j.'&brisanje=1"> 
                                                    <span class = "fa fa-trash text-info"> </span>
                                               </a>';
                                    }
                                    else
                                        print $j;

                                    print '</button> ';

                                    $brojac1++; 
                                    $brojac2++;
                                }

                            if ($brojac2 == 0)
                            {
                                // Slobodna mjesta.
                                print '<a href = "'.$link.'&rezR='.$i.'&rezM='.$j.'" class = "btn text-white" style = "background-color: #558b2f;" role = "button">'.$j.'</a> ';
                            }
                        }

                        print $i;
                        print '<br><br>'; // Novi red.

                    }
                }
                else // Sva mjesta su slobodna.
                {
                    for ($i = 1; $i <= $brojRedova; $i++)
                    {
                        for ($j = 1; $j <= $brojMjesta; $j++)
                            print '<a href = "'.$link.'&rezR='.$i.'&rezM='.$j.'" class = "btn text-white" style = "background-color: #558b2f;" role = "button">'.$j.'</a> '; 
                            
                        print $i;
                        print '<br><br>'; // Novi red.
                    }
                      
                }      
            }

        }

        ?>

    </div>

</body>
</html>