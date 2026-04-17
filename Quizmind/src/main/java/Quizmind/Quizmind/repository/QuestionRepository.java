package Quizmind.Quizmind.repository;
import Quizmind.Quizmind.model.Question;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface QuestionRepository extends JpaRepository<Question, Long> {

    // Ta méthode actuelle (parfaite pour filtrer)
    List<Question> findByDomainAndDifficulty(String domain, String difficulty);

    // 2. Récupérer des questions aléatoirement (indispensable pour un Quiz !)
    // Pour PostgreSQL, on utilise RANDOM()
    @Query(value = "SELECT * FROM questions q WHERE q.domain = :domain AND q.difficulty = :difficulty ORDER BY RANDOM() LIMIT :limit", nativeQuery = true)
    List<Question> findRandomQuestions(
            @Param("domain") String domain,
            @Param("difficulty") String difficulty,
            @Param("limit") int limit
    );

    // 3. Lister tous les domaines uniques disponibles en BDD
    @Query("SELECT DISTINCT q.domain FROM Question q")
    List<String> findAllUniqueDomains();
}