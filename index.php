<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>test</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <div class="custom_heading">
            <h2 style="text-align: center; color:white;">PEOPLE DATA</h2>
            <button id="nextButton">Next Person</button>
        </div>
        <div class="container" id="personDetails">
            <?php
        $jsonData = file_get_contents('data.json');
        $people = json_decode($jsonData, true);
        $startIndex = 0;
        $endIndex = 2;

        for ($i = $startIndex; $i <= $endIndex; $i++) {
            if ($i >= count($people)) {
                break;
            }
            $person = $people[$i];
        ?>

            <div class="card" data-index="<?php echo $i + 1; ?>">
                <div class="card-header">
                    <h1><?php echo  $person['name']; ?></h1>
                </div>
                <div class="card-body">
                    <p>Location: <?php echo $person['location']; ?></p>
                </div>

            </div>

            <?php
        }
        ?>
        </div>
        <div class="bottom_heading">
            Currently <span id="countElement"></span> People Showing
        </div>
        <script>
        var jsonData;
        var startIndex = <?php echo $startIndex; ?>;
        var endIndex = <?php echo $endIndex; ?>;
        var personDetailsElement = document.getElementById("personDetails");
        var nextButton = document.getElementById("nextButton");
        var countElement = document.getElementById("countElement");

        nextButton.addEventListener("click", function() {
            if (endIndex >= jsonData.length - 1) {
                alert("No more people!");
                countElement.textContent = " 0";
                return;
            }
            startIndex += 3;
            endIndex += 3;
            displayPersons(startIndex, endIndex);
            updateCount(startIndex, endIndex);
        });

        function displayPersons(start, end) {
            personDetailsElement.innerHTML = "";
            for (var i = start; i <= end; i++) {
                if (i >= jsonData.length) {
                    break;
                }
                var person = jsonData[i];
                var personCard = document.createElement("div");
                personCard.classList.add("card");
                personCard.setAttribute("data-index", i + 1);
                var cardHeader = document.createElement("div");
                cardHeader.classList.add("card-header");
                var cardHeaderTitle = document.createElement("h1");
                cardHeaderTitle.textContent = 'Name: ' + person.name;
                cardHeader.appendChild(cardHeaderTitle);
                var cardBody = document.createElement("div");
                cardBody.classList.add("card-body");
                var cardBodyText = document.createElement("p");
                cardBodyText.textContent = 'Location: ' + person.location;
                cardBody.appendChild(cardBodyText);
                personCard.appendChild(cardHeader);
                personCard.appendChild(cardBody);
                personDetailsElement.appendChild(personCard);
            }
        }

        fetch("data.json")
            .then(response => response.json())
            .then(data => {
                jsonData = data;
                displayPersons(startIndex, endIndex);
                updateCount(startIndex, endIndex);
            })
            .catch(error => console.log(error));

        function updateCount(start, end) {
            var count = 0;
            var locationCount = 0;
            for (var i = start; i <= end; i++) {
                if (i >= jsonData.length) {
                    break;
                }
                var person = jsonData[i];
                if (person.name) {
                    count++;
                }
                if (person.location) {
                    locationCount++;
                }
            }
            countElement.textContent = " " + count;
        }
        </script>

    </body>

</html>