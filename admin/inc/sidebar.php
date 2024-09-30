<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

<aside id="sidebar" class="sidebar-closed">
    <ul class="m-0 list-unstyled ps-3">
        <a href="allpages.php" class="text-decoration-none">
            <li class="pb-2 pt-2 aside-list">
                <img src="inc/images/document.png" alt="" class="icon-img">
                <button class="btn  border-0 me-3">Pages</button>
            </li>
        </a>
   
        <a href="featured-in.php" class="text-decoration-none">
            <li class="pb-2 pt-2 aside-list">
                <img src="inc/images/document.png" alt="" class="icon-img">
                <button class="btn  border-0 me-3">Featured In</button>
            </li>
        </a>       

        <a href="allusers.php" class="text-decoration-none"><li class="pb-2 pt-0 aside-list">
            <img src="inc/images/add-user.png" alt="" class="icon-img">
            <button class="btn  border-0 aside-buttons" 
                type="button" data-bs-toggle="collapse" data-bs-target="#userMenu" aria-expanded="false" aria-controls="userMenu">
                Users
            </button>
        </li></a>
        <a href="allteams.php" class="text-decoration-none">
        <li class="pb-0 pt-0 aside-list">
            <img src="inc/images/united.png" alt="" class="icon-img">
            <button class="btn  border-0 aside-buttons" 
                type="button" data-bs-toggle="collapse" data-bs-target="#teamMenu" aria-expanded="false" aria-controls="teamMenu">
                Teams
            </button>
        </li></a>

        <a href="logout.php" class="text-decoration-none" id="logoutLink">
            <li class="pb-3 pt-3 aside-list">
                <img src="inc/images/logout.png" alt="" class="icon-img">    
                <button class="btn  border-0 aside-buttons">Logout</button>
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
