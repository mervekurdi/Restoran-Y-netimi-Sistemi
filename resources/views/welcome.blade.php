<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Lüks Restoran Yönetim Sistemi</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<style>
  :root{
    --bg-gradient: linear-gradient(135deg, #DFB13E 0%, #B8860B 40%, #8A6412 80%, #5C4305 100%);
    --surface: rgba(255, 255, 255, 0.92);
    --border: rgba(138, 100, 18, 0.3);
    --primary: #8A6412;
    --text: #2A1E00;
    --muted: #5C4305;
    --shadow: 0 15px 40px rgba(92, 67, 5, 0.3);
    --gold-glow: 0 0 20px rgba(255, 255, 255, 0.4);
  }
  *{box-sizing:border-box;margin:0;padding:0}
  body{font-family:'Poppins',sans-serif;background:var(--bg-gradient);background-attachment:fixed;color:var(--text);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
  
  .portal-container{max-width:1100px;width:100%;text-align:center;position:relative;z-index:2;background:var(--surface);backdrop-filter:blur(20px);padding:60px 40px;border-radius:30px;box-shadow:var(--shadow), var(--gold-glow);border:1px solid var(--border)}
  .portal-title{font-family:'Playfair Display',serif;font-size:3.5rem;font-weight:800;margin-bottom:15px;background:linear-gradient(135deg, #B8860B, #5C4305);-webkit-background-clip:text;color:transparent;letter-spacing:1px}
  .portal-subtitle{font-size:1.2rem;color:var(--muted);margin-bottom:50px;font-weight:500}

  .grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:30px}
  
  .portal-card{background:linear-gradient(180deg, #FFFFFF 0%, #FFFDF8 100%);border-radius:24px;padding:40px 20px;text-decoration:none;color:var(--text);display:flex;flex-direction:column;align-items:center;transition:all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);box-shadow:0 10px 20px rgba(92,67,5,0.1);position:relative;overflow:hidden;border:1px solid var(--border)}
  .portal-card:hover{transform:translateY(-10px);box-shadow:0 20px 40px rgba(92,67,5,0.25);border-color:var(--primary)}
  
  .card-icon{font-size:4.5rem;margin-bottom:20px;transition:transform 0.4s ease;filter:drop-shadow(0 4px 6px rgba(184,134,11,0.3))}
  .portal-card:hover .card-icon{transform:scale(1.1)}
  
  .card-title{font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:700;margin-bottom:10px;color:var(--primary)}
  .card-desc{font-size:0.95rem;color:var(--muted);font-weight:500;line-height:1.5}

  .portal-card::before{content:'';position:absolute;top:0;left:0;right:0;height:5px;background:linear-gradient(90deg,#DFB13E,#8A6412);opacity:0;transition:opacity 0.3s}
  .portal-card:hover::before{opacity:1}
</style>
</head>
<body>

<div class="portal-container">
  <h1 class="portal-title">Lüks Restoran Yönetimi</h1>
  <p class="portal-subtitle">Lütfen işlem yapmak istediğiniz ekranı seçin</p>
  
  <div class="grid">
    <a href="/customer.html" class="portal-card">
      <div class="card-icon">🍽️</div>
      <div class="card-title">Müşteri Ekranı</div>
      <div class="card-desc">Yeni altın menüden sipariş verin</div>
    </a>
    
    <a href="/waiter.html" class="portal-card">
      <div class="card-icon">🛎️</div>
      <div class="card-title">Garson Paneli</div>
      <div class="card-desc">Siparişleri ve masa çağrılarını yönetin</div>
    </a>
    
    <a href="/kitchen.html" class="portal-card">
      <div class="card-icon">👨‍🍳</div>
      <div class="card-title">Mutfak KDS</div>
      <div class="card-desc">Profesyonel ekran ile siparişleri hazırlayın</div>
    </a>
    
    <a href="/admin.html" class="portal-card">
      <div class="card-icon">👑</div>
      <div class="card-title">Yönetici Paneli</div>
      <div class="card-desc">Tüm sistemi (kategori, ürün, sipariş) yönetin</div>
    </a>
  </div>
</div>

</body>
</html>
