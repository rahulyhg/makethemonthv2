function ajaxCall(url,data,callback){
    loading_bg();
    $.ajax({
        url:site_url+'ajax/'+url,
        type:'POST',
        data:data,
        success:callback,
        fail:function(error){
            return error;
        }
    })
}
function createArrayForPie(array){
    final = [];
    $.each(array,function(index,value){
        ob = {
            "methods": index,
            "values": value
        };
        final.push(ob);
    });
    final.sort(function(a, b){
        var keyA = a.methods,
            keyB = b.methods;
        if(keyA < keyB) return -1;
        if(keyA > keyB) return 1;
        return 0;
    });
    return final;
}
function createPie(selector,array,colors){
    done_loading();
    AmCharts.makeChart( selector, {
        "type": "pie",
        "theme": "light",
        "dataProvider": array,
        "colors":colors,
        "valueField": "values",
        "titleField": "methods",
        "balloon":{
            "fixedPosition":true
        },
        "export": {
            "enabled": false
        }
    });
}
function createLineChart(selector, data){
    done_loading();
    var chartLine = AmCharts.makeChart(selector, {
        "type": "serial",
        "theme": "light",
        "marginRight": 70,
        "autoMarginOffset": 20,
        "marginTop": 0,
        "dataProvider": data,
        "valueAxes": [{
            "axisAlpha": 0.2,
            "dashLength": 1,
            "position": "left"
        }],
        "mouseWheelZoomEnabled": true,
        "graphs": [{
            "id": "g1",
            "balloonText": "[[category]]<br/><b><span style='font-size:14px;'>Time Played: [[value]]</span></b>",
            "bullet": "round",
            "bulletBorderAlpha": 1,
            "bulletColor": "#FFFFFF",
            "hideBulletsCount": 50,
            "title": "red line",
            "valueField": "visits",
            "useLineColorForBulletBorder": true
        }],
        "chartScrollbar": {
            "autoGridCount": true,
            "graph": "g1",
            "scrollbarHeight": 30,
            "color":"#444"
        },
        "chartCursor": {

        },
        "categoryField": "date",
        "categoryAxis": {
            "parseDates": true,
            "axisColor": "#DADADA",
            "dashLength": 1,
            "minorGridEnabled": true
        },
        "export": {
            "enabled": true
        }
    });

    chartLine.addListener("rendered", zoomChart);
    //zoomChart();

    function zoomChart() {
        data.zoomToIndexes(data.length - 40, data.length - 1);
    }
}
function callbackhomesuperadmin(response){
    if(response){
        var data = JSON.parse(response);
        var stats = {},
            cities = {};
        $.each(data,function(index,value){
            cities[value.city] = cities[value.city]?(cities[value.city]+1):1;
            end = parseInt(value.end);
            key = end>0?'Win':(end<0?'Lose':'Give Up');
            stats[key] = stats[key]?(stats[key]+1):1;
        });
        $('#total-play').html(data.length);
        createPie('dashboard-home-lose-win',createArrayForPie(stats),['Yellow','Red','Green']);
        createPie('dashboard-home-cities',createArrayForPie(cities),[]);
    }
}
function callbackhome(response){
    if(response){
        var data = JSON.parse(response);
        var stats = {};
        $.each(data,function(index,value){
            end = parseInt(value.end);
            key = end>0?'Win':(end<0?'Lose':'Give Up');
            stats[key] = stats[key]?(stats[key]+1):1;
        });
        $('#total-play').html(data.length);
        createPie('dashboard-home',createArrayForPie(stats),['Yellow','Red','Green']);
    }
}
function callbackplaytimeLine(response){
    if(response !="false" && response !='[]'){
        var data = JSON.parse(response);
        var stats = [];
        $.each(data,function(index,value){
            var newDate = new Date(parseInt(value.year),parseInt(value.month-1),parseInt(value.day));
            stats.push({
                date: newDate,
                visits: value.total
            });
        });
        createLineChart('dashboard-home-lose-win',stats);
    }else{
        done_loading();
        $('#dashboard-home-lose-win').html('No data for this filter, please try another one!');
    }
}
var filter = {};
$(document).on('change','#stats-city',function(){
    filter.city = this.value;
    refreshData(filter);
});
$(document).on('change','#stats-scenario',function(){
    filter.scenario = this.value;
    refreshData(filter);
});
$(document).on('change','#stats-status',function(){
    filter.status = this.value;
    refreshData(filter);
});
$(document).on('click','#stats-reset',function(){
    filter = {};
    $('#stats-scenario').val("");
    $('#stats-city').val("");
    $('#stats-status').val("");
    refreshData(filter);
});
function refreshData(filter){
    if(template == 'home'){
        if(access == 'superadmin'){
            ajaxCall('get_general_stats',filter,callbackhomesuperadmin);
        }else{
            ajaxCall('get_general_stats',filter,callbackhome);
        }
    }
    if(template == "stats"){
        ajaxCall('get_play_per',filter,callbackplaytimeLine);
    }
}
refreshData(filter);