<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merci pour votre visite !</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400&display=swap" rel="stylesheet">
    <style>
        
       /* Styles de la section feedback */
       .feedback {
            transition: height 2s ease-in;
            padding: 15px;
            height: auto;
            width: 100%;
            max-width: 450px;
            background-color: #FF3366;
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #404040;
            font-family: 'Quicksand', sans-serif !important;
            margin: 0 auto;
        }
        .feedback h3 {
            margin-top: 0;
            font-weight: 700;
            /*font-size: 1.3rem;*/
        }
        .feedback_ratings {
            justify-content: space-between;
            display: flex;
            flex-wrap: nowrap;
        }
        .feedback_rating {
            cursor: pointer;
            padding: 6px 10px;
            background-color: #ff3366;
            border-radius: 100px;
            color: #404040;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .feedback_rating:hover {
            background-color: #404040;
            color: #ff3366;
            transform: scale(1.1);
        }
        .feedback-n {
            margin-top: 1rem;
            transition: all 200ms ease-in-out;
        }
        .feedback_notice {
            transition: all 200ms ease-in-out;
            padding: 10px;
            border-radius: 20px;
            display: flex;
            flex-direction: column;
        }
        .feedback_notice p {
            -webkit-animation: fade-in 1.2s cubic-bezier(0.39, 0.575, 0.565, 1) both;
            animation: fade-in 1.2s cubic-bezier(0.39, 0.575, 0.565, 1) both;
            margin: 0;
        }
        .rating_active {
            background-color: #404040;
            color: #FF3366;
            transition: all 200ms ease-in-out;
        }
        .active_feedback {
            height: 240px;
            transition: height 0.6s ease-in;
        }
        .hidden {
            display: none;
        }
        @-webkit-keyframes fade-in {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
        @keyframes fade-in {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

    </style>
    <style>
        /* Charger la police Quicksand */
        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;700&display=swap');

        /* Styles des messages */
        .message {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-family: 'Quicksand', sans-serif !important;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            color: #404040;
        }

        .message i {
            margin-right: 10px;
            font-size: 20px;
            color: #404040;
        }

        .success {
            background-color: #ff3366;
            color: #404040;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f5c6cb;
            color: #404040;
            border: 1px solid #f5c6cb;
        }

        .warning {
            background-color: #ffeeba;
            color: #404040;
            border: 1px solid #ffeeba;
        }

        .info {
            background-color: #bee5eb;
            color: #404040;
            border: 1px solid #bee5eb;
        }

        /* Style pour le message de remerciement */
        .thank-you {
            text-align: center;
            font-family: 'Quicksand', sans-serif !important;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php
    $message_sent = ""; // Initialiser la variable

    // Afficher les erreurs PHP
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer les données du formulaire
        $name = trim($_POST['name']);
        $from = trim($_POST['email']);
        $message_body = trim($_POST['message']);
        $recaptcha_response = $_POST['g-recaptcha-response'];

        // Vérifier le captcha
        $secret_key = '6Ld1igoqAAAAALFjBFCVv7z5PvsoYVXb-KXmLdiw';
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=$recaptcha_response");
        $response_keys = json_decode($response, true);

        // Afficher les valeurs récupérées pour vérification
        echo "<p class=\"message info\"><strong>Nom:</strong> " . htmlspecialchars($name) . "</p>";
        echo "<p class=\"message info\"><strong>Email:</strong> " . htmlspecialchars($from) . "</p>";
        echo "<p class=\"message info\"><strong>Message:</strong> " . htmlspecialchars($message_body) . "</p>";

        // Validation des données
        if (!empty($name) && !empty($from) && !empty($message_body) && filter_var($from, FILTER_VALIDATE_EMAIL)) {
            $to = "venothrajasekaran13@outlook.fr";
            $subject = "Prise de contact via mon site internet";
            $message = "Message : " . htmlspecialchars($message_body) . "\r\n" . "Nom : " . htmlspecialchars($name);
            $headers = "From: " . $from . "\r\n";
            $headers .= "Reply-To: " . $from . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/plain; charset=UTF-8\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();

            // Tester la fonction mail()
            if (mail($to, $subject, $message, $headers)) {
                $message_sent = "<p class=\"message success\"><i class='fas fa-check-circle'></i>L'email a été envoyé.</p>";
            } else {
                $message_sent = "<p class=\"message error\"><i class='fas fa-times-circle'></i>Erreur lors de l'envoi de l'email.</p>";
            }
        } else {
            $message_sent = "<p class=\"message warning\"><i class='fas fa-exclamation-circle'></i>Veuillez remplir tous les champs correctement.</p>";
        }
    }

    echo $message_sent;
    ?>
    <div class="feedback">
        <h3>Quelle note donneriez-vous à mon Portfolio ?</h3>
        <div class="feedback_ratings">
            <span class="feedback_rating" data-rate="1">😢 Nul</span>
            <span class="feedback_rating" data-rate="2">😒 Moyen</span>
            <span class="feedback_rating" data-rate="3">😐 OK</span>
            <span class="feedback_rating" data-rate="4">😏 Bien</span>
            <span class="feedback_rating" data-rate="5">😁 Bravo</span>
        </div>
        <div class="feedback-n"></div>
    </div>

    <script>
        const feedbackC = document.querySelector(".feedback");
        const addComment = document.querySelector(".feedback_comment");
        const ratings = document.querySelector(".feedback_ratings");
        const rating = document.querySelectorAll(".feedback_rating");
        const notice = document.querySelector(".feedback_notice");
        const noticeContainer = document.querySelector(".feedback-n");

        ratings.addEventListener("click", function (e) {
            const clicked = e.target.closest(".feedback_rating");
            console.log(clicked);
            if (!clicked) return;

            rating.forEach((r) => r.classList.remove("rating_active"));
            clicked.classList.add("rating_active");

            const data = clicked.dataset.rate;
            const rateEmoji = clicked.textContent.split(" ")[0];
            const rateText = clicked.textContent.split(" ")[1];
            console.log(rateEmoji);

            noticeContainer.innerHTML = "";
            const html = `<section class="feedback_notice">
                    <p> ${
                        data < 3
                            ? `Vous : Désolé, pour ce retour négative ${rateEmoji} ! <br/> Moi : Merci pour votre retour !`
                            : `Vous : ${rateText} ! <br/> Moi : Merci Beaucoup à vous ! ${rateEmoji}`
                    } </p>
                </section>`;

            noticeContainer.insertAdjacentHTML("afterbegin", html);
        });
    </script>
    <br/>
    <div class="thank-you">
        <p>Merci beaucoup pour votre participation et pour votre patience !!!!!!!!!!!!!!!!!</p>
        <img src="https://i.giphy.com/media/v1.Y2lkPTc5MGI3NjExbWhjaWNvb2FtMmd3cHh1cDlqYmJ1Y2hwNDYxcml4NjJrZHdsbHkwdiZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9cw/5zxGwho7LdRFujnyv8/giphy.gif" alt="Thank you gif">
    </div>

    
</body>
</html>