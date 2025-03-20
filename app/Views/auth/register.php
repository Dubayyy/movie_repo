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
                        <form action="<?= base_url('auth/register') ?>" method="post" class="auth-form">
                            <div class="mb-4">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= old('username') ?>" required>
                                <?php if(isset($validation) && $validation->hasError('username')): ?>
                                    <div class="text-danger mt-2"><?= $validation->getError('username') ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mb-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" required>
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
                            
                            <div class="mb-4">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                <?php if(isset($validation) && $validation->hasError('confirm_password')): ?>
                                    <div class="text-danger mt-2"><?= $validation->getError('confirm_password') ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></label>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 btn-custom">
                                <i class="fas fa-user-plus me-2"></i>Create Account
                            </button>
                        </form>
                        
                        <div class="mt-4 text-center">
                            <p>Already have an account? <a href="<?= base_url('auth/login') ?>">Login here</a></p>
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