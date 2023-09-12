<?php

session_start();

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php";
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
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
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/media.css" />

        <!-- TITLE -->
        <title>Helix Invest</title>

        <!-- FAVICON -->
        <link rel="icon" href="images/logo.png">

        <!-- FONT LINKS -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

        <!-- SCRIPTS -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

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
                            <li class="navbar-item"><a href="index.php" class="text-decoration-none navbar-link active" data-nav-link>Home</a></li>
                            <li class="navbar-item"><a href="#" class="text-decoration-none navbar-link" data-nav-link>Trending</a></li>
                            <li class="navbar-item"><a href="#" class="text-decoration-none navbar-link" data-nav-link>Search</a></li>
                        </ul>
                    </nav>

                    <button class="nav-toggle-btn" data-nav-toggler>
                        <span class="line line-1"></span>
                        <span class="line line-2"></span>
                        <span class="line line-3"></span>
                    </button>
                    
                    <button class="user-btn" aria-label="Toggle menu" data-user-toggler>
                        <?php if (isset($user)): ?>
                        	<a class="fas fa-user" style="color: #FFFFFF;"></a>
                        <?php else: ?>
                            <a href="login.php" class="fas fa-user" style="color: #FFFFFF;"></a>
                        <?php endif; ?>
                    </button>
            
                </div>
               	<?php if (isset($user)): ?>
                    <form class="user-form" data-user-form>
                            <h3>Hi <?= htmlspecialchars($user["name"]) ?></h3>
                            <a href="logout.php" class="create-account text-decoration-none">Log out</a>
                    </form>
                <?php endif; ?>
				

            </header>

            <!-- MAIN -->
            <main>
                <article>

                    <!-- HERO -->
                    <section class="section hero" data-section>
                        <div class="container">
                
                          <div class="hero-content">
                
                            <h1 class="h1 hero-title">Personal Stock Price Viewer</h1>
                
                                <p class="hero-text">Some stock prices may be different due to 'Alpha Vantage' 5 request/min limit. So I'm using 'TIME_SERIES_INTRADAY' to help create the 
                                    graphs but it also has some differences in prices from the times it opens & closes.
                                </p>
                
                            </div>
                
                            <figure class="hero-banner">
                                    <img src="images/hero-banner.png" width="550" height="350" class="w-100">
                            </figure>
                
                        </div>
                    </section>
                    
                </article>
            </main>

            <!-- MARKET -->
            <section class="section market" aria-label="market update" data-section>
                <div class="container">

                <div class="title-wrapper">
                    <h2 class="h2 section-title">Trending</h2>
                </div>

                <div class="market-tab">

                    <ul class="tab-nav">

                        <li><button class="tab-btn active" tab-btn-today>Today</button></li>

                    </ul>

                    <table class="market-table">

                        <thead class="table-head">
                            <tr class="table-row table-title">
                                <th class="table-heading"></th>
                                <th class="table-heading" scope="col">#</th>
                                <th class="table-heading" scope="col">Name</th>
                                <th class="table-heading" scope="col">Stock Price</th>
                                <th class="table-heading" scope="col">24h %</th>
                                <th class="table-heading" scope="col">Last 24h</th>
                                <th class="table-heading"></th>
                            </tr>
                        </thead>

                        <tbody class="table-body"></tbody>

                    </table>

                </div>

                </div>
            </section>
            
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
            <script type="text/javascript" src="js/getStockData.js"></script>
        </div>
        
    </body>

</html>