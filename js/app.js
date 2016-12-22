var timeframe = "1week";
var m_label = 'User Count for last 1 week';
var chartType = 'bar';
var botid = "SG1";
var bool_sentiment = "0"; //0 means false, 1 means true

data_1day = {};
data_1week = {};
data_1month = {};
data_6months = {};


$(document).ready(function(){
    var ajax_options = {
        url: "http://localhost/~shobhitgarg_mbp/rupertbot/data.php",
        method: "GET",
        data: { 
            tf: timeframe,   
            bs: bool_sentiment            
        },  
        success: function(data) {            
            plot(data);            
        },
        error: function(data) {
            console.log(data);
        }
    }
    ajax_options.data = { tf : timeframe }
    $.ajax(ajax_options);

    $("#dropdown_1day").click(function() {    
        timeframe = "1day";
        resetCanvas();
        ajax_options.data = { tf : timeframe, bs : bool_sentiment };
        $.ajax(ajax_options);
    });
    $("#dropdown_1week").click(function() {    
        timeframe = "1week";
        resetCanvas();
        ajax_options.data = { tf : timeframe, bs : bool_sentiment };
        $.ajax(ajax_options);
    });
    $("#dropdown_1month").click(function() {    
        timeframe = "1month";
        resetCanvas();
        ajax_options.data = { tf : timeframe, bs : bool_sentiment };
        $.ajax(ajax_options);
    });
    $("#dropdown_6months").click(function() {    
        timeframe = "6months";
        resetCanvas();
        ajax_options.data = { tf : timeframe, bs : bool_sentiment };
        $.ajax(ajax_options);        
    });
    $("#dashboard").click(function() {    
        chartType = 'bar';        
        resetCanvas();    
        $.ajax(ajax_options); 
    });
    $("#chart_pie").click(function() {  
        bool_sentiment = "0"; //reset
        chartType = 'pie';
        resetCanvas();    
        ajax_options.data = { tf : timeframe, bs : bool_sentiment };
        $.ajax(ajax_options);        
    });
    $("#chart_bar").click(function() {    
        bool_sentiment = "0"; //reset
        chartType = 'bar';
        resetCanvas();
        ajax_options.data = { tf : timeframe, bs : bool_sentiment };
        $.ajax(ajax_options);        
    });
    $("#chart_line").click(function() {    
        bool_sentiment = "0"; //reset
        chartType = 'line';
        resetCanvas();  
        ajax_options.data = { tf : timeframe, bs : bool_sentiment };    
        $.ajax(ajax_options);        
    }); 
    $("#chart_sentiment").click(function() {    
        chartType = 'line';
        bool_sentiment = "1";
        resetCanvas();      
        ajax_options.data = { tf : timeframe, bs : "1" };
        $.ajax(ajax_options); 
        //bool_sentiment = "0"; //reset       
    });
    $("#dropdown_botid_SG1").click(function() {    
        botid = 'SG1';
        resetCanvas();
        $.ajax(ajax_options);        
    }); 
    $("#dropdown_botid_SG2").click(function() {    
        botid = 'SG2';
        resetCanvas();
        $.ajax(ajax_options);        
    }); 

});

var plot = function(data) {
    var data_botid = [];
    var data_count = [];
    var data_date = [];  
    var data_sb = [];
    
    for(var i in data) {                
        data_botid.push(data[i].botid);        
        data_count.push(data[i].count);
        data_date.push(data[i].year + "-" + data[i].month + "-" + data[i].day);
        if(bool_sentiment == "1") {
            data_sb.push(data[i].sb);        
        }
    }

    var data_chart_x_axis = [];
    var data_chart_y_axis = [];
    
    console.log("bool sentiment is: " + bool_sentiment)
    for(i = 0; i < data_date.length; i++) {
        //Chart only data relevant to the bot we've selected from dropdown
        if(data_botid[i] == botid) {       
            if(bool_sentiment == "0") {
                data_chart_y_axis.push(data_count[i]);
                data_chart_x_axis.push(data_date[i]);
            }                        
            else {
                if(data_sb[i] == "1") {
                    //TODO: don't divide by 1000. find out exactly how many users were
                    //active in that timeframe, then divide by that number
                    //Damn you, hacker mentality!
                    data_chart_y_axis.push(data_count[i]/1000); //average across all users                    
                    data_chart_x_axis.push(data_date[i]);
                }                
            }                        
        }
    }
    
    var chartdata = {
        labels: data_chart_x_axis,
        datasets : [
            {
                label: generateLabel(),
                data: data_chart_y_axis
            }
        ]
    };

    var ctx = $("#mycanvas");

    var barGraph = new Chart(ctx, {
        type: chartType,
        data: chartdata,                
        options: {
            responsive: true,
            maintainAspectRatio: true
        }        
    });
}

var resetCanvas = function(){
    $('#mycanvas').remove(); // this is my <canvas> element
    $('#chart-container').append('<canvas id="mycanvas"><canvas>');
    canvas = document.querySelector('#mycanvas');    
};
   
var generateLabel = function() {
    if(bool_sentiment == "0") {
        res = 'User count for the last ';
    }
    else {
        res = 'Sentiment graph for the last ';
    }    
    if(timeframe == "1day") {
        res = res + '1 day';
    }
    else if(timeframe == "1week") {
        res = res + '1 week';
    }
    else if(timeframe == "1month") {
        res = res + '1 month';
    }
    else if(timeframe == "6months") {
        res = res + '6 months';
    }
    return res;       
}
