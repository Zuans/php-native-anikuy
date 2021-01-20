<!-- CSS Declare -->
<?= View::setCSS('navbar') ?>
<?= View::setCSS('footer') ?>
<?= isset($popularAnime) ? View::setCSS('anime-home') : View::setCSS('manga-home'); ?>

<!-- JS Declare -->
<?= View::setJS('app/navbar')?>
<?= View::setAsyncJS('index'); ?>

<!-- Build -->
<?= View::build('templates/header') ?>
<?= View::build('templates/navbar') ?>
    <section id="hero" >
        <div class="hero-body">
            <h1 class="hero-title">AniKuy</h1>
            <h4 class="hero-caption">
                <?php if(isset($popularAnime)): ?>
                    Tempat buat cari anime doang
                <?php else: ?>
                    Tempat buat cari manga doang
                <?php endif; ?>
            </h4>
        </div>
    </section>
    <?php if( isset($popularAnime)) : ?>
    <section id="body-anime" >
        <div class="anime-list-wrapper">
            <div class="favorites-anime">
                <h1>Favorites Anime</h1>
                <div class="card-list">
                    <?php foreach($popularAnime as $anime ): ?>
                            <div class="card">
                                <div class="img-wrapper">
                                    <img src="<?= $anime['imgPoster'] ?>" alt="">
                                    <i class="fas fa-star icons icon-rating "><span><?= $anime['rating'] ?></span></i>
                                    <i class="fas fa-user icons icon-user"><span><?= $anime['user'] ?> </span></i>
                                    <i class="fas fa-tv icons icon-eps "><span><?= $anime['epsCount']?></span></i>
                                </div>
                                <div class="content-wrapper">
                                    <h1><?= $anime['title']?></h1>
                                    <h4 class="anime-status">Status&nbsp;<?= $anime['status'] ?> </h4>
                                    <span class="anime-synopsis" ><?= $anime['synopsis']?></span>
                                    <a  href="<?= View::request("Anime/show/" . $anime['id'] )?>" class="btn-details" >Details</a>
                                </div>
                            </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="anime-list">
                <h2>Anime List</h2>
                <form action="<?= View::request('Anime/search')?>" method="POST" class="anime-search" >
                    <div class="form-group">
                        <input type="text" id="anime-name" name="text" autocomplete="off"  required>
                        <span class="input-label"  >Search Anime &nbsp; <i class="fas fa-search"></i></span>
                        <span class="underline"></span>
                    </div>
                    <div class="form-group">
                        <select name=""  id="select-genre" class="select-genre" id="">
                            <option value="action">Action</option>
                            <option value="harem">Harem</option>
                            <option value="romance">Romance</option>
                            <option value="adventure">Adventure</option>
                            <option value="ecchi">Ecchi</option>
                            <option value="school">School</option>
                            <option value="mystery">Mystery</option>
                        </select>
                    </div>
                </form>
                <div class="anime-result" id="anime-result" >
                    <h2 id="title-content" > <?= $typeSearch;?> </h2>
                    <div class="card-list">
                        <?php if(count($allAnime) > 0) : ?>
                            <?php foreach($allAnime as $anime ): ?>
                                <div class="card">
                                <div class="img-wrapper">
                                    <img src="<?= $anime['imgPoster'] ?>" alt="">
                                    <i class="fas fa-star icons icon-rating "><span><?= $anime['rating'] ?></span></i>
                                    <i class="fas fa-user icons icon-user "><span><?= $anime['user'] ?> </span></i>
                                    <i class="fas fa-tv icons icon-eps "><span><?= $anime['epsCount']?></span></i>
                                </div>
                                <div class="content-wrapper">
                                    <h1><?= $anime['title']?></h1>
                                    <h4 class="anime-status">Status&nbsp;<?= $anime['status'] ?> </h4>
                                    <span class="anime-synopsis" ><?= $anime['synopsis']?></span>
                                    <a  href="<?= View::request("Anime/show/" . $anime['id'] )?>" class="btn-details" >Details</a>
                                </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php else:?>
        <section id="body-manga" >
        <div class="manga-list-wrapper">
            <div class="favorites-manga">
                <h1>Favorites Manga</h1>
                <div class="card-list">
                    <?php foreach($popularManga as $manga ): ?>
                            <div class="card">
                                <div class="img-wrapper">
                                    <img src="<?= $manga['imgPoster'] ?>" alt="">
                                    <i class="fas fa-star icons icon-rating "><span><?= $manga['rating'] ?></span></i>
                                    <i class="fas fa-user icons icon-user"><span><?= $manga['user'] ?> </span></i>
                                    <i class="fas fa-tv icons icon-eps "><span><?= $manga['chapCount']?></span></i>
                                </div>
                                <div class="content-wrapper">
                                    <h1><?= $manga['title']?></h1>
                                    <h4 class="manga-serial">Serialize By <?= $manga['serialization']?></h4>
                                    <h4 class="manga-status">Status&nbsp;<?= $manga['status'] ?> </h4>
                                    <span class="manga-synopsis" ><?= $manga['synopsis']?></span>
                                    <a  href="<?= View::request("Manga/show/" . $manga['id'] )?>" class="btn-details" >Details</a>
                                </div>
                            </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="manga-list">
                <h2>Manga List</h2>
                <form action="<?= View::request('Manga/search')?>" method="POST" class="manga-search" >
                    <div class="form-group">
                        <input type="text" id="manga-name" name="text" autocomplete="off"  required>
                        <span class="input-label"  >Search Manga &nbsp; <i class="fas fa-search"></i></span>
                        <span class="underline"></span>
                    </div>
                    <div class="form-group">
                        <select name=""  id="select-genre" class="select-genre" id="">
                            <option value="action">Action</option>
                            <option value="harem">Harem</option>
                            <option value="romance">Romance</option>
                            <option value="adventure">Adventure</option>
                            <option value="ecchi">Ecchi</option>
                            <option value="school">School</option>
                            <option value="mystery">Mystery</option>
                        </select>
                    </div>
                </form>
                <div class="manga-result" id="manga-result" >
                <h2 id="title-content" > <?= $typeSearch;?> </h2>
                    <div class="card-list">
                        <?php if(count($allManga) > 0) : ?>
                            <?php foreach($allManga as $manga ): ?>
                                <div class="card">
                                <div class="img-wrapper">
                                    <img src="<?= $manga['imgPoster'] ?>" alt="">
                                    <i class="fas fa-star icons icon-rating "><span><?= $manga['rating'] ?></span></i>
                                    <i class="fas fa-user icons icon-user "><span><?= $manga['user'] ?> </span></i>
                                    <i class="fas fa-tv icons icon-eps "><span><?= $manga['chapCount']?></span></i>
                                </div>
                                <div class="content-wrapper">
                                    <h1><?= $manga['title']?></h1>
                                    <h4 class="manga-serial">Serialize By <?= $manga['serialization']?></h4>
                                    <h4 class="manga-status">Status&nbsp;<?= $manga['status'] ?> </h4>
                                    <span class="manga-synopsis" ><?= $manga['synopsis']?></span>
                                    <a  href="<?= View::request("Manga/show/" . $manga['id'] )?>" class="btn-details" >Details</a>
                                </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif;?>
<?= View::build('templates/footer') ?>
