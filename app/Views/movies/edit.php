<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<h2>Edit Movie</h2>

<form method="post" action="<?= base_url('movies/update/'.$movie['id']) ?>">
    <label>Title:</label>
    <input type="text" name="title" value="<?= $movie['title'] ?>" required><br>

    <label>Genre:</label>
    <input type="text" name="genre" value="<?= $movie['genre'] ?>" required><br>

    <label>Release Year:</label>
    <input type="number" name="release_year" value="<?= $movie['release_year'] ?>" required><br>

    <button type="submit">Update Movie</button>
</form>

<?= $this->endSection() ?>
