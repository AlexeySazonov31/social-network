<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="/css/layout.css" rel="stylesheet">
</head>

<body class="bg-body-tertiary" style="background-color: #084298!important">
    <header class="container-fluid d-flex justify-content-between align-items-center py-3" style="background: #084298;">
        <div class="text-center mx-5">
            <a href="/" style="color: white; text-decoration: none;">
                <h4 class="m-0">SOC.NET</h4>
            </a>
        </div>
        <div class="d-inline-flex mx-5 header-menu-desktop">
            <?php if (!empty($_SESSION["auth"]) and $_SESSION["status"] === "admin") : ?>
                <a class="nav-link <?= $pageName === "admin-panel" ? "text-warning" : "text-light" ?> px-2 mx-2" href="/admin-panel">Admin</a>
            <?php endif; ?>
            <?php if (!empty($_SESSION["auth"])) : ?>
                <a class="nav-link <?= $pageName === "messenger" ? "text-warning" : "text-light" ?> px-2 mx-2" href="/messenger">Messenger</a>
                <a class="nav-link <?= $pageName === "friends" ? "text-warning" : "text-light" ?> px-2 mx-2" href="/friends">Friends</a>

                <a class="nav-link <?= $pageName === "profile" ? "text-warning" : "text-light" ?> px-2 mx-2" href="/profile/<?= $_SESSION["login"] ?>">Account</a>
                <a class="nav-link text-danger px-2 mx-2" href="/logout">Logout</a>
            <?php else : ?>
                <a class="nav-link <?= $pageName === "signup" ? "text-warning" : "text-light" ?> px-2 mx-2" href="/signup">sign up</a>
                <a class="nav-link <?= $pageName === "login" ? "text-warning" : "text-light" ?> px-2 mx-2" href="/login">login</a>
            <?php endif; ?>
        </div>
        <div class="header-menu-mobile">
            <button id="mbMenuBtn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                </svg>
            </button>
            <div class="menu-items-mobile" id="menu-mb">
                <div class="text-left logo-mobile">
                    <a href="/" style="color: white; text-decoration: none;">
                        <h4 class="m-0">SOC.NET</h4>
                    </a>
                </div>
                <?php if (!empty($_SESSION["auth"])) : ?>
                    <a class="nav-link <?= $pageName === "profile" ? "text-warning" : "text-light" ?>" href="/profile/<?= $_SESSION["login"] ?>">Account</a>
                    <a class="nav-link <?= $pageName === "friends" ? "text-warning" : "text-light" ?>" href="/friends">Friends</a>
                    <a class="nav-link <?= $pageName === "messenger" ? "text-warning" : "text-light" ?>" href="/messenger">Messenger</a>

                    <a class="nav-link text-danger" href="/logout">Logout</a>
                <?php else : ?>
                    <a class="nav-link <?= $pageName === "signup" ? "text-warning" : "text-light" ?>" href="/signup">sign up</a>
                    <a class="nav-link <?= $pageName === "login" ? "text-warning" : "text-light" ?>" href="/login">login</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <div class="container d-flex justify-content-center">{{ flash }}</div>

    <div id="primary-main">
        <main class="container py-5" id="container-main">
            <h1 class="mb-5">{{ contentTitle }}</h1>
            {{ content }}
        </main>
    </div>

    <footer class="container-fluid p-3 text-center text-light" style="background: #084298;">Sazonov A. S. - For.um</footer>

    <script>
        const mbMenuBtn = document.getElementById("mbMenuBtn");
        const mbMenu = document.getElementById("menu-mb");

        closeIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16"><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg>';
        menuIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" /></svg>';

        let isOpen = 0;
        mbMenuBtn.addEventListener("click", () => {
            if(!isOpen){
                mbMenu.classList.add("active");
                mbMenuBtn.innerHTML = closeIcon;
                isOpen = 1;
            } else {
                mbMenu.classList.remove("active");
                mbMenuBtn.innerHTML = menuIcon;
                isOpen = 0;
            }
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>

</html>