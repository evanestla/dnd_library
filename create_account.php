<?php
include 'header.php';
require_once 'Repository/accountCrud.php';

$is_account_created = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    if (isset($_POST['is_admin']))
    {
        $is_admin = 1;
    } else
    {
        $is_admin = 0;
    }
    $connectionDatabase = new accountCRUD();
    $account = array(
        'firstname' => $_POST['firstname'],
        'lastname' => $_POST['lastname'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'is_admin' => $is_admin
    );

    $mails = $connectionDatabase->getMail();
    $is_mail_in = false;
    if (in_array($account['email'], $mails))
    {
        $is_mail_in = true;
    } else {
        $connectionDatabase->saveData($account);
        $is_account_created = true;
    }


}

$is_admin = false

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
<?php if ($is_account_created === false) : ?>
    <form class='gradient_box card' id='connect' style='height:75vh!important' method='post'>
        <div class="form-group" id='form_header'>
            <h2 class='card-title'>
                Bienvenue!
            </h2>
        </div>
        <div class='form-group'>
            <h3 class='card-subtitle'>Créer un compte</h3>
        </div>
        <div id='inputs'>
            <div class="form-group">
                <label for="exampleInputEmail1">Nom</label>
                <input type="text" required class="form-control form_inputs" name= 'lastname' id="Inputname" aria-describedby="nameHelp" <?php if ($is_mail_in) : ?> value='<?php echo $account['lastname'] ?>' <?php endif; ?> placeholder="Entrer votre nom">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Prénom</label>
                <input type="text" required class="form-control form_inputs" name= 'firstname' id="Inputname" aria-describedby="nameHelp" <?php if ($is_mail_in) : ?> value='<?php echo $account['firstname'] ?>' <?php endif; ?> placeholder="Entrer votre nom">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">adresse Email </label>
                <?php if ($is_mail_in) : ?> <br><label for="exampleInputEmail1" style='color:red; font-size:1em;'>Cette Email est déjà utilisé...</label> <?php endif; ?>
                <input type="email" required class="form-control form_inputs" name='email' id="InputEmail" aria-describedby="emailHelp" placeholder="Entrer votre email">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">mot de passe</label>
                <input type="password" required class="form-control form_inputs" name='password' id="exampleInputPassword1" placeholder="Entrer votre Mot de passe">
            </div>

            <?php
                if ($is_admin)
                {
                    echo '            <div class="form-group">
                    <label for="exampleInputPassword1">Administrateur?</label>
                    <input type="checkbox" class="form-control form-check-input" name="is_admin" id="isAdminCheckbox" >
                </div>';
                }
            ?>
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>


        <div class='form-group' id='create_account_link'>
            <a href="login.php">Déjà venu? Se connecter</a>
        </div>
        </form>
        <?php else : ?>
                <h2 style='color:white;'>Bienvenue <?php echo $account['firstname']?>!</h2>
        <?php endif; ?>
    <div id='hello_image'>
        <img src="/img/wizard.png" alt="magicien image">
    </div>
</div>

<footer>

</footer>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</html>
