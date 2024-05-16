<style>
    .background-information {
    background-image: url("assets/images/rijschool_home1.svg");
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
    }
    .container-height{
    height:400px;
    }
    .container-items-left {
    display: flex;
    flex-direction: column; /* Changed from row to column */
        justify-content: center;
        align-items: start;
    }
    /*.container-items-right {*/
    /*    display: flex;*/
    /*    flex-direction: column; !* Changed from row to column *!*/
    /*    justify-content: center;*/
    /*    align-items: end;*/
    /*}*/


</style>

<div id="container-visie" class="container-fluid mt-5 mb-5 text-dark">
    <div class="row container-height">
        <div class="col-6 container-items-left" style="padding-right: 75px;">
            <h1>Visie</h1>
            <p>
                Welkom bij Vierkante wielen Rijschool, waar we jongeren met een fysieke beperking helpen om veilig en zelfverzekerd achter het stuur te stappen. Onze gespecialiseerde instructeurs bieden een inclusieve leeromgeving, waarbij de individuele behoeften van elke leerling centraal staan. Met onze vloot van twee elektrische auto's en drie aangepaste voertuigen streven we ernaar mobiliteit toegankelijk te maken voor iedereen.
                <br><br>
                Bij Vierkante wielen geloven we in het empoweren van onze leerlingen. We bieden een duurzame en op maat gemaakte rijervaring, zodat jongeren de vrijheid van autorijden kunnen ervaren, ongeacht hun fysieke uitdagingen.
            </p>
        </div>
        <div class="col-6 rounded background-information" >
        </div>
    </div>
</div>

<div id="container-teams" class="container px-4 py-5" id="featured-3">
    <h2 class="pb-2 border-bottom">Instructeurs</h2>
    <div class="row g-4 py-5 row-cols-1 row-cols-lg-4">
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
        <div class="col-lg-6 container-items-left" style="padding-right: 75px;">
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

<div class="container">
    <div class="row">
        <div class="col-md-4 d-flex align-items-center">
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


