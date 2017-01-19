define(['services/module'], function (services) {
  services.service('facetservice',[ '$http', 'config', function($http, config){
    
    var initSelectedFacet = function(selectedFacets, facetKey) {
      if(!selectedFacets[facetKey]) {
        selectedFacets[facetKey] = {};
      }
    };
    
    var isRefined = function(selectedFacets, facetKey, facetValue) {
      initSelectedFacet(selectedFacets, facetKey);
      return selectedFacets[facetKey][facetValue];
    };
    
    var handleFacetEntry = function(selectedFacets, entry){
      var fqSplit = entry.split(':');
      selectedFacets[fqSplit[0]] = {};
      var values = fqSplit[1].replace(/^\(/, '').replace(/\)$/, '').replace(/"/g,'');
      values = values.split(' OR ');
      _.each(values, function(value){
        selectedFacets[fqSplit[0]][value] = true;
      });
    };
    
    var retrieveSelectedFacets = function(searchResult){
        var selectedFacets = {};
        if(searchResult && searchResult.responseHeader && searchResult.responseHeader.params && searchResult.responseHeader.params.fq) {
          var fq = searchResult.responseHeader.params.fq;
          if(Array.isArray(fq)){
            _.each(fq, function(entry){
              handleFacetEntry(selectedFacets, entry);
            });
          }else{
            handleFacetEntry(selectedFacets, fq);
          }
        }
        return selectedFacets;
    };
    
    var resetSearch = function(search) {
      search.searchtext = '';
      search.searchfield = 'suche_alles';
      for (var member in search.selectedFacets) delete search.selectedFacets[member];
    };
    
    var expandFacetValue = function(search, facetKey, facetValue) {
      resetSearch(search);
      initSelectedFacet(search.selectedFacets, facetKey);
      search.selectedFacets[facetKey][facetValue] = !isRefined(search.selectedFacets, facetKey, facetValue);
    };
    
    return {
      toggleFacetValue: function(selectedFacets, facetKey, facetValue) {
        initSelectedFacet(selectedFacets, facetKey);
        var newValue = !isRefined(selectedFacets, facetKey, facetValue);
        if(!newValue){
          delete selectedFacets[facetKey][facetValue];
        }else{
          selectedFacets[facetKey][facetValue] = newValue;
        }
      },
      isRefined: isRefined,
      retrieveSelectedFacets: retrieveSelectedFacets,
      expandFacetValue: expandFacetValue
    };
  }]);
});