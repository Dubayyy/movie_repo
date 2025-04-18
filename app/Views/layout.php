<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'CineVerse - Your Ultimate Movie Experience' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">CineVerse</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('movies') ?>">Discover</a>
                    </li>
                    
                    <?php if(session()->get('isLoggedIn')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('watchlist') ?>">Watchlist</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i><?= session()->get('username') ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="<?= base_url('profile') ?>"><i class="fas fa-user me-2"></i>Profile</a></li>
                                <li><hr class="dropdown-divider divider-light"></li>
                                <li><a class="dropdown-item" href="<?= base_url('auth/logout') ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('auth/login') ?>">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('auth/register') ?>">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>


       <!-- Live Search Box -->
<div class="ms-auto me-3 position-relative">
    <input type="text" id="liveSearch" class="form-control" placeholder="Search movies...">
    <div id="searchResults" class="position-absolute w-100 mt-1 bg-white shadow-lg rounded d-none" style="z-index: 1000; max-height: 400px; overflow-y: auto;"></div>
</div>
        </div>
    </nav>


    <div class="container mt-3">
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('warning')): ?>
        <div class="alert alert-warning">
            <?= session()->getFlashdata('warning') ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>




</div>


    <!-- Main Content -->
    <?= $this->renderSection('content') ?>


<!-- Geolocation Theater Finder Section -->
<section class="py-4 bg-light" id="nearbyTheatersSection">
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle p-3 me-3">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h4 class="mb-0">Find Theaters Near You</h4>
                        </div>
                        
                        <p class="text-muted">Looking for a place to watch the latest movies? Use your location to find theaters in your area.</p>
                        
                        <div id="geoContent">
                            <button class="btn btn-primary" onclick="getLocation()">
                                <i class="fas fa-location-arrow me-2"></i>Find Nearby Theaters
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Footer -->
<footer class="footer">
  

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h3 class="footer-title mb-4">CineVerse</h3>
                    <p class="text-light opacity-75">Your ultimate destination for movies. Discover, review, and keep track of your favorite films all in one place.</p>
                    <div class="social-icons mt-4">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-2 col-6 mb-4 mb-md-0">
                    <h5 class="text-white mb-4">Explore</h5>
                    <ul class="footer-links">
                        <li><a href="<?= base_url() ?>">Home</a></li>
                        <li><a href="<?= base_url('movies') ?>">Movies</a></li>
                        <li><a href="<?= base_url('watchlist') ?>">Watchlist</a></li>
                        <li><a href="#">Top Rated</a></li>
                    </ul>
                </div>
                <div class="col-md-2 col-6 mb-4 mb-md-0">
                    <h5 class="text-white mb-4">Links</h5>
                    <ul class="footer-links">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="text-white mb-4">Stay Updated</h5>
                    <p class="text-light opacity-75">Subscribe to our newsletter for the latest movie updates.</p>
                    <form class="mt-3">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Your Email">
                            <button class="btn btn-primary" type="button">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <hr class="mt-4 mb-4 divider-light">
            <div class="text-center text-light opacity-75">
                <p class="mb-0">&copy; <?= date('Y') ?> CineVerse. All rights reserved.</p>
            </div>
           
     <!-- TMDB attribution  -->
     <div class="text-center mt-3">
            <p class="small text-white">
                <a href="https://www.themoviedb.org/" target="_blank" class="me-2">
                    <img src="https://www.themoviedb.org/assets/2/v4/logos/v2/blue_short-8e7b30f73a4020692ccca9c88bafe5dcb6f8a62a4c6bc55cd9ba82bb2cd95f6c.svg" alt="TMDB" height="20">
                </a>
                This product uses the TMDB API but is not endorsed or certified by TMDB.
            </p>
        </div>
</div>
        </div>
    </footer>



      <!-- search implementation -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?= $this->renderSection('scripts') ?>

    <script>

 document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('liveSearch');
    const searchResults = document.getElementById('searchResults');
    let searchTimeout;
    
    if (searchInput && searchResults) {
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            // Clear previous timeout
            clearTimeout(searchTimeout);
            
            // Hide results if query is empty
            if (query === '') {
                searchResults.classList.add('d-none');
                return;
            }
            
            // Set a timeout to avoid making requests for every keystroke
            searchTimeout = setTimeout(function() {
                // Make AJAX request
                fetch(`<?= base_url('api/search') ?>?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        // Clear previous results
                        searchResults.innerHTML = '';
                        
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
                            
                            searchResults.appendChild(resultsList);
                            searchResults.classList.remove('d-none');
                        } else {
                            // Show no results message
                            searchResults.innerHTML = '<div class="p-3 text-center">No results found</div>';
                            searchResults.classList.remove('d-none');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }, 300); // Wait 300ms after last keystroke before searching
        });
        
        // Hide results when clicking outside
        document.addEventListener('click', function(event) {
            if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
                searchResults.classList.add('d-none');
            }
        });
        
        // Show results when focusing on search input if it has value
        searchInput.addEventListener('focus', function() {
            if (this.value.trim() !== '') {
                searchResults.classList.remove('d-none');
            }
        });
    }
});
</script>

   <!-- Quick View  -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Add quick view buttons to movie cards
    document.querySelectorAll('.movie-card').forEach(function(card) {
        // Find the movie ID
        const detailsLink = card.querySelector('a[href*="movies/view/"]');
        if (detailsLink) {
            const href = detailsLink.getAttribute('href');
            const movieId = href.substring(href.lastIndexOf('/') + 1);
            card.setAttribute('data-movie-id', movieId);
            
            // Add a quick view button
            const overlay = card.querySelector('.movie-card-overlay');
            if (overlay) {
                const quickViewBtn = document.createElement('button');
                quickViewBtn.className = 'btn btn-sm btn-primary w-100 mt-2 quick-view-btn';
                quickViewBtn.innerHTML = '<i class="fas fa-eye me-2"></i>Quick View';
                quickViewBtn.setAttribute('data-movie-id', movieId);
                overlay.appendChild(quickViewBtn);
            }
        }
    });
    
    // Set up modal
    const quickViewModal = new bootstrap.Modal(document.getElementById('quickViewModal'));
    const quickViewContent = document.getElementById('quickViewContent');
    
    // Add click event to quick view buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.quick-view-btn')) {
            e.preventDefault();
            const btn = e.target.closest('.quick-view-btn');
            const movieId = btn.getAttribute('data-movie-id');
            
            // Show loading state
            quickViewContent.innerHTML = `
              <div class="d-flex justify-content-center align-items-center p-5">
                <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
            `;
            
            // Show modal
            quickViewModal.show();
            
            // Fetch movie data
            fetch('<?= base_url('api/quick-view') ?>?id=' + movieId)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        quickViewContent.innerHTML = data.html;
                    } else {
                        quickViewContent.innerHTML = `
                          <div class="p-4 text-white">
                            <div class="alert alert-danger">Error: ${data.message}</div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    quickViewContent.innerHTML = `
                      <div class="p-4 text-white">
                        <div class="alert alert-danger">An error occurred. Please try again.</div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      </div>
                    `;
                });
        }
    });
});
</script>



<!-- Movie Quick View Modal -->
<div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content bg-dark">
      <div class="modal-body p-0">
        <div id="quickViewContent">
          <div class="d-flex justify-content-center align-items-center p-5">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- Mobile Device Detection Feature -->

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Improved mobile detection
  function isMobileDevice() {
    // Check if the screen width is mobile-sized AND
    // either has touch capability OR matches mobile user agent
    const isMobileWidth = window.innerWidth < 768;
    const hasTouchCapability = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
    const isMobileUserAgent = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    
    return isMobileWidth && (hasTouchCapability || isMobileUserAgent);
  }
  
  // Apply mobile-specific enhancements only if is on mobile
  if (isMobileDevice()) {
    // Add mobile class to body
    document.body.classList.add('mobile-device');
    
    // Adjust movie cards for touch
    document.querySelectorAll('.movie-card-overlay').forEach(overlay => {
      overlay.style.opacity = '1';
      overlay.style.transform = 'translateY(0)';
    });
    
    // Show a mobile-friendly message
    const mobileMessage = document.createElement('div');
    mobileMessage.className = 'alert alert-info alert-dismissible fade show mb-0';
    mobileMessage.innerHTML = `
      <i class="fas fa-mobile-alt me-2"></i>
      You're viewing the mobile-optimized version of CineVerse
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    // Insert after navbar
    const navbar = document.querySelector('.navbar');
    if (navbar && navbar.nextElementSibling) {
      navbar.parentNode.insertBefore(mobileMessage, navbar.nextElementSibling);
    }
  }
});
</script>




<!-- Geolocation JavaScript -->
<script>
function getLocation() {
    const geoContent = document.getElementById('geoContent');
    
    // Check if geolocation is available
    if ("geolocation" in navigator) {
        geoContent.innerHTML = '<div class="d-flex align-items-center"><div class="spinner-border text-primary me-3" role="status"></div><p class="mb-0">Getting your location...</p></div>';
        
        navigator.geolocation.getCurrentPosition(
            // Success
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                geoContent.innerHTML = `
                    <div class="alert alert-success">
                        <p>We found theaters near your location <small>(${lat.toFixed(4)}, ${lng.toFixed(4)})</small></p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5>Cinema City</h5>
                                    <p class="text-muted">2.3 miles away</p>
                                    <div class="small mb-2">
                                        <div class="text-success"><i class="fas fa-circle me-1"></i> Open Now</div>
                                        <div>Shows every 30 min</div>
                                    </div>
                                    <a href="#" class="btn btn-sm btn-outline-primary">View Showtimes</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5>Regal Multiplex</h5>
                                    <p class="text-muted">3.1 miles away</p>
                                    <div class="small mb-2">
                                        <div class="text-success"><i class="fas fa-circle me-1"></i> Open Now</div>
                                        <div>IMAX Available</div>
                                    </div>
                                    <a href="#" class="btn btn-sm btn-outline-primary">View Showtimes</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5>AMC Theaters</h5>
                                    <p class="text-muted">5.4 miles away</p>
                                    <div class="small mb-2">
                                        <div class="text-success"><i class="fas fa-circle me-1"></i> Open Now</div>
                                        <div>Luxury Seating</div>
                                    </div>
                                    <a href="#" class="btn btn-sm btn-outline-primary">View Showtimes</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-3">
                        <button class="btn btn-outline-secondary" onclick="getLocation()">
                            <i class="fas fa-sync-alt me-2"></i>Refresh Location
                        </button>
                    </div>
                `;
            },
            // Error
            function(error) {
                let errorMessage = "Could not access your location.";
                
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        errorMessage = "Location access was denied. Please allow location access to use this feature.";
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMessage = "Location information is unavailable at this time.";
                        break;
                    case error.TIMEOUT:
                        errorMessage = "Location request timed out. Please try again.";
                        break;
                }
                
                geoContent.innerHTML = `
                    <div class="alert alert-warning">
                        <p class="mb-2"><i class="fas fa-exclamation-triangle me-2"></i>${errorMessage}</p>
                        <button class="btn btn-sm btn-primary" onclick="getLocation()">Try Again</button>
                    </div>
                `;
            }
        );
    } else {
        geoContent.innerHTML = '<div class="alert alert-danger">Geolocation is not supported by your browser.</div>';
    }
}


</script>
</body>
</html>