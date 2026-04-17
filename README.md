<div align="center">

<img src="https://img.shields.io/badge/QuizMind-AI-7c3aed?style=for-the-badge&logo=openai&logoColor=white" alt="QuizMind AI"/>

# 🧠 QuizMind AI

### Jeu de Quiz Intelligent avec Intelligence Artificielle

*Questions générées en temps réel par Claude AI (Anthropic)*

<br/>

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![Java](https://img.shields.io/badge/Java-17+-ED8B00?style=flat-square&logo=openjdk&logoColor=white)](https://openjdk.org)
[![Spring Boot](https://img.shields.io/badge/Spring_Boot-3.2-6DB33F?style=flat-square&logo=springboot&logoColor=white)](https://spring.io)
[![Groq AI](https://img.shields.io/badge/Groq-AI-f55036?style=flat-square&logo=lightning&logoColor=white)](https://groq.com)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-15+-4169E1?style=flat-square&logo=postgresql&logoColor=white)](https://postgresql.org)


<br/>

</div>

---

## 📸 Screenshots

<div align="center">

### 🏠 Sélection du Domaine & Paramétrage
> Choisissez parmi 8 domaines, configurez la difficulté, le nombre de questions et entrez votre nom

<img width="1327" alt="Interface de Sélection et Paramétrage du Quiz AI" src="https://github.com/user-attachments/assets/85f320fe-b489-4d9e-8d82-a86bc6654088" />

<br/><br/>

### ❓ Question Interactive avec Compte à Rebours
> Chaque question est générée en temps réel par Groq AI — le timer décompte en direct

<img width="1139" alt="Interface de Question Interactive avec Compte à Rebours" src="https://github.com/user-attachments/assets/d4687b05-fc4f-482d-a893-1b74d42a806a" />

<br/><br/>

### ✅ Validation de Réponse & Feedback IA
> Après chaque réponse, Groq AI génère une explication pédagogique personnalisée

<img width="1227" alt="Feedback Utilisateur et Validation de Réponse Correcte" src="https://github.com/user-attachments/assets/69cda3cd-3bfe-4af4-ab1f-8e00f40cd0f2" />

<br/><br/>

### 📊 Tableau de Bord & Analyse de Performance
> Score final, statistiques détaillées et analyse complète générée par l'IA

<img width="852" alt="Tableau de Bord Récapitulatif et Analyse de Performance par IA" src="https://github.com/user-attachments/assets/9c3a80f2-3e52-4b2d-9b5a-0b4276e8563c" />

<br/><br/>

### 🏆 Classement par Domaine (Leaderboard)
> Top 10 des meilleurs scores sauvegardés en base de données, filtrés par catégorie

<img width="740" alt="Module de Classement (Leaderboard) par Catégorie" src="https://github.com/user-attachments/assets/1aac23e0-5015-4966-b818-c49b3d795eac" />

</div>

---

## 📋 Table des Matières

- [À propos](#-à-propos)
- [Architecture](#-architecture)
- [Technologies](#-technologies)
- [Prérequis](#-prérequis)
- [Installation](#-installation)
  - [1. Cloner le projet](#1-cloner-le-projet)
  - [2. Backend Java (Spring Boot)](#2-backend-java-spring-boot)
  - [3. Frontend Laravel](#3-frontend-laravel)
  - [4. Base de données](#4-base-de-données)
- [Configuration](#️-configuration)
- [Lancement](#-lancement)
- [Structure du projet](#-structure-du-projet)
- [API Endpoints](#-api-endpoints)
- [Fonctionnalités](#-fonctionnalités)
- [Comment jouer](#-comment-jouer)
- [Contribuer](#-contribuer)
- [Licence](#-licence)

---

## 🎯 À propos

**QuizMind AI** est une application de quiz interactive où **chaque question est générée en temps réel par l'intelligence artificielle Claude (Anthropic)**. Le projet suit une architecture moderne séparant clairement le frontend du backend :

- **Laravel** joue le rôle d'interface utilisateur (vues Blade, routing)
- **Java Spring Boot** gère toute la logique métier et les appels à l'IA
- **Groq AI** génère les questions, vérifie les réponses et analyse le score final

### ✨ Ce qui rend ce projet unique
- 🤖 Questions **100% générées par IA** — jamais deux parties identiques
- 💬 **Feedback pédagogique** après chaque réponse (expliqué par l'IA)
- 📊 **Analyse personnalisée** de vos résultats à la fin de chaque partie
- ⏱️ Timer dynamique avec pénalité de temps
- 🏆 Système de score avec séries de bonnes réponses (streaks)
- 🌍 9 domaines au choix : Science, Histoire, Géographie, Technologie, Cinéma, Sport, Musique, Culture Générale, Gastronomie

---

## 🏗️ Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                                                                 │
│   NAVIGATEUR                                                    │
│   └── Laravel (port 8000)         ← Interface utilisateur      │
│       ├── home.blade.php           (choix domaine)             │
│       ├── quiz.blade.php           (questions + timer)         │
│       └── result.blade.php         (score + analyse IA)        │
│                │                                                │
│                │  HTTP REST (JSON)                              │
│                ▼                                                │
│   Java Spring Boot (port 8080)    ← Logique + IA               │
│       ├── QuizController.java      /api/question               │
│       ├── QuizController.java      /api/check                  │
│       ├── QuizController.java      /api/score                  │
│       ├── AiService.java           ← Appels Groq AI          │
│       ├── QuizService.java         ← Logique du quiz           │
│       └── ScoreService.java        ← Calcul + sauvegarde       │
│                │                                                │
│                ├── PostgreSQL (port 5432)  ← Scores sauvegardés     │
│                │                                                │
│                └── Groq AI API     ← Groq               │
│                    ├── Génère questions                        │
│                    ├── Vérifie réponses + explique             │
│                    └── Analyse score final                     │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

### Flux d'une partie
```
Joueur → choisit domaine (Laravel)
       → charge question (Laravel → Java → Groq AI)
       → répond (Laravel → Java → Groq AI vérifie)
       → voit feedback IA (Java → Laravel)
       → fin de partie (Java sauvegarde score + Groq analyse)
       → page résultats (Laravel affiche analyse)
```

---

## 🛠️ Technologies

### Backend — Java
| Technologie | Version | Rôle |
|-------------|---------|------|
| Java (OpenJDK) | **17+** | Langage principal |
| Spring Boot | **3.2.x** | Framework web |
| Spring Data JPA | **3.2.x** | Accès base de données |
| Spring AI | Latest | Intégration Groq / Llama 3 |
| Gson | **2.10.1** | Parsing JSON |
| Maven | **3.9+** | Gestion des dépendances |
| PostgreSQL Driver | — | Connecteur PostgreSQL |

### Frontend — Laravel
| Technologie | Version | Rôle |
|-------------|---------|------|
| PHP | **8.2+** | Langage |
| Laravel | **11.x** | Framework MVC |
| Blade | **Laravel 11** | Moteur de templates |
| JavaScript (Vanilla) | **ES2020+** | Logique côté client |
| CSS3 | — | Styles et animations |
| Composer | **2.x** | Gestion des dépendances PHP |

### Base de données
| Technologie | Version | Rôle |
|-------------|---------|------|
| PostgreSQL | 15+ | Stockage persistant des scores |

### Intelligence Artificielle
| Service | Modèle | Rôle |
|---------|--------|------|
|Groq | **llama-3.3-70b-versatile** | Génération questions, feedback, analyse |

---

## ✅ Prérequis

Avant de commencer, assurez-vous d'avoir installé :

```bash
# Vérifier Java
java -version        # → doit afficher 17 ou supérieur

# Vérifier Maven
mvn -version         # → doit afficher 3.9+

# Vérifier PHP
php -version         # → doit afficher 8.2+

# Vérifier Composer
composer -version    # → doit afficher 2.x

# Vérifier MySQL
postgresql --version      # → doit afficher 8.0+
```

Vous avez également besoin de :
- ✅ Un compte [https://api.groq.com/openai/v1](https://api.groq.com/openai/v1) avec une **clé API**
- ✅ Une instance **postgresql** active (locale ou distante)

---

## 🚀 Installation

### 1. Cloner le projet

```bash
git clone https://github.com/mChaabi/quizmind-ai.git
cd quizmind-ai
```

Le projet contient deux dossiers séparés :
```
quizmind-ai/
├── quizmind-backend/    ← Java Spring Boot
└── quizmind-frontend/   ← Laravel
```

---

### 2. Backend Java (Spring Boot)

```bash
# Aller dans le dossier backend
cd quizmind-backend

# Installer les dépendances Maven
mvn clean install

# Copier le fichier de configuration
cp src/main/resources/application.properties.example \
   src/main/resources/application.properties
```

Éditer `src/main/resources/application.properties` :

```properties
# Serveur
server.port=8080

# Base de données PostgreSQL
spring.datasource.url=jdbc:PostgreSQL://localhost:5432/quizmind_db
spring.datasource.username=PostgreSQL
spring.datasource.password=Secret

# JPA — crée les tables automatiquement au premier lancement
spring.jpa.hibernate.ddl-auto=update
spring.jpa.show-sql=false

# Groq API (via Spring AI)
spring.ai.openai.api-key=${GROQ_API_KEY}
spring.ai.openai.base-url=[https://api.groq.com/openai/v1](https://api.groq.com/openai/v1)
spring.ai.openai.chat.options.model=llama-3.3-70b-versatile
```

---

### 3. Frontend Laravel

```bash
# Aller dans le dossier frontend
cd ../quizmind-frontend

# Installer les dépendances PHP
composer install

# Copier le fichier d'environnement
cp .env.example .env

# Générer la clé d'application Laravel
php artisan key:generate
```

Éditer le fichier `.env` :

```env
APP_NAME=QuizMindAI
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Laravel n'a pas besoin de base de données directement
# (c'est Java qui gère la DB)
DB_CONNECTION=mysql
DB_DATABASE=quizmind_db
```

---

### 4. Base de données

```sql
-- Créer la base de données postgresql
CREATE DATABASE quizmind_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

> ⚡ **Note :** Les tables sont créées **automatiquement** par Spring Boot au premier lancement grâce à `ddl-auto=update`. Pas besoin de migration manuelle.

---

## ⚙️ Configuration

### Clé API Anthropic (Claude AI)

1. Créer un compte sur [https://api.groq.com/openai/v1](https://api.groq.com/openai/v1)
2. Aller dans **API Keys** → **Create Key**
3. Copier la clé (format : `sk-ant-api03-...`)
4. Coller dans `quizmind-backend/src/main/resources/application.properties`

```properties
spring.ai.openai.api-key=${GROQ_API_KEY}
```

### Port du serveur Java

Si le port **8080** est déjà utilisé sur votre machine, changez-le :

```properties
# Dans application.properties
server.port=8081
```

Et mettre à jour la référence dans `quiz.blade.php` :

```javascript
// Dans quiz.blade.php — ligne JAVA_API
const JAVA_API = "http://localhost:8081/api";  // ← même port
```

---

## ▶️ Lancement

Ouvrir **deux terminaux** simultanément :

### Terminal 1 — Lancer Java Spring Boot
```bash
cd quizmind-backend
mvn spring-boot:run
```

✅ Succès quand vous voyez :
```
Started QuizmindBackendApplication in 3.2 seconds
Tomcat started on port(s): 8080
```

### Terminal 2 — Lancer Laravel
```bash
cd quizmind-frontend
php artisan serve
```

✅ Succès quand vous voyez :
```
INFO  Server running on [http://127.0.0.1:8000]
```

### Ouvrir dans le navigateur
```
http://localhost:8000
```

---

## 📁 Structure du projet

```
quizmind-ai/
│
├── 📂 quizmind-backend/                    ← Java Spring Boot
│   ├── 📂 src/main/java/com/quizmind/
│   │   ├── QuizmindBackendApplication.java  ← Point d'entrée
│   │   │
│   │   ├── 📂 controller/
│   │   │   └── QuizController.java          ← Endpoints REST API
│   │   │
│   │   ├── 📂 service/
│   │   │   ├── AiService.java               ← Appels Groq AI ⭐
│   │   │   ├── QuizService.java             ← Logique quiz
│   │   │   └── ScoreService.java            ← Calcul scores
│   │   │
│   │   ├── 📂 model/
│   │   │   ├── Question.java                ← Entité question
│   │   │   └── Score.java                   ← Entité score
│   │   │
│   │   └── 📂 repository/
│   │       ├── QuestionRepository.java      ← Accès DB questions
│   │       └── ScoreRepository.java         ← Accès DB scores
│   │
│   ├── 📂 src/main/resources/
│   │   └── application.properties           ← Configuration
│   │
│   └── pom.xml                              ← Dépendances Maven
│
├── 📂 quizmind-frontend/                   ← Laravel
│   ├── 📂 app/Http/Controllers/
│   │   └── QuizController.php               ← Contrôleur Laravel
│   │
│   ├── 📂 resources/views/
│   │   ├── home.blade.php                   ← Menu principal
│   │   ├── quiz.blade.php                   ← Écran de quiz ⭐
│   │   ├── result.blade.php                 ← Résultats finaux
│   │   └── leaderboard.blade.php            ← Classement
│   │
│   ├── 📂 routes/
│   │   └── web.php                          ← Routes Laravel
│   │
│   └── .env                                 ← Variables d'environnement
│
└── README.md
```

---

## 📡 API Endpoints

Le serveur Java expose les endpoints suivants sur `http://localhost:8080/api` :

### `GET /api/question`
Génère une question via Claude AI.

```bash
# Exemple
curl "http://localhost:8080/api/question?domain=Science&difficulty=facile"
```

```json
{
  "source": "ai",
  "question": "Quelle est la planète la plus proche du Soleil ?",
  "answers": "[\"Vénus\",\"Mercure\",\"Mars\",\"Terre\"]",
  "correct": 1,
  "explanation": "Mercure est la planète la plus proche du Soleil.",
  "success": true
}
```

---

### `POST /api/check`
Vérifie la réponse du joueur et retourne un feedback IA.

```bash
curl -X POST http://localhost:8080/api/check \
  -H "Content-Type: application/json" \
  -d '{
    "question": "Quelle est la planète la plus proche du Soleil ?",
    "chosenIndex": 1,
    "correctIndex": 1,
    "answers": ["Vénus","Mercure","Mars","Terre"]
  }'
```

```json
{
  "isCorrect": true,
  "correctIndex": 1,
  "correctAnswer": "Mercure",
  "feedback": "Excellent ! Mercure orbite à seulement 57 millions de km du Soleil.",
  "points": 100
}
```

---

### `POST /api/score`
Sauvegarde le score et retourne l'analyse IA finale.

```bash
curl -X POST http://localhost:8080/api/score \
  -H "Content-Type: application/json" \
  -d '{
    "playerName": "Ali",
    "domain": "Science",
    "difficulty": "facile",
    "correct": 8,
    "wrong": 2,
    "maxStreak": 5
  }'
```

```json
{
  "totalScore": 800,
  "correct": 8,
  "wrong": 2,
  "totalQuestions": 10,
  "percentage": 80,
  "analysis": "Excellent résultat Ali ! Vous maîtrisez bien les bases de la Science...",
  "saved": true
}
```

---

### `GET /api/leaderboard`
Retourne le top 10 des scores.

```bash
curl "http://localhost:8080/api/leaderboard?domain=Science"
```

---

## 🎮 Fonctionnalités

| Fonctionnalité | Description | Statut |
|----------------|-------------|--------|
| 🤖 Génération IA | Questions créées par Groq AI | ✅ |
| ⏱️ Timer | 30 secondes par question | ✅ |
| 💡 Feedback IA | Explication après chaque réponse | ✅ |
| 📊 Score en temps réel | Score, série, bonnes/mauvaises | ✅ |
| 🏆 Analyse finale | Rapport IA personnalisé | ✅ |
| 💾 Sauvegarde scores | Scores en base postgresql | ✅ |
| 🌍 9 domaines | Science, Histoire, Géo... | ✅ |
| 🎯 3 niveaux | Facile, Moyen, Expert | ✅ |
| 📱 Responsive | Mobile + Desktop | ✅ |
| 🏅 Classement | Top 10 par domaine | ✅ |

---

## 🕹️ Comment jouer

```
1. Ouvrir http://localhost:8000

2. Choisir un domaine (Science, Histoire, Géographie...)

3. Configurer la partie :
   - Nombre de questions : 5 / 10 / 15
   - Difficulté : Facile / Moyen / Expert
   - Entrer votre nom

4. Cliquer "Commencer le Quiz"

5. Pour chaque question :
   - Lire la question générée par l'IA
   - Cliquer sur la réponse (A, B, C ou D)
   - Lire le feedback IA explicatif
   - Passer à la question suivante

6. À la fin :
   - Voir votre score final et pourcentage
   - Lire l'analyse personnalisée de l'IA
   - Consulter le classement
   - Rejouer !
```

> ⚡ **Astuce Score :** Répondre vite = plus de points bonus ! Le score est calculé ainsi :
> ```
> Points = 100 pts (bonne réponse) + bonus vitesse
> Bonus = proportionnel au temps restant
> ```

---

## 🐛 Dépannage

### Les boutons de réponse n'apparaissent pas
```javascript
// Vérifier dans quiz.blade.php que JAVA_API pointe vers le bon port
const JAVA_API = "http://localhost:8080/api";  // ← doit correspondre à server.port
```

### Erreur CORS (Cross-Origin)
```java
// Vérifier dans QuizController.java
@CrossOrigin(origins = "http://localhost:8000")  // ← port Laravel
```

### Java ne démarre pas
```bash
# Vérifier la version Java
java -version  # doit être 17+

# Vérifier que MySQL est démarré
mysql -u root -p -e "SHOW DATABASES;"
```

### Claude AI ne répond pas
```bash
# Tester la clé API directement
curl https://api.anthropic.com/v1/messages \
  -H "x-api-key: sk-ant-VOTRE_CLE" \
  -H "anthropic-version: 2023-06-01" \
  -H "content-type: application/json" \
  -d '{"model":"claude-sonnet-4-20250514","max_tokens":10,"messages":[{"role":"user","content":"test"}]}'
```

---

## 🤝 Contribuer

Les contributions sont les bienvenues ! Pour contribuer :

```bash
# 1. Forker le projet
# 2. Créer une branche
git checkout -b feature/ma-nouvelle-fonctionnalite

# 3. Committer vos changements
git commit -m "feat: ajouter nouvelle fonctionnalité"

# 4. Pusher la branche
git push origin feature/ma-nouvelle-fonctionnalite

# 5. Ouvrir une Pull Request
```

### Idées de contributions
- [ ] Ajouter un mode multijoueur
- [ ] Support de nouveaux domaines
- [ ] Ajouter des images aux questions
- [ ] Mode hors-ligne avec questions en cache
- [ ] Application mobile (React Native / Flutter)
- [ ] Statistiques avancées par joueur

---


*QuizMind AI — Chaque partie est unique, chaque question est nouvelle*

</div>
