<?php
session_start();
include './dbh.class.php';
include './connexion.php';

if (!file_exists('./dbh.class.php')) {
    die("Erreur : le fichier de connexion à la base de données est introuvable.");
}

$errors = []; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = trim($_POST["nom"]);
    $username = trim($_POST["prenom"]); 
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    
    // Valider email, mot de passe, nom, et prénom
    if (empty($email)) {
        $errors['email'] = "Veuillez entrer votre adresse e-mail.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Veuillez entrer une adresse e-mail valide.";
    }
    if (empty($password)) {
        $errors['password'] = "Veuillez entrer votre mot de passe.";
    }
    if (empty($username)) {
        $errors['prenom'] = "Veuillez entrer votre prénom.";
    }
    if (empty($firstname)) {
        $errors['nom'] = "Veuillez entrer votre nom.";
    }

    if (empty($errors)) {
        $db = new Dbh();
        $conn = $db->connect();

        if (!$conn) {
            die("Erreur de connexion à la base de données : " . mysqli_connect_error());
        }

        // Vérifier si l'email existe déjà
        $stmt = $conn->prepare("SELECT id_user FROM user WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $errors['email'] = "Cette adresse e-mail est déjà utilisée.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO `user`(`nom`, `prenom`, `email`, `password`) VALUES (?, ?, ?, ?)");
            if (!$stmt->execute([$firstname, $username, $email, $hashedPassword])) {
                // Récupérer les informations d'erreur SQL
                $errorInfo = $stmt->errorInfo();
                echo "Erreur SQL : " . $errorInfo[2];
                $errors['registration'] = "Erreur SQL : " . $errorInfo[2];
            } else {
                // Inscription réussie
                $_SESSION['id_user'] = $conn->lastInsertId();
                $_SESSION['prenom'] = $username;
                header("Location: index.html");
                exit();
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

<div class="top">
    <h1>TaskCollab</h1>
    <div class="user">
        <img src="./assets/img/notification.webp" alt="Notifications">
        <a href=""><img src="./assets/img/user.webp" alt="User"></a>
    </div>
</div>

<section class="bg-primary py-3 py-md-5 py-xl-8">
  <div class="container">
    <div class="row gy-4 align-items-center">
      <div class="col-12 col-md-6 col-xl-7">
        <div class="d-flex justify-content-center text-bg-primary">
          <div class="col-12 col-xl-9">
            <hr class="border-primary-subtle mb-4">
            <h2 class="h1 mb-4">Organisez votre quotidien, simplifiez votre vie.</h2>
            <p class="lead mb-5">Notre to-do list intuitive vous aide à gérer vos tâches quotidiennes, des plus simples aux plus complexes, pour une meilleure productivité et un esprit plus clair.</p>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-6 col-xl-5">
        <div class="card border-0 rounded-4">
          <div class="card-body p-3 p-md-4 p-xl-5">
            <div class="row">
              <div class="col-12">
                <div class="mb-4">
                  <h2 class="h3">Inscription</h2>
                  <h3 class="fs-6 fw-normal text-secondary m-0">Entrez vos détails pour vous inscrire</h3>
                </div>
              </div>
            </div>

            <form action="#" method="POST">
              <div class="row gy-3">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom" required>
                  <label for="nom">Nom</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Prénom" required>
                  <label for="prenom">Prénom</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                  <label for="email">Email</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                  <label for="password">Mot de passe</label>
                </div>
                <div class="form-check mb-3">
                  <input class="form-check-input" type="checkbox" value="" name="iAgree" id="iAgree" required>
                  <label class="form-check-label text-secondary" for="iAgree">
                    J'accepte les <a href="#!" class="link-primary text-decoration-none">termes et conditions</a>
                  </label>
                </div>
                <div class="d-grid">
                  <button class="btn btn-primary btn-lg" type="submit">S'inscrire</button>
                </div>
                <?php if (!empty($errors)): ?>
                  <div class="alert alert-danger mt-3">
                    <ul>
                      <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                <?php endif; ?>
              </div>
            </form>

            <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end mt-4">
              <p class="m-0 text-secondary text-center">Vous avez déjà un compte? <a href="login.php" class="link-primary text-decoration-none">Se connecter</a></p>
            </div>
            <p class="mt-4 mb-4 mx-3">Ou continuer avec</p>
            <div class="d-flex gap-2 gap-sm-3 justify-content-center mx-3 my-3">
              <a href="#!" class="btn btn-outline-danger bsb-btn-circle bsb-btn-circle-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
                  <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"/>
                </svg>
              </a>
              <a href="#!" class="btn btn-outline-primary bsb-btn-circle bsb-btn-circle-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                  <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.02c-1.005 0-1[_{{{CITATION{{{_1{](https://github.com/arilas-rouaiguia/livre-or/tree/5cb494f3d1f937178c85b9afe1a3660a59546381/livre-or.php)[_{{{CITATION{{{_2{](https://github.com/celine-emptoz-lacote/site-perso/tree/404a14107c2acf991df36389d041d8aa658b29cc/projet%2Fcamping%2Finscription.php)[_{{{CITATION{{{_3{](https://github.com/Steven-Blombou/Projet-VOD/tree/4585dd1b6ce36167d064d16773b77dd90bda7c96/register.php)[_{{{CITATION{{{_4{](https://github.com/intanyuliana/TBPWEB-KelompokDua/tree/1a0bc364e73647807d93cdbf01547d1c100f0b21/login.php)[_{{{CITATION{{{_5{](https://github.com/cbralop/ejemplo_php_jquery/tree/ac217270903dc0b6cb95c063e92135c0a2e414f9/index.php)[_{{{CITATION{{{_6{](https://github.com/little-apps/little-software-stats/tree/360e145123e2874573f0c7100caeddd9bcdea188/install%2Fupdate.php)[_{{{CITATION{{{_7{](https://github.com/anshumanairy/React_Java/tree/1da771ac502df82debf555144694f22cdfd34665/src%2Fcomponents%2FDetails%2Ffooter.js)[_{{{CITATION{{{_8{](https://github.com/scott306lr/fcs_orient_2021/tree/89f9f2682bb47d1a73df1bd81c7610486aac9ea4/node_modules%2Fbootstrap-vue%2Fdist%2Fbootstrap-vue-icons.esm.js)[_{{{CITATION{{{_9{](https://github.com/smallwind1004/2021_summer_web_server/tree/7fda390254546ae4f2a30af1f0c11d1a6832929c/index2.php)[_{{{CITATION{{{_10{](https://github.com/AdolfoGu/Proyecto_IngSoft/tree/923bd4b3c61ce40de22c5e30dbcaa46a0f69c795/views%2Fusuario%2FLigaBBVA.php)[_{{{CITATION{{{_11{](https://github.com/Bagggas/Lentera/tree/89752d56d749cd513660809ae8601825d901d909/admin%2Fdata-peserta.php)
