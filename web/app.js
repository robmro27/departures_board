(function() {
    
    var app = angular.module('DeparturesApp', []).config(function($interpolateProvider){
        $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
    });
    
    app.controller('DeparturesController', ['$scope', '$http', '$filter', function($scope, $http, $filter) {
            
        $scope.selectedBusstopDepartures = {};
        
        var url = 'http://departures_board.local/api/busstops';
        var urlDepartures = 'http://departures_board.local/api/busdepartures/';
        
        $scope.searchDepartures = function() {
            var code = $scope.selectedBusstop.code;
            $http.get(urlDepartures + code).success(function(data) {
                $scope.selectedBusstopDepartures = data;
                
                $scope.selectedBusstopDeparturesByDay = $filter('filter')($scope.selectedBusstopDepartures, {daytype: 'working'});
                
                // add time
                angular.forEach($scope.selectedBusstopDeparturesByDay, function(eachObj) {
                    eachObj.hours = [];
                    var explode = eachObj.data.split(',');
                    for (var i = 0; i < explode.length; i++) {
                        eachObj.hours.push({"hour":explode[i]});
                    }
                });
                
            });
        }
        
        $http.get(url).success(function(data) {
            $scope.busstops = data; 
        });
        
    }]);
    
})();



