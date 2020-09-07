<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

        td {
            padding-right:20px;
        }

        h1, h3 {
            color:#42006e;
        }

    </style>
</head>

<body>
<h1>Welcome to {{$patient->assignedClinic->name}}!</h1>
<h3>Your patient account has been created.</h3>
<table>
<tbody>
    <tr>
        <td><strong>Patient Name </strong></td>
        <td>{{$patient->first_name}} {{$patient->last_name}}</td>
    </tr>
    <tr>
        <td><strong>Date of Birth </strong></td>
        <?php 
        $mysql_Dob = strtotime($patient['date_of_birth']);
        $fromatted_Dob = date("m/d/Y", $mysql_Dob);
        echo "<td>$fromatted_Dob</td>";
        ?>
    </tr>
    <tr>
        <td><strong>Patient's Email </strong></td>
        <td>{{$patient->email}}</td>
    </tr>
    <tr>
        <td><strong>Registered By </strong></td>
        <td>{{$patient->createdBy->first_name}} {{$patient->createdBy->last_name}}</td>
    </tr>
    <tr>
        <td><strong>Registration Date </strong></td>
        <?php 
        $mysql_Date = strtotime($patient['created_at']);
        $fromatted_Date = date("m/d/Y g:i A", $mysql_Date);
        echo "<td>$fromatted_Date</td>";
        ?>
    </tr>
</tbody>
</table>    
</body>
</html>