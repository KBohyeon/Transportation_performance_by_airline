<h2>
            <a href='./db_start.html'>돌아가기</a>
        </h2>
<?php
	include 'db_conn.php';
	$file = $_POST['file'];
	echo "<p> 선택된 파일이름: $file <br /></p>\n";
	if(isset($_POST['submit'])) {

		$row = 0;
		if($file == "airline.csv"){ //파일이름 확인
			if (($users_file = fopen("./data/airline.csv", "r")) !== FALSE) {
				// Line-by-line 으로 읽기
				while (($data = fgetcsv($users_file, 1000, ',')) !== FALSE) {
					        // 첫 번째 행은 헤더로 사용하기에 헤더 다음행 부터 처리
							if ($row == 0) {
								$row++;
								continue;
							}
					// 한 행씩 읽어서 insert SQL 실행
					$num = count($data);
					echo "<p> $num fields in line: <br /></p>\n";
					
					for ($c = 0; $c < $num; $c++) {
						echo $data[$c] . "<br />\n";
					}
			
					$airlineNum = isset($data[0]) ? intval($data[0]) : ''; // Ensure it is an integer
					$airlineName = isset($data[1]) ? $data[1] : '';
					$Icao = isset($data[2]) ? $data[2] : '';
					$Iata = isset($data[3]) ? $data[3] : '';
					
					$query = "INSERT INTO airline (airlineNum, airlineName, Icao, Iata) 
							  VALUES ('" . $airlineNum . "', '" . $airlineName . "', '" . $Icao . "', '" . $Iata . "')";
					mysqli_query($conn, $query);
					echo "<p> Insert! <br /></p>\n";
				}
			
				fclose($users_file);
			}
			}
		
	

		if($file == "airplane.csv"){ //파일 이름 확인
			if (($users_file = fopen("./data/airplane.csv", "r")) !== FALSE) {
			
				//Line-by-line 으로 읽기
				while(($data = fgetcsv($users_file, 1000, ','))) {
					// 첫 번째 행은 헤더로 사용하기에 헤더 다음행 부터 처리
					if ($row == 0) {
						$row++;
						continue;
					}
					// 한 행씩 읽어서 insert sql 실행
					$num = count($data);
					echo "<p> $num fields in line $row: <br /></p>\n";
					$row++;
					for ($c=0; $c < $num; $c++) {
						echo $data[$c] . "<br />\n";
					}

					$serialNumber = isset($data[0]) ? intval($data[0]) : '';
					$airplaneName = isset($data[1]) ? $data[1] : '';
					$aircraftRating = isset($data[2]) ? $data[2] : '';
					$manufacturer = isset($data[3]) ? $data[3] : '';
					$sortation = isset($data[4]) ? $data[4] : '';
					$query="INSERT INTO airplane (serialNumber, airplaneName, aircraftRating, manufacturer, sortation) 
							VALUES ('".$serialNumber."', '".$airplaneName."', '".$aircraftRating."', '".$manufacturer."', '".$sortation."')";
					mysqli_query($conn, $query);
					echo "<p> Insert! <br /></p>\n";
				}
			}
		}

		if($file == "aviationinformation.csv"){ //파일 이름 확인
			if (($users_file = fopen("./data/aviationinformation.csv", "r")) !== FALSE) {
			
				//Line-by-line 으로 읽기
				while(($data = fgetcsv($users_file, 1000, ','))) {
					if ($row == 0) {
						$row++;
						continue;
					}
					// 한 행씩 읽어서 insert sql 실행
					$num = count($data);
					echo "<p> $num fields in line $row: <br /></p>\n";
					$row++;
					for ($c=0; $c < $num; $c++) {
						echo $data[$c] . "<br />\n";
					}

					$airlineId = isset($data[0]) ? intval($data[0]) : '';
					$domesticInternational = isset($data[1]) ? $data[1] : '';
					$stopoverAirport = isset($data[2]) ? $data[2] : '';
					$arrival_departure = isset($data[3]) ? $data[3] : '';
					$regular_irregularity = isset($data[4]) ? $data[4] : '';
					$cargo = isset($data[5]) ? intval($data[5]) : '';
					$airlineNum = isset($data[6]) ? intval($data[6]) : '';
					$cargoplane_airliner = isset($data[7]) ? $data[7] : '';
					$query="INSERT INTO aviationinformation (airlineId, domesticInternational, stopoverAirport, arrival_departure, regular_irregularity, cargo, airlineNum, cargoplane_airliner) 
							VALUES ('".$airlineId."', '".$domesticInternational."', '".$stopoverAirport."', '".$arrival_departure."', '".$regular_irregularity."', '".$cargo."', '".$airlineNum."', '".$cargoplane_airliner."')";
					mysqli_query($conn, $query);
					echo "<p> Insert! <br /></p>\n";
				}
				fclose($users_file);
			}
		}
		
		// fclose($users_file);
			//echo "Insert 성공"
		echo "<p> Insert 성공! <br /></p>\n";

	}  
?>