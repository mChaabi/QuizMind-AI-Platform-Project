{{-- resources/views/quiz.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quiz — {{ $domain }}</title>
  <style>
* { box-sizing: border-box; margin: 0; padding: 0; }

body {
  font-family: 'Inter', 'Segoe UI', sans-serif;
  background: radial-gradient(circle at top, #1a1a2e, #0a0a14);
  color: #f0eeff;
  min-height: 100vh;
}

.container {
  max-width: 900px;
  margin: auto;
  padding: 50px 20px;

  display: flex;
  flex-direction: column;
  align-items: center; /* 🔥 centre tout */
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 25px;
}

.badge {
  background: rgba(124, 58, 237, 0.15);
  border: 1px solid #7c3aed;
  border-radius: 20px;
  padding: 6px 14px;
  font-size: 13px;
  color: #a78bfa;
}

.timer {
  font-size: 28px;
  font-weight: bold;
  color: #a78bfa;
  min-width: 50px;
  text-align: center;
  transition: 0.3s;
}
.timer.warn   { color: #f59e0b; }
.timer.danger { color: #ef4444; animation: pulse 1s infinite; }

@keyframes pulse {
  0%,100% { transform: scale(1); }
  50%     { transform: scale(1.15); }
}

.progress-bar {
  background: #1e1e30;
  border-radius: 10px;
  height: 8px;
  margin-bottom: 25px;
  overflow: hidden;
}
.progress-fill {
  height: 100%;
  background: linear-gradient(90deg, #7c3aed, #a78bfa);
  transition: width 0.4s ease;
  border-radius: 10px;
}

.score-strip {
  display: flex;
  justify-content: space-between;
  background: rgba(20, 20, 31, 0.6);
  border: 1px solid #2a2a40;
  border-radius: 14px;
  padding: 15px;
  margin-bottom: 25px;
  gap: 20px; /* <--- Ajoute ceci pour créer de l'espace entre les blocs */
}
.score-item { text-align: center; flex: 1; }
.score-val  { font-size: 22px; font-weight: bold; }
.score-lbl  { font-size: 11px; color: #7c7ca0; text-transform: uppercase; margin-top: 4px; }

.question-box {
  background: rgba(20, 20, 31, 0.6);
  border: 1px solid #2a2a40;
  border-radius: 18px;
  padding: 30px;
  margin-bottom: 20px;
  min-height: 120px;
  display: flex;
  align-items: center;
}
.question-text { font-size: 19px; font-weight: 600; line-height: 1.5; }

/* ── BOUTONS RÉPONSES ─────────────────────────────── */
.answers {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
  margin-bottom: 20px;
}

.ans-btn {
  background: rgba(20, 20, 31, 0.6);
  border: 1px solid #2a2a40;
  border-radius: 14px;
  padding: 16px;
  text-align: left;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 12px;
  color: #c4c4e0;
  font-size: 14px;
  font-family: inherit;
  transition: 0.25s;
  width: 100%;
}

.ans-btn:hover:not(:disabled) {
  transform: translateY(-3px);
  border-color: #7c3aed;
  background: rgba(124, 58, 237, 0.1);
}

.ans-btn:disabled { cursor: not-allowed; opacity: 0.8; }

.ans-letter {
  min-width: 32px;
  height: 32px;
  border-radius: 8px;
  background: #1e1e30;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  color: #8b8bbd;
  font-size: 14px;
  flex-shrink: 0;
}

/* États des boutons */
.ans-btn.correct              { border-color: #34d399; background: rgba(52,211,153,0.15); }
.ans-btn.correct .ans-letter  { background: #34d399; color: #000; }
.ans-btn.correct span:last-child { color: #34d399; }

.ans-btn.wrong                { border-color: #ef4444; background: rgba(239,68,68,0.15); }
.ans-btn.wrong .ans-letter    { background: #ef4444; color: #fff; }
.ans-btn.wrong span:last-child { color: #ef4444; }

.ans-btn.reveal               { border-color: #34d399; background: rgba(52,211,153,0.08); }
.ans-btn.reveal .ans-letter   { background: rgba(52,211,153,0.3); color: #34d399; }

/* ── FEEDBACK IA ─────────────────────────────────── */
.feedback {
  border-left: 4px solid #7c3aed;
  border-radius: 10px;
  padding: 15px 18px;
  margin-bottom: 15px;
  font-size: 14px;
  line-height: 1.6;
  display: none;
}
.feedback.show { display: block; }
.feedback.ok  { border-color: #34d399; background: rgba(52,211,153,0.1);  color: #a7f3d0; }
.feedback.bad { border-color: #ef4444; background: rgba(239,68,68,0.1);  color: #fca5a5; }

/* ── BOUTON SUIVANT ──────────────────────────────── */
.next-btn {
  width: 100%;
  padding: 15px;
  background: linear-gradient(90deg, #7c3aed, #6d28d9);
  border: none;
  border-radius: 14px;
  font-size: 16px;
  font-weight: bold;
  color: #fff;
  cursor: pointer;
  display: none;
  transition: 0.3s;
  box-shadow: 0 10px 20px rgba(124,58,237,0.4);
  font-family: inherit;
}
.next-btn.show  { display: block; }
.next-btn:hover { transform: translateY(-2px); }

/* ── LOADING ─────────────────────────────────────── */
.loading { text-align: center; padding: 20px; }
.dots span {
  display: inline-block;
  width: 8px; height: 8px;
  background: #7c3aed;
  border-radius: 50%;
  margin: 0 3px;
  animation: bounce 1.2s infinite;
}
.dots span:nth-child(2) { animation-delay: .2s; }
.dots span:nth-child(3) { animation-delay: .4s; }
@keyframes bounce {
  0%,60%,100% { transform: translateY(0); }
  30%          { transform: translateY(-8px); }
}

@media (max-width: 600px) {
  .answers     { grid-template-columns: 1fr; }
  .score-strip { flex-wrap: wrap; gap: 10px; }
}
  </style>
</head>
<body>
<div class="container">

  <!-- HEADER -->
  <div class="header">
    <div>
      <span class="badge">{{ $domain }}</span>
      <span style="color:#5b5b8a;font-size:13px;margin-left:12px;" id="q-count">
        Question 1 / {{ $total }}
      </span>
    </div>
    <div class="timer" id="timer">30</div>
  </div>

  <!-- PROGRESS -->
  <div class="progress-bar">
    <div class="progress-fill" id="progress" style="width:0%"></div>
  </div>

  <!-- SCORE STRIP -->
  <div class="score-strip">
    <div class="score-item">
      <div class="score-val" id="s-score">0</div>
      <div class="score-lbl">Score</div>
    </div>
    <div class="score-item">
      <div class="score-val" style="color:#34d399" id="s-correct">0</div>
      <div class="score-lbl">Correctes</div>
    </div>
    <div class="score-item">
      <div class="score-val" style="color:#ef4444" id="s-wrong">0</div>
      <div class="score-lbl">Fausses</div>
    </div>
    <div class="score-item">
      <div class="score-val" style="color:#f59e0b" id="s-streak">0</div>
      <div class="score-lbl">Série</div>
    </div>
  </div>

  <!-- QUESTION -->
  <div class="question-box">
    <div id="q-text" class="question-text">
      <div class="loading dots"><span></span><span></span><span></span></div>
    </div>
  </div>

  <!-- ✅ LES BOUTONS RÉPONSES S'INSÈRENT ICI AUTOMATIQUEMENT -->
  <div class="answers" id="answers"></div>

  <!-- FEEDBACK IA -->
  <div class="feedback" id="feedback"></div>

  <!-- BOUTON SUIVANT -->
  <button class="next-btn" id="next-btn" onclick="nextQuestion()">
    Question suivante →
  </button>

</div>

<script>
  // ─── CONFIG ──────────────────────────────────────────────
  const DOMAIN     = "{{ $domain }}";
  const DIFFICULTY = "{{ $difficulty }}";
  const TOTAL      = {{ $total }};
  const PLAYER     = "{{ $player }}";
  const JAVA_API   = "http://localhost:8080/api";  // ← port Java Spring Boot

  // ─── ÉTAT DU JEU ─────────────────────────────────────────
  let state = {
    qIndex:          0,
    score:           0,
    correct:         0,
    wrong:           0,
    streak:          0,
    maxStreak:       0,
    timer:           null,
    timeLeft:        30,
    currentQuestion: null,
    currentAnswers:  [],
    currentCorrect:  0,
    answered:        false   // ← empêche double-clic
  };

  // ─── DÉMARRAGE ───────────────────────────────────────────
  window.onload = () => loadQuestion();

  // ─── CHARGER UNE QUESTION DEPUIS JAVA + IA ───────────────
 async function loadQuestion() {
    // 1. Réinitialisation de l'interface
    state.answered = false;
    document.getElementById('q-text').innerHTML =
        '<div class="loading dots"><span></span><span></span><span></span></div>';
    document.getElementById('answers').innerHTML = '';
    document.getElementById('feedback').className = 'feedback';
    document.getElementById('next-btn').className = 'next-btn';
    clearTimer();

    try {
        // 2. Appel au serveur Java
        const url = `${JAVA_API}/question`
            + `?domain=${encodeURIComponent(DOMAIN)}`
            + `&difficulty=${encodeURIComponent(DIFFICULTY)}`;

        const response = await fetch(url);
        if (!response.ok) throw new Error(`Serveur Java : erreur ${response.status}`);

        const data = await response.json();

        // 3. Vérification de base des données
        if (!data) throw new Error("Réponse vide du serveur");

        // 4. Traitement et stockage de la question
        state.currentQuestion = data.question || "Question non définie";

        // Sécurité pour les réponses : on gère le JSON string ou l'objet direct
        let rawAnswers = data.answers;
        if (typeof rawAnswers === 'string') {
            try {
                rawAnswers = JSON.parse(rawAnswers);
            } catch (e) {
                throw new Error("Format JSON des réponses invalide");
            }
        }

        // --- CORRECTION CRITIQUE : On s'assure que c'est un tableau avant le forEach ---
        if (!Array.isArray(rawAnswers)) {
            console.error("Données reçues pour answers :", rawAnswers);
            throw new Error("Les réponses reçues ne sont pas un tableau (Array)");
        }

        state.currentAnswers = rawAnswers;
        state.currentCorrect = parseInt(data.correct);

        // 5. Affichage des infos textuelles
        document.getElementById('q-text').textContent = state.currentQuestion;
        document.getElementById('q-count').textContent =
            `Question ${state.qIndex + 1} / ${TOTAL}`;
        document.getElementById('progress').style.width =
            (state.qIndex / TOTAL * 100) + '%';

        // 6. ✅ CRÉATION DYNAMIQUE DES BOUTONS
        const letters = ['A', 'B', 'C', 'D'];
        const grid = document.getElementById('answers');
        grid.innerHTML = ''; // On vide la grille par sécurité

        state.currentAnswers.forEach((texteReponse, index) => {
            const bouton = document.createElement('button');
            bouton.className = 'ans-btn';

            // On utilise textContent pour le texte de la réponse (protection XSS)
            bouton.innerHTML = `
                <span class="ans-letter">${letters[index]}</span>
                <span class="ans-text"></span>
            `;
            bouton.querySelector('.ans-text').textContent = texteReponse;

            // Gestion du clic
            bouton.addEventListener('click', () => selectAnswer(index));
            grid.appendChild(bouton);
        });

        // 7. Lancement des mécaniques de jeu
        startTimer();
        if (typeof updateStrip === 'function') updateStrip();

    } catch (error) {
        // Affichage de l'erreur à l'utilisateur
        document.getElementById('q-text').innerHTML =
            `<span style="color: #ff4d4d;">❌ Erreur : ${error.message}</span>`;
        console.error("Erreur loadQuestion détaillée :", error);
    }
}

  // ─── JOUEUR CLIQUE SUR UNE RÉPONSE ───────────────────────
  async function selectAnswer(indexChoisi) {
    // Empêcher double-clic
    if (state.answered) return;
    state.answered = true;

    clearTimer();

    // Désactiver tous les boutons
    const tousLesBoutons = document.querySelectorAll('.ans-btn');
    tousLesBoutons.forEach(b => b.disabled = true);

    try {
      // Envoyer la réponse à Java pour vérification + feedback IA
      const response = await fetch(`${JAVA_API}/check`, {
        method:  'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          question:     state.currentQuestion,
          chosenIndex:  indexChoisi,
          correctIndex: state.currentCorrect,
          answers:      state.currentAnswers
        })
      });

      const result = await response.json();

      // ✅ Coloriser les boutons selon la bonne/mauvaise réponse
      tousLesBoutons[indexChoisi].classList.add(result.isCorrect ? 'correct' : 'wrong');
      if (!result.isCorrect) {
        tousLesBoutons[state.currentCorrect].classList.add('reveal');
      }

      // Mettre à jour les statistiques
      if (result.isCorrect) {
        state.score   += result.points || 100;
        state.correct++;
        state.streak++;
        state.maxStreak = Math.max(state.maxStreak, state.streak);
      } else {
        state.wrong++;
        state.streak = 0;
      }

      // Afficher le feedback IA (explication générée par Claude)
      const fb = document.getElementById('feedback');
      fb.textContent = result.feedback || (result.isCorrect ? '✓ Bonne réponse !' : '✗ Mauvaise réponse.');
      fb.className   = 'feedback show ' + (result.isCorrect ? 'ok' : 'bad');

      updateStrip();

    } catch (error) {
      // Vérification locale si Java ne répond pas
      const correct = (indexChoisi === state.currentCorrect);
      tousLesBoutons[indexChoisi].classList.add(correct ? 'correct' : 'wrong');
      if (!correct) tousLesBoutons[state.currentCorrect].classList.add('reveal');

      if (correct) { state.score += 100; state.correct++; state.streak++; }
      else         { state.wrong++; state.streak = 0; }

      const fb = document.getElementById('feedback');
      fb.textContent = correct ? '✓ Bonne réponse !' : `✗ La bonne réponse était : ${state.currentAnswers[state.currentCorrect]}`;
      fb.className   = 'feedback show ' + (correct ? 'ok' : 'bad');
      updateStrip();
    }

    // Afficher le bouton "Question suivante"
    document.getElementById('next-btn').className = 'next-btn show';
  }

  // ─── QUESTION SUIVANTE ────────────────────────────────────
  function nextQuestion() {
    state.qIndex++;
    if (state.qIndex >= TOTAL) {
      finishGame();
    } else {
      loadQuestion();
    }
  }

  // ─── FIN DU JEU ──────────────────────────────────────────
  async function finishGame() {
    document.querySelector('.container').innerHTML =
      '<div style="text-align:center;padding:60px">'
    + '<div class="loading dots"><span></span><span></span><span></span></div>'
    + '<p style="color:#a78bfa;margin-top:20px;font-size:16px">Analyse IA en cours...</p>'
    + '</div>';

    try {
      const response = await fetch(`${JAVA_API}/score`, {
        method:  'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          playerName: PLAYER,
          domain:     DOMAIN,
          difficulty: DIFFICULTY,
          correct:    state.correct,
          wrong:      state.wrong,
          maxStreak:  state.maxStreak
        })
      });

      const result = await response.json();

      // Rediriger vers la page de résultats
      const params = new URLSearchParams({
        score:      result.totalScore      || state.score,
        correct:    result.correct         || state.correct,
        wrong:      result.wrong           || state.wrong,
        total:      result.totalQuestions  || TOTAL,
        percentage: result.percentage      || Math.round(state.correct / TOTAL * 100),
        analysis:   result.analysis        || 'Bravo pour cette partie !',
        domain:     DOMAIN,
        player:     PLAYER
      });
      window.location.href = `/result?${params.toString()}`;

    } catch (error) {
      // Si Java ne répond pas, rediriger quand même avec les données locales
      const params = new URLSearchParams({
        score:      state.score,
        correct:    state.correct,
        wrong:      state.wrong,
        total:      TOTAL,
        percentage: Math.round(state.correct / TOTAL * 100),
        analysis:   'Bravo pour cette partie ! Continuez à pratiquer.',
        domain:     DOMAIN,
        player:     PLAYER
      });
      window.location.href = `/result?${params.toString()}`;
    }
  }

  // ─── TIMER ────────────────────────────────────────────────
  function startTimer() {
    state.timeLeft = 30;
    updateTimerDisplay();

    state.timer = setInterval(() => {
      state.timeLeft--;
      updateTimerDisplay();

      if (state.timeLeft <= 0) {
        clearTimer();
        // Temps écoulé = réponse fausse
        if (!state.answered) {
          state.answered = true;
          const btns = document.querySelectorAll('.ans-btn');
          btns.forEach(b => b.disabled = true);
          btns[state.currentCorrect].classList.add('reveal');
          state.wrong++;
          state.streak = 0;
          updateStrip();

          const fb = document.getElementById('feedback');
          fb.textContent = `⏱ Temps écoulé ! Bonne réponse : ${state.currentAnswers[state.currentCorrect]}`;
          fb.className   = 'feedback show bad';
          document.getElementById('next-btn').className = 'next-btn show';
        }
      }
    }, 1000);
  }

  function clearTimer() {
    if (state.timer) { clearInterval(state.timer); state.timer = null; }
  }

  function updateTimerDisplay() {
    const el = document.getElementById('timer');
    el.textContent = state.timeLeft;
    el.className   = 'timer'
      + (state.timeLeft <= 10 ? ' danger'
       : state.timeLeft <= 20 ? ' warn' : '');
  }

  // ─── MISE À JOUR SCORE AFFICHÉ ────────────────────────────
  function updateStrip() {
    document.getElementById('s-score').textContent   = state.score;
    document.getElementById('s-correct').textContent = state.correct;
    document.getElementById('s-wrong').textContent   = state.wrong;
    document.getElementById('s-streak').textContent  = state.streak;
  }
</script>
</body>
</html>
