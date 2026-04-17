{{-- resources/views/result.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Résultats</title>
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

  display: flex;
  flex-direction: column;
  align-items: center; /* 🔥 centre tout */
}

/* EMOJI */
.emoji {
  font-size: 90px;
  margin-bottom: 15px;
  animation: pop 0.6s ease;
}

@keyframes pop {
  0% { transform: scale(0.5); opacity: 0; }
  100% { transform: scale(1); opacity: 1; }
}

/* TITLE */
.title {
  font-size: 38px;
  font-weight: bold;
  background: linear-gradient(90deg, #a78bfa, #7c3aed);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  margin-bottom: 10px;
}

/* DOMAIN */
.container > div:nth-of-type(2) {
  color: #8b8bbd;
  margin-bottom: 10px;
}

/* PERCENTAGE */
.pct {
  font-size: 90px;
  font-weight: bold;
  background: linear-gradient(90deg, #7c3aed, #a78bfa);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  margin: 20px 0;
}

/* SUBTEXT */
.container > div:nth-of-type(4) {
  color: #7c7ca0;
  margin-bottom: 30px;
}

/* STATS */
.stats {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 15px;
  margin: 30px 0;
}

.stat {
  background: rgba(20, 20, 31, 0.6);
  backdrop-filter: blur(10px);
  border: 1px solid #2a2a40;
  border-radius: 16px;
  padding: 20px;
  transition: 0.3s;
}

.stat:hover {
  transform: translateY(-5px);
}

.stat-n {
  font-size: 30px;
  font-weight: bold;
}

.stat-l {
  font-size: 11px;
  color: #7c7ca0;
  text-transform: uppercase;
  margin-top: 5px;
}

/* AI BOX */
.ai-box {
  background: rgba(124, 58, 237, 0.08);
  border: 1px solid #7c3aed;
  border-radius: 16px;
  padding: 22px;
  margin: 25px 0;
  text-align: left;
  position: relative;
}

.ai-box::before {
  content: "";
  position: absolute;
  inset: 0;
  background: linear-gradient(120deg, transparent, rgba(124, 58, 237, 0.2), transparent);
  opacity: 0.4;
}

.ai-tag {
  font-size: 11px;
  color: #a78bfa;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  font-weight: bold;
  margin-bottom: 10px;
  position: relative;
  z-index: 1;
}

.ai-text {
  font-size: 15px;
  color: #d0d0ff;
  line-height: 1.7;
  position: relative;
  z-index: 1;
}

/* BUTTONS */
.btns {
  display: flex;
  gap: 12px;
  margin-top: 35px;
  flex-wrap: wrap;
}

.btn {
  flex: 1;
  padding: 16px;
  border-radius: 14px;
  font-size: 15px;
  font-weight: bold;
  cursor: pointer;
  transition: 0.3s;
  border: none;
}

.btn-main {
  background: linear-gradient(90deg, #7c3aed, #6d28d9);
  color: #fff;
  box-shadow: 0 10px 20px rgba(124, 58, 237, 0.5);
}

.btn-main:hover {
  transform: translateY(-3px);
}

.btn-sec {
  background: rgba(20, 20, 31, 0.6);
  border: 1px solid #2a2a40;
  color: #c4c4e0;
}

.btn-sec:hover {
  background: #1a1a2e;
}

/* RESPONSIVE */
@media (max-width: 600px) {
  .pct {
    font-size: 60px;
  }

  .title {
    font-size: 28px;
  }

  .stats {
    grid-template-columns: 1fr;
  }

  .btn {
    width: 100%;
  }
}
  </style>
</head>
<body>
<div class="container">
  @php
    $pct     = (int)($data['percentage'] ?? 0);
    $correct = (int)($data['correct'] ?? 0);
    $wrong   = (int)($data['wrong'] ?? 0);
    $total   = (int)($data['total'] ?? 0);
    $score   = (int)($data['score'] ?? 0);
    $analysis = $data['analysis'] ?? 'Bravo pour cette partie !';
    $player  = $data['player'] ?? 'Joueur';
    $domain  = $data['domain'] ?? '';

    if ($pct >= 80) { $emoji = '🏆'; $title = 'Excellent, ' . $player . '!'; }
    elseif ($pct >= 60) { $emoji = '⭐'; $title = 'Très bien, ' . $player . '!'; }
    elseif ($pct >= 40) { $emoji = '👍'; $title = 'Pas mal, ' . $player . '!'; }
    else { $emoji = '💪'; $title = 'Continue, ' . $player . '!'; }
  @endphp

  <span class="emoji">{{ $emoji }}</span>
  <div class="title">{{ $title }}</div>
  <div style="color:#5b5b8a">{{ $domain }}</div>
  <div class="pct">{{ $pct }}%</div>
  <div style="color:#5b5b8a">{{ $correct }} / {{ $total }} bonnes réponses · Score : {{ $score }} pts</div>

  <div class="stats">
    <div class="stat">
      <div class="stat-n" style="color:#34d399">{{ $correct }}</div>
      <div class="stat-l">Correctes</div>
    </div>
    <div class="stat">
      <div class="stat-n" style="color:#ef4444">{{ $wrong }}</div>
      <div class="stat-l">Fausses</div>
    </div>
    <div class="stat">
      <div class="stat-n" style="color:#f59e0b">{{ $score }}</div>
      <div class="stat-l">Points</div>
    </div>
  </div>

  <div class="ai-box">
    <div class="ai-tag">🤖 Analyse IA</div>
    <div class="ai-text">{{ $analysis }}</div>
  </div>

  <div class="btns">
    <button class="btn btn-sec" onclick="window.location.href='/'">← Menu</button>
    <button class="btn btn-main"
      onclick="window.location.href='/leaderboard?domain={{ urlencode($domain) }}'">
      🏆 Classement
    </button>
    <button class="btn btn-main"
      onclick="window.location.href='/quiz?domain={{ urlencode($domain) }}&difficulty=facile&total={{ $total }}&player={{ urlencode($player) }}'">
      🔄 Rejouer
    </button>
  </div>
</div>
</body>
</html>
