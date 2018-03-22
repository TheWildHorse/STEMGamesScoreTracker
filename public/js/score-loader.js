// Templates
Handlebars.registerHelper("inc", function(value, options)
{
    return parseInt(value) + 1;
});
Handlebars.registerHelper('ifEquals', function(arg1, arg2, options) {
    return (arg1 == arg2) ? options.fn(this) : options.inverse(this);
});
Handlebars.registerHelper('getScore', function(collegeId, scores, options) {
    var wantedScore = '-';
    scores.forEach(function(score) {
        if(score.college.id === collegeId) {
            wantedScore = score.score;
        }
    });
    return wantedScore;
});
var placementsTemplate = Handlebars.compile($('#placements-template').html())
var versusTemplate = Handlebars.compile($('#versus-template').html())


// State
var filter = null;
var lastDataFetchResult = null;

function loadData() {
    $.getJSON('/api/results', function(data) {
        lastDataFetchResult = data.data;
        displayData(lastDataFetchResult);
    });
}

function displayData(data) {
    var payload = "";
    data.forEach(function(sport) {
        if(filter !== null && sport.name !== filter) {
            return;
        }
        if(sport.groups.length === 0) {
            return;
        }
        if(sport.event_type === 2) {
            payload += placementsTemplate(sport)
        }
        else {
            payload += versusTemplate(sport)
        }
    });
    $('#scores-container').html(payload);
}

$(document).ready(function() {
    loadData();
    setInterval(loadData, 30*1000);

    $('#filter-container a').click(function(e) {
        filter = $(this).data('sport');
        if(filter === "all") {
            filter = null;
        }
        if(lastDataFetchResult === null) {
            loadData();
            return;
        }
        displayData(lastDataFetchResult);
    });
});