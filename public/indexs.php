<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieFlix - Home</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

</head>
<body>
    <header>
        <div class="logo">MovieFlix</div>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Movies</a></li>
                <li><a href="#">Genres</a></li>
                <li><a href="#">Login</a></li>
            </ul>
        </nav>
    </header>
    
    <section class="hero">
        <div class="hero-content">
            <h1>Welcome to MovieFlix</h1>
            <p>Stream and explore your favorite movies anytime.</p>
            <a href="#movies" class="btn">Browse Movies</a>
        </div>
    </section>
    
    <section id="movies" class="movies-grid">
        <h2>Trending Movies</h2>
        <div class="grid">
            <div class="movie-card">
                <img src="assets/images/movie1.jpg" alt="Movie 1">
                <h3>Movie Title 1</h3>
            </div>
            <div class="movie-card">
                <img src="assets/images/movie2.jpg" alt="Movie 2">
                <h3>Movie Title 2</h3>
            </div>
            <div class="movie-card">
                <img src="assets/images/movie3.jpg" alt="Movie 3">
                <h3>Movie Title 3</h3>
            </div>
            <div class="movie-card">
                <img src="assets/images/movie4.jpg" alt="Movie 4">
                <h3>Movie Title 4</h3>
            </div>
        </div>
    </section>
    
    <footer>
        <p>&copy; 2025 MovieFlix. All rights reserved.</p>
    </footer>
</body>
</html>
