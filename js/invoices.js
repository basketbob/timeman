var invoicesApp = angular.module('invoicesApp', []);

invoicesApp.controller('invoicesAppController', function($scope, $http) {
    var today = new Date();
    $scope.start_date = today.getFullYear() + "/" + (today.getMonth()+1) + "/" + today.getDate();
    $scope.end_date   = today.getFullYear() + "/" + (today.getMonth()+1) + "/" + today.getDate();
    $scope.payday     = today.getFullYear() + "/" + (today.getMonth()+1) + "/" + today.getDate();
    $scope.whose      = 'personal';
    $scope.invoice    = false;

    $http({ method :'POST', url :'/invoices/selectData' })
        .success(function(response){
            $scope.projects = response.projects;
            $scope.invoices = response.invoices
        })
        .error(function(response, status) {
            $scope.projects = response || "Request failed"; $scope.status = status;
        });

    $scope.selectForInvoice = function(){
        $scope.saveInvoice();

        $http({
            method :'POST',
            url    :'/invoices/selectforinvoice',
            data   : $.param({
                id_project : $scope.project_name.id_project,
                from       : $scope.start_date,
                to         : $scope.end_date
            }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .success(function(response){
            $scope.data = response;
        })
        .error(function(response, status) {
            $scope.profile = response || "Request failed"; $scope.status = status;
        });

        $http({ method :'POST', url :'/invoices/selectData' })
        .success(function(response){
            $scope.invoices = response.invoices
        })
        .error(function(response, status) {
            $scope.invoices = response || "Request failed"; $scope.status = status;
        });

        $scope.invoice = true;
    };

    $scope.saveInvoice = function() {
        $http({
            method: 'POST',
            url: '/invoices/saveinvoice',
            data: $.param({
                events : $scope.data,
                name   : $scope.client.name || '',
                email  : $scope.client.email || '',
                proj   : $scope.project_name,
                payday : $scope.payday,
                payment: $scope.payment,
                other  : $scope.other
            }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .success(function(data){
            $scope.id_invoice = data;
        })
        .error(function(data, status) {
            $scope.id_invoice = data || "Something wrong, try again!";
            $scope.status = status;
        });
    };

    $scope.sendInvoice = function() {
        $http({
            method: 'POST',
            url: '/invoices/sendinvoice',
            data: $.param({
                id_invoice: $scope.id_invoice,
                events : $scope.data,
                name   : $scope.client.name,
                email  : $scope.client.email,
                proj   : $scope.project_name,
                from   : $scope.start_date,
                to     : $scope.end_date,
                payday : $scope.payday,
                payment: $scope.payment,
                other  : $scope.other,
                me_copy: $scope.copy || 0
            }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .success(function(data){
            $scope.send_invoice = data;
        })
        .error(function(data, status) {
            $scope.send_invoice = data || "Something wrong, try again!"; $scope.status = status;
        });
    };

    $scope.clearSaveInvoice = function() {
        $scope.send_invoice = 0;
    };

    $scope.invoicePaid = function(id_invoice){
        $http({
            method: 'POST', url: '/invoices/invoicepaid',
            data: $.param({ id_invoice: id_invoice }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .success(function(data){ console.log(data); })
        .error(function(data, status) { console.log(data || "Something wrong, try again!"); console.log(status); });
    };

    $scope.deleteInvoice = function(index, id_invoice){
        $scope.invoices.splice(index, 1);

        $http({
            method: 'POST', url: '/invoices/deleteinvoice',
            data: $.param({ id_invoice: id_invoice }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .success(function(data){
            console.log(data);
        })
        .error(function(data, status) {
            console.log(data || "Something wrong, try again!"); console.log(status);
        });
    }
});

$(function() {
    $( "#datepicker_from" ).datepicker({ dateFormat: "yy/mm/dd", defaultDate: 0 }).datepicker("setDate", 'today');
    $( "#datepicker_to" ).datepicker({ dateFormat: "yy/mm/dd", defaultDate: 0 }).datepicker("setDate", 'today');
    $( "#datepicker_pay" ).datepicker({ dateFormat: "yy/mm/dd", defaultDate: 0 }).datepicker("setDate", 'today');
});