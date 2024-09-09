
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.11.1/toastify.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.11.1/toastify.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    // Initialize Pusher
    var pusher = new Pusher('c27cf1cca7e151dffc12', {
        cluster: 'ap1'
    });

    // Subscribe to the channel we specified in our Laravel Event
    var channel = pusher.subscribe('abuse-reports');

    // Bind a function to an Event (the event we defined in Laravel)
    channel.bind('AnimalAbuseReportSubmitted', function(data) {
        const report = data.report;  // Correctly accessing the 'report' object

         // Update the notification count
        var countElement = document.getElementById('notificationCount');
        countElement.innerText = parseInt(countElement.innerText) + 1;

        // Display a toast notification when new data is received
        Toastify({
            text: `New Abuse Report Submitted: ${report.description}`,
            duration: 5000,
            close: true,
            gravity: "top", // top or bottom
            position: "right", // left, center or right
            backgroundColor: "#4CAF50",
            stopOnFocus: true // Prevents dismissing of toast on hover
        }).showToast();

        // Append the new abuse report to the table
        $('#dataTables-example tbody').prepend(`
            <tr class="odd gradeX">
                <td>${report.description || 'N/A'}</td>
                <td>${report.photos1 ? `<img width="40px" height="40px" src="/storage/${report.photos1}" class="card-img-top">` : '<p>No image available.</p>'}</td>
                <td>${report.photos2 ? `<img width="40px" height="40px" src="/storage/${report.photos2}" class="card-img-top">` : '<p>No image available.</p>'}</td>
                <td>${report.photos3 ? `<img width="40px" height="40px" src="/storage/${report.photos3}" class="card-img-top">` : '<p>No image available.</p>'}</td>
                <td>${report.photos4 ? `<img width="40px" height="40px" src="/storage/${report.photos4}" class="card-img-top">` : '<p>No image available.</p>'}</td>
                <td>${report.photos5 ? `<img width="40px" height="40px" src="/storage/${report.photos5}" class="card-img-top">` : '<p>No image available.</p>'}</td>
                <td>${report.videos1 ? `<video width="320" height="240" controls><source src="${report.videos1}" type="video/mp4">Your browser does not support the video tag.</video>` : '<p>No video available.</p>'}</td>
                <td>${report.videos2 ? `<video width="320" height="240" controls><source src="${report.videos2}" type="video/mp4">Your browser does not support the video tag.</video>` : '<p>No video available.</p>'}</td>
                <td>${report.videos3 ? `<video width="320" height="240" controls><source src="${report.videos3}" type="video/mp4">Your browser does not support the video tag.</video>` : '<p>No video available.</p>'}</td>
                <td><a href="" class="btn btn-warning btn-sm">Edit</a></td>
                <td>
                    <form action="" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        `);
    });
</script>