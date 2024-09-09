

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
                let actionButtons = '';
                if (adoptionRequest.status === 'Pending') {
                    actionButtons = `
                        <form action="/admin/adoption/${adoptionRequest.id}/verify" method="POST" class="d-inline">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-warning">Set to Verifying</button>
                        </form>
                    `;
                } else if (adoptionRequest.status === 'Verifying') {
                    actionButtons = `
                        <form action="/admin/adoption/${adoptionRequest.id}/approve" method="POST" class="d-inline">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-success">Approve</button>
                        </form>
                        <form action="/admin/adoption/${adoptionRequest.id}/reject" method="POST" class="d-inline">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger">Reject</button>
                        </form>
                    `;
                }

                // Append new adoption request to the table
                $('#dataTables-example tbody').prepend(`
                    <tr class="odd gradeX">
                        <td>${adoptionRequest.first_name || 'N/A'}</td>
                        <td>${adoptionRequest.last_name || 'N/A'}</td>
                        <td>${adoptionRequest.gender || 'N/A'}</td>
                        <td>${adoptionRequest.phone_number || 'N/A'}</td>
                        <td>${adoptionRequest.address || 'N/A'}</td>
                        <td>${adoptionRequest.salary || 'N/A'}</td>
                        <td>${adoptionRequest.question1 || 'N/A'}</td>
                        <td>${adoptionRequest.question2 || 'N/A'}</td>
                        <td>${adoptionRequest.question3 || 'N/A'}</td>
                        <td>
                            <img width="40px" height="40px" src="${adoptionRequest.valid_id ? '/storage/' + adoptionRequest.valid_id : '/images/placeholder.png'}" class="card-img-top" alt="Valid ID">
                        </td>
                        <td>
                            <img width="40px" height="40px" src="${adoptionRequest.valid_id_with_owner ? '/storage/' + adoptionRequest.valid_id_with_owner : '/images/placeholder.png'}" class="card-img-top" alt="ID with User">
                        </td>
                        <td>${actionButtons}</td> 
                    </tr>
                `);
            } else {
                console.error('adoptionRequest is undefined or not in the expected structure', data);
            }
        }
    });
</script>
