const buttons = document.querySelectorAll('.status-btn');

buttons.forEach(button => {

    button.addEventListener('click', function() {

        const jobId = this.dataset.id;

        fetch('../Controller/ToggleJobStatus.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'job_id=' + jobId
        })
        .then(response => response.json())
        .then(data => {

            if(data.success)
            {
                if(button.innerText == 'active')
                {
                    button.innerText = 'closed';
                }
                else
                {
                    button.innerText = 'active';
                }
            }

        });

    });

});
