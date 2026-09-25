<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Geprek Kasir POS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="card border-0 shadow-lg rounded-4 p-4" style="width: 100%; max-width: 400px;">
        <div class="text-center mb-4">
            <div class="bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-utensils fs-3"></i>
            </div>
            <h4 class="fw-bold mb-0">Geprek Kasir</h4>
            <small class="text-muted">Silakan masuk ke akun kasir kamu</small>
        </div>

        <<form action="<?php echo route('pos.index'); ?>" method="GET">>
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label class="form-label small fw-semibold">Username / Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 rounded-start-3"><i class="fa-regular fa-user text-muted"></i></span>
                    <input type="text" name="email" class="form-control border-start-0 rounded-end-3" placeholder="Masukkan username" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-semibold">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 rounded-start-3"><i class="fa-solid fa-lock text-muted"></i></span>
                    <input type="password" name="password" class="form-control border-start-0 rounded-end-3" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn btn-danger w-100 rounded-pill py-2 fw-bold shadow-sm">
                Masuk Sekarang <i class="fa-solid fa-arrow-right ms-1"></i>
            </button>
        </form>
    </div>

</body>
</html>