jQuery(document).ready(function ($) {

    let tableBody = $('#table_search');

    $('body').on('keyup', '[data-action="search_input"]', function(e) {
        let value = e.target.value;

        $.ajax({
            url: '/rijschool/ajax-calls.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'searchgebruikers',
                value: value
            },
            success: function(response) {
                tableBody.empty();

                if(response.success == true){
                    // console.log(response.data)

                    $.each(response.data, function(index, data) {
                        var row = '<tr>' +
                            '<td>' + data.firstname + ' ' + data.lastname + '<button data-action="useroverzicht_pakkettoevoegen" data-lessoncredit="' + data.lesson_credit + '" data-id="' + data.id + '"><i class="fa-solid fa-gear"></i></button></td>' +
                            '</tr>';
                        tableBody.append(row);
                    });


                }
                else{
                    row = '<tr>' +
                        '<td>Leerling bestaat niet</td>' +
                        '</tr>';
                    tableBody.append(row);
                }

            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

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

    $('body').on('click', '[data-action="leerling_overzicht"]', function(e) {
        let apprentice = $(this).data('test');
        let commentary = $(this).data('textarea');
        let lessoncredit = $(this).data('lessoncredit');

        console.log(commentary);

        $('#student_information_id').val(apprentice);
        $('#textarea_settings').val(commentary);
        $('#student_information_credits').val(lessoncredit);

        $('#student_information_strippenkaart').modal('show'); // Close the modal
    });

    $('body').on('click', '[data-action="open"]', function(e) {
        $('#student_information_strippenkaart').modal('hide'); // Close the modal
    });

    $('body').on('click', '[data-action="save_modalstudent_information_textarea"]', function(e) {

        let id = $('#student_information_id').val();
        let textarea = $('#textarea_settings').val();


        $.ajax({
            url: '/rijschool/ajax-calls.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'textarea_settings',
                textarea: textarea,
                id: id,
            },
            success: function(response) {
                if(response.success == true){
                    alert('Textarea is aangepast');
                    var newUrl = "index.php";
                    window.location.href = newUrl;
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });



    $('body').on('click', '[data-action="useroverzicht_pakkettoevoegen"]', function(e) {
        let lessoncredit = $(this).data('lessoncredit');
        let id = $(this).data('id');
        $('#student_information_credits_pagina_overzicht').val(lessoncredit);
        $('#student_information_credits_pagina_id').val(id);

        $('#student_information_strippenkaart_pagina_overzicht').modal('show'); // Close the modal
    });

    $('body').on('click', '[data-action="save_modalstudent_information_strippenkaart"]', function(e) {
        let lessoncredit = $('#student_information_credits_pagina_overzicht').val();
        let id = $('#student_information_credits_pagina_id').val();

        $.ajax({
            url: '/rijschool/ajax-calls.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'lessoncredit_aanpassen',
                lessoncredit: lessoncredit,
                id: id,
            },
            success: function(response) {
                if(response.success == true){
                    alert('Leerling strippenkaart is aangepast');
                    var newUrl = "lespakket.php";
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



    $('body').on('click', '[data-action="close_modalstudent_information_strippenkaart"]', function(e) {
        $('#student_information_strippenkaart').modal('hide'); // Close the modal
        $('#student_information_strippenkaart_pagina_overzicht').modal('hide'); // Close the modal
    });

    $('body').on('click', '[data-action="settings_personal"]', function(e) {
        var myModal = $('#editModal')[0]; // Get the DOM element
        var modal = new bootstrap.Modal(myModal); // Create the Bootstrap Modal instance
        modal.show();
    });

    $('body').on('click', '[data-action="tedt23"]', function(e) {
        let id = $(this).data('id');

        console.log(id);
        $('#testbero').val(id);

        $('#exampleModal').modal('show'); // Close the modal
        // console.log('test');
    });

    $('body').on('click', '[data-action="ziekmelden_today"]', function(e) {
        let id = $(this).data('id');
        $.ajax({
            url: '/rijschool/ajax-calls.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'leraarziekmelden',
                id: id,
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

    $('body').on('click', '[data-action="afspraakmaken_leerling"]', function(e) {
        let id = $(this).data('id');
        $('#student_id').val(id);

        $('#select_date').empty();
        $('#select_time').empty();

        $.ajax({
            url: '/rijschool/ajax-calls.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'collectadminusers',
            },
            success: function(response) {
                if(response.success == true){
                    $('#select_users').empty();
                    $('#select_users').append('<option selected disabled>Kies je instructeur</option>');

                    $.each(response.data, function(index, user) {
                        $('#select_users').append('<option value="' + user.id + '">' + user.firstname + ' ' + user.lastname + '</option>');
                    });
                }
                else{
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });

        $('#student_afspraak_maken').modal('show'); // Close the modal
    });





    $('body').on('change', '[data-action="student_id"]', function(e) {
        let valueSelected = $('#select_users').val();

        $.ajax({
            url: '/rijschool/ajax-calls.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'collectdatesselect',
                valueselected: valueSelected,
            },
            success: function(response) {
                if(response.success == true){
                    $('#select_date').empty();
                    $('#select_date').append('<option selected disabled>Kies je datum</option>');

                    $.each(response.data, function(index, user) {
                        $('#select_date').append('<option value="' + user.start + '">' + user.start + '</option>');
                    });
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


    $('body').on('change', '[data-action="student_date"]', function(e) {
        let valueSelected = $('#select_date').val();
        let selectedUser = $('#select_users').val();

        $.ajax({
            url: '/rijschool/ajax-calls.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'collecttimesselect',
                valueselected: valueSelected,
                selectedUser: selectedUser,
            },
            success: function(response) {
                    $('#select_time').empty();
                    $('#select_time').append('<option selected disabled>Kies je tijd</option>');

                    $.each(response.data, function(index, time) {
                        $('#select_time').append('<option value="' + time + '">' + time + '</option>');
                    });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });


    $('body').on('click', '[data-action="save_afspraak"]', function(e) {
        let date = $('#select_date').val();
        let instructor = $('#select_users').val();
        let select_time = $('#select_time').val();
        let student_id = $('#student_id').val();


        let einddatum = date + ' ' + select_time;

        if(!instructor || !select_time || !date){
            alert('Vul alle vleden');
            return;
        }

        $.ajax({
            url: '/rijschool/ajax-calls.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'createAfspraak',
                date: date,
                instructor: instructor,
                einddatum: einddatum,
                student_id: student_id,
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
});