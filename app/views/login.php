<!-- CSS Declare -->
<? View::setCSS('footer'); ?>
<? View::setCSS('auth'); ?>
<? View::setCSS('alert')?>




<?= View::build('templates/header'); ?>
<div class="container">
    <div class="wall-auth">
        <h1>Welcome </br> 
            to </br> 
            <strong>Anikuy</strong> 
        </h1>
    </div>
    <div class="form-wrapper">
        <h1>Login</h1>
        <hr>
        <div class="alert-wrapper">
            <? Flash::showFlash(); ?>
        </div>
        <form action="<?= View::request('Auth/login')?>" method="POST" class="form-input"   >
            <div class="form-group">
                <input type="text" id="email" name="email"  autocomplete="off" required />
                <span class="label" >Email</span>
                <div class="underline"></div>
            </div>
            <div class="form-group">
                <input type="password"  id="password" name="password"  autocomplete="off" required />
                <span class="label" >Password</span>
                <div class="underline"></div>
            </div>
            <button role="submit" >Submit</button>
            <?php if(isset($error['account'])):?>
                <p class="error-invalid-account"><?=  $error['account']?></p>
            <?php endif; ?>
        </form>
        <p class="signup-link">
            Don't have an account yet ?
            <a href="<?= View::request("Auth/indexRegister"); ?>"> <strong>Sign Up</strong></a>
        </p>
        <p class="mark" >Made with  <i class="fas fa-heart"></i>  by <a href="">Zuans</a></p>
    </div>
</div>
