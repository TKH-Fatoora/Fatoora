//  Chart.js to create pie charts
// It is open-source, easy to use, and provides a wide variety of chart types.

// _____________________________________________________________________________

// Total Per Category Pie Chart

// fetching all categories and the totals per category spendings
var category = document.getElementById('category').getAttribute('value').split(', ');
var ctotal = document.getElementById('ctotal').getAttribute('value').split(', ');

// formatting the arrays (remove the extra , at the end)
category.pop();
ctotal.pop();

// setting the data that would be represented in the pie chart (total per category)
const data = {
  labels: category,
  datasets: [{
    data: ctotal,
    backgroundColor: [
      '#FFADAD',
      '#FFD6A5',
      '#FDFFB6',
      '#CAFFBF',
      '#9BF6FF',
      '#A0C4FF',
      '#BDB2FF',
      '#FFC6FF',
    ],
    borderColor:'black',
    hoverOffset: 10
  }]
};

// choosing the chart type as pie chart
const config = {
  type: 'pie',
  data: data,
};

// setting the div in which the pie chart would be displayed
const myChart = new Chart(
  document.getElementById('myChart'),
  config
);

// _____________________________________________________________________________

// Total Per Payment Method Pie Chart

// fetching all payment methods and the totals per payment method spendings
var method = document.getElementById('method').getAttribute('value').split(', ');
var mtotal = document.getElementById('mtotal').getAttribute('value').split(', ');

// formatting the arrays (remove the extra , at the end)
method.pop();
mtotal.pop();

// setting the data that would be represented in the pie chart (total per payment method)
const data2 = {
  labels: method,
  datasets: [{
    data: mtotal,
    backgroundColor: [
      '#FDFFB6',
      '#CAFFBF',
      '#A0C4FF',
      '#BDB2FF',
      '#FFC6FF',
    ],
    borderColor:'black',
    hoverOffset: 10
  }]
};

// choosing the chart type as pie chart
const config2 = {
  type: 'pie',
  data: data2,
};

// setting the div in which the pie chart would be displayed
const myChart2 = new Chart(
  document.getElementById('myChart2'),
  config2
);
