// Render the customer sales chart
export function renderSalesChart() {
  const chartData = window.salesChartData;
  const labels = chartData.labels;
  const data = chartData.data;

  const canvas = document.getElementById("customerSalesChart");
  const ctx = canvas.getContext("2d");

  // Theme colors
  const root = getComputedStyle(document.documentElement);
  const baseColor = root.getPropertyValue("--brand-2").trim();
  const textMuted = root.getPropertyValue("--fg-muted").trim();

  // Chart height (CSS variable)
  const rowHeight = 26;
  const minHeight = 480;
  const chartHeight = Math.max(minHeight, labels.length * rowHeight);

  const wrap = canvas.closest(".chart-wrap");
  if (wrap) {
    wrap.style.setProperty("--chart-height", chartHeight + "px");
  }

  new Chart(ctx, {
    type: "bar",
    data: {
      labels: labels,
      datasets: [
        {
          label: "売上",
          data: data,
          backgroundColor: makeRgba(baseColor, 0.75),
        },
      ],
    },
    options: {
      indexAxis: "y",
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          displayColors: false,
          callbacks: {
            label: function (context) {
              const value = context.parsed.x;
              return "売上：" + Number(value).toLocaleString() + " 円";
            },
          },
        },
      },
      scales: {
        x: {
          ticks: {
            color: textMuted,
            callback: function (v) {
              return Number(v).toLocaleString();
            },
          },
          grid: { color: "rgba(255, 255, 255, 0.06)" },
        },
        y: {
          ticks: {
            color: textMuted,
            autoSkip: false,
          },
          grid: { display: false },
        },
      },
    },
  });
}

// Make rgba color string from hex
function makeRgba(hexColor, alpha) {
  const r = parseInt(hexColor.slice(1, 3), 16);
  const g = parseInt(hexColor.slice(3, 5), 16);
  const b = parseInt(hexColor.slice(5, 7), 16);
  return "rgba(" + r + "," + g + "," + b + "," + alpha + ")";
}
