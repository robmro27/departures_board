(function() {
    
    var app = angular.module('DeparturesApp', []).config(function($interpolateProvider){
        $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
    });
    
    app.controller('DeparturesController', ['$scope', '$http', function($scope, $http) {
        
        $scope.busstops = 'aaa'; 
        
    }]);
    
})();



