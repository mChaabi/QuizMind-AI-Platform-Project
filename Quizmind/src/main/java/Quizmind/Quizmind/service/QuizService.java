package Quizmind.Quizmind.service;

import Quizmind.Quizmind.model.Question;
import Quizmind.Quizmind.model.Score;
import Quizmind.Quizmind.repository.QuestionRepository;
import Quizmind.Quizmind.repository.ScoreRepository;
import lombok.RequiredArgsConstructor;
import lombok.extern.slf4j.Slf4j;
import org.springframework.stereotype.Service;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

@Service
@Slf4j
@RequiredArgsConstructor // Remplace @Autowired pour une injection par constructeur plus propre
public class QuizService {

    private final AiService aiService;
    private final QuestionRepository questionRepo;
    private final ScoreRepository scoreRepo;

    public Map<String, Object> getNextQuestion(String domain, String difficulty, String exclude) {
        Map<String, Object> result = new HashMap<>();

        try {
            // ✅ CORRECTION : On passe maintenant "exclude" à la méthode generateQuestion
            Map<String, Object> aiQuestion = aiService.generateQuestion(domain, difficulty, exclude);

            result.put("source", "ai");
            result.putAll(aiQuestion);
            result.put("success", true);

            log.info("Question générée par Groq pour le domaine: {} (Excluant: {})", domain, exclude);

        } catch (Exception e) {
            log.error("Échec de l'IA, passage à la base de données: {}", e.getMessage());

            // Gestion de la base de données (inchangée mais sécurisée)
            List<Question> questions = questionRepo.findRandomQuestions(domain, difficulty, 1);

            if (!questions.isEmpty()) {
                Question q = questions.get(0);
                result.put("source", "database");
                result.put("question", q.getQuestionText());
                result.put("answers", List.of(q.getAnswer0(), q.getAnswer1(), q.getAnswer2(), q.getAnswer3()));
                result.put("correct", q.getCorrectIndex());
                result.put("explanation", q.getExplanation());
                result.put("success", true);
            } else {
                result.put("success", false);
                result.put("error", "Aucune question disponible en local.");
            }
        }
        return result;
    }

    public Map<String, Object> checkAnswer(String question, int chosenIndex, int correctIndex, List<String> answers) {
        Map<String, Object> result = new HashMap<>();
        boolean isCorrect = (chosenIndex == correctIndex);

        result.put("isCorrect", isCorrect);
        result.put("correctIndex", correctIndex);
        result.put("correctAnswer", answers.get(correctIndex));

        try {
            String feedback = aiService.checkAnswer(
                    question,
                    answers.get(chosenIndex),
                    answers.get(correctIndex),
                    isCorrect
            );
            result.put("feedback", feedback);
        } catch (Exception e) {
            result.put("feedback", isCorrect ? "Excellent !" : "Dommage, réessaye !");
        }

        result.put("points", isCorrect ? 100 : 0);
        return result;
    }

    public Map<String, Object> saveScore(String playerName, String domain, String difficulty, int correct, int wrong, int maxStreak) {
        int total = correct + wrong;
        int totalScore = correct * 100;

        // Utilisation du @Builder de Lombok pour l'entité Score
        Score score = Score.builder()
                .playerName(playerName)
                .domain(domain)
                .difficulty(difficulty)
                .totalScore(totalScore)
                .correctAnswers(correct)
                .wrongAnswers(wrong)
                .maxStreak(maxStreak)
                .totalQuestions(total)
                .build();

        scoreRepo.save(score);

        Map<String, Object> response = new HashMap<>();
        response.put("totalScore", totalScore);

        try {
            response.put("analysis", aiService.analyzeScore(playerName, domain, correct, total, totalScore));
        } catch (Exception e) {
            response.put("analysis", "Superbe effort ! Continue de t'entraîner.");
        }

        response.put("percentage", total > 0 ? (correct * 100 / total) : 0);
        response.put("saved", true);
        return response;
    }

    public List<Score> getLeaderboard(String domain) {
        return (domain != null && !domain.isEmpty())
                ? scoreRepo.findTop10ByDomainOrderByTotalScoreDesc(domain)
                : scoreRepo.findTop10ByOrderByTotalScoreDesc();
    }
}