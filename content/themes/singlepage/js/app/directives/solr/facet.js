define(['directives/module'], function (directives) {
  directives.directive('facet', [ 'facetservice', '$uibModal', function (facetservice, $uibModal) {
     return {
          restrict: 'E',
          require: '^^search',
          templateUrl: '/facet.html',
          scope: {
            facetConfig: '=',
            currentSearch: '=',
            searchResult: '=',
            disjunctive: '='
          },
          link: function(scope, element, attrs, searchController){
              
              searchController.registerFacetField(scope.facetConfig.facetfield, scope.facetConfig.facettitle);
              
              scope.facetTitle = scope.facetConfig.facettitle;
              
              scope.toggleNotFacetValue = function(facetValue) {
                facetservice.toggleFacetValue(scope.currentSearch.selectedFacets, '!' + scope.facetConfig.facetfield, facetValue);
              };
              
              scope.isNot = function(facetValue) {
                return facetservice.isRefined(scope.currentSearch.selectedFacets, '!' + scope.facetConfig.facetfield, facetValue);
              };
              
              scope.toggleFacetValue = function(facetValue) {
                facetservice.toggleFacetValue(scope.currentSearch.selectedFacets, scope.facetConfig.facetfield, facetValue);
              };
              
              scope.expandFacetValue = function(facetValue) {
                facetservice.expandFacetValue(scope.currentSearch, scope.facetConfig.facetfield, facetValue);
              };
              
              scope.isRefined = function(facetValue) {
                return facetservice.isRefined(scope.currentSearch.selectedFacets, scope.facetConfig.facetfield, facetValue);
              };
              
              scope.globalSearchResult = searchController.globalSearchResult;
              
              scope.filterUnuseful = function () {
                  return function (item, index, items) {
                      return index % 2 === 0;
                  };
              };
              
              var modalInstance = null;
              scope.openFacetModal = function(){
                modalInstance = $uibModal.open({
                    templateUrl: '/facetmodal.html',
                    scope: scope
                  });
              };
              
          }
      };
  }]);
});