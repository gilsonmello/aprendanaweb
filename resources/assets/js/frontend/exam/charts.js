Chart.defaults.global = {
    animation: true,
    animationSteps: 60,
    animationEasing: "easeOutQuart",
    showScale: true,
    scaleOverride: false,
    scaleSteps: null,
    scaleStepWidth: null,
    scaleStartValue: null,
    scaleLineColor: "rgba(0,0,0,.1)",
    scaleLineWidth: 1,
    scaleShowLabels: true,
    scaleLabel: "<%=value%>",
    scaleIntegersOnly: true,
    scaleBeginAtZero: false,
    scaleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
    scaleFontSize: 12,
    scaleFontStyle: "normal",
    scaleFontColor: "#666",
    responsive: true,
    maintainAspectRatio: true,
    showTooltips: true,
    customTooltips: false,
    tooltipEvents: ["mousemove", "touchstart", "touchmove"],
    tooltipFillColor: "rgba(0,0,0,0.8)",
    tooltipFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
    tooltipFontSize: 14,
    tooltipFontStyle: "normal",
    tooltipFontColor: "#fff",
    tooltipTitleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
    tooltipTitleFontSize: 14,
    tooltipTitleFontStyle: "bold",
    tooltipTitleFontColor: "#fff",
    tooltipYPadding: 6,
    tooltipXPadding: 6,
    tooltipCaretSize: 8,
    tooltipCornerRadius: 6,
    tooltipXOffset: 10,
    tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>",
    multiTooltipTemplate: "<%= value %>",

    // Function - Will fire on animation progression.
    onAnimationProgress: function(){},

    // Function - Will fire on animation completion.
    onAnimationComplete: function(){}
}

if(document.getElementById("performance-graph") != undefined) {
    var ctx = document.getElementById("performance-graph").getContext("2d");

    ctx.canvas.width = 50;
    ctx.canvas.height = 50;
    //sales_ctx.canvas.width = 300;

    // create_chart_by_subject(ctx);
    create_right_chart(ctx);

}

if(document.getElementById("performance-rights-graph") != undefined) {
    var ctx = document.getElementById("performance-rights-graph").getContext("2d");

    ctx.canvas.width = 50;
    ctx.canvas.height = 50;
    //sales_ctx.canvas.width = 300;

    create_right_chart(ctx);

}



function create_chart_by_subject(selector){
    $.ajax({
        url: "/exam/performance",
        data: {
            'question-exec': $("question").data("question-exec")
        },
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,

        success: function(data){
            //console.log(data);
            var data_keys = [];
            var data_values = [];

            $.each(data,function(key,value){
                data_keys.push(key);
                data_values.push(Math.floor((value[1] * 100) / value[0]));
            });



            // console.log(data_keys);
            //console.log(data_values);
            var values = {
                labels: data_keys,
                datasets: [
                    {
                        label: 'Cursos vendidos',
                        fillColor: "rgba(151,187,205,0.5)",
                        strokeColor: "rgba(151,187,205,0.8)",
                        highlightFill: "rgba(151,187,205,0.75)",
                        highlightStroke: "rgba(151,187,205,1)",
                        data: data_values
                    }]
            };
            //  console.log(values);


            var time_line_chart = new Chart(selector).Bar(values,{
                barShowStroke: false,
                responsive: false
            });

        }
    });
}

function create_right_chart(selector){
//console.log('right_chart');
    var values = [
        {
            value:  Number($("#results").data('rights')).toFixed(0),
            color:"#3D9056",
            highlight: "#45A46A",
            label: "Acertos"
        },
        {
            value: $("#results").data('partial') - $("#results").data('rights'),
            color:"#F7464A",
            highlight: "#FF5A5E",
            label: "Erros"
        },



    ];


    // console.log(values);


    Chart.types.Doughnut.extend({
        name: "DoughnutAlt",
        draw: function () {
            Chart.types.Doughnut.prototype.draw.apply(this, arguments);

            var canvasWidthvar = this.chart.width;
            var canvasHeight =  this.chart.height;
            var constant = 114;
            var fontsize = (canvasHeight/constant).toFixed(2);
            this.chart.ctx.font=fontsize +"em Titillium Web,Arial,sans-serif";
            this.chart.ctx.textBaseline="middle";
            this.chart.ctx.textAlign = "left";

            var total = 0;
            var values = this.segments;
            $.each(values,function() {
                total += parseInt(this.value,10);
            });
            var tpercentage = ((values[0].value/total )*100).toFixed(0)+"%";
            var textWidth =  this.chart.ctx.measureText(tpercentage).width;

            var txtPosx = Math.round((canvasWidthvar - textWidth)/2);
            this.chart.ctx.fillStyle =  "#3D9056";
            this.chart.ctx.fillText(tpercentage, txtPosx, canvasHeight/2);
        }
    });







    var doughnut_chart = new Chart(selector).DoughnutAlt(values,{
        animation:true,
        responsive: true,
        showTooltips: true,
        percentageInnerCutout : 70,
        segmentShowStroke : false,
        scaleOverride : true,
        maintainAspectRatio: false
    });

}


function create_time_chart(selector){





    var values = [
        {
            value: Math.floor($("#results").data('time') / 60),
            color:"#F7464A",
            highlight: "#FF5A5E",
            label: "Tempo Utilizado"
        },
        {
            value: $("#results").data('total-time') - Math.floor($("#results").data('time') / 60) ,
            color:"#3D9056",
            highlight: "#45A46A",
            label: "Tempo Restante"
        }


    ];


    Chart.types.Doughnut.extend({
        name: "DoughnutAlt",
        draw: function () {
            Chart.types.Doughnut.prototype.draw.apply(this, arguments);

            var canvasWidthvar = this.chart.width;
            var canvasHeight =  this.chart.height;
            var constant = 114;
            var fontsize = (canvasHeight/constant).toFixed(2);
            this.chart.ctx.font=fontsize +"em Titillium Web,Arial,sans-serif";
            this.chart.ctx.textBaseline="middle";
            this.chart.ctx.textAlign = "left";
            this.chart.ctx.fillStyle =  "#F7464A";
            var total = 0;
            var values = this.segments;
            $.each(values,function() {
                total += parseInt(this.value,10);
            });
            var hours = Math.floor(values[0].value / 60);
            var minutes = Math.floor((values[0].value - (hours * 60))) ;

            //var tpercentage = (((values[0].value/total)*100) - 100).toFixed(2) * -1+"%";

            var tpercentage = hours + 'h' + minutes + 'm';
            var textWidth =  this.chart.ctx.measureText(tpercentage).width;

            var txtPosx = Math.round((canvasWidthvar - textWidth)/2);

            this.chart.ctx.fillText(tpercentage, txtPosx, canvasHeight/2);
        }
    });




    // console.log(values);

    var doughnut_chart = new Chart(selector).DoughnutAlt(values,{
        animation:true,
        responsive: true,
        showTooltips: true,
        percentageInnerCutout : 70,
        segmentShowStroke : false,
        scaleOverride : true,
        maintainAspectRatio: false
    });

}

function create_average_time_chart(selector){

    var values = [
        {
            value: Math.floor($("#results").data('time') / $("#results").data("partial")),
            color:"#F7464A",
            highlight: "#FF5A5E",
            label: "Tempo Médio"
        },
        {
            value: $("#results").data('total-time') - (Math.floor($("#results").data('time') / $("#results").data("partial"))),
            color:"#3D9056",
            highlight: "#45A46A",
            label: "Tempo Máximo"
        }


    ];


    Chart.types.Doughnut.extend({
        name: "DoughnutAlt",
        draw: function () {
            Chart.types.Doughnut.prototype.draw.apply(this, arguments);

            var canvasWidthvar = this.chart.width;
            var canvasHeight =  this.chart.height;
            var constant = 114;
            var fontsize = (canvasHeight/constant).toFixed(2);
            this.chart.ctx.font=fontsize +"em Titillium Web,Arial,sans-serif";
            this.chart.ctx.textBaseline="middle";
            this.chart.ctx.textAlign = "left";
            this.chart.ctx.fillStyle =  "#F7464A";
            var total = 0;
            var values = this.segments;
            $.each(values,function() {
                total += parseInt(this.value,10);
            });

            var minutes = Math.floor((values[0].value / 60)) ;
            var seconds = Math.floor((values[0].value - (minutes * 60)));

            //var tpercentage = (((values[0].value/total)*100) - 100).toFixed(2) * -1+"%";

            var tpercentage = minutes + 'm' + seconds + 's';
            var textWidth =  this.chart.ctx.measureText(tpercentage).width;

            var txtPosx = Math.round((canvasWidthvar - textWidth)/2);

            this.chart.ctx.fillText(tpercentage, txtPosx, canvasHeight/2);
        }
    });




    //  console.log(values);

    var doughnut_chart = new Chart(selector).DoughnutAlt(values,{
        animation:true,
        responsive: true,
        showTooltips: true,
        percentageInnerCutout : 70,
        segmentShowStroke : false,
        scaleOverride : true,
        maintainAspectRatio: false
    });
}

function create_total_chart(selector,show_percentage){


    var values = [
        {
            value: $("#results").data("partial"),
            color:"#31708f",
            highlight: "#31778f",
            label: "Questões"
        },
        {
            value: $("#results").data("total") - $("#results").data("partial") ,
            color:"#AAAABB",
            highlight: "#AAB1BB",
            label: "Questões"
        }

    ];

    console.log(selector);


    Chart.types.Doughnut.extend({
        name: "DoughnutAlt",
        draw: function () {
            Chart.types.Doughnut.prototype.draw.apply(this, arguments);

            var canvasWidthvar = this.chart.width;
            var canvasHeight =  this.chart.height;
            var constant = 114;
            var fontsize = (canvasHeight/constant - 1.0).toFixed(2);
            this.chart.ctx.font=fontsize +"em Titillium Web,Arial,sans-serif";
            this.chart.ctx.textBaseline="middle";
            this.chart.ctx.textAlign = "left";
            this.chart.ctx.fillStyle =  "#31708f";
            var total = 0;
            var values = this.segments;
            $.each(values,function() {
                total += parseInt(this.value,10);
            });



            var tpercentage = values[0].value + '/' + $("#results").data("total");
            if(show_percentage != undefined) tpercentage = ((values[0].value/total )*100).toFixed(0)+"%";
            var textWidth =  this.chart.ctx.measureText(tpercentage).width;

            var txtPosx = Math.round((canvasWidthvar - textWidth)/2);

            this.chart.ctx.fillText(tpercentage, txtPosx, canvasHeight/2);
        }
    });




    //  console.log(values);

    var doughnut_chart = new Chart(selector).DoughnutAlt(values,{
        animation:true,
        responsive: true,
        showTooltips: true,
        percentageInnerCutout : 70,
        segmentShowStroke : false,
        scaleOverride : true,
        maintainAspectRatio: false
    });
}


function create_clock(selector){
    var values = [
        {
            value: timer,
            color:"#F7464A",
            highlight: "#FF5A5E",
            label: "Acertos"
        },
        {
            value: parse_time_to_sec($("#time").data('time')) - timer,
            color: "lightgray",
            highlight:  "#5AFF5E",
            label: "Erros"
        }
    ];

    var doughnut_chart = new Chart(selector).Doughnut(values,{
        animation:true,
        responsive: false,
        showTooltips: false,
        percentageInnerCutout : 50,
        segmentShowStroke : false,
        scaleOverride : false,
        maintainAspectRatio: false
    });

    return doughnut_chart;
}

function create_workshop_clock(selector){
    var values = [
        {
            value: chrono_timer,
            color:"#F7464A",
            highlight: "#FF5A5E",
            label: "Acertos"
        },
        {
            value: parse_time_to_sec($("#chrono-display").text()) - chrono_timer,
            color: "lightgray",
            highlight:  "#5AFF5E",
            label: "Erros"
        }
    ];

    var doughnut_chart = new Chart(selector).Doughnut(values,{
        animation:true,
        responsive: false,
        showTooltips: false,
        percentageInnerCutout : 50,
        segmentShowStroke : false,
        scaleOverride : false,
        maintainAspectRatio: false
    });

    return doughnut_chart;
}



function create_dashboard_right_chart(){

    Chart.types.Doughnut.extend({
        name: "DoughnutAlt",
        draw: function () {
            Chart.types.Doughnut.prototype.draw.apply(this, arguments);

            var canvasWidthvar = this.chart.width;
            var canvasHeight =  this.chart.height;
            var constant = 114;

            var total = 0;
            var values = this.segments;
            $.each(values,function() {
                total += parseFloat(this.value,10);
            });
            var tpercentage = ((values[0].value/total )*100).toFixed(0)+"%";

            var fontsize = (canvasHeight/constant + 1.0).toFixed(2);
            this.chart.ctx.font=fontsize +"em Titillium Web,Arial,sans-serif";
            this.chart.ctx.textBaseline="middle";
            this.chart.ctx.textAlign = "left";

            var textWidth =  this.chart.ctx.measureText(tpercentage).width;
            var textHeight =  this.chart.ctx.measureText(tpercentage).height;

            console.log(this.chart.ctx.measureText(tpercentage));

            var txtPosx = Math.round((canvasWidthvar - textWidth)/2);
            this.chart.ctx.fillStyle =  "#3D9056";
            this.chart.ctx.fillText(tpercentage, txtPosx, ((canvasHeight )/2) );
            console.log("canvasHeight " + canvasHeight);
            console.log("textHeight " + textHeight);
        }
    });





    $(".best-graph").each(function(){




        console.log(Number($(this).data("best")));
        var values = [
            {
                value:  Number($(this).data("best")),
                color:"#5FBEAA",
                highlight: "#45A46A",
                label: "Acertos"
            },
            {
                value: Number($(this).data("questions-count")) - Number($(this).data('best')),
                color:"#CCCCCC",
                highlight: "#FF5A5E",
                label: "Erros"
            }


        ];

        console.log("Exemplo");
        var ctx = $(this).find('.best-result-graph')[0].getContext('2d');
        console.log(ctx);
        ctx.canvas.width = '100';
        ctx.canvas.height = '100';

        var doughnut_chart = new Chart(ctx).DoughnutAlt(values,{
            animation:false,
            responsive: false,
            showTooltips: false,
            percentageInnerCutout : 70,
            segmentShowStroke : false,
            scaleOverride : true,
            maintainAspectRatio: false
        });
    });

}

function create_performance_results_chart() {
    {

        Chart.types.Doughnut.extend({
            name: "DoughnutAlt",
            draw: function () {
                Chart.types.Doughnut.prototype.draw.apply(this, arguments);

                var canvasWidthvar = this.chart.width;
                var canvasHeight = this.chart.height;
                var constant = 114;

                var total = 0;
                var values = this.segments;
                $.each(values, function () {
                    total += parseInt(this.value, 10);
                });
                var tpercentage = ((values[0].value / total ) * 100).toFixed(0) + "%";

                var fontsize = (canvasHeight / constant).toFixed(2);
                this.chart.ctx.font = fontsize + "em Titillium Web,Arial,sans-serif";
                this.chart.ctx.textBaseline = "middle";
                this.chart.ctx.textAlign = "left";

                var textWidth = this.chart.ctx.measureText(tpercentage).width;
                var textHeight = this.chart.ctx.measureText(tpercentage).height;

                console.log(this.chart.ctx.measureText(tpercentage));

                var txtPosx = Math.round((canvasWidthvar - textWidth) / 2);
                this.chart.ctx.fillStyle = "#3D9056";
                this.chart.ctx.fillText(tpercentage, txtPosx, ((canvasHeight ) / 2));
                console.log("canvasHeight " + canvasHeight);
                console.log("textHeight " + textHeight);
            }
        });


        $(".performance-result-graph").each(function () {
            var values = [
                {
                    value: Number($(this).data("result")),
                    color: "#5FBEAA",
                    highlight: "#45A46A",
                    label: "Acertos"
                },
                {
                    value: 100 - Number($(this).data('result')),
                    color: "#CCCCCC",
                    highlight: "#FF5A5E",
                    label: "Erros"
                }


            ];


            var ctx = $(this).find('.performance-result-graph')[0].getContext('2d');
            console.log(ctx);
            ctx.canvas.width = '100';
            ctx.canvas.height = '100';

            var doughnut_chart = new Chart(ctx).DoughnutAlt(values, {
                animation: true,
                responsive: false,
                showTooltips: false,
                percentageInnerCutout: 70,
                segmentShowStroke: false,
                scaleOverride: true,
                maintainAspectRatio: false
            });
        });

    }
}


function create_intro_results_chart(){

    Chart.types.Doughnut.extend({
        name: "DoughnutAlt",
        draw: function () {
            Chart.types.Doughnut.prototype.draw.apply(this, arguments);

            var canvasWidthvar = this.chart.width;
            var canvasHeight =  this.chart.height;
            var constant = 114;

            var total = 0;
            var values = this.segments;
            $.each(values,function() {
                total += parseInt(this.value,10);
            });
            var tpercentage = ((values[0].value/total )*100).toFixed(0)+"%";

            var fontsize = (canvasHeight/constant).toFixed(2);
            this.chart.ctx.font=fontsize +"em Titillium Web,Arial,sans-serif";
            this.chart.ctx.textBaseline="middle";
            this.chart.ctx.textAlign = "left";

            var textWidth =  this.chart.ctx.measureText(tpercentage).width;
            var textHeight =  this.chart.ctx.measureText(tpercentage).height;

            console.log(this.chart.ctx.measureText(tpercentage));

            var txtPosx = Math.round((canvasWidthvar - textWidth)/2);
            this.chart.ctx.fillStyle =  "#3D9056";
            this.chart.ctx.fillText(tpercentage, txtPosx, ((canvasHeight )/2) );
            console.log("canvasHeight " + canvasHeight);
            console.log("textHeight " + textHeight);
        }
    });




    $(".result-graph").each(function(){
        var values = [
            {
                value:  Number($(this).data("result")),
                color:"#5FBEAA",
                highlight: "#45A46A",
                label: "Acertos"
            },
            {
                value: 100 - Number($(this).data('result')),
                color:"#CCCCCC",
                highlight: "#FF5A5E",
                label: "Erros"
            }


        ];

        console.log("Exemplo");
        var ctx = $(this).find('.intro-result-graph')[0].getContext('2d');
        console.log(ctx);
        ctx.canvas.width = '100';
        ctx.canvas.height = '100';

        var doughnut_chart = new Chart(ctx).DoughnutAlt(values,{
            animation:true,
            responsive: false,
            showTooltips: false,
            percentageInnerCutout : 70,
            segmentShowStroke : false,
            scaleOverride : true,
            maintainAspectRatio: false
        });
    });

}




function create_dashboard_study_charts(){

    Chart.types.Doughnut.extend({
        name: "DoughnutAlt",
        draw: function () {
            Chart.types.Doughnut.prototype.draw.apply(this, arguments);

            var canvasWidthvar = this.chart.width;
            var canvasHeight =  this.chart.height;
            var constant = 114;



            this.chart.ctx.textBaseline="middle";
            this.chart.ctx.textAlign = "left";


            var total = 0;
            var values = this.segments;
            //      console.log('resto - ' + values[1].value + 'total ' + values[0].value);
            $.each(values,function() {
                total += this.value;
            });
            //console.log('total: ' + total);
            var percentage = ((values[0].value/total )*100).toFixed(0);
            var tpercentage = percentage +"%";

            if(percentage < 40){


                this.segments[0].fillColor = "#F7464A";
                this.segments[0].highlightColor = "#FF5A5E";
                this.chart.ctx.fillStyle =  "#FF5A5E";

            }else if(percentage < 70){
                this.segments[0].fillColor = "#D4C76A";
                this.segments[0].highlightColor = "#FFF4AA";
                this.chart.ctx.fillStyle =  "#FFF4AA";

            }


            var textWidth =  this.chart.ctx.measureText(tpercentage).width;


            var txtPosx = Math.round((canvasWidthvar - textWidth)/2);


            var fontsize = (canvasHeight/constant + 1.0).toFixed(2);

            this.chart.ctx.font=fontsize +"em Titillium Web,Arial,sans-serif";
            this.chart.ctx.fillText(tpercentage, txtPosx, canvasHeight/2);
        }
    });



    var study_time = $("#study-achievements").data("study-time");

    //  console.log( $("#study-plan-daily").data('time-today'));
    //  console.log(study_time);



    var daily_values =
        [

            {
                value: $("#study-plan-daily").data('time-today') / 3600,
                color:"#3D9056",
                highlight: "#45A46A",
                label: 'Horas Cumpridas'
            },
            {
                value: study_time - ( $("#study-plan-daily").data('time-today') / 3600 ),
                color:"#E6E6E6",
                highlight: "#EEFAFA",
                label: 'Horas diárias'
            }



        ];



    var weekly_values =
        [

            {
                value: $("#study-plan-weekly").data('time-this-week') / 3600,
                color:"#3D9056",
                highlight: "#45A46A",
                label: 'Horas Cumpridas'
            },
            {
                value: study_time * 7 - ($("#study-plan-weekly").data('time-this-week') / 3600),
                color:"#E6E6E6",
                highlight: "#EEFAFA",
                label: 'Horas semanais'
            }

        ];


    var monthly_values =
        [
            {
                value: $("#study-plan-monthly").data('time-this-month') / 3600,
                color:"#3D9056",
                highlight: "#45A46A",
                label: 'Horas Cumpridas'
            },
            {
                value: study_time * 30 - ($("#study-plan-monthly").data('time-this-month') / 3600),
                color:"#E6E6E6",
                highlight: "#EEFAFA",
                label: 'Horas mensais'
            }


        ];

    var ctxDaily = $("#study-plan-daily")[0].getContext('2d');
    ctxDaily.canvas.width = '100';
    ctxDaily.canvas.height = '100';

    var ctxWeekly = $("#study-plan-weekly")[0].getContext('2d');
    ctxWeekly.canvas.width = '100';
    ctxWeekly.canvas.height = '100';

    var ctxMonthly = $("#study-plan-monthly")[0].getContext('2d');
    ctxMonthly.canvas.width = '100';
    ctxMonthly.canvas.height = '100';



    var doughnut_chart_daily = new Chart(ctxDaily).DoughnutAlt(daily_values,{
            animation:true,
            animationSteps: 40,
            responsive: false,
            showTooltips: false,
            percentageInnerCutout : 70,
            segmentShowStroke : false,
            scaleOverride : true,
            maintainAspectRatio: false
        });

    var doughnut_chart_monthly = new Chart(ctxMonthly).DoughnutAlt(monthly_values,{
        animation:true,
        animationSteps: 40,
        responsive: false,
        showTooltips: false,
        percentageInnerCutout : 70,
        segmentShowStroke : false,
        scaleOverride : true,
        maintainAspectRatio: false
    });

    var doughnut_chart_weekly = new Chart(ctxWeekly).DoughnutAlt(weekly_values,{
        animation:true,
        animationSteps: 40,
        responsive: false,
        showTooltips: false,
        percentageInnerCutout : 70,
        segmentShowStroke : false,
        scaleOverride : true,
        maintainAspectRatio: false,
        scaleFontSize: 16,
        tooltipFontSize: 16,
    });

}

var period_values;
var period_progress_data;
var study_time;
function create_dashboard_progress_charts(){
    $.ajax({
        url: "/dashboard/progress",
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,

        success: function(data){

            period_progress_data = data;

            study_time = $("#study-achievements").data("study-time");
            var daily = data['daily'];



            var data_keys = [];
            var data_values = [];
            var data_empty = [];

            $.each(daily,function(key,value){
                data_keys.push(key);
                data_values.push(value / 3600);
                data_empty.push(study_time);
            });


            period_values = {
                labels: data_keys,
                datasets: [
                    {
                        label: 'Horas Assistidas',
                        fillColor: "rgba(151,187,205,0.5)",
                        strokeColor: "rgba(151,187,205,0.8)",
                        highlightFill: "rgba(151,187,205,0.75)",
                        highlightStroke: "rgba(151,187,205,1)",
                        data: data_values
                    },
                    {
                        label: 'Horas Assistidas',
                        fillColor: "rgba(200,200,225,0.0)",
                        strokeColor: "#00CCCC",
                        highlightFill: "rgba(151,187,205,0.75)",
                        highlightStroke: "rgba(151,187,205,1)",
                        pointColor: "rgba(0,0,0,0)",
                        pointStrokeColor: "rgba(0,0,0,0)",
                        pointHighlightFill: "rgba(0,0,0,0)",
                        pointHighlightStroke: "rgba(0,0,0,0)",
                        data: data_empty
                    },
                    {
                        label: 'Horas Assistidas',
                        fillColor: "rgba(200,200,225,0.0)",
                        strokeColor:  "rgba(151,187,205,0.0)",
                        highlightFill: "rgba(151,187,205,0.0)",
                        highlightStroke: "rgba(151,187,205,0)",
                        pointColor: "rgba(0,0,0,0)",
                        pointStrokeColor: "rgba(0,0,0,0)",
                        pointHighlightFill: "rgba(0,0,0,0)",
                        pointHighlightStroke: "rgba(0,0,0,0)",
                        data: [study_time + 1]
                    }]
            };

            console.log('set initial value');
            $(window).resize(respondCanvas);
            respondCanvas();

            $("#daily-progress").click("daily", change_period_values);
            $("#weekly-progress").click("weekly", change_period_values);
            $("#monthly-progress").click("monthly",change_period_values);


        }
    });
}

function change_period_values(type){
    if(period_progress_data != undefined){
        var data;
        if(type.data == "daily"){
            study_time = $("#study-achievements").data("study-time");
            data = period_progress_data['daily'];
            $("#progress-by-title").text('Horas Assistidas nos últimos 8 dias');
            $(".progress-title").css('font-weight','normal');
            $("#daily-progress").css('font-weight','bold');

        }else if(type.data == "weekly"){
            study_time = $("#study-achievements").data("study-time") * 7;
            data = period_progress_data['weekly'];
            $("#progress-by-title").text('Horas Assistidas nas últimas 8 semanas');
            $(".progress-title").css('font-weight','normal');
            $("#weekly-progress").css('font-weight','bold');

        }else{
            study_time = $("#study-achievements").data("study-time") * daysInMonth(new Date().getMonth(), new Date().getFullYear());
            data = period_progress_data['monthly'];
            $("#progress-by-title").text('Horas Assistidas nos últimos 8 meses');
            $(".progress-title").css('font-weight','normal');
            $("#monthly-progress").css('font-weight','bold');
        }

        var data_keys = [];
        var data_values = [];
        var data_empty = [];

        $.each(data,function(key,value){
            data_keys.push(key);
            data_values.push(value / 3600);
            data_empty.push(study_time);
        });



        period_values = {
            labels: data_keys,
            datasets: [
                {
                    label: 'Horas Assistidas',
                    fillColor: "rgba(151,187,205,0.5)",
                    strokeColor: "rgba(151,187,205,0.8)",
                    highlightFill: "rgba(151,187,205,0.75)",
                    highlightStroke: "rgba(151,187,205,1)",
                    data: data_values
                },
                {
                    label: 'Horas Assistidas',
                    fillColor: "rgba(200,200,225,0.0)",
                    strokeColor: "#00CCCC",
                    highlightFill: "rgba(151,187,205,0.75)",
                    highlightStroke: "rgba(151,187,205,1)",
                    pointColor: "rgba(0,0,0,0)",
                    pointStrokeColor: "rgba(0,0,0,0)",
                    pointHighlightFill: "rgba(0,0,0,0)",
                    pointHighlightStroke: "rgba(0,0,0,0)",
                    data: data_empty
                },
                {
                    label: 'Horas Assistidas',
                    fillColor: "rgba(200,200,225,0.0)",
                    strokeColor:  "rgba(151,187,205,0.0)",
                    highlightFill: "rgba(151,187,205,0.0)",
                    highlightStroke: "rgba(151,187,205,0)",
                    pointColor: "rgba(0,0,0,0)",
                    pointStrokeColor: "rgba(0,0,0,0)",
                    pointHighlightFill: "rgba(0,0,0,0)",
                    pointHighlightStroke: "rgba(0,0,0,0)",
                    data: [study_time + 1]
                }]
        };

        respondCanvas();

    }
}

function daysInMonth(month,year) {
    return new Date(year, month, 0).getDate();
}

function respondCanvas() {

    Chart.types.Line.extend({
        name: "ProgressLine",
        draw: function () {
            Chart.types.Line.prototype.draw.apply(this, arguments);

            var points = this.datasets[0].points;

            $.each(points ,function() {
                this.fillColor = "#FFFFFF";
                this.highlightFill = "#FFFFFF";
                if(this.value < study_time){

                    this.strokeColor = "#FF5531";
                    this.highlightStroke = "#FF5531";

                }else{
                    this.strokeColor = "#55FF31";
                    this.highlightStroke = "#55FF31";

                }
            });


        }
    });


    $("#study-plan-continuous").attr('width',  $("#canvas-container").offsetParent().width());
    $("#study-plan-continuous").attr('height', $("#canvas-wrapper").height());
    $("#canvas-wrapper").css('width',  $("#canvas-container").offsetParent().width());

    $("#study-plan-continuous").css('width',  $("#canvas-container").offsetParent().width());
    $("#study-plan-continuous").css('height', $("#canvas-wrapper").height());


    var progress_column_height = $("#progress-column").css('height');
    if(progress_column_height != undefined){
    var card_column_height = $("#card-column").css('height');
    var column_difference =  Number(progress_column_height.substr(0,progress_column_height.length - 2))  - Number(card_column_height.substr(0,card_column_height.length - 2));

    var study_plan_height = $("#study-plan-continuous").css('height');
    study_plan_height = Number(study_plan_height.substr(0,study_plan_height.length - 2));


    $("#study-plan-continuous").css('height',(study_plan_height - column_difference) + "px");
    $("#study-plan-continuous").attr('height',(study_plan_height - column_difference) + "px");
    }else{
        var study_plan_height = $("#study-plan-continuous").css('height');
        study_plan_height = Number(study_plan_height.substr(0,study_plan_height.length - 2));
        $("#study-plan-continuous").css('height',(300) + "px");
        $("#study-plan-continuous").attr('height',(300) + "px");
    }


    var ctx = $("#study-plan-continuous")[0].getContext('2d');

    var time_line_chart = new Chart(ctx).ProgressLine(period_values,{
        bezierCurve: false,
        responsive: true,
        mantainAspectRatio: false,
        animation: false,
        showTooltips: false
    });


    $.each(time_line_chart.datasets[0].points,function(){
        this.fillColor = "#FFFFFF";
        this.highlightFill = "#FFFFFF";
        if(this.value < study_time){

            this.strokeColor = "#FF5531";
            this.highlightStroke = "#FF5531";

        }else{
            this.strokeColor = "#55FF31";
            this.highlightStroke = "#55FF31";

        }

        time_line_chart.update();
    });



}

function swap_result(){
    $(".current-attempt").click(function(){

        console.log("change.");
        $("#attempt-canvas").data('attempt',$(this).data('attempt-grade'));
        $("#attempt-canvas").data('total-questions',$(this).data("total-questions"));
        if($(this).data('attempt-date') != null && $(this).data('attempt-date') != ""){
        $("#result-date").html($(this).data('attempt-date'));
        }else{
            $("#result-date").html("Resultado Parcial");
        }
        $("#attempt-right").html("&nbsp;&nbsp;" + $(this).data('attempt-grade') + " ACERTOS");
        $("#attempt-wrong").html("&nbsp;&nbsp;" + ($("#attempt-canvas").data("total-questions") - $(this).data('attempt-grade')) + " ERROS");
        create_dashboard_result_chart();

    });

}




function create_dashboard_expected_chart(){


    Chart.types.Doughnut.extend({
        name: "DoughnutAlt",
        draw: function () {
            Chart.types.Doughnut.prototype.draw.apply(this, arguments);

            var canvasWidthvar = this.chart.width;
            var canvasHeight =  this.chart.height;
            var constant = 114;



            this.chart.ctx.textBaseline="middle";
            this.chart.ctx.textAlign = "left";


            var total = 0;
            var values = this.segments;
            //      console.log('resto - ' + values[1].value + 'total ' + values[0].value);
            $.each(values,function() {
                total += this.value;
            });
            //console.log('total: ' + total);
            var percentage = ((values[0].value/total )*100).toFixed(0);
            var tpercentage = percentage +"%";



            var textWidth =  this.chart.ctx.measureText(tpercentage).width;


            var txtPosx = Math.round((canvasWidthvar - textWidth)/2);


            var fontsize = (canvasHeight/constant + 1.0).toFixed(2);

            this.chart.ctx.font=fontsize +"em Titillium Web,Arial,sans-serif";

            this.chart.ctx.fillText(tpercentage, txtPosx, canvasHeight/2);
        }
    });




    var values = [
        {
            value:  Number($("#target-canvas").data("target")),
            color:"#61A9DC",
            highlight: "#45A46A",
            label: "Acertos"
        },
        {
            value: 100 - Number($("#target-canvas").data("target")),
            color:"#CCCCCC",
            highlight: "#FF5A5E",
            label: "Erros"
        }


    ];

    var ctx = $("#target-canvas")[0].getContext('2d');
    ctx.canvas.width = '100';
    ctx.canvas.height = '100';

    var doughnut_chart = new Chart(ctx).DoughnutAlt(values,{
        animation:true,
        responsive: false,
        showTooltips: false,
        percentageInnerCutout : 70,
        segmentShowStroke : false,
        scaleOverride : true,
        maintainAspectRatio: false
    });


}

function create_dashboard_result_chart(){

    Chart.types.Doughnut.extend({
        name: "DoughnutAlt",
        draw: function () {
            Chart.types.Doughnut.prototype.draw.apply(this, arguments);

            var canvasWidthvar = this.chart.width;
            var canvasHeight =  this.chart.height;
            var constant = 114;



            this.chart.ctx.textBaseline="middle";
            this.chart.ctx.textAlign = "left";


            var total = 0;
            var values = this.segments;
            //      console.log('resto - ' + values[1].value + 'total ' + values[0].value);
            $.each(values,function() {
                total += this.value;
            });
            //console.log('total: ' + total);
            var percentage = ((values[0].value/total )*100).toFixed(0);
            var tpercentage = percentage +"%";



            var textWidth =  this.chart.ctx.measureText(tpercentage).width;


            var txtPosx = Math.round((canvasWidthvar - textWidth)/2);


            var fontsize = (canvasHeight/constant + 1.0).toFixed(2);

            this.chart.ctx.font=fontsize +"em Titillium Web,Arial,sans-serif";
            this.chart.ctx.fillStyle = "#CCCCCC";
            this.chart.ctx.fillText(tpercentage, txtPosx, canvasHeight/2);
        }
    });


    console.log(Number($('#attempt-canvas').data("total-questions")));




    console.log(Number($('#attempt-canvas').data("total-questions")) + Number($("#attempt-canvas").data("attempt")));

    console.log(Number($('#last-exam-results').data("questions-count")) - (Number($('#attempt-canvas').data("total-questions")) + Number($("#attempt-canvas").data("attempt"))));





    var values = [
        {
            value:  Number($("#attempt-canvas").data("attempt")),
            color:"#5FBEAA",
            highlight: "#45A46A",
            label: "Acertos"
        },
        {
            value: Number($('#attempt-canvas').data("total-questions")) - Number($("#attempt-canvas").data("attempt")),
            color:"#CCCCCC",
            highlight: "#FF5A5E",
            label: "Erros"
        },
        {
            value: Number($('#last-exam-results').data("questions-count")) - (Number($('#attempt-canvas').data("total-questions"))),
            color:"#FFF",
            highlight: "#FF5A5E",
            label: "Total"
        }


    ];

    var ctxCurrent = $('#attempt-canvas')[0].getContext('2d');
    ctxCurrent.canvas.width = '100';
    ctxCurrent.canvas.height = '100';

    var doughnut_chart = new Chart(ctxCurrent).DoughnutAlt(values,{
        animation:true,
        responsive: false,
        showTooltips: false,
        percentageInnerCutout : 70,
        segmentShowStroke : false,
        scaleOverride : true,
        maintainAspectRatio: false
    });



}






function create_dashboard_enemies_chart(){


    Chart.types.Doughnut.extend({
        name: "DoughnutAlt",
        draw: function () {
            Chart.types.Doughnut.prototype.draw.apply(this, arguments);

            var canvasWidthvar = this.chart.width;
            var canvasHeight =  this.chart.height;
            var constant = 114;



            this.chart.ctx.textBaseline="middle";
            this.chart.ctx.textAlign = "left";


            var total = 0;
            var values = this.segments;
            //      console.log('resto - ' + values[1].value + 'total ' + values[0].value);
            $.each(values,function() {
                total += this.value;
            });
            //console.log('total: ' + total);
            var percentage = ((values[0].value/total )*100).toFixed(0);
            var tpercentage = percentage +"%";



            var textWidth =  this.chart.ctx.measureText(tpercentage).width;


            var txtPosx = Math.round((canvasWidthvar - textWidth)/2);

            var fontsize = (canvasHeight/constant + 1.0).toFixed(2);

            this.chart.ctx.font=fontsize +"em Titillium Web,Arial,sans-serif";
            this.chart.ctx.fillText(tpercentage, txtPosx, canvasHeight/2);
        }
    });




    var values = [
        {
            value:  Number($("#enemy-canvas").data("enemy")),
            color:"#ff9e5e",
            highlight: "#45A46A",
            label: "Acertos"
        },
        {
            value: Number($('#last-exam-results').data("questions-count")) - Number($("#enemy-canvas").data("enemy")),
            color:"#CCCCCC",
            highlight: "#FF5A5E",
            label: "Erros"
        }


    ];

    var ctxEnemy = $('#enemy-canvas')[0].getContext('2d');
    ctxEnemy.canvas.width = '100';
    ctxEnemy.canvas.height = '100';

    var doughnut_chart = new Chart(ctxEnemy).DoughnutAlt(values,{
        animation:true,
        responsive: false,
        showTooltips: false,
        percentageInnerCutout : 70,
        segmentShowStroke : false,
        scaleOverride : true,
        maintainAspectRatio: false
    });


}


function create_mini_right_charts(selector){


    if(selector == undefined) selector = ".mini-right-chart";

        $(selector).not(":hidden").each(function(){

            if($(this).width() != 0 && $(this).height() != 0 && $(this).outerHeight() !== 0) {
                var values = [
                    {
                        value: Number($(this).parent().parent().data("percentual")),
                        color: "#5FBEAA",
                        highlight: "#45A46A",
                        label: "Acertos"
                    },
                    {
                        value: 100 - Number($(this).parent().parent().data("percentual")),
                        color: "#CCCCCC",
                        highlight: "#FF5A5E",
                        label: "Erros"
                    }


                ];

                var ctx = $(this)[0].getContext('2d');
                ctx.canvas.width = '30';
                ctx.canvas.height = '30';



                if($(this).width() != 0 && $(this).height()) {
                    var doughnut_chart = new Chart(ctx).Doughnut(values, {
                        animation: false,
                        responsive: false,
                        showTooltips: false,
                        percentageInnerCutout: 70,
                        segmentShowStroke: false,
                        scaleOverride: true,
                        maintainAspectRatio: false
                    });
                }

            }
        });

    }


function create_classroom_right_chart(selector){
    Chart.types.Doughnut.extend({
        name: "DoughnutAlt",
        draw: function () {
            Chart.types.Doughnut.prototype.draw.apply(this, arguments);

            var canvasWidthvar = this.chart.width;
            var canvasHeight =  this.chart.height;
            var constant = 114;



            this.chart.ctx.textBaseline="middle";
            this.chart.ctx.textAlign = "left";


            var total = 0;
            var values = this.segments;
            //      console.log('resto - ' + values[1].value + 'total ' + values[0].value);
            $.each(values,function() {
                total += this.value;
            });
            //console.log('total: ' + total);
            var percentage = ((values[0].value/total )*100).toFixed(0);
            var tpercentage = percentage +"%";



            var textWidth =  this.chart.ctx.measureText(tpercentage).width;


            var txtPosx = Math.round((canvasWidthvar - textWidth)/2);


            var fontsize = (canvasHeight/constant + 0.3).toFixed(2);

            this.chart.ctx.font=fontsize +"em Titillium Web,Arial,sans-serif";

            this.chart.ctx.fillText(tpercentage, txtPosx, canvasHeight/2);
        }
    });

    var percentage = (Number($(selector).data("rights")) * 100) / Number($(selector).data('total'));
    var expected = Number($(selector).data('expected'));
    var color = percentage >= expected ? "#61A9DC" : "red";

    console.log(percentage);


    var values = [
        {
            value:  Number($(selector).data("rights")),
            color: color,
            highlight: "#45A46A",
            label: "Acertos"
        },
        {
            value: Number($(selector).data('total')) - Number($(selector).data("rights")),
            color:"#CCCCCC",
            highlight: "#FF5A5E",
            label: "Erros"
        }


    ];

    var ctx = $(selector)[0].getContext('2d');
    ctx.canvas.width = '90';
    ctx.canvas.height = '90';

    var doughnut_chart = new Chart(ctx).DoughnutAlt(values,{
        animation:true,
        responsive: false,
        showTooltips: false,
        percentageInnerCutout : 70,
        segmentShowStroke : false,
        scaleOverride : true,
        maintainAspectRatio: false
    });

}

function create_mini_previous_charts(){
    $(".mini-previous-chart").not(":hidden").each(function(){
        if($(this).width() != 0) {
            var values = [
                {
                    value: Number($(this).parent().parent().data("previous")),
                    color: "#ff9e5e",
                    highlight: "#45A46A",
                    label: "Acertos"
                },
                {
                    value: 100 - Number($(this).parent().parent().data("previous")),
                    color: "#CCCCCC",
                    highlight: "#FF5A5E",
                    label: "Erros"
                }


            ];


            var ctx = $(this)[0].getContext('2d');

            ctx.canvas.width = '30';
            ctx.canvas.height = '30';
            if($(this).width() != 0) {
                var doughnut_chart = new Chart(ctx).Doughnut(values, {
                    animation: false,
                    responsive: false,
                    showTooltips: false,
                    percentageInnerCutout: 70,
                    segmentShowStroke: false,
                    scaleOverride: true,
                    maintainAspectRatio: false
                });
            }
        }
    });

}


function create_mini_expected_charts(){
    $(".mini-expected-chart").not(":hidden").each(function(){
        if($(this).width() != 0 && $(this).height() != 0){
        var values = [
            {
                value:  Number($(this).parent().parent().data("expected")),
                color:"#61A9DC",
                highlight: "#45A46A",
                label: "Acertos"
            },
            {
                value: 100 -Number($(this).parent().parent().data("expected")),
                color:"#CCCCCC",
                highlight: "#FF5A5E",
                label: "Erros"
            }


        ];


        var ctx = $(this)[0].getContext('2d');


        ctx.canvas.width = '30';
        ctx.canvas.height = '30';


        var doughnut_chart = new Chart(ctx).Doughnut(values,{
            animation:false,
            responsive: false,
            showTooltips: false,
            percentageInnerCutout : 70,
            segmentShowStroke : false,
            scaleOverride : true,
            maintainAspectRatio: false
        });
        }
    });

}







