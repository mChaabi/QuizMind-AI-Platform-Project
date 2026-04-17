package Quizmind.Quizmind.model;

import jakarta.persistence.*;
import jakarta.validation.constraints.*;
import lombok.*;

@Entity
@Table(name = "questions")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder // Pratique pour créer des objets : Question.builder().domain("AI").build()
public class Question {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @NotBlank(message = "Le domaine est obligatoire")
    private String domain;

    @NotBlank(message = "La difficulté est obligatoire")
    @Pattern(regexp = "facile|moyen|expert", message = "La difficulté doit être : facile, moyen ou expert")
    private String difficulty;

    @NotBlank(message = "Le texte de la question ne peut pas être vide")
    @Column(columnDefinition = "TEXT")
    private String questionText;

    @NotBlank(message = "La réponse 0 est obligatoire")
    private String answer0;

    @NotBlank(message = "La réponse 1 est obligatoire")
    private String answer1;

    @NotBlank(message = "La réponse 2 est obligatoire")
    private String answer2;

    @NotBlank(message = "La réponse 3 est obligatoire")
    private String answer3;

    @Min(0) @Max(3)
    private int correctIndex;

    @Column(columnDefinition = "TEXT")
    private String explanation;
}