<?php

if (isset($_SESSION['userrole'])) {
//    echo "idKlant is: " . $_SESSION['idKlant'];
    switch ($_SESSION['userrole']) {
        case "klant":
            echo "		
<nav class=\"navbar navbar-inverse\">
    <div class=\"header\">
        <div class=\"container-fluid\">
            <div class=\"navbar-header\">
                <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#myNavbar\"></button>
                <a class=\"navbar-brand\" href=\"index.php?content=autos\"><img src=\"images/logo.png\"></a>
            </div>
            <div class=\"collapse navbar-collapse\" id=\"myNavbar\">
                <ul class=\"menuClass nav navbar-nav\">
                    <!--                    <li class=\"active\"><a href=\"#\">Home</a></li>-->
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Auto\">Auto's</a></li>
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Klassieker\">Klassiekers</a></li>
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Motor\">Motoren</a></li>
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Bedrijfswagen\">Bedrijfswagens</a></li>
                    <li><a href=\"index.php?content=zoeken\">Zoeken</a></li>
                    <li id=\"menuDevider\"><img src=\"images/dividerIcon.png\"></li>                  
                    <li class=\"afterDeviderMenu\"><a href=\"index.php?content=klantHomepage\">Winkelmand</a></li>
                    <li class=\"afterDeviderMenu\"><a href=\"index.php?content=logout\">Logout</a></li>
            </ul>
                <ul class=\"nav navbar-nav navbar-right\">
                    <li><a href=\"index.php?content=contact\"><span><img src=\"images/phoneIcon.png\"></span> (0347) 350 777</a></li>
                    <li><a href=\"https://klantenvertellen.nl/referenties/auto_trader/\"><span><img src=\"images/thumbUpIcon.png\" style=\"margin-top: -4px;\"></span> Klantenbeoordeling 8,2</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
";
            break;
        case "anon":
            echo "		
<nav class=\"navbar navbar-inverse\">
    <div class=\"header\">
        <div class=\"container-fluid\">
            <div class=\"navbar-header\">
                <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#myNavbar\"></button>
                <a class=\"navbar-brand\" href=\"index.php?content=autos\"><img src=\"images/logo.png\"></a>
            </div>
            <div class=\"collapse navbar-collapse\" id=\"myNavbar\">
                <ul class=\"menuClass nav navbar-nav\">
                    <!--                    <li class=\"active\"><a href=\"#\">Home</a></li>-->
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Auto\">Auto's</a></li>
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Klassieker\">Klassiekers</a></li>
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Motor\">Motoren</a></li>
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Bedrijfswagen\">Bedrijfswagens</a></li>
                    <li><a href=\"index.php?content=zoeken\">Zoeken</a></li>
                    <li id=\"menuDevider\"><img src=\"images/dividerIcon.png\"></li>                  
                    <li class=\"afterDeviderMenu\"><a href=\"index.php?content=klantHomepage\">Winkelmand</a></li>
                    <li class=\"afterDeviderMenu\"><a href=\"index.php?content=inloggen_Registreren\">Inloggen/<br>Registreren</a></li>
            </ul>
                <ul class=\"nav navbar-nav navbar-right\">
                    <li><a href=\"index.php?content=contact\"><span><img src=\"images/phoneIcon.png\"></span> (0347) 350 777</a></li>
                    <li><a href=\"https://klantenvertellen.nl/referenties/auto_trader/\"><span><img src=\"images/thumbUpIcon.png\" style=\"margin-top: -4px;\"></span> Klantenbeoordeling 8,2</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
";
            break;
        case "verkoper":
            echo "		
<nav class=\"navbar navbar-inverse\">
    <div class=\"header\">
        <div class=\"container-fluid\">
            <div class=\"navbar-header\">
                <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#myNavbar\"></button>
                <a class=\"navbar-brand\" href=\"index.php?content=autos\"><img src=\"images/logo.png\"></a>
            </div>
            <div class=\"collapse navbar-collapse\" id=\"myNavbar\">
                <ul class=\"menuClass nav navbar-nav\">
                    <!--                    <li class=\"active\"><a href=\"#\">Home</a></li>-->
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Auto\">Auto's</a></li>
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Klassieker\">Klassiekers</a></li>
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Motor\">Motoren</a></li>
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Bedrijfswagen\">Bedrijfswagens</a></li>
                    <li><a href=\"index.php?content=zoeken\">Zoeken</a></li>
                    <li id=\"menuDevider\"><img src=\"images/dividerIcon.png\"></li>                  
                    <li class=\"afterDeviderMenu\"><a href=\"index.php?content=verkoperHomepage\">Home</a></li>
                    <li class=\"afterDeviderMenu\"><a href=\"index.php?content=voertuigToevoegen\">Verkopen<br></a></li>                    
                    <li class=\"afterDeviderMenu\"><a href=\"index.php?content=logout\">Logout</a></li>
                </ul>
                <ul class=\"nav navbar-nav navbar-right\">
                    <li><a href=\"index.php?content=contact\"><span><img src=\"images/phoneIcon.png\"></span> (0347) 350 777</a></li>
                    <li><a href=\"https://klantenvertellen.nl/referenties/auto_trader/\"><span><img src=\"images/thumbUpIcon.png\" style=\"margin-top: -4px;\"></span> Klantenbeoordeling 8,2</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
";
            break;
        case "admin":
            echo "		
<nav class=\"navbar navbar-inverse\">
    <div class=\"header\">
        <div class=\"container-fluid\">
            <div class=\"navbar-header\">
                <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#myNavbar\"></button>
                <a class=\"navbar-brand\" href=\"index.php?content=autos\"><img src=\"images/logo.png\"></a>
            </div>
            <div class=\"collapse navbar-collapse\" id=\"myNavbar\">
                <ul class=\"menuClass nav navbar-nav\">
                    <!--                    <li class=\"active\"><a href=\"#\">Home</a></li>-->
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Auto\">Auto's</a></li>
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Klassieker\">Klassiekers</a></li>
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Motor\">Motoren</a></li>
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Bedrijfswagen\">Bedrijfswagens</a></li>
                    <li><a href=\"index.php?content=zoeken\">Zoeken</a></li>
                    <li id=\"menuDevider\"><img src=\"images/dividerIcon.png\"></li>                  
                    <li class=\"afterDeviderMenu\"><a href=\"index.php?content=adminHomepage\">Home</a></li>
                    <li class=\"afterDeviderMenu\"><a href=\"index.php?content=logout\">Logout</a></li>
                </ul>
                <ul class=\"nav navbar-nav navbar-right\">
                    <li><a href=\"index.php?content=contact\"><span><img src=\"images/phoneIcon.png\"></span> (0347) 350 777</a></li>
                    <li><a href=\"https://klantenvertellen.nl/referenties/auto_trader/\"><span><img src=\"images/thumbUpIcon.png\" style=\"margin-top: -4px;\"></span> Klantenbeoordeling 8,2</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
";
            break;
        case "verkoopleidster":
            echo "		
<nav class=\"navbar navbar-inverse\">
    <div class=\"header\">
        <div class=\"container-fluid\">
            <div class=\"navbar-header\">
                <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#myNavbar\"></button>
                <a class=\"navbar-brand\" href=\"index.php?content=autos\"><img src=\"images/logo.png\"></a>
            </div>
            <div class=\"collapse navbar-collapse\" id=\"myNavbar\">
                <ul class=\"menuClass nav navbar-nav\">
                    <!--                    <li class=\"active\"><a href=\"#\">Home</a></li>-->
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Auto\">Auto's</a></li>
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Klassieker\">Klassiekers</a></li>
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Motor\">Motoren</a></li>
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Bedrijfswagen\">Bedrijfswagens</a></li>
                    <li><a href=\"index.php?content=zoeken\">Zoeken</a></li>
                    <li id=\"menuDevider\"><img src=\"images/dividerIcon.png\"></li>                  
                    <li class=\"afterDeviderMenu\"><a href=\"index.php?content=verkoopleidsterHomepage\">Home</a></li>
                    <li class=\"afterDeviderMenu\"><a href=\"index.php?content=logout\">Logout</a></li>
                </ul>
                <ul class=\"nav navbar-nav navbar-right\">
                    <li><a href=\"index.php?content=contact\"><span><img src=\"images/phoneIcon.png\"></span> (0347) 350 777</a></li>
                    <li><a href=\"https://klantenvertellen.nl/referenties/auto_trader/\"><span><img src=\"images/thumbUpIcon.png\" style=\"margin-top: -4px;\"></span> Klantenbeoordeling 8,2</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
";
            break;
        case "geblokkeerd":
            echo "		
<nav class=\"navbar navbar-inverse\">
    <div class=\"header\">
        <div class=\"container-fluid\">
            <div class=\"navbar-header\">
                <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#myNavbar\"></button>
                <a class=\"navbar-brand\" href=\"index.php?content=autos\"><img src=\"images/logo.png\"></a>
            </div>
            <div class=\"collapse navbar-collapse\" id=\"myNavbar\">
                <ul class=\"menuClass nav navbar-nav\">
                    <!--                    <li class=\"active\"><a href=\"#\">Home</a></li>-->
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Auto\">Auto's</a></li>
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Klassieker\">Klassiekers</a></li>
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Motor\">Motoren</a></li>
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Bedrijfswagen\">Bedrijfswagens</a></li>
                    <li><a href=\"index.php?content=zoeken\">Zoeken</a></li>
                    <li id=\"menuDevider\"><img src=\"images/dividerIcon.png\"></li>                  
                    <li class=\"afterDeviderMenu\"><a href=\"index.php?content=geblokkeerdHomepage\">Home</a></li>
                    <li class=\"afterDeviderMenu\"><a href=\"index.php?content=logout\">Logout</a></li>
                </ul>
                <ul class=\"nav navbar-nav navbar-right\">
                    <li><a href=\"index.php?content=contact\"><span><img src=\"images/phoneIcon.png\"></span> (0347) 350 777</a></li>
                    <li><a href=\"https://klantenvertellen.nl/referenties/auto_trader/\"><span><img src=\"images/thumbUpIcon.png\" style=\"margin-top: -4px;\"></span> Klantenbeoordeling 8,2</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
";
    }
} else {
    echo "		
<nav class=\"navbar navbar-inverse\">
    <div class=\"header\">
        <div class=\"container-fluid\">
            <div class=\"navbar-header\">
                <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#myNavbar\"></button>
                <a class=\"navbar-brand\" href=\"index.php?content=autos\"><img src=\"images/logo.png\"></a>
            </div>
            <div class=\"collapse navbar-collapse\" id=\"myNavbar\">
                <ul class=\"menuClass nav navbar-nav\">
                    <!--                    <li class=\"active\"><a href=\"#\">Home</a></li>-->
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Auto\">Auto's</a></li>
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Klassieker\">Klassiekers</a></li>
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Motor\">Motoren</a></li>
                    <li><a href=\"index.php?content=voertuigen&typeVanVoertuig=Bedrijfswagen\">Bedrijfswagens</a></li>
                    <li><a href=\"index.php?content=zoeken\">Zoeken</a></li>
                    <li id=\"menuDevider\"><img src=\"images/dividerIcon.png\"></li>
                    <li class=\"afterDeviderMenu\"><a href=\"index.php?content=inloggen_Registreren\">Inloggen / Registreren</a></li>
                </ul>
                <ul class=\"nav navbar-nav navbar-right\">
                    <li><a href=\"index.php?content=contact\"><span><img src=\"images/phoneIcon.png\"></span> (0347) 350 777</a></li>
                    <li><a href=\"https://klantenvertellen.nl/referenties/auto_trader/\"><span><img src=\"images/thumbUpIcon.png\" style=\"margin-top: -4px;\"></span> Klantenbeoordeling 8,2</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
";
}

?>


