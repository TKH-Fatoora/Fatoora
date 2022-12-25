
var category = document.getElementById('category').getAttribute('value').split(', ');
var ctotal = document.getElementById('ctotal').getAttribute('value').split(', ');

category.pop();
ctotal.pop();

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

const config = {
  type: 'pie',
  data: data,
};

const myChart = new Chart(
  document.getElementById('myChart'),
  config
);

// _______________________________________________________________________

var method = document.getElementById('method').getAttribute('value').split(', ');
var mtotal = document.getElementById('mtotal').getAttribute('value').split(', ');

method.pop();
mtotal.pop();

const data2 = {
  labels: method,
  datasets: [{
    data: mtotal,
    backgroundColor: [
      // '#FFADAD',
      // '#FFD6A5',
      '#FDFFB6',
      '#CAFFBF',
      // '#9BF6FF',
      '#A0C4FF',
      '#BDB2FF',
      '#FFC6FF',
    ],
    borderColor:'black',
    hoverOffset: 10
  }]
};

const config2 = {
  type: 'pie',
  data: data2,
};

const myChart2 = new Chart(
  document.getElementById('myChart2'),
  config2
);
