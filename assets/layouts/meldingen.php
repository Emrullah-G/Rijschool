<style>
    #cookieMelding{
        position: fixed;
        bottom: 10px;
        width: 40%;
        border-radius: 14px;
        background-color: white;
        z-index: 20;
        /*transform: translateY(30px);*/
        border:2px solid gray;
    }
</style>

<div id='cookieMelding' >
    <div class="row gap-3" style="padding: 30px;">
        <div class="col-10">
            <div id="cookieMessage"></div>
        </div>

        <div class="col-12">
            <button data-action="denycookie_melding" class="btn btn-secondary">Sluiten</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        function setCookie(name, value, days) {
            let expires = "";
            if (days) {
                const date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }
        function getCookie(name) {
            const nameEQ = name + "=";
            const ca = document.cookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }

        if (getCookie('userRoleForCookie') == 1) {
            $('#cookieMessage').html('Dit is een bericht voor Instructuers');
        }
        else if (getCookie('userRoleForCookie') == 2) {
            $('#cookieMessage').html('Dit is bericht voor Rijschoolhouders');
        }
        else{
            $('#cookieMessage').html('Dit is een bericht voor Leerlingen');
        }


        $('body').on('click', '[data-action="denycookie_melding"]', function(e) {
            $('#cookieMelding').hide();
        });
    });
</script>