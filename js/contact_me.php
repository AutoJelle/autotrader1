/*
 Jquery Validation using jqBootstrapValidation
 example is taken from jqBootstrapValidation docs
 */
<script>
$(function () {

    $("#contactForm input,#contactForm textarea").jqBootstrapValidation({
        preventSubmit: true,
        submitError: function ($form, event, errors) {
            // something to have when submit produces an error ?
            // Not decided if I need it yet
        },
        submitSuccess: function ($form, event) {
            event.preventDefault(); // prevent default submit behaviour
            // get values from FORM
            var name = $("input#name").val();
            var phone = $("input#phone").val();
            var email = $("input#email").val();
            var message = $("textarea#message").val();
            var firstName = name; // For Success/Failure Message
            // Check for white space in name for Success/Fail message
            if (firstName.indexOf(' ') >= 0) {
                firstName = name.split(' ').slice(0, -1).join(' ');
            }
            $.ajax({
                url: "./bin/contact_me.php",
                type: "POST",
                data: {
                    name: name,
                    phone: phone,
                    email: email,
                    message: message
                },
                cache: false,
                success: function () {
                    // Success message
                    $('#success').html("<div class='alert alert-success'>");
                    $('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                        .append("</button>");
                    $('#success > .alert-success')
                        .append("<strong>Uw bericht is verzonden.</strong>");
                    $('#success > .alert-success')
                        .append('</div>');

                    //clear all fields
                    $('#contactForm').trigger("reset");
                },
                error: function () {
                    // Fail message
                    $('#success').html("<div class='alert alert-danger'>");
                    $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                        .append("</button>");
                    $('#success > .alert-danger').append("<strong>De E-mail server reageert niet.</strong> Probeer het nog eens en als dat niet werkt, neem contact op met de administrator via <a href='mailto:jellevandenbroek@gmail.com?Subject=Mailserver problemen rox.nl;'>jellevandenbroek@gmail.com</a> Dankuwel.");
                    $('#success > .alert-danger').append('</div>');
                    //clear all fields
                    $('#contactForm').trigger("reset");
                },
            })
        },
        filter: function () {
            return $(this).is(":visible");
        },
    });

    $("a[data-toggle=\"tab\"]").click(function (e) {
        e.preventDefault();
        $(this).tab("show");
    });
});


/*When clicking on Full hide fail/success boxes */
$('#name').focus(function () {
    $('#success').html('');
});
</script>