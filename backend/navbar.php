            <nav class="navbar navbar-expand-sm navbar-dark bg-dark p-0">
                <div class="container">
                    <a href="dashboard.php" class="navbar-brand">Restaurant Management System</a>
                    <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown mr-3">
                                <a href="" class="nav-link doropdown-toggle text-white" data-toggle="dropdown">
                                    <i class="fa fa-user mr-1"></i>Welcome
                                </a>
                                <div class="dropdown-menu">
                                    <a href="profile.php" class="dropdown-item">
                                        <i class="fa fa-user-circle"></i>Profile
                                    </a>
                                    <a href="settings.php" class="dropdown-item">
                                        <i class="fa fa-gear"></i>Settings
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="" onclick="logout()" class="nav-link text-white">
                                    <i class="fa fa-user-times mr-1">Logout</i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
