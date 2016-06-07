(function() {
    
    var app = angular.module('DeparturesApp', []).config(function($interpolateProvider){
        $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
    });
    
    app.controller('DeparturesController', ['$scope', '$http', '$filter', '$interval', function($scope, $http, $filter, $interval) {
            
        $scope.selectedBusstopDepartures = [];
        
        var url = 'http://departures_board.local/api/busstops';
        var urlDepartures = 'http://departures_board.local/api/busdepartures/';
        var currentDatetime = new Date();
        
        $interval(function() {
            $scope.currentTime = moment().format('YYYY MM DD hh:mm:ss');
        }, 1000);
        
        
        $scope.searchDepartures = function( code, name ) {
                    
            $scope.loading = true;
            $scope.selectedBusstop = name;
            $http.get(urlDepartures + code).success(function(data) {
                
                // Parse data to format => Busnumber | Direction | minutes to departure
                // Algorithm:
                // 1. Create datetime from departrue time
                // 2. Calculate diff in seconds beetwen two above
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
                        var secondsToDeparture = (departureDatetime.getTime() - currentDatetime.getTime()) / 1000;
                        var d = moment.duration(secondsToDeparture, 'seconds');
                        
                        // 3.
                        var hours = Math.floor(d.asHours());
                        var mins = Math.floor(d.asMinutes()) - hours * 60;
                        
                        jsonArr.push(
                            {
                                busnumber: eachObj.busnumber,
                                direction: eachObj.direction,
                                daytype: eachObj.daytype,
                                secondsToDeparture: secondsToDeparture,
                                timeToDeparture: hours + "h " + mins + "m",
                                hour:explode[i]
                            }
                        );
                    }
                    
                });
                
                $scope.selectedBusstopDepartures = $filter('filter')(jsonArr, {daytype: $scope.getDayType(currentDatetime)});
            }).finally(function () {
                // Hide loading spinner whether our call succeeded or failed.
                $scope.loading = false;
            });
        }
        
        // filter for grather than
        $scope.greaterThan = function(prop, val){
            return function(item){
              return item[prop] > val;
            }
        }

        // returns day type of weekday
        $scope.getDayType = function( date ) {
            var weekday = date.getDay();
            if ( weekday == 0 ) {return 'sunday';} 
            else if ( weekday == 6 ) {return 'saturday';} 
            else {return 'working';}
        }
        
        $http.get(url).success(function(data) {
            $scope.loading = false;
            $scope.busstops = data; 
        }).finally(function () {
            $scope.loading = false;
        });
        
    }]);
    
})();



