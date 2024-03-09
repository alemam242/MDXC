<?php

// $query_user = "SELECT * FROM `user` WHERE `id` = $user_id";
// $result_user = mysqli_query($conn, $query_user);

// // Extract users;
// if ($result_user && mysqli_num_rows($result_user) > 0) {
//     $user_details = mysqli_fetch_assoc($result_user);
    
//     $username = explode(" ",$user_details['name'])[0];
// }else{
//     $user_details = null;
//     $username = "";
// }

echo '<nav class="navbar fixed-top px-0 shadow-sm bg-white">
<div class="container-fluid">

    <a class="navbar-brand" href="#">
        <span class="icon-nav m-0 h5" onclick="MenuBarClickHandler()">
            <img class="nav-logo-sm mx-2" src="../../assets/images/menu.svg" alt="logo" />
        </span>
        <img class="nav-logo  mx-2" src="../../images/MDXC-200px1.png" alt="logo" />
    </a>

    
</div>
</nav>';

?>

<!-- Optional -->
<!-- <div class="float-right h-auto d-flex">
        <div class="user-dropdown">
            <img class="icon-nav-img" src="../../assets/images/user.webp" alt="" />
            <div class="user-dropdown-content ">
                <div class="mt-4 text-center">
                    <img class="icon-nav-img" src="../../assets/images/user.webp" alt="" />
                    <h6>'.$username.'</h6>
                    <hr class="user-dropdown-divider  p-0" />
                </div>
                <a href="#" class="side-bar-item">
                    <span class="side-bar-item-caption">Profile</span>
                </a>
                <a href="../logout.php" class="side-bar-item">
                    <span class="side-bar-item-caption">Logout</span>
                </a>
            </div>
        </div>
    </div> -->