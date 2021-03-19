<!DOCTYPE html>
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
                <a class="nav-item nav-link active" href="#">สั่งอาหาร</a>
                <a class="nav-item nav-link" href="order.php">Order</a>
            </div>
        </div>
    </nav>
</head>

<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-12 text-center">
                <h3>รายการอาหาร</h3>
                <div class="col-12">
                    <table class="table">
                        <th>No.</th>
                        <th>Menu Name</th>
                        <th>Price</th>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>ข้าวผัดหมู</td>
                                <td>50</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>ข้าวผัดกุ้ง</td>
                                <td>70</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>ข้าวผัดหมึก</td>
                                <td>70</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>กระเพราหมู</td>
                                <td>50</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 ">

                <?php
                if (!isset($_GET['num'])) { ?>
                <form action="index.php" method="get">
                    จำนวนรายการอาหารที่จะสั่ง: <input type="text" name="num" />
                    <input type="submit" />
                </form>
                <?php
                } elseif ($_GET['num'] == 0 || $_GET['num'] == null) {  ?>
                <form action="index.php" method="get">
                    จำนวนรายการอาหารที่จะสั่ง: <input type="text" name="num" />
                    <input type="submit" />
                </form>
                <?php
                } else {
                ?>
                <form action="add_order.php?chek=1" method="post" class="form-horizontal">
                    <h1>สั่งอาหาร</h1>
                    <p></p>
                    <?php
                        $num = $_GET['num'];
                        $_SESSION['num'] = $num;
                        for ($i = 0; $i < $_GET['num']; $i++) {
                            $menu = "menu$i";
                            $price = "price$i";
                            $quantity = "quantity$i";
                            $detail = "detail$i";
                        ?>
                    <div class="form-group">
                        <div class="col-sm-2 control-label">
                            รายการอาหารที่ <?php echo $i + 1; ?> :
                        </div>
                        <div class="col-sm-3">
                            <input type="text" name="<?php echo $menu; ?>" required class="form-control"
                                placeholder="รายการอาหารที่ <?php echo $i + 1; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 control-label">
                            ราคา :
                        </div>
                        <div class="col-sm-3">
                            <input type="text" name="<?php echo $price; ?>" required class="form-control"
                                placeholder="ราคาอาหาร">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 control-label">
                            จำนวน :
                        </div>
                        <div class="col-sm-3">
                            <input type="text" name="<?php echo $quantity; ?>" required class="form-control"
                                placeholder="จำนวน">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 control-label">
                            รายละเอียด :
                        </div>
                        <div class="col-sm-3">
                            <input type="text" name="<?php echo $detail; ?>" required class="form-control"
                                placeholder="รายละเอียด">
                        </div>
                    </div>
                    <?php
                        }
                        ?>
                    <div class="form-group">
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-3">
                            <button type="submit" class="btn btn-primary">สั่งอาหาร</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <?php
                }
?>




    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>