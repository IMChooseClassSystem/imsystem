<!DOCTYPE html>
<html>

<head>
    <title>首頁</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body class="text-center">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="home.html">
            <img src="pic\1.png" width="30" height="30" class="d-inline-block align-top" alt="">
            教師選課意願系統
        </a>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="test.html">Sign out</a>
            </li>
        </ul>
    </nav>
    <table>
        <?php
        include("dbconnection.php");
        $query_courseInformation = "SELECT * FROM curriculum";
        $stmt = $conn->prepare($query_courseInformation);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
        ?>
            <tr>
                <td><?php echo $row["ID"];?></td>
                <td><?php echo $row["course"];?></td>
                <td><?php echo $row["getyear"];?></td>
                <td><?php echo $row["curriculum"];?></td>
                <td><?php echo $row["kindyear"];?></td>
                <td><?php echo $row["creditUP"];?></td>
                <td><?php echo $row["creditDN"];?></td>
                <td><?php echo $row["hourUP"];?></td>
                <td><?php echo $row["hourDN"];?></td>
                <td><?php echo $row["hourTUP"];?></td>
                <td><?php echo $row["hourTDN"];?></td>
                <td><?php echo $row["kind"];?></td>
                <td><?php echo $row["outkind"];?></td>


            </tr>
        <?php } ?>

    </table>




</body>

</html>