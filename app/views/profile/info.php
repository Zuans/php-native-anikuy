<?= View::setCSS('navbar');?>
<?= View::setCSS('footer');?>
<?= View::setCSS('alert');?>
<?= View::setCSS('profile/info'); ?>

<? View::setJS('page/profile/info');?>


<?= View::build('templates/header')?>
<?= View::build('templates/navbar');?>
<section id="profile-body">
    <div class="info-profile">
        <h1>User Profile</h1>
        <hr>
        <ul>
            <li>
                <h4>Username</h4>
                <span><?= $userInfo['username']?></span>
            </li>
            <li>
                <h4>Email</h4>
                <span><?= $userInfo['email']?></span>
            </li>
            <li>
                <h4>Created at</h4>
                <span><?= $userInfo['created_at']?><</span>
            </li>
            <li>
                <h4>Animanga Love </h4>
                <span><?=  $loveCount; ?> Loves</span>
            </li>
        </ul>
    </div>
    <div class="main-profile">
        <h1 class="user-greet">All Activity</h1>
        <hr>
        <div class="user-info">
            <div class="love-count">
                <span>Animanga <?=  $loveCount; ?>  <i class="fas fa-heart"></i>    </span>
            </div>
            <div class="comment-count">
                <span>Comment <?=  $commentCount; ?> <i class="fas fa-comment"></i> </span>
            </div>
            <div class="see-count">
                <span>View <?= $userInfo['view'];?>  <i class="far fa-eye"></i></span>
            </div>
        </div>
        <div class="form-wrapper">
            <h1>Edit Account</h1>      
            <hr>
            <div class="alert-wrapper">
                <?= Flash::showFlash(); ?>
            </div>
            <form action="<?= View::request('Profile/edit') ?>" method="POST" class="form-change-profile form-change-password">
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" value="<?= isset($userInfo['username']) ? $userInfo['username'] : ''; ?>" id="username">
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" value="<?= isset($userInfo['email']) ? $userInfo['email'] : ''; ?>" id="email">
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password"   id="password">
                </div>
                <input type="submit" value="Change Save">
            </form>
            <div class="separator">
                <h3>Or</h3>
            </div>
            <!-- Form change profile with new password -->
            </form>
            <h1>Change Password</h1>      
            <hr>
            <div class="alert-wrapper">
                <?= Flash::showFlash(); ?>
            </div>
            <form action="<?= View::request('Profile/edit') ?>" method="POST" class="form-change-profile form-change-password">
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" value="<?= isset($userInfo['username']) ? $userInfo['username'] : ''; ?>" id="username">
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" value="<?= isset($userInfo['email']) ? $userInfo['email'] : ''; ?>" id="email">
                </div>
                <div class="input-group">
                    <label for="old-password">Old Password</label>
                    <input type="password" name="old-password"   id="old-password">
                </div>
                <div class="input-group">
                    <label for="new-password">New Pasword</label>
                    <input type="password" name="new-password" id="new-password">
                </div>
                <div class="input-group">
                    <label for="password">Confirm Pasword</label>
                    <input type="password" name="confirm-password" id="confirm-password">
                </div>
                <input type="submit" value="Change Save">
            </form>
        </div>
    </div>
</section>
<?= View::build('templates/footer');?>