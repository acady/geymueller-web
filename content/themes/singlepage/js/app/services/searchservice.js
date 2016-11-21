define(['services/module'], function (services) {
  services.service('searchservice',[ '$http', 'localStorageService', function($http, localStorageService){
    
    var getSavings = function(savingName){
      return $http({method: 'GET', url: '/wp-json/imareal/searches', headers: {'X-WP-Nonce' : wp_nonce }}).then(function(response){
        var searches = response.data;
        var localStorageResults = localStorageService.get(savingName);
        var result = _.merge(searches, localStorageResults);
        return result;
      })
    };
    
    var setSavings = function(savingName, savings){
      
      localStorageService.set(savingName, savings);
      
      return $http({method: 'POST', url: '/wp-json/imareal/searches/update', data: { savings: savings }, headers: {'X-WP-Nonce' : wp_nonce } });
      
    };
    
    return {
      getSavings: getSavings,
      setSavings: setSavings
    };
    
  }]);
});