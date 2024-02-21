// Create the fake chart while the actual chart is loading
function createFakeChartLine1() {
    // Create the fake data
   const fakeData = [50, 40, 50, 45, 60];
  
    // Create the chart element
    const chartElement = document.getElementById('chartjs-dashboard-line');
    const ctx = chartElement.getContext('2d');
  
    if (window.myChartLine1) {
      // Destroy the existing chart instance if it exists
      window.myChartLine1.destroy();
    }
  
    // Create the fake chart
    window.myChartLine1 = new Chart(ctx, {
      type: 'line', // Use 'line' instead of 'bar'
      data: {
        labels: ['Label 1', 'Label 2', 'Label 3', 'Label 4', 'Label 5'],
        datasets: [
          {
            label: 'Data',
            data: fakeData,
          backgroundColor: ['rgba(255, 99, 132, 0.4)', 'rgba(54, 162, 235, 0.4)', 'rgba(255, 205, 86, 0.4)', 'rgba(75, 192, 192, 0.4)', 'rgba(153, 102, 255, 0.4)'],
          borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 205, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)'],
            borderWidth: 1
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        // Add other chart options as needed
      }
    });
    
  }
  function createFakeChartLine2() {
    // Create the fake data
    const fakeData = [50, 40, 50, 45, 60];
  
    // Create the chart element
    const chartElement = document.getElementById('chartjs-dashboard-line2');
    const ctx = chartElement.getContext('2d');
  
    if (window.myChartLine2) {
      // Destroy the existing chart instance if it exists
      window.myChartLine2.destroy();
    }
  
    // Create the fake chart
    window.myChartLine2 = new Chart(ctx, {
      type: 'line', // Use 'line' instead of 'bar'
      data: {
        labels: ['Label 1', 'Label 2', 'Label 3', 'Label 4', 'Label 5'],
        datasets: [
          {
            label: 'Data',
            data: fakeData,
          backgroundColor: ['rgba(255, 99, 132, 0.4)', 'rgba(54, 162, 235, 0.4)', 'rgba(255, 205, 86, 0.4)', 'rgba(75, 192, 192, 0.4)', 'rgba(153, 102, 255, 0.4)'],
          borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 205, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)'],
            borderWidth: 1
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        // Add other chart options as needed
      }
    });
    
  }
  function createFakeChartBar1() {
   // Create the fake data
  const fakeData = [10, 20, 30, 40, 50];
  
  // Create the chart element
  const chartElement = document.getElementById('chartjs-dashboard-bar');
  const ctx = chartElement.getContext('2d');
  
  if (window.myChartBar1) {
    // Destroy the existing chart instance if it exists
    window.myChartBar1.destroy();
  }
  
  // Create the fake chart
  window.myChartBar1 = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Label 1', 'Label 2', 'Label 3', 'Label 4', 'Label 5'],
      datasets: [
        {
          label: 'Data',
          data: fakeData,
          backgroundColor: ['rgba(255, 99, 132, 0.4)', 'rgba(54, 162, 235, 0.4)', 'rgba(255, 205, 86, 0.4)', 'rgba(75, 192, 192, 0.4)', 'rgba(153, 102, 255, 0.4)'],
          borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 205, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)'],
          borderWidth: 1
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      // Add other chart options as needed
    }
  });
  
    
  }
  function createFakeChartBar2() {
   // Create the fake data
  const fakeData = [10, 20, 30, 40, 50];
  
  // Create the chart element
  const chartElement = document.getElementById('chartjs-dashboard-bar2');
  const ctx = chartElement.getContext('2d');
  
  if (window.myChartBar2) {
    // Destroy the existing chart instance if it exists
    window.myChartBar2.destroy();
  }
  
  // Create the fake chart
  window.myChartBar2 = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Label 1', 'Label 2', 'Label 3', 'Label 4', 'Label 5'],
      datasets: [
        {
          label: 'Data',
          data: fakeData,
          backgroundColor: ['rgba(255, 99, 132, 0.4)', 'rgba(54, 162, 235, 0.4)', 'rgba(255, 205, 86, 0.4)', 'rgba(75, 192, 192, 0.4)', 'rgba(153, 102, 255, 0.4)'],
          borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 205, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)'],
          borderWidth: 1
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      // Add other chart options as needed
    }
  });
  
    
  }