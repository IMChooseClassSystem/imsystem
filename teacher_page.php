<?php session_start(); //啟動Session?>
<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous" />
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script language="javascript">
var count = 1;

function choose_class() {
    // document.getElementById("chooseTable").insertRow(1).insertCell(0);
    var choose_class_CB = document.getElementsByName("CC_CB");
    var class_ID = [];

    for (i = 1; i <= choose_class_CB.length; i++) {
        if (choose_class_CB[i - 1].checked) {
            var row = document.getElementById("chooseTable").insertRow(count);
            row.insertCell(0).innerHTML = count;
            for (j = 1; j <= 6; j++) {
                row.insertCell(j).innerHTML = document.getElementById("classTable").rows[i].cells.item(j).innerHTML;

            }
            count++;
            choose_class_CB[i - 1].checked = false;
        }
    }

    $.ajax({
        type: 'POST',
        url: "orderlist.php",
        data: {
            classID: class_ID
        },
        success: function(res) {
            console.log(res)
        }
    });

}
</script>
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
        <div class="col-auto">
            <a class="btn btn-outline-secondary btn-lg m-auto" href="">查詢</a>
        </div>
    </div>

    <div class="row">
        <div class="col ">
            <div class="card mb-2">
                <div class="card-body text-center">
                    <table class="table table-striped table-sm" id="classTable">
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as  $row) { ?>
                            <tr>
                                <td><input name="CC_CB" type="checkbox" id="<?php echo $row["ID"]?>"></td>
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
        </div>
        <div class="col-auto align-self-center ">
            <div class="col">
                <button type="button" class="btn btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                        class="bi bi-arrow-up-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 0 0 8a8 8 0 0 0 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z" />
                    </svg>
                </button>
                <div class="w-100 my-4"></div>
                <button type="button" class="btn btn-success" onclick="choose_class()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                        class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                    </svg>
                </button>
                <div class="w-100 my-4"></div>
                <button type="button" class="btn btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                        class="bi bi-arrow-down-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
        <div class="col">
            <div class="card mb-2">
                <div class="card-body text-center">
                    <table class="table table-striped table-sm" id="chooseTable">
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
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

</html>