document.addEventListener("DOMContentLoaded", function () {
  const jobSelector = document.getElementById("job_selector");
  const tbody = document.getElementById("application_body");

  // Chart
  const ctx = document.getElementById("applicationFunnelChart").getContext("2d");
  let funnelChart = new Chart(ctx, {
    type: "bar", data: {
      labels: ["Submitted", "Reviewed", "Shortlisted", "Rejected"],
      datasets: [
        {
          label: "Application Count",
          data: [0, 0, 0, 0],
          backgroundColor: ["#95a5a6", "#f39c12", "#3498db", "#e74c3c"],
          borderWidth: 1,
        },
      ],
    },
    options: {
      indexAxis: "y",
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: { beginAtZero: true, ticks: { stepSize: 1 } },
      },
      plugins: {
        legend: { display: false },
      },
    },
  });

  // Chart data fetch
  function updateChart(jobId) {
    if (!jobId) {
      funnelChart.data.datasets[0].data = [0, 0, 0, 0];
      funnelChart.update();
      return;
    }

    fetch("../Controller/GetChartDataController.php?job_id=" + jobId)
      .then((res) => res.json())
      .then((data) => {
        funnelChart.data.datasets[0].data = [
          data.Submitted,
          data.Reviewed,
          data.Shortlisted,
          data.Rejected,
        ];
        funnelChart.update();
      })
      .catch((err) => console.error("Chart fetch error:", err));
  }

  // Job selector
  jobSelector.addEventListener("change", function () {
    const jobId = this.value;

    updateChart(jobId);

    if (!jobId) {
      tbody.innerHTML =
        '<tr><td colspan="5">Select a job to view applications.</td></tr>';
      return;
    }

    // Applications fetch
    fetch("../Controller/GetApplicationsController.php?job_id=" + jobId)
      .then((res) => res.text())
      .then((text) => {
        try {
          const data = JSON.parse(text);

          if (data.error) {
            tbody.innerHTML = `<tr><td colspan="5" style="color:red;">Error: ${data.error}</td></tr>`;
            return;
          }

          if (data.length === 0) {
            tbody.innerHTML =
              '<tr><td colspan="5">No applications found for this job.</td></tr>';
            return;
          }

          let html = "";
          data.forEach((app) => {
            html += `
              <tr>
                <td>${app.name}</td>
                <td>${app.headline || "N/A"}</td> 
                <td>${new Date(app.created_at).toLocaleDateString()}</td>
                <td>${app.cover_letter || "N/A"}</td>
                <td><a href="${app.resume_path}" target="_blank">Download Resume</a></td>
                <td>
                  <select class="status-updater" data-app-id="${app.id}">
                    <option value="Submitted"   ${app.status === "Submitted" ? "selected" : ""}>Submitted</option>
                    <option value="Reviewed"    ${app.status === "Reviewed" ? "selected" : ""}>Reviewed</option>
                    <option value="Shortlisted" ${app.status === "Shortlisted" ? "selected" : ""}>Shortlisted</option>
                    <option value="Rejected"    ${app.status === "Rejected" ? "selected" : ""}>Rejected</option>
                  </select>
                  <span id="badge-${app.id}" class="status-badge status-${app.status}">${app.status}</span>
                </td>
              </tr>`;
          });

          tbody.innerHTML = html;
          bindStatusChangeEvents();
        } catch (e) {
          console.error("Raw response:", text);
          tbody.innerHTML =
            '<tr><td colspan="5" style="color:red;">Invalid server response. Check Console (F12).</td></tr>';
        }
      })
      .catch((err) => {
        console.error("Fetch error:", err);
        tbody.innerHTML =
          '<tr><td colspan="5" style="color:red;">Network error. Check connection.</td></tr>';
      });
  });

  // Status update
  function bindStatusChangeEvents() {
    document.querySelectorAll(".status-updater").forEach((select) => {
      select.addEventListener("change", function () {
        const appId = this.getAttribute("data-app-id");
        const newStatus = this.value;
        const badge = document.getElementById("badge-" + appId);
        const currentJobId = jobSelector.value;

        fetch("../Controller/UpdateStatusController.php", {
          method: "PUT",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ id: appId, status: newStatus }),
        })
          .then((res) => res.json())
          .then((data) => {
            if (data.success) {
              badge.textContent = newStatus;
              badge.className = "status-badge status-" + newStatus;
              updateChart(currentJobId);
            } else {
              alert("Error: " + data.message);
            }
          })
          .catch((err) => console.error("Status update error:", err));
      });
    });
  }
});
