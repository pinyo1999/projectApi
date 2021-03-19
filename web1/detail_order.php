<?php session_start(); ?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>อารหารตามสั่ง</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">


    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">FiFo</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link active" href="index.php">สั่งอาหาร</a>
                <a class="nav-item nav-link" href="order.php">Order</a>
            </div>
        </div>
    </nav>
</head>

<body>
    <?php
    $id = $_GET['detail'];
    $data = file_get_contents("http://localhost:3000/detail/$id");
    $arrData = json_decode($data, true);
    // echo "<pre>";
    // var_dump($arrData);
    // echo "</pre>";
    // echo count($arrData['data']['detail_order']);
    ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 text-center">
                <h3><?php echo $id; ?> Order Details</h3>
                <div class="col-12">
                    <table class="table">
                        <th>No.</th>
                        <th>Menu Name</th>
                        <th>Amount</th>
                        <th>Price</th>
                        <th>Menu details</th>
                        <tbody>

                            <?php
                            for ($i = 0; $i < count($arrData['data']['detail_order']); $i++) {

                            ?>
                            <tr>
                                <td><?php echo $i + 1 ?></td>
                                <td><?php echo $arrData['data']['detail_order'][$i]['menu_name'] ?></td>
                                <td><?php echo $arrData['data']['detail_order'][$i]['quantity'] ?></td>
                                <td><?php echo $arrData['data']['detail_order'][$i]['price'] ?> บาท</td>
                                <td><?php echo $arrData['data']['detail_order'][$i]['detail'] ?></td>
                            </tr>
                            <?php } ?>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>






    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>