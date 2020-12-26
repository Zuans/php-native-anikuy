<!-- CSS Declare -->
<?= View::setCSS('navbar') ?>
<?= isset($animeDetail) ? View::setCSS('anime_detail') : View::setCSS('manga_detail'); ?>
<?= View::setCSS('footer') ?>


<!-- JS Declare -->
<? View::setJS('detail');?>


<!-- Build Template -->
<?= View::build('templates/header')?>
<?= View::build('templates/navbar')?>

<?php if(isset($animeDetail)):?>
<section id="anime-detail">
    <div class="img-hero">
        <img src="<?= $animeDetail['imgCover']?>" alt="<?$animeDetail['title']?>">
    </div>
    <div class="container">
        <div class="anime-info">
            <h2>Information</h2>
            <ul class="anime-info-list" >
                <li>Rating: <?= $animeDetail['rating']?></li>
                <li>Rating rank: <?= $animeDetail['ratingRank']?></li>
                <li>Age rating: <?= $animeDetail['ageRating']?></li>
                <li>User: <?= $animeDetail['user']?></li>
                <li>Status: <?= $animeDetail['status']?></li>
                <li>Aired: <p class="aired-date" ><?= $animeDetail['aired']?></p></li>
                <li>Episode Count: <?= $animeDetail['epsCount']?></li>
            </ul>
        </div>
        <div class="anime-content">
            <h1><?= $animeDetail['title']?> (<?= $animeDetail['showType'];?> ) </h1>
            <!-- Like Icon -->
            <div class="btn-love-wrapper">
                <i class="fas fa-heart <?= $isLoved ? 'love' : ''  ?>" id="love-icon" ></i>
            </div>
            <div class="spec-info">
                <div class="rating">
                    <span><?= $animeDetail['rating'] ?></span>
                    <i class="fas fa-star icon "></i>
                </div>
                <div class="user">
                    <span><?= $animeDetail['user'] ?> </span>
                    <i class="fas fa-user icon "></i>
                </div>
                <div class="episode">
                    <span><?= $animeDetail['epsCount']?></span>
                    <i class="fas fa-tv icon "></i>
                </div>
            </div>
            <p class="anime-desc"><?= $animeDetail['fullSynopsis']?></p>
        </div>
    </div>
</section>
<?php else:?>
    <section id="manga-detail">
    <div class="img-hero">
        <img src="<?= $mangaDetail['imgCover']?>" alt="<?$mangaDetail['title']?>">
    </div>
    <div class="container">
        <div class="manga-info">
            <h2>Information</h2>
            <ul class="manga-info-list" >
                <li>Rating: <?= $mangaDetail['rating']?></li>
                <li>Rating rank: <?= $mangaDetail['ratingRank']?></li>
                <li>Age rating: <?= $mangaDetail['ageRating']?></li>
                <li>User: <?= $mangaDetail['user']?></li>
                <li>Status: <?= $mangaDetail['status']?></li>
                <li>Aired: <p class="aired-date" ><?= $mangaDetail['aired']?></p></li>
                <li>Serialize by: <?= $mangaDetail['serialization']?></li>
                <li>Chapter Count: <?= $mangaDetail['chapCount']?></li>
            </ul>
        </div>
        <div class="manga-content">
            <h1><?= $mangaDetail['title']?> (<?= $mangaDetail['mangaType'];?> ) </h1>
            <!-- Like Icon -->
            <div class="btn-love-wrapper">
                <i class="fas fa-heart <?= $isLoved ? 'love' : ''  ?>" id="love-icon" ></i>
            </div>
            <div class="spec-info">
                <div class="rating">
                    <span><?= $mangaDetail['rating'] ?></span>
                    <i class="fas fa-star icon "></i>
                </div>
                <div class="user">
                    <span><?= $mangaDetail['user'] ?> </span>
                    <i class="fas fa-user icon "></i>
                </div>
                <div class="chapter">
                    <span><?= $mangaDetail['chapCount']?></span>
                    <i class="fas fa-tv icon "></i>
                </div>
            </div>
            <p class="manga-desc"><?= $mangaDetail['fullSynopsis']?></p>
        </div>
    </div>
</section>
<?php endif;?>


<?= View::build('templates/footer')?>