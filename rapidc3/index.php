<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>RapidC3 | Accueil</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <link rel="icon" href="images/thumbnail.png">
</head>

<body>
    <header>
        <div class="image">
            <a href="#" title="Retour à l'accueil">
                <img src="images/logo.PNG" alt="logo" class="logo">
            </a>
        </div>
        <div class="container">
            <nav>
                <ul>
                    <li><a href="modelcarte.php">Notre carte</a></li>
                    <li><a href="apropos">A propos de nous</a></li>
                </ul>
            </nav>
            <a class="commander" href="phpfiles/panier.php">Panier</a>
            <a class="commander" href="Form/index.php">Connexion</a>
        </div>
    </header>

    <div class="slideshow-container">
        <div class="mySlides fade">
            <div class="numbertext">1 / 3</div>
            <img src="images/back1.jpg" style="width:100%">
            <div class="textshow">RapidC3</div>
        </div>

        <div class="mySlides fade">
            <div class="numbertext">2 / 3</div>
            <img src="images/back2.jpg" style="width:100%">
            <div class="textshow">RapidC3</div>
        </div>

        <div class="mySlides fade">
            <div class="numbertext">3 / 3</div>
            <img src="images/back3.jpg" style="width:100%">
            <div class="textshow">RapidC3</div>
        </div>

        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>

    <div style="text-align:center">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
    </div>
    <script>
        let slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("dot");
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
        }
    </script>
<footer>
        <p>Pour votre santé mangez 5 kebabs et pizzas par jour. mangerbouger.fr</p>
        <ul>
            <li>Notre Facebook : <a href="https://www.facebook.com/">RapicC3Officiel</a></li>
            <li>Notre Twitter : <a href="https://twitter.com/">RapicC3Officiel</a></li>
            <li>Notre Instagram : <a href="https://www.instagram.com/">RapicC3Officiel</a></li>
        </ul>
        <p><br>Tout droits réservés Copyright 2022 CHERUEL BELLAN LEROUX PLISSONNIER LANGLOIS SEVAUX BRIZE</p>
</footer>
</body>

</html>