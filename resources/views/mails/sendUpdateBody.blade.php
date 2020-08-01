<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Triage Translation</title>

 
</head>

<body>
<h1>User Profile Update Notification</h1>
<h2>Your user profile has been updated by {{$user -> first_name}}.</h2>
<h2>Updated user profile details:</h2>
<table>
    <tbody>
        <tr>
            <td>
            <strong>
                First Name:
            </strong>
            </td>
                {{$users -> first_name}} 
            <td>
            </td>            
        </tr>
        <tr>
            <td>
            <strong>
                Last Name:
            </strong>
            </td>
                {{$users -> last_name}} 
            <td>
            </td>            
        </tr>
        <tr>
            <td>
            <strong>
                Email:
            </strong>
            </td>
                {{$users -> email}} 
            <td>
            </td>            
        </tr>
        <tr>
            <td>
            <strong>
                Position:
            </strong>
            </td>
                {{$users -> position}} 
            <td>
            </td>            
        </tr>
        <tr>
            <td>
            <strong>
                Access Type:
            </strong>
            </td>
                {{$users -> access_type}} 
            <td>
            </td>            
        </tr>
        <tr>
            <td>
            <strong>
                Last Updated:
            </strong>
            </td>
                {{$users -> updated_at}} 
            <td>
            </td>            
        </tr>
    </tbody>
</table>
<br><br>

</body>

</html>