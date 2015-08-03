var timerApp = angular.module('timerApp', ['timer'], function($httpProvider){
    // Use x-www-form-urlencoded Content-Type
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
    
    /**
     * The workhorse; converts an object to x-www-form-urlencoded serialization.
     * @param {Object} obj
     * @return {String}
     */ 
    var param = function(obj) {
      var query = '', name, value, fullSubName, subName, subValue, innerObj, i;
        
      for(name in obj) {
        value = obj[name];
          
        if(value instanceof Array) {
          for(i=0; i<value.length; ++i) {
            subValue = value[i];
            fullSubName = name + '[' + i + ']';
            innerObj = {};
            innerObj[fullSubName] = subValue;
            query += param(innerObj) + '&';
          }
        }
        else if(value instanceof Object) {
          for(subName in value) {
            subValue = value[subName];
            fullSubName = name + '[' + subName + ']';
            innerObj = {};
            innerObj[fullSubName] = subValue;
            query += param(innerObj) + '&';
          }
        }
        else if(value !== undefined && value !== null)
          query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
      }
        
      return query.length ? query.substr(0, query.length - 1) : query;
    };
    
    // Override $http service's default transformRequest
    $httpProvider.defaults.transformRequest = [function(data) {
        return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
    }];
});

timerApp.controller('timerAppController', function($scope, $http) {
    $scope.timerRunning = false;
    $scope.currentPage  = 0;
    $scope.pageSize     = 10;

    $http.post(
        '/timer/selectevents'
    )
    .success(function(response){
        $scope.events   = response.events;
        $scope.projects = response.projects;

        if($scope.events.active){
            $scope.timerRunning = true;
            for(project in $scope.projects){
                if($scope.projects[project].name_project == $scope.events.active.project.name_project){
                    $scope.events.active.project = $scope.projects[project];
                }
            }
        } else {
            $scope.events.active = {};
            $scope.events.active.project = $scope.projects[0]; // No project
        }

        $scope.numberOfPages = function(){
            return Math.ceil($scope.events.inactive.length / $scope.pageSize);
        };
    });

    $scope.startTimer = function (){
        $scope.$broadcast('timer-start');
        $scope.timerRunning = true;
        $scope.events.active.start_time = new Date().getTime();

        $http.post(
            '/timer/newevent', {
                event   : $scope.events.active.name_event,
                project : $scope.events.active.project
            }
        )
        .success(function(response){
            console.log('started successfully - ' + response);
        });
    };

    $scope.stopTimer = function (){
        $scope.$broadcast('timer-stop');
        $scope.timerRunning = false;
    };

    $scope.$on('timer-stopped', function (event, data){
        var end_time = new Date(),
            duration = Math.round((end_time.getTime() - $scope.events.active.start_time) / 1000 - 1);

        $scope.events.inactive = [{
            'name_event'  : $scope.events.active.name_event,
            'name_project': $scope.events.active.project.name_project,
            'duration'    : duration,
            'start_time'  : $scope.events.active.start_time,
            'end_time'    : end_time
        }].concat($scope.events.inactive);

        $http.post(
            '/timer/stopevent', {
                event    : $scope.events.active.name_event,
                duration : duration,
                bill     : $scope.money
            }
        )
        .success(function(response){
            $scope.$broadcast('timer-clear');
            $scope.events.active = {};
            $scope.events.active.project = $scope.projects[0]; // No project
            
            console.log('stopped successfully - ' + response);
        });
    });

    $scope.deleteEvent = function (id_event, index){
        $scope.events.inactive.splice(index, 1);
        $http.post(
            '/timer/deleteevent', {
                id_event : id_event
            }
        )
        .success(function(response){
            console.log("Deleted Successfully - " + response);
        });
    }

    $scope.secondsToTime = function (secs){
        var hours = Math.floor(secs / (60 * 60)) + '';

        var divisor_for_minutes = secs % (60 * 60);
        var minutes = Math.floor(divisor_for_minutes / 60) + '';
     
        var divisor_for_seconds = divisor_for_minutes % 60;
        var seconds = Math.ceil(divisor_for_seconds) + '';

        if(hours.length   < 2) {hours   = '0' + hours;}
        if(minutes.length < 2) {minutes = '0' + minutes;}
        if(seconds.length < 2) {seconds = '0' + seconds;}

        return hours + ':' + minutes + ':' + seconds;
    }
});

timerApp.filter('startFrom', function() {
    return function(input, start) {
        start = +start; //parse to int
        if (input) return input.slice(start);
    }
});