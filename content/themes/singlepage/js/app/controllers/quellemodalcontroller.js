define(['controllers/module'], function (controllers) {
  
  controllers.controller('QuelleModalController', ['$scope', '$http', 'quelle', 'config', function ($scope, $http, quelle, config) {

    $scope.quelle = quelle;
    
    $http.get(config.apiBaseUrl + 'quelle/' + quelle + '?apiKey=9rkWCL6e86').success(function(data){
      $scope.quellecontent = data;
    });
    
  }]);
  
});