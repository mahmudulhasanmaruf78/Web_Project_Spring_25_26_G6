document.addEventListener("DOMContentLoaded", function () {
  loadSummary();
  loadJobs();

  document.getElementById("apply_filters").addEventListener("click", loadJobs);
});

function loadSummary() {
  fetch("../Controller/AdminGetSummaryController.php")
    .then((response) => response.json())
    .then((data) => {
      document.getElementById("total_jobs").textContent = data.total_jobs;
      document.getElementById("total_apps").textContent = data.total_apps;

      const tbody = document.getElementById("category_summary_body");
      tbody.innerHTML = "";
      data.category_summary.forEach((cat) => {
        tbody.insertAdjacentHTML(
          "beforeend",
          `
                    <tr>
                        <td>${cat.category_name}</td>
                        <td>${cat.application_count}</td>
                    </tr>
                `,
        );
      });
    })
    .catch((error) => console.error("Error fetching summary:", error));
}

function loadJobs() {
  const categoryId = document.getElementById("filter_category").value;
  const status = document.getElementById("filter_status").value;

  // query string
  const params = new URLSearchParams();
  if (categoryId) params.append("category_id", categoryId);
  if (status) params.append("status", status);

  fetch("../Controller/AdminGetJobsController.php?" + params.toString())
    .then((response) => response.json())
    .then((data) => {
      const tbody = document.getElementById("global_jobs_body");
      tbody.innerHTML = "";

      if (data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5">No jobs found.</td></tr>';
        return;
      }

      data.forEach((job) => {
        const closeBtn =
          job.status === "active"
            ? `<button class="btn-close" data-job-id="${job.id}">Close Job</button>`
            : `<em>Closed</em>`;

        tbody.insertAdjacentHTML(
          "beforeend",
          `
                    <tr>
                        <td><strong>${job.title}</strong></td>
                        <td>${job.company_name}</td>
                        <td>${job.category_name || "N/A"}</td>
                        <td><span class="status-badge status-${job.status}">${job.status}</span></td>
                        <td>${closeBtn}</td>
                    </tr>
                `,
        );
      });

      bindCloseButtons();
    })
    .catch((error) => console.error("Error fetching jobs:", error));
}

function bindCloseButtons() {
  const buttons = document.querySelectorAll(".btn-close");
  buttons.forEach((button) => {
    button.addEventListener("click", function () {
      if (!confirm("Are you sure you want to close this job listing?")) return;

      const jobId = this.getAttribute("data-job-id");

      fetch("../Controller/AdminCloseJobController.php", {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ job_id: jobId }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            loadJobs(); // Reload the table
            loadSummary(); // Reload summary
          } else {
            alert("Error: " + data.message);
          }
        });
    });
  });
}
