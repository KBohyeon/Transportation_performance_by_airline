<!DOCTYPE html>
<html lang="ko">
<?php
ini_set('display_errors', '0');
include "db_conn.php";

// 초기값 선택 삭제를 위해 입력 내용 폼에 저장
$airlineNum = '';
$airlineName = '';
$Icao = '';
$Iata = '';

// 초기화된 $result 변수
$result = mysqli_query($conn, "SELECT * FROM airline");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete_id'])) {
    $deleteId = mysqli_real_escape_string($conn, $_GET['delete_id']);
    $deleteQuery = "DELETE FROM airline WHERE airlineNum = '$deleteId'";
    mysqli_query($conn, $deleteQuery);

    // 초기화된 $result 변수
    $result = mysqli_query($conn, "SELECT * FROM airline");
}

// 항공사 정보 수정 기능 추가
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_id'])) {
    $editId = mysqli_real_escape_string($conn, $_POST['edit_id']);
    $editQuery = "SELECT * FROM airline WHERE airlineNum = '$editId'";
    $editResult = mysqli_query($conn, $editQuery);

    if ($editResult) {
        $editRow = mysqli_fetch_assoc($editResult);
        $airlineNum = $editRow['airlineNum'];
        $airlineName = $editRow['airlineName'];
        $Icao = $editRow['Icao'];
        $Iata = $editRow['Iata'];
    }
}

// 항공사 정보 업데이트 기능 추가
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $updateId = mysqli_real_escape_string($conn, $_POST['update_id']);
    $newAirlineName = mysqli_real_escape_string($conn, $_POST['new_airlineName']);
    $newIcao = mysqli_real_escape_string($conn, $_POST['new_Icao']);
    $newIata = mysqli_real_escape_string($conn, $_POST['new_Iata']);

    $updateQuery = "UPDATE airline 
                    SET airlineName = '$newAirlineName', 
                        Icao = '$newIcao', 
                        Iata = '$newIata' 
                    WHERE airlineNum = '$updateId'";
    mysqli_query($conn, $updateQuery);

    // 초기화된 $result 변수
    $result = mysqli_query($conn, "SELECT * FROM airline");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 폼으로부터 받은 검색어
    $airlineNum = isset($_POST['airlineNum']) ? mysqli_real_escape_string($conn, $_POST['airlineNum']) : '';
    $airlineName = isset($_POST['airlineName']) ? mysqli_real_escape_string($conn, $_POST['airlineName']) : '';
    $Icao = isset($_POST['Icao']) ? mysqli_real_escape_string($conn, $_POST['Icao']) : '';
    $Iata = isset($_POST['Iata']) ? mysqli_real_escape_string($conn, $_POST['Iata']) : '';

    // 데이터 수행 쿼리문 생성
    $query = "SELECT * FROM airline WHERE 
              airlineNum LIKE '%$airlineNum%' AND
              airlineName LIKE '%$airlineName%' AND
              Icao LIKE '%$Icao%' AND
              Iata LIKE '%$Iata%'";
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
    $deleteAllQuery = "DELETE FROM airline";
    mysqli_query($conn, $deleteAllQuery);

    // 초기화된 $result 변수
    $result = mysqli_query($conn, "SELECT * FROM airline");
}

// 선택 삭제 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_selected'])) {
    // 선택 삭제 쿼리문 
    $deleteSelectedQuery = "DELETE FROM airline WHERE 
                    airlineNum LIKE '%$airlineNum%' AND
                    airlineName LIKE '%$airlineName%' AND
                    Icao LIKE '%$Icao%' AND
                    Iata LIKE '%$Iata%'";
    mysqli_query($conn, $deleteSelectedQuery);

    $query = "SELECT * FROM airline WHERE 
              airlineNum LIKE '%$airlineNum%' AND
              airlineName LIKE '%$airlineName%' AND
              Icao LIKE '%$Icao%' AND
              Iata LIKE '%$Iata%'";
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
        <h2>Airline 테이블 조회</h2>
        <h4>
            <a href='./db_start.html'>돌아가기</a>
        </h4>
        <!-- 검색 -->
        <form method="POST" action="">
            <div class="form-row">
                 <div class="col-md-2">
                    <label for="airlineNum">항공사 번호:</label>
                    <input type="text" class="form-control" name="airlineNum" id="airlineNume" value="<?php echo $airlineNum; ?>">
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
                <tr>
                    <th>항공사 번호</th>
                    <th>항공사명</th>
                    <th>Icao</th>
                    <th>Iata</th>
                    <th>수정</th>
                    <th>삭제</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_array($result)) {
                    $airlineNum = $row['airlineNum'];
                    $airlineName = $row['airlineName'];
                    $Icao = $row['Icao'];
                    $Iata = $row['Iata'];
                ?>
                    <tr>
                        <td><?php echo $airlineNum; ?></td>
                        <td><?php echo $airlineName; ?></td>
                        <td><?php echo $Icao; ?></td>
                        <td><?php echo $Iata; ?></td>
                        <td>
                            <!-- 수정 버튼 -->
                            <button class="btn btn-sm btn-info" onclick="showEditForm('<?php echo $airlineNum; ?>')">수정</button>
                        </td>
                        <td><a href="?delete_id=<?php echo $airlineNum; ?>" class="btn btn-sm btn-danger">삭제</a></td>
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
        document.getElementById('new_airlineName').value = '<?php echo $airlineName; ?>';
        document.getElementById('new_Icao').value = '<?php echo $Icao; ?>';
        document.getElementById('new_Iata').value = '<?php echo $Iata; ?>';
    }
</script>
</body>
</html>
