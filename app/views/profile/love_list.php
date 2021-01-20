<?= View::setCSS('navbar');?>
<?= View::setCSS('footer');?>
<?= View::setCSS('profile/love-list');?>

<?= View::setJS('app/navbar');?>
<?= View::setAsyncJS('page/profile/loveList');?>


<?= View::build('templates/header')?>
<?= View::build('templates/navbar');?>
<section id="body-love-list">
    <h1 class="body-title">Your Love List <i class="fas fa-heart"></i></h1>
    <div id="card-list-anime">
        <h1 class="title-type">Anime</h1>
        <?php if(isset($animesLove)): ?>
        <?php foreach($animesLove as $key => $animeLove ): ?>
        <div class="card-list-love">
            <?php if(isset($animeLove[0])): ?>
            <div class="first">
                <h1 class="animanga-title" ><?= $animeLove[0]['title']?></h1>
                <div class="animanga-info">
                    <div class="img-wrapper">   
                        <img src="<?= $animeLove[0]['imgPosterFl'] ?>" alt="">
                        <div class="detail">      
                            <ul>
                                <li><?= $animeLove[0]['showType'] ?></li>
                                <li>Rating : <?= $animeLove[0]['rating'] ?></li>
                                <li>Age Rating : <?= $animeLove[0]['ratingRank'] ?></li>
                                <li>Aired : <?= $animeLove[0]['aired'] ?></li>
                                <li>User : <?= $animeLove[0]['user'] ?></li>
                                <li>Status : <?= $animeLove[0]['status'] ?></li>
                                <li>
                                    <div class="action">
                                        <button>
                                            <a href="<?= View::request('Anime/show/'.$animeLove[0]['id']);?>">Detail</a>
                                        </button>
                                        <button class="remove-btn-anime" data-id="<?= $animeLove[0]['id']?>">Remove</button>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if(isset($animeLove[1])):?>
            <div class="second">
                <h1 class="title"><?= $animeLove[1]['title']?></h1>
                <div class="animanga-info">
                    <img src="<?= $animeLove[1]['imgPoster'] ?>" alt="">
                    <div class="detail">
                        <ul>
                            <li><?= $animeLove[1]['showType'] ?></li>
                            <li>Rating : <?= $animeLove[1]['rating'] ?></li>
                            <li>Age Rating : <?= $animeLove[1]['ratingRank'] ?></li>
                            <li>Aired : <?= $animeLove[1]['aired'] ?></li>
                            <li>User : <?= $animeLove[1]['user'] ?></li>
                            <li>Status : <?= $animeLove[1]['status'] ?></li>
                            <li>
                                <div class="action">
                                    <button>
                                        <a href="<?= View::request('Anime/show/'.$animeLove[1]['id']);?>">Detail</a>
                                    </button>
                                    <button class="remove-btn-anime" data-id="<?= $animeLove[1]['id']?>">Remove</button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endif;?>
            <?php if(isset($animeLove[2])):?>
            <div class="third">
                <h1 class="title"><?= $animeLove[2]['title']?></h1>
                <div class="img-wrapper">
                    <img src="<?= $animeLove[2]['imgCover'] ?>" alt="">
                </div>
                <div class="animanga-info">
                    <div class="detail">
                    <ul>
                        <li><?= $animeLove[0]['showType'] ?></li>
                        <li>Rating : <?= $animeLove[0]['rating'] ?></li>
                        <li>Age Rating : <?= $animeLove[0]['ratingRank'] ?></li>
                        <li>Aired : <?= $animeLove[0]['aired'] ?></li>
                        <li>User : <?= $animeLove[0]['user'] ?></li>
                        <li>Status : <?= $animeLove[0]['status'] ?></li>
                        <li class="action">
                            <button>
                                <a href="<?= View::request('Anime/show/'.$animeLove[1]['id']);?>">Detail</a>
                            </button>
                            <button class="remove-btn-anime" data-id="<?= $animeLove[2]['id']?>">Remove</button>
                        </li>
                    </ul>
                    </div>
                </div>
            </div>
            <?php endif;?>
        </div>
        <?php endforeach; ?>
        <?php endif;?>
    </div>
    <!-- MANGA -->
    <div id="card-list-manga">
        <h1 class="title-type">Manga</h1>
        <?php if(isset($mangasLove)): ?>
        <?php foreach($mangasLove as $key => $mangaLove ): ?>
        <div class="card-list-love">
            <?php if(isset($mangaLove[0])): ?>
            <div class="first">
                <h1 class="animanga-title" ><?= $mangaLove[0]['title']?></h1>
                <div class="animanga-info">
                    <div class="img-wrapper">   
                        <img src="<?= $mangaLove[0]['imgPosterFl'] ?>" alt="">
                        <div class="detail">      
                        <ul>
                            <li>Rating : <?= $mangaLove[0]['rating'] ?></li>
                            <li>Age Rating : <?= $mangaLove[0]['ratingRank'] ?></li>
                            <li>Aired : <?= $mangaLove[0]['aired'] ?></li>
                            <li>User : <?= $mangaLove[0]['user'] ?></li>
                            <li>Status : <?= $mangaLove[0]['status'] ?></li>
                            <li>Serialization by : <?= $mangaLove[0]['serialization'] ?></li>
                            <li>
                                <div class="action">
                                    <button>
                                        <a href="<?= View::request('Manga/show/'.$mangaLove[0]['id']);?>">Detail</a>
                                    </button>
                                    <button class="remove-btn-manga" data-id="<?= $mangaLove[0]['id']?>">Remove</button>
                                </div>
                            </li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if(isset($mangaLove[1])):?>
            <div class="second">
                <h1 class="title"><?= $mangaLove[1]['title']?></h1>
                <div class="animanga-info">
                    <img src="<?= $mangaLove[1]['imgPoster'] ?>" alt="">
                    <div class="detail">
                        <ul>
                            <li>Rating :  <?= $mangaLove[1]['rating'] ?> </li>
                            <li>Age Rating :  <?= $mangaLove[1]['ratingRank']?> </li>
                            <li>Aired :  <?= $mangaLove[1]['aired'] ?> </li>
                            <li>User :  <?= $mangaLove[1]['user'] ?> </li>
                            <li>Status :  <?= $mangaLove[1]['status'] ?> </li>
                            <li>Serialization by :  <?= $mangaLove[1]['serialization']?> </li>
                            <li>
                                <div class="action">
                                    <button>
                                        <a href="<?= View::request('Manga/show/'.$mangaLove[1]['id']);?>">Detail</a>
                                    </button>
                                    <button class="remove-btn-manga" data-id="<?= $mangaLove[1]['id']?>">Remove</button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endif;?>
            <?php if(isset($mangaLove[2])):?>
            <div class="third">
                <h1 class="title"><?= $mangaLove[2]['title']?></h1>
                <div class="img-wrapper">
                    <img src="<?= $mangaLove[2]['imgCover'] ?>" alt="">
                </div>
                <div class="animanga-info">
                    <div class="detail">
                    <ul>
                    <li>Rating :  <?= $mangaLove[2]['rating'] ?> </li>
                        <li>Age Rating :  <?= $mangaLove[2]['ratingRank']?> </li>
                        <li>Aired :  <?= $mangaLove[2]['aired'] ?> </li>
                        <li>User :  <?= $mangaLove[2]['user'] ?> </li>
                        <li>Status :  <?= $mangaLove[2]['status'] ?> </li>
                        <li>Serialization by :  <?= $mangaLove[2]['serialization']?> </li>
                        <li>
                            <div class="action">
                                <button>
                                    <a href="<?= View::request('Manga/show/'.$mangaLove[2]['id']);?>">Detail</a>
                                </button>
                                <button class="remove-btn-manga" data-id="<?= $mangaLove[2]['id']?>">Remove</button>
                            </div>
                        </li>
                    </ul>
                    </div>
                </div>
            </div>
            <?php endif;?>
        </div>
        <?php endforeach; ?>
        <?php endif;?>
    </div>
</section>
<?= View::build('templates/footer');?>