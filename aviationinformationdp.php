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

        $result = mysqli_query($conn, "SELECT * FROM aviationinformation");

        // GET 요청 시 삭제 처리 후 $result 초기화
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete_id'])) {
            $deleteId = mysqli_real_escape_string($conn, $_GET['delete_id']);
            $deleteQuery = "DELETE FROM aviationinformation WHERE airlineId = '$deleteId'";
            mysqli_query($conn, $deleteQuery);

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

        // 항공사 정보 수정 기능 추가
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_id'])) {
    $editId = mysqli_real_escape_string($conn, $_POST['edit_id']);
    $editQuery = "SELECT * FROM aviationinformation WHERE airlineId = '$editId'";
    $editResult = mysqli_query($conn, $editQuery);

    if ($editResult) {
        $editRow = mysqli_fetch_assoc($editResult);
        $airlineId = $editRow['airlineId'];
        $domesticInternational = $editRow['domesticInternational'];
        $stopoverAirport = $editRow['stopoverAirport'];
        $arrival_departure = $editRow['arrival_departure'];
        $regular_irregularity = $editRow['regular_irregularity'];
        $cargo = $editRow['cargo'];
        $airlineNum = $editRow['airlineNum'];
        $cargoplane_airliner = $editRow['cargoplane_airliner'];
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

    $updateQuery = "UPDATE aviationinformation 
                    SET domesticInternational = '$newDomesticInternational', 
                        stopoverAirport = '$newStopoverAirport', 
                        arrival_departure = '$newArrival_departure', 
                        regular_irregularity = '$newRegular_irregularity',
                        cargo = '$newCargo',
                        airlineNum = '$newairlineNum',
                        cargoplane_airliner = '$newCargoplane_airliner'
                    WHERE airlineId = '$updateId'";
    mysqli_query($conn, $updateQuery);

    // 초기화된 $result 변수
    $result = mysqli_query($conn, "SELECT * FROM aviationinformation");
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
        
            // 데이터 수행 쿼리문 생성
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
    </head>

<body>
    <div class="container">
        <h2>Aviation_information 테이블 조회</h2>
        <h4><a href='./db_start.html'>돌아가기</a></h4>
        
            <!-- 검색 -->
            <form method="POST" action="">

                        <label for="airlineId">코드:</label>
                        <input type="text" name="airlineId" id="airlineId" value="<?php echo $airlineId; ?>">

                        <label for="domesticInternational">국제, 국내:</label>
                        <input type="text"  name="domesticInternational" id="domesticInternational" value="<?php echo $domesticInternational; ?>">


                        <label for="stopoverAirport">경유지:</label>
                        <input type="text"  name="stopoverAirport" id="stopoverAirport" value="<?php echo $stopoverAirport; ?>">

                    
                        <label for="arrival_departure">도착, 출발:</label>
                        <input type="text"  name="arrival_departure" id="arrival_departure" value="<?php echo $arrival_departure; ?>">

                    
                        <label for="regular_irregularity">정기, 부정기:</label>
                        <input type="text"  name="regular_irregularity" id="regular_irregularity" value="<?php echo $regular_irregularity; ?>">

                    
                        <label for="cargo">화물(kg):</label>
                        <input type="text" name="cargo" id="cargo" value="<?php echo $cargo; ?>">
                   
                    
                        <label for="airlineNum">항공사 번호:</label>
                        <input type="text"  name="airlineNum" id="airlineNum" value="<?php echo $airlineNum; ?>">
                   
                    
                        <label for="cargoplane_airliner">화물기, 여객기:</label>
                        <input type="text"  name="cargoplane_airliner" id="cargoplane_airliner" value="<?php echo $cargoplane_airliner; ?>">
                   
                    
                        <input type="submit"  value="검색">
                   
              
                    

                    
            </form>

                                        <!-- 수정 폼 -->

                                        

        <table class="table mt-4">
           
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
                    <th>삭제</th>
                </tr>
           
            
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
                            <!-- 수정 버튼 -->

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

    
</body>
</html>
