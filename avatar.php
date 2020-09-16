<?php

// Prikazuje se avatar vezan za samo jedan film.
// Klikom na njega dobijamo vise informacija o filmu.

?>
   
<!-- Treba nam za tooltip. -->
<script>

$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});

</script>

<div class = "card" style = "width: 125px; background-color: #fff8e1; border: 0;" data-toggle = "tooltip" title = "Ocjena: <?php if ($ocjena == 0)
                                                                                                                                    print 'N/A';
                                                                                                                                else
                                                                                                                                    print $ocjena; 
                                                                                                                            ?>." data-placement = "right">
    <img class = "card-img-top" src = "images/<?php print $avatar ?>" alt = "Slika nije dostupna." style = "height: 200px; box-shadow: 0px 16px 14px -6px rgba(0,0,0,.5);">
    <div class = "card-body">
        <a href = "<?php print "movie.php?sifraFilma={$sifraFilma}";
                        require ('username.php');
                        ?> "
                  class = "card-title stretched-link">  <!-- Nema spajanja stringova u HTML-u. -->
           <small class = "card-text" style = "text-color: #004d40;"><?php print "{$naziv} ({$godina})"; ?>
           </small>
        </a>
    </div>
</div>


