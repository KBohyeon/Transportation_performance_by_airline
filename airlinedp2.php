<!DOCTYPE html>
<html language="UTF-8">
<?php
    //경고 무시
	ini_set('display_errors', '0');
        include "db_conn.php";

        $airlineId = '';
        $domesticInternational = '';
        $stopoverAirport = '';
        $arrival_departure = '';
        $regular_irregularity = '';
        $cargo = '';
        $airlineNum = '';
        $cargoplane_airliner = '';
        $airlineName = '';
        $Icao = '';
        $Iata = '';

        $result = mysqli_query($conn, "SELECT * FROM aviationinformation AS a JOIN airline AS l ON a.airlineNum = l.airlineNum");
        $query = "SELECT * FROM aviationinformation AS a JOIN airline AS l ON a.airlineNum = l.airlineNum";


        // GET 요청 시 삭제 처리 후 $result 초기화
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete_id'])) {
            $deleteId = mysqli_real_escape_string($conn, $_GET['delete_id']);
            $deleteQuery = "DELETE FROM aviationinformation WHERE airlineId = '$deleteId'";
            mysqli_query($conn, $deleteQuery);

            $result = mysqli_query($conn, $query);
        }

        // 항공사 정보 수정 기능 추가
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_id'])) {
    $editId = mysqli_real_escape_string($conn, $_POST['edit_id']);
    $editQuery = "SELECT * FROM aviationinformation AS a JOIN airline AS l ON a.airlineNum = l.airlineNum WHERE a.airlineId = '$editId'";
    $editResult = mysqli_query($conn, $editQuery);

    if ($editResult) {
        $editRow = mysqli_fetch_assoc($editResult);
        $airlineId = $editRow['a.airlineId'];
        $domesticInternational = $editRow['a.domesticInternational'];
        $stopoverAirport = $editRow['a.stopoverAirport'];
        $arrival_departure = $editRow['a.arrival_departure'];
        $regular_irregularity = $editRow['a.regular_irregularity'];
        $cargo = $editRow['a.cargo'];
        $airlineNum = $editRow['a.airlineNum'];
        $cargoplane_airliner = $editRow['a.cargoplane_airliner'];
        $airlineName = $editRow['l.airlineName'];
        $Icao = $editRow['l.Icao'];
        $Iata = $editRow['l.Iata'];
    }
}

// 항공사 정보 업데이트 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $updateId = mysqli_real_escape_string($conn, $_POST['update_id']);
    $newDomesticInternational = mysqli_real_escape_string($conn, $_POST['new_domesticInternational']);
    $newStopoverAirport = mysqli_real_escape_string($conn, $_POST['new_stopoverAirport']);
    $newArrival_departure = mysqli_real_escape_string($conn, $_POST['new_arrival_departure']);
    $newRegular_irregularity = mysqli_real_escape_string($conn, $_POST['new_regular_irregularity']);
    $newCargo = mysqli_real_escape_string($conn, $_POST['new_cargo']);
    $newairlineNum = mysqli_real_escape_string($conn, $_POST['new_airlineNum']);
    $newCargoplane_airliner = mysqli_real_escape_string($conn, $_POST['new_cargoplane_airliner']);
    $newAirlineName = mysqli_real_escape_string($conn, $_POST['new_airlineName']);
    $newIcao = mysqli_real_escape_string($conn, $_POST['new_Icao']);
    $newIata = mysqli_real_escape_string($conn, $_POST['new_Iata']);

    $updateQuery = "UPDATE aviationinformation AS a 
                    JOIN airline AS l ON a.airlineNum = l.airlineNum
                    SET a.domesticInternational = '$newDomesticInternational', 
                        a.stopoverAirport = '$newStopoverAirport', 
                        a.arrival_departure = '$newArrival_departure', 
                        a.regular_irregularity = '$newRegular_irregularity',
                        a.cargo = '$newCargo',
                        a.airlineNum = '$newairlineNum',
                        a.cargoplane_airliner = '$newCargoplane_airliner',
                        l.airlineName = '$newAirlineName', 
                        l.Icao = '$newIcao', 
                        l.Iata = '$newIata' 
                    WHERE a.airlineId = '$updateId'";
    mysqli_query($conn, $updateQuery);

    // 초기화된 $result 변수
    $result = mysqli_query($conn, "SELECT * FROM aviationinformation AS a JOIN airline AS l ON a.airlineNum = l.airlineNum");
}

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // 폼으로부터 받은 검색어
            $airlineId = isset($_POST['airlineId']) ? mysqli_real_escape_string($conn, $_POST['airlineId']) : '';
            $domesticInternational = isset($_POST['domesticInternational']) ? mysqli_real_escape_string($conn, $_POST['domesticInternational']) : '';
            $stopoverAirport = isset($_POST['stopoverAirport']) ? mysqli_real_escape_string($conn, $_POST['stopoverAirport']) : '';
            $arrival_departure = isset($_POST['arrival_departure']) ? mysqli_real_escape_string($conn, $_POST['arrival_departure']) : '';
            $regular_irregularity = isset($_POST['regular_irregularity']) ? mysqli_real_escape_string($conn, $_POST['regular_irregularity']) : '';
            $cargo = isset($_POST['cargo']) ? mysqli_real_escape_string($conn, $_POST['cargo']) : '';
            $airlineNum = isset($_POST['airlineNum']) ? mysqli_real_escape_string($conn, $_POST['airlineNum']) : '';
            $cargoplane_airliner = isset($_POST['cargoplane_airliner']) ? mysqli_real_escape_string($conn, $_POST['cargoplane_airliner']) : '';
            $airlineName = isset($_POST['airlineName']) ? mysqli_real_escape_string($conn, $_POST['airlineName']) : '';
            $Icao = isset($_POST['Icao']) ? mysqli_real_escape_string($conn, $_POST['Icao']) : '';
            $Iata = isset($_POST['Iata']) ? mysqli_real_escape_string($conn, $_POST['Iata']) : '';
        

            // 데이터 수행 쿼리문 생성
            $query = "SELECT * FROM  aviationinformation AS a JOIN airline AS l ON a.airlineNum = l.airlineNum WHERE 
                a.airlineId LIKE '%$airlineId%' AND
                a.domesticInternational LIKE '%$domesticInternational%' AND
                a.stopoverAirport LIKE '%$stopoverAirport%' AND
                a.arrival_departure LIKE '%$arrival_departure%' AND
                a.regular_irregularity LIKE '%$regular_irregularity%' AND
                a.cargo LIKE '%$cargo%' AND
                a.airlineNum LIKE '%$airlineNum%' AND
                a.cargoplane_airliner LIKE '%$cargoplane_airliner%' AND
                l.airlineName LIKE '%$airlineName%' AND
                l.Icao LIKE '%$Icao%' AND
                l.Iata LIKE '%$Iata%'";
            $result = mysqli_query($conn, $query);
        }

        // 전체 삭제 확인 경고
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_all'])) {
            echo "<script>
                    var confirmDelete = confirm('모든 데이터를 삭제하시겠습니까?');
                    if (confirmDelete) {
                        window.location.href = '?confirmed_delete_all=true';
                    }
                </script>";
        }

        // 확인 후 전체 삭제 처리
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['confirmed_delete_all'])) {
            // 전체삭제 쿼리문
            $deleteAllQuery = "DELETE FROM aviationinformation";
            mysqli_query($conn, $deleteAllQuery);

            // $result 초기화
            $query = "SELECT * FROM aviationinformation WHERE 
                airlineId LIKE '%$airlineId%' AND
                domesticInternational LIKE '%$domesticInternational%' AND
                stopoverAirport LIKE '%$stopoverAirport%' AND
                arrival_departure LIKE '%$arrival_departure%' AND
                regular_irregularity LIKE '%$regular_irregularity%' AND
                cargo LIKE '%$cargo%' AND
                airlineNum LIKE '%$airlineNum%' AND
                cargoplane_airliner LIKE '%$cargoplane_airliner%'";
            $result = mysqli_query($conn, $query);
        }

        // 선택 삭제 
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_selected'])) {
            // 선택 삭제 쿼리문 
            $deleteSelectedQuery = "DELETE FROM aviationinformation WHERE 
                airlineId LIKE '%$airlineId%' AND
                domesticInternational LIKE '%$domesticInternational%' AND
                stopoverAirport LIKE '%$stopoverAirport%' AND
                arrival_departure LIKE '%$arrival_departure%' AND
                regular_irregularity LIKE '%$regular_irregularity%' AND
                cargo LIKE '%$cargo%' AND
                airlineNum LIKE '%$airlineNum%' AND
                cargoplane_airliner LIKE '%$cargoplane_airliner%'";
            mysqli_query($conn, $deleteSelectedQuery);
        
            $query = "SELECT * FROM aviationinformation WHERE 
                airlineId LIKE '%$airlineId%' AND
                domesticInternational LIKE '%$domesticInternational%' AND
                stopoverAirport LIKE '%$stopoverAirport%' AND
                arrival_departure LIKE '%$arrival_departure%' AND
                regular_irregularity LIKE '%$regular_irregularity%' AND
                cargo LIKE '%$cargo%' AND
                airlineNum LIKE '%$airlineNum%' AND
                cargoplane_airliner LIKE '%$cargoplane_airliner%'";
            $result = mysqli_query($conn, $query);
        }

    ?>
<head>
        <meta charset="UTF-8">
        <title>DB 커넥트</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <style>
            body {
                background-color: #f8f9fa;
                padding: 50px;
                font-family: 'Arial', sans-serif;
            }

            h2, h4 {
                text-align: center;
                color: #007bff;
            }

            form {
                margin: 20px 0;
            }

            label {
                margin-right: 10px;
            }

            table {
                margin-top: 20px;
                width: 100%;
                table-layout: auto; /*텍스트 길이에 따라 열의 크기를 조절*/
            }

            table, th, td {
                border: 1px solid #007bff;
            }

            th, td {
                text-align: center;
                white-space: nowrap; /* 텍스트가 열 너비를 넘어갈 경우 줄바꿈 방지 */
            }

            th {
                background-color: #007bff;
                color: white;
            }

            a {
                color: #007bff;
                text-decoration: none;
            }

            a:hover {
                text-decoration: underline;
            }

            .edit-form {
                display: none;
            }

            .container {            /*테이블의 크기 설정*/
            max-width: 3200px; 
        }

        </style>
    </head>

    <body>

    <div class="container">
        <h2>조인 테이블 조회</h2>
        <h4><a href='./db_start.html'>돌아가기</a></h4>

                <!-- 검색 -->
        <form method="POST" action="">
            <div class="form-row">
                    <div class="col-md-2">
                        <label for="airlineId">코드:</label>
                        <input type="text" class="form-control" name="airlineId" id="airlineId" value="<?php echo $airlineId; ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="domesticInternational">국제, 국내:</label>
                        <input type="text" class="form-control" name="domesticInternational" id="domesticInternational" value="<?php echo $domesticInternational; ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="stopoverAirport">경유지:</label>
                        <input type="text" class="form-control" name="stopoverAirport" id="stopoverAirport" value="<?php echo $stopoverAirport; ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="arrival_departure">도착, 출발:</label>
                        <input type="text" class="form-control" name="arrival_departure" id="arrival_departure" value="<?php echo $arrival_departure; ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="regular_irregularity">정기, 부정기:</label>
                        <input type="text" class="form-control" name="regular_irregularity" id="regular_irregularity" value="<?php echo $regular_irregularity; ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="cargo">화물(kg):</label>
                        <input type="text" class="form-control"name="cargo" id="cargo" value="<?php echo $cargo; ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="airlineNum">항공사 번호:</label>
                        <input type="text" class="form-control" name="airlineNum" id="airlineNum" value="<?php echo $airlineNum; ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="cargoplane_airliner">화물기, 여객기:</label>
                        <input type="text" class="form-control" name="cargoplane_airliner" id="cargoplane_airliner" value="<?php echo $cargoplane_airliner; ?>">
                    </div>
                <div class="col-md-2">
                    <label for="airlineName">항공사명:</label>
                    <input type="text" class="form-control" name="airlineName" id="airlineName" value="<?php echo $airlineName; ?>">
                </div>
                <div class="col-md-2">
                    <label for="Icao">Icao:</label>
                    <input type="text" class="form-control" name="Icao" id="Icao" value="<?php echo $Icao; ?>">
                </div>
                <div class="col-md-2">
                    <label for="Iata">Iata:</label>
                    <input type="text" class="form-control" name="Iata" id="Iata" value="<?php echo $Iata; ?>">
                </div>
                <div class="col-md-2">
                    <input type="submit" class="btn btn-primary" value="검색">
                </div>
            </div>
            <div class="form-row mt-2">
                <div class="col-md-2">
                    <input type="submit" class="btn btn-danger" name="delete_all" value="전체 삭제">
                </div>
                <div class="col-md-2">
                    <input type="submit" class="btn btn-warning" name="delete_selected" value="선택 삭제">
                </div>
            </div>
        </form>

                            <!-- 수정 폼 -->
        <div class="edit-form">
            <h3>항공사 정보 수정</h3>
            <form method="POST" action="">
                <input type="hidden" name="update_id" id="update_id" value="">
                <label for="new_domesticInternational">국제, 국내:</label>
                <input type="text" class="form-control" name="new_domesticInternational" id="new_domesticInternational" required>
                <br>
                <label for="new_stopoverAirport">경유지:</label>
                <input type="text" class="form-control" name="new_stopoverAirport" id="new_stopoverAirport" required>
                <br>
                <label for="new_arrival_departure">도착, 출발:</label>
                <input type="text" class="form-control" name="new_arrival_departure" id="new_arrival_departure" required>
                <br>
                <label for="new_regular_irregularity">정기, 부정기:</label>
                <input type="text" class="form-control" name="new_regular_irregularity" id="new_regular_irregularity" required>
                <br>
                <label for="new_cargo">화물(kg):</label>
                <input type="text" class="form-control" name="new_cargo" id="new_cargo" required>
                <br>
                <label for="new_airlineNum">항공사 번호:</label>
                <input type="text" class="form-control" name="new_airlineNum" id="new_airlineNum" required>
                <br>
                <label for="new_cargoplane_airliner">화물기, 여객기:</label>
                <input type="text" class="form-control" name="new_cargoplane_airliner" id="new_cargoplane_airliner" required>
                <br>
                <label for="new_airlineName">항공사명:</label>
                <input type="text" class="form-control" name="new_airlineName" id="new_airlineName" required>
                <br>
                <label for="new_Icao">Icao:</label>
                <input type="text" class="form-control" name="new_Icao" id="new_Icao" required>
                <br>
                <label for="new_Iata">Iata:</label>
                <input type="text" class="form-control" name="new_Iata" id="new_Iata" required>
                <br>
                <input type="submit" class="btn btn-success" name="update" value="수정">
            </form>
        </div>

            <table class="table mt-4">
            <thead class="thead-dark">
            <!-- 헤더 -->
                <tr>
                    <th>코드</th>
                    <th>국제, 국내</th>
                    <th>경유지</th>
                    <th>도착, 출발</th>
                    <th>정기, 부정기</th>
                    <th>화물(kg)</th>
                    <th>항공사 번호</th>
                    <th>화물기, 여객기</th>
                    <th>항공사명</th>
                    <th>Icao</th>
                    <th>Iata</th>
                    <th>수정</th>
                    <th>삭제</th>
                </tr>
            </thead>
            
            <tbody>
                <?php
                    while($row = mysqli_fetch_array($result)) {
                        $airlineId = $row['airlineId'];
                        $domesticInternational = $row['domesticInternational'];
                        $stopoverAirport = $row['stopoverAirport'];
                        $arrival_departure = $row['arrival_departure'];
                        $regular_irregularity = $row['regular_irregularity'];
                        $cargo = $row['cargo'];
                        $airlineNum = $row['airlineNum'];
                        $cargoplane_airliner = $row['cargoplane_airliner'];
                        $airlineName = $row['airlineName'];
                        $Icao = $row['Icao'];
                        $Iata = $row['Iata'];
                ?>
                <tr>
                    <td><?php echo $airlineId; ?></td>
                    <td><?php echo $domesticInternational; ?></td>
                    <td><?php echo $stopoverAirport; ?></td>
                    <td><?php echo $arrival_departure; ?></td>
                    <td><?php echo $regular_irregularity; ?></td>
                    <td><?php echo $cargo; ?></td>
                    <td><?php echo $airlineNum; ?></td>
                    <td><?php echo $cargoplane_airliner; ?></td>
                    <td><?php echo $airlineName; ?></td>
                        <td><?php echo $Icao; ?></td>
                        <td><?php echo $Iata; ?></td>
                            <!-- 수정 버튼 -->
                    <td><button class="btn btn-sm btn-info" onclick="showEditForm('<?php echo $airlineId; ?>')">수정</button></td>
                    <td><a href="?delete_id=<?php echo $airlineId; ?>" class="btn btn-sm btn-danger">삭제</a></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>                
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
    function showEditForm(id) {
        var editForm = document.querySelector('.edit-form');
        editForm.style.display = 'block';

        // 선택된 행의 정보를 수정 폼에 표시
        document.getElementById('update_id').value = id;
        document.getElementById('new_domesticInternational').value = '<?php echo $domesticInternational; ?>';
        document.getElementById('new_stopoverAirport').value = '<?php echo $stopoverAirport; ?>';
        document.getElementById('new_arrival_departure').value = '<?php echo $arrival_departure; ?>';
        document.getElementById('new_regular_irregularity').value = '<?php echo $regular_irregularity; ?>';
        document.getElementById('new_cargo').value = '<?php echo $cargo; ?>';
        document.getElementById('new_airlineNum').value = '<?php echo $airlineNum; ?>';
        document.getElementById('new_cargoplane_airliner').value = '<?php echo $cargoplane_airliner; ?>';
        document.getElementById('new_airlineName').value = '<?php echo $airlineName; ?>';
        document.getElementById('new_Icao').value = '<?php echo $Icao; ?>';
        document.getElementById('new_Iata').value = '<?php echo $Iata; ?>';
    }
    </script>
    </body>
</html>