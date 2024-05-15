<?php
    use classes\authenticator;
?>




<div class="container-fluid p-0 mt-5">
<!--    <div class="row mt-5">-->
<!--        <div class="col-6"><h2>Afspraken</h2></div>-->
<!--        <div class="col-6 d-flex align-items-center justify-content-end"><a class="btn btn-success" href="resevering.php">Reserveren</a></div>-->
<!--    </div>-->

    <table class="table table-light align-items-center table-striped">
        <colgroup>
            <col width='120'>
            <col width='120'>
            <col width='120'>
            <col width='160'>
            <col width='160'>
            <col width='120'>
            <col width='30'>
        </colgroup>
        <thead>
        <tr>
            <th>Lesnummer</th>
            <th>Leerling</th>
            <th>Auto</th>
            <th>Tijd</th>
            <th>Ophaaladres</th>
            <th>Status</th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        <?php

        $authenticator = new authenticator();
        $appointments = $authenticator->collectAppointments( $_SESSION['user_id'], $_SESSION['user_role'] );

        if(!$appointments){
            echo "<tr><td colspan='7'>Er zijn geen actieve afspraken</td></tr>";
        }

        // Loop door de afspraken en toon ze in de tabel
        foreach ($appointments as $appointment) {

            if($appointment['status'] == 1){
                $appointment['status'] = 'Gecanceld';
            }
            else{
                $appointment['status'] = 'Actief';
            }

            echo "
                <tr>
                    <td>{$appointment['lesson']}</td>
                    <td>{$appointment['firstname']} {$appointment['lastname']} <button style='padding: 0px;margin-top:-5px;' type='button'><i class='text-danger fa-solid fa-circle-info'></i></button></td>
                    <td>{$appointment['license_plate']}</td>
                    <td>{$appointment['appointment_date']}</td>
                    <td>{$appointment['address']}, {$appointment['zipcode']}</td>
                    <td>{$appointment['status']}</td>
                    <td><button style='padding: 0px;' type='button'><i class='fa-regular fa-note-sticky'></i></button></td>
                </tr>";
        }
        ?>
        </tbody>
    </table>
</div>
