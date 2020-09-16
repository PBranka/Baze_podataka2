<!-- Prijavljeni korisnik moze da doda proizvoljan broj komentara. -->

<form action = "movie.php" method = "POST">
    <input type = "hidden" name = "korisnickoIme" value = "<?php print $korisnickoIme; ?>">
    <input type = "hidden" name = "sifraFilma" value = <?php print $sifraFilma; ?>> <!-- Samo za prosljedjivanje sifre filma. -->
    <div class = "form-group">
      <textarea class = "form-control" rows= "5" id = "comment" name = "tekstKomentara" style = "background-color: #fff8e1; box-shadow: 0px 24px 24px -6px rgba(0,0,0,.5);"> </textarea>
    </div>
    <button type = "submit" class = "btn text-white" style ="background-color: #004d40; border:0.5px solid #1de9b6;"> Dodaj </button>
</form>