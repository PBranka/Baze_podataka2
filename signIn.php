<!-- Prijavljivanje i registrovanje. -->

<head>

<?php 
      
    require ('bootstrap.php');
    require ('connect.php'); 

?>
    <!-- Pozadina, poravnanje dugmadi, izgled polja za unos podataka. -->
    <style>
        .container-fluid
        {
             background-image: url('images/Wallpaper.jpg');
             background-size: cover;
             background-repeat: no-repeat;
             background-color: #004d40; 
             display: flex;
             flex-direction: column;
             flex-wrap: wrap;
             justify-content: center;
             align-content: center;
        }
        input[type = text], input[type = email], input[type = date], input[type = password] 
        {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: 0.5px solid #1c2331; 
            background-color: #e0f7fa;
        }
    </style>

    <title> Prijava </title>

</head>
<body>

    <div class = "container-fluid" style = "height: 100vh;">

        <!-- Dugme za prijavu. -->
        <button type = "button" class = "btn shadow-lg active" data-toggle = "modal" data-target = "#myModal2" style = "background-color: #b2ebf2; border:0.5px solid #1c2331;">
            Prijava
        </button>

        <br>

        <!-- Dugme za registraciju. -->
        <button type = "button" class = "btn shadow-lg active" data-toggle = "modal" data-target = "#myModal" style = "background-color: #b2ebf2; border:0.5px solid #1c2331;">
            Registracija
        </button>

        <!-- Prijava. -->
        <div class = "modal" id = "myModal2">
            <div class = "modal-dialog">
                <div class = "modal-content">

                    <div class="modal-header text-info" style = "background-color: #263238;">
                        <h4 class = "modal-title"> Prijava </h4>
                        <button type = "button" class = "close" data-dismiss = "modal"> <p class = "text-info"> &times; </p></button>
                    </div>
                 
                    <div class = "modal-body" style = "background-color: #b2ebf2;">
                         <form action = "home.php" method = "POST">

                            <label for = "username"> <b> Korisnicko ime/e-mail </b> </label>
                            <input type = "text" placeholder = "Unesite korisničko ime ili e-mail..." name = "pomocna" id = "pomocna" required>
                            <label for = "psw"> <b> Lozinka </b> </label>
                            <input type = "password" placeholder = "Unesite lozinku..." name = "sifraKorisnika" id = "sifraKorisnika" required>
                            <button type = "submit" class = "btn text-info shadow-lg" style = "background-color: #263238;"> Potvrdite </button>
                      
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- Registracija. -->
        <div class = "modal" id = "myModal">
            <div class = "modal-dialog">
                <div class = "modal-content">

                    <div class="modal-header text-info" style = "background-color: #263238;">
                        <h4 class = "modal-title"> Registracija </h4>
                        <button type = "button" class = "close" data-dismiss = "modal"> <p class = "text-info"> &times; </p></button>
                    </div>
                 
                    <div class = "modal-body" style = "background-color: #b2ebf2;">
                         <form action = "home.php" method = "POST">

                            <label for = "name"> <b> Ime </b> </label>
                            <input type = "text" placeholder = "Unesite ime..." name = "ime" id = "ime" required>

                            <label for = "surname"> <b> Prezime </b> </label>
                            <input type = "text" placeholder = "Unesite prezime..." name = "prezime" id = "prezime" required>

                            <label for = "username"> <b> Korisničko ime </b> </label>
                            <input type = "text" placeholder = "Unesite korisničko ime..." name = "korisnickoIme" id = "korisnickoIme" required>

                            <label for = "mail"> <b> E-mail </b> </label>
                            <input type = "email" placeholder = "Unesite e-mail..." name = "mail" id = "mail" required>

                            <label for = "date"> <b> Datum rođenja (neobavezno) </b> </label>
                            <input type = "date" placeholder = "Unesite datum rođenja..." name = "datumRodjenja" id = "datumRodjenja">

                            <label for = "psw"> <b> Lozinka </b> </label>
                            <input type = "password" placeholder = "Unesite lozinku..." name = "sifraKorisnika" id = "sifraKorisnika" required>

                            <button type = "submit" class = "btn text-info shadow-lg" style = "background-color: #263238;"> Potvrdite </button>
                      
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
  
</body>








