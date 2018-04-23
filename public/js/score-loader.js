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
Handlebars.registerHelper('dateFormat', function(context, block) {
    if (window.moment) {
        var f = block.hash.format || "MMM Do, YYYY";
        return moment(context, moment.HTML5_FMT.DATETIME_LOCAL_SECONDS).format(f);
    } else {
        return context;   //  moment plugin not available. return data as is.
    }
});
var placementsTemplate = Handlebars.compile($('#placements-template').html())
var versusTemplate = Handlebars.compile($('#versus-template').html())

function clone(obj) {
    if (obj === null || typeof(obj) !== 'object' || 'isActiveClone' in obj)
        return obj;

    if (obj instanceof Date)
        var temp = new obj.constructor(); //or new Date(obj);
    else
        var temp = obj.constructor();

    for (var key in obj) {
        if (Object.prototype.hasOwnProperty.call(obj, key)) {
            obj['isActiveClone'] = null;
            temp[key] = clone(obj[key]);
            delete obj['isActiveClone'];
        }
    }

    return temp;
}

// State
var filter = null;
var dayFilter = null;
var collegeFilter = null;
var lastDataFetchResult = null;

function loadData() {
    $.getJSON('/api/results', function(data) {
        lastDataFetchResult = data.data;
        displayData(lastDataFetchResult);
    });
}

function displayData(dataOriginal) {
    var payload = "";
    data = clone(dataOriginal);
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
            if(collegeFilter !== null) {
                sport.groups.forEach(function (group, index, object) {
                    group.events = group.events.filter(function (event) {
                        return event.competitor1.id == collegeFilter || event.competitor2.id == collegeFilter;
                    });
                    if(group.events.length === 0) {
                        object.splice(index, 1);
                    }
                });
            }
            if(dayFilter !== null) {
                sport.groups.forEach(function (group, index, object) {
                    group.events = group.events.filter(function (event) {
                        return moment(event.start_time, moment.HTML5_FMT.DATETIME_LOCAL_SECONDS).format('dddd') === dayFilter;
                    });
                    if(group.events.length === 0) {
                        object.splice(index, 1);
                    }
                });
            }
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
    $('#college-filter-container a').click(function(e) {
        collegeFilter = $(this).data('college');
        if(collegeFilter === "all") {
            collegeFilter = null;
        }
        if(lastDataFetchResult === null) {
            loadData();
            return;
        }
        displayData(lastDataFetchResult);
    });
    $('#day-filter-container a').click(function(e) {
        dayFilter = $(this).data('day');
        if(dayFilter === "all") {
            dayFilter = null;
        }
        if(lastDataFetchResult === null) {
            loadData();
            return;
        }
        displayData(lastDataFetchResult);
    });
});