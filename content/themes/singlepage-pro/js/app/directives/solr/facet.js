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
              
              searchController.registerFacetField(scope.facetConfig, scope.facetConfig);
              
              scope.facetTitle = scope.facetConfig;
              
              scope.toggleNotFacetValue = function(facetValue) {
                facetservice.toggleFacetValue(scope.currentSearch.selectedFacets, '!' + scope.facetConfig, facetValue);
              };
              
              scope.isNot = function(facetValue) {
                return facetservice.isRefined(scope.currentSearch.selectedFacets, '!' + scope.facetConfig, facetValue);
              };
              
              scope.toggleFacetValue = function(facetValue) {
                facetservice.toggleFacetValue(scope.currentSearch.selectedFacets, scope.facetConfig, facetValue);
              };
              
              scope.expandFacetValue = function(facetValue) {
                facetservice.expandFacetValue(scope.currentSearch, scope.facetConfig, facetValue);
              };
              
              scope.isRefined = function(facetValue) {
                return facetservice.isRefined(scope.currentSearch.selectedFacets, scope.facetConfig, facetValue);
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