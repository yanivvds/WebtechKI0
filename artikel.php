<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Insider</title>
    <link rel="icon" type="image/x-icon" href="/fotos/favicon.ico">
    <link rel="stylesheet" href="css/stylesheet.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
      /* Custom styling for this page  */
    .activity-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        padding: 20px;
    }

    .activity-offer {
        position: relative;
        background-size: cover;
        background-position: center;
        color: #fff;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border-radius: 10px;
        height: 400px; 
    }   
    .save-icon {
        position: absolute;
        top: -13px;
        right: 15px;
        width: 51px;
        height: 32px;
        cursor: pointer;
        background-size: cover;
    }

    .save-icon.empty {
        background-image: url('/fotos/bookmark-empty.svg'); 
    }

    .save-icon.filled {
        background-image: url('/fotos/bookmark.svg'); 
    }

    .activity-offer::before {
        content: '';
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6); 
        border-radius: 10px;
    }

    .title-section {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .activity-offer * {
        position: relative;
        z-index: 1;
    }

    .activity-offer h2 {
        font-size: 1.5em;
        margin: 10px;
    }

    .short-description {
        margin: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    p {
        color: #fff;
        font-size: 20px;
        margin: 10px;
    }

    .full-description {
        max-height: 0;
        overflow-y: auto;
        transition: max-height 0.3s ease-in-out;
    }

    .read-more-button {
        align-self: center;
        margin-bottom: 10px;
        background-color: #b79079;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .activity-title {
        font-size: 1.5em;
        margin: 10px;
        flex-grow: 1;
    }

    .view-details-button {
        display: block;
        background-color: #986e43;
        color: white;
        padding: 10px 20px;
        text-align: center;
        width: 100%;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
    }

    .view-details-button:hover {
        background-color: #ab7946;
    }
    </style>
</head>
<body>
    <?php require_once("navbar.php"); ?>
    <div class="activity-container">
        <!-- Placeholder for the first activity -->
    </div>

    <script src="scrape.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Make an HTTP request to the server when the page loads
            fetch('/runPythonScript', { method: 'POST' })
                .then(response => response.json())
                .then(data => {
                    // Handle the received data and update the HTML content
                    updateActivityContent(data.activityData);
                })
                .catch(error => console.error('Error fetching data:', error));
        });

        function updateActivityContent(activityData) {
            const activityContainer = document.querySelector('.activity-container');

            activityData.forEach(data => {
                const activityOffer = createActivityOfferElement(data);
                activityContainer.appendChild(activityOffer);
            });
        }

        function createActivityOfferElement(data) {
            const activityOffer = document.createElement('div');
            activityOffer.classList.add('activity-offer');
            activityOffer.style.backgroundImage = `url(${data.imageUrl})`;

            const saveIcon = document.createElement('div');
            saveIcon.classList.add('save-icon', 'empty');
            activityOffer.appendChild(saveIcon);

            const titleSection = document.createElement('div');
            titleSection.classList.add('title-section');

            const activityTitle = document.createElement('h2');
            activityTitle.classList.add('activity-title');
            activityTitle.textContent = data.title;
            titleSection.appendChild(activityTitle);

            const viewDetailsButton = document.createElement('a');
            viewDetailsButton.classList.add('view-details-button');
            viewDetailsButton.href = data.href;
            viewDetailsButton.target = '_blank';
            viewDetailsButton.textContent = 'View Details';
            titleSection.appendChild(viewDetailsButton);

            activityOffer.appendChild(titleSection);

            const shortDescription = document.createElement('p');
            shortDescription.classList.add('short-description');
            shortDescription.textContent = data.shortDescription;
            activityOffer.appendChild(shortDescription);

            return activityOffer;
        }
    </script>
</body>
</html>
