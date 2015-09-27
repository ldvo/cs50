<!DOCTYPE html>

<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="/css/bootstrap-theme.min.css" rel="stylesheet"/>
        <link href="/css/styles.css" rel="stylesheet"/>

        <?php if (isset($title)): ?>
            <title>C$50 Finance: <?= htmlspecialchars($title) ?></title>
        <?php else: ?>
            <title>C$50 Finance</title>
        <?php endif ?>

        <script src="/js/jquery-1.10.2.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/scripts.js"></script>
        
    </head>

    <body>

        <div id="top">
                <a href="/"><img id=logo alt="C$50 Finance" src="/img/logo.png"/></a>
            </div>
        
        <div id=index class=boton> <a href=index.php> Index </a> </div>
        <div id=quote class=boton> <a href=quote.php> Quote </a> </div>
        <div id=buy class=boton> <a href=buy.php> Buy </a> </div>
        <div id=sell class=boton> <a href=sell.php> Sell </a> </div>
        <div id=history class=boton> <a href=history.php> History </a> </div>
        <div id=password class=boton> <a href=password.php> Password </a> </div>
        
        
        <div class="container">
            <br/><br/><br/><br/>

            <div id="middle">
