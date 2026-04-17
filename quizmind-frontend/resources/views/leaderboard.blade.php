{{-- resources/views/leaderboard.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Classement</title>
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: radial-gradient(circle at top, #1a1a2e, #0a0a14);
      color: #fff;
      padding: 40px;
      text-align: center;
    }

    h1 {
      margin-bottom: 20px;
      color: #a78bfa;
    }

    .table {
      max-width: 700px;
      margin: auto;
      background: rgba(20,20,31,0.6);
      border-radius: 16px;
      overflow: hidden;
      border: 1px solid #2a2a40;
    }

    .row {
      display: flex;
      justify-content: space-between;
      padding: 15px;
      border-bottom: 1px solid #2a2a40;
    }

    .row.header {
      background: #7c3aed;
      font-weight: bold;
    }

    .row:last-child {
      border-bottom: none;
    }

    .btn {
      margin-top: 25px;
      padding: 12px 20px;
      border-radius: 10px;
      border: none;
      background: #7c3aed;
      color: white;
      cursor: pointer;
    }
  </style>
</head>
<body>

<h1>🏆 Classement - {{ $domain }}</h1>

<div class="table">
  <div class="row header">
    <div>#</div>
    <div>Joueur</div>
    <div>Score</div>
  </div>

  @forelse($scores as $index => $s)
    <div class="row">
      <div>{{ $index + 1 }}</div>
      <div>{{ $s['playerName'] }}</div>
      <div>{{ $s['totalScore'] }}</div>
    </div>
  @empty
    <div class="row">
      <div>Aucun score</div>
    </div>
  @endforelse
</div>

<button class="btn" onclick="window.location.href='/'">← Retour</button>

</body>
</html>
