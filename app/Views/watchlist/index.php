<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12">
                <h1 class="section-title">My Watchlist</h1>
                <p class="text-muted">Keep track of movies you want to watch.</p>
            </div>
        </div>
        
        
        <div class="row">
            <?php if(!empty($watchlistItems)): ?>
                <?php foreach($watchlistItems as $item): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="movie-card">
                            <div class="movie-card-img">
                                <?php if($item['poster_path']): ?>
                                    <img src="https://image.tmdb.org/t/p/w500<?= $item['poster_path'] ?>" alt="<?= $item['title'] ?>" class="img-fluid">
                                <?php else: ?>
                                    <img src="<?= base_url('assets/images/no-poster.jpg') ?>" alt="No poster available" class="img-fluid">
                                <?php endif; ?>
                                <div class="movie-card-overlay">
                                    <a href="<?= base_url('movies/view/' . $item['tmdb_id']) ?>" class="btn btn-sm btn-primary mb-2 w-100">
                                        <i class="fas fa-info-circle me-2"></i>Details
                                    </a>
                                    <a href="<?= base_url('watchlist/remove/' . $item['id']) ?>" class="btn btn-sm btn-outline-light w-100">
    <i class="fas fa-trash me-2"></i>Remove
</a>
                                    </a>
                                </div>
                            </div>
                            <div class="movie-card-body">
                                <h5 class="movie-card-title"><?= $item['title'] ?></h5>
                                <div class="movie-card-rating">
                                    <div class="stars">
                                        <?php 
                                        $rating = $item['vote_average'] / 2;
                                        $fullStars = floor($rating);
                                        $halfStar = $rating - $fullStars >= 0.5;
                                        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                        
                                        for($i = 0; $i < $fullStars; $i++): ?>
                                            <i class="fas fa-star"></i>
                                        <?php endfor; ?>
                                        
                                        <?php if($halfStar): ?>
                                            <i class="fas fa-star-half-alt"></i>
                                        <?php endif; ?>
                                        
                                        <?php for($i = 0; $i < $emptyStars; $i++): ?>
                                            <i class="far fa-star"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <span><?= number_format($item['vote_average'], 1) ?></span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="badge badge-custom">Movie</span>
                                    <span class="text-muted">
                                        <?= isset($item['release_date']) ? date('Y', strtotime($item['release_date'])) : 'TBA' ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <div class="py-5">
                        <i class="fas fa-film fa-4x mb-3 text-muted"></i>
                        <h4>Your watchlist is empty</h4>
                        <p class="text-muted">Start adding movies to keep track of what you want to watch.</p>
                        <a href="<?= base_url('movies') ?>" class="btn btn-primary mt-3">
                            <i class="fas fa-search me-2"></i>Browse Movies
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?= $this->endSection() ?>

  
 