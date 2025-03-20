<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<section class="py-5" style="background-image: linear-gradient(rgba(18, 18, 18, 0.8), rgba(30, 136, 229, 0.6)), url('https://via.placeholder.com/1920x1080'); background-size: cover; background-position: center; min-height: 80vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="auth-card">
                    <div class="auth-card-header">
                        <h4 class="mb-0">Welcome Back</h4>
                    </div>
                    <div class="card-body p-4">
                        <?php if(session()->getFlashdata('success')): ?>
                            <div class="alert alert-success">
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if(isset($error)): ?>
                            <div class="alert alert-danger">
                                <?= $error ?>
                            </div>
                        <?php endif; ?>
                        
                        <form action="<?= base_url('auth/login') ?>" method="post" class="auth-form">
                            <div class="mb-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <?php if(isset($validation) && $validation->hasError('email')): ?>
                                    <div class="text-danger mt-2"><?= $validation->getError('email') ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <?php if(isset($validation) && $validation->hasError('password')): ?>
                                    <div class="text-danger mt-2"><?= $validation->getError('password') ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 btn-custom">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </button>
                        </form>
                        
                        <div class="mt-4 text-center">
                            <p>Don't have an account? <a href="<?= base_url('auth/register') ?>">Register here</a></p>
                            <p><a href="#" class="small">Forgot your password?</a></p>
                        </div>
                        
                        <div class="divider my-4"></div>
                        
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-outline-dark me-2"><i class="fab fa-google me-2"></i>Google</button>
                            <button class="btn btn-outline-dark"><i class="fab fa-facebook-f me-2"></i>Facebook</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>