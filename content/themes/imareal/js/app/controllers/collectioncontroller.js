define(['controllers/module'], function (controllers) {
  
  controllers.controller('CollectionController', ['$scope', '$http', '$uibModal', 'config', 'imageservice', function ($scope, $http, $uibModal, config, imageservice) {




    $scope.activeCollectionIndex = 0;
    
    $scope.setActiveCollectionIndex = function(index){
      $scope.activeCollectionIndex = index;
    };
    
    var initActiveCollection = function(){
      var solrQuery = '';
      var works = $scope.backendCollections[$scope.activeCollectionIndex].works;
      var activeColl = $scope.backendCollections[$scope.activeCollectionIndex].name;
        //console.log($scope.backendCollections[$scope.activeCollectionIndex]);
      _.each(works, function(work){
          if(solrQuery){
            solrQuery += ' OR ';
          }
          
          solrQuery += work;
      });
      $http.get(config.solrBaseUrl + '/solr/work/select?q=archivnr:(' + solrQuery + ')&wt=json').success(function(searchResult) {
          
          var docs = searchResult.response.docs;
         
          var hits = [];
          _.each(works, function(work){
            _.each(docs, function(doc){
              if(work === doc.archivnr){
                hits.push(doc);
              }
            });
          });


          $scope.hits = hits;
          $scope.numFound = searchResult.response.numFound;
          $scope.activeColl = activeColl;
        
      });
    };
    
    $http.get(config.apiBaseUrl + 'collection?apiKey=9rkWCL6e86')
      .success(function(backendCollections) {
        
        $scope.backendCollections = backendCollections; 
        
        var solrQuery = '';
        _.each(backendCollections, function(backendCollection){
          if(backendCollection.works){
            if(solrQuery){
              solrQuery += ' OR ';
            }
            
            solrQuery += backendCollection.works[0];
          }
        });



        $http.get(config.solrBaseUrl + '/solr/work/select?q=archivnr:(' + solrQuery + ')&wt=json').success(function(searchResult) {
          
          var docs = searchResult.response.docs;
          var titles = searchResult.response;

          var collections = [];
          _.each(backendCollections, function(backendCollection){
            if(backendCollection.works){
              _.each(docs, function(doc){
                if(backendCollection.works[0] === doc.archivnr){
                  collections.push(doc);
                }
              });
            }
          });
          $scope.collections = collections;
          
          initActiveCollection();
          
          $scope.$watch('activeCollectionIndex', initActiveCollection);
          
        });
        
      }).error(function(content) {
        if(content){
          console.log('Error: ' + content);
        }
      });
    
    $scope.retrieveImageUrl = function(hit){
      return imageservice.retrieveImageUrl(hit, 1000);
    };
    
    $scope.openModal = function(hit, searchkeyword){
        $uibModal.open({
            templateUrl: '/modal.html',
            controller: 'SearchModalController',
            size: 'search',
            resolve: {
                hit: function () {
                  return hit;
                },
                searchkeyword: function () {
                    //console.log(searchkeyword + ' search.js');
                    return searchkeyword;
                },
                hideClose: function(){
                  return false;
                }
              }
          });
      };
    
  }]);
  
});