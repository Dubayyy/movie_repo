<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<h2>Movies List</h2>
<a href="<?= base_url('movies/create') ?>">Add New Movie</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Genre</th>
        <th>Release Year</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($movies as $movie): ?>
        <tr>
            <td><?= $movie['id'] ?></td>
            <td><?= $movie['title'] ?></td>
            <td><?= $movie['genre'] ?></td>
            <td><?= $movie['release_year'] ?></td>
            <td>
                <a href="<?= base_url('movies/edit/'.$movie['id']) ?>">Edit</a> | 
                <a href="<?= base_url('movies/delete/'.$movie['id']) ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?= $this->endSection() ?>
