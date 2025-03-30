<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12">
                <h1 class="section-title">Search Results</h1>
                <p class="text-muted">Results for: "<?= $query ?>"</p>
            </div>
        </div>
        
     <!-- Search Bar -->
<div class="row mb-5">
    <div class="col-md-8 mx-auto">
        <form action="<?= base_url('movies/search') ?>" method="get" class="position-relative">
            <div class="input-group">
                <input type="text" name="q" id="pageSearch" class="form-control form-control-lg" placeholder="Search for movies..." value="<?= $query ?>">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
            </div>
            <div id="pageSearchResults" class="position-absolute w-100 bg-white shadow rounded mt-1 d-none" style="z-index: 1000; max-height: 400px; overflow-y: auto;"></div>
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
                <div class="col-12 text-center py-5">
                    <i class="fas fa-search fa-3x mb-3 text-muted"></i>
                    <h3>No results found</h3>
                    <p class="text-muted">Try different keywords or browse our popular movies.</p>
                    <a href="<?= base_url('movies') ?>" class="btn btn-primary mt-3">Browse Movies</a>
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
                                    <a class="page-link" href="<?= base_url('movies/search?q=' . $query . '&page=' . ($page - 1)) ?>">Previous</a>
                                </li>
                            <?php endif; ?>
                            
                            <?php
                            $start = max(1, $page - 2);
                            $end = min($movies['total_pages'], $page + 2);
                            
                            for($i = $start; $i <= $end; $i++): ?>
                                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= base_url('movies/search?q=' . $query . '&page=' . $i) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if($page < $movies['total_pages']): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?= base_url('movies/search?q=' . $query . '&page=' . ($page + 1)) ?>">Next</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const pageSearchInput = document.getElementById('pageSearch');
    const pageSearchResults = document.getElementById('pageSearchResults');
    let pageSearchTimeout;
    
    if (pageSearchInput && pageSearchResults) {
        pageSearchInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            // Clear previous timeout
            clearTimeout(pageSearchTimeout);
            
            // Hide results if query is empty
            if (query === '') {
                pageSearchResults.classList.add('d-none');
                return;
            }
            
            // Set a timeout to avoid making requests for every keystroke
            pageSearchTimeout = setTimeout(function() {
                // Make AJAX request
                fetch(`<?= base_url('api/search') ?>?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        // Clear previous results
                        pageSearchResults.innerHTML = '';
                        
                        if (data.results && data.results.length > 0) {
                            // Build results HTML
                            const resultsList = document.createElement('div');
                            resultsList.className = 'list-group';
                            
                            data.results.slice(0, 5).forEach(movie => {
                                const resultItem = document.createElement('a');
                                resultItem.className = 'list-group-item list-group-item-action d-flex align-items-center';
                                resultItem.href = `<?= base_url('movies/view') ?>/${movie.id}`;
                                
                                // Create poster thumbnail
                                let posterHtml = '';
                                if (movie.poster_path) {
                                    posterHtml = `<img src="https://image.tmdb.org/t/p/w92${movie.poster_path}" alt="${movie.title}" class="me-3" style="width: 46px; height: 69px; object-fit: cover;">`;
                                } else {
                                    posterHtml = `<div class="bg-secondary me-3" style="width: 46px; height: 69px;"></div>`;
                                }
                                
                                // Create content section
                                const contentHtml = `
                                    <div>
                                        <div class="fw-bold">${movie.title}</div>
                                        <small>${movie.release_date ? new Date(movie.release_date).getFullYear() : 'N/A'}</small>
                                    </div>
                                `;
                                
                                resultItem.innerHTML = posterHtml + contentHtml;
                                resultsList.appendChild(resultItem);
                            });
                            
                            // Add "View all results" link
                            const viewAllLink = document.createElement('a');
                            viewAllLink.className = 'list-group-item list-group-item-action text-center';
                            viewAllLink.href = `<?= base_url('movies/search') ?>?q=${encodeURIComponent(query)}`;
                            viewAllLink.innerHTML = 'View all results';
                            resultsList.appendChild(viewAllLink);
                            
                            pageSearchResults.appendChild(resultsList);
                            pageSearchResults.classList.remove('d-none');
                        } else {
                            // Show no results message
                            pageSearchResults.innerHTML = '<div class="p-3 text-center">No results found</div>';
                            pageSearchResults.classList.remove('d-none');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }, 300); // Wait 300ms after last keystroke before searching
        });
        
        // Hide results when clicking outside
        document.addEventListener('click', function(event) {
            if (!pageSearchInput.contains(event.target) && !pageSearchResults.contains(event.target)) {
                pageSearchResults.classList.add('d-none');
            }
        });
        
        // Show results when focusing on search input if it has value
        pageSearchInput.addEventListener('focus', function() {
            if (this.value.trim() !== '') {
                pageSearchResults.classList.remove('d-none');
            }
        });
    }
});
</script>
<?= $this->endSection() ?>
