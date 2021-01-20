<!-- CSS Declare -->
<?= View::setCSS('navbar') ?>
<?= isset($animeDetail) ? View::setCSS('anime_detail') : View::setCSS('manga_detail'); ?>
<?= View::setCSS('footer') ?>


<!-- JS Declare -->
<?= View::setJS('app/navbar')?>
<?= View::setAsyncJS('detail');?>


<!-- Build Template -->
<?= View::build('templates/header')?>
<?= View::build('templates/navbar')?>

<?php if(isset($animeDetail)):?>
<section id="anime-detail">
    <div class="img-hero">
        <img src="<?= $animeDetail['imgCover']?>" alt="<?$animeDetail['title']?>">
    </div>
    <div class="alert">
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
                <li>Duration : <?= $animeDetail['epsLength']?></li>
            </ul>
        </div>
        <div class="anime-content">
            <h1><?= $animeDetail['title']?> (<?= $animeDetail['showType'];?> ) </h1>
            <!-- Video Preview IF EXIST-->
            <?php if(isset($animeDetail['ytVideoId'])):?>
                <div class="preview-wrapper">
                    <iframe 
                        width="100%" 
                        height="100%" src="https://www.youtube.com/embed/<?= $animeDetail['ytVideoId']?>" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
            <?php endif;?>
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
            <h2 class="content-title">
                Synopsis
            </h2>
            <p class="anime-desc"><?= $animeDetail['fullSynopsis']?></p>
        </div>
    </div>
</section>
<?php else:?>
    <section id="manga-detail">
    <div class="img-hero">
        <img src="<?= $mangaDetail['imgCover']?>" alt="<?$mangaDetail['title']?>">
    </div>
    <div class="alert">
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

<section id="comment-body">
    <h1 class="comment-title">Comments</h1>
    <div class="all-comments">
        <?php foreach( $allComment as $comment ):?>
            <div class="comment-card">
                <p class="username">
                <?= $comment['username']?>
                </p>
                <p class="comment-date">
                    at <?= $comment['created_at'];?>
                </p>
                <p class="comment-text">
                    <?= $comment['text'];?>
                </p>
            </div>
        <?php endforeach; ?>
        <?php if($totalData > 5): ?>
            <button id="btn-more-comnt">More Comments</button>
        <? endif; ?>
    </div>
    <?php if(isset($_SESSION['user_id'])): ?>
    <div class="comment-input">
        <h3>Your Comment</h3>
        <input type="text" id="input-comment" placeholder="Insert Your Comment">
        <button id="add-comment" ><i class="fas fa-arrow-right"></i></button>
    </div>
    <?php else: ?>
    <div class="not-authorized">
        <h3>You are not login yet for add the comment you please <a href="<?= View::request('Auth/indexLogin')?>">Login</a></h3>
    </div>
    <?php endif;?>
</section>


<?= View::build('templates/footer')?>