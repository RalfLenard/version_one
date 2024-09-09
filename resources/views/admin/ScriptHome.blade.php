

<script>
    // Enable Pusher logging - don't include this in production
    Pusher.logToConsole = true;

    // Initialize Pusher
    var pusher = new Pusher('c27cf1cca7e151dffc12', {
        cluster: 'ap1'
    });

    // Subscribe to the channel and bind to the event
    var channel = pusher.subscribe('adoption-requests');
    channel.bind('adoption-request.submitted', function(data) {
        console.log('Received data:', data); // Log data for debugging

        var countElement = document.getElementById('notificationCount');
        if (countElement) {
            // Retrieve the current notification count or initialize it to 0
            let currentCount = parseInt(countElement.innerText) || 0;
            // Increment the count
            countElement.innerText = currentCount + 1;

            var adoptionRequest = data.adoptionRequest;

            if (adoptionRequest) {
                // Use Toastify to display the notification
                Toastify({
                    text: `New Adoption Request Submitted by ${adoptionRequest.first_name || 'Unknown'} ${adoptionRequest.last_name || 'Unknown'}`,
                    duration: 5000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    style: {
                        background: "#4fbe87"
                    },
                    stopOnFocus: true
                }).showToast();

                // Generate the action buttons based on the adoption request status
               
               
            } 
        }
    });
</script>
