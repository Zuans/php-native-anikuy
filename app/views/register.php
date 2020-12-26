<!-- CSS Declare -->
<? View::setCSS('footer'); ?>
<? View::setCSS('auth'); ?>




<?= View::build('templates/header'); ?>
<div class="container">
    <div class="form-wrapper">
        <h1>Sign Up</h1>
        <hr>
        <form action="<?= View::request('Auth/register')?>" method="POST" class="form-input"   >
            <div class="form-group">
                <input type="text" id="username" name="username"  autocomplete="off" required />
                <span class="label <?= $error['username'] ? 'error': '' ?> " >Username</span>
                <div class="underline"></div>
            </div>
            <?php if(isset($error['username'])): ?>
                <p class="error-invalid-input" ><?= $error['username'];?></p>
            <?php endif; ?>
            <div class="form-group">
                <input type="text" id="email" name="email"  autocomplete="off" required />
                <span class="label <?= $error['email'] ? 'error': '' ?> " " >Email</span>
                <div class="underline"></div>
            </div>
            <?php if(isset($error['email'])): ?>
                <p class="error-invalid-input" ><?= $error['email'];?></p>
            <?php endif; ?>
            <div class="form-group">
                <input type="password"  id="password" name="password"  autocomplete="off" required />
                <span class="label <?= $error['password'] ? 'error': '' ?> " " >Password</span>
                <div class="underline"></div>
            </div>
            <?php if(isset($error['password'])): ?>
                <p class="error-invalid-input" ><?= $error['password'];?></p>
            <?php endif; ?>
            <div class="form-group">
                <input type="password" id="confirm-password" name="confirm-password" autocomplete="off" required />
                <span class="label <?= $error['confirm-password'] ? 'error': '' ?> " " >Confirm-password</span>
                <div class="underline"></div>
            </div>
            <?php if(isset($error['confirm-password'])): ?>
                <p class="error-invalid-input" ><?= $error['confirm-password'];?></p>
            <?php endif; ?>
            <button role="submit" >Submit</button>
            <!-- Error Account -->
            <?php if(isset($error['account'])): ?>
                <p class="error-invalid-account" ><?= $error['account'];?></p>
            <?php endif; ?>
        </form>
        <p class="mark" >Made with by <i class="fas fa-heart"></i> <a href="">Zuans</a></p>
    </div>
    <div class="wall-auth">
        <h1>Welcome </br> 
            to </br> 
            <strong>Anikuy</strong> 
        </h1>
    </div>
</div>
