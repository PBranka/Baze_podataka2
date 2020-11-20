<!-- Dodavanje prikazivanja filma. -->

<style>

input[type = date], input[type = time], input[type = number]
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

<div class = "modal fade" id = "myModal">
    <div class = "modal-dialog">
        <div class = "modal-content">

            <div class = "modal-header text-white" style = "background-color: #004d40; border: 3px solid #1de9b6;">
                <h4 class = "modal-title"> Dodavanje prikazivanja </h4>
                <button type = "button" class = "close" data-dismiss = "modal"><p class = "text-info"> &times; </p></button>
            </div>
                  
            <div class = "modal-body text-warning" style = "background-color: #004d40; border: 3px solid #1de9b6;">
                <form action = "movie.php?sifraFilma=<?php print $sifraFilma; require ('username.php'); ?>" method = "POST"> 

                    <label for = "datum"> Datum </label>
                    <input type = "date" placeholder = "Unesite datum..." name = "datumPrikazivanja" id = "datumPrikazivanja" required>

                    <label for = "termin"> Termin </label>
                    <input type = "time" placeholder = "Unesite vrijeme..." name = "termin" id = "termin" required>

                    <label for = "sala"> Sala </label> 
                    <input type = "number" placeholder = "Odaberite salu..." name = "sala" id = "sala" required> 
                
                    <button type = "submit" class = "btn text-white" style ="background-color: #004d40; border:0.5px solid #1de9b6;"> Dodaj </button>

                </form>
            </div>
                  
        </div>
    </div>
</div>
