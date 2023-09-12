<?php
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/database.php";
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
    
    if ($user) {
        if (password_verify($_POST["password"], $user["password_hash"])) {
            session_start();
            session_regenerate_id();
            $_SESSION["user_id"] = $user["id"];
            header("Location: index.php");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="keywords" content="everstock, crypto, stocks, money" />
        <meta name="description" content="This is the home page for the store EverStock. Where you can view all the stocks in one glance" />
        <meta name="author" content="Zac Avis" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

        <!-- STYLE SHEETS -->
        <link rel="stylesheet" href="css/signup.css" />
        <link rel="stylesheet" href="css/media.css" />

        <!-- TITLE -->
        <title>Helix Invest - Login</title>

        <!-- FAVICON -->
        <link rel="icon" href="images/logo.png">

        <!-- FONT LINKS -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

    </head>

    <body>

        <div class="content">

            <!-- HEADER -->
            <header class="header" data-header>
                <div class="container d-flex justify-space-between">
            
                    <a href="index.php" class="logo d-flex">
                        <img src="images/logo.png" width="40">
                        Helix
                    </a>
                
                    <nav class="navbar" data-navbar>
                        <ul class="navbar-list">
                            <li class="navbar-item"><a href="index.php" class="text-decoration-none navbar-link" data-nav-link>Home</a></li>
                            <li class="navbar-item"><a href="#" class="text-decoration-none navbar-link" data-nav-link>Trending</a></li>
                            <li class="navbar-item"><a href="#" class="text-decoration-none navbar-link" data-nav-link>Search</a></li>
                        </ul>
                    </nav>

                    <button class="nav-toggle-btn" data-nav-toggler>
                        <span class="line line-1"></span>
                        <span class="line line-2"></span>
                        <span class="line line-3"></span>
                    </button>
            
                </div>

            </header>

            <!-- MAIN -->
            <main>
                <article>
                    <section class="login-page d-flex">

                        <h1 class="text justify-center d-flex">login</h1>
    
                        <form method="post" class="login-form justify-center d-flex">
                                
                            <?php if ($is_invalid): ?>
                            	<em class="login-invalid d-flex justify-center">Invalid login</em>
                            <?php endif; ?>
                                
                            <div class="login-div">
                                <label for="email" class="input-text d-flex justify-center">email</label>
                                <input type="email" name="email" id="email" placeholder="Email" class="login-input" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" >
                            </div>
                                
                            <div class="login-div">
                                <label for="password" class="input-text d-flex justify-center">Password</label>
                                <input type="password" id="password" name="password" placeholder="Password" class="login-input">
                            </div>
                            
                            <div class="login-button-div">
                                <button class="button login-button">Log in</button>
                            </div>
                            
                        </form>

                    </section>
                </article>
            </main>
            
            <!-- FOOTER -->
            <div class="footer-bottom">
                <div class="container">
          
                  <p class="copyright">
                    &copy; 2023 All Rights Reserved by <a target="_blank" href="https://zacavis.web.app" class="copyright-link">Zac Avis</a>
                  </p>
          
                  <ul class="social-list">
          
                    <li>
                      <a href="#" class="social-link">
                        <div class="fab fa-instagram"></div>
                      </a>
                    </li>
          
                    <li>
                      <a href="#" class="social-link">
                        <div class="fab fa-facebook"></div>
                      </a>
                    </li>
          
                    <li>
                      <a href="#" class="social-link">
                        <div class="fab fa-twitter"></div>
                      </a>
                    </li>
          
                  </ul>
          
                </div>
              </div>
          
            </footer>

            <!-- CUSTOM JS FILE -->
            <!-- at bottom so page loads before executing -->
            <script src="js/script.js"></script>
        </div>
        
    </body>

</html>