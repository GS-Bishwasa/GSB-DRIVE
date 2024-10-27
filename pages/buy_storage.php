<?php
session_start();
require("../db.php");
$user_email = $_SESSION['user'];
$user_sql = "SELECT * FROM users WHERE email = '$user_email'";
$user_response = $db->query($user_sql);
$user_data = $user_response->fetch_assoc();
$user_id = $user_data['id'];
$tf = "user_" . $user_id;
$plan = $user_data['plans'];

$p_status = "";
if ($plan != "free") {
    $ed = $user_data["expiry_date"];
    $cd = date("Y-m-d");
    if ($ed < $cd) {
        $p_status = "deactivate";
    } else {
        $p_status = "activate";

    }
}

$s_btn = '  <button class="btn btn-secondary w-50 buy" plan="silver" amount="170">&#8377;170 / Month</button>';
$g_btn = ' <button class="btn btn-warning w-50 buy" plan="gold" amount="320">&#8377;320 / Month</button>';
$p_btn = ' <button class="btn btn-primary w-50 buy" plan="premium" amount="500">&#8377;500 / Month</button>';

if ($plan == "silver" && $p_status == "activate") {
    $s_btn = '  <button class="btn btn-secondary w-50 buy disabled" plan="silver" amount="170">Current Plan</button>';
    $g_btn = ' <button class="btn btn-warning w-50 buy" plan="gold" amount="320">&#8377;320 / Month</button>';
    $p_btn = ' <button class="btn btn-primary w-50 buy" plan="premium" amount="500">&#8377;500 / Month</button>';

} elseif ($plan == "silver" && $p_status == "deactivate") {
    $s_btn = '  <button class="btn btn-secondary w-50 buy" plan="silver" amount="170">&#8377;170 / Month</button>';
    $g_btn = ' <button class="btn btn-warning w-50 buy" plan="gold" amount="320">&#8377;320 / Month</button>';
    $p_btn = ' <button class="btn btn-primary w-50 buy" plan="premium" amount="500">&#8377;500 / Month</button>';
} elseif ($plan == "gold" && $p_status == "activate") {
    $s_btn = '  <button class="btn btn-secondary w-50 buy disabled" plan="silver" amount="170">&#8377;170 / Month</button>';
    $g_btn = ' <button class="btn btn-warning w-50 buy disabled" plan="gold" amount="320">Current Plan</button>';
    $p_btn = ' <button class="btn btn-primary w-50 buy" plan="premium" amount="500">&#8377;500 / Month</button>';

} elseif ($plan == "gold" && $p_status == "deactivate") {
    $s_btn = '  <button class="btn btn-secondary w-50 buy disabled" plan="silver" amount="170">&#8377;170 / Month</button>';
    $g_btn = ' <button class="btn btn-warning w-50 buy" plan="gold" amount="320">&#8377;320 / Month</button>';
    $p_btn = ' <button class="btn btn-primary w-50 buy" plan="premium" amount="500">&#8377;500 / Month</button>';
} elseif ($plan == "premium" && $p_status == "activate") {
    $s_btn = '  <button class="btn btn-secondary w-50 buy disabled" plan="silver" amount="170">&#8377;170 / Month</button>';
    $g_btn = ' <button class="btn btn-warning w-50 buy disabled" plan="gold" amount="320">&#8377;320 / Month</button>';
    $p_btn = ' <button class="btn btn-primary w-50 buy disabled" plan="premium" amount="500">Current Plan</button>';

} elseif ($plan == "premium" && $p_status == "deactivate") {
    $s_btn = '  <button class="btn btn-secondary w-50 buy disabled" plan="silver" amount="170">&#8377;170 / Month</button>';
    $g_btn = ' <button class="btn btn-warning w-50 buy disabled" plan="gold" amount="320">&#8377;320 / Month</button>';
    $p_btn = ' <button class="btn btn-primary w-50 buy" plan="premium" amount="500">&#8377;500 / Month</button>';
}
?>


<div class="row">
    <h1 class="text-center mb-5">OUR PLANS</h1>
    <div class="col-md-4 px-5 mb-4">
        <div class="card border-secondary shadow"
            style="background-color:#EAEAEA; border-width:4px; border-radius: 12px;">
            <div class="card-body text-center border-0">
                <label class="fs-5 mt-4">SILVER</label><br>
                <label class="fs-2">50 GB</label>
                <br><br>
                <?php echo $s_btn; ?>
                <hr>
                <label>50 GB Storage</label>
                <hr>
                <label>24X7 Technical Support</label>
                <hr>
                <label>Data Sequrity</label>
                <hr>
                <label>SEO Service</label>
                <hr>
                <label>Email Support</label>
                <hr>
                <label>Sharing Facilabelty</label>
            </div>
        </div>
    </div>



    <div class="col-md-4 px-5 mb-4">
        <div class="card border-warning shadow"
            style="background-color:#FFEFD5; border-width:4px; border-radius: 12px;">
            <div class="card-body text-center border-0">
                <label class="fs-5 mt-4">GOLD</label><br>
                <label class="fs-2">100 GB</label>
                <br><br>
                <?php echo $g_btn; ?>
                <hr>
                <label>50 GB Storage</label>
                <hr>
                <label>24X7 Technical Support</label>
                <hr>
                <label>Data Sequrity</label>
                <hr>
                <label>SEO Service</label>
                <hr>
                <label>Email Support</label>
                <hr>
                <label>Sharing Facilabelty</label>
            </div>
        </div>
    </div>



    <div class="col-md-4 px-5 ">
        <div class="card border-primary shadow"
            style="background-color:#e8f2ff; border-width:4px; border-radius: 12px;">
            <div class="card-body text-center border-0">
                <label class="fs-5 mt-4">PREMIUM</label><br>
                <label class="fs-2">UNLIMITED</label>
                <br><br>
                <?php echo $p_btn; ?>
                <hr>
                <label>50 GB Storage</label>
                <hr>
                <label>24X7 Technical Support</label>
                <hr>
                <label>Data Sequrity</label>
                <hr>
                <label>SEO Service</label>
                <hr>
                <label>Email Support</label>
                <hr>
                <label>Sharing Facilabelty</label>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $(".buy").each(function () {
            $(this).on("click", function () {
                let plan = $(this).attr("plan")
                let amt = $(this).attr("amount")
                location.href = "pages/pay.php?plan=" + plan + "&amt=" + amt;
            })
        })
    })
</script>