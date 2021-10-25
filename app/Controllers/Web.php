<?php

namespace App\Controllers;

require 'app/Libraries/Exception.php';
require 'app/Libraries/PHPMailer.php';
require 'app/Libraries/SMTP.php';

use DateTime;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class Web extends BaseController
{
	public function about()
	{
		echo view("pages/about");
	}
	public function acceptcookies()
	{
		setcookie("acc", 1);
	}
	public function addEvent()
	{
		$eventsModel = model("Events");
		$info = [
			"id_user" => $_SESSION["id"],
			"place" => $_POST["place"],
			"time" => $_POST["time"]
		];
		$eventsModel->insert($info);
		$res = [
			"url" => "/profile",
			"msg" => "",
			"error" => 0
		];
		$res = json_encode($res);
		echo $res;
	}
	public function addfavorites()
	{
		$filesModel = model("Files");
		$info = $filesModel->find($_POST["id"]);
		$favoritesModel = model("Favorites");
		$path = "";
		if ($info["type"] == 0) {
			$path = "sets/" . $info["id_user"] . "/" . $info["name"];
		} else {
			$path = "tracks/" . $info["id_user"] . "/" . $info["name"];
		}
		$data = [
			"id_user" => $_SESSION["id"],
			"type" => $info["type"],
			"name" => $info["name"],
			"path" => $path,
			"id_artist" => $info["id_user"],
			"id_file" => $info["id"]
		];
		$favoritesModel->insert($data);
		$res = [
			"error" => $favoritesModel->errors(),
			"msg" => "ADDED TO FAVORITES"
		];
		$res = json_encode($res);
		echo $res;
	}
	public function artist($artist)
	{
		$userModel = model("User");
		$data["user"] = $userModel->select("id,user,avatar,bio,genres,city,country,debut")->where("user", $artist)->findAll();
		$filesModel = model("Files");
		$info = [
			"type" => 0,
			"id_user" => $data["user"][0]["id"]
		];
		$data["sets"] = $filesModel->where($info)->findAll();
		$info = [
			"type" => 1,
			"id_user" => $data["user"][0]["id"]
		];
		$data["tracks"] = $filesModel->where($info)->findAll();
		$data["artist"] = $artist;
		echo view("pages/results", $data);
	}
	public function artists()
	{
		$filesModel = Model("Files");
		$data["artists"] = $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->groupBy("id_user")->findAll();
		echo view("pages/artists", $data);
	}
	public function genres($genre)
	{
		$filesModel = Model("Files");
		$data = [];
		switch ($genre) {
			case "electro":
				$data["info"] = [
					"ELECTRO" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "electro")->groupBy(["genre", "id_user"])->findAll(),
					"IDM" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "idm")->groupBy(["genre", "id_user"])->findAll(),
					"NEW WAVE" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "newwave")->groupBy(["genre", "id_user"])->findAll(),
					"POST PUNK" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "postpunk")->groupBy(["genre", "id_user"])->findAll(),
					"ELECTRONIC" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "electronic")->groupBy(["genre", "id_user"])->findAll(),
				];
				$data["genrename"] = "ELECTRO";
				break;
			case "dubstep":
				$data["info"] = [
					"DUBSTEP" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "dubstep")->groupBy(["genre", "id_user"])->findAll(),
					"UK GARAGE" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "ukgarage")->groupBy(["genre", "id_user"])->findAll(),
					"BASS LINE" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "bassline")->groupBy(["genre", "id_user"])->findAll(),
					"JUNGLE" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "jungle")->groupBy(["genre", "id_user"])->findAll(),
					"DRUM AND BASS" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "drumandbass")->groupBy(["genre", "id_user"])->findAll(),
				];
				$data["genrename"] = "DUBSTEP";
				break;
			case "italodisco":
				$data["info"] = [
					"ITALO DISCO" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "italodisco")->groupBy(["genre", "id_user"])->findAll(),
					"DISCO" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "disco")->groupBy(["genre", "id_user"])->findAll(),
					"SPACE" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "space")->groupBy(["genre", "id_user"])->findAll(),
					"SYNTH POP" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "synthpop")->groupBy(["genre", "id_user"])->findAll(),
					"DRONE AMBIENT" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "droneambient")->groupBy(["genre", "id_user"])->findAll(),
				];
				$data["genrename"] = "ITALO DISCOP";
				break;
			case "hiphop":
				$data["info"] = [
					"HIP HOP" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "hiphop")->groupBy(["genre", "id_user"])->findAll(),
					"REGGAE" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "reggae")->groupBy(["genre", "id_user"])->findAll(),
					"TRIP HOP" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "triphop")->groupBy(["genre", "id_user"])->findAll(),
					"BROKEN BEAT" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "brokenbeat")->groupBy(["genre", "id_user"])->findAll(),
				];
				$data["genrename"] = "HIP HOP";
				break;
			case "house":
				$data["info"] = [
					"HOUSE" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "house")->groupBy(["genre", "id_user"])->findAll(),
					"CHICAGO" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "chicago")->groupBy(["genre", "id_user"])->findAll(),
					"TECH HOUSE" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "techhouse")->groupBy(["genre", "id_user"])->findAll(),
					"TRIBAL HOUSE" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "tribalhouse")->groupBy(["genre", "id_user"])->findAll(),
					"MICRO HOUSE" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "microhouse")->groupBy(["genre", "id_user"])->findAll(),
				];
				$data["genrename"] = "HOUSE";
				break;
			case "techno":
				$data["info"] = [
					"TECHNO" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "techno")->groupBy(["genre", "id_user"])->findAll(),
					"DUB TECHNO" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "dubtechno")->groupBy(["genre", "id_user"])->findAll(),
					"EBM" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "ebm")->groupBy(["genre", "id_user"])->findAll(),
					"MINIMAL" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "minimal")->groupBy(["genre", "id_user"])->findAll(),
					"DETROIT" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "detroit")->groupBy(["genre", "id_user"])->findAll(),
					"UK" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "uk")->groupBy(["genre", "id_user"])->findAll(),
					"INDUSTRIAL" => $filesModel->select('user, avatar')->join('user', 'user.id = files.id_user')->where("genre", "industrial")->groupBy(["genre", "id_user"])->findAll(),
				];
				$data["genrename"] = "TECHNO";
				break;
		}
		echo view("pages/genres",$data);
	}
	public function checktoken($token)
	{
		$userModel = model("User");
		$user = $userModel->where("recovery_token", $token)->findAll();
		if (count($user) > 0) {
			$fecha1 = new DateTime($user[0]["expiration_token"]); //fecha inicial
			$fecha2 = new DateTime(date("Y-m-d H:i:s")); //fecha de cierre
			$intervalo = $fecha1->diff($fecha2);
			$check = intval($intervalo->format('%r%h%i%s'));
			if ($check < 0) {
				$data["exists"] = 1;
				$data["token"] = $token;
				echo view("pages/main", $data);
			} else {
				$userModel->update($user[0]["id"], ["recovery_token" => "", "expiration_token" => "0000-00-00 00:00:00"]);
				$data["exists"] = 0;
				echo view("pages/main", $data);
			}
		} else {
			return redirect()->to("/");
		}
	}
	public function chooseAvatar()
	{
		$userModel = model("User");
		$path = "./public/img/artists/" . $_SESSION["id"] . "/" . $_FILES["avatar"]["name"];
		if (!is_file($path)) {
			if (!is_dir("./public/img/artists/" . $_SESSION["id"])) {
				mkdir("./public/img/artists/" . $_SESSION["id"], 0777);
			}
			$gestor = opendir("./public/img/artists/" . $_SESSION["id"]);
			while (($file = readdir($gestor)) !== false) {
				if (is_file("./public/img/artists/" . $_SESSION["id"] . "/" . $file)) {
					unlink("./public/img/artists/" . $_SESSION["id"] . "/" . $file);
				}
			}
			closedir($gestor);
			move_uploaded_file($_FILES["avatar"]["tmp_name"], $path);
			$data["avatar"] = $path;
			$userModel->update($_SESSION["id"], $data);
			$_SESSION["avatar"] = $path;
		} else {
			$res = [
				"msg" => "THE IMAGE ALREADY EXISTS",
				"error" => 1
			];
		}
		$res = [
			"path" => $path,
			"error" => 0
		];
		$res = json_encode($res);
		echo $res;
	}
	public function confirmsendemail()
	{
		echo view("pages/confirm");
	}
	public function delete($id)
	{
		$filesModel = model("Files");
		$favoritesModel = model("Favorites");
		$track = $filesModel->find($id);
		if (!count($track) > 0) {
			$res = [
				"msg" => "YOU MUST SELECT A TRACK",
				"url" => "",
				"error" => 1
			];
			$res = json_encode($res);
			echo $res;
		} else {
			if ($track["id_user"] != $_SESSION["id"]) {
				$res = [
					"msg" => "NOT AUTHORIZED",
					"url" => "",
					"error" => 1
				];
				$res = json_encode($res);
				echo $res;
			} else {
				$filesModel->delete($id);
				$favoritesModel->where("id_file", $id)->delete();
				$res = [
					"msg" => "",
					"url" => "/artist/" . $_SESSION["user"],
					"error" => 0
				];
				$res = json_encode($res);
				echo $res;
			}
		}
	}
	public function deleteEvent($id)
	{
		$eventsModel = model("Events");
		$eventsModel->delete($id);
	}
	public function deleteFavorites($id)
	{
		$favoritesModel = model("Favorites");
		$favoritesModel->delete($id);
	}
	public function expiratedtoken()
	{
		echo view("pages/expirated");
	}
	public function events($id, $user)
	{
		$eventsModel = model("Events");
		$data["events"] = $eventsModel->where("id_user", $id)->findAll();
		$data["user"] = $user;
		echo view("pages/events", $data);
	}
	public function getTags()
	{
		$filesModel = model("Files");
		$userModel = model("User");
		$files = $filesModel->findAll();
		$user = $userModel->select("user,avatar")->findAll();
		$res = [
			"files" => $files,
			"user" => $user
		];
		$res = json_encode($res);
		echo $res;
	}
	public function home()
	{
		echo view("pages/home");
	}
	public function login()
	{
		echo view("pages/login");
	}
	public function logout()
	{
		session_destroy();
		echo view("pages/home");
	}
	public function main()
	{
		$eventsModel = model('Events');
		$mifecha = date('Y-m-d H:i:s');
		$NuevaFecha = strtotime('-3 hour', strtotime($mifecha));
		$NuevaFecha = date('Y-m-d H:i:s', $NuevaFecha);
		$eventsModel->where('time <', $NuevaFecha)->delete();
		echo view("pages/main");
	}
	public function mysets()
	{
		$favoritesModel = model("Favorites");
		$data["sets"] = $favoritesModel->select('favorites.id,favorites.id_user,favorites.type,favorites.name,favorites.path,favorites.id_artist,favorites.id_file,user.user as username, image')->join('user', 'user.id = favorites.id_artist')->join('files', 'files.id = favorites.id_file')->where(["favorites.type" => 0, ' favorites.id_user' => $_SESSION['id']])->findAll();
		echo view("pages/mysets", $data);
	}
	public function mytracks()
	{
		$favoritesModel = model("Favorites");
		$data["tracks"] = $favoritesModel->select('favorites.id,favorites.id_user,favorites.type,favorites.name,favorites.path,favorites.id_artist,favorites.id_file,user.user as username, image')->join('user', 'user.id = favorites.id_artist')->join('files', 'files.id = favorites.id_file')->where(["favorites.type" => 1, ' favorites.id_user' => $_SESSION['id']])->findAll();
		echo view("pages/mytracks", $data);
	}
	public function newpassword()
	{
		$userModel = model("User");
		$user = $userModel->where("recovery_token", $_POST["token"])->findAll();
		$password = password_hash($_POST["password"], PASSWORD_BCRYPT, ["cost" => 10]);
		$info = ["password" => $password, "recovery_token" => "", "expiration_token" => "0000-00-00 00:00:00"];
		$userModel->update($user[0]["id"], $info);
		$res = [
			"url" => "/login",
			"msg" => "",
			"error" => 0
		];
		$res = json_encode($res);
		echo $res;
	}
	public function policy()
	{
		echo view("pages/policy");
	}
	public function profile()
	{
		$userModel = model("User");
		$eventsModel = model("Events");
		$data["user"] = $userModel->select("bio,genres,city,country,debut")->where("id", $_SESSION["id"])->findAll();
		$data["events"] = $eventsModel->where("id_user", $_SESSION["id"])->findAll();
		echo view("pages/profile", $data);
	}
	public function recovery()
	{
		echo view("pages/recovery");
	}
	public function registerUser()
	{
		$userModel = model("User");
		$password = password_hash($_POST["password"], PASSWORD_BCRYPT, ["cost" => 10]);
		$data = [
			"user" => $_POST["user"],
			"email" => $_POST["email"],
			"password" => $password
		];
		$userModel->insert($data);
		$res = [
			"url" => "/login",
			"msg" => $userModel->errors()
		];
		$res = json_encode($res);
		echo $res;
	}
	public function resetpassword($token)
	{
		$data['token'] = $token;
		echo view("pages/resetpassword", $data);
	}
	public function savebio()
	{
		$userModel = model("User");
		$info = [
			"bio" => $_POST["bio"],
			"genres" => $_POST["genres"],
			"city" => $_POST["city"],
			"country" => $_POST["country"],
			"debut" => $_POST["debut"]
		];
		$userModel->update($_SESSION["id"], $info);
		$res = [
			"url" => "/profile",
			"msg" => ""
		];
		$res = json_encode($res);
		echo $res;
	}
	public function saveprofile()
	{

		$res = [
			"url" => "/profile",
			"error" => 0
		];
		$userModel = model("User");
		if (isset($_POST["user"])) {
			if ($_POST["user"] != "") {
				$data["user"] = $_POST["user"];
				$userModel->update($_SESSION["id"], $data);
				$_SESSION["user"] =  $_POST["user"];
				$res = [
					"url" => "/profile",
					"error" => 0,
					"msg" => $_POST["user"]
				];
			}
		}
		if (isset($_POST["password"]) && isset($_POST["currentpassword"])) {
			if ($_POST["password"] != "" && $_POST["currentpassword"] != "") {
				$user = $userModel->where("email", $_SESSION["email"])->findAll();
				if (count(array($user)) > 0) {
					if (password_verify($_POST["currentpassword"], $user[0]["password"])) {
						$password = password_hash($_POST["password"], PASSWORD_BCRYPT, ["cost" => 10]);
						$userModel->update($_SESSION["id"], ["password" => $password]);
					} else {
						$res = [
							"msg" => "THE PASSWORD DOESN'T MATCH",
							"error" => 1
						];
					}
				}
			}
		}
		$res = json_encode($res);
		echo $res;
	}
	public function saveplayercookies()
	{
		Setcookie("name", $_POST["name"]);
		Setcookie("artist", $_POST["artist"]);
		Setcookie("image", $_POST["image"]);
		Setcookie("path", $_POST["path"]);
	}
	public function saveset()
	{
		$path = "sets/" . $_SESSION["id"] . "/" . basename($_FILES["music"]["name"]);
		if (!is_file($path)) {
			if (!is_dir("sets/" . $_SESSION['id'])) { //comprobamos que exista la carpeta
				mkdir("sets/" . $_SESSION['id'], 0755, true);
			}
			move_uploaded_file($_FILES["music"]["tmp_name"], $path); //movemos el archivo a la ruta path
			$filesModel = model("Files");
			$data = [
				"name" => basename($_FILES["music"]["name"]),
				"upload_date" => date("Y-m-d"),
				"id_user" => $_SESSION["id"],
				"length" => $_POST["duration"],
				"format" => $_POST["filetype"],
				"genre" => $_POST["genre"],
				"type" => 0
			];
			$filesModel->insert($data);
			$res = [                    //mensajes y rutas
				"url" => "/home",
				"msg" => "",
				"error" => 0
			];
			$res = json_encode($res);
			echo $res;
		} else {
			$res = [
				"url" => "",
				"msg" => "ALREADY UPLOADED",
				"error" => 1
			];
			$res = json_encode($res);
			echo $res;
		}
		echo "hola";
	}
	public function savetrack()
	{
		$path = "tracks/" . $_SESSION["id"] . "/" . basename($_FILES["music"]["name"]);
		if (!is_file($path)) {
			if (!is_dir("tracks/" . $_SESSION["id"])) {
				mkdir("tracks/" . $_SESSION["id"], 0755, true);
			}
			move_uploaded_file($_FILES["music"]["tmp_name"], $path);
			$filesModel = model("Files");
			$data = [
				"name" => basename($_FILES["music"]["name"]),
				"upload_date" => date("Y-m-d"),
				"id_user" => $_SESSION["id"],
				"length" => $_POST["duration"],
				"format" => $_POST["filetype"],
				"genre" => $_POST["genre"],
				"type" => 1
			];
			$filesModel->insert($data);
			$res = [                    //mensajes y rutas
				"url" => "/home",
				"msg" => "",
				"error" => 0
			];
			$res = json_encode($res);
			echo $res;
		} else {
			$res = [
				"url" => "",
				"msg" => "ALREADY UPLOADED",
				"error" => 1
			];
			$res = json_encode($res);
			echo $res;
		}
	}
	public function search($keyword)
	{
		$filesModel = model("Files");
		$userModel = model("User");
		$data["files"] = $filesModel->select('files.id, files.id_user,files.type,files.name,user.user as username, files.image')->join('user', 'user.id = files.id_user')->like("name", $keyword)->findAll();
		$data["users"] = $userModel->select("user,avatar")->like("user", $keyword)->findAll();
		$data["keyword"] = $keyword;
		echo view("pages/search", $data);
	}
	public function sendrecovery()
	{
		$userModel = model("User");
		$user = $userModel->where("email", $_POST["email"])->findAll();
		if (count($user) > 0) {
			$fecha1 = new DateTime($user[0]["expiration_token"]); //fecha inicial
			$fecha2 = new DateTime(date("Y-m-d H:i:s")); //fecha de cierre
			$seconds = abs($fecha1->getTimestamp() - $fecha2->getTimestamp() - 18000);
			if (intval($seconds) < 300) {
				$res = [
					"url" => "",
					"msg" => "KEEP CALM, YOU HAVE ALREADY SENT A RESET REQUEST",
					"error" => 1
				];
				$res = json_encode($res);
				echo $res;
			} else {
				$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
				$token =  substr(str_shuffle($permitted_chars), 0, 30);
				$fecha = date("Y-m-d H:i:s");
				$NuevaFecha = strtotime('+5 hour', strtotime($fecha));
				$NuevaFecha = date('Y-m-d H:i:s', $NuevaFecha);
				$info = [
					"recovery_token" => $token,
					"expiration_token" => $NuevaFecha
				];
				$userModel->where("email", $_POST["email"])->set($info)->update();
				$mail = new PHPMailer(true);
				try {
					//Server settings
					// $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
					$mail->isSMTP();
					$mail->SMTPOptions = array(
						'ssl' => array(
							'verify_peer' => false,
							'verify_peer_name' => false,
							'allow_self_signed' => true
						)
					);                                           //Send using SMTP
					$mail->Host       = '217.116.0.228';                     //Set the SMTP server to send through
					$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
					$mail->Username   = 'support@danzefloor.com';                     //SMTP username
					$mail->Password   = 'Karmencita1934@';                               //SMTP password
					$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
					$mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

					//Recipients
					$mail->setFrom('noreply@danzefloor.com', 'Support Danzefloor');
					$mail->addAddress($_POST["email"]);
					$mail->addReplyTo('noreply@danzefloor.com', 'No-Reply');

					//
					$data["user"] = $user[0]["user"];
					$data["url"] = "http://localhost:73/checktoken/" . $token;

					//Content
					$mail->isHTML(true);                                  //Set email format to HTML
					$mail->Subject = 'RECOVER PASSWORD';
					$mail->Body    = view('pages/mail', $data);
					$mail->AltBody = 'Click this url to set your new password. https://www.danzefloor.com/recovery/' . $token;

					if (!$mail->send()) {
						echo "ERROR PHPMAILER";
					}
				} catch (Exception $e) {
					$res = [
						"url" => "",
						"msg" => $e,
						"error" => 1
					];
					$res = json_encode($res);
					echo $res;
				}
				$res = [
					"url" => "/confirmsendemail",
					"msg" => "",
					"error" => 0
				];
				$res = json_encode($res);
				echo $res;
			}
		} else {
			$res = [
				"url" => "",
				"msg" => "THE EMAIL DOESN'T EXISTS",
				"error" => 1
			];
			$res = json_encode($res);
			echo $res;
		}
	}
	public function shareset()
	{
		echo view("pages/shareset");
	}
	public function sharetrack()
	{
		echo view("pages/sharetrack");
	}
	public function signup()
	{
		echo view("pages/signup");
	}
	public function track($id)
	{
		$filesModel = model("Files");
		$userModel = model("User");
		$data["track"] = $filesModel->find($id);
		$data["user"] = $userModel->select("user,avatar")->find($data["track"]["id_user"]);
		$data["id"] = $id;
		echo view("pages/track", $data);
	}
	public function updatefileimg()
	{
		$res = [
			"url" => "/artists",
			"error" => 0
		];
		$filesModel = model("Files");
		if ($_FILES["avatar"]["tmp_name"] != "") {
			$path = "./public/img/cover/" . $_SESSION["id"] . "/" . $_FILES["avatar"]["name"];
			if (!is_file($path)) {
				if (!is_dir("./public/img/cover/" . $_SESSION["id"])) {
					mkdir("./public/img/cover/" . $_SESSION["id"], 0777);
				}
				move_uploaded_file($_FILES["avatar"]["tmp_name"], $path);
				$data["image"] = $path;
				$filesModel->update($_POST["id"], $data);
			} else {
				$res = [
					"msg" => "THE IMAGE ALREADY EXISTS",
					"error" => 1
				];
			}
		}
		$res = json_encode($res);
		echo $res;
	}
	public function validateUser()
	{
		$res = array();
		$userModel = model("User");
		$user = $userModel->where("email", $_POST["email"])->findAll();
		if (count($user) > 0) {
			if (password_verify($_POST["password"], $user[0]["password"])) {
				$_SESSION["id"] = $user[0]["id"];
				$_SESSION["user"] = $user[0]["user"];
				$_SESSION["email"] = $user[0]["email"];
				$_SESSION["avatar"] = $user[0]["avatar"];
				$res = [
					"url" => "/home",
					"msg" => $user[0]["user"]
				];
			} else {
				$res = [
					"url" => "",
					"msg" => "INCORRECT EMAIL OR PASSWORD"
				];
			}
		} else {
			$res = [
				"url" => "",
				"msg" => "INCORRECT EMAIL OR PASSWORD"
			];
		}
		$res = json_encode($res);
		echo $res;
	}
}
