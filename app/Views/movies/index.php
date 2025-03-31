<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12">
                <h1 class="section-title">Discover Movies</h1>
                <p class="text-muted">Browse through our vast collection of movies.</p>
            </div>
        </div>
        
        <!-- Search Bar -->
        <div class="row mb-5">
            <div class="col-md-8 mx-auto">
                <form action="<?= base_url('movies/search') ?>" method="get" class="d-flex">
                    <input type="text" name="q" class="form-control form-control-lg me-2" placeholder="Search for movies...">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
        
        <!-- Movie Grid -->
        <div class="row">
            <?php if(isset($movies['results']) && !empty($movies['results'])): ?>
                <?php foreach($movies['results'] as $movie): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="movie-card">
                            <div class="movie-card-img">
                                <?php if($movie['poster_path']): ?>
                                    <img src="<?= $tmdb->getPosterUrl($movie['poster_path']) ?>" alt="<?= $movie['title'] ?>" class="img-fluid">
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
                    <p>No movies found.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Pagination -->
        <?php if(isset($movies['total_pages']) && $movies['total_pages'] > 1): ?>
            <div class="row mt-5">
                <div class="col-12">
                    <nav>
                        <ul class="pagination justify-content-center">
                            <?php if($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?= base_url('movies?page=' . ($page - 1)) ?>">Previous</a>
                                </li>
                            <?php endif; ?>
                            
                            <?php
                            $start = max(1, $page - 2);
                            $end = min($movies['total_pages'], $page + 2);
                            
                            for($i = $start; $i <= $end; $i++): ?>
                                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= base_url('movies?page=' . $i) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if($page < $movies['total_pages']): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?= base_url('movies?page=' . ($page + 1)) ?>">Next</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>




<?= $this->endSection() ?>