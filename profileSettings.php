
<?php

// Korisnik pokusava da podesi nalog.
if (isset ($_POST['imeN']))
{
    $korisnicko = $korisnickoIme; // Pamtimo koje cemo ime unijeti u bazu.

    // Situacija kada korisnik unosi već postojeće korisničko ime u formu, a da to nije njegovo staro korisničko ime.
    if (mysqli_num_rows (mysqli_query ($con, "SELECT korisnickoIme FROM korisnik WHERE BINARY korisnickoIme = '{$_POST['korisnicko']}'")) > 0 && $korisnickoIme <> $_POST['korisnicko']) 
        $greska = 1; // Korisnicko ime jeste zauzeto.
    else 
        $korisnicko = $_POST['korisnicko'];

    if (mysqli_query ($con, "UPDATE korisnik SET korisnickoIme = '{$korisnicko}', sifraKorisnika = '{$_POST['lozinka']}', mail = '{$_POST['email']}', ime = '{$_POST['imeN']}', prezime = '{$_POST['prezime']}' WHERE BINARY korisnickoIme = '{$korisnickoIme}'"))
        $korisnickoIme = $korisnicko;
}

// Modal za podesavanje naloga.
if ( $korisnickoIme <> "" && $rez = mysqli_query ($con, "SELECT korisnickoIme, sifraKorisnika, mail, ime, prezime FROM korisnik WHERE BINARY korisnickoIme = '{$korisnickoIme}'")) 
{
    $red = mysqli_fetch_array ($rez);
    //STARE VRIJEDNOSTI IZ BAZE:
    $skorisnicko = $red[0];
    $ssifra = $red[1];
    $smail = $red[2];
    $sime =  $red[3];  
    $sprezime = $red[4];
?>

    <div class = "modal fade" id = "myModal">
        <div class = "modal-dialog">
            <div class = "modal-content">

                <div class = "modal-header text-white" style = "background-color: #004d40; border: 3px solid #1de9b6;">
                    <h4 class = "modal-title"> Podešavanje naloga </h4>
                    <button type = "button" class = "close" data-dismiss = "modal"> <p class = "text-success"> &times; </p></button>
                </div>
                 
                <div class = "modal-body text-warning" style = "background-color: #004d40; border: 3px solid #1de9b6;">
                    <form action = "home.php<?php print '?korisnickoIme='.$korisnickoIme; ?>" method = "POST">

                        <div class = "form-group">
                            <label class = "col-lg-4 control-label" > Ime: </label>
                            <div class="col-lg-10">
                                <input class = "form-control" name = "imeN" style = "background-color: #fff8e1;" type = "text" value = "<?php print $sime; ?>" >
                            </div>
                        </div>

                        <div class = "form-group">
                            <label class = "col-lg-4 control-label"> Prezime: </label>
                            <div class = "col-lg-10">
                                <input class = "form-control" name = "prezime" style = "background-color: #fff8e1;" type = "text" value = "<?php print $sprezime; ?>">
                            </div>
                        </div>

                        <div class = "form-group">
                            <label class = "col-lg-4 control-label"> E-mail: </label>
                            <div class = "col-lg-10">
                                <input class = "form-control" name = "email" style = "background-color: #fff8e1;" type = "text" value = "<?php print $smail; ?>">
                            </div>
                        </div>

                        <div class = "form-group">
                            <label class = "col-md-4 control-label"> Korisničko ime: </label>
                            <div class = "col-md-10">
                                <input class = "form-control" name = "korisnicko" style = "background-color: #fff8e1;" type = "text" value = "<?php print $skorisnicko; ?>">
                            </div>
                        </div>

                        <div class = "form-group">
                            <label class = "col-md-4 control-label"> Lozinka: </label>
                            <div class = "col-md-10">
                                <input class = "form-control" name = "lozinka" style = "background-color: #fff8e1;" type = "password" value = "<?php print $ssifra; ?>">
                            </div>
                        </div>

                        <div class = "col-md-8">
                            <button type = "submit" class = "btn text-white" name = "Sacuvaj" style = "background-color: #004d40; border:0.5px solid #1de9b6;"> Sačuvaj </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

<?php 

} 

?>