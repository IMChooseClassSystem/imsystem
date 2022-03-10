<?php session_start(); //啟動Session
?>
<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"
        integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous">
    </script>

</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script language="javascript">
var orderCount = 1;
var rowCount = 1;
var class_ID = [];
var memoryOrderlist = [];
var classTatal = 0;
window.onload = function() {
    var value = true;
    $.ajax({
        type: 'GET',
        url: "orderlist.php",
        data: {
            getOrderlist: value,

        },
        success: function(res) {
            value = false;
            // console.log(res)
            res = JSON.parse(res)
            $("#chooseTBody").html(res.orderListTable);
            class_ID = res.classIDArray;
            // console.log(class_ID.length)
            orderCount = class_ID.length;
            class_ID.forEach(function(element, index) {
                // console.log(element.classTotal)
                classTatal += element.classTotal;
            })
            $("#classTotal").text("已選 " + classTatal + " 學分")


        }
    });

    // var load = true;
    $.ajax({
        type: "GET",
        url: "showClass.php",
        data: {
            ajaxPost: "pageLoading"
        },
        success: function(res) {
            // console.log(res)
            res = JSON.parse(res);
            // console.log(res)
            $("#classTBody").html(res.classTable);
            $("#page").html(res.pages);
        }
    });
}

function choose_class() {
    var choose_class_CB = document.getElementsByName("CC_CB");

    choose_class_CB.forEach(function(element, index) {
        var inArray = class_ID.filter(e => e.classID === element.id).length > 0;
        if (element.checked && inArray != true) {

            var tr = element.parentElement.parentElement;
            classTatal += parseInt(tr.childNodes[7].textContent)
            console.log(classTatal)
            orderCount++;
            class_ID.push({
                sequence: orderCount,
                classID: element.id,
                rowPosition: index
            });

            $("#chooseTBody").append($(tr).clone().attr("onclick", "trClick(this)"));
            $("#chooseTBody tr").last().find("td:first").remove();
            $("#chooseTBody tr").last().prepend("<td>" + orderCount + "</td>");
            $("#chooseTBody tr").last().prepend(
                "<td><button type='button' class='btn btn-sm bg-transparent'><img src='pic/close.png' alt='Flower' onclick='deleteRow(this)'></button></td>"
            )

        }
        element.checked = false;
    });

    $("#classTotal").text("已選 " + classTatal + " 學分")
    // console.log(class_ID)

}

// function choose_class() {
//     var choose_class_CB = $("input:checked[name='CC_CB']");
//     // console.log(choose_class_CB.length)
//     // add checked row

//     choose_class_CB.each(function(index, element) {
//         // console.log(element.parentElement.parentElement)
//         var tr = element.parentElement.parentElement;

//         // console.log($(tr).find("td:first").remove())
//         $("#chooseTBody").append($(tr).clone())

//         // if (element.checked && isInArray(element.id) != true) {
//         //     class_ID.push({
//         //         sequence: orderCount,
//         //         classID: element.id,
//         //         rowPosition: index
//         //     });
//         //     orderCount++;
//         // }
//         // element.checked = false;
//     });
//     $("#chooseTBody > tr").slice(-choose_class_CB.length).each(function(index, element) {
//         orderCount++;
//         // console.log(element)
//         class_ID.push({
//             sequence: orderCount,
//             classID: element.id,
//         });

//         $(element).find("td:first").remove();
//         $(element).prepend("<td>" + orderCount + "</td>");
//         $(element).prepend(
//             "<td><button type='button' class='btn btn-sm bg-transparent'><img src='pic/close.png' alt='Flower' onclick='deleteRow(this)'></button></td>"
//         )
//     });
//     console.log(choose_class_CB)
//     // insertTableRow();

// }

// function insertTableRow() {
//     for (i = rowCount; i <= class_ID.length; i++) {
//         var tbodyRef = document.getElementById("chooseTable").getElementsByTagName("tbody")[0];
//         // Insert a row at the end of table
//         var newRow = tbodyRef.insertRow();
//         newRow.setAttribute("onclick", "trClick(this)")
//         // Insert a cell at the end of the row
//         var newCell = newRow.insertCell();
//         //Insert delete button at td
//         var newDelBtn = document.createElement("Button");
//         newDelBtn.setAttribute("type", "button");
//         newDelBtn.setAttribute("class", "btn btn-sm bg-transparent");
//         //Insert delete img at button
//         var newImg = document.createElement("img");
//         newImg.setAttribute("src", "pic/close.png");
//         newImg.setAttribute("alt", "Flower");
//         newImg.setAttribute("onclick", "deleteRow(this)");
//         newDelBtn.appendChild(newImg);
//         newCell.append(newDelBtn);

//         // Append a text node to the cell
//         newCell = newRow.insertCell();
//         var newText = document.createTextNode(rowCount);
//         newCell.appendChild(newText);

//         console.log(class_ID[rowCount - 1].rowPosition)
//         for (j = 1; j <= 6; j++) {
//             newCell = newRow.insertCell();
//             newText = document.createTextNode(document.getElementById("classTable").rows[class_ID[rowCount - 1]
//                     .rowPosition + 1].cells.item(j)
//                 .innerHTML);
//             newCell.appendChild(newText);
//         }
//         rowCount++;
//     }
// }
var keep = null;

function trClick(row) {
    if (keep == null) {
        row.setAttribute("class", "table-warning")
    } else if (row != keep) {
        row.setAttribute("class", "table-warning");
        keep.removeAttribute("class", "table-warning");
    }
    keep = row;
}

function deleteRow(row) {
    var delRow = row.parentNode.parentNode.parentNode;
    var delSequence = delRow.childNodes[1].textContent;
    // console.log(delRow)
    delRow.remove();
    var tr = document.getElementById("chooseTable").getElementsByTagName("tbody")[0].getElementsByTagName("tr");
    // console.log(tr.length)
    class_ID.forEach(function(item, index, array) {
        if (item.sequence == delSequence) {
            array.splice(index, 1);
        }
    });
    for (i = 0; i < tr.length; i++) {
        // console.log(tr[i].childNodes[1].textContent)
        if (parseInt(tr[i].childNodes[1].textContent) > delSequence) {

            tr[i].childNodes[1].textContent = tr[i].childNodes[1].textContent - 1;
        }
    }
    class_ID.forEach(function(item, index) {
        if (item.sequence > delSequence) {
            item.sequence = item.sequence - 1
        }
    })
    rowCount--;
    orderCount--;
}
var result;

function isInArray(value) {
    var result;
    class_ID.forEach(function(element, index) {
        // console.log(element.classID.includes(parseInt(value)))
        result = element.classID.includes(parseInt(value));
        // console.log(element.classID)
        //     if (parseInt(element.classID) === parseInt(value)) {
        //         console.log("in")
        //         result = true;
        //         console.log(result)
        //     } else {
        //         result = false;
        //     }
        // })
        // console.log(result)
        // return result;
    });
    return result;
}

function moveUp() {
    if (keep) {
        //如果不是第一行，則與上一行交換順序
        if (keep.childNodes[1].textContent != 1) {
            var node = keep.previousSibling;
        }
        if (node) {
            swapNode(keep, node);
            var keepArray = class_ID.find(function(item, index) {
                return item.sequence == keep.childNodes[1].textContent;
            });

            var nodeArray = class_ID.find(function(item, index) {
                return item.sequence == node.childNodes[1].textContent;
            });

            keepArray.sequence = parseInt(keep.childNodes[1].textContent) - 1;
            nodeArray.sequence = parseInt(node.childNodes[1].textContent) + 1;
            keep.childNodes[1].textContent = parseInt(keep.childNodes[1].textContent) - 1;
            node.childNodes[1].textContent = parseInt(node.childNodes[1].textContent) + 1;
        }
    } else
        alert("請先點選欲排序的課程")
}

function moveDown() {
    if (keep) {
        //如果不是最後一行，則與下一行交換順序
        if (keep.childNodes[1].textContent != class_ID.length) {
            var node = keep.nextSibling;
        }
        if (node) {
            swapNode(keep, node);
            var keepArray = class_ID.find(function(item, index) {
                return item.sequence == keep.childNodes[1].textContent;
            });
            var nodeArray = class_ID.find(function(item, index) {
                return item.sequence == node.childNodes[1].textContent;
            });
            keepArray.sequence = parseInt(keep.childNodes[1].textContent) + 1;
            nodeArray.sequence = parseInt(node.childNodes[1].textContent) - 1;

            keep.childNodes[1].textContent = parseInt(keep.childNodes[1].textContent) + 1;
            node.childNodes[1].textContent = parseInt(node.childNodes[1].textContent) - 1;
        }
    } else
        alert("請先點選欲排序的課程")
}

function swapNode(node1, node2) {
    //獲取父結點
    var _parent = node1.parentNode;
    //獲取兩個結點的相對位置
    var _t1 = node1.nextSibling;
    var _t2 = node2.nextSibling;
    //將node2插入到原來node1的位置
    if (_t1) _parent.insertBefore(node2, _t1);
    else _parent.appendChild(node2);
    //將node1插入到原來node2的位置
    if (_t2) _parent.insertBefore(node1, _t2);
    else _parent.appendChild(node1);
}

function saveOrderLIst() {
    if (class_ID.length > 0) {
        $.ajax({
            type: 'GET',
            url: "orderlist.php",
            data: {
                classIDArray: class_ID
            },
            success: function(res) {
                alert("儲存成功!")
            }
        });
    } else {
        alert("您還沒填選意願表!")
    }
}

function changePage(page) {
    $.ajax({
        type: 'GET',
        url: "showClass.php",
        data: {
            ajaxPost: "changePage",
            turnPage: page,
            kind: $('[name=kind]').val()
        },
        success: function(res) {
            res = JSON.parse(res);
            $("#classTBody").html(res.classTable);
            $("#page").html(res.pages);
            // console.log(JSON.parse(res))
        }
    });
}

function init() {

    $('#kind').change(function() {
        if ($('[name=kind]').val() == 0) {
            kind = 0
        }
        // console.log($('[name=kind]').val())
        $.ajax({
            type: "GET",
            url: "showClass.php",
            data: {
                ajaxPost: "clickKind",
                kind: $('[name=kind]').val()
            },
            success: function(res) {

                res = JSON.parse(res);
                $("#classTBody").html(res.classTable);
                $("#page").html(res.pages);
                $("#class").html(res.class)
            }
        });
    });
    $('#class').change(function() {
        // console.log($('[name=class]').val())
        $.ajax({
            type: "GET",
            url: "showClass.php",
            data: {
                ajaxPost: "clickClass",
                kind: $('[name=kind]').val(),
                class: $('[name=class]').val()
            },
            success: function(res) {
                res = JSON.parse(res)
                $("#classTBody").html(res.classTable);
                $("#page").html(res.pages);
                $("#class").html(res.class)
            }
        });
    });


}
$(document).ready(init);
</script>
<?php include("showClass.php") ?>
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
                <button type=" button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"
                    data-whatever="@getbootstrap" style="margin-right: 10px;">修改密碼</button>

                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">設定您的新密碼:</label>
                                        <input type="password" class="form-control" id="new_passwd" name="new_passwd"
                                            placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">再次輸入新密碼:</label>
                                        <input type="password" class="form-control" id="new_passwd_again"
                                            name="new_passwd_again" placeholder="">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                                    <input type="submit" class="btn btn-primary" value="確認">
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <a class="btn btn btn-outline-secondary" href="login.php?logout=1">登出</a>
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
                    if ($row["kind_ID"] == $_GET["kind"]) {
                ?>
                <option value=<?= $row["kind_ID"] ?> selected> <?= $row["kind_name"] ?></option>
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
                foreach ($class_result as $row) {
                    if ($row["class_ID"] == $_GET["class"]) {
                ?>
                <option value="<?= $row["class_ID"] ?>" selected> <?= $row["class_name"] ?></option>
                <?php } else { ?>
                <option value=<?= $row["class_ID"] ?>><?= $row["class_name"] ?></option>
                <?php }
                } ?>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col ">
            <div class="card mb-2">
                <div class="card-body text-center">
                    <H2>開課課程</H2>
                    <table class="table table-striped table-sm" id="classTable">
                        <thead>
                            <tr>
                                <th scope="col"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        fill="currentColor" class="bi bi-check-square-fill green" viewBox="0 0 16 16">
                                        <path
                                            d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z" />
                                    </svg></th>
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
                        <tbody id="classTBody">

                        </tbody>

                    </table>
                    <div class="row justify-content-center">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination" id="page">

                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-auto align-self-center ">
            <div class="col">
                <button type="button" class="btn btn-warning" onclick="moveUp()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                        class="bi bi-arrow-up-circle-fill white" viewBox="0 0 16 16">
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
                <button type="button" class="btn btn-warning" onclick="moveDown()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                        class="bi bi-arrow-down-circle-fill white" viewBox="0 0 16 16">
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
                    <H2>已選課程</H2>
                    <table class="table table-striped table-sm table-hover" id="chooseTable">
                        <thead>
                            <tr>
                                <th scope="col"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        fill="currentColor" class="bi bi-trash3-fill red" viewBox="0 0 16 16">
                                        <path
                                            d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                    </svg></th>
                                <th scope="col">志願序</th>
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
                        <tbody id="chooseTBody">
                        </tbody>
                        <TFoot>
                            <TR>
                                <TD colspan="10" ID="classTotal"></TD>
                            </TR>
                        </TFoot>
                    </table>
                    <button type="button" class="btn btn-primary" onclick="saveOrderLIst()">儲存</button>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.table-hover tbody tr:hover td,
.table-hover tbody tr:hover th {
    background-color: #97CBFF;
}

.green {
    color: green;
}

.white {
    color: white;
}

.red {
    color: red;
}
</style>

</html>