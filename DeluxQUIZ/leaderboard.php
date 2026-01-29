<div class="leaderboard-div">
        <h2>Top 10 Leaderboard</h2>
        <?php if (count($leaderboard) === 0): ?>
            <p class="yellow-text-sm">No scores yet!</p>
        <?php else: ?>
            <table class="table text-center mt-3 leaderboard-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Score</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($leaderboard as $i => $row): ?>
                        <tr <?= $row['username'] === $_SESSION['username'] ? 'class="table-highlight"' : '' ?>>
                            <td><?= $i + 1 ?></td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td>
                                <?= $row['amount_correct'] ?>/<?= $row['total_questions'] ?>
                            </td>
                            <td><?= $row['time_taken'] ?>s</td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        <?php endif; ?>
    </div>