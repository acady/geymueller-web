define(['directives/module'], function (directives) {
  directives.directive('hierarchicalfacet', [ 'facetservice', function (facetservice) {
     return {
          restrict: 'E',
          require: '^^search',
          templateUrl: '/hierarchicalfacet.html',
          scope: {
            facetConfig: '=',
            currentSearch: '=',
            searchResult: '=',
            disjunctive: '='
          },
          link: function(scope, element, attrs, search){
              
              search.registerFacetField(scope.facetConfig.facetfield, scope.facetConfig.facettitle);
              
              scope.facetTitle = scope.facetConfig.facettitle;
              
              scope.toggleFacetValue = function(facetValue) {
                facetservice.toggleFacetValue(scope.currentSearch.selectedFacets, scope.facetConfig.facetfield, facetValue);
              };
              
              scope.expandFacetValue = function(facetValue) {
                facetservice.expandFacetValue(scope.currentSearch, scope.facetConfig.facetfield, facetValue);
              };
              
              scope.isRefined = function(facetValue) {
                return facetservice.isRefined(scope.currentSearch.selectedFacets, scope.facetConfig.facetfield, facetValue);
              };
              
              scope.$watch('searchResult.facet_counts.facet_fields.' + scope.facetConfig.facetfield, function(value){
                var layers = {};
                _.each(value, function(element, index){
                  if(index % 2 === 1){
                    return;
                  }
                  var split = element.split('/');
                  var layer = split.length;
                  var layerArray = layers[layer];
                  if(!layerArray) {
                    layers[layer] = [];
                    layerArray = layers[layer];
                  }
                  layerArray.push({value: split.reverse(), originalValue: element, count: value[index + 1]});
                });
                var preparedTree = {children: {}};
                for (i = 1; i < 6; i++) {
                  var layer = layers[i];
                  if(layer){
                    _.each(layer, function(wholeelement){
                      var val = wholeelement.value;
                      var length = val.length;
                      var container = preparedTree;
                      _.each(val, function(element, index){
                        if(index === length - 1){
                          if(container){
                            container.children[element] = {label: element, originalValue: wholeelement.originalValue, count: wholeelement.count, children: {}};
                          }else{
                            //console.log(wholeelement);
                          }
                          container = preparedTree
                        }else{
                          if(container){
                            container = container.children[element];
                          }else{
                            //console.log(wholeelement);
                          }
                        }
                      });
                    });
                  }
                }
                var childrenToArray = function(element){
                  if(element.children){
                    var values = _.values(element.children);
                    _.each(values, function(value){
                      childrenToArray(value);
                    });
                    element.children = values;
                  }
                };
                childrenToArray(preparedTree);
                scope.treedata = preparedTree;
              });
              
              scope.globalSearchResult = search.globalSearchResult;
              
          }
      };
  }]);
});