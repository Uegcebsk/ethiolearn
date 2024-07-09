<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Questions</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            padding: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top:19px;
        }
        h2 {
            color: #333;
        }
        .filters {
            display: flex;
            justify-content: space-between;
            width: 100%;
            max-width: 600px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .actions {
            display: flex;
            gap: 5px;
        }
        .actions a {
            text-decoration: none;
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border-radius: 3px;
            cursor: pointer;
        }
        .actions a:hover {
            background-color: #45a049;
        }
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .pagination a {
            padding: 8px 16px;
            text-decoration: none;
            color: black;
            border: 1px solid #ddd;
            margin: 0 4px;
        }
        .pagination a.active {
            background-color: #4CAF50;
            color: white;
        }
        .pagination a:hover:not(.active) {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <h2>Questions for Exam Category: <?php echo htmlspecialchars($_GET['exam_category']); ?></h2>

    <div class="filters">
        <div>
            <label for="question_type">Filter by Question Type:</label>
            <select id="question_type" onchange="filterQuestions()">
                <option value="all">All</option>
                <option value="multiple_choice" <?php if (isset($_GET['question_type']) && $_GET['question_type'] == 'multiple_choice') echo 'selected'; ?>>Multiple Choice</option>
                <option value="true_false" <?php if (isset($_GET['question_type']) && $_GET['question_type'] == 'true_false') echo 'selected'; ?>>True/False</option>
                <option value="fill_in_the_blank" <?php if (isset($_GET['question_type']) && $_GET['question_type'] == 'fill_in_the_blank') echo 'selected'; ?>>Fill in the Blank</option>
            </select>
        </div>
        <div>
            <label for="items_per_page">Items per Page:</label>
            <select id="items_per_page" onchange="changeItemsPerPage()">
                <option value="5" <?php if (isset($_GET['items_per_page']) && $_GET['items_per_page'] == '5') echo 'selected'; ?>>5</option>
                <option value="10" <?php if (isset($_GET['items_per_page']) && $_GET['items_per_page'] == '10') echo 'selected'; ?>>10</option>
                <option value="20" <?php if (isset($_GET['items_per_page']) && $_GET['items_per_page'] == '20') echo 'selected'; ?>>20</option>
            </select>
        </div>
    </div>

    <?php
    include_once("../DB_Files/db.php");
    include_once("header copy.php");

    // Function to fetch questions based on exam category and pagination
    function fetchQuestionsForCategory($conn, $exam_category, $start, $itemsPerPage, $question_type = null) {
        $questions = array();

        // Prepare base SQL statement
        $sql = "SELECT * FROM exam_questions WHERE catergory = ?";
        $params = array($exam_category);

        // Add filter by question type if provided
        if ($question_type !== null && $question_type !== 'all') {
            $sql .= " AND question_type = ?";
            $params[] = $question_type;
        }

        // Add pagination limit and offset
        $sql .= " LIMIT ?, ?";
        $params[] = $start;
        $params[] = $itemsPerPage;

        // Prepare and execute statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch questions and store them in an array
        while ($row = $result->fetch_assoc()) {
            $questions[] = $row;
        }

        $stmt->close();

        return $questions;
    }

    // Function to get total number of questions for pagination
    function getTotalQuestionsCount($conn, $exam_category, $question_type = null) {
        // Prepare SQL statement
        $sql = "SELECT COUNT(*) AS total FROM exam_questions WHERE catergory = ?";
        $params = array($exam_category);

        // Add filter by question type if provided
        if ($question_type !== null && $question_type !== 'all') {
            $sql .= " AND question_type = ?";
            $params[] = $question_type;
        }

        // Prepare and execute statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stmt->close();

        return $row['total'];
    }

    // Check if exam category is provided in GET parameter
    if (isset($_GET['exam_category'])) {
        $exam_category = $_GET['exam_category'];

        // Determine current page and items per page
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $itemsPerPage = isset($_GET['items_per_page']) ? (int)$_GET['items_per_page'] : 5;

        // Calculate starting point for fetching questions
        $start = ($currentPage - 1) * $itemsPerPage;

        // Fetch questions based on selected question type (if provided)
        $questionType = isset($_GET['question_type']) ? $_GET['question_type'] : 'all';

        // Fetch questions count for pagination
        $totalQuestions = getTotalQuestionsCount($conn, $exam_category, $questionType);

        // Fetch questions based on category, question type, and pagination
        $exam_questions = fetchQuestionsForCategory($conn, $exam_category, $start, $itemsPerPage, $questionType);

        // Display questions
        if (!empty($exam_questions)) {
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Question</th>';
            echo '<th>Type</th>';
            echo '<th>Options / Answer</th>';
            echo '<th>Actions</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            foreach ($exam_questions as $question) {
                echo '<tr>';
                echo '<td>' . $question['question_text'] . '</td>';
                echo '<td>' . ucfirst(str_replace('_', ' ', $question['question_type'])) . '</td>';
                echo '<td>';

                // Display based on question type
                switch ($question['question_type']) {
                    case 'multiple_choice':
                        echo '<ul>';
                        echo '<li>Option 1: ' . $question['opt1'] . '</li>';
                        echo '<li>Option 2: ' . $question['opt2'] . '</li>';
                        echo '<li>Option 3: ' . $question['opt3'] . '</li>';
                        echo '<li>Option 4: ' . $question['opt4'] . '</li>';
                        echo '<li>Correct Answer: ' . $question['correct_answer'] . '</li>';
                        echo '</ul>';
                        break;

                    case 'true_false':
                        echo '<p>Correct Answer: ' . $question['correct_answer'] . '</p>';
                        break;

                    case 'fill_in_the_blank':
                        echo '<p>Correct Answer: ' . $question['correct_answer'] . '</p>';
                        break;

                    default:
                        echo '<p>Question Type not recognized.</p>';
                        break;
                }

                echo '</td>';
                echo '<td class="actions">';
                echo '<a href="edit_exam_questions.php?id=' . $question['id'] . '">Edit</a>';
                echo '<a href="delete_exam_questions.php?id=' . $question['id'] . '">Delete</a>';
                echo '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';

            // Pagination links
            $totalPages = ceil($totalQuestions / $itemsPerPage);
            if ($totalPages > 1) {
                echo '<div class="pagination">';
                for ($i = 1; $i <= $totalPages; $i++) {
                    $activeClass = ($i === $currentPage) ? 'active' : '';
                    echo '<a class="' . $activeClass . '" href="?exam_category=' . urlencode($_GET['exam_category']) . '&page=' . $i . '&items_per_page=' . $itemsPerPage . '&question_type=' . urlencode($questionType) . '">' . $i . '</a>';
                }
                echo '</div>';
            }

        } else {
            echo '<p>No questions found for Exam Category: ' . htmlspecialchars($_GET['exam_category']) . '</p>';
        }

    } else {
        echo '<p>Exam category not specified.</p>';
    }
    ?>

    <div style="margin-top: 20px;">
        <a href="add exams.php">Add More Questions</a>
    </div>

    <script>
        function filterQuestions() {
            var questionType = document.getElementById('question_type').value;
            var itemsPerPage = document.getElementById('items_per_page').value;
            var currentURL = window.location.href.split('?')[0]; // Get current page URL without query string
            var newURL = currentURL + '?exam_category=<?php echo urlencode($_GET['exam_category']); ?>&items_per_page=' + itemsPerPage;
            if (questionType !== 'all') {
                newURL += '&question_type=' + questionType;
            }
            window.location.href = newURL;
        }

        function changeItemsPerPage() {
            var itemsPerPage = document.getElementById('items_per_page').value;
            var questionType = document.getElementById('question_type').value;
            var currentURL = window.location.href.split('?')[0]; // Get current page URL without query string
            var newURL = currentURL + '?exam_category=<?php echo urlencode($_GET['exam_category']); ?>&items_per_page=' + itemsPerPage;
            if (questionType !== 'all') {
                newURL += '&question_type=' + questionType;
            }
            window.location.href = newURL;
        }
    </script>
</body>
</html>
