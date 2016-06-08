/* Controllers */
var DeparturesBoardControllers = angular.module('DeparturesBoardControllers', []);

DeparturesBoardControllers.controller('DeparturesController', 
['$scope', '$http', '$filter', '$interval', 'helperServices', 
    function($scope, $http, $filter, $interval, helperServices) {
            
        $scope.helperServices = helperServices;   // pass services to scope      
        $scope.selectedBusstopDepartures = [];    // init departures
        
        var url = Routing.generate('get_busstops'); //var url = 'http://departures_board.local/api/busstops';
        var urlDepartures = Routing.generate('get_busdepartures'); //var urlDepartures = 'http://departures_board.local/api/busdepartures';
        
        // refresh 1s clock and time to departure
        $interval(function() {
            $scope.currentTime = moment().format('YYYY MM DD hh:mm:ss');
            $scope.refreshDepartureTimes();
        }, 1000);
        
        // select code and name of sellected busstop
        $scope.selectBusstop = function( code, name ) {
            $scope.selectedCode = code;
            $scope.selectedName = name;
            $scope.searchDepartures();
        }

        // search
        $scope.searchDepartures = function() {
                    
            if ( $scope.loading == true ) {return;} // to not load at same time        
            
            // set default at first time
            if ( !$scope.selectedCode && !$scope.selectedName) {
                $scope.selectedCode = $scope.busstops[0].code;
                $scope.selectedName = $scope.busstops[0].name;
            }
                 
            $scope.loading = true; // for loader show
            
            // load departures
            $http.get(urlDepartures + '/' + $scope.selectedCode).success(function(data) {
                // Parse data to format => Busnumber | Direction | minutes to departure 
                // Algorithm:
                // 1. Create datetime from departrue time
                // 2. Calculate diff in seconds beetwen above and current
                // 3. Parse to hours and seconds 
                var jsonArr = [];
                angular.forEach(data, function(eachObj) {
                    var explode = eachObj.data.split(',');
                    for (var i = 0; i < explode.length; i++) {
                        // 1.
                        tmpArr = explode[i].split(':');
                        var departureDatetime = new Date();
                        departureDatetime.setHours( tmpArr[0] );
                        departureDatetime.setMinutes( tmpArr[1] );
                        departureDatetime.setSeconds( 0 );
                        // 2.
                        var date = new Date();
                        var secondsToDeparture = (departureDatetime.getTime() - date.getTime()) / 1000;
                        jsonArr.push({
                                busnumber: eachObj.busnumber,
                                direction: eachObj.direction,
                                daytype: eachObj.daytype,
                                secondsToDeparture: secondsToDeparture,
                                timeToDeparture: helperServices.hhmmss(secondsToDeparture),
                                hour:explode[i]});
                    }
                });
                
                // filter by correct working day
                $scope.selectedBusstopDepartures = $filter('filter')(jsonArr), {daytype: helperServices.getDayType(new Date())};
                
            }).finally(function () {
                $scope.loading = false;
            });
        }
        
        // refresh departures
        $scope.refreshDepartureTimes = function() {
            angular.forEach($scope.selectedBusstopDepartures, function(eachObj) {
                eachObj.secondsToDeparture -= 1;
                eachObj.timeToDeparture = helperServices.hhmmss(eachObj.secondsToDeparture);
             });
        }
        
        // first load get busstops and departures
        $http.get(url).success(function(data) {
            $scope.busstops = data;
            $scope.searchDepartures();
        });
        
    }]);