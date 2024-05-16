<?php

$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$result = mysqli_query($connection, "SELECT * FROM user WHERE role = 1");
$data = mysqli_fetch_assoc($result);
?>

<div class="modal fade" id="student_information_strippenkaart" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Leerling overzicht</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <div><strong>Aantal les tegoed nog over</strong></div>
                            <input class="form-control" type="text" disabled id="student_information_credits" placeholder="Credits">
                            <input class="form-control" type="hidden" disabled id="student_information_id" placeholder="Credits">
                            <textarea rows="10" style="width: 100%;" class="form-control mt-2" id="textarea_settings" placeholder="Samenvatting"></textarea>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-action="close_modalstudent_information_textarea">Sluiten</button>
                    <button type="button" class="btn btn-danger" data-action="save_modalstudent_information_textarea">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="student_information_strippenkaart_pagina_overzicht" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Leerling overzicht</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col">
                        <div><strong>Aantal les tegoed nog over</strong></div>
                        <input class="form-control" type="number" id="student_information_credits_pagina_overzicht" placeholder="Credits">
                        <input class="form-control" type="hidden" id="student_information_credits_pagina_id" placeholder="Credits">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-action="close_modalstudent_information_strippenkaart">Sluiten</button>
                <button type="button" class="btn btn-primary" data-action="save_modalstudent_information_strippenkaart">Opslaan</button>
            </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="student_afspraak_maken" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Afspraak maken</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col">
<!--                        <input class="form-control" type="number" id="student_information_credits_pagina_overzicht" placeholder="Credits">-->
                        <input type="hidden" id="student_id">
                        <select class="form-control" data-action="student_id" id="select_users"></select>
                        <select class="form-control mt-2" data-action="student_date" id="select_date"><option>Kies je datum</option></select>
                        <select class="form-control mt-2" id="select_time"><option>Kies je gewenste tijd</option></select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-action="close_afspraak">Sluiten</button>
                <button type="button" class="btn btn-primary" data-action="save_afspraak">Opslaan</button>
            </div>
            </form>
        </div>
    </div>
</div>