<!DOCTYPE html>
<html lang="UTF-8">

<?php
ini_set('display_errors', '0');
include "db_conn.php";
$serialNumber = '';
$airplaneName = '';
$aircraftRating = '';
$manufacturer = '';
$sortation = '';
$new_airplaneName = '';
$new_aircraftRating = '';
$new_manufacturer = '';

// 초기화된 $result 변수
$result = mysqli_query($conn, "SELECT * FROM airplane");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete_id'])) {
    $deleteId = mysqli_real_escape_string($conn, $_GET['delete_id']);
    $deleteQuery = "DELETE FROM airplane WHERE serialNumber = '$deleteId'";
    mysqli_query($conn, $deleteQuery);

        // 초기화된 $result 변수
        $result = mysqli_query($conn, "SELECT * FROM airplane");
}

//수정
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_id'])) {
    $editId = mysqli_real_escape_string($conn, $_POST['edit_id']);
    $editQuery = "SELECT * FROM airplane WHERE serialNumber = '$editId'";
    $editResult = mysqli_query($conn, $editQuery);

    if ($editResult) {
        $editRow = mysqli_fetch_assoc($editResult);
        $serialNumber = $editRow['serialNumber'];
        $airplaneName = $editRow['airplaneName'];
        $aircraftRating = $editRow['aircraftRating'];
        $manufacturer = $editRow['manufacturer'];
        $sortation = $editRow['sortation'];
    }
}

// 항공사 정보 업데이트 기능 추가
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $updateId = mysqli_real_escape_string($conn, $_POST['update_id']);
    $newAirplaneName = mysqli_real_escape_string($conn, $_POST['new_airplaneName']);
    $newAircraftRating = mysqli_real_escape_string($conn, $_POST['new_aircraftRating']);
    $newManufacturer = mysqli_real_escape_string($conn, $_POST['new_manufacturer']);
    $newSortation = mysqli_real_escape_string($conn, $_POST['new_sortation']);

    $updateQuery = "UPDATE airplane 
                    SET airplaneName = '$newAirplaneName', 
                        aircraftRating = '$newAircraftRating', 
                        manufacturer = '$newManufacturer',
                        sortation = '$newSortation'  
                    WHERE serialNumber = '$updateId'";
    mysqli_query($conn, $updateQuery);

    // 초기화된 $result 변수
    $result = mysqli_query($conn, "SELECT * FROM airplane"); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $serialNumber = isset($_POST['serialNumber']) ? mysqli_real_escape_string($conn, $_POST['serialNumber']) : '';
    $airplaneName = isset($_POST['airplaneName']) ? mysqli_real_escape_string($conn, $_POST['airplaneName']) : '';
    $aircraftRating = isset($_POST['aircraftRating']) ? mysqli_real_escape_string($conn, $_POST['aircraftRating']) : '';
    $manufacturer = isset($_POST['manufacturer']) ? mysqli_real_escape_string($conn, $_POST['manufacturer']) : '';
    $newSortation = isset($_POST['sortation']) ? mysqli_real_escape_string($conn, $_POST['sortation']) : '';

    $query = "SELECT * FROM airplane WHERE 
            serialNumber LIKE '%$serialNumber%' AND
            airplaneName LIKE '%$airplaneName%' AND
            aircraftRating LIKE '%$aircraftRating%' AND
            manufacturer LIKE '%$manufacturer%' AND
            sortation LIKE '%$sortation%'";
    $result = mysqli_query($conn, $query);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_all'])) {
    echo "<script>
            var confirmDelete = confirm('모든 데이터를 삭제하시겠습니까?');
            if (confirmDelete) {
                window.location.href = '?confirmed_delete_all=true';
            }
        </script>";
}

//전체삭제
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['confirmed_delete_all'])) {
    $deleteAllQuery = "DELETE FROM airplane";
    mysqli_query($conn, $deleteAllQuery);

    // 초기화된 $result 변수
    $result = mysqli_query($conn, "SELECT * FROM airplane");
}

//선택 삭제
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_selected'])) {
    $deleteSelectedQuery = "DELETE FROM airplane WHERE 
                    serialNumber LIKE '%$serialNumber%' AND
                    airplaneName LIKE '%$airplaneName%' AND
                    aircraftRating LIKE '%$aircraftRating%' AND
                    manufacturer LIKE '%$manufacturer%' AND
                    sortation LIKE '%$sortation%'";
    mysqli_query($conn, $deleteSelectedQuery);

    $query = "SELECT * FROM airplane WHERE 
            serialNumber LIKE '%$serialNumber%' AND
            airplaneName LIKE '%$airplaneName%' AND
            aircraftRating LIKE '%$aircraftRating%' AND
            manufacturer LIKE '%$manufacturer%' AND
            sortation LIKE '%$sortation%'";
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
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #007bff;
        }

        th, td {
            padding: 10px;
            text-align: center;
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
    </style>
</head>

<body>
    <div class="container">
        <h2>Airplane 테이블 조회</h2>
        <h4>
            <a href='./db_start.html'>돌아가기</a>
        </h4>
        <!-- 검색 -->
        <form method="POST" action="">
            <div class="form-row">
                <div class="col-md-2">
                    <label for="serialNumber">시리얼 번호:</label>
                    <input type="text" class="form-control" name="serialNumber" id="serialNumber" value="<?php echo $serialNumber; ?>">
                </div>
                <div class="col-md-2">
                    <label for="airplaneName">기종:</label>
                    <input type="text" class="form-control" name="airplaneName" id="airplaneName" value="<?php echo $airplaneName; ?>">
                </div>
                <div class="col-md-2">
                    <label for="aircraftRating">항공기 등급:</label>
                    <input type="text" class="form-control" name="aircraftRating" id="aircraftRating" value="<?php echo $aircraftRating; ?>">
                </div>
                <div class="col-md-2">
                    <label for="manufacturer">제조업체:</label>
                    <input type="text" class="form-control" name="manufacturer" id="manufacturer" value="<?php echo $manufacturer; ?>">
                </div>
                <div class="col-md-2">
                    <label for="sortation">구분:</label>
                    <input type="text" class="form-control" name="sortation" id="sortation" value="<?php echo $sortation; ?>">
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

                <!-- 항공기 정보 수정 폼 -->
        <div class="edit-form">
            <h3>항공기 정보 수정</h3>
            <form method="POST" action="">
                <input type="hidden" name="update_id" id="update_id" value="">
                <label for="new_airplaneName">기종:</label>
                <input type="text" class="form-control" name="new_airplaneName" id="new_airplaneName" required>
                <br>
                <label for="new_aircraftRating">항공기 등급:</label>
                <input type="text" class="form-control" name="new_aircraftRating" id="new_aircraftRating" required>
                <br>
                <label for="new_manufacturer">제조업체:</label>
                <input type="text" class="form-control" name="new_manufacturer" id="new_manufacturer" required>
                <br>
                <label for="new_sortation">구분:</label>
                <input type="text" class="form-control" name="new_sortation" id="new_sortation" required>
                <br>
                <input type="submit" class="btn btn-success" name="update" value="수정">
            </form>
        </div>

        <!-- 테이블 -->
        <table class="table mt-4">
            <thead class="thead-dark">
                <tr>
                    <th>시리얼 번호</th>
                    <th>기종</th>
                    <th>항공기 등급</th>
                    <th>제조업체</th>
                    <th>구분</th>
                    <th>삭제</th>
                    <th>수정</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_array($result)) {
                    $serialNumber = $row['serialNumber'];
                    $airplaneName = $row['airplaneName'];
                    $aircraftRating = $row['aircraftRating'];
                    $manufacturer = $row['manufacturer'];
                    $sortation = $row['sortation'];
                ?>
                    <tr>
                        <td><?php echo $serialNumber; ?></td>
                        <td><?php echo $airplaneName; ?></td>
                        <td><?php echo $aircraftRating; ?></td>
                        <td><?php echo $manufacturer; ?></td>
                        <td><?php echo $sortation; ?></td>
                        <td>
                            <!-- 수정 버튼 -->
                            <button class="btn btn-sm btn-info" onclick="showEditForm('<?php echo $serialNumber; ?>')">수정</button>
                        </td>
                        <td><a href="?delete_id=<?php echo $serialNumber; ?>" class="btn btn-sm btn-danger">삭제</a></td>
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
    function showEditForm(id, airplaneName, aircraftRating, manufacturer, sortation) {
        var editForm = document.querySelector('.edit-form');
        editForm.style.display = 'block';

        document.getElementById('update_id').value = id;
        document.getElementById('new_airplaneName').value = '<?php echo $airplaneName; ?>';
        document.getElementById('new_aircraftRating').value = '<?php echo $aircraftRating; ?>';
        document.getElementById('new_manufacturer').value = '<?php echo $manufacturer; ?>';
        document.getElementById('new_sortation').value = '<?php echo $sortation; ?>';
    }
</script>
</body>

</html>
