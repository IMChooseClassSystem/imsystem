<!DOCTYPE html>
<html lang="zh-tw">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous" />
  <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
  <script type="text/javascript">
    function init() {
      $('#kind').change(function() {
        location.href = "/imsystem/admin_page.php?" + 'kind=' + $('[name=kind]').val();
      });
      $('#class').change(function() {
        location.href = "/imsystem/admin_page.php?" + 'kind=' + $('[name=kind]').val() + '&class=' + $('[name=class]').val();
      });
    }
    $(document).ready(init);
  </script>
</head>
<div class="container-fluid">
  <header class="blog-header py-3">
    <div class="row flex-nowrap justify-content-between align-items-center">
      <div class="col-4 text-Left">
        <h2 class="blog-header-logo text-dark">教師授課意願系統</h2>
      </div>
      <div class="col-4 d-flex justify-content-end align-items-center">
        <a class="btn btn-sm btn-outline-secondary" href="login.html">登出</a>
      </div>
    </div>
  </header>
  <?php
  include("dbconnection.php");
  include("admin_page_function.php");
  ?>
  <div class="row py-1 mb-4">
    <div class="col">
      學制
      <?php //學制選單
      $kind_sql = "SELECT * FROM kind_info";
      $kind_result = query_sql($conn, $kind_sql);
      echo "<select class=\"form-control\" name=\"kind\" id=\"kind\">";
      foreach ($kind_result as $row) {
        if ($row["kind_ID"] == $_GET["kind"])
          echo "<option value='" . $row["kind_ID"] . "' selected>" . $row["kind_name"] . "</option>";
        else
          echo "<option value='" . $row["kind_ID"] . "'>" . $row["kind_name"] . "</option>";
      }
      echo "</select>";
      ?>

    </div>
    <div class="col">
      班級
      <?php //班級選單
      $class_sql = "SELECT * FROM class_info WHERE kind_ID=" . $_GET["kind"];
      $class_result = query_sql($conn, $class_sql);
      echo "<select class=\"form-control\" name=\"class\" id=\"class\">";
      foreach ($class_result as $row) {
        if ($row["class_ID"] == $_GET["class"])
          echo "<option value='" . $row["class_ID"] . "' selected>" . $row["class_name"] . "</option>";
        else
          echo "<option value='" . $row["class_ID"] . "'>" . $row["class_name"] . "</option>";
      }
      echo "</select>";
      ?>
    </div>
    <div class="col-1">
      <a class="btn btn-outline-secondary btn-lg m-auto" href="">查詢</a>
    </div>
  </div>
  <?php
  $courseInfo_sql = "SELECT * FROM curriculum C LEFT JOIN kind_info K on C.kind=K.kind_ID WHERE getyear=" . $_GET["class"] . "and kind=" . $_GET["kind"];
  $course_result = query_sql($conn, $courseInfo_sql);
  ?>
  <div class="card w-auto p-3 mb-4 bg-light text-center">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">修別</th>
          <th scope="col">系所</th>
          <th scope="col">學制</th>
          <th scope="col">年級</th>
          <th scope="col">課程名稱</th>
          <th scope="col">學年 / 學期</th>
          <th scope="col">學分</th>
          <th scope="col">時數</th>
          <th scope="col">教師列表</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($course_result as $row) {
        ?>
          <tr>

            <td scope="row"><?php echo $row["ID"]; ?></td>
            <td><?php echo $row["course"]; ?></td>
            <td><?php echo $row["outkind"]; ?></td>
            <td><?php echo $row["kind_name"]; ?></td>
            <td><?php echo $row["getyear"]; ?></td>
            <td><?php echo $row["curriculum"]; ?></td>
            <td><?php echo $row["kindyear"]; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <div class="row mb-2">
    <div class="col-md-6">
      <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
          <strong class="d-inline-block mb-2 text-primary">World</strong>
          <h3 class="mb-0">Featured post</h3>
          <div class="mb-1 text-muted">Nov 12</div>
          <p class="card-text mb-auto">
            This is a wider card with supporting text below as a natural
            lead-in to additional content.
          </p>
          <a href="#" class="stretched-link">Continue reading</a>
        </div>
        <div class="col-auto d-none d-lg-block">
          <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="#55595c"></rect>
            <text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
          </svg>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
          <strong class="d-inline-block mb-2 text-success">Design</strong>
          <h3 class="mb-0">Post title</h3>
          <div class="mb-1 text-muted">Nov 11</div>
          <p class="mb-auto">
            This is a wider card with supporting text below as a natural
            lead-in to additional content.
          </p>
          <a href="#" class="stretched-link">Continue reading</a>
        </div>
        <div class="col-auto d-none d-lg-block">
          <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="#55595c"></rect>
            <text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
          </svg>
        </div>
      </div>
    </div>
  </div>
</div>

</html>