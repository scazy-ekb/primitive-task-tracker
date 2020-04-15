<!DOCTYPE html>
<html lang="en">
    <head>
        <title>slowpoke-tracker</title>
        <meta charset="utf-8"  />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="/favicon.png" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script>
            if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                let link = document.createElement("link");
                link.rel = "stylesheet";
                link.href = "https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/slate/bootstrap.min.css";
                document.head.appendChild(link);

                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
                    document.head.removeChild(link);
                });
            }
        </script>
    </head>
    <body>
        <nav class="navbar">
            <a class="navbar-brand" href="/">
                <img src="/slowpoke.png" width="30" height="30" class="d-inline-block align-top" alt="logo">
                Slowpoke Tracker
            </a>
            <?php if ($model['isAuthenticated']) { ?>
                <span class="nav-text"><?=$model['username']?></span>
                <ul class="nav navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/page/logout">Logout</a>
                    </li>
                </ul>
            <?php } else { ?>
                <ul class="nav navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/page/login">Login</a>
                    </li>
                </ul>
            <?php } ?>
        </nav>
        <?php include __DIR__."/$viewPath"; ?>
    </body>
</html>