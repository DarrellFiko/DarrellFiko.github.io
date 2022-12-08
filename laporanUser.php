<?php
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=UserReport_SoccerSportStation.xls");
header("Pragma: no-cache");
header("Expires: 0");

require_once 'functions.php';

$output = "";

$output .= "
		<table border='1'>
			<thead>
				<tr>
					<th>ID User</th>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Nomor Telepon</th>
                    <th>Password</th>
                    <th>Status User</th>
				</tr>
			<tbody>
	";

$data = query("SELECT * FROM user");
foreach ($data as $key => $value) {
    $tempStatus = $value["status_user"];
    if ($tempStatus == 1) {
        $status = "Active";
    } else if ($tempStatus == 0) {
        $status = "Inactive";
    }

    $output .= "
				<tr>
					<td>" . $value["id_user"] . "</td>
                    <td>" . $value["username"] . "</td>
                    <td>" . $value["full_name"] . "</td>
                    <td>" . $value["email"] . "</td>
                    <td>" . $value["alamat"] . " pcs</td>
                    <td>" . $value["nomor_telepon"] . "</td>
                    <td>" . $value["password"] . "</td>
                    <td>" . $status . "</td>
				</tr>
	";
}

$output .= "
			</tbody>
 
		</table>
	";

echo $output;

// echo "<script>document.location.href = 'admin.php'</script>";
