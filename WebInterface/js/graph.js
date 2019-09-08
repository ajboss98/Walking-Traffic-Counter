$(document).ready(function() {
	$.ajax({
		url: "B:\web_project\index.php",
		type: "POST",
		success: function(data){
			console.log(data);
			var numPeople = [];
			for(var i in data) {
				numPeople.push(data[i].numPeople);
			}
			  		
		  var config = {
				type: 'line',
				data: {
					labels: [],
					datasets: [{
						label: 'People',
						backgroundColor: window.chartColors.red,
						borderColor: window.chartColors.red,
						data: [],
						fill: false,
					}]
				},
				options: {
					responsive: true,
					title: {
						display: true,
						text: 'Traffic Chart'
					},
					tooltips: {
						mode: 'index',
						intersect: false,
					},
					hover: {
						mode: 'nearest',
						intersect: true
					},
					scales: {
						xAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Time'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Number of People'
							}
						}]
					}
				}
			};

			window.onload = function() {
				var ctx = document.getElementById('canvas').getContext('2d');
				window.myLine = new Chart(ctx, config);
			};


			var colorNames = Object.keys(window.chartColors);


		  document.getElementById('hour').addEventListener('click', function() {
			if (config.data.datasets.length > 0) {
			  config.data.datasets.forEach(function(dataset) {
				//put in data that we grab from php
				var temp = numPeopl;
				dataset.data = temp;
			  });

			  config.data.labels = [10,20,30,40,50,60];
			  config.options.title.text = 'Traffic Chart for the past hour in minutes';

			  window.myLine.update();
			}
		  });
		  
			document.getElementById('day').addEventListener('click', function() {
			if (config.data.datasets.length > 0) {

			  //var month = MONTHS[config.data.labels.length % MONTHS.length];



			  // config.data.datasets.forEach(function(dataset) {
			  //   dataset.data.push(randomScalingFactor());
			  // });

			  //ur feg data goes here
			  config.data.datasets.forEach(function(dataset) {
				//put in data that we grab from php
				dataset.data = [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()];
			  });

			  config.data.labels = [3,6,9,12,15,18,21,24];
			  config.options.title.text = 'Traffic Chart for the past day in hours';

			  window.myLine.update();
			}
		  });
		  
			document.getElementById('week').addEventListener('click', function() {
				if (config.data.datasets.length > 0) {

				  //var month = MONTHS[config.data.labels.length % MONTHS.length];



				  // config.data.datasets.forEach(function(dataset) {
				  //   dataset.data.push(randomScalingFactor());
				  // });

				  //ur feg data goes here
				  config.data.datasets.forEach(function(dataset) {

					dataset.data = [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()];
				  });

				  config.data.labels = [1,2,3,4,5,6,7];
				  config.options.title.text = 'Traffic Chart for the past week in days';

				  window.myLine.update();
				}
			});
		  
			document.getElementById('month').addEventListener('click', function() {
				if (config.data.datasets.length > 0) {

				  //var month = MONTHS[config.data.labels.length % MONTHS.length];



				  // config.data.datasets.forEach(function(dataset) {
				  //   dataset.data.push(randomScalingFactor());
				  // });

				  //ur feg data goes here
				  config.data.datasets.forEach(function(dataset) {

					dataset.data = [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()];
				  });

				  config.data.labels = [7,14,21,28];
				  config.options.title.text = 'Traffic Chart for the past month in days';

				  window.myLine.update();
				}
			});
		  
			document.getElementById('year').addEventListener('click', function() {
				if (config.data.datasets.length > 0) {

				  //var month = MONTHS[config.data.labels.length % MONTHS.length];



				  // config.data.datasets.forEach(function(dataset) {
				  //   dataset.data.push(randomScalingFactor());
				  // });

				  //ur feg data goes here
				  config.data.datasets.forEach(function(dataset) {

					dataset.data = [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()];
				  });

				  config.data.labels = [1,2,3,4,5,6,7,8,9,10,11,12];
				  config.options.title.text = 'Traffic Chart for the past year in months';

				  window.myLine.update();
				}
			});

		},
		error: function(data){
			
		}
});