<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<style>
    main {
        min-height: 87vh;
    }

    .container {
        max-width: 900px;
        ;
    }
    header {
        z-index: 10;
    }

    .alert {
        position: absolute;
        width: fit-content;

        z-index: 20;

        animation: alert 0.2s forwards;
        transform: translateX(-150%);
    }

    @keyframes alert {
        0% {
            transform: translateX(-150%);
        }

        100% {
            transform: translateX(0);
        }
    }

</style>

<body class="bg-body-tertiary">
    <header class="container-fluid d-flex justify-content-between align-items-center py-3" style="background: #084298;">
        <div class="text-center mx-5">
            <a href="/" style="color: white; text-decoration: none;">
                <h4 class="m-0">SOC.NET</h4>
            </a>
        </div>
        <div class="d-inline-flex mx-5">
            <?php if (!empty($_SESSION["auth"]) and $_SESSION["status"] === "admin") : ?>
                <a class="btn btn-secondary my-2" href="/admin-panel">Admin Panel</a>
            <?php endif; ?>
            <?php if (!empty($_SESSION["auth"])) : ?>
                <a class="btn btn-success m-2" href="/profile/<?= $_SESSION["login"] ?>">Account - <?= $_SESSION["login"] ?></a>
                <a class="btn btn-danger my-2" href="/logout">Logout</a>
            <?php else : ?>
                <a class="nav-link <?= $pageName === "signup" ? "text-warning" : "text-light" ?> px-2 mx-2" href="/signup">sign up</a>
                <a class="nav-link <?= $pageName === "login" ? "text-warning" : "text-light" ?> px-2 mx-2" href="/login">login</a>
            <?php endif; ?>
        </div>
    </header>

    <div class="container d-flex justify-content-center">{{ flash }}</div>

    <main class="container py-5">
        <h1 class="mb-5">{{ contentTitle }}</h1>
        {{ content }}
    </main>

    <footer class="container-fluid p-3 text-center text-light" style="background: #084298;">Sazonov A. S. - For.um</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>

</html>