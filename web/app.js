(function() {
    
    var app = angular.module('DeparturesApp', []).config(function($interpolateProvider){
        $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
    });
    
    app.controller('DeparturesController', ['$scope', '$http', function($scope, $http) {
            
        $scope.selectedBusstopDepartures = {};
        
        var url = 'http://departures_board.local/api/busstops';
        var urlDepartures = 'http://departures_board.local/api/busdepartures/';
        
        $scope.searchDepartures = function() {
            
            var code = $scope.selectedBusstop.code;
            $http.get(urlDepartures + code).success(function(data) {
                $scope.selectedBusstopDepartures = data;
            });
            
        }
        
        $http.get(url).success(function(data) {
            $scope.busstops = data; 
        });
        
        
    }]);
    
})();



