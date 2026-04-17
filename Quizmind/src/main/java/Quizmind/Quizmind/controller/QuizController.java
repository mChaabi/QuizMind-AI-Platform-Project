package Quizmind.Quizmind.controller;

import Quizmind.Quizmind.model.Score;
import Quizmind.Quizmind.service.QuizService;
import lombok.RequiredArgsConstructor;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

@RestController
@RequestMapping("/api")
@RequiredArgsConstructor // Injection propre via Lombok
@CrossOrigin(origins = "*") // Plus simple pour le développement
public class QuizController {

    private final QuizService quizService;

    @GetMapping("/question")
    public Map<String, Object> getQuestion(
            @RequestParam String domain,
            @RequestParam String difficulty,
            @RequestParam(required = false, defaultValue = "") String exclude) { // Ajoute ce paramètre

        return quizService.getNextQuestion(domain, difficulty, exclude);
    }

    @PostMapping("/check")
    public ResponseEntity<Map<String, Object>> checkAnswer(@RequestBody Map<String, Object> body) {
        // Extraction sécurisée des données
        String question = (String) body.get("question");
        int chosenIndex = ((Number) body.get("chosenIndex")).intValue();
        int correctIndex = ((Number) body.get("correctIndex")).intValue();

        @SuppressWarnings("unchecked")
        List<String> answers = (List<String>) body.get("answers");

        return ResponseEntity.ok(quizService.checkAnswer(question, chosenIndex, correctIndex, answers));
    }

    @PostMapping("/score")
    public ResponseEntity<Map<String, Object>> saveScore(@RequestBody Map<String, Object> body) {
        return ResponseEntity.ok(quizService.saveScore(
                (String) body.get("playerName"),
                (String) body.get("domain"),
                (String) body.get("difficulty"),
                ((Number) body.get("correct")).intValue(),
                ((Number) body.get("wrong")).intValue(),
                ((Number) body.get("maxStreak")).intValue()
        ));
    }

    @GetMapping("/leaderboard")
    public ResponseEntity<List<Score>> getLeaderboard(@RequestParam(required = false) String domain) {
        return ResponseEntity.ok(quizService.getLeaderboard(domain));
    }
}