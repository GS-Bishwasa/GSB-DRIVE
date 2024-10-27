<?php
session_start();
require("../db.php");
$user_email = $_SESSION['user'];
$user_sql = "SELECT * FROM users WHERE email = '$user_email'";
$user_response = $db->query($user_sql);
$user_data = $user_response->fetch_assoc();
$user_id = $user_data['id'];
$total_storage = $user_data['storage'];
$tf = "user_" . $user_id;
?>
<h1 class="text-center mt-3 mb-4">Favorite Files</h1>
<div class="row">


    <?php
    $file_data_sql = "SELECT * FROM $tf WHERE star = 'yes'";
    $file_res = $db->query($file_data_sql);
    while ($file_array = $file_res->fetch_assoc()) {
        $fd_array = pathinfo($file_array["file_name"]);
        $file_name = $fd_array["filename"];
        $file_ext = $fd_array["extension"];
        $basename = $fd_array["basename"];
        echo '
             <div class="col-md-4">
             <div class="d-flex align-items-center p-2 mb-3 border">
             <div class="me-3">';

        if ($file_ext == "mp4") {
            echo "<img src='images/mp4.png' class='thumb'> ";
        } else if ($file_ext == "mp3") {
            echo "<img src='images/mp3.png' class='thumb'> ";
        } else if ($file_ext == "docx" || $file_ext == "doc") {
            echo "<img src='images/doc.png' class='thumb'> ";
        } else if ($file_ext == "mov") {
            echo "<img src='images/mov.png' class='thumb'> ";
        } else if ($file_ext == "pdf") {
            echo "<img src='images/pdf.png' class='thumb'> ";
        } else if ($file_ext == "pptx" || $file_ext == "ppt") {
            echo "<img src='images/ppt.png' class='thumb'> ";
        } else if ($file_ext == "txt") {
            echo "<img src='images/txt.png' class='thumb'> ";
        } else if ($file_ext == "wmv") {
            echo "<img src='images/wmv.png' class='thumb'> ";
        } else if ($file_ext == "xlsx" || $file_ext == "xls") {
            echo "<img src='images/xls.png' class='thumb'> ";
        } else if ($file_ext == "zip") {
            echo "<img src='images/zip.png' class='thumb'> ";
        } else if ($file_ext == "jpg" || $file_ext == "jpeg" || $file_ext == "png" || $file_ext == "gif" || $file_ext == "webp") {
            echo "<img src='data/" . $tf . "/" . $basename . "' class='thumb'> ";
        }
        ;
        echo '</div>
             <div class="w-100">
             <p>' . $file_name . '</p>
             <hr>
             <div class="d-flex justify-content-around w-100"> 
            <a href="data/' . $tf . '/' . $basename . '"target="blank"> <i class="fas fa-eye"></i></a>
             <a href="data/' . $tf . '/' . $basename . '"download> <i class="fas fa-download"></i></a>
             <i class="fas fa-trash del" id="' . $file_array['id'] . '" folder="' . $tf . '" file="' . $basename . '"></i>
             ';
        if ($file_array['star'] == 'yes') {
            echo '<i class="fa-solid fa-heart text-warning heart" status="no" id="' . $file_array['id'] . '" folder="' . $tf . '"></i>';
        } else {
            echo '<i class="fa-solid fa-heart text-secondary heart" status="yes"  id="' . $file_array['id'] . '" folder="' . $tf . '"></i>';

        }
        echo '
             </div>
             </div>
             </div>
             </div>
             ';
    }
    ?>
</div>

<script>
    $(function () {
        $(".del").each(function () {
            $(this).on("click", function () {
                let id = $(this).attr("id")
                let folder = $(this).attr("folder")
                let file = $(this).attr('file')
                let ce = $(this)
                $.ajax({
                    type: "POST",
                    url: "pages/delete_file.php",
                    data: {
                        id: id,
                        folder: folder,
                        file: file
                    },
                    success: function (response) {
                        let obj = JSON.parse(response)
                        if (obj.msg == "Delete Success") {
                            let new_per = (obj.used_storage * 100) / <?php echo $total_storage ?>;
                            $(".us").html(obj.used_storage)
                            $(".pb").css("width", new_per + "%")
                            let div = document.createElement("DIV")
                            div.className = "alert alert-success m-3"
                            div.innerHTML = obj.msg
                            $(".upload_msg").append(div)
                            $(ce).parent().parent().parent().parent().remove()
                            setTimeout(() => {
                                $(".upload_msg").html("")
                                $(".upload_p").css("width", "0%")
                                $(".upload_p").html("")
                            }, 3000);
                        } else {
                            let div = document.createElement("DIV")
                            div.className = "alert alert-danger m-3"
                            div.innerHTML = obj.msg
                            $(".upload_msg").append(div)
                            setTimeout(() => {
                                $(".upload_msg").html("")
                                $(".upload_p").css("width", "0%")
                                $(".upload_p").html("")
                            }, 3000);
                        }
                    }
                });
            })
        })

        $(".heart").each(function () {
            $(this).on("click", function () {
                let heart_status = $(this).attr("status")
                let heart_id = $(this).attr("id")
                let heart_folder = $(this).attr("folder")
                $.ajax({
                    type: "POST",
                    url: "pages/heart_files.php",
                    data: {
                        h_status: heart_status,
                        h_id: heart_id,
                        h_folder: heart_folder
                    },
                    success: function (response) {
                        if (response.trim() == "Success") {
                            $('[p_link="my_files"]').click()
                        } else {
                            alert(response)
                        }
                    }
                });
            })
        })
    })
</script>