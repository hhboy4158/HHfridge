function logout(){
    $.ajax({
        type: "post",
        url: "./pages/login/loginFunc.php",
        data: {
            functionName: "Logout",
        },
        cache: false
    }).done(function(msg) {
        console.log(msg);
        if (msg == "0") {
            Swal.fire({
                icon: 'success',
                title: '登出成功!',
                // text: '滾出我的沼澤!',
            }).then(function() {
                window.location.href = "./../../index.php";
            })
        }
    })
    return false;
}


function RecipePieChart(RecipeName, RecipeCount){
  // console.log(RecipeName);
  // console.log(RecipeCount);
  // Chart.defaults.set('plugins.datalabels', {
  //   color: '#FE777B'
  // });
    // // Set new default font family and font color to mimic Bootstrap's default styling
    // Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    // Chart.defaults.global.defaultFontColor = '#858796';
    var ctx = document.getElementById("RecipePie");
    let datasetname = new Array();
    let datasetcolor = [
      '#F16B6F',//義
      '#4cb46a',//美
      '#299691',//泰
      '#00569f',//日
      '#ef5285',//韓
      'rgba(5, 111, 158, 1)',//台
      'rgba(153, 77, 82, 1)',//港
      'rgba(75, 192, 192, 1)',//川
      'rgba(153, 102, 255, 1)',//中
      'rgba(255, 159, 64, 1)',//法
      'rgba(75, 192, 192, 1)',//英  
    ];
    for(let i = 0; i < RecipeName.length; i++){
      datasetname.push({
        label : RecipeName[i],
        data : RecipeCount[i],
        backgroundColor : datasetcolor[i]
      });
    }
    var RecipePie = new Chart(ctx, {
      //圖表類型:
      //doughnut  : 甜甜圈狀
      //bar       : 柱狀長條圖
      //line      : 折線圖
      //radar     : 雷達圖
      //polarArea : 餵公子吃餅
      //bubble    : 泡泡
      // plugins: [ChartDataLabels],
      type: 'bar',
      data: {
        labels: "123" ,
        datasets: datasetname
      },
      options: {
        // showAllTooltips: true,
    
        plugins: {
          // Change options for ALL labels of THIS CHART
          // datalabels: {
          //   color: '#36A2EB',
          //   align: 'end',
          //   anchor: 'end',        
          //   // backgroundColor: function(context) {
          //   //   return context.dataset.backgroundColor;
          //   // },
          //   borderRadius: 4,
          //   color: 'white',
          //   formatter: Math.round
          // }
        },
        scales: { //bar 坐標軸
          yAxes: [{//Y軸
            ticks: {
              min:0, 
              max:120, 
              stepSize:20,
              // // Include a dollar sign in the ticks
              // callback: function(value, index, values) {
              //     return '$' + value;
              // }
            }
          }]
        },
        responsive: true, //rwd
        maintainAspectRatio: false, //維持橫縱比
        
        legend: {//圖例
          display: true,
          position: 'top',
        },
        // cutoutPercentage: 80,
      },
    });
    
}


/**
 * @returns Recipe Name array
 */
 function GetRecipeName(){
  let data;
  let a_name = [];
  $.ajax({
    type: "post",
    url: "./js/GetRecipeValue.php",
    data: {
      functionName: "Name",
    },
    cache: false
  }).done(function(msg) {
    data = JSON.parse(msg);
    // console.log(data);
    for (var i = 0; i < data.length; i++) {
      // var counter = data[i];
      a_name.push(data[i]);
      // a_name[i] = data[i];
    }
    
  })
  return a_name;  
}


function GetRecipeCount(){
  let data;
  let a_count = [];
  $.ajax({
      type: "post",
      url: "./js/GetRecipeValue.php",
      data: {
        functionName: "Count",
      },
      cache: false
  }).done(function(msg) {
    data = JSON.parse(msg);
    // console.log(data);
    for (var i = 0; i < data.length; i++) {
      // var counter = data[i];
      a_count.push(data[i]);
      // a_count[i] = data[i];
    }
    
  })
  return a_count;
}
    