<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="jumbotron">
    <h1 class="display-4">Welcome to Ellflix</h1>
    <p class="lead">Discover, track, and review your favorite movies.</p>
    <hr class="my-4">
    <p>Browse our extensive collection of movies or search for your favorites.</p>
    <a class="btn btn-primary btn-lg" href="<?= base_url('movies') ?>" role="button">Browse Movies</a>
</div>
<div class="row mt-5">
    <div class="col-12">
        <h2>Featured Movies</h2>
        <p>Our API integration will load dynamic content here in Milestone 3.</p>
    </div>
</div>
<?= $this->endSection() ?>