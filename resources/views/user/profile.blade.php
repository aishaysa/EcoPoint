<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profil Saya</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        /* ============================================================
           GAYA SERAGAM DENGAN LAYOUT USER & FORM SETORAN
        ============================================================ */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            background: #f0f7f2;
        }

        .profile-page {
            width: 100%;
            min-height: 100vh;
            background: #f0f7f2;
            padding: 28px 22px 50px;
        }

        .profile-container {
            width: 100%;
            max-width: 820px;
            margin: 0 auto;
        }

        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .profile-title {
            margin: 0;
            font-size: 1.7rem;
            font-weight: 800;
            color: #0d2b1f;
        }

        .profile-subtitle {
            margin-top: 4px;
            color: #2d5a43;
            font-size: 0.8rem;
        }

        .profile-actions {
            display: flex;
            gap: 10px;
        }

        .btn-edit {
            text-decoration: none;
            padding: 9px 18px;
            border-radius: 40px;
            background: #2e7d5a;
            color: white;
            font-weight: 600;
            font-size: 0.75rem;
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: none;
            cursor: pointer;
        }
        .btn-edit:hover {
            background: #1a4532;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46, 125, 90, 0.3);
        }

        .btn-back {
            text-decoration: none;
            padding: 9px 14px;
            border: 1px solid #cde0d3;
            border-radius: 10px;
            background: #fff;
            color: #2d5a43;
            font-weight: 600;
            transition: 0.2s;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-back:hover {
            background: #e8f5e9;
            border-color: #6fcf97;
        }

        /* CARD */
        .profile-card {
            background: #ffffff;
            border: 1px solid #d4e8db;
            border-radius: 24px;
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.06);
            overflow: hidden;
            padding: 32px;
        }

        .profile-avatar {
            display: flex;
            align-items: center;
            gap: 24px;
            margin-bottom: 28px;
            padding-bottom: 24px;
            border-bottom: 1px solid #d4e8db;
        }

        .profile-avatar img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #2e7d5a;
            background: #e8f5e9;
        }

        .profile-avatar .default-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #e8f5e9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #2e7d5a;
            border: 3px solid #2e7d5a;
        }

        .profile-name {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            color: #0d2b1f;
        }

        .profile-email {
            margin: 0;
            color: #4d7a63;
            font-size: 0.85rem;
        }

        /* INFO GRID */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px 30px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-item .label {
            font-size: 0.7rem;
            font-weight: 700;
            color: #4d7a63;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }

        .info-item .value {
            font-size: 0.95rem;
            font-weight: 600;
            color: #0d2b1f;
            padding: 6px 0;
            border-bottom: 1px dashed #d4e8db;
        }

        .info-item .value .poin-badge {
            background: #2e7d5a;
            color: white;
            padding: 2px 14px;
            border-radius: 40px;
            font-size: 0.85rem;
            font-weight: 700;
        }

        /* RESPONSIVE */
        @media (max-width: 700px) {
            .profile-page {
                padding: 18px 12px 30px;
            }
            .profile-card {
                padding: 20px;
            }
            .profile-avatar {
                flex-direction: column;
                text-align: center;
            }
            .info-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            .profile-header {
                flex-wrap: wrap;
            }
            .profile-actions {
                width: 100%;
                justify-content: flex-start;
            }
        }
    </style>
</head>
<body>

    <div class="profile-page">

        <div class="profile-container">

            <!-- HEADER -->
            <div class="profile-header">
                <div>
                    <h1 class="profile-title">
                        <i class="fas fa-user-circle" style="color:#2e7d5a; margin-right:8px;"></i>
                        Profil Saya
                    </h1>
                    <div class="profile-subtitle">
                        Informasi akun dan riwayat poin Anda
                    </div>
                </div>
                <div class="profile-actions">
                    <a href="#" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Dashboard
                    </a>
                    <a href="#" class="btn-edit">
                        <i class="fas fa-pen"></i> Edit Profil
                    </a>
                </div>
            </div>

            <!-- CARD -->
            <div class="profile-card">

                <!-- AVATAR & NAMA -->
                <div class="profile-avatar">
                    <!-- Ganti src dengan foto profil sebenarnya jika ada -->
                    <!-- <img src="foto-profil.jpg" alt="Foto Profil"> -->

                    <!-- Default avatar (tanpa foto) -->
                    <div class="default-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <h2 class="profile-name">Budi Santoso</h2>
                        <p class="profile-email">budi@example.com</p>
                    </div>
                </div>

                <!-- DATA LENGKAP -->
                <div class="info-grid">
                    <div class="info-item">
                        <span class="label">Nama Lengkap</span>
                        <span class="value">Budi Santoso</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Email</span>
                        <span class="value">budi@example.com</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Nomor HP</span>
                        <span class="value">0812-3456-7890</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Alamat</span>
                        <span class="value">Jl. Merdeka No. 10, Jakarta</span>
                    </div>
                    <div class="info-item" style="grid-column: 1 / -1;">
                        <span class="label">Total Poin</span>
                        <span class="value">
                            <span class="poin-badge">1.250</span>
                            <span style="font-size:0.75rem; color:#4d7a63; margin-left:8px;">poin</span>
                        </span>
                    </div>
                </div>

            </div>
            <!-- end .profile-card -->

        </div>
        <!-- end .container -->

    </div>
    <!-- end .profile-page -->

</body>
</html>