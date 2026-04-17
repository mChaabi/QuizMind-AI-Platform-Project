package Quizmind.Quizmind.repository;
import Quizmind.Quizmind.model.Score;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;
import java.util.List;

@Repository
public interface ScoreRepository extends JpaRepository<Score, Long> {

    // Top 10 pour un domaine spécifique (ton Leaderboard par catégorie)
    List<Score> findTop10ByDomainOrderByTotalScoreDesc(String domain);

    // Top 10 global (tous domaines confondus)
    List<Score> findTop10ByOrderByTotalScoreDesc();

    // Utile pour afficher l'historique d'un joueur spécifique
    List<Score> findByPlayerNameOrderByPlayedAtDesc(String playerName);

    // Optionnel : Récupérer les derniers scores mondiaux pour un flux d'activité
    List<Score> findTop5ByOrderByPlayedAtDesc();
}