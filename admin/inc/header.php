<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        header div img{
            width: 52px;
            height: 52px;
        }
        header{
            padding: 0 50px;
            height: 70px;
        }
        ul li a{
            text-decoration: none;
            font-weight: 500;
        }
        nav ul li a{
            color: white;
        }
        nav ul li a:hover{
            color: #830000;
        }
        nav ul li{
            padding-right: 20px;
        }
        .h4{
            color: white !important;
        }  
    </style>
</head>
<body>
    <header class="d-flex justify-content-between align-items-center bg-dark text-light">
        <div class="d-flex align-items-center">
            <img src="inc/images/logo.png" alt="" class="me-3">
            <h2 class="h4 m-0 fw-bold">Cricket ScorePro</h2>
        </div>
        <!-- <h4><?php echo $pageTitle ?></h4> -->
    </header>    
</body>
</html>