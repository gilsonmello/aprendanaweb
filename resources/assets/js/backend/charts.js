Chart.defaults.global = {
    // Boolean - Whether to animate the chart
    animation: true,

    // Number - Number of animation steps
    animationSteps: 60,

    // String - Animation easing effect
    // Possible effects are:
    // [easeInOutQuart, linear, easeOutBounce, easeInBack, easeInOutQuad,
    //  easeOutQuart, easeOutQuad, easeInOutBounce, easeOutSine, easeInOutCubic,
    //  easeInExpo, easeInOutBack, easeInCirc, easeInOutElastic, easeOutBack,
    //  easeInQuad, easeInOutExpo, easeInQuart, easeOutQuint, easeInOutCirc,
    //  easeInSine, easeOutExpo, easeOutCirc, easeOutCubic, easeInQuint,
    //  easeInElastic, easeInOutSine, easeInOutQuint, easeInBounce,
    //  easeOutElastic, easeInCubic]
    animationEasing: "easeOutQuart",

    // Boolean - If we should show the scale at all
    showScale: true,

    // Boolean - If we want to override with a hard coded scale
    scaleOverride: false,

    // ** Required if scaleOverride is true **
    // Number - The number of steps in a hard coded scale
    scaleSteps: null,
    // Number - The value jump in the hard coded scale
    scaleStepWidth: null,
    // Number - The scale starting value
    scaleStartValue: null,

    // String - Colour of the scale line
    scaleLineColor: "rgba(0,0,0,.1)",

    // Number - Pixel width of the scale line
    scaleLineWidth: 1,

    // Boolean - Whether to show labels on the scale
    scaleShowLabels: true,

    // Interpolated JS string - can access value
    scaleLabel: "<%=value%>",

    // Boolean - Whether the scale should stick to integers, not floats even if drawing space is there
    scaleIntegersOnly: true,

    // Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
    scaleBeginAtZero: false,

    // String - Scale label font declaration for the scale label
    scaleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",

    // Number - Scale label font size in pixels
    scaleFontSize: 12,

    // String - Scale label font weight style
    scaleFontStyle: "normal",

    // String - Scale label font colour
    scaleFontColor: "#666",

    // Boolean - whether or not the chart should be responsive and resize when the browser does.
    responsive: true,

    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio: true,

    // Boolean - Determines whether to draw tooltips on the canvas or not
    showTooltips: true,

    // Function - Determines whether to execute the customTooltips function instead of drawing the built in tooltips (See [Advanced - External Tooltips](#advanced-usage-custom-tooltips))
    customTooltips: false,

    // Array - Array of string names to attach tooltip events
    tooltipEvents: ["mousemove", "touchstart", "touchmove"],

    // String - Tooltip background colour
    tooltipFillColor: "rgba(0,0,0,0.8)",

    // String - Tooltip label font declaration for the scale label
    tooltipFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",

    // Number - Tooltip label font size in pixels
    tooltipFontSize: 14,

    // String - Tooltip font weight style
    tooltipFontStyle: "normal",

    // String - Tooltip label font colour
    tooltipFontColor: "#fff",

    // String - Tooltip title font declaration for the scale label
    tooltipTitleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",

    // Number - Tooltip title font size in pixels
    tooltipTitleFontSize: 14,

    // String - Tooltip title font weight style
    tooltipTitleFontStyle: "bold",

    // String - Tooltip title font colour
    tooltipTitleFontColor: "#fff",

    // Number - pixel width of padding around tooltip text
    tooltipYPadding: 6,

    // Number - pixel width of padding around tooltip text
    tooltipXPadding: 6,

    // Number - Size of the caret on the tooltip
    tooltipCaretSize: 8,

    // Number - Pixel radius of the tooltip border
    tooltipCornerRadius: 6,

    // Number - Pixel offset from point x to tooltip edge
    tooltipXOffset: 10,

    // String - Template string for single tooltips
    tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>",

    // String - Template string for multiple tooltips
    multiTooltipTemplate: "<%= value %>",


    // Function - Will fire on animation progression.
    onAnimationProgress: function(){},

    // Function - Will fire on animation completion.
    onAnimationComplete: function(){}
}

if(document.getElementById("course-graph") != undefined) {
    var ctx = document.getElementById("course-graph").getContext("2d");
    var sales_ctx = document.getElementById("sales-graph").getContext("2d");

    ctx.canvas.width = 50;
    ctx.canvas.height = 50;
    //sales_ctx.canvas.width = 300;
    sales_ctx.canvas.height = 100;

    create_chart_by_time(sales_ctx, 'annual', 'courses', 0)
    create_pie_chart(ctx, 'courses');

}
function create_chart_by_time(selector, period, type, specific){
    console.log('creating');
    $.ajax({
    url: "/admin/courses/report",
        type: "POST",
        data: {
            period: period,
            type: type,
            specific: specific,
    },
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    },
    cache: false,

        success: function(data){
            console.log(data);
            var data_keys = [];
            var data_values = [];

            $.each(data,function(key,value){
                data_keys.push(key);
                data_values.push(value);
            });




            var values = {
                labels: data_keys,
                datasets: [
                    {
                        label: 'Cursos vendidos',
                        fillColor: "rgba(60,60,60,0.2)",
                        strokeColor: "rgba(60,60,60,1)",
                        pointColor: "rgba(60,60,60,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(60,60,60,1)",
                        data: data_values
                    }]
            };
            console.log(values);


            var time_line_chart = new Chart(selector).Line(values,{
                bezierCurve: true,
                responsive: true
            });

        }
    });






}


function create_pie_chart(selector, type){
    console.log('creating');
    $.ajax({
        url: "/admin/courses/totalSales",
        type: "POST",
        data: {
            type: type
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,

        success: function(data){
            console.log(data);
            var total_data = [];
            var color = '';


            $.each(data,function(key,value){

                r = Math.floor(Math.random() * 200) + 50;
                console.log(r);
                g = Math.floor(Math.random() * 200) + 50;
                console.log(g);
                b = Math.floor(Math.random() * 200) + 50;
                console.log(b);
                color = 'rgb(' + r + ', ' + g + ', ' + b + ')';
                //data_keys.push(key);
                //data_values.push(value);
                console.log(value);
                total_data.push({
                    value: value,
                    label: key,
                    color: color
                });
            });

            console.log('finishing');
            console.log(total_data);


            //console.log(values);


            var time_line_chart = new Chart(selector).Pie(total_data,{

                animateRotate : true,
                legendTemplate:   "<table class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><tr><td><i class=\"fa fa-square\" style=\"color:<%=segments[i].fillColor%>; font-size: 3.0rem;\" ></i>&nbsp;&nbsp;<%if(segments[i].label){%><%=segments[i].label%><%}%></td></tr><%}%></table>"
            });

            console.log(time_line_chart.generateLegend())
            $("#course-legend").html(time_line_chart.generateLegend());

        }
    });




}








