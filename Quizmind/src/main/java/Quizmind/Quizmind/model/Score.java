package Quizmind.Quizmind.model;

import jakarta.persistence.*;
import jakarta.validation.constraints.*;
import lombok.*;
import java.time.LocalDateTime;

@Entity
@Table(name = "scores")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class Score {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @NotBlank(message = "Le nom du joueur est obligatoire")
    @Size(min = 2, max = 50, message = "Le nom doit contenir entre 2 et 50 caractères")
    private String playerName;

    @NotBlank(message = "Le domaine est obligatoire")
    private String domain;

    @NotBlank(message = "La difficulté est obligatoire")
    private String difficulty;

    @PositiveOrZero(message = "Le score total ne peut pas être négatif")
    private int totalScore;

    @PositiveOrZero(message = "Le nombre de bonnes réponses ne peut pas être négatif")
    private int correctAnswers;

    @PositiveOrZero(message = "Le nombre de mauvaises réponses ne peut pas être négatif")
    private int wrongAnswers;

    @PositiveOrZero(message = "Le record de série ne peut pas être négatif")
    private int maxStreak;

    @Min(value = 1, message = "Il doit y avoir au moins une question dans le quiz")
    private int totalQuestions;

    @Column(updatable = false)
    private LocalDateTime playedAt;

    @PrePersist
    public void prePersist() {
        this.playedAt = LocalDateTime.now();
    }
}