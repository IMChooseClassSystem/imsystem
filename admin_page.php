<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous" />
</head>
<?php include("class.php")?>
<div class="container-fluid">
    <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
            <!-- <div class="col-4 pt-1">
          <a class="text-muted" href="#">Subscribe</a>
        </div> -->
            <div class="col-4 text-Left">
                <h2 class="blog-header-logo text-dark">教師授課意願系統</h2>
            </div>
            <div class="col-4 d-flex justify-content-end align-items-center">
                <!-- <a class="text-muted" href="#" aria-label="Search">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="mx-3" role="img" viewBox="0 0 24 24" focusable="false"><title>Search</title><circle cx="10.5" cy="10.5" r="7.5"></circle><path d="M21 21l-5.2-5.2"></path></svg>
          </a> -->
                <a class="btn btn-sm btn-outline-secondary" href="">登出</a>
            </div>
        </div>
    </header>

    <div class="row py-1 mb-4">
        <div class="col">
            學制
            <select class="form-control" id="kind">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>
        <div class="col">
            班級
            <select class="form-control" id="calss"></select>
        </div>
        <div class="col-1">
            <a class="btn btn-outline-secondary btn-lg m-auto" href="">查詢</a>
        </div>
    </div>

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
                <?php foreach ($result as $row) { ?>
                <tr>
                    <td scope="row"><?php echo $row["ID"];?></td>
                    <td><?php echo $row["course"];?></td>
                    <td><?php echo $row["outkind"];?></td>
                    <td><?php echo $row["kind"];?></td>
                    <td><?php echo $row["getyear"];?></td>
                    <td><?php echo $row["curriculum"];?></td>
                    <td><?php echo $row["kindyear"];?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="row justify-content-center ">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php for($i=1;$i<=$pages;$i++){
                                echo "<li class='page-item'><a class='page-link' href=?page=".$i.">$i</a><li>";
                            }?>

                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

</html>