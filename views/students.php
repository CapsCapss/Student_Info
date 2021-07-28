<?php


include 'database/SimpleXLSX.php';

require "database/connect.php";

include_once "database/queries.php";

$queries = new Queries();
$d = $queries->getData();

if(isset($_POST["submit"]))
{

          $file = $_FILES['file']['tmp_name'];
          $xlsx = new SimpleXLSX($file);
          $fp = fopen( 'file.csv', 'w');
          foreach( $xlsx->rows() as $fields ) {
                fputcsv( $fp, $fields);
          }
          fclose($fp);

          $fo = fopen('file.csv', 'r');

          $c = 0;
          while(($filesop = fgetcsv($fo, 1000, ",")) !== false)
        {

          if ($c++ == 0) continue;
          $lname = $filesop[0];
          $fname = $filesop[1];
          $mname = $filesop[2];
          $course = $filesop[3];
          $sql = "INSERT INTO students(LAST_NAME, FIRST_NAME, MIDDLE_NAME, COURSE) VALUES ('$lname','$fname', '$mname', '$course')";
          $statement = $connection->prepare($sql);
          $statement->execute();

         $c = $c + 1;
           }

        header("Location: /studentInfo");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel to DB</title>
</head>
<body>
    

    <div class="container">
        <div class="mt-5">
            <h1>Excel file to Database</h1>
            <form method="post" role="form" enctype="multipart/form-data">
            <div class="form-group">
                <input type="file" name="file" id="file" size="150">
                <p class="help-block">Only Excel/CSV File Import.</p>
            </div>
                <button type="submit" class="btn btn-secondary" name="submit" value="submit">Submit</button>
            </form>
        </div>

        <table class="table mt-3">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Last_Name</th>
          <th scope="col">First_Name</th>
          <th scope="col">Middle_Name</th>
          <th scope="col">Course</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($d as $a): ?>
        <tr>
          <td><?= $a->ID; ?></td>
          <td><?= $a->LAST_NAME; ?></td>
          <td><?= $a->FIRST_NAME; ?></td>
          <td><?= $a->MIDDLE_NAME; ?></td>
          <td><?= $a->COURSE; ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    </div>

</body>
</html>