<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Lüks Restoran Yönetim Sistemi</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
<style>
  :root {
    --bg-color: #0A0A0A;
    --gold: #D4AF37;
    --gold-gradient: linear-gradient(135deg, #FFD700 0%, #D4AF37 50%, #996515 100%);
    --card-bg: #111111;
    --text-white: #FFFFFF;
    --text-grey: #8E8E93;
    
    --theme-customer: #B8860B;
    --theme-waiter: #3B82F6;
    --theme-kitchen: #EA580C;
    --theme-admin: #10B981;
  }
  
  * { box-sizing: border-box; margin: 0; padding: 0; }
  
  body {
    font-family: 'Poppins', sans-serif;
    background-color: var(--bg-color);
    color: var(--text-white);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
  }
  
  .container {
    max-width: 1200px;
    width: 100%;
    text-align: center;
    padding: 60px 40px;
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  
  .logo-icon {
    width: 80px;
    height: 80px;
    background: var(--gold-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 25px;
    box-shadow: 0 0 30px rgba(212, 175, 55, 0.3);
  }
  
  .logo-icon svg {
    width: 40px;
    height: 40px;
    fill: #0A0A0A;
  }
  
  .title-main {
    font-size: 2.5rem;
    font-weight: 800;
    line-height: 1.1;
    letter-spacing: 4px;
    text-transform: uppercase;
  }
  
  .title-main span {
    color: var(--gold);
    display: block;
  }
  
  .divider {
    width: 40px;
    height: 2px;
    background-color: var(--gold);
    margin: 20px auto;
  }
  
  .subtitle {
    font-size: 0.8rem;
    color: var(--text-grey);
    letter-spacing: 2px;
    text-transform: uppercase;
    font-weight: 500;
    margin-bottom: 50px;
  }
  
  .panel-header {
    width: 100%;
    text-align: center;
    font-size: 1rem;
    color: var(--text-grey);
    letter-spacing: 3px;
    font-weight: 600;
    margin-bottom: 40px;
  }
  
  .grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
    width: 100%;
  }
  
  @media(max-width: 1000px) {
    .grid { grid-template-columns: repeat(2, 1fr); }
  }
  @media(max-width: 600px) {
    .grid { grid-template-columns: 1fr; }
  }
  
  .card {
    background: var(--card-bg);
    border-radius: 20px;
    padding: 24px;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    text-align: left;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.05);
    position: relative;
    overflow: hidden;
  }
  
  .card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    opacity: 0.03;
    transition: opacity 0.3s ease;
  }
  
  .card-customer { border-color: rgba(184, 134, 11, 0.2); }
  .card-customer::before { background-color: var(--theme-customer); opacity: 0.08; }
  .card-customer:hover { border-color: var(--theme-customer); box-shadow: 0 10px 30px rgba(184, 134, 11, 0.15); }
  
  .card-waiter { border-color: rgba(59, 130, 246, 0.2); }
  .card-waiter::before { background-color: var(--theme-waiter); opacity: 0.05; }
  .card-waiter:hover { border-color: var(--theme-waiter); box-shadow: 0 10px 30px rgba(59, 130, 246, 0.15); }
  
  .card-kitchen { border-color: rgba(234, 88, 12, 0.2); }
  .card-kitchen::before { background-color: var(--theme-kitchen); opacity: 0.05; }
  .card-kitchen:hover { border-color: var(--theme-kitchen); box-shadow: 0 10px 30px rgba(234, 88, 12, 0.15); }
  
  .card-admin { border-color: rgba(16, 185, 129, 0.2); }
  .card-admin::before { background-color: var(--theme-admin); opacity: 0.05; }
  .card-admin:hover { border-color: var(--theme-admin); box-shadow: 0 10px 30px rgba(16, 185, 129, 0.15); }
  
  .card-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
  }
  
  .card-icon svg { width: 24px; height: 24px; fill: #FFFFFF; }
  
  .card-customer .card-icon { background-color: var(--theme-customer); }
  .card-waiter .card-icon { background-color: var(--theme-waiter); }
  .card-kitchen .card-icon { background-color: var(--theme-kitchen); }
  .card-admin .card-icon { background-color: var(--theme-admin); }
  
  .card-title {
    font-size: 1.25rem;
    font-weight: 800;
    color: var(--text-white);
    margin-bottom: 8px;
  }
  
  .card-desc {
    font-size: 0.8rem;
    color: var(--text-grey);
    font-weight: 500;
    line-height: 1.4;
    margin-bottom: 20px;
    flex-grow: 1;
  }
  
  .card-link {
    font-size: 0.9rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: transform 0.2s;
  }
  
  .card:hover .card-link { transform: translateX(5px); }
  
  .card-customer .card-link { color: var(--theme-customer); }
  .card-waiter .card-link { color: var(--theme-waiter); }
  .card-kitchen .card-link { color: var(--theme-kitchen); }
  .card-admin .card-link { color: var(--theme-admin); }
</style>
</head>
<body>

<div class="container">
  <div class="logo-icon">
    <!-- Fork & Knife SVG -->
    <svg viewBox="0 0 24 24">
      <path d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-9.03C11.34 12.84 13 11.12 13 9V2h-2v7zm8.42-3.11c-.37-.74-1.12-1.35-1.92-1.63V22h-2.5V4.26c-.8.28-1.55.89-1.92 1.63C12.75 6.55 12.5 7.69 12.5 9v13h2.5V11h3v11h2.5V9c0-1.31-.25-2.45-.58-3.11z"/>
    </svg>
  </div>
  
  <h1 class="title-main">
    RESTORAN
    <span>YÖNETİMİ</span>
  </h1>
  
  <div class="divider"></div>
  
  <div class="subtitle">Lüks Lezzetler • Eşsiz Deneyim</div>
  
  <div class="panel-header">PANEL SEÇİNİZ</div>
  
  <div class="grid">
    <a href="/customer.html" class="card card-customer">
      <div class="card-icon">
        <svg viewBox="0 0 24 24"><path d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-9.03C11.34 12.84 13 11.12 13 9V2h-2v7zm8.42-3.11c-.37-.74-1.12-1.35-1.92-1.63V22h-2.5V4.26c-.8.28-1.55.89-1.92 1.63C12.75 6.55 12.5 7.69 12.5 9v13h2.5V11h3v11h2.5V9c0-1.31-.25-2.45-.58-3.11z"/></svg>
      </div>
      <div class="card-title">Müşteri</div>
      <div class="card-desc">Menüyü görüntüle ve sipariş ver</div>
      <div class="card-link">Giriş Yap →</div>
    </a>
    
    <a href="/waiter.html" class="card card-waiter">
      <div class="card-icon">
        <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
      </div>
      <div class="card-title">Garson</div>
      <div class="card-desc">Masa ve sipariş takibi</div>
      <div class="card-link">Giriş Yap →</div>
    </a>
    
    <a href="/kitchen.html" class="card card-kitchen">
      <div class="card-icon">
        <svg viewBox="0 0 24 24"><path d="M19.48 12.35c-1.57-4.08-7.16-4.3-5.81-10.23-.1.01-.19.04-.29.05-.72.08-1.56.24-2.36.43-3.69 1.18-5.74 4.31-5.78 8.16C4.05 10.74 3 11.23 3 11.5c0 1.25.96 2.37 2.21 2.89-.13.35-.21.71-.21 1.11 0 3.04 2.46 5.5 5.5 5.5 3.04 0 5.5-2.46 5.5-5.5 0-.17-.01-.34-.03-.51 1.76-.32 3.14-1.74 3.44-3.51.05-.28.09-.58.07-.88zM10.5 19c-1.93 0-3.5-1.57-3.5-3.5 0-.74.23-1.42.63-1.98.02.59.39 1.54 1.37 2.08 1.48.81 3.5-1.05 2.87-2.65-.13-.33-.35-.61-.63-.84 1.34-.14 2.45.69 2.76 1.83.04.14.07.28.07.43 0 1.92-1.54 3.48-3.46 3.48-1.93.01-1.93.01-3.57.01-1.15.15-3.08-1.63-3.08-3.5 0-.96.38-1.83.99-2.46C9.15 13.06 10 13.9 10 14.5c0 .28-.22.5-.5.5s-.5-.22-.5-.5c0-1.1-1.34-1.65-2.12-.88C6.34 14.26 6 14.85 6 15.5c0 2.49 2.01 4.5 4.5 4.5s4.5-2.01 4.5-4.5c0-1.25-.51-2.38-1.33-3.19.16-.16.3-.34.42-.53 1.22 1.3 2 3.07 2 5.01 0 3.87-3.13 7-7 7s-7-3.13-7-7c0-2.45 1.25-4.61 3.16-5.87.56-1.57 1.51-2.91 2.68-3.9 1.15-.98 2.5-1.7 3.99-2.11C13.56 5.56 16.5 8.94 16.5 13c0 .5-.05 1-.16 1.49 1.33-.21 2.45-1 3.16-2.14z"/></svg>
      </div>
      <div class="card-title">Mutfak</div>
      <div class="card-desc">Gelen siparişleri hazırla</div>
      <div class="card-link">Giriş Yap →</div>
    </a>
    
    <a href="/admin.html" class="card card-admin">
      <div class="card-icon">
        <svg viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>
      </div>
      <div class="card-title">Admin</div>
      <div class="card-desc">Restoran yönetim paneli</div>
      <div class="card-link">Giriş Yap →</div>
    </a>
  </div>
</div>

</body>
</html>
