$(function() {
    $( "#datepicker_from" ).datepicker({ dateFormat: "yy-mm-dd", defaultDate: 0 }).datepicker("setDate", 'today');
    $( "#datepicker_to" ).datepicker({ dateFormat: "yy-mm-dd", defaultDate: 0 }).datepicker("setDate", 'today');
});


function total_results(data, filter) {
    var result = {all_hours: 0, bill_hours: 0, unbill_hours: 0, percent: 0, cost: 0};

    if (data !== undefined && data.events !== undefined) {
        var events = JSON.parse(JSON.stringify(data.events)),
            sum_all_hours  = 0,
            sum_bill_hours = 0,
            prs_all_hours  = [],
            prs_bill_hours = [];

        if (filter !== undefined) {
            for (var i = events.length - 1; i >= 0; i--) {
                if (events[i]['name_project'] !== filter.name_project && filter.name_project !== null) {
                    events.splice(i, 1);
                }
            }
        }

        for (i = events.length - 1; i >= 0; i--) {
            prs_all_hours  = events[i]['duration'].split(':');
            prs_bill_hours = events[i]['bill_duration'].split(':');
            sum_all_hours += prs_all_hours[0] * 60 + prs_all_hours[1] * 1;
            sum_bill_hours+= prs_bill_hours[0] * 60 + prs_bill_hours[1] * 1;

            result.cost += events[i]['cost'];
        }

        result.all_hours    = Math.floor(sum_all_hours / 60);
        result.bill_hours   = Math.floor(sum_bill_hours / 60);
        result.unbill_hours = result.all_hours - result.bill_hours;
        result.percent      = Math.round(result.bill_hours * 100 / result.all_hours);
    }

    var $circle = $('#svg #bar');

    if (isNaN(result.percent)) {
        result.percent = 0;
    } else {
        var r = $circle.attr('r');
        var c = Math.PI * (r * 2);

        if (result.percent < 0) { result.percent = 0; }
        if (result.percent > 100) { result.percent = 100; }

        var pct = ((100 - result.percent) / 100) * c;

        $circle.css({ strokeDashoffset: pct});
        $('#cont').attr('data-pct', result.percent);
    }

    return result;
}

var reportsApp = angular.module('reportsApp', []);

reportsApp.controller('reportsController', function($scope, $http) {
    var today = new Date();

    $scope.period     = 'Day';
    $scope.predicate  = '-index';
    $scope.count      = 0;
    $scope.start_date = today.getFullYear() + "-" + (today.getMonth()+1) + "-" + today.getDate();
    $scope.end_date   = today.getFullYear() + "-" + (today.getMonth()+1) + "-" + today.getDate();

    $scope.selectEvents = function() {
        $http({
            method: 'POST',
            url: '/reports/selectevents',
            data: $.param({
                period: $scope.period,
                count:  $scope.count,
                from:   $scope.start_date,
                to:     $scope.end_date
            }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .success(function(data){
            $scope.data = data;
            $scope.total = total_results($scope.data);
        })
        .error(function(data, status) {
            $scope.data = data || "Request failed";
            $scope.status = status;
        });
    };

    $scope.sendReport = function() {
        $('#exportable table td, #exportable table th').css('border', '1px solid grey');
        $http({
            method: 'POST',
            url: '/reports/sendreport',
            data: $.param({
                events: document.getElementById('exportable').innerHTML,
                from:   $scope.start_date,
                to:     $scope.end_date,
                email:  $scope.email,
                reply:  $('#themes').text()
            }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
            .success(function(data){
                $scope.send_report = data;
            })
            .error(function(data, status) {
                $scope.send_report = data || "Something wrong, try again!";
                $scope.status = status;
        });
        $('#exportable table td, #exportable table th').css('border', '');
    };

    $scope.clearSendReport = function() {
        $scope.email = '';
        $scope.send_report = 0;
    }

    $scope.$watchCollection('filter', function() {
        /*if($scope.proj){ $scope.data = [$scope.proj]; }*/
        $scope.total = total_results($scope.data, $scope.filter);
    });

    $scope.$watch('period', function() {
        $scope.count = 0;
        $scope.selectEvents();
    });

    $scope.prevPeriod = function() {
        $scope.count++;
        $scope.selectEvents();
    };

    $scope.nextPeriod = function() {
        $scope.count--;
        $scope.selectEvents();
    };

    $scope.exportData = function () {
        var blob = new Blob([document.getElementById('exportable').innerHTML], {
            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
        });
        saveAs(blob, "Report_" + $scope.data.period.from + '-' + $scope.data.period.to + ".xls");
    };
});