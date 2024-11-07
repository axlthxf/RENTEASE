


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link rel="stylesheet" href="feedback.css">
</head>
<body>
    <div class="header">
        <div class="logo">
           <a href="owner.php"> <img src="image/renteaselogo21.png" alt="Rentease Logo"></a>
        </div>
        <div class="feedback-header">
            <h1>Feedback Form</h1>
        </div>
        <div class=""></div>
      </div>
      <div class="feedback">

    <div class="feedback-container">

        <div class="feedback-box">
            <div class="feedback-title">
                <h2>Send us your feedback!</h2>
                <p>Do you have a suggestion or found some bug? Let us know in the field below.</p>
            </div>
            <form action="ownerfeedback_success.php" method="POST">
                <div class="experience-rating">
                    <p>How was your experience?</p>
                    <div class="rating-options">
                        <label>
                            <input type="radio" name="experience" value="good" required>
                            <span>😊</span>
                        </label>
                        <label>
                            <input type="radio" name="experience" value="neutral" required>
                            <span>😐</span>
                        </label>
                        <label>
                            <input type="radio" name="experience" value="bad" required>
                            <span>☹️</span>
                        </label>
                    </div>
                </div>
                <textarea name="description" rows="4" placeholder="Describe your experience here..." required></textarea>
                <div class="feedback-type">

                <button type="submit" class="send-feedback-btn">Send Feedback</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
