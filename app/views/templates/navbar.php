<nav id="navbar">
        <div class="nav-menu ">
            <h1 class="nav-title">AniKuy</h1>
            <ul class="nav-list">
                <li><a href="<?= View::request('Home/index')?>">Home</a></li>
                <li><a href="<?= View::request('Home/index')?>">Anime</a></li>
                <li><a href="<?= View::request('Manga/index')?>">Manga</a> </li>
                <?php if(isset($_SESSION['user_id'])):  ?>
                <li class="dropdown">
                    <a href="" class="dropdown-a">Profile</a>
                    <div class="dropdown-content">
                        <a href="<?= View::request('Profile/info')?>">My Info</a>
                        <a href="<?= View::request('Profile/loveList'); ?>">Love list</a>
                    </div>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <button id="btn-hamburger" class="btn-hamburger">
            <div></div>
            <div></div>
            <div></div>
        </button>
        <div class="nav-auth">
            <?php if(isset($_SESSION['username'])): ?>
                <p class="greet-user">
                    Hi,<?= $_SESSION['username']; ?>
                </p>
                <a href="<?= View::request('Auth/logout') ?>" class="btn-auth-logout">
                    Logout
                </a>
            <?php else: ?>
                <a href="<?= View::request('Auth/indexLogin') ?>" class="btn-auth-login">
                    Login
                </a>
                <a href="<?= View::request('Auth/indexRegister')?>" class="btn-auth-register">
                    Sign Up
                </a>
            <?php endif; ?>
        </div>
    </nav>