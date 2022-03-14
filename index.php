<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    

    <title>Hello, world!</title>
  </head>
  <body>

      <div class="container">
          <div class="py-3 top-3 left-5">
              <h3>Dynamic charts using PHP, AJAX & MySQL</h3>
          </div>
      </div>

      <div class="container-fluid">
          <div class="row">
              <div class="col-md-3">
                  <div class="card mt-4">
                      <div class="card-header">pie chart</div>
                      <div class="card-body">
                          <div class="chart-container pie-chart">
                              <canvas id="pie_chart" width="200" height="150">

                              </canvas>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="card mt-4">
                      <div class="card-header">doughnut chart</div>
                      <div class="card-body">
                          <div class="chart-container pie-chart">
                              <canvas id="doughnut_chart" width="200" height="150">

                              </canvas>                              
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="card mt-4">
                      <div class="card-header">bar chart</div>
                      <div class="card-body">
                          <div class="chart-container pie-chart">
                              <canvas id="bar_chart" width="200" height="150">

                              </canvas>                              
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="card mt-4">
                      <div class="card-header">line chart</div>
                      <div class="card-body">
                          <div class="chart-container pie-chart">
                              <canvas id="line_chart" width="200" height="150">

                              </canvas>                              
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    
  </body>
</html>

<script>

    $(document).ready(function(){
        makechart();
    });


        function makechart()
        {
            $.ajax({
                url: "process.php",
                method: "POST",
                data: {action: "fetch"},
                dataType: "JSON",
                success: function(data)
                {                    
                    var name = [];
                    var balance = [];

                    for(var i in data)
                    {
                        
                        name.push(data[i].name);
                        balance.push(data[i].balance);
                    }

                    
                    console.log(name);


                    const chart_data = {
                        labels: name ,
                        datasets:[
                            {
                                label: 'accounts',
                                backgroundColor: ['#49e2ff', '#005ce6', '#739900'],
                                borderColor: '#4d4d4d',
                                hoverBackgroundColor: '#4d4d4d',
                                hoverBorderColor: '#4d4d4d',
                                data: balance
                            }
                        ]
                    };

                    const options = {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    };

                    const group_chart1 = document.getElementById('pie_chart').getContext('2d');

                    const graph1 = new Chart(group_chart1, {
                        type:"pie",
                        data: chart_data,
                        options: options
                    });



                    const group_chart2 = document.getElementById('doughnut_chart').getContext('2d');

                    const graph2 = new Chart(group_chart2, {
                        type:"doughnut",
                        data: chart_data,
                        options: options
                    });




                    const group_chart3 = document.getElementById('bar_chart').getContext('2d');

                    const graph3 = new Chart(group_chart3, {
                        type:"bar",
                        data: chart_data,
                        options: options
                    });



                    const group_chart4 = document.getElementById('line_chart').getContext('2d');

                    const graph4 = new Chart(group_chart4, {
                        type:"line",
                        data: chart_data,
                        options: options
                    });
                }
            })
        }

 
</script>