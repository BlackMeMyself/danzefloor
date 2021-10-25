<html>

<head>
    <style>
        *{
            background-color: black;
            color: chartreuse;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 1.2em;
            font-weight: bold;
        }
        img {
            margin: 0 auto ;
            display: block;
        }

        a {
            color: #FFD700 !important;
            text-decoration: none;
            font-weight: bolder;
        }
    </style>
</head>

<body>
    <img src="https://danzefloor.com/public/img/mail.png" alt="" srcset="">
    <p class="mainemail">Madrid, <?php echo date("d/m/Y") ?> </p>
    <p>Dear <?php echo $user ?>:</p>
    <p>We have received a request to reset your password. Click this <a href="<?php echo $url ?>">link</a> to reset it.</p>
    <p>If it wasn't you,ignore this email</p>
</body>

</html>