<!DOCTYPE html>
<html lang="en">

<head>
    <script data-ad-client="ca-pub-8678758853912961" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <meta charset="UTF-8">
    <meta name="description" content="Discover electronic music artists,share sets,tracks,new events">
    <meta name="keywords" content="share,upload,download,coming up events,dancefloor,techno,drum and bass,D&B,electro,house,dubstep,UK garage,club,music,sets,tracks">
    <meta name="author" content="David López Pérez">
    <meta name="robots" content="follow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/public/jquery-ui.min.css">
    <!-- Load the custom CSS style file -->
    <link rel="stylesheet" type="text/css" href="/public/style.css">
    <link rel="stylesheet" href="/public/index.css">
    <title>DANZEFLOOR</title>
</head>

<body>
    <header>
        <div class="logged">
            <div class="social" id="idheader">
                <a href="https://www.facebook.com/Danzefloor"><i class="fa fa-facebook-square fa-2x" aria-hidden="true"></i></a>
                <!-- <a href="https://twitter.com/danzefloor"><i class="fa fa-twitter-square fa-2x" aria-hidden="true"></i></a> -->
                <a href="https://www.instagram.com/danzefloor"><i class="fa fa-instagram fa-2x" aria-hidden="true"></i></a>
                <a href="https://www.youtube.com/channel/UClMk6vphXCLz8p0bKEEIvzw"><i class="fa fa-youtube-square fa-2x" aria-hidden="true"></i></a>
            </div>
            <div class="livestream" style="visibility:hidden">
                <a href="">
                    <h2>LIVESTREAM<i class="fa fa-globe" aria-hidden="true"></i></h2>
                </a>
            </div>
            <?php if (isset($_SESSION["user"])) { ?>
                <div class="loggedcheck hidden" id="loggedcheck">
                    <i class="fa fa-user loggeduser" aria-hidden="false"></i><span class="userlogged" id="showUserName"><?php if (isset($_SESSION["user"])) echo $_SESSION["user"] ?></span>
                    <a href="javascript:logout('/logout/')"><i class="fa fa-sign-out signout" aria-hidden="true"></i></a>
                </div>
            <?php } ?>
        </div>

        <div class="tittle"><span class="halftittle">DANZEFLOOR</span></div>
        <div class="toggle" onclick="toggleMenu(this)">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
        </div>
        <div id="nav">
            <nav class="navlogged" id="navlogged">
                <ul>
                    <!-- <li><a href="javascript:loadPage('/home/')">HOME</a></li>-->
                    <li id="artistsl"><a id="lang-artists" href="javascript:loadPage('/artists/')">ARTISTS</a></li>
                    <li id="genres"><a id="lang-genres" onclick="toggleGenres()">GENRES</a></li>
                    <nav>
                        <ul class="estilosfooter" id="estilosfooter">
                            <li><a href="javascript:loadPage('/genres/electro')">ELECTRO</a></li>
                            <li><a href="javascript:loadPage('/genres/dubstep')">DUBSTEP</a></li>
                            <li><a href="javascript:loadPage('/genres/italodisco')">ITALO DISCO</a></li>
                        </ul>
                        <ul class="estilosfooter1" id="estilosfooter1">
                        <li><a href="javascript:loadPage('/genres/hiphop')">HIP HOP</a></li>
                            <li><a href="javascript:loadPage('/genres/house')">HOUSE</a></li>
                            <li><a href="javascript:loadPage('/genres/techno')">TECHNO</a></li>
                        </ul>
                    </nav>
                    <li id="signup" id="lang-signup"><a href="javascript:loadPage('/signup/')">SIGN UP</a></li>
                    <li id="loginl" id="lang-login"><a href="javascript:loadPage('/login/')">LOG IN</a></li>
                    <li id="shareset" id="lang-shareset"><a href="javascript:loadPage('/shareset/')">SHARE SET</a></li>
                    <li id="sharetrack" id="lang-sharetrack"><a href="javascript:loadPage('/sharetrack')">SHARE TRACK</a></li>
                    <li id="mysets" id="lang-mysets"><a href="javascript:loadPage('/mysets')">MY SETS</a></li>
                    <li id="mytracks" id="lang-mytracks"><a href="javascript:loadPage('/mytracks')">MY TRACKS</a></li>
                    <li id="profile" id="lang-profile"><a href="javascript:loadPage('/profile')">PROFILE</a></li>
                    <li id="search" id="lang-search"><input onkeypress="search(event)" id="isearch" class="search" type="text" placeholder="SEARCH">
                </ul>
            </nav>
        </div>
        <div class="player">
            <div class="rep1">
                <!-- Define the section for displaying details -->
                <div class="details">
                    <!-- <div class="now-playing">PLAYING x OF y</div> -->
                    <div class="track-art"></div>
                </div>

                <!-- Define the section for displaying track buttons -->
                <div class="buttons">
                    <div class="prev-track" onclick="prevTrack()">
                        <i class="fa fa-step-backward fa-2x"></i>
                    </div>
                    <div class="playpause-track" onclick="playpauseTrack()">
                        <i class="fa fa-play-circle fa-5x"></i>
                    </div>
                    <div class="next-track" onclick="nextTrack()">
                        <i class="fa fa-step-forward fa-2x"></i>
                    </div>
                </div>

                <!-- Define the section for displaying the seek slider-->
                <div class="slider_container">
                    <div class="current-time">00:00</div>
                    <input type="range" min="1" max="100" value="0" class="seek_slider" onchange="seekTo()">
                    <div class="total-duration">00:00</div>
                </div>

                <!-- Define the section for displaying the volume slider-->
                <div class="slider_container">
                    <i class="fa fa-volume-down"></i>
                    <input type="range" min="1" max="100" value="99" class="volume_slider" onchange="setVolume()">
                    <i class="fa fa-volume-up"></i>
                </div>
            </div>
            <div class="rep2">
                <div class="track-name">Track Name</div>
                <div class="track-artist">Track Artist</div>
            </div>
        </div>
    </header>
    <script>
        function toggleMenu(x) {
            x.classList.toggle("change");
            var navlogged = document.getElementById("nav");
            navlogged.classList.toggle("displayblock");
        }

        function toggleGenres() {
            var estilosfooter = document.getElementById("estilosfooter");
            var estilosfooter1 = document.getElementById("estilosfooter1");

            estilosfooter.classList.toggle("displayblock");
            estilosfooter1.classList.toggle("displayblock");
        }

        function search(ev) {
            if (ev.keyCode == 13) {
                var keyword = $("#isearch").val();
                loadPage("/search/" + keyword);
                $("#isearch").val("");
            }
        }
    </script>
    <div id="spinner" class="spinner displaynone">
        <i class="fa fa-spinner" aria-hidden="true"></i>
    </div>
    <div id="dialog" title="Alert" class="dialogmsg displaynone">
        <p id="dialogmsg"></p>
    </div>