<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Judge Scoring Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center mb-4">Judge Scoring Portal</h2>
        <div class="text-center mb-4">

            <a href="/Lampstackimplementation/public" class="btn btn-outline-secondary">scoring</a>
        </div>
        <div id="alertPlaceholder"></div>
        <div id="usersList" class="row gy-3">
            <!-- Users will be inserted here -->
        </div>
    </div>

    <script>
    function showAlert(type, message) {
        document.getElementById('alertPlaceholder').innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
          ${message}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      `;
    }

    // Fetch users and display
    function fetchUsers() {
        fetch("../../includes/get-users.php")
            .then(res => res.json())
            .then(data => {
                const usersList = document.getElementById('usersList');
                usersList.innerHTML = '';

                data.forEach(user => {
                    usersList.innerHTML += `
              <div class="col-md-6">
                <div class="card shadow-sm p-3">
                  <h5>${user.full_name}</h5>
                  <form onsubmit="submitScore(event, '${user.id}')">
                    <div class="input-group mt-2">
                      <input type="number" name="points" class="form-control" min="1" max="100"  placeholder="Enter points (1–100)">
                      <input type="hidden" name="user_id" class="form-control" readonly value="${user.id}" >
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            `;
                });
            })
            .catch((error) => showAlert('danger', 'Failed to load users' + error.message));
    }

    // function for selecting a random judge id instead of having a prefixxed value
    async function getRandomJudgeId() {
        try {
            const response = await fetch('../../includes/get-judgeId.php');


            const result = await response.json();
            if (result.status === 'success' && result.data.length > 0) {

                const judges = result.data;
                const randomJudgeId = judges[Math.floor(Math.random() * judges.length)];
                return randomJudgeId;
            } else {
                throw new Error("now judges found");
            }
        } catch (error) {
            console.error("Error fetching judge Id", error);
            return null;
        }
    }

    // Submit score
    async function submitScore(event, userId) {
        event.preventDefault();
        const randomJudgeId = await getRandomJudgeId();
        if (!randomJudgeId) return;
        const form = event.target;
        const formData = new FormData(form);
        formData.append("judge_id", randomJudgeId);


        fetch('../../includes/score-user.php', {
                method: 'POST',
                body: formData
            })
            .then(async res => {
                if (!res.ok) {
                    // parse the error response JSON
                    const errorData = await res.json();

                    // throw an error with the message property if it exists
                    const errorMessage = errorData.message || "Unknown server error";
                    throw new Error("Server responded with error: " + errorMessage);
                }
                return res.json(); // parse success response JSON
            })
            .then(data => {
                if (data.status === 'success') {
                    showAlert('success', data.message);
                    form.reset();
                } else {
                    showAlert('danger', data.message || 'Unknown error');
                }
            })
            .catch(error => {
                showAlert('danger', error.message);
            });
    }


    // Initial fetch
    fetchUsers();
    </script>
</body>

</html>