<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">My Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 text-center mb-4 mb-md-0">
                                <div class="bg-light rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                    <i class="fas fa-user fa-4x text-primary"></i>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <h3><?= $user['username'] ?></h3>
                                <p class="text-muted"><?= $user['email'] ?></p>
                                
                                <div class="mb-3">
                                    <h5>Account Details</h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>User ID</span>
                                            <span class="badge bg-secondary"><?= $user['id'] ?></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Account Status</span>
                                            <span class="badge bg-success">Active</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Member Since</span>
                                            <span><?= date('M Y') ?></span>
                                        </li>
                                    </ul>
                                </div>
                                
                                <div class="d-flex">
                                    <a href="#" class="btn btn-outline-primary me-2">
                                        <i class="fas fa-edit me-1"></i> Edit Profile
                                    </a>
                                    <a href="<?= base_url('watchlist') ?>" class="btn btn-outline-dark">
                                        <i class="fas fa-list me-1"></i> My Watchlist
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>