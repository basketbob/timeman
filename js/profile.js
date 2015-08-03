var profileApp = angular.module('profileApp', [])
    .directive('ngModelOnblur', function() {
        return {
            restrict: 'A',
            require: 'ngModel',
            priority: 1, // needed for angular 1.2.x
            link: function(scope, elm, attr, ngModelCtrl) {
                if (attr.type === 'radio' || attr.type === 'checkbox') return;

                elm.unbind('input').unbind('keydown').unbind('change');
                elm.bind('blur', function() {
                    scope.$apply(function() {
                        ngModelCtrl.$setViewValue(elm.val());
                    });
                });
            }
        };
    })
    .directive("fileread", [function () {
        return {
            scope: {
                fileread: "="
            },
            link: function (scope, element, attributes) {
                element.bind("change", function (changeEvent) {
                    scope.$apply(function () {
                        scope.fileread = changeEvent.target.files[0];
                        // or all selected files:
                        // scope.fileread = changeEvent.target.files;
                    });
                });
            }
        }
    }]);

profileApp.controller('profileAppController', function($scope, $http) {
    $http({method:'POST', url:'/profile/selectprofile'})
    .success(function(response){
        $scope.profile = response;
    })
    .error(function(response, status) {
      $scope.profile = response || "Request failed";
      $scope.status = status;
    });

    $scope.checkPwd = false;
    $scope.resultUpdate = false;
    $scope.avatar = false;

    $scope.updateProfile = function(){
        $http({
            method: 'POST',
            url: '/profile/updateprofile',
            data: $.param({
                name_user  : $scope.profile.name_user,
                department :  $scope.profile.department,
                timezone   :   $scope.profile.timezone,

                password        : $scope.profile.currentPassword,
                new_password    : $scope.profile.newPassword,
                repeat_password : $scope.profile.repeatPassword
            }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .success(function(data){
            $scope.resultUpdate = data;
        })
        .error(function(data, status) {
            $scope.data = data || "Request failed";
            $scope.status = status;
        });
    };

    $scope.checkPassword = function(){
        $http({
            method: 'POST',
            url: '/profile/checkpassword',
            data: $.param({
                password  : $scope.profile.currentPassword
            }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .success(function(data){
            $scope.checkPwd = data;
        })
        .error(function(data, status) {
            $scope.data = data || "Request failed";
            $scope.status = status;
        });
    };
});