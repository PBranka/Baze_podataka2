<!-- Pregled osnovnih informacija o filmovima iz baze. -->

<!DOCTYPE html>

<html>

    <head>

        <title> Pregled filmova </title>
    
    </head>

    <body>

        <?php

            require ('connect.php');
            require ('bootstrap.php'); 
            require ('addMovie.php');

            $admin = "disabled"; // Ako nije admin, dugmad za prikazivanje ce biti blokirana.

            // Samo admin moze odobravati filmove.
            if (mysqli_num_rows (mysqli_query ($con,"SELECT korisnik_korisnickoIme FROM administrator WHERE BINARY korisnik_korisnickoIme = '{$_GET['korisnickoIme']}'")) > 0)
                $admin = "";


            if (isset ($_POST['Odobri']))
                mysqli_query ($con, "INSERT INTO odobreni (film_sifraFilma, administrator_korisnik_korisnickoIme) VALUES ({$_POST['Odobri']}, '{$_GET['korisnickoIme']}')");
            else 
                if (isset ($_POST ['Prekini']))
                    mysqli_query ($con, "DELETE FROM odobreni WHERE film_sifraFilma = {$_POST['Prekini']}");
                else 
                    if (isset ($_POST['Obriši']))
                        mysqli_query ($con, "DELETE FROM film WHERE sifraFilma = {$_POST['Obriši']}");
        ?>

        <!-- TABELA -->
        <div class = "container-fluid" style = "background-color: #004d40; height: 100vh; overflow: auto;">
    
        <br>
    
        <a href = "home.php?korisnickoIme=<?php print $_GET['korisnickoIme']; ?>" class = "btn text-warning float-left" role = "button" style ="background-color: #004d40; border:0.5px solid #1de9b6;"> Početna </a>

        <!-- Samo kriticar dodaje filmove. -->
        <?php

        if ($admin == "disabled") 
        {
            ?>
            <a href = "#myModal" class = "btn text-warning float-left" data-toggle = "modal" style ="background-color: #004d40; border:0.5px solid #1de9b6;"> Dodaj film </a>
            <?php
        }

        $upit1 = mysqli_query ($con, 'select sifraFilma, naziv, godina, zanr, kriticar_korisnik_korisnickoIme from film');

        if ($upit1 && mysqli_num_rows ($upit1) > 0)
        {
            ?>

            <br>
        
            <div class = "table-responsive">
                <table class = "table-striped" style = "text-align:center; background-color: #fff8e1; border: 1.5px solid #1de9b6; box-shadow: 0px 16px 14px -6px rgba(0,0,0,.5);">
                    
                    <thead class = "thead text-white" style = "background-color: #004d40;">
                        <tr>
                            <th> Šifra filma </th>
                            <th> Naziv </th>
                            <th> Godina </th>
                            <th> Žanr</th>
                            <th> Kritičar </th>
                            <th> Prikazivanje </th>
                            <th> Brisanje </th>
                        </tr>
                    </thead>
                    
                    <tbody>
                    
                        <?php
            
                        while ($vrsta = mysqli_fetch_array ($upit1))
                        {
                            print '<tr>';

                            for($i = 0; $i < mysqli_num_fields ($upit1); $i++)
                                 print '<td>'.$vrsta[$i].'</td>';
                
                            //Filmovi za prikazivanje, samo admin time manipulise.
                           
                            if (mysqli_num_rows (mysqli_query ($con,"SELECT film_sifraFilma FROM odobreni WHERE film_sifraFilma = {$vrsta[0]}")) > 0) //AKO JE FILM VEĆ ODOBREN
                            { 
                                ?>
                                <form action = "<?php print 'moviesSettings.php?korisnickoIme='.$_GET['korisnickoIme']; ?>" method = "POST">
                                    <td>
                                        <button type = "submit" class = "btn btn-success" name = "Prekini" value = <?php print $vrsta[0].' '.$admin; ?>  > Prekini </button>
                                    </td>
                                </form>
                                <?php 
                            }
                            else //AKO FILM NIJE ODOBREN
                            {   
                                ?>
                                <form action = "<?php print 'moviesSettings.php?korisnickoIme='.$_GET['korisnickoIme'].' '; ?>" method = "POST">
                                    <td>
                                        <button type = "submit" class = "btn btn-warning" name = "Odobri" value = <?php print $vrsta[0].' '.$admin; ?>  > Odobri </button> 
                                    </td>
                                </form> 
                                <?php 
                            } 
                                 ?>

                            <!-- Za brisanje filma. -->
                            <form action = "<?php print 'moviesSettings.php?korisnickoIme='.$_GET['korisnickoIme'];?>" method = "POST">
                                <td>
                                    <button class = "btn" name = "Obriši" value = <?php print $vrsta[0].' '; ?>> <i class = "fa fa-trash"> </i> </button>
                                </td>
                            </form>

                            </tr>

                        <?php
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