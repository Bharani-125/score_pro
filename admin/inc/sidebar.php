<style>
    .icon-img {
        width: 18px;
        height: 18px;
    }
    aside {
        background-color: #1d2327;
        color: white;
        width: 250px;
        height: 88%;
        position: absolute;
        top: 70px;
        left: 0px;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        transition: left 0.3s ease;
    }
    aside ul li{
        /* border-bottom: 1px solid white; */
        display: block;
    }
    .dropdown-menu {
        background-color: #1d2327;
        border: none;
    }
    .dropdown-item {
        color: white;
    }
    /* .aside-list:hover {
        background-color: #830000;
    } */
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

<aside id="sidebar" class="sidebar-closed">
    <ul class="m-0 list-unstyled ps-3">
        
        <li class="pb-0 pt-2 aside-list">
            <img src="inc/images/man.png" alt="" class="icon-img">
            <button class="btn text-light border-0 aside-buttons" 
                type="button" data-bs-toggle="collapse" data-bs-target="#pagesMenu" aria-expanded="false" aria-controls="pagesMenu">
                Pages
            </button>
            <ul id="pagesMenu" class=" list-unstyled ps-3">
                <a href="allposts.php" class="text-decoration-none">
                    <li class="pb-2 pt-2 aside-list">
                        <img src="inc/images/document.png" alt="" class="icon-img">
                        <button class="btn text-light border-0 me-3">All Pages</button>
                    </li>
                </a>
                <a href="pageform.php" class="text-decoration-none">
                    <li class="pb-0 pt-0 aside-list">
                        <img src="inc/images/add-user.png" alt="" class="icon-img">    
                        <button class="btn text-light border-0 me-3">Add Page</button>
                    </li>
                </a>
            </ul>
        </li>

        <li class="pb-0 pt-0 aside-list">
            <img src="inc/images/add-user.png" alt="" class="icon-img">
            <button class="btn text-light border-0 aside-buttons" 
                type="button" data-bs-toggle="collapse" data-bs-target="#userMenu" aria-expanded="false" aria-controls="userMenu">
                Users
            </button>
            <ul id="userMenu" class=" list-unstyled ps-3">
                <a href="allusers.php" class="text-decoration-none">
                    <li class="pb-2 pt-2 aside-list">
                        <img src="inc/images/document.png" alt="" class="icon-img">
                        <button class="btn text-light border-0 me-3">All Users</button>
                    </li>
                </a>
                <!-- <a href="userinfo.php" class="text-decoration-none">
                    <li class="pb-0 pt-0 aside-list">
                        <img src="inc/images/add-user.png" alt="" class="icon-img">    
                        <button class="btn text-light border-0 me-3">Add User</button>
                    </li>
                </a> -->
            </ul>
        </li>

        <li class="pb-0 pt-0 aside-list">
            <img src="inc/images/united.png" alt="" class="icon-img">
            <button class="btn text-light border-0 aside-buttons" 
                type="button" data-bs-toggle="collapse" data-bs-target="#teamMenu" aria-expanded="false" aria-controls="teamMenu">
                Teams
            </button>
            <ul id="teamMenu" class=" list-unstyled ps-3">
                <a href="allteams.php" class="text-decoration-none">
                    <li class="pb-0 pt-2 aside-list">
                        <img src="inc/images/united.png" alt="" class="icon-img">
                        <button class="btn text-light border-0 me-3">All Teams</button>
                    </li>
                </a>
                <a href="teaminfo.php" class="text-decoration-none">
                    <li class="pb-0 pt-0 aside-list">
                        <img src="inc/images/new-employee.png" alt="" class="icon-img">    
                        <button class="btn text-light border-0 me-3">Add Team</button>
                    </li>
                </a>
            </ul>
        </li>

        <a href="logout.php" class="text-decoration-none" id="logoutLink">
            <li class="pb-3 pt-3 aside-list">
                <img src="inc/images/logout.png" alt="" class="icon-img">    
                <button class="btn text-light border-0 aside-buttons">Logout</button>
            </li>
        </a>
    </ul>

    <script>
        document.getElementById("logoutLink").onclick = function(event) {
            if (!confirm("Are you sure you want to log out?")) {
                event.preventDefault();
            }
        };
    </script>
</aside>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
