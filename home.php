<?php
// Pocetna strana naseg sajta.
    require ('connect.php'); // Za povezivanje sa bazom.

    $natpis = 'Nudimo Vam...'; // Ono sto ce pisati na liniji iznad filmova.

    if (isset($_GET['zanr'])) // Kada odaberemo zanr, natpis se promijeni.
        $natpis = $_GET['zanr'];
    else if (isset($_GET['search'])) // Kada trazimo po naslovu filma, natpis se takodje promijeni.
        $natpis = "Rezultati pretrage za: {$_GET['search']}";

?> 
      
<html>
    <head>

        <?php require ('bootstrap.php'); ?>

        <title> Bioskop </title>

    </head>

    <body> 

        <!-- Treba nam za toast. -->
        <script>

        $(document).ready(function(){
        $('.toast').toast('show');
        });

        </script>

        <!-- Preko ove varijable vodimo racuna da li je korisnik ulogovan. -->
        <?php 

        $korisnickoIme = ""; 

        if (isset($_GET['korisnickoIme']))
            $korisnickoIme = $_GET['korisnickoIme'];
        
        if (isset($_POST['sifraKorisnika']) && !isset($_POST['ime'])) // Ne radi se o registraciji, vec prijavi.
        {
            $sql = "SELECT korisnickoIme FROM korisnik WHERE sifraKorisnika = '{$_POST['sifraKorisnika']}' AND 
                   (BINARY korisnickoIme = '{$_POST['pomocna']}' OR BINARY mail = '{$_POST['pomocna']}')";

            if ($rezultat = mysqli_query ($con, $sql))
                if (mysqli_num_rows ($rezultat) > 0) // Ako smo unijeli ispravne podatke.
                    $korisnickoIme = mysqli_fetch_array ($rezultat)[0];       
         }

         // Ukoliko se radi o registraciji, sigurno mora unijeti ime, a ime se ne unosi tokom prijave.
         if (isset($_POST['ime'])) 
         {
            $sql = "INSERT into korisnik (korisnickoIme, sifraKorisnika, mail, ime, prezime, datumRodjenja) values
                                          ('{$_POST['korisnickoIme']}', '{$_POST['sifraKorisnika']}', '{$_POST['mail']}', 
                                           '{$_POST['ime']}', '{$_POST['prezime']}', '{$_POST['datumRodjenja']}')";

            if (mysqli_query ($con, $sql))
                $korisnickoIme = $_POST['korisnickoIme'];     
        }

        // Modal za podesavanje naloga.
        require ('profileSettings.php');
   
        ?>

        <!-- Kontejner za sve na nasoj pocetnoj strani. vh = view height -->
         <div class = "container-fluid text-white" style = "background-color: #004d40; height: 100vh;">

            <!-- Gornja traka. -->
            <nav class = "navbar navbar-expand-sm fixed-top" style = "background-color: #fff8e1; border: 1.5px solid #1de9b6; box-shadow: 0px 16px 14px -6px rgba(0,0,0,.5); height: 75px; overflow: auto;">
            
                <a class = "navbar-brand text-warning" href = "#"> 
                    Bioskop
                    <?php if ($korisnickoIme <> "")
                            { 
                    ?> <!-- Kad smo prijavljeni, vidimo zmaja. -->
                            <i class = "fas fa-dragon float-right"> </i> 
                    <?php   } 
                    ?> 
                </a>

                <!-- Dugme za povratak na pocetnu stranu.
                     Za dodavanje linkova u navbar koristimo klasu ul. -->

                <ul class = "navbar-nav">
                    <li class = "nav-item">
                      <a class = "nav-link text-white" href = "home.php<?php if ($korisnickoIme <> "") print '?korisnickoIme='.$korisnickoIme; ?>" style = "background-color: #004d40; border:0.5px solid #1de9b6;"> Početna </a>
                    </li>
                
                    <!-- Dugme za prijavu, prikazano je samo ako vec nismo prijavljeni. -->
                    <?php if ($korisnickoIme == ""){ ?>

                        <li class = "nav-item">
                            <a class = "nav-link text-white" href = "signIn.php" style = "background-color: #004d40; border:0.5px solid #1de9b6;"> Prijava </a>
                        </li>

                    <?php } ?>

                    <!-- Dugme za odabir zanra.-->
    
                    <li class = "nav-item dropdown" style = "background-color: #004d40; border:0.5px solid #1de9b6;">
                        <a class = "nav-link dropdown-toggle text-white" href = "#" id = "navbardrop" data-toggle = "dropdown"> Žanr </a>
                             <div class = "dropdown-menu shadow-lg" style = "background-color: #004d40;  border:1px solid #1de9b6;">
                                <a class = "dropdown-item text-warning" href = "?zanr=Akcija<?php require ('username.php'); ?>"> Akcija </a>
                                <a class = "dropdown-item text-warning" href = "?zanr=Animacija<?php require ('username.php'); ?>"> Animacija </a>
                                <a class = "dropdown-item text-warning" href = "?zanr=Avantura<?php require ('username.php'); ?>"> Avantura </a>
                                <a class = "dropdown-item text-warning" href = "?zanr=Drama<?php require ('username.php'); ?>"> Drama </a>
                                <a class = "dropdown-item text-warning" href = "?zanr=Fantazija<?php require ('username.php'); ?>"> Fantazija </a>
                                <a class = "dropdown-item text-warning" href = "?zanr=Horor<?php require ('username.php'); ?>"> Horor </a>
                                <a class = "dropdown-item text-warning" href = "?zanr=Komedija<?php require ('username.php'); ?>"> Komedija </a>
                                <a class = "dropdown-item text-warning" href = "?zanr=Misterija<?php require ('username.php'); ?>"> Misterija </a>
                                <a class = "dropdown-item text-warning" href = "?zanr=Mjuzikl<?php require ('username.php'); ?>"> Mjuzikl </a>
                                <a class = "dropdown-item text-warning" href = "?zanr=Ratni<?php require ('username.php'); ?>"> Ratni </a>
                                <a class = "dropdown-item text-warning" href = "?zanr=Romansa<?php require ('username.php'); ?>"> Romansa </a>
                                <a class = "dropdown-item text-warning" href = "?zanr=Triler<?php require ('username.php'); ?>"> Triler </a>
                                <a class = "dropdown-item text-warning" href = "?zanr=Vestern<?php require ('username.php'); ?>"> Vestern </a>
                            </div>
                    </li>

                    <!-- Dugmad koju vide odredjeni prijavljeni korisnici. -->
                    <?php 
                    
                    if ($korisnickoIme <> "")
                    {
                        $temp = 0; // Pamtimo koji je tip korisnika. Neka 0 bude za obicnog korisnika.

                        // Pitamo se da li je taj korisnik administrator...
                        $sql1 = "SELECT * FROM administrator WHERE BINARY korisnik_korisnickoIme = '{$korisnickoIme}'";
                        // ili kriticar.
                        $sql2 = "SELECT * FROM kriticar WHERE BINARY korisnik_korisnickoIme = '{$korisnickoIme}'";

                        if ($rez = mysqli_query ($con, $sql1))
                            if (mysqli_num_rows ($rez) > 0)
                                $temp = 1; // Admin je ulogovan.

                        if ($rez = mysqli_query ($con, $sql2))
                            if (mysqli_num_rows ($rez) > 0)
                                 $temp = 2; // Kriticar je ulogovan.

                        // Dugme za pregled korisnika, samo u slucaju admina.
                        if ($temp == 1)
                        {
                            ?>
         
                            <li class = "nav-item">
                                <a class = "nav-link text-white" href = "showUsers.php?korisnickoIme=<?php print $korisnickoIme; ?>" style = "background-color: #004d40; border:0.5px solid #1de9b6;"> Korisnici </a>
                            </li>            
         
                             <?php
                        
                        }

                        // Dugme za pregled filmova, admin i kriticar.
                        if ($temp == 1 || $temp == 2)
                        {
                            ?> 
                            
                            <li class = "nav-item">
                                <a class = "nav-link text-white" href = "moviesSettings.php?korisnickoIme=<?php print $korisnickoIme; ?>" style = "background-color: #004d40; border:0.5px solid #1de9b6;"> Filmovi </a> 
                            </li>
                            
                            <?php
                        }

                        // Dugme za odjavu.
                        ?>

                        <li class = "nav-item">
                            <a class = "nav-link text-white" href = "home.php" style = "background-color: #004d40; border:0.5px solid #1de9b6;"> Odjava </a>
                        </li>

                        <?php
                    }

                    ?>

                </ul>

                <!-- Link za podesavanje naloga. -->
                <?php 
                
                if ($korisnickoIme <> "") 
                    print '<a href = "#myModal" class = "nav-link text-warning" data-toggle = "modal"> <h2> <span class = "fas fa-child"></span> </h2> </a>';
                
                ?>

                <!-- Dio za pretrazivanje po naslovu filma. -->
                <form class = "form-inline" action = "home.php" method = "GET">
                    <input type = "hidden" name = "korisnickoIme" value = "<?php if ($korisnickoIme <> "") print $korisnickoIme; ?>">
                    <input class = "form-control mr-sm-2" type = "text" placeholder = "Upišite naziv filma..." name = "search">
                    <button class = "btn btn-sm btn-success" type = "submit"> Traži </button>
                </form>
                
            </nav>

            <br><br>
    
             <!-- Kontejner u kojem ce biti smjesteni filmovi. ml = margin left. mr = margin right. -->
            <div class = "container-sm pt-5 pl-5 pr-5 text-dark" style = "background-color: #fff8e1; height: 85%; border: 3px solid #1de9b6; box-shadow: 0px 24px 24px -6px rgba(0,0,0,.5); overflow: auto">
        
                <!-- Upozorenje prilikom podesavanja naloga. -->
                <?php if (isset ($greska)) { ?> 
    
                    <div class = "toast" data-autohide = "false" style = "border: 1.5px solid #1de9b6; box-shadow: 0px 24px 24px -6px rgba(0,0,0,.5);">

                        <div class = "toast-header" style = "background-color: #004d40;">
                            <strong class = "mr-auto text-white"> <h5> Upozorenje </h5> </strong>
                            <button type = "button float-right" class = "close" data-dismiss = "toast"> <p class = "text-primary"> &times; </p> </button>    
                        </div>
        
                        <div class = "toast-body text-dark" style = "background-color: #fff8e1;">
                            Korisničko ime koje ste izabrali je zauzeto! Pokušajte sa drugim korisničkim imenom.
                        </div>

                    </div>
       
                <?php } ?>

                <!-- Gornja traka. -->
                <div class = "row mt-3 text-white">
                     <div class = "col" style = "background-color: #004d40;"> <?php print $natpis ?> </div>
                </div>

                <br>

                <?php
                    // Za prikaz filmova u ovom bez kontejneru.
                    require ('showMovies.php');
                 ?>   
                
            </div>

        </div> <!-- Zatvaramo zeleni kontejner. -->

    </body>
</html>