<?php
include 'header.php';
require_once 'Repository/accountCrud.php';

$is_account_exist = false;
$is_password_false = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $connectionDatabase = new accountCRUD();
    $account = array(
        'email' => $_POST['email'],
        'password' => $_POST['password']
    );
    if ($connectionDatabase->login($account['email'], $account['password'])) {
        $is_account_exist = true;
    }else{
        $is_password_false = true;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="\css\all.css">
    <link rel="stylesheet" href="\css\login.css">
    <link rel="stylesheet" href="\css\header.css">
</head>
<body id='content'>

<div class='center'>
<?php if ($is_account_exist === false) : ?>
    <form class='gradient_box card' id='connect' style='height:55vh!important' method='post'>
        <div class="form-group" id='form_header'>
            <h2 class='card-title'>
                Re-Bienvenue!
            </h2>
        </div>
        <div class='form-group'>
            <h3 class='card-subtitle'>se connecter</h3>
        </div>
        <h4 style='color:red;'><?php if ($is_password_false) : ?>Erreur dans l'email ou le mot de passe<?php endif;?></h4>
        <div class="form-group">
            <label for="exampleInputEmail1">adresse Email</label>
            <input type="email" required name='email' class="form-control form_inputs" id="eInputEmail" aria-describedby="emailHelp" <?php if ($is_password_false) : ?> value='<?php echo $account['lastname'] ?>' <?php endif; ?> placeholder="Entrer votre email">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">mot de passe</label>
            <input type="password" required name='password' class="form-control form_inputs" id="exampleInputPassword1" placeholder="Entrer votre Mot de passe">
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
        <div class='form-group' id='create_account_link'>
            <a href="create_account.php">Nouveau? Créer un compte</a>
        </div>
        
    </form>
    <?php else : ?>
        <h2 style='color:white;'>Bienvenue <?php echo $connectionDatabase->getName($account['email'])?>!</h2>
        <?php endif; ?>
    <div id='hello_image'>
        <img src="/img/archmage.png" alt="archmage image">
    </div>
</div>

<footer>

</footer>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</html>
