<!-- Prikazuje podatake o korisniku, kao i mogucnost manipulacije nad tim podacima od strane admina. -->

<!DOCTYPE html>
<html>

    <head>

        <?php 
        
        require ('bootstrap.php'); 
        require ('connect.php');
        
        ?>

        <title> Pregled korisnika </title>

    </head>

    <body>

        <?php 

        if (isset ($_POST['obrisiKorisnika']))
            mysqli_query ($con, "DELETE FROM korisnik WHERE BINARY korisnickoIme = '{$_POST['obrisiKorisnika']}'");
        else
            if (isset ($_POST['postaviAdmina']))
                mysqli_query ($con, "INSERT INTO administrator (korisnik_korisnickoIme) VALUES ('{$_POST['postaviAdmina']}')");
            else
                if (isset ($_POST['ukloniAdmina']))
                    mysqli_query ($con, "DELETE FROM administrator WHERE BINARY korisnik_korisnickoIme = '{$_POST['ukloniAdmina']}'");
                else    
                    if (isset ($_POST['postaviKriticara']))
                        mysqli_query ($con, "INSERT INTO kriticar (korisnik_korisnickoIme) VALUES ('{$_POST['postaviKriticara']}')");
                    else
                        if (isset ($_POST['ukloniKriticara']))
                            mysqli_query ($con, "DELETE FROM kriticar WHERE BINARY korisnik_korisnickoIme = '{$_POST['ukloniKriticara']}'");
        ?>

        <!-- TABELA -->
        <div class = "container-fluid" style = "background-color: #004d40; height: 100vh; overflow: auto;">
    
            <br>

            <!-- Omogucava povratak na pocetnu stranu. -->
            <a href = "home.php?korisnickoIme=<?php print $_GET['korisnickoIme']; ?>" class = "btn text-warning float-left" role = "button" style ="background-color: #004d40; border:0.5px solid #1de9b6;"> Početna </a>

            
            <?php

            $upit1 = mysqli_query ($con, 'select * from korisnik');

            if ($upit1 && mysqli_num_rows ($upit1) > 0) // Da li je upit prosao i da li uopste ima podataka u tabeli?
            {

            ?>
                <br>
        
                <div class = "table-responsive">
                    <table class = "table-striped" style = "background-color: #fff8e1; border: 1.5px solid #1de9b6; box-shadow: 0px 16px 14px -6px rgba(0,0,0,.5);">

                        <thead class = "thead text-white" style = "background-color: #004d40;">
                            <tr>
                                <td> Korisničko ime </td>
                                <td> Šifra korisnika </td>
                                <td> E-mail </td>
                                <td> Ime </td>
                                <td> Prezime </td>
                                <td> Datum rođenja </td>
                                <td> Brisanje </td>
                                <td> Admin </td>
                                <td> Kritičar </td>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
            
                            // Bitan je redoslijed kolona u tabeli, moramo gledati kako je gore napisano (unutar th), tj. takav da nam bude redoslijed.
                            while ($vrsta = mysqli_fetch_array ($upit1))
                            {
                                print '<tr>';

                                for ($i = 0; $i < mysqli_num_fields ($upit1); $i++)
                                    print '<td>'.$vrsta[$i].'</td>';
                
                                // Da li je korisnik admin ili kriticar? 
                                $admin = 0; 
                                $kriticar = 0;
                            
                                if (mysqli_num_rows (mysqli_query ($con,"SELECT korisnik_korisnickoIme FROM administrator WHERE BINARY korisnik_korisnickoIme = '{$vrsta[0]}'")) > 0)
                                    $admin = 1;
                        
                                if (mysqli_num_rows (mysqli_query ($con,"SELECT korisnik_korisnickoIme FROM kriticar WHERE BINARY korisnik_korisnickoIme = '{$vrsta[0]}'")) > 0)
                                    $kriticar = 1;
                        
                                // BRISANJE (Ulogovani admin ne moze sam sebe izbrisati)
                                if ($vrsta[0] <> $_GET['korisnickoIme'])
                                {
                                    ?>

                                    <form action = "<?php print 'showUsers.php?korisnickoIme='.$_GET['korisnickoIme']; ?>" method = "POST">
                                        <td>
                                            <button class = "btn" name = "obrisiKorisnika" value = "<?php print $vrsta[0]; ?>" > <i class="fa fa-trash"></i> </button>
                                        </td>
                                    </form>

                                    <?php
                                }
                                else
                                    print '<td></td>';
                
                                // UPRAVLJANJE ADMINIMA
                                if ($admin == 1) // Ako je korisnik iz vrste admin, da se prikaze dugme za uklanjanje, osim ako je to ulogovani admin.
                                {
                                    ?>

                                    <form action = "<?php print 'showUsers.php?korisnickoIme='.$_GET['korisnickoIme']; ?>" method = "POST">
                                        <td>
                                            <button type = "submit" class = "btn btn-success" name = "ukloniAdmina" value = "<?php print $vrsta[0]; ?>" 
                                                                                                                             <?php if ($vrsta[0] == $_GET['korisnickoIme']) print 'disabled'; ?>> 
                                                Ukloni
                                            </button>
                                        </td>
                                    </form>

                                    <?php
                                }
                                else // Dugme za dodavanje administratora (ako korisnik nije kriticar, inace je blokirano).
                                {
                                    ?>

                                    <form action = "<?php print 'showUsers.php?korisnickoIme='.$_GET['korisnickoIme']; ?>" method = "POST">
                                        <td>
                                            <button type = "submit" class = "btn btn-warning" name = "postaviAdmina" value = "<?php print $vrsta[0]; ?>"
                                                                                                                              <?php if ($kriticar == 1) print 'disabled'; ?>>
                                                Postavi 
                                            </button>
                                        </td>
                                    </form>

                                    <?php
                                }
                
                                //UPRAVLJANJE KRITIČARIMA
                                if ($kriticar == 1) // Ako je korisnik iz vrste kriticar, da se prikaze dugme za uklanjanje.
                                {
                                    ?>

                                    <form action = "<?php print 'showUsers.php?korisnickoIme='.$_GET['korisnickoIme']; ?>" method = "POST">
                                        <td>
                                            <button type = "submit" class = "btn btn-success" name = "ukloniKriticara" value = "<?php print $vrsta[0]; ?>"> Ukloni </button>
                                        </td>
                                    </form>

                                    <?php
                                }
                                else // Dugme za dodavanje kriticara.
                                {
                                    ?>

                                    <form action = "<?php print 'showUsers.php?korisnickoIme='.$_GET['korisnickoIme']; ?>" method = "POST">
                                        <td>
                                            <button type = "submit" class = "btn btn-warning" name = "postaviKriticara" value = "<?php print $vrsta[0]; ?>"
                                                                                                                                 <?php if ($admin == 1) print 'disabled'; ?>>
                                                Postavi 
                                            </button>
                                        </td>
                                    </form>

                                    <?php
                                }
                
                                print '</tr>';
                            }
                    
                            ?>

                        </tbody>

                    </table>
                </div>

            <?php 
            
            }
            else 
            {
                ?>
        
                <h5 class = "display-5 text-white"> Žao nam je, trenutno nema rezultata. </h5>
        
                <?php
            }
            
            ?>

        </div>

    </body>

</html>