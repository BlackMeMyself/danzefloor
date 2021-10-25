<?php echo view("templates/header"); ?>
<main id="container">
</main>
<?php echo view("templates/footer"); ?>
<?php if (isset($exists)) { ?>
    <?php if ($exists == 0) { ?>
        <script>
            $(document).ready(function() {
                loadPage("/expiratedtoken")
            });
        </script>
    <?php } ?>
    <?php if ($exists == 1) { ?>
        <script>
            $(document).ready(function() {
                loadPage("/resetpassword/<?php echo $token ?>")
            });
        </script>
    <?php } ?>
<?php } else { ?>
    <script>
        $(document).ready(function() {
            <?php if (isset($_SESSION['user'])) { ?>
                logged = true;
            <?php } else { ?>
                logged = false;
            <?php } ?>
            toggleNav(logged);
            loadPage("/home")
            try {
                $("#showUserName").html("<?php if (isset($_SESSION["user"])) echo $_SESSION["user"] ?>")
            } catch (error) {}
            track_list = [{
                name: '<?php if (isset($_COOKIE['name'])) echo htmlspecialchars( $_COOKIE['name']) ?>' || 'CHOOSE A TRACK',
                artist: '<?php if (isset($_COOKIE['artist'])) echo  htmlspecialchars($_COOKIE['artist']) ?>',
                image: '<?php if (isset($_COOKIE['image'])) echo  htmlspecialchars($_COOKIE['image']) ?>',
                path: './<?php if (isset($_COOKIE['path'])) echo  htmlspecialchars($_COOKIE['path']) ?>',
            }]
            if (track_list.artist != '') {
                loadTrack(track_index);
            }
        });
    </script>
<?php } ?>