<!DOCTYPE html>
<html>

<head>
    <title>Berhasil</title>
</head>

<body>

    <h2>Register Berhasil</h2>

    <table border="1" cellpadding="10">
        <tr>
            <td>First Name</td>
            <td>{{ $data['first_name'] }}</td>
        </tr>

        <tr>
            <td>Last Name</td>
            <td>{{ $data['last_name'] }}</td>
        </tr>

        <tr>
            <td>Username</td>
            <td>{{ $data['username'] }}</td>
        </tr>

        <tr>
            <td>Email</td>
            <td>{{ $data['email'] }}</td>
        </tr>

        <tr>
            <td>Password</td>
            <td>{{ $data['password'] }}</td>
        </tr>
    </table>

</body>

</html>