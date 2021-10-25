<div class="backbtn" onclick="back()"><i class="fa fa-chevron-left" aria-hidden="true"></i> BACK</div>
<footer>
    <div class="containermenufooter">
        <div class="menufooter">
            <ul>
                <li><a href="javascript:loadPage('/about')">ABOUT US</a></li>
            </ul>
        </div>
    </div>
    <?php if(!isset($_COOKIE["acc"])){ ?>
    <div class="policy" id="policy">
        <h3>Tu configuración de cookies</h3>
        <p>Danzefloor te pedirá que aceptes cookies con fines de rendimiento, publicidad y redes sociales. Las cookies publicitarias y de redes sociales de terceros se utilizan para ofrecerte funciones de redes sociales y anuncios personalizados. Si deseas obtener más información o modificar tus preferencias, haz clic en el botón "Más información" o consulta la "Configuración de cookies" al final del sitio web. Para obtener más información sobre estas cookies y el tratamiento de los datos personales, consulta nuestra Política de privacidad y cookies. ¿Aceptas estas cookies y el tratamiento de los datos personales que implica?</p>
        <div>
            <button class="masButton" onclick="loadPage('/policy')">Más información</button>
            <button class="siButton" onclick="acceptcookies()">Sí, acepto</button>
        </div>
    </div>
    <?php } ?>
</footer>
<script src="/public/js/jquery-3.5.1.min.js"></script>
<script src="/public/js/jquery-ui.min.js"></script>
<script src="/public/js/moment.js"></script>
<script src="/public/js/player.js"></script>
<script src="/public/js/main.js"></script>
<script src="/public/js/repoption.js"></script>
<script>
    $(document).ready(function() {
        getTags();
    });
    function acceptcookies(){
        $.get("/acceptcookies",function(res){
           $("#policy").addClass("displaynone"); 
        })
    }
</script>
</body>

</html>