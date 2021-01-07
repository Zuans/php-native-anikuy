<?= View::setCSS('navbar');?>
<?= View::setCSS('footer');?>
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
                <span>Zuans</span>
            </li>
            <li>
                <h4>Email</h4>
                <span>Zuans</span>
            </li>
            <li>
                <h4>Created at</h4>
                <span>20-20-1989</span>
            </li>
            <li>
                <h4>Animanga Love </h4>
                <span>48 Loves</span>
            </li>
        </ul>
    </div>
    <div class="main-profile">
        <h1 class="user-greet">All Activity</h1>
        <hr>
        <div class="user-info">
            <div class="love-count">
                <span>Animanga 36 <i class="fas fa-heart"></i></span>
            </div>
            <div class="comment-count">
                <span>Comment 46 <i class="fas fa-comment"></i></span>
            </div>
            <div class="see-count">
                <span>View 200 <i class="far fa-eye"></i></span>
            </div>
        </div>
        <div class="form-wrapper">
            <form action="" class="form-change-profile">
                <h1>Edit Account</h1>
                <hr>
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username">
                </div>
                <div class="input-group">
                    <label for="username">Email</label>
                    <input type="text" name="username" id="username">
                </div>
                <div class="input-group">
                    <label for="username">Old Password</label>
                    <input type="text" name="username" id="username">
                </div>
                <div class="input-group">
                    <label for="username">New Pasword</label>
                    <input type="text" name="username" id="username">
                </div>
                <div class="input-group">
                    <label for="username">Confirm Pasword</label>
                    <input type="text" name="username" id="username">
                </div>
                <input type="submit" value="Change Save">
            </form>
        </div>
    </div>
</section>
<?= View::build('templates/footer');?>