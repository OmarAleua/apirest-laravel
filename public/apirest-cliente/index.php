<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ApiREST-Cliente</title>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <?php

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://localhost.apirest-laravel.com/curso?page=1',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_POSTFIELDS => 'titulo=Desarrollo%20web%20en%20PHP%20con%20Laravel%206%2C%20VueJS%20y%20MariaDB%20Mysql&descripcion=Desarrolla%20un%20sistema%20web%20robusto%20en%20PHP%20con%20Laravel%205.6%2C%20VueJS%20y%20MariaDB%20(Mysql)%20INCLUYE%20PROYECTO%20FINAL&instructor=Juan%20Carlos%20Arcila%20Diaz&imagen=https%3A%2F%2Fi.ytimg.com%2Fvi%2F8GD3DGbTwMc%2Fmaxresdefault.jpg&precio=10.99',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic YTJ5YTEwYWhITkVORURKT0g3VHlzWVZNUkpoQS5ITG41eW5IY2RyazAzd0lWc0l6cVlwVnVseWVmV3JpOm8yeW8xMm84Nkxtd1MwcWpSLmxjTk1CMndHWFZPbElCc1FvTWJaNENJcnNWSmlMRy5ycmh1TUd1dllzaQ==',
            'Content-Type: application/x-www-form-urlencoded',
            'Cookie: XSRF-TOKEN=eyJpdiI6InJvWDg0NTJGVkdFeUU5Y2c3c2N2ZHc9PSIsInZhbHVlIjoiKzREZXJmcHlEYVlaNjlReVZ1YXJoTjhPczJWdlBwTTlxcWVjVDZNLzlCTE1rWGcxRWEwbEpkelRvK2FsTTdnMWJRWmV0Nm1SbDYwME5EajdWNGpqd2h2TE13NDRsNkxYMUhkcnFkVkt0eit0UVlzZk1pcjE1c2htb2NCeTlZMFMiLCJtYWMiOiIxZTEwNDczYzA1MjYyYzQzNzIxYjU0ZDQwN2I5MjQ0NGY3MDcxMTM0NWFlMTYzYTg0YzhjY2QyYmM2YzZlOTU2IiwidGFnIjoiIn0%3D; laravel_session=eyJpdiI6IkViSEhia0lnSHJpMHN6Q0JFS1FTb0E9PSIsInZhbHVlIjoiaERLT28rdFpUTnN5eHp2UEc1cm5YaWlkV291ZHkwbjV5MU4zVDNnb2kxMkRuNkpucVhMcWkvTXBZYWU5QjUxQUJmcGt1YVNlYU5aYTM5T3Y3ZUdSQzJqemFnMEs5R2RuUXpzTTY3ZjNXVUdYTktxejNqbnRyOVhCcGt2M0wxUTIiLCJtYWMiOiI0ZmI1YzMwYjkyNWY0NTYwM2VmZDAxMWNmZWI0YjY3ZjE4ZWFlZTVjOWU3ZmUzNjQ0YjM0ZmQ5Y2FiNzEyZmEwIiwidGFnIjoiIn0%3D'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    $jsonDecode = json_decode($response, true);
    $jsonDecodes = $jsonDecode["detalles"]["data"];
    /* echo '<pre>';
    print_r($jsonDecode);
    echo '</pre>'; */

    ?>

    <div class="container-fluid">
        <div class="container">
            <div class="row">

                <?php
                foreach ($jsonDecodes as $key => $value) :
                ?>

                    <div class="col-3">
                        <div class="card my-2">
                            <div class="card-header">
                                <img src="<?php print_r($value['imagen']); ?>" class="img-fluid"> <!---->
                            </div>
                            <div class="card-body">
                                <h4><?php echo $value["titulo"]; ?></h4>
                                <p><?php echo $value["descripcion"]; ?></p>
                                <span class="badge badge-secondary"><?php echo $value["instructor"]; ?></span>
                            </div>
                            <div class="card-footer">
                                Precio <span class="badge bg-danger"><?php echo $value["precio"]; ?> USD</span>
                            </div>
                        </div>
                    </div>

                <?php
                endforeach
                ?>

            </div>
        </div>
    </div>

</body>

</html>