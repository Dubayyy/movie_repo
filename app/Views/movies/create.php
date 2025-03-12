<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<h2>Add New Movie</h2>

<form method="post" action="<?= base_url('movies/store') ?>">
    <label>Title:</label>
    <input type="text" name="title" required><br>

    <label>Genre:</label>
    <input type="text" name="genre" required><br>

    <label>Release Year:</label>
    <input type="number" name="release_year" required><br>

    <button type="submit">Save Movie</button>
</form>

<?= $this->endSection() ?>

