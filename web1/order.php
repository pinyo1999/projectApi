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
                <a class="nav-item nav-link active" href="index.php">สั่งอาหาร</a>
                <a class="nav-item nav-link" href="order.php">Order</a>
            </div>
        </div>
    </nav>
</head>
<?php
//เปลี่ยน status
if (!empty($_GET['delete'])) {
    //echo $_GET['delete'];
    $id = $_GET['delete'];
    $url = "http://localhost:3000/detail/$id";
    //echo $url;
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL =>  $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'DELETE',
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    //echo $response;

}



if (!empty($_GET['status'])) {
    //echo $_GET['status'];
    $id = $_GET['status'];
    $url = "http://localhost:3000/detail/$id";
    //echo $url;
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PATCH',
        CURLOPT_POSTFIELDS => '{
    "status":"finished"
}',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    //echo $response;
}



// $url = "";
// if(!isset($_GET['url'])){
//     $url = $url.'http://localhost:3000/detail/';
// }elseif(isset($_GET['url']) == 0){

// }
$data = file_get_contents('http://localhost:3000/detail/');
//var_dump($arrData);
$arrData = json_decode($data, true);
// echo "<pre>";
// var_dump($arrData);
// echo "</pre>";
//echo $arrData['data'][1]["detail_order"][1]["menu_name"];
//echo count($arrData['data']);
?>

<body>


    <div class="container mt-5">
        <div class="row">
            <div class="col-12 text-center">
                <h3>Order</h3>
                <div class="col-12">
                    <div class="btn-group">
                        <!-- 
                        <a href="order.php?url=0"><button type="button" class="btn-primary">เรียบร้อยแล้ว</button></a>
                        <a href="order.php?url=1"><button type="button" class="btn-danger">ยังไม่เรียบร้อย</button></a> -->


                    </div>
                    <table class="table">
                        <th>รหัส</th>
                        <th>จำนวนรายการ</th>
                        <th>ราคารวม</th>
                        <th>##</th>
                        <th>สถานะ</th>
                        <th>##</th>
                        <tbody>
                            <tr>
                                <?php
                                for ($i = 0; $i < count($arrData['data']); $i++) {
                                    $button = "";
                                    if ($arrData['data'][$i]["status"] == "not finished") {
                                        $button = '<button type="button" class="btn btn-danger">อาหารยังไม่เสร็จ</button><a href="order.php?status=' . $arrData['data'][$i]["id"] . '"><button type="button"
                                        class="btn btn-warning">อาหารเสร็จแล้ว</button></a>';
                                    } else {
                                        $button = '<button type="button" class="btn btn-primary">เรียบร้อยแล้ว</button>';
                                    }
                                    $id = $arrData['data'][$i]["id"];
                                    $quantity = 0;
                                    $price = $arrData['data'][$i]["price"];
                                    for ($x = 0; $x < count($arrData['data'][$i]["detail_order"]); $x++) {
                                        $quantity =  $quantity + $arrData['data'][$i]["detail_order"][$x]['quantity'];
                                    }
                                ?>

                                <td><?php echo $id; ?></td>
                                <td><?php echo $quantity; ?></td>
                                <td><?php echo $price; ?></td>
                                <td>
                                    <a href="detail_order.php?detail=<?php echo $arrData['data'][$i]['id'] ?>"><button
                                            type="button" class="btn btn-info">รายละเอียด</button></a>
                                </td>
                                <td><?php echo $button; ?>
                                </td>
                                <td>
                                    <a href="order.php?delete=<?php echo $arrData['data'][$i]['id'] ?>"><button
                                            type="button" class="btn btn-danger">ลบ</button></a>
                                </td>
                            </tr>
                            <?php }; ?>
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