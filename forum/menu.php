<!-- menu.php -->
<div class="offcanvas offcanvas-end show" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel" aria-modal="true" role="dialog">
  <div class="offcanvas-header bg-primary text-white">
    <h5 class="offcanvas-title" id="offcanvasMenuLabel">
      <i class="bi bi-list"></i> Menu
    </h5>
    <button type="button" class="btn-close text-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <a href="forum.php" class="btn btn-outline-primary mb-3 w-100"><i class="bi bi-house-door-fill"></i> Main Forum</a>
    <a href="post-question.php" class="btn btn-outline-primary mb-3 w-100"><i class="bi bi-pencil-fill"></i> Post Question</a>
    <a href="my-questions.php" class="btn btn-outline-primary mb-3 w-100"><i class="bi bi-journal-text"></i> Your Questions</a>
    <a href="my-answers.php" class="btn btn-outline-primary mb-3 w-100"><i class="bi bi-chat-left-fill"></i> Your Answers</a>
  </div>
</div>

<style>
  .offcanvas {
    margin-top:7%;

    position: fixed;
    top: 10%;
    right: 0;
    bottom: 0;
    z-index: 1045;
    display: block;
    width: 250px;
    background-color: #fff;
    box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    transition: transform 0.3s ease-in-out;
  }

  .offcanvas-header {
    padding: 0.5rem 1rem;
    border-bottom: none;
  }

  .offcanvas-title {
    margin-bottom: 0;
    line-height: 1.5;
    font-weight: bold;
  }

  .offcanvas-body {
    padding: 20px;
  }

  .btn-outline-primary {
    border-color: #007bff;
    color: #007bff;
  }

  .btn-outline-primary:hover {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff;
  }

  .btn-close {
    font-size: 1.5rem;
  }
</style>
