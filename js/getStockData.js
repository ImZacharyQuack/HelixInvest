
const appleURL = 'https://alpha-vantage.p.rapidapi.com/query?interval=60min&function=TIME_SERIES_INTRADAY&symbol=AAPL&datatype=json&output_size=compact';
const teslaURL = 'https://alpha-vantage.p.rapidapi.com/query?interval=60min&function=TIME_SERIES_INTRADAY&symbol=TSLA&datatype=json&output_size=compact';
const metaURL = 'https://alpha-vantage.p.rapidapi.com/query?interval=60min&function=TIME_SERIES_INTRADAY&symbol=META&datatype=json&output_size=compact';
const amazonURL = 'https://alpha-vantage.p.rapidapi.com/query?interval=60min&function=TIME_SERIES_INTRADAY&symbol=AMZN&datatype=json&output_size=compact';
const nvidiaURL = 'https://alpha-vantage.p.rapidapi.com/query?interval=60min&function=TIME_SERIES_INTRADAY&symbol=NVDA&datatype=json&output_size=compact';

const options = {
	method: 'GET',
	headers: {
		'X-RapidAPI-Key': 'b0ff5379a1mshe406b896d7db93cp18fd47jsn72a3e4394f99',
		'X-RapidAPI-Host': 'alpha-vantage.p.rapidapi.com'
	}
};

async function getData(url, options) {
    const response = await fetch(url, options);
  
    return response.json();
}

var data = [];
var chartY = [];
var chartX = [];

var counter = 0;

const pushData = async function(url, options, stockName, stockTicker) {

    const response = await getData(url, options);

    var json = response['Time Series (60min)']
    var reverseJson = Object.keys(json).sort().reverse();

    var time = reverseJson[0].substring(10, reverseJson[0].length-6);
    if (time > 16) {
        time = 16;
    }
    time = 19-time;

    const todayPrice = json[reverseJson[time]]['1. open'];
    const yesterdayPrice = json[reverseJson[time+17]]['4. close'];
    const difference = percentageDifference(todayPrice, yesterdayPrice);

    data.push(
        {
            name: stockName,
            ticker: stockTicker,
            today: todayPrice,
            differencePercent: difference,
            day18: todayPrice,
            day17: json[reverseJson[time+1]]['4. close'],
            day16: json[reverseJson[time+2]]['4. close'],
            day15: json[reverseJson[time+3]]['4. close'],
            day14: json[reverseJson[time+4]]['4. close'],
            day13: json[reverseJson[time+5]]['4. close'],
            day12: json[reverseJson[time+6]]['4. close'],
            day11: json[reverseJson[time+7]]['4. close'],
            day10: json[reverseJson[time+8]]['4. close'],
            day9: json[reverseJson[time+9]]['4. close'],
            day8: json[reverseJson[time+10]]['4. close'],
            day7: json[reverseJson[time+11]]['4. close'],
            day6: json[reverseJson[time+12]]['4. close'],
            day5: json[reverseJson[time+13]]['4. close'],
            day4: json[reverseJson[time+14]]['4. close'],
            day3: json[reverseJson[time+15]]['4. close'],
            day2: json[reverseJson[time+16]]['4. close'],
            day1: yesterdayPrice,
            
        }
    );
    counter++;

    function ascending(a,b) {
        return a.differencePercent < b.differencePercent ? 1 : -1
    } 

    data.sort(ascending);

    if (counter == 5) {
        getGraphData();
        addData();
    }
}

function addData() {

    var $list = $(".table-body");
    $list.find(".table-row").remove();

    for (var i=0; i < data.length; i++) {

        var percent = parseFloat(data[i].differencePercent);
        var active = "";
        var percentString = "";
        
        if (percent < 0) {
            active = "red";
            percentString = parseFloat(percent).toFixed(2);
        } else {
            active = "green";
            percentString = "+" + parseFloat(percent).toFixed(2);
        }
        var $item = $(
            "<tr class='table-row' stock-table-1>" +
                "<td class='table-data'>" +
                "</td>" +
                "<th class='table-data rank' scope='row'>" + (i+1) + "</th>" +
                "<td class='table-data'>" +
                "    <div class='wrapper'>" +
                "    <h3>" +
                "        <a href='#' class='stock-name' stock-name>" + data[i].name + " <span class='span'>" + data[i].ticker + "</span></a>" +
                "    </h3>" +
                "    </div>" +
                "</td>" +
                "<td class='table-data last-price' stock-price> $" + parseFloat(data[i].today).toFixed(2) + "</td>" +
                "<td class='table-data last-update " + active + "' stock-percent-change>" + percentString + "% </td>" +
                "<td class='table-data'> <canvas id='myChart-" + (i+1) + "' style='width:100%;max-width:100px;'></canvas> </td>" +
            "</tr>"
        );
        data[i].$item = $item;
        $list.append($item);
    }

    addGraphs();

}

const percentageDifference = function(today, yesterday) {
    const difference = today - yesterday;
    return difference / yesterday * 100;
}

function getGraphData() {

    var yPrice  = [];
    const xTime = [4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20];

    for (var i=0; i < data.length; i++) {
        yPrice.push(data[i].day18);
        yPrice.push(data[i].day17);
        yPrice.push(data[i].day16);
        yPrice.push(data[i].day15);
        yPrice.push(data[i].day14);
        yPrice.push(data[i].day13);
        yPrice.push(data[i].day12);
        yPrice.push(data[i].day11);
        yPrice.push(data[i].day10);
        yPrice.push(data[i].day9);
        yPrice.push(data[i].day8);
        yPrice.push(data[i].day7);
        yPrice.push(data[i].day6);
        yPrice.push(data[i].day5);
        yPrice.push(data[i].day4);
        yPrice.push(data[i].day3);
        yPrice.push(data[i].day2);
        yPrice.push(data[i].day1);

        yPrice = yPrice.reverse();

        chartY.push(yPrice);
        chartX.push(xTime);
        yPrice  = []
    }

}

function createGraph(name, i) {

    var yValues = chartY[i]; 
    var xValues = chartX[i];
    var percent = chartY[i][chartY[i].length-1] - chartY[i][0];
    
    var backgroundRGBA = getGraphColour(percent, 0.1);
    var borderRGBA = getGraphColour(percent, 1.0);

    return new Chart(name, { 
        type: 'line',
        data: {
        labels: xValues,
        datasets: [{
            backgroundColor: backgroundRGBA,
            borderColor: borderRGBA,
            data: yValues 
        }] 
        },
        options: { 
            legend: { display: false },
            scales: {
                yAxes: [{
                    display: false, 
                    ticks: { max: Math.max.apply(null, yValues) + 5 }
                }],
                xAxes: [{display: false}] 
            },
            elements: {
                point:{
                    radius: 0 
                } 
            }
        }
    });  
}

function addGraphs() {

    for (var i=0; i < 5; i++) {
        createGraph("myChart-" + (i+1), i)
    }

}

function getGraphColour(percent, opacity) {
    var colour = "rgba(144, 238, 144, " + opacity + ")"; 
    if (percent < 0) {
        colour = "rgba(255, 14, 118, " + opacity + ")"; 
    }
    return colour;
}

pushData(appleURL, options, "Apple", "AAPL");
pushData(teslaURL, options, "Tesla", "TSLA");
pushData(metaURL, options, "Meta", "META");
pushData(amazonURL, options, "Amazon", "AMZN");
pushData(nvidiaURL, options, "Nvidia", "NVDA");