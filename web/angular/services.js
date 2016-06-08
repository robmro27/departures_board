'use strict';
/* Services */
var DeparturesBoardServices = angular.module('DeparturesBoardServices', []);
/* Generic Services */                                                                                                                                                                                                    
angular.module('DeparturesBoardServices', [])                                                                                                                                                                        
    .factory("helperServices", function() {                                                                                                                                                   
    return {    
        workingLabel:'working',
        saturdayLabel:'saturday',
        sundayLabel:'sunday',
        pad: function( num ) {
            return ("0"+num).slice(-2);
        },
        hhmmss: function( secs ) {
            var minutes = Math.floor( secs / 60 );
            secs = secs % 60;
            var hours = Math.floor( minutes / 60 )
            minutes = minutes % 60;
            return this.pad( hours )+"h "+ this.pad( minutes )+"m "+ this.pad( secs ) + "s";
        },
        greaterThan: function( prop, val ) {
            return function(item){
              return item[prop] > val;
            }
        },
        getDayType: function( date ) {
            var weekday = date.getDay();
            if ( weekday == 0 ) {return this.sundayLabel;} 
            else if ( weekday == 6 ) {return this.saturdayLabel;} 
            else {return this.workingLabel;}
        },
    }
});



