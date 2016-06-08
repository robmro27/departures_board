'use strict';
/* App Module */

var app = angular.module('DeparturesApp', [
    'DeparturesBoardControllers',
    'DeparturesBoardServices',
]);

app.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});