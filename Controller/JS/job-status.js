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
                if(button.innerText.trim() == 'active')
                {
                    button.innerText = 'closed';

                    button.classList.remove('active');
                    button.classList.add('closed');
                }
                else
                {
                    button.innerText = 'active';

                    button.classList.remove('closed');
                    button.classList.add('active');
                }
            }
            else
            {
                alert(data.message);
            }

        });

    });

});
