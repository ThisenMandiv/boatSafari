<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details Form</title>
    <link rel="stylesheet" href="./css/insert.css">
</head>
<body>

    <h1>Insert User Details</h1>

    <form action="./insert.inc.php" method="post">
        <label for="name">User Name:</label><br>
        <input type="text" id="name" name="name" required ><br><br>

        <label for="gmail">User Gmail:</label><br>
        <input type="email" id="email" name="email" required ><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Submit</button>
    </form>

</body>
</html>