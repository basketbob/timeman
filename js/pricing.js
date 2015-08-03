var pricingApp = angular.module('pricingApp', []);

pricingApp.controller('pricingAppCtrl', function($scope, $http) {
    $scope.show_calc   = false;
    $scope.total_users = 1;
    $scope.total_time  = 1;
    $scope.valuta      = 2;
    $scope.currency    = 46;

    $http({
        method: 'POST',
        url: '/site/currency',
        data: $.param({}),
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
    .success(function(data){
        $scope.currency = data;
    })
    .error(function(data, status) {
        $scope.send_report = data || "Something wrong, try again!";
        $scope.status = status;
    });

    var valuta      = 3 * $scope.currency;
    var valuta_item = ' руб.';

    $scope.getPrice = function() {
        if($scope.valuta == 1){
            valuta = 3 * $scope.currency;
            valuta_item = ' руб.';
        } else if($scope.valuta == 2){
            valuta = 3;
            valuta_item = ' USD';
        }

        if ($scope.total_users < 50 && $scope.total_time < 12 ) {
            $scope.discount = 0;

        } else if ($scope.total_users >= 50 && $scope.total_users < 200 && $scope.total_time < 12 ) {
            $scope.discount = Math.round($scope.total_users * $scope.total_time * valuta * 0.05);

        } else if ($scope.total_users >= 200 && $scope.total_users < 500 && $scope.total_time < 12 ) {
            $scope.discount = Math.round($scope.total_users * $scope.total_time * valuta * 0.1);

        } else if ($scope.total_users >= 500 && $scope.total_time < 12 ) {
            $scope.discount = Math.round($scope.total_users * $scope.total_time * valuta * 0.2);

        } else if ($scope.total_users < 50 && $scope.total_time >= 12 ) {
            $scope.discount = Math.round($scope.total_users * $scope.total_time * valuta * 0.2);

        } else if ($scope.total_users >= 50 && $scope.total_users < 200 && $scope.total_time >= 12 ) {
            $scope.discount = Math.round($scope.total_users * $scope.total_time * valuta * 0.25);

        } else if ($scope.total_users >= 200 && $scope.total_users < 500 && $scope.total_time >= 12 ) {
            $scope.discount = Math.round($scope.total_users * $scope.total_time * valuta * 0.3);

        } else if ($scope.total_users >= 500 && $scope.total_time >= 12 ) {
            $scope.discount = Math.round($scope.total_users * $scope.total_time * valuta * 0.4);
        }

        $scope.total_sum = Math.round($scope.total_users * $scope.total_time * valuta) + valuta_item;
        $scope.final_sum = Math.round(($scope.total_users * $scope.total_time * valuta) - $scope.discount) + valuta_item;
        $scope.discount  = $scope.discount + valuta_item;
    }

    $scope.$watch('[valuta,total_users,total_time]', function(){ $scope.getPrice(); }, true);
});