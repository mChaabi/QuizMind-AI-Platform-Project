package Quizmind.Quizmind.service;

import com.fasterxml.jackson.core.type.TypeReference;
import com.fasterxml.jackson.databind.ObjectMapper;
import lombok.extern.slf4j.Slf4j;
import org.springframework.ai.chat.client.ChatClient;
import org.springframework.stereotype.Service;
import java.util.Map;

@Slf4j
@Service
public class AiService {

    private final ChatClient chatClient;

    // Spring AI injecte automatiquement le bean ChatClient configuré pour Groq
    public AiService(ChatClient.Builder chatClientBuilder) {
        this.chatClient = chatClientBuilder.build();
    }

    public Map<String, Object> generateQuestion(String domain, String difficulty, String exclude) {
        String prompt = """
Génère UNE question de quiz.

Format JSON STRICT (sans texte autour) :
{
  "question": "string",
  "answers": ["A", "B", "C", "D"],
  "correct": 0
}

Domaine: %s
Difficulté: %s
""".formatted(domain, difficulty);

        String rawJson = chatClient.prompt()
                .user(prompt)
                .call()
                .content();

        try {
            // 1. Enlever les balises Markdown si elles existent (```json et ```)
            String cleanedJson = rawJson.trim();
            if (cleanedJson.startsWith("```")) {
                cleanedJson = cleanedJson.replaceAll("^```json", "").replaceAll("^```", "").replaceAll("```$", "");
            }

            // 2. Nettoyage des apostrophes échappées (ton code actuel)
            cleanedJson = cleanedJson.replace("\\'", "'").trim();

            log.info("JSON nettoyé prêt pour parsing : {}", cleanedJson);

            ObjectMapper mapper = new ObjectMapper();
            return mapper.readValue(cleanedJson, new TypeReference<Map<String, Object>>() {});
        } catch (Exception e) {
            log.error("Erreur de parsing JSON. Contenu brut : {}", rawJson);
            log.error("Détail de l'erreur : {}", e.getMessage());
            throw new RuntimeException("IA Response Error");
        }
    }

    // ─── Vérifier une réponse et donner un feedback ────────
    public String checkAnswer(String question, String chosenAnswer, String correctAnswer, boolean isCorrect) {
        String prompt = """
            Question : {question}
            Le joueur a choisi : {chosen}
            La bonne réponse était : {correct}
            Résultat : {status}
            Donne un feedback pédagogique court (1 phrase).
            """;

        return chatClient.prompt()
                .user(u -> u.text(prompt)
                        .param("question", question)
                        .param("chosen", chosenAnswer)
                        .param("correct", correctAnswer)
                        .param("status", isCorrect ? "Correct" : "Incorrect"))
                .call()
                .content();
    }

    // ─── Analyser le score final ─────────────────
    public String analyzeScore(String playerName, String domain, int correct, int total, int score) {
        String prompt = """
            Analyse le score de {name} : {correct}/{total} sur le domaine {domain}.
            Score total : {score}.
            Écris une analyse motivante de 3 phrases avec des conseils.
            """;

        return chatClient.prompt()
                .user(u -> u.text(prompt)
                        .param("name", playerName)
                        .param("correct", correct)
                        .param("total", total)
                        .param("domain", domain)
                        .param("score", score))
                .call()
                .content();
    }
}