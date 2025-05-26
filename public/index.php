<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Live Scoreboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .gold {
        background-color: #FFD700 !important;
    }

    .silver {
        background-color: #C0C0C0 !important;
    }

    .bronze {
        background-color: #CD7F32 !important;
    }

    .highlight {
        transition: background-color 0.5s ease;
    }

    .pulse {
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.02);
        }

        100% {
            transform: scale(1);
        }
    }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <h1 class="text-center mb-4">Live Scoreboard</h1>
        <div class="row justify-content-center mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text">Auto-refresh</span>
                    <select id="refreshInterval" class="form-select">
                        <option value="5000">5 seconds</option>
                        <option value="10000" selected>10 seconds</option>
                        <option value="30000">30 seconds</option>
                        <option value="60000">1 minute</option>
                        <option value="0">Paused</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <div class="row fw-bold">
                    <div class="col-1">Rank</div>
                    <div class="col-5">User</div>
                    <div class="col-3">Total Points</div>
                    <div class="col-3">Last Updated</div>
                </div>
            </div>
            <div class="card-body p-0">
                <div id="scoreboardBody" class="list-group list-group-flush">
                    <!-- Scores will be loaded here -->
                    <div class="list-group-item text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Loading scoreboard...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    let refreshTimer;
    let lastUpdateTime = null;

    function loadScoreboard() {
        fetch('./includes/scoreboard-data.php')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    updateScoreboard(data.data);
                } else {
                    console.error('Error loading scores:', data.message);
                }
            })
            .catch(error => {
                document.getElementById('scoreboardBody').innerHTML = `
                    <div class="list-group-item text-center py-5 text-danger">
                        <p class="mt-2">${error.message}</p>
                        <button onclick="loadScoreboard()" class="btn btn-primary mt-2">Retry</button>
                    </div>
                `;
            });
    }

    function updateScoreboard(data) {
        const scoreboardBody = document.getElementById('scoreboardBody');
        let html = '';
        const now = new Date();
        const updateTime = now.getTime();
        const isInitialLoad = lastUpdateTime === null;
        lastUpdateTime = updateTime;

        // Group by user_id and calculate total points and latest timestamp
        const userScores = {};

        data.forEach(entry => {
            const userId = entry.user_id;
            if (!userScores[userId]) {
                userScores[userId] = {
                    total_points: 0,
                    last_updated: new Date(entry.created_at).getTime(),
                    full_name: entry.full_name || userId
                };
            }

            userScores[userId].total_points += entry.points;
            const entryTime = new Date(entry.created_at).getTime();
            if (entryTime > userScores[userId].last_updated) {
                userScores[userId].last_updated = entryTime;
            }
        });

        const sortedUsers = Object.entries(userScores).map(([userId, data]) => ({
            id: userId,
            full_name: data.full_name,
            total_points: data.total_points,
            last_updated: data.last_updated
        })).sort((a, b) => b.total_points - a.total_points);

        sortedUsers.forEach((user, index) => {
            const rank = index + 1;
            let rowClass = 'list-group-item';
            let highlightClass = '';

            if (rank === 1) rowClass += ' gold';
            else if (rank === 2) rowClass += ' silver';
            else if (rank === 3) rowClass += ' bronze';

            if (!isInitialLoad && user.last_updated > lastUpdateTime - 30000) {
                highlightClass = 'highlight pulse';
            }

            html += `
    <div class="${rowClass} ${highlightClass}" data-user-id="${user.id}">
        <div class="row align-items-center">
            <div class="col-1 fw-bold">${rank}</div>
            <div class="col-5">
                ${user.full_name} <small class="text-muted">(${user.id})</small>
            </div>
            <div class="col-3 fw-bold">${user.total_points}</div>
            <div class="col-3 fw-semibold">${new Date(user.last_updated).toLocaleTimeString()}</div>
        </div>
    </div>
`;

        });

        scoreboardBody.innerHTML = html;

        setTimeout(() => {
            document.querySelectorAll('.highlight').forEach(el => {
                el.classList.remove('pulse');
            });
        }, 3000);
    }

    function setupAutoRefresh() {
        clearInterval(refreshTimer);
        const interval = parseInt(document.getElementById('refreshInterval').value);
        if (interval > 0) {
            refreshTimer = setInterval(loadScoreboard, interval);
            loadScoreboard();
        }
    }

    document.getElementById('refreshInterval').addEventListener('change', setupAutoRefresh);
    setupAutoRefresh();
    </script>
</body>

</html>