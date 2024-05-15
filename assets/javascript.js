jQuery(document).ready(function ($) {
    $('body').on('click', '[data-action="login_button"]', function(e) {
        let email = $('#login_email').val();
        let password = $('#login_password').val();

        $.ajax({
            url: '/rijschool/ajax-calls.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'login_account',
                email: email,
                password: password
            },
            success: function(response) {
                if(response.success == true){
                    var newUrl = "index.php";
                    window.location.href = newUrl;
                }
                else{
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
    $('body').on('click', '[data-action="create_button"]', function(e) {
        let email = $('#create_email').val();
        let password = $('#create_password').val();

        let firstname = $('#create_firstname').val();
        let lastname = $('#create_lastname').val();
        let geboortedatum = $('#create_geboortedatum').val();
        let telefoon = $('#create_telefoon').val();
        let gender = $('#create_gender').val();

        let adres = $('#create_adres').val();
        let postcode = $('#create_postcode').val();
        let number = $('#create_number').val();

        $.ajax({
            url: '/rijschool/ajax-calls.php', // The URL to the server-side script that will handle the form submission
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'create_account',
                email: email,
                password: password,
                firstname: firstname,
                gender: gender,
                lastname: lastname,
                geboortedatum: geboortedatum,
                telefoon: telefoon,
                adres: adres,
                postcode: postcode,
                number: number,
            },
            success: function(response) {

                if(response.success == true){
                    var newUrl = "index.php";
                    window.location.href = newUrl;
                    // alert(response.message);
                }
                else{
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    $('body').on('click', '[data-action="settings_personal"]', function(e) {
        var myModal = $('#editModal')[0]; // Get the DOM element
        var modal = new bootstrap.Modal(myModal); // Create the Bootstrap Modal instance
        modal.show();
    });
});