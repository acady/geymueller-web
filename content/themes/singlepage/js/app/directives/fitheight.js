define(['directives/module'], function (directives) {
  directives.directive('fitheight', [ '$window', function ($window) {
     return {
          restrict: 'A',
          link: function(scope, element){
            
            var w = angular.element($window);
            var substract = scope.$eval(element.attr('fitheight-substract'));
            
            var updateHeight = function(){
              var height = w.height();
              if(substract){
                height = height - substract;
              }
              element.css('height', height);
              element.attr('data-fitheight-height', height);
            };
            
            var resize = function () {
                updateHeight();
                scope.$apply();
            };
            
            w.bind('resize', resize);
            updateHeight();
            
            scope.$on("$destroy", function(){
              w.unbind('resize', resize);
            });
            
          }
      };
  }]);
});