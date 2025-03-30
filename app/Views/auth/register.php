<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<section class="py-5" style="background-image: linear-gradient(rgba(18, 18, 18, 0.8), rgba(30, 136, 229, 0.6)), url('https://via.placeholder.com/1920x1080'); background-size: cover; background-position: center; min-height: 80vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="auth-card">
                    <div class="auth-card-header">
                        <h4 class="mb-0">Create Your Account</h4>
                    </div>
                    <div class="card-body p-4">
                        <?php if(isset($error)): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>
                        
                        <?php if(isset($validation)): ?>
                            <div class="alert alert-danger">
                                <?= $validation->listErrors() ?>
                            </div>
                        <?php endif; ?>
                        
                        <form action="<?= base_url('auth/register') ?>" method="post" class="auth-form">
                            <div class="mb-3">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= old('username') ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            
                            <div class="mb-3">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                            </div>
                            
            
                            
                            <button type="submit" class="btn btn-primary w-100">Create Account</button>
                        </form>
                        
                        <div class="mt-3 text-center">
                            <p>Already have an account? <a href="<?= base_url('auth/login') ?>">Login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>