<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script type="text/javascript">
    /*function sort_data($sortBy) {
        $.ajax({
            type: 'GET',
            url: "admin_page.php",
            data: {
                sort: $sortBy
            },
            success: function(res) {
                alert("sucess")
                console.log(res)
            }
        });
    }*/
    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
        return false;
    };
    var sort = getUrlParameter('sort');
    var ascdesc_o = getUrlParameter('ascdesc');
    if (ascdesc_o == "ASC") {
        ascdesc_n = "DESC";
    } else {
        ascdesc_n = "ASC";
    }

    // var sort = "";

    function init() {
        $('#kind').change(function() {
            $('#kind_value').val($('[name=kind]').val());
            $('#showInfo').submit();
        });
        $('#class').change(function() {
            $('#kind_value').val($('[name=kind]').val());
            $('#class_value').val($('[name=class]').val());
            $('#showInfo').submit();

        });
        $('.page-item').click(function() {
            $('#sort').val(sort);
            $('#kind_value').val($('[name=kind]').val());
            $('#class_value').val($('[name=class]').val());
            $('#page').val($(this).val());
            $('#ascdesc').val(ascdesc_o);
            $('#showInfo').submit();

        });
        $('.sortby').click(function(event) {
            $('#sort').val($(this).attr("name"));
            $('#kind_value').val($('[name=kind]').val());
            $('#class_value').val($('[name=class]').val());
            $('#ascdesc').val(ascdesc_n);
            $('#showInfo').submit();

        });
        // console.log(sort)
    }

    $(document).ready(init);
    </script>
</head>
<form action="admin_page.php" method="GET" id="showInfo">
    <input type="hidden" id="kind_value" name="kind_value" />
    <input type="hidden" id="class_value" name="class_value" />
    <input type="hidden" id="sort" name="sort" value="false" />
    <input type="hidden" id="page" name="page" value=1 />
    <input type="hidden" id="ascdesc" name="ascdesc" value="ASC" />
</form>

<?php include("class.php");
?>
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
            <select class="form-control" id="kind" name="kind">
                <option value="0">--</option>
                <?php 
                    foreach ($kind_result as $row){
                    if ($row["kind_ID"] == $_GET["kind_value"]){
                ?>
                <option value="<?= $row["kind_ID"]?>" selected> <?= $row["kind_name"]?></option>
                <?php }else {?>
                <option value=<?= $row["kind_ID"]?>><?=$row["kind_name"]?></option>
                <?php }  }?>
            </select>
        </div>
        <div class="col">
            班級
            <select class="form-control" id="class" name="class">
                <option value="0">--</option>
                <?php 
                    foreach ($class_result as $row){
                    if ($row["class_ID"] == $_GET["class_value"]){
                ?>
                <option value="<?= $row["class_ID"]?>" selected> <?= $row["class_name"]?></option>
                <?php }else {?>
                <option value=<?= $row["class_ID"]?>><?=$row["class_name"]?></option>
                <?php }  }?>
            </select>
        </div>
        <div class="col-1">
            <a class="btn btn-outline-secondary btn-lg m-auto" href="">查詢</a>
        </div>
    </div>

    <div class="card w-auto p-3 mb-4 bg-light text-center">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col"><a href="#" class="sortby" name="C.ID">#</th>
                    <th scope="col"><a href="#" class="sortby" name="course">修別</th>
                    <th scope="col">系所</th>
                    <th scope="col"><a href="#" class="sortby" name="kind">學制</th>
                    <th scope="col"><a href="#" class="sortby" name="class_name">班級</th>
                    <th scope="col"><a href="#" class="sortby" name="curriculum">課程名稱</th>
                    <th scope="col"><a href="#" class="sortby" name="kind_year">學年 / 學期（上/下)</th>
                    <th scope="col">學分</th>
                    <th scope="col">時數（上課/實習）</th>
                    <th scope="col"> 教師列表</th>
                </tr>
            </thead>
            <tbody id="classInfoBody">
                <?php foreach ($result as $row) { ?>
                <tr>
                    <td scope="row">
                        <?=$row["ROW_ID"];?></td>
                    <td><?=$row["course"];?></td>
                    <td><?=$row["outkind"];?></td>
                    <td><?=$row["kind_name"];?></td>
                    <td><?=$row["class_name"];?></td>
                    <td><?=$row["curriculum"];?></td>
                    <?php sem_credit_maker($row["kindyear"], $row["creditUP"], $row["creditDN"], $row["hourUP"], $row["hourDN"], $row["hourTUP"], $row["hourTDN"]); ?>
                    <td><?=$row["teacherList"];?></td>
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
                    <?php page_maker($pages, $page);?>

                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

</html>