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
    var data = clone(dataOriginal);
    for(var sportIndex in data) {
        // FILTERS
        if(filter !== null && data[sportIndex].name !== filter) {
            continue;
        }
        if(data[sportIndex].groups.length === 0) {
            continue;
        }
        if(dayFilter !== null) {
            for(var groupIndex in data[sportIndex].groups) {
                data[sportIndex].groups[groupIndex].events = data[sportIndex].groups[groupIndex].events.filter(function (event) {
                    return moment(event.start_time, moment.HTML5_FMT.DATETIME_LOCAL_SECONDS).format('dddd') === dayFilter;
                });
            }
        }
        if(collegeFilter !== null) {
            for(var groupIndex in data[sportIndex].groups) {
                data[sportIndex].groups[groupIndex].events = data[sportIndex].groups[groupIndex].events.filter(function (event) {
                    if(event.competitor1 === undefined && event.competitor2 === undefined) {
                        return false;
                    }
                    return event.competitor1.id == collegeFilter || event.competitor2.id == collegeFilter;
                });
            }
        }
        // REMOVE EMPTY
        data[sportIndex].groups = data[sportIndex].groups.filter(function (group) {
            return group.events.length !== 0;
        });

        // TEMPLATE GENERATION
        if(data[sportIndex].groups.length === 0) {
            continue;
        }
        if(data[sportIndex].event_type === 2) {
            payload += placementsTemplate(data[sportIndex])
        }
        else {
            payload += versusTemplate(data[sportIndex])
        }
    }
    $('#scores-container').html(payload);
}

$(document).ready(function() {
    loadData();
    setInterval(loadData, 30*1000);

    $('#filter-container a').click(function(e) {
        filter = $(this).data('sport');
        $('#filter-container a').removeClass('active');
        $(this).addClass('active');
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
        $('#college-filter-container a').removeClass('active');
        $(this).addClass('active');
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
        $('#day-filter-container a').removeClass('active');
        $(this).addClass('active');
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