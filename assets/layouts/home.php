<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-k6RqeWeci5ZR/Lv4MR0sA0FfDOMIRX1Ip5a3D4skSwR4Y8KjPJm8t4+VxF4UgTwSWWY9Z2NwE5AvCgbZRT7S9Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .background-information {
            background-image: url("assets/images/rijschool_home1.svg");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }
        .container-height {
            height: 400px;
        }
        .container-items-left {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: start;
        }
    </style>
</head>
<body>

<div id="container-visie" class="container-fluid mt-5 mb-5 text-dark">
    <div class="row container-height">
        <div class="col-md-6 container-items-left pr-md-5">
            <h1>Visie</h1>
            <p>
                Welkom bij Vierkante wielen Rijschool, waar we jongeren met een fysieke beperking helpen om veilig en zelfverzekerd achter het stuur te stappen. Onze gespecialiseerde instructeurs bieden een inclusieve leeromgeving, waarbij de individuele behoeften van elke leerling centraal staan. Met onze vloot van twee elektrische auto's en drie aangepaste voertuigen streven we ernaar mobiliteit toegankelijk te maken voor iedereen.
                <br><br>
                Bij Vierkante wielen geloven we in het empoweren van onze leerlingen. We bieden een duurzame en op maat gemaakte rijervaring, zodat jongeren de vrijheid van autorijden kunnen ervaren, ongeacht hun fysieke uitdagingen.
            </p>
        </div>
        <div class="col-md-6 rounded background-information"></div>
    </div>
</div>

<div id="container-teams" class="container px-4 py-5" id="featured-3">
    <h2 class="pb-2 border-bottom">Instructeurs</h2>
    <div class="row g-4 py-5 row-cols-1 row-cols-md-2 row-cols-lg-4">
        <div class="feature col">
            <div class="feature-icon d-inline-flex align-items-center justify-content-center text-bg-primary p-2 rounded bg-gradient fs-2 mb-3">
                <i class="fa-regular fa-circle-check"></i>
            </div>
            <h3 class="fs-2 text-body-emphasis">Henk</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum arcu risus, rutrum sed arcu nec, egestas maximus ante.</p>
        </div>
        <div class="feature col">
            <div class="feature-icon d-inline-flex align-items-center justify-content-center text-bg-primary p-2 rounded bg-gradient fs-2 mb-3">
                <i class="fa-regular fa-circle-check"></i>
            </div>
            <h3 class="fs-2 text-body-emphasis">Jan</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum arcu risus, rutrum sed arcu nec, egestas maximus ante.</p>
        </div>
        <div class="feature col">
            <div class="feature-icon d-inline-flex align-items-center justify-content-center text-bg-primary bg-gradient p-2 rounded fs-2 mb-3">
                <i class="fa-regular fa-circle-check"></i>
            </div>
            <h3 class="fs-2 text-body-emphasis">Robert</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum arcu risus, rutrum sed arcu nec, egestas maximus ante.</p>
        </div>
        <div class="feature col">
            <div class="feature-icon d-inline-flex align-items-center justify-content-center text-bg-primary bg-gradient p-2 rounded fs-2 mb-3">
                <i class="fa-regular fa-circle-check"></i>
            </div>
            <h3 class="fs-2 text-body-emphasis">Mart</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum arcu risus, rutrum sed arcu nec, egestas maximus ante.</p>
        </div>
    </div>
</div>

<div id="container-behandelingen" class="container-fluid mb-5 text-dark">
    <div class="row container-height">
        <div class="col-lg-6 container-items-left pr-lg-5">
            <h1>Locatie</h1>
            <p>
                Onze rijschool biedt een unieke ervaring voor aspirant-chauffeurs van alle niveaus. Gelegen aan Schoolstraat 5, verwelkomen we studenten en bezoekers om te genieten van onze innovatieve benadering en ondersteunende leeromgeving.
                <br><br>
                Onze rijschool bevindt zich op een opvallende locatie aan [Adres]. Omgeven door moderne architectuur en gemakkelijk bereikbaar, biedt onze school een unieke ervaring op de weg.
                <br><br>
            </p>
        </div>
        <div class="col-lg-6 rounded background-behandelingen">
            <img src="assets/images/mapsrij.png" class="img-fluid" alt="Afbeelding">
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div id="aanmeldenNieuwsbrief">
                <h2>Meld je aan voor de nieuwsbrief</h2>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Vul je e-mailadres in" aria-label="E-mailadres" aria-describedby="button-aanmelden">
                    <button class="btn btn-primary" type="button" id="button-aanmelden">Aanmelden</button>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div id="contactFormulier">
                <h2>Contactformulier</h2>
                <form id="contactForm">
                    <div class="form-group">
                        <label for="naam">Naam:</label>
                        <input type="text" class="form-control" id="naam" required>
                    </div>
                    <div class="form-group">
                        <label for="email">E-mailadres:</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="onderwerp">Onderwerp:</label>
                        <input type="text" class="form-control" id="onderwerp" required>
                    </div>
                    <div class="form-group">
                        <label for="bericht">Bericht:</label>
                        <textarea class="form-control" id="bericht" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Verzenden</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Aanmelden voor nieuwsbrief
    document.getElementById("button-aanmelden").addEventListener("click", function() {
        var emailInput = document.querySelector("#aanmeldenNieuwsbrief input[type='email']");
        emailInput.value = ""; // Maak het e-mailadres invoerveld leeg
    });

    // Contactformulier
    document.getElementById("contactForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Voorkom standaardgedrag van het formulier (verzenden)
        var form = event.target; // Het verzonden formulier
        form.reset(); // Maak alle invoervelden van het formulier leeg
    });
</script>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4 d-flex align-items-center mb-4 mb-md-0">
            <div class="car text-center">
                <svg width="200" height="100">
                    <image href="assets/images/electric-car-svgrepo-com.svg" width="200" height="100" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="mb-0">Elektrisch</p>
            </div>
        </div>
        <div class="col-md-4 d-flex align-items-center mb-4 mb-md-0">
            <div class="car text-center">
                <svg width="200" height="100">
                    <image href="assets/images/electric-car-svgrepo-com.svg" width="200" height="100" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="mb-0">Elektrisch</p>
            </div>
        </div>
        <div class="col-md-4 d-flex align-items-center">
            <div class="car text-center">
                <svg width="200" height="100">
                    <image href="assets/images/car-svgrepo-com.svg" width="200" height="100" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="mb-0">Benzine</p>
            </div>
        </div>
    </div>
</div>

<footer class="footer mt-5">
    <div class="container">
        <hr> <!-- Streep boven de footer -->
        <div class="row">
            <div class="col-md-6">
                <ul class="list-unstyled">
                    <li><a href="#">Privacybeleid</a></li>
                </ul>
            </div>
            <div class="col-md-6">
                <ul class="list-unstyled">
                    <li><a href="#">Algemene voorwaarden</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
