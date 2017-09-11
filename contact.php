<?php
require_once('Classes/BerichtClass.php');

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    $from = 'From: Website_Autotrader.nl';
    $to = 'autotrader@gmail.com';
    $subject = 'Nieuw bericht van ' . $_POST['email'];

    $body = "Naam: $name\nE-mail: $email\nTelefoon: $phone\n\nBericht:\n$message";

    if (mail($to, $subject, $body, $from)) {
        BerichtClass::insert_message_into_database($_POST);
        echo '<h3 style=\'text-align: center;\' >Uw bericht is verzonden!</h3>';
        echo '<meta http-equiv="refresh" content="5" />';
    } else {
        echo '<h3>Er is iets fout gegaan. Probeer het opnieuw.</h3>';
    }


} else {
    ?>

    <style>
        .requiredStar {
            color: red;
            font-size: 13px;
        }
    </style>

    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Contact
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Content Row -->
        <div class="row">
            <!-- Map Column -->
            <div class="col-md-8">
                <!-- Embedded Google Map -->
                <script src='https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyCk8gVFVZkm_SLkcAxBYPMZ5NU121mJ1Jo'></script>
                <div style='overflow:hidden;height:400px;width:100%;'>
                    <div id='gmap_canvas' style='height:400px;width:100%;'></div>
                    <style>#gmap_canvas img {
                            max-width: none !important;
                            background: none !important
                        }</style>
                </div>
                <a style="color: white;" href='http://maps-generator.com/nl'>Generator Google Map</a>
                <script type='text/javascript' src='https://embedmaps.com/google-maps-authorization/script.js?id=bcd61ff8d1957510ab3c167f2c4be6c8923eac95'></script>
                <script type='text/javascript'>
                    function init_map() {
                        var myOptions = {
                            zoom: 14, center: new google.maps.LatLng(52.0638148, 5.1000849),
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        };
                        map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);
                        marker = new google.maps.Marker({map: map, position: new google.maps.LatLng(52.0638148, 5.1000849)});
                        infowindow = new google.maps.InfoWindow({content: '<strong>Autotrader</strong><br>Columbuslaan 540<br>3526 EP Utrecht<br>'});
                        google.maps.event.addListener(marker, 'click', function () {
                            infowindow.open(map, marker);
                        });
                        infowindow.open(map, marker);
                    }
                    google.maps.event.addDomListener(window, 'load', init_map);</script>
            </div>
            <!-- Contact Details Column -->
            <div class="col-md-4">
                <h3>Contact Details</h3>
                <p>
                    Columbuslaan 540<br>
                    3526 EP Utrecht<br>
                </p>
                <p><i class="fa fa-mobile-phone"></i>&nbsp;
                    <abbr title="Mobile"><b>Mobiel:</b></abbr> 06 39 707 502</p>
                <p><i class="fa fa-envelope-o"></i>
                    <abbr title="Email"><b>Email:</b></abbr> <a href="mailto:name@example.com">autotrader@gmail.com</a></p>
                <!--            <p><i class="fa fa-clock-o"></i>-->
                <!--                <abbr title="Hours"><b>Uren:</b></abbr> Monday - Friday: 9:00 AM to 5:00 PM</p>-->
                <ul class="list-unstyled list-inline list-social-icons">
                    <li>
                        <a href="#"><i class="fa fa-facebook-square fa-2x"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-linkedin-square fa-2x"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-twitter-square fa-2x"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-google-plus-square fa-2x"></i></a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /.row -->

        <!--        <!-- Contact Form -->

        <!--        <div class="row">-->
        <!--            <div class="col-md-8">-->
        <!--                <hr>-->
        <!--                <h3>Stuur ons een bericht</h3>-->
        <!--                <form name="sentMessage" id="contactForm" method="post" novalidate>-->
        <!--                    <div class="control-group form-group">-->
        <!--                        <div class="controls">-->
        <!--                            <label>Volledige naam:</label>-->
        <!--                            <input type="text" class="form-control" id="name" required data-validation-required-message="Voer uw naam in.">-->
        <!--                            <p class="help-block"></p>-->
        <!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="control-group form-group">-->
<!--                        <div class="controls">-->
<!--                            <label>Telefoon nummer:</label>-->
<!--                            <input type="tel" class="form-control" id="phone" required data-validation-required-message="Voer uw telefoon nummer in.">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="control-group form-group">-->
<!--                        <div class="controls">-->
<!--                            <label>Email:</label>-->
<!--                            <input type="email" class="form-control" id="email" required data-validation-required-message="Voer uw email in.">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="control-group form-group">-->
<!--                        <div class="controls">-->
<!--                            <label>Bericht:</label>-->
<!--                            <textarea rows="10" cols="100" class="form-control" id="message" required data-validation-required-message="Voer uw bericht in." maxlength="999"-->
<!--                                      style="resize:none"></textarea>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div id="success"></div>-->

<!--                    <!-- For success/fail messages -->

<!--                    <button type="submit" name="submit" class="btn btn-primary">Verzenden</button>-->
<!--                </form>-->
<!--            </div>-->
<!---->
<!--        </div>-->

<!--        <!-- /.row -->
        <?php
        $emailAdress = "";
        if (isset($_SESSION['email'])){
            $emailAdress = $_SESSION['email'];
        }
        
        echo "
        <div class='row'>

            <div class='col-md-12 text-left'>
                <h3>Stuur ons een bericht</h3>
                <form role='form' action='index.php?content=contact' method='post'>
                    <div class='form-group'><label class='control-label' for='name'>Voer uw naam in</label><span class='requiredStar'>*</span>
                        <input class='form-control' id='name' placeholder='Naam' type='text' name='name' required></div>
                    <div class='form-group'><label class='control-label' for='phone'>Voer uw telefoonnummer in<br></label><span class='requiredStar'>*</span>
                        <input class='form-control' id='phone' placeholder='Telefoon' type='tel' name='phone' required></div>
                    <div class='form-group'><label class='control-label' for='email'>E-mail</label><span class='requiredStar'>*</span>
                        <input class='form-control' id='email' placeholder='E-mail' type='email' name='email' value='" . $emailAdress . "' required></div>
                    <div class='form-group'><label class='control-label' for='message'>Voer uw bericht in</label><span class='requiredStar'>*</span>
                    <textarea rows='10' cols='100' class='form-control' id='message' placeholder='Bericht' name='message' maxlength='200' style='resize:none' required></textarea>

                    <button type='submit' class='btn btn-primary' name='submit'>Verzenden</button>

                </form>
            </div>
        </div>
        ";
        ?>

        <hr>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.php"></script>
    <?php
}
    ?>