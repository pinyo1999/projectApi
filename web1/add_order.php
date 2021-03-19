    <?php
    session_start();
    $menu = array();
    $price = array();
    $quantity = array();
    $detail = array();
    $detail_order = "";
    $p = 0.0;
    $q = 0;



    for ($i = 0; $i < $_SESSION['num']; $i++) {
        array_push($menu, $_POST["menu$i"]);
        array_push($price, $_POST["price$i"] * $_POST["quantity$i"]);
        array_push($quantity, $_POST["quantity$i"]);
        array_push($detail, $_POST["detail$i"]);
    }
    for ($i = 0; $i < $_SESSION['num']; $i++) {
        $detail_order = $detail_order . '{
                        "menu_name" : "' . $menu[$i] . '",
                        "price" : ' . $price[$i] . ',
                        "quantity" : ' . $quantity[$i] . ',
                        "detail" : "' . $detail[$i] . '"
                    }';
        if ($i <= ($_SESSION['num'] - 2)) {
            $detail_order = $detail_order . ',';
        }
    }
    //echo $detail_order;

    for ($i = 0; $i < $_SESSION['num']; $i++) {
        $p = $p + $price[$i];
        $q = $q + $quantity[$i];
    }
    $data = file_get_contents("http://localhost:3000/detail/");
    //var_dump($arrData);
    $arrData = json_decode($data, true);
    // echo "<pre>";
    // var_dump($arrData);
    // echo "</pre>";
    $num = count($arrData['data']) - 1;
    $no = $arrData['data'][$num]['no'] + 1;
    $id = $arrData['data'][$num]['id'] + 1;
    // echo  $id;



    //Set up POST array
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://localhost:3000/detail',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
        "_id" :  ' . $id . ',
        "id" : ' . $id . ',
        "no" : ' . $no . ',
        "quantity" :  ' . $_SESSION['num'] . ',
        "price" : ' . $p . ',
        "detail_order" : [ ' . $detail_order . '
        ],
        "status" : "not finished"
    }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    //echo $response;
    //header("Location:index.php")
    ?>
    <script type="text/javascript">
alert("<?php echo "สั่ง Order สําเร็จ"; ?>");
window.location = 'index.php';
    </script>