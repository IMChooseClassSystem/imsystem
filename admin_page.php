<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"
        integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script type="text/javascript">
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

    function checknewpassword() {
        if ($('#new_passwd').val() != $('#new_passwd_again').val()) {
            $('#check_new_pass').show();
        } else {
            $('#check_new_pass').hide();
        }
    }

    function deleteCurriculum(curriculum_id) {
        $check_result = window.confirm('確定要刪除嗎');
        if ($check_result == true) {
            $.ajax({
                type: 'POST',
                url: "class.php",
                data: {
                    ID: curriculum_id
                },
                success: function(res) {
                    alert("刪除成功!");
                    location.reload();
                }
            });
        }

    }

    function select_teacher_info() {
        $.ajax({
            type: 'POST',
            url: "class.php",
            data: {
                teacher_name: $('#teacher_name').val()
            },
            success: function(res) {
                res = JSON.parse(res);
                if (res["name"] == $('#teacher_name').val()) {
                    $('#teacher_account').val(res["account"]);
                    $('#teacher_password').val(res["password"]);
                    $('#teacher_password').attr("type", "password");
                    $('#check_teacher').html("<p style=\"color:green\">查詢成功")
                } else {
                    $('#teacher_account').val("");
                    $('#teacher_password').val("");
                    $('#check_teacher').html("<p style=\"color:red\">查詢失敗，請輸入正確導師姓名")
                }

            }
        });
    }



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
        $('.sortby').click(function() {
            $('#sort').val($(this).attr("name"));
            $('#kind_value').val($('[name=kind]').val());
            $('#class_value').val($('[name=class]').val());
            $('#ascdesc').val(ascdesc_n);
            $('#showInfo').submit();
        });
        $("#toggle-password").click(function() {
            var input = $("#teacher_password");
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }

        });
    }

    $(document).ready(init);
    </script>
</head>

<body>
    <form action="admin_page.php" method="GET" id="showInfo">
        <input type="hidden" id="kind_value" name="kind_value" />
        <input type="hidden" id="class_value" name="class_value" />
        <input type="hidden" id="sort" name="sort" value="false" />
        <input type="hidden" id="page" name="page" value=1 />
        <input type="hidden" id="ascdesc" name="ascdesc" value="ASC" />
    </form>

    <?php include("class.php");?>

    <div class="container-fluid">
        <header class="blog-header py-3">
            <div class="row flex-nowrap justify-content-between align-items-center">
                <!-- <div class="col-4 pt-1">
          <a class="text-muted" href="#">Subscribe</a>
        </div> -->
                <div class="col-4 text-Left">
                    <h2 class="blog-header-logo text-dark">教師授課意願系統</h2>
                </div>
                <div class="col text-right">

                    <a class="btn btn-outline-secondary" href="export_excel.php"
                        style="margin-right: 10px;">儲存志願序Excel</a>
                    <button type=" button" class="btn btn-primary" data-toggle="modal" data-target="#selectpassword"
                        data-whatever="@getbootstrap" style="margin-right: 10px;">查詢教師密碼</button>
                    <button type=" button" class="btn btn-primary" data-toggle="modal" data-target="#editpassword"
                        data-whatever="@getbootstrap" style="margin-right: 10px;">修改密碼</button>
                    <a class="btn btn-outline-secondary" href="login.php?logout=1">登出</a>
                </div>

            </div>

        </header>

        <div class="row py-1 mb-4">
            <div class="col">
                學制
                <select class="form-control" id="kind" name="kind">
                    <option value="0">--</option>
                    <?php
                foreach ($kind_result as $row) {
                    if (!empty($_GET["kind_value"]) && $row["kind_ID"] == $_GET["kind_value"]) {
                ?>
                    <option value="<?= $row["kind_ID"] ?>" selected> <?= $row["kind_name"] ?></option>
                    <?php } else { ?>
                    <option value=<?= $row["kind_ID"] ?>><?= $row["kind_name"] ?></option>
                    <?php }
                } ?>
                </select>
            </div>
            <div class="col">
                班級
                <select class="form-control" id="class" name="class">
                    <option value="0">--</option>
                    <?php
                if(!empty($class_result)){
                foreach ($class_result as $row) {
                    if ($row["class_ID"] == $_GET["class_value"]) {
                ?>
                    <option value="<?= $row["class_ID"] ?>" selected> <?= $row["class_name"] ?></option>
                    <?php } else { ?>
                    <option value=<?= $row["class_ID"] ?>><?= $row["class_name"] ?></option>
                    <?php }
                }} ?>
                </select>
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
                        <th scope="col"> 操作</th>
                    </tr>
                </thead>
                <tbody id="classInfoBody">
                    <?php foreach ($result as $row) { 
                        $curriculum_id = $row["ID"];?>
                    <tr>
                        <td scope="row">
                            <?= $row["ROW_ID"]; ?></td>
                        <td><?= $row["course"]; ?></td>
                        <td><?= $row["outkind"]; ?></td>
                        <td><?= $row["kind_name"]; ?></td>
                        <td><?= $row["class_name"]; ?></td>
                        <td><?= $row["curriculum"]; ?></td>
                        <?php sem_credit_maker($row["kindyear"], $row["creditUP"], $row["creditDN"], $row["hourUP"], $row["hourDN"], $row["hourTUP"], $row["hourTDN"]); ?>
                        <td><?= $row["teacherList"]; ?></td>
                        <td><button onclick="deleteCurriculum(<?=$curriculum_id?>)">刪除</button></td>
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
                        <?php page_maker($pages, $page); ?>

                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!--修改密碼區塊 -->
        <div class="modal fade" id="editpassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">修改密碼</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="login.php" method="POST">
                        <div class="modal-body text-left">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">請輸入舊密碼:</label>
                                <input type="password" class="form-control" id="old_passwd" name="old_passwd"
                                    placeholder="" oninput="checkpassword()">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">設定您的新密碼:</label>
                                <input type="password" class="form-control" id="new_passwd" oninput="checknewpassword()"
                                    name="new_passwd" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">再次輸入新密碼:</label>
                                <input type="password" class="form-control" id="new_passwd_again"
                                    name="new_passwd_again" placeholder="" oninput="checknewpassword()">
                                <div id="check_new_pass" name="check_new_pass" style="color:red;">
                                    與新密碼不相符
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                            <input type="submit" class="btn btn-primary" value="確認">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--修改密碼區塊 -->

        <!--查詢密碼 -->
        <div class="modal fade" id="selectpassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabe2"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabe2">查詢教師密碼</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">請輸入導師姓名:</label>
                            <input type="text" class="form-control" id="teacher_name" name="teacher_name">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">導師帳號:</label>
                            <input type="text" class="form-control" id="teacher_account" name="teacher_account"
                                value="">
                        </div>
                        <div class="form-group ">

                            <label for="recipient-name" class="col-form-label">導師密碼:</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="teacher_password"
                                    aria-describedby="toggle-password" name="teacher_password" value="">
                                <button class="btn btn-outline-secondary" id="toggle-password"><i
                                        class="bi bi-eye-slash"></i></button>
                            </div>

                        </div>
                        <div id="check_teacher" name="check_teacher">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary" onclick="select_teacher_info()">查詢</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">完成</button>

                    </div>

                </div>
            </div>
        </div>
        <!--修改密碼區塊 -->

</body>

</html>