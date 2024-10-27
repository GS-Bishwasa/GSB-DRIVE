<?php
require("db.php");
session_start();

if (empty($_SESSION['user'])) {
    header("Location:login.php");
}

$user_email = $_SESSION['user'];
$user_sql = "SELECT * FROM users WHERE email = '$user_email'";
$user_response = $db->query($user_sql);
$user_data = $user_response->fetch_assoc();
$user_name = $user_data['full_name'];
$total_storage = $user_data['storage'];
$used_storage = $user_data['used_storage'];
$free_storage = 0;
$plan = $user_data['plans'];
if ($plan != 'premium') {
    $percentage = round(($used_storage * 100) / $total_storage, 2);
    $free_storage = $total_storage - $used_storage;
}
$user_id = $user_data['id'];
$tf = "user_" . $user_id;
// echo "Hello World";

$p_status = "";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>



    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        * {
            font-family: "Ubuntu", sans-serif;
            /* margin: 0;
    padding: 0; */
        }

        .main-container {
            width: 100%;
            height: 100vh;
        }

        .left {
            width: 17%;
            height: 100%;
            background-color: #080429;
        }

        .right {
            width: 83%;
            height: 100%;
            /* background-color:green; */
            overflow: auto;
        }

        .profile_pic {
            width: 100px;
            height: 100px;
            border-radius: 100%;
            border: 4px solid white;

        }

        .line {
            background-color: #fff !important;
            width: 100%;
            margin: 0.5rem;
        }

        .storage {
            width: 80%;
        }

        .thumb {
            width: 75px;
            height: 75px;
        }

        .my_menu {
            list-style: none;
            padding: 0;
            margin: 0;
            width: 100%;
            cursor: pointer;
        }

        .my_menu li {
            width: 100%;
            padding: 10px;
            padding-left: 40px;
            color: white;
        }

        .my_menu li:hover {
            background-color: #fff;
            color: #080429;
        }

        .msg {
            height: 100vh;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 100000;
        }

        @media screen and (max-width:992px) {
            .mobile_menu {
                width: 0%;
                height: 100%;
                position: fixed;
                top: 0;
                left: 0;
                background-color: #080429;
                z-index: 1000000000000;
                overflow: hidden;
                transition: 0.4s;
            }

            .right {
                width: 100%;
                height: 100%;

                overflow: auto;
            }
        }
    </style>
</head>

<body>
    <div class="main-container d-flex">
        <div class="left d-none d-lg-block">
            <div class="d-flex justify-content-center align-items-center flex-column pt-5">
                <div class="profile_pic d-flex justify-content-center align-items-center">
                    <i class="fa fa-user fs-1 text-white"></i>
                </div>
                <span class="text-white fs-3 mt-3"><?php echo $user_name; ?></span>
                <hr class="line">
                <button class="btn btn-light rounded-pill upload"><i class="fa fa-upload"></i>Upload File </button>


                <div class="progress storage mt-3 d-none u_pro">
                    <div class="progress-bar bg-primary upload_p"></div>
                </div>
                <div class="upload_msg"></div>

                <hr class="line">
                <ul class="my_menu">
                    <li class="menu" p_link="my_files"><i class="fa-solid fa-folder-open"></i> My Files</li>
                    <li class="menu" p_link="f_files"><i class="fa-solid fa-heart"></i> Favorite Storage</li>
                    <li class="menu" p_link="buy_storage"><i class="fa-solid fa-cart-shopping"></i> Buy Storage</li>
                </ul>
                <hr class="line">

                <?php
                if ($plan != "premium") {

                    ?>
                    <span class="text-light mb-2"><i class="fa-solid fa-database"></i> Storage</span>
                    <div class="progress storage">
                        <div class="progress-bar bg-primary pb" style="width:<?php echo "$percentage"; ?>%;"></div>
                    </div>
                    <span class="text-white "><span class="us"><?php echo $used_storage; ?></span>Mb
                        /<?php echo $total_storage; ?>Mb</span>

                    <?php
                } else {

                    ?>
                    <span class="text-light mb-2"><i class="fa-solid fa-database"></i> Used Storage</span>
                    <span class="text-white "><span class="us"><?php echo $used_storage; ?></span>Mb</span>
                    <?php
                }

                ?>

                <hr class="line">
                <a href="logout.php" class="btn btn-light mt-1">Log Out</a>
            </div>
        </div>

        <!-- Mobile Menu Coding Start -->
        <div class="mobile_menu d-block d-lg-none">
            <i class="fa-solid fa-xmark text-light fs-1 pt-2 ps-3 cut"></i>
            <div class="d-flex justify-content-center align-items-center flex-column pt-1">
                <div class="profile_pic d-flex justify-content-center align-items-center">
                    <i class="fa fa-user fs-1 text-white"></i>
                </div>
                <span class="text-white fs-3 mt-3"><?php echo $user_name; ?></span>
                <hr class="line">
                <button class="btn btn-light rounded-pill upload"><i class="fa fa-upload"></i>Upload File </button>


                <div class="progress storage mt-3 d-none u_pro">
                    <div class="progress-bar bg-primary upload_p"></div>
                </div>
                <div class="upload_msg"></div>

                <hr class="line">
                <ul class="my_menu">
                    <li class="menu mm" p_link="my_files"><i class="fa-solid fa-folder-open"></i> My Files</li>
                    <li class="menu mm" p_link="f_files"><i class="fa-solid fa-heart"></i> Favorite Storage</li>
                    <li class="menu mm" p_link="buy_storage"><i class="fa-solid fa-cart-shopping"></i> Buy Storage</li>
                </ul>
                <hr class="line">

                <?php
                if ($plan != "premium") {

                    ?>
                    <span class="text-light mb-2"><i class="fa-solid fa-database"></i> Storage</span>
                    <div class="progress storage">
                        <div class="progress-bar bg-primary pb" style="width:<?php echo "$percentage"; ?>%;"></div>
                    </div>
                    <span class="text-white "><span class="us"><?php echo $used_storage; ?></span>Mb
                        /<?php echo $total_storage; ?>Mb</span>

                    <?php
                } else {

                    ?>
                    <span class="text-light mb-2"><i class="fa-solid fa-database"></i> Used Storage</span>
                    <span class="text-white "><span class="us"><?php echo $used_storage; ?></span>Mb</span>
                    <?php
                }

                ?>

                <hr class="line">
                <a href="logout.php" class="btn btn-light mt-1">Log Out</a>
            </div>
        </div>
        <!-- Mobile Menu Coding End -->

        <div class="right">
            <nav class="navbar navbar-light bg-light p-1 pt-3 pb-3 shadow-sm sticky-top">
                <div class="container-fluid">
                    <!-- <a class="navbar-brand">GS Bishwasa</a> -->
                    <form class="d-flex ms-auto search_frm">
                        <i class="fa-solid fa-bars fs-4 me-3 mt-2 bar d-block d-lg-none"></i>
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"
                            id="search">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </form>
                </div>
            </nav>

            <div class="content p-4">

            </div>

        </div>
    </div>
    <div class="msg d-none"></div>
    <?php
    if ($plan != "free") {
        $ed = $user_data["expiry_date"];
        $cd = date("Y-m-d");
        if ($ed < $cd) {
            $p_status = "deactivate";
            echo "<style>
    .upload,[p_link='my_files'],[p_link='f_files']{
    pointer-events:none;
        }

    </style>";
        } else {
            $p_status = "activate";

        }
    }
    ?>
    <script>

        $(function () {
            $(".upload").on("click", function () {
                let input = document.createElement("INPUT")
                input.setAttribute("type", "file")
                input.click()
                input.addEventListener("change", function () {
                    $(".u_pro").removeClass("d-none")
                    let file = new FormData()
                    file.append("data", input.files[0])
                    let file_size = Math.floor(input.files[0].size / 1024 / 1024);
                    let free_storage = <?php echo $free_storage; ?>;
                    let plan = "<?php echo $plan; ?>";
                    function upload() {
                        $.ajax({
                            type: "POST",
                            url: "upload.php",
                            data: file,
                            processData: false,
                            contentType: false,
                            cache: false,
                            xhr: function () {
                                let request = new XMLHttpRequest()
                                request.upload.onprogress = function (e) {
                                    let loaded = (e.loaded / 1024 / 1024).toFixed(2)
                                    let total = (e.total / 1024 / 1024).toFixed(2)
                                    let upload_per = ((loaded * 100) / total).toFixed(0)

                                    $(".upload_p").css("width", upload_per + "%")
                                    $(".upload_p").html(upload_per + "%")
                                }
                                return request
                            },
                            success: function (response) {
                                $(".u_pro").addClass("d-none")
                                let obj = JSON.parse(response)
                                if (obj.msg == "Upload Success") {
                                    let new_per = (obj.used_storage * 100) / <?php echo $total_storage ?>;
                                    $(".us").html(obj.used_storage)
                                    $(".pb").css("width", new_per + "%")
                                    let div = document.createElement("DIV")
                                    div.className = "alert alert-success m-3"
                                    div.innerHTML = obj.msg
                                    $(".upload_msg").append(div)
                                    my_files()
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
                    }
                    if (plan == "premium") {
                        upload()
                    } else {
                        if (file_size < free_storage) {
                            // Upload logic goes here
                            upload()

                        } else {
                            let div = document.createElement("DIV")
                            div.className = "alert alert-danger m-3"
                            div.innerHTML = "File Size Too Large Purchase More Storage"
                            $(".upload_msg").append(div)
                            setTimeout(() => {
                                $(".upload_msg").html("")
                                $(".upload_p").css("width", "0%")
                                $(".upload_p").html("")
                                $(".u_pro").addClass("d-none")
                            }, 3000);
                        }
                    }

                })
            })

            $(".menu").each(function () {
                $(this).on("click", function () {
                    let page_link = $(this).attr("p_link")
                    // alert(page_link)
                    $.ajax({
                        type: "POST",
                        url: "pages/" + page_link + ".php",
                        beforeSend: function () {
                            $(".msg").removeClass("d-none")
                            let div = document.createElement("DIV");
                            $(div).addClass("alert alert-primary fs-1 text-center p-5");
                            $(div).html('<i class="fa-solid fa-spinner fa-spin display-1"></i><br>Loading...');
                            $(".msg").html(div);
                        },
                        success: function (response) {
                            $(".msg").addClass("d-none")
                            $(".content").html(response)
                        }
                    });
                });
            })
            function my_files() {
                if ("<?php echo $plan; ?>" != "free") {
                    if ("<?php echo $p_status; ?>" == "activate") {

                        $('[p_link="my_files"]').click()
                    } else {
                        $('[p_link="buy_storage"]').click()

                    }
                } else {
                    $('[p_link="my_files"]').click()
                }


            }
            my_files()

            $(".cut").on("click", function () {
                $(".mobile_menu").css("width", "0%")
            })

            $(".bar").on("click", function () {
                $(".mobile_menu").css("width", "75%")
            })
            $(".mm").on("click", function () {
                $(".mobile_menu").css("width", "0%")
            })

            $(".search_frm").on("submit", function (e) {
                e.preventDefault()
                let query = $("#search").val()
                $.ajax({
                    type: "POST",
                    url: "pages/search.php",
                    data: {
                        query: query
                    },
                    beforeSend: function () {
                        $(".msg").removeClass("d-none")
                        let div = document.createElement("DIV");
                        $(div).addClass("alert alert-primary fs-1 text-center p-5");
                        $(div).html('<i class="fa-solid fa-spinner fa-spin display-1"></i><br>Loading...');
                        $(".msg").html(div);
                    },
                    success: function (response) {
                        $(".msg").addClass("d-none")
                        $(".content").html(response)
                    }
                });
            })

        })

    </script>
</body>

</html>