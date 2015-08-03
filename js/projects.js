var projectApp = angular.module('projectApp', [], function($httpProvider){
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

projectApp.controller('projectAppController', function($scope, $http) {
    $scope.Math = window.Math;
    $scope.addedMember = false;

    $http.post(
        '/projects/selectprojects'
    )
    .success(function(response){
        $scope.projects = response;
    });
    
    $scope.newProject = function (){
        $http.post(
            '/projects/newprojects', {
                project : $scope.nameProject,
                cost    : $scope.costProject
            }
        )
        .success(function(response){
            $http.post(
                '/projects/selectprojects'
            )
            .success(function(data){
                $scope.projects = data;
            });
            $scope.nameProject = '';
            $scope.costProject = '';
            console.log('created successfully - ' + response);
        });
    };

    $scope.deleteProject = function (id_project, index){
        $http.post(
            '/projects/deleteproject', {
                id_project : id_project
            }
        )
        .success(function(response){
            $http.post(
                '/projects/selectprojects'
            )
            .success(function(data){
                $scope.projects = data;
            });
            console.log("Deleted project Successfully - " + response);
        });
    };

    $scope.newMember = function(email, id_project, name_project){
        $http.post(
            '/projects/newmember', {
                email       : email,
                id_project  : id_project,
                name_project: name_project
            }
        )
        .success(function(response){
            $http.post(
                '/projects/selectprojects'
            )
            .success(function(data){
                $scope.projects = data;
            });

            $scope.addedMember = Number(response);

            $('input[name=email]').val('');

            console.log("New member added successfully - " + response);
        });
    };

    $scope.deleteMember = function(id_project, id_user){
        $http.post(
            '/projects/deletemember', {
                id_project : id_project,
                id_user    : id_user
            }
        )
        .success(function(response){
            $http.post(
                '/projects/selectprojects'
            )
            .success(function(data){
                $scope.projects = data;
            });

            console.log("Deleted member Successfully - " + response);
        });
    };
    
    $scope.secondsToHours = function (secs){
        var hours = Math.floor(secs / 3600) + '';
        if(hours.length   < 2) {hours   = '0' + hours;}

        return hours;
    };

    $scope.sizeOf = function(obj) {
        return Object.keys(obj).length;
    };
});