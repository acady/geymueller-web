define(['directives/module', 'ol'], function (directives, ol) {
  directives.directive('expertsearch',[ '$timeout', function($timeout){
    return {
          restrict: 'E',
          templateUrl: '/expertsearch.html',
          scope: {
            activeIndex : '='
          },
          link: function(scope, element, attrs){
            /*
            var map = new ol.Map({
                target: 'map',
                layers: [
                  new ol.layer.Tile({
                    source: new ol.source.OSM()
                  })
                ],
                view: new ol.View({
                  center: ol.proj.fromLonLat([15.439504, 47.070714]),
                  zoom: 4
                })
              });
            
            scope.$watch(function() {
                return scope.activeIndex;
              }, function(newval, oldval){
              $timeout(function(){
                map.updateSize();
              }, 500);
            }, true);
            */
          }
      };

    }]);
});