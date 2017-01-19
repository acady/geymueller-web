define(['services/module'], function (services) {
  services.service('productservice',[ '$http', 'config', function($http, config){
    
    var addProduct = function(product, success, error) {
      return $http.post('/wp-json/imareal/product/add', product);
    };
    
    var retrieveDescriptions = function(hit){
      return $http.get(config.solrBaseUrl + '/solr/description/select?q=archivnr:' + hit.archivnr + '&wt=json').then(function(searchResult) {
            var descriptions = {};
            _.each(searchResult.data.response.docs, function(value){
              var description = value.typ;
              if(!descriptions[description]){
                descriptions[description] = [];
              }
              descriptions[description].push(value);
            });
            return descriptions;
          });
    };
    
    var retrieveEnsembles = function(hit){
      if(hit.ensemble){
        return $http.get(config.solrBaseUrl + '/solr/work/select?q=ensemble:"' + hit.ensemble + '"&wt=json')
        .then(function(searchResult) {
          return searchResult.data.response.docs;
        });
      }
      return undefined;
    };
    
    var retrieveData = function(hit){
      return $http.get(config.apiBaseUrl +"work?apiKey=9rkWCL6e86&detail=true&archivnr=" + hit.archivnr)
        .then(function(searchResult) {
          return searchResult.data;
        });
    };
    
    return {
      addProduct: addProduct,
      retrieveDescriptions: retrieveDescriptions,
      retrieveEnsembles: retrieveEnsembles,
      retrieveData: retrieveData
    };
    
  }]);
});