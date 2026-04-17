{{-- resources/views/home.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>QuizMind AI</title>
  <style>
   /* RESET */
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

/* BODY */
body {
  font-family: 'Inter', 'Segoe UI', sans-serif;
  background: radial-gradient(circle at top, #1a1a2e, #0a0a14);
  color: #f0eeff;
  min-height: 100vh;
}

/* CONTAINER */
.container {
  max-width: 900px;
  margin: auto;
  padding: 50px 20px;
}

/* TITLE */
h1, .subtitle {
  text-align: center;
  width: 100%;
}

/* DOMAIN GRID */
.domain-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
  gap: 15px;
  margin-bottom: 35px;
}

.domain-card {
  width: 100%;
  max-width: 160px; /* 🔥 limite largeur */
  height: 120px;

  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;

  background: rgba(20, 20, 31, 0.6);
  backdrop-filter: blur(10px);
  border: 1px solid #2a2a40;
  border-radius: 16px;

  cursor: pointer;
  transition: 0.3s ease;
  position: relative;
  overflow: hidden;
}

.domain-card::before {
  content: "";
  position: absolute;
  inset: 0;
  background: linear-gradient(120deg, transparent, rgba(124, 58, 237, 0.3), transparent);
  opacity: 0;
  transition: 0.3s;
}

.domain-card:hover::before {
  opacity: 1;
}

.domain-card:hover {
  transform: translateY(-5px) scale(1.03);
  border-color: #7c3aed;
}

.domain-card.selected {
  border-color: #7c3aed;
  background: rgba(124, 58, 237, 0.15);
  box-shadow: 0 0 20px rgba(124, 58, 237, 0.5);
}

/* DOMAIN TEXT */
.domain-emoji {
  font-size: 32px;
  margin-bottom: 10px;
}

.domain-name {
  font-size: 14px;
  font-weight: 600;
  color: #d4d4ff;
}

/* CONFIG */
.config {
  display: flex;
  gap: 20px;
  margin-bottom: 35px;
  flex-wrap: wrap;
}

.config-box {
  flex: 1;
  min-width: 200px;
  background: rgba(20, 20, 31, 0.6);
  backdrop-filter: blur(10px);
  border: 1px solid #2a2a40;
  border-radius: 14px;
  padding: 18px;
}

.config-label {
  font-size: 11px;
  color: #7c7ca0;
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-bottom: 12px;
}

/* OPTIONS */
.config-opts {
  display: flex;
  gap: 8px;
}

.opt {
  flex: 1;
  padding: 10px;
  background: #0f0f1c;
  border: 1px solid #2a2a40;
  border-radius: 10px;
  text-align: center;
  font-size: 13px;
  color: #aaaad6;
  cursor: pointer;
  transition: 0.25s;
}

.opt:hover {
  background: #1c1c30;
}

.opt.active {
  background: linear-gradient(90deg, #7c3aed, #6d28d9);
  border: none;
  color: #fff;
  box-shadow: 0 0 10px rgba(124, 58, 237, 0.6);
}

/* INPUT */
input[type=text] {
  width: 100%;
  padding: 12px;
  background: #0f0f1c;
  border: 1px solid #2a2a40;
  border-radius: 10px;
  color: #f0eeff;
  font-size: 14px;
  outline: none;
  transition: 0.2s;
}

input[type=text]:focus {
  border-color: #7c3aed;
  box-shadow: 0 0 8px rgba(124, 58, 237, 0.4);
}

/* BUTTON */
.btn-start {
  width: 100%;
  padding: 18px;
  background: linear-gradient(90deg, #7c3aed, #6d28d9);
  border: none;
  border-radius: 16px;
  font-size: 18px;
  font-weight: bold;
  color: #fff;
  cursor: pointer;
  transition: 0.3s;
  box-shadow: 0 10px 25px rgba(124, 58, 237, 0.5);
}

.btn-start:hover {
  transform: translateY(-3px);
  box-shadow: 0 15px 30px rgba(124, 58, 237, 0.7);
}

/* RESPONSIVE */
@media (max-width: 768px) {
  h1 {
    font-size: 34px;
  }

  .config {
    flex-direction: column;
  }
}
  </style>
</head>
<body>
<div class="container">
  <h1>🧠 QuizMind AI</h1>
  <p class="subtitle">Questions générées par Intelligence Artificielle</p>

  <p style="color:#5b5b8a;font-size:13px;text-transform:uppercase;letter-spacing:1px;margin-bottom:14px;">
    Choisir votre domaine
  </p>
  <div class="domain-grid" id="domainGrid">
    @foreach($domains as $domain)
      <div class="domain-card" data-domain="{{ $domain['name'] }}" onclick="selectDomain(this)">
        <span class="domain-emoji">{{ $domain['emoji'] }}</span>
        <div class="domain-name">{{ $domain['name'] }}</div>
      </div>
    @endforeach
  </div>

  <div class="config">
    <div class="config-box">
      <div class="config-label">Nombre de questions</div>
      <div class="config-opts">
        <div class="opt active" onclick="setOpt(this,'q',5)">5</div>
        <div class="opt" onclick="setOpt(this,'q',10)">10</div>
        <div class="opt" onclick="setOpt(this,'q',15)">15</div>
      </div>
    </div>
    <div class="config-box">
      <div class="config-label">Difficulté</div>
      <div class="config-opts">
        <div class="opt active" onclick="setOpt(this,'d','facile')">Facile</div>
        <div class="opt" onclick="setOpt(this,'d','moyen')">Moyen</div>
        <div class="opt" onclick="setOpt(this,'d','expert')">Expert</div>
      </div>
    </div>
    <div class="config-box">
      <div class="config-label">Votre nom</div>
      <input type="text" id="playerName" placeholder="Entrez votre nom...">
    </div>
  </div>

  <button class="btn-start" onclick="startGame()">🚀 Commencer le Quiz</button>
</div>

<script>
  let selected = { domain: '', q: 5, d: 'facile' };

  function selectDomain(el) {
    document.querySelectorAll('.domain-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    selected.domain = el.dataset.domain;
  }

  function setOpt(el, type, val) {
    el.closest('.config-opts').querySelectorAll('.opt').forEach(o => o.classList.remove('active'));
    el.classList.add('active');
    selected[type] = val;
  }

  function startGame() {
    if (!selected.domain) { alert('Choisissez un domaine !'); return; }
    const player = document.getElementById('playerName').value || 'Joueur';
    window.location.href = `/quiz?domain=${encodeURIComponent(selected.domain)}`
                         + `&difficulty=${selected.d}&total=${selected.q}&player=${encodeURIComponent(player)}`;
  }
</script>
</body>
</html>
