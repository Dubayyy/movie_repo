<?= $this->extend('layout') ?>

<?= $this->section('content') ?>


<!-- Movie Hero Section -->
<!-- Movie Hero Section with extended dark background -->
<section class="py-0">
    <div class="position-relative" style="background: rgba(18, 18, 18, 1);">
        <?php if($movie['backdrop_path']): ?>
            <div style="height: 500px; background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(18, 18, 18, 1)), url('<?= $tmdb->getBackdropUrl($movie['backdrop_path']) ?>'); background-size: cover; background-position: center;"></div>
        <?php else: ?>
            <div style="height: 300px; background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(18, 18, 18, 1));"></div>
        <?php endif; ?>
        
        <div class="container" style="margin-top: -350px; position: relative; z-index: 10;">
            <!-- Movie details remain unchanged -->
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow">
                    <?php if($movie['poster_path']): ?>
                        <img src="<?= $tmdb->getPosterUrl($movie['poster_path']) ?>" alt="<?= $movie['title'] ?>" class="card-img-top">
                    <?php else: ?>
                        <img src="<?= base_url('assets/images/no-poster.jpg') ?>" alt="No poster available" class="card-img-top">
                    <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-9 text-white">
                    <h1 class="display-4 fw-bold"><?= $movie['title'] ?></h1>
                    
                    <?php if(isset($movie['release_date'])): ?>
                        <p class="mb-2"><?= date('Y', strtotime($movie['release_date'])) ?></p>
                    <?php endif; ?>
                    
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <span class="badge bg-primary p-2"><i class="fas fa-star me-1"></i> <?= number_format($movie['vote_average'], 1) ?></span>
                        </div>
                        <div>
                            <?php if(isset($movie['runtime'])): ?>
                                <span class="me-3"><?= floor($movie['runtime'] / 60) ?>h <?= $movie['runtime'] % 60 ?>m</span>
                            <?php endif; ?>
                            
                            <?php if(isset($movie['genres']) && !empty($movie['genres'])): ?>
                                <?php foreach($movie['genres'] as $genre): ?>
                                    <span class="badge badge-custom me-1"><?= $genre['name'] ?></span>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <?php if(session()->get('isLoggedIn')): ?>
                        <div class="mb-4">
                            <?php if($inWatchlist): ?>
                                <a href="<?= base_url('watchlist/remove/' . $dbMovie['id']) ?>" class="btn btn-outline-light me-2">
                                    <i class="fas fa-check me-1"></i> In Watchlist
                                </a>
                            <?php else: ?>
                                <a href="<?= base_url('watchlist/add/' . $dbMovie['id']) ?>" class="btn btn-outline-light me-2">
                                    <i class="fas fa-plus me-1"></i> Add to Watchlist
                                </a>
                            <?php endif; ?>
                            
                            <a href="#review-form" class="btn btn-primary">
                                <i class="fas fa-star me-1"></i> Write a Review
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <h4 class="mt-4 mb-2">Overview</h4>
                    <p class="mb-4"><?= $movie['overview'] ?></p>
                </div>
            </div>
            
            <!-- Cast section now clearly within the dark background -->
            <?php if(isset($movie['credits']['cast']) && !empty($movie['credits']['cast'])): ?>
                <div class="row text-white">
                    <div class="col-12">
                        <h4 class="mb-3">Cast</h4>
                    </div>
                    <?php 
                    $castLimit = 4;
                    $castCount = 0;
                    foreach($movie['credits']['cast'] as $castMember):
                        if($castCount >= $castLimit) break;
                        $castCount++;
                    ?>
                        <div class="col-md-3 col-6 mb-4">
                            <div class="d-flex align-items-center">
                                <?php if(isset($castMember['profile_path']) && $castMember['profile_path']): ?>
                                    <img src="<?= $tmdb->getPosterUrl($castMember['profile_path'], 'w92') ?>" alt="<?= $castMember['name'] ?>" class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="rounded-circle bg-secondary me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <div class="fw-bold"><?= $castMember['name'] ?></div>
                                    <small class="text-light"><?= $castMember['character'] ?></small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <!-- Trailer section also within dark background -->
            <?php if(isset($movie['videos']['results']) && !empty($movie['videos']['results'])): ?>
                <?php 
                $trailer = null;
                foreach($movie['videos']['results'] as $video) {
                    if($video['type'] == 'Trailer') {
                        $trailer = $video;
                        break;
                    }
                }
                
                if($trailer): 
                ?>
                    <div class="row text-white mb-5">
                        <div class="col-12">
                            <h4 class="mb-3">Trailer</h4>
                            <div class="ratio ratio-16x9">
                                <iframe src="https://www.youtube.com/embed/<?= $trailer['key'] ?>" title="<?= $trailer['name'] ?>" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <!-- Add extra padding at the bottom of the dark background section -->
        <div style="height: 30px;"></div>
    </div>
</section>



<!-- Reviews Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="section-title">Reviews</h2>
            </div>
        </div>
        
        <?php if(session()->get('isLoggedIn')): ?>
            <div class="row mb-5">
                <div class="col-md-8 mx-auto">
                    <div class="card" id="review-form">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Write a Review</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('reviews/create/' . $dbMovie['id']) ?>" method="post">
                                <div class="mb-3">
                                    <label for="rating" class="form-label">Rating</label>
                                    <select class="form-select" id="rating" name="rating" required>
                                        <option value="" selected disabled>Select a rating</option>
                                        <option value="1">1 - Poor</option>
                                        <option value="2">2 - Fair</option>
                                        <option value="3">3 - Good</option>
                                        <option value="4">4 - Very Good</option>
                                        <option value="5">5 - Excellent</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="review_text" class="form-label">Your Review</label>
                                    <textarea class="form-control" id="review_text" name="review_text" rows="4" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit Review</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <?php if(!empty($reviews)): ?>
                <?php foreach($reviews as $review): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0"><?= $review['username'] ?></h5>
                                    <div class="stars">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <?php if($i <= $review['rating']): ?>
                                                <i class="fas fa-star text-warning"></i>
                                            <?php else: ?>
                                                <i class="far fa-star text-warning"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <p class="card-text"><?= $review['review_text'] ?></p>
                                <div class="text-muted small">
                                    Posted on <?= date('M d, Y', strtotime($review['created_at'])) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p>No reviews yet. Be the first to review this movie!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Similar Movies Section -->
<?php if(isset($movie['similar']['results']) && !empty($movie['similar']['results'])): ?>
    <section class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="section-title">Similar Movies</h2>
                </div>
            </div>
            
            <div class="row">
                <?php 
                $count = 0;
                foreach($movie['similar']['results'] as $similarMovie): 
                    if($count >= 4) break;
                    $count++;
                ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="movie-card">
                            <div class="movie-card-img">
                            <?php if($similarMovie['poster_path']): ?>
    <img src="<?= $tmdb->getPosterUrl($similarMovie['poster_path']) ?>" alt="<?= $similarMovie['title'] ?>" class="img-fluid">
<?php else: ?>
    <img src="<?= base_url('assets/images/no-poster.jpg') ?>" alt="No poster available" class="img-fluid">
<?php endif; ?> 


                                <div class="movie-card-overlay">
                                    <a href="<?= base_url('movies/view/' . $similarMovie['id']) ?>" class="btn btn-sm btn-primary mb-2 w-100">
                                        <i class="fas fa-info-circle me-2"></i>Details
                                    </a>
                                    <?php if(session()->get('isLoggedIn')): ?>
                                        <a href="<?= base_url('watchlist/add/' . $similarMovie['id']) ?>" class="btn btn-sm btn-outline-light w-100">
                                            <i class="fas fa-plus me-2"></i>Add to Watchlist
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="movie-card-body">
                                <h5 class="movie-card-title"><?= $similarMovie['title'] ?></h5>
                                <div class="movie-card-rating">
                                    <div class="stars">
                                        <?php 
                                        $rating = $similarMovie['vote_average'] / 2;
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
                                    <span><?= number_format($similarMovie['vote_average'], 1) ?></span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <?php if(isset($similarMovie['genre_ids']) && !empty($similarMovie['genre_ids'])): ?>
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
                                            
                                            if(isset($genres[$similarMovie['genre_ids'][0]])):
                                                echo $genres[$similarMovie['genre_ids'][0]];
                                            else:
                                                echo 'Movie';
                                            endif;
                                            ?>
                                        </span>
                                    <?php endif; ?>
                                    <span class="text-muted">
                                        <?= isset($similarMovie['release_date']) ? date('Y', strtotime($similarMovie['release_date'])) : 'TBA' ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="text-center mt-4">
                <a href="<?= base_url('movies?similar_to=' . $movie['id']) ?>" class="btn btn-outline-dark btn-custom">
                    View More Similar Movies <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>
<?php endif; ?>
<?= $this->endSection() ?>