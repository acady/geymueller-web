define(['directives/module'], function (directives) {
  directives.directive('facetcontainer', [ function () {
     return {
          restrict: 'E',
          transclude: true,
          require: '^^search',
          templateUrl: '/facetcontainer.html',
          scope: {
            facetTitle: '='
          },
          link: function(scope, element, attrs, search){
              
              scope.facetOpen = false;
              scope.toggleFacetOpen = function(){
                scope.facetOpen = !scope.facetOpen;
              };
              
          }
      };
  }]);
});