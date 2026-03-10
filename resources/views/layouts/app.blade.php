<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'The Grand Mugarsari') — Reservasi Hotel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root{--gold:#C9A84C;--gold-light:#E8C97A;--gold-dim:#a8893d;--navy:#0D1B2A;--navy-mid:#162233;--navy-soft:#1E3050;--cream:#F5F0E8;--cream-dark:#E8E0D0;--text-light:#B0A898;--red:#e74c3c;--shadow:0 8px 40px rgba(0,0,0,0.35);--radius:12px}
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Lato',sans-serif;background-color:var(--navy);color:var(--cream);min-height:100vh;background-image:radial-gradient(ellipse at 20% 50%,rgba(201,168,76,.06) 0%,transparent 60%),radial-gradient(ellipse at 80% 20%,rgba(201,168,76,.04) 0%,transparent 50%)}
        .site-header{background:linear-gradient(135deg,var(--navy) 0%,var(--navy-soft) 100%);border-bottom:1px solid rgba(201,168,76,.3);position:sticky;top:0;z-index:100;box-shadow:0 4px 30px rgba(0,0,0,.4)}
        .header-inner{max-width:1300px;margin:0 auto;padding:18px 32px;display:flex;align-items:center;justify-content:space-between}
        .logo{display:flex;flex-direction:column;line-height:1;text-decoration:none}
        .logo-main{font-family:'Playfair Display',serif;font-size:1.6rem;font-weight:700;color:var(--gold);letter-spacing:2px}
        .logo-sub{font-size:.65rem;letter-spacing:4px;text-transform:uppercase;color:var(--text-light);margin-top:2px}
        .nav-links{display:flex;gap:8px}
        .nav-btn{background:transparent;border:1px solid rgba(201,168,76,.4);color:var(--gold-light);padding:8px 18px;border-radius:6px;cursor:pointer;font-family:'Lato',sans-serif;font-size:.82rem;letter-spacing:1px;text-transform:uppercase;transition:all .25s;text-decoration:none}
        .nav-btn:hover,.nav-btn.active{background:var(--gold);color:var(--navy);border-color:var(--gold)}
        .container{max-width:1300px;margin:0 auto;padding:40px 32px 60px}
        .alert{padding:14px 20px;border-radius:var(--radius);margin-bottom:28px;font-size:.92rem;display:flex;align-items:center;gap:10px;animation:slideDown .4s ease}
        @keyframes slideDown{from{opacity:0;transform:translateY(-12px)}to{opacity:1;transform:translateY(0)}}
        .alert-sukses{background:rgba(46,204,113,.12);border:1px solid rgba(46,204,113,.35);color:#a8f0c6}
        .alert-error{background:rgba(231,76,60,.12);border:1px solid rgba(231,76,60,.35);color:#f5b7b1}
        .error-list{background:rgba(231,76,60,.1);border:1px solid rgba(231,76,60,.35);border-radius:var(--radius);padding:16px 20px;margin-bottom:24px;color:#f5b7b1}
        .error-list ul{margin-left:20px;margin-top:8px;font-size:.88rem}.error-list li{margin-bottom:4px}
        .input-error{border-color:var(--red)!important}.field-error{font-size:.75rem;color:#e74c3c;margin-top:4px}
        .section-title{font-family:'Playfair Display',serif;font-size:1.5rem;color:var(--gold);margin-bottom:6px}
        .section-sub{font-size:.82rem;color:var(--text-light);letter-spacing:1px;margin-bottom:24px}
        .gold-divider{width:60px;height:2px;background:linear-gradient(90deg,transparent,var(--gold),transparent);margin:20px auto}
        .card{background:var(--navy-mid);border:1px solid rgba(201,168,76,.18);border-radius:var(--radius);padding:36px;box-shadow:var(--shadow)}
        .form-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:20px}
        .form-group{display:flex;flex-direction:column;gap:7px}.form-group.full{grid-column:1/-1}
        label{font-size:.75rem;text-transform:uppercase;letter-spacing:1.5px;color:var(--gold-light);font-weight:700}
        input[type="text"],input[type="email"],input[type="number"],input[type="date"],select,textarea{background:rgba(255,255,255,.05);border:1px solid rgba(201,168,76,.25);border-radius:8px;color:var(--cream);padding:12px 16px;font-family:'Lato',sans-serif;font-size:.92rem;transition:border-color .25s,background .25s,box-shadow .25s;outline:none;width:100%}
        input:focus,select:focus,textarea:focus{border-color:var(--gold);background:rgba(201,168,76,.08);box-shadow:0 0 0 3px rgba(201,168,76,.12)}
        input::placeholder,textarea::placeholder{color:rgba(176,168,152,.5)}
        select option{background:var(--navy-mid);color:var(--cream)}
        textarea{resize:vertical;min-height:90px}
        .input-hint{font-size:.72rem;color:var(--text-light);margin-top:3px}
        .price-preview{background:linear-gradient(135deg,rgba(201,168,76,.12),rgba(201,168,76,.05));border:1px solid rgba(201,168,76,.35);border-radius:10px;padding:18px 22px;display:flex;justify-content:space-between;align-items:center;margin-top:8px}
        .price-label{font-size:.75rem;text-transform:uppercase;letter-spacing:2px;color:var(--text-light)}
        .price-amount{font-family:'Playfair Display',serif;font-size:1.6rem;color:var(--gold);font-weight:600}
        .btn-submit{background:linear-gradient(135deg,var(--gold),var(--gold-dim));color:var(--navy);border:none;border-radius:8px;padding:14px 36px;font-family:'Lato',sans-serif;font-size:.9rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;cursor:pointer;transition:all .25s;box-shadow:0 4px 20px rgba(201,168,76,.3)}
        .btn-submit:hover{background:linear-gradient(135deg,var(--gold-light),var(--gold));transform:translateY(-2px);box-shadow:0 8px 30px rgba(201,168,76,.45)}
        .btn-submit:active{transform:translateY(0)}
        .btn-cancel{background:transparent;border:1px solid rgba(255,255,255,.2);color:var(--text-light);padding:13px 28px;border-radius:8px;cursor:pointer;font-family:'Lato',sans-serif;font-size:.88rem;transition:all .2s;text-decoration:none;display:inline-flex;align-items:center}
        .btn-cancel:hover{border-color:var(--cream);color:var(--cream)}
        .btn-edit{display:inline-flex;align-items:center;gap:5px;padding:7px 14px;border-radius:6px;font-size:.78rem;font-weight:700;text-decoration:none;cursor:pointer;border:1px solid rgba(93,173,226,.3);transition:all .2s;background:rgba(93,173,226,.15);color:#5dade2}
        .btn-edit:hover{background:rgba(93,173,226,.25)}
        .btn-hapus{display:inline-flex;align-items:center;gap:5px;padding:7px 14px;border-radius:6px;font-size:.78rem;font-weight:700;cursor:pointer;border:1px solid rgba(231,76,60,.3);transition:all .2s;background:rgba(231,76,60,.12);color:#e74c3c}
        .btn-hapus:hover{background:rgba(231,76,60,.22)}
        .rooms-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:12px;margin-bottom:28px}
        .room-card{background:rgba(255,255,255,.03);border:1px solid rgba(201,168,76,.15);border-radius:10px;padding:16px;cursor:pointer;transition:all .25s;text-align:center}
        .room-card:hover{border-color:var(--gold);background:rgba(201,168,76,.07)}
        .room-card.selected{border-color:var(--gold);background:rgba(201,168,76,.12);box-shadow:0 0 0 2px rgba(201,168,76,.25)}
        .room-name{font-size:.85rem;font-weight:700;color:var(--cream)}.room-price{font-size:.75rem;color:var(--gold);margin-top:4px}
        .table-wrap{overflow-x:auto;border-radius:var(--radius)}
        table{width:100%;border-collapse:collapse;font-size:.88rem}
        thead tr{background:linear-gradient(90deg,rgba(201,168,76,.15),rgba(201,168,76,.08));border-bottom:2px solid rgba(201,168,76,.3)}
        th{padding:14px 16px;text-align:left;font-size:.7rem;letter-spacing:1.5px;text-transform:uppercase;color:var(--gold);white-space:nowrap}
        td{padding:13px 16px;color:var(--cream-dark);vertical-align:middle;border-bottom:1px solid rgba(255,255,255,.05)}
        tbody tr{transition:background .2s}tbody tr:hover{background:rgba(201,168,76,.05)}
        .actions{display:flex;gap:6px}
        .badge{display:inline-block;padding:4px 10px;border-radius:20px;font-size:.72rem;font-weight:700}
        .badge-booking{background:rgba(241,196,15,.15);color:#f1c40f;border:1px solid rgba(241,196,15,.3)}
        .badge-dikonfirmasi{background:rgba(52,152,219,.15);color:#5dade2;border:1px solid rgba(52,152,219,.3)}
        .badge-checkin{background:rgba(46,204,113,.15);color:#2ecc71;border:1px solid rgba(46,204,113,.3)}
        .badge-checkout{background:rgba(149,165,166,.15);color:#95a5a6;border:1px solid rgba(149,165,166,.3)}
        .badge-dibatalkan{background:rgba(231,76,60,.15);color:#e74c3c;border:1px solid rgba(231,76,60,.3)}
        .stats-bar{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:16px;margin-bottom:36px}
        .stat-item{background:var(--navy-mid);border:1px solid rgba(201,168,76,.18);border-radius:10px;padding:18px 22px;text-align:center}
        .stat-number{font-family:'Playfair Display',serif;font-size:1.8rem;color:var(--gold);font-weight:700}
        .stat-label{font-size:.7rem;letter-spacing:2px;text-transform:uppercase;color:var(--text-light);margin-top:4px}
        .empty-state{text-align:center;padding:50px 20px;color:var(--text-light)}.empty-state .icon{font-size:2.5rem;margin-bottom:12px}
        .form-actions{display:flex;justify-content:flex-end;gap:12px;margin-top:28px;padding-top:22px;border-top:1px solid rgba(201,168,76,.15)}
        .modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.7);z-index:999;display:none;align-items:center;justify-content:center;backdrop-filter:blur(4px)}
        .modal-overlay.active{display:flex}
        .modal-box{background:var(--navy-mid);border:1px solid rgba(231,76,60,.4);border-radius:var(--radius);padding:36px;max-width:400px;width:90%;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,.5);animation:popIn .3s ease}
        @keyframes popIn{from{opacity:0;transform:scale(.9)}to{opacity:1;transform:scale(1)}}
        .modal-icon{font-size:2.5rem;margin-bottom:14px}
        .modal-title{font-family:'Playfair Display',serif;font-size:1.2rem;color:var(--cream);margin-bottom:8px}
        .modal-desc{font-size:.88rem;color:var(--text-light);margin-bottom:24px}
        .modal-actions{display:flex;gap:12px;justify-content:center}
        .btn-modal-cancel{background:transparent;border:1px solid rgba(255,255,255,.2);color:var(--text-light);padding:10px 24px;border-radius:7px;cursor:pointer;font-family:'Lato',sans-serif;font-size:.88rem;transition:all .2s}
        .btn-modal-cancel:hover{border-color:var(--cream);color:var(--cream)}
        .btn-confirm-delete{background:var(--red);border:none;color:#fff;padding:10px 24px;border-radius:7px;cursor:pointer;font-family:'Lato',sans-serif;font-size:.88rem;font-weight:700;transition:all .2s}
        .btn-confirm-delete:hover{background:#c0392b}
        .hero{background:linear-gradient(160deg,var(--navy-soft) 0%,var(--navy-mid) 60%,var(--navy) 100%);padding:70px 32px 50px;text-align:center;border-bottom:1px solid rgba(201,168,76,.15);position:relative;overflow:hidden}
        .hero::before{content:'';position:absolute;inset:0;background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23C9A84C' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")}
        .hero-eyebrow{font-size:.7rem;letter-spacing:5px;text-transform:uppercase;color:var(--gold);margin-bottom:14px}
        .hero h1{font-family:'Playfair Display',serif;font-size:clamp(2rem,5vw,3.2rem);font-weight:700;color:var(--cream);line-height:1.2}
        .hero h1 em{color:var(--gold);font-style:italic}
        .hero-desc{color:var(--text-light);font-size:.95rem;margin-top:14px;font-weight:300;letter-spacing:.5px}
        .section-gap{margin-top:50px}
        footer{text-align:center;padding:28px;color:var(--text-light);font-size:.78rem;border-top:1px solid rgba(201,168,76,.15);letter-spacing:1px}
        footer span{color:var(--gold)}
        @media(max-width:768px){.header-inner{padding:14px 18px}.container{padding:24px 18px 48px}.hero{padding:50px 18px 36px}.card{padding:22px 18px}.logo-main{font-size:1.2rem}}
    </style>
    @stack('styles')
</head>
<body>
<header class="site-header">
    <div class="header-inner">
        <a href="{{ url('/') }}" class="logo">
            <span class="logo-main">✦ THE GRAND MUGARSARI</span>
            <span class="logo-sub">Luxury Hotel &amp; Resort</span>
        </a>
        <nav class="nav-links">
            <a href="{{ url('/') }}#form-pesan"   class="nav-btn">Reservasi</a>
            <a href="{{ url('/') }}#daftar-pesan" class="nav-btn">Data Tamu</a>
        </nav>
    </div>
</header>

@yield('content')

<footer>
    &copy; {{ date('Y') }} <span>The Grand Mugarsari Hotel</span>
    — Sistem Reservasi &bull; Powered by <span>Laravel</span>
</footer>

@stack('scripts')
</body>
</html>
