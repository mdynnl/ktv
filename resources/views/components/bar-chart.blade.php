<div>
    <div x-data
         x-init="() => {
             var mychart = echarts.init($refs.container, null, { renderer: 'svg', width: '600px', height: '400px' });
         
             var option = {
                 title: {
                     text: 'Bar Chart Title'
                 },
                 tooltip: {},
                 legend: {
                     data: ['sales']
                 },
                 xAxis: {
                     data: ['Shirts', 'Cardigans', 'Chiffons', 'Pants', 'Heels', 'Socks']
                 },
                 yAxis: {},
                 series: [{
                     name: 'sales',
                     type: 'bar',
                     data: [5, 20, 36, 10, 10, 20]
                 }]
             };
         
             mychart.setOption(option);
         }">

        <div x-ref="container"></div>
    </div>
</div>
