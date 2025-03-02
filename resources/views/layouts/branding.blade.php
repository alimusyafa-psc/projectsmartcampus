<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>
      Profile Member
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .profile-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            text-align: center;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 250px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            height: 100%;
            padding-bottom: 20px;
        }
        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            object-position: top; /* Atur posisi agar lebih ke atas */
            margin-top: -50px;
            border: 4px solid white;
            background: white;
            transform: scale(0.9); /* Mengecilkan gambar sedikit */
}

        .badge-instagram {
            background: linear-gradient(45deg, #f58529, #dd2a7b, #8134af);
            color: white;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 15px;
            display: inline-block;
            margin-top: 10px;
        }
        .bio {
            font-size: 14px;
            color: #555;
            margin-top: 5px;
            font-size: 14px;
            color: #555;
            margin-top: auto;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .container {
            max-width: 1200px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center g-4">
            <div class="col-lg-3 col-md-6 d-flex justify-content-center">
                <div class="profile-card">
                    <img src="{{ asset('img/nadhif.jpg') }}" alt="Profile Image" class="profile-img">
                    <div class="badge-instagram">@nadhif_mh</div>
                    <h5 class="mt-2">Muhammad Husnun Nadhif</h5>
                    <p class="bio">NRP: 2222500004<br>D3 Teknik Telekomunikasi</p>
                    <p class="bio">
                        🌍 <a href="https://www.linkedin.com/in/husnun-nadhif" target="_blank">LinkedIn</a> | 
                        📸 <a href="https://www.instagram.com/nadhif_mh?igsh=amQ3ajFqbzZ1cHV5" target="_blank">Instagram</a>
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 d-flex justify-content-center">
                <div class="profile-card">
                    <img src="{{ asset('img/dida.jpg') }}" alt="Profile Image" class="profile-img">
                    <div class="badge-instagram">@didaallanuari_10</div>
                    <h5 class="mt-2">Dida Allanuari Tribel</h5>
                    <p class="bio">NRP: 2222500005<br>D3 Teknik Telekomunikasi</p>
                    <p class="bio">
                        🌍 <a href="https://www.linkedin.com/in/husnun-nadhif" target="_blank">LinkedIn</a> | 
                        📸 <a href="https://www.instagram.com/didaallanuari_10?igsh=emQyOWhiY2g5azl4" target="_blank">Instagram</a>
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 d-flex justify-content-center">
                <div class="profile-card">
                    <img src="{{ asset('img/ali.jpg') }}" alt="Profile Image" class="profile-img">
                    <div class="badge-instagram">@aliimusyafa</div>
                    <h5 class="mt-2">Muhammad Ali Musyafa</h5>
                    <p class="bio">NRP: 2222500016<br>D3 Teknik Telekomunikasi</p>
                    <p class="bio">
                        🌍 <a href="https://www.linkedin.com/in/husnun-nadhif" target="_blank">LinkedIn</a> | 
                        📸 <a href="https://www.instagram.com/aliimusyafa?igsh=MW0zZHhzNzlnODh3cg==" target="_blank">Instagram</a>
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 d-flex justify-content-center">
                <div class="profile-card">
                    <img src="{{ asset('img/farel.png') }}" alt="Profile Image" class="profile-img">
                    <div class="badge-instagram">@endryco.farel</div>
                    <h5 class="mt-2">Endryco Farel Rianrachmatullah</h5>
                    <p class="bio">NRP: 2421600026<br>D4 Teknologi Rekayasa Internet</p>
                    <p class="bio">
                        🌍 <a href="https://www.linkedin.com/in/husnun-nadhif" target="_blank">LinkedIn</a> | 
                        📸 <a href="https://www.instagram.com/husnun.nadhif" target="_blank">Instagram</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>