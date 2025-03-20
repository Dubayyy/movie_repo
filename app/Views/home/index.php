<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<!-- Hero Section -->
<section class="hero-section">
    <div class="container hero-content">
        <div class="row">
            <div class="col-lg-7">
                <h1 class="hero-title">Discover <span>Cinematic</span> Excellence</h1>
                <p class="hero-subtitle">Your personal journey through the world of film starts here.</p>
                <a href="<?= base_url('movies') ?>" class="btn btn-light btn-custom me-3">
                    <i class="fas fa-film me-2"></i>Explore Movies
                </a>
                <a href="<?= base_url('auth/register') ?>" class="btn btn-outline-light btn-custom">
                    <i class="fas fa-user-plus me-2"></i>Join Now
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Featured Movies Section -->
<section class="section-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="section-title">Featured Films</h2>
                <p class="text-muted">Our curated selection of must-watch movies.</p>
            </div>
        </div>
        
        <div class="row">
            <?php if(isset($featured_movies['results']) && !empty($featured_movies['results'])): ?>
                <?php 
                $count = 0;
                foreach($featured_movies['results'] as $movie): 
                    if($count >= 8) break; // Limit to 8 movies
                    $count++;
                ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="movie-card">
                            <div class="movie-card-img">
                            <?php if($movie['poster_path']): ?>
    <img src="<?= $getPosterUrl($movie['poster_path']) ?>" alt="<?= $movie['title'] ?>" class="img-fluid">
<?php else: ?>
    <img src="<?= base_url('assets/images/no-poster.jpg') ?>" alt="No poster available" class="img-fluid">
<?php endif; ?>
                                <div class="movie-card-overlay">
                                    <a href="<?= base_url('movies/view/' . $movie['id']) ?>" class="btn btn-sm btn-primary mb-2 w-100">
                                        <i class="fas fa-info-circle me-2"></i>Details
                                    </a>
                                    <?php if(session()->get('isLoggedIn')): ?>
                                        <a href="<?= base_url('watchlist/add/' . $movie['id']) ?>" class="btn btn-sm btn-outline-light w-100">
                                            <i class="fas fa-plus me-2"></i>Add to Watchlist
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="movie-card-body">
                                <h5 class="movie-card-title"><?= $movie['title'] ?></h5>
                                <div class="movie-card-rating">
                                    <div class="stars">
                                        <?php 
                                        $rating = $movie['vote_average'] / 2;
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
                                    <span><?= number_format($movie['vote_average'], 1) ?></span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <?php if(isset($movie['genre_ids']) && !empty($movie['genre_ids'])): ?>
                                        <span class="badge badge-custom">
                                            <?php 
                                            // Simplified genre mapping
                                            $genres = [
                                                28 => 'Action',
                                                12 => 'Adventure',
                                                16 => 'Animation',
                                                35 => 'Comedy',
                                                80 => 'Crime',
                                                18 => 'Drama',
                                                10751 => 'Family',
                                                14 => 'Fantasy',
                                                36 => 'History',
                                                27 => 'Horror',
                                                10402 => 'Music',
                                                9648 => 'Mystery',
                                                10749 => 'Romance',
                                                878 => 'Sci-Fi',
                                                53 => 'Thriller'
                                            ];
                                            
                                            if(isset($genres[$movie['genre_ids'][0]])):
                                                echo $genres[$movie['genre_ids'][0]];
                                            else:
                                                echo 'Movie';
                                            endif;
                                            ?>
                                        </span>
                                    <?php endif; ?>
                                    <span class="text-muted">
                                        <?= isset($movie['release_date']) ? date('Y', strtotime($movie['release_date'])) : 'TBA' ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p>No featured movies available at the moment.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-5">
            <a href="<?= base_url('movies') ?>" class="btn btn-outline-dark btn-custom">
                View All Movies <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Keep the rest of the homepage content (Features Section, etc.) -->
<?= $this->endSection() ?>