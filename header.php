<?php
include 'loading.php';
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
    <a class="navbar-brand" href="/"><img src="img/logo.svg" alt=""></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" id="toggle_dropdown_button" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <img src="img/closed_eye.png" alt="burger_icon_closed">
    </button>
    <div class="collapse navbar-collapse flex-row-reverse" id="navbarSupportedContent">
        <div class="d-flex">
            <button onclick='location.href="login.php"' id="login_button">Login</button>
        </div>
            <input class="form-control me-2" id="searchbar" type="search" placeholder="Rechercher..." aria-label="rechercher">
        </div>
    </div>
</nav>
<script>
    const eye = document.getElementById("toggle_dropdown_button");
    eye.addEventListener("click", changeImageEye);
    let is_open = false
    function changeImageEye() {
    if (is_open) {
        document.getElementById("toggle_dropdown_button").innerHTML = "<img src=\"img/closed_eye.png\" alt=\"burger_icon_closed\">";
        is_open = false
    } else
    {
        document.getElementById("toggle_dropdown_button").innerHTML = "<img src=\"img/open_eye.png\" alt=\"burger_icon_closed\">";
        is_open = true
    }
    }
</script>