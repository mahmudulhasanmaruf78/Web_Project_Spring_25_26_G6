// Select all status buttons
const buttons = document.querySelectorAll(".status-btn");

// Loop through each button
buttons.forEach(function(button) {

    // When button is clicked
    button.addEventListener("click", function() {

        // Get job ID from button
        let jobId = button.dataset.id;

        // Send data to PHP controller
        fetch("../Controller/ToggleJobStatus.php", {

            method: "POST",

            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },

            body: "job_id=" + jobId

        })

        // Convert response to JSON
        .then(function(response) {
            return response.json();
        })

        // Handle result
        .then(function(data) {

            // If status changed successfully
            if (data.success) {

                // Check current button text
                if (button.innerText == "active") {

                    button.innerText = "closed";

                    button.classList.remove("active");
                    button.classList.add("closed");

                } else {

                    button.innerText = "active";

                    button.classList.remove("closed");
                    button.classList.add("active");
                }

            } else {

                alert("Status update failed");

            }

        });

    });

});
