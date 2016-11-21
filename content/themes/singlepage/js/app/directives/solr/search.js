define(['directives/module', 'openseadragon', 'introJs'], function (directives, openseadragon, introJs) {
  
  directives.directive('search', [ '$uibModal', '$http', '$timeout', '$q', '$location', 'localStorageService', 'facetservice', 'config', 'imageservice', 'facetservice', 'searchservice', 'Notification', 'productservice', function($uibModal, $http, $timeout, $q, $location, localStorageService, facetservice, config, imageservice, facetservice, searchservice, Notification, productservice) {
      return {
          restrict: 'E',
          transclude: true,
          template: '<ng-transclude></ng-transclude>',
          controller: ['$scope', '$element', '$attrs', function($scope, $element, $attrs){
              
              var ctrl = this;
              
              var facetFields = [];
              var facetTitles = {ante: 'Ante', post: 'Post', thesaurus: 'Thesaurus'};
              
              ctrl.registerFacetField = function(facetKey, facetTitle) {
                facetFields.push(facetKey);
                if(facetTitle){
                  facetTitles[facetKey] = facetTitle;
                }
              };
              
              ctrl.retrieveFacetTitle = function(facetKey) {
                if(facetTitles[facetKey]){
                  return facetTitles[facetKey];
                }
                return facetKey;
              };
              
              var searchesStorageName = window.location.pathname + 'searches';
              
              var init = function(){
                if($location.search().searchtext || $location.search().searchfield) {
                  $scope.searches = [{searchtext: $location.search().searchtext, searchfield: $location.search().searchfield, selectedFacets:{}}];
                }else{
                  $scope.searches = localStorageService.get(searchesStorageName) ? localStorageService.get(searchesStorageName) : [{selectedFacets:{}}];
                }
                $scope.searchResults = [{}];
              };
              init();

              $scope.pageChanged = function() {
                  //window.location.hash = '#top';
                  window.scrollTo(0,0);
              };

              $scope.toggleFacetValue = facetservice.toggleFacetValue;
              $scope.celltype = 'sm';
              $scope.tabIndex = 0;
              $scope.hitsPerPageOptions = [{id: '12', name: '12'}, {id: '24', name: '24'}, {id: '48', name: '48'}]
              
              $scope.addAllResultsToWishlist = function(){
                $uibModal.open({
                      templateUrl: '/wishlistmodal.html',
                      controller: [ '$scope', 'wishlists', function($scope, wishlists){
                        
                        $scope.wishlists = wishlists;
                        $scope.hideAddNewbutton = true;
                        
                        var addToWishlist = function(responses, wishlist){
                            var action = wishlist ? '/my-lists/edit-my-list/' : '/';
                            action += '?add-to-wishlist-itemid=';
                            action += responses[0].data;
                            var param = [];
                            var xsrf = $.param({wlid: wishlist.id, 'add-to-wishlist-type': 'group'});
                            _.each(responses, function(response){
                              xsrf += '&quantity[' + response.data + ']=1';
                            });
                            $http({
                                method: 'POST',
                                url: action,
                                data: xsrf,
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                            }).success(function(){
                              Notification.success('Erfolg');
                            });
                        };
                        
                        $scope.addToWishlist = function(wishlist){
                          var currentSearchResult = $scope.searchResults[$scope.tabIndex];
                          var promises = [];
                          _.each(currentSearchResult.response.docs, function(item){
                            promises.push(productservice.addProduct(item));
                          });
                          $q.all(promises).then(function(responses){
                              addToWishlist(responses, wishlist);
                            });
                        };
                        
                      }],
                      resolve: {
                        wishlists: [function () {
                          return $http.get('/wp-json/imareal/wishlists')
                             .then(function(response) {
                               return response.data;
                              });
                        }]
                      }
                    });
              };
              
              $scope.startNewSearch = function() {
                var newIndex = $scope.searches.length;
                $scope.searches.splice(newIndex, 0, {searchfield: 'suche_beschreibungen', searchtext: '', selectedFacets:{}});
                $scope.searchResults.splice(newIndex, 0, {});
                $scope.selectTab(newIndex);
                $scope.updateQuery();
              };
              
              $scope.showFacetTitle = function(facetTitleKey){
                var facettitle = '';
                if(facetTitleKey.startsWith('!')){
                  facettitle += 'NICHT ';
                  facetTitleKey = facetTitleKey.substring(1);
                }
                facettitle += ctrl.retrieveFacetTitle(facetTitleKey);
                return facettitle
              };
              
              $scope.showSelectedFacets = function(selectedFacets){
                var result = false;
                _.map(selectedFacets, function(value, key){
                  if($scope.showFacetSelection(value, key)){
                    result = true;
                  }
                });
                return result;
              };
              
              $scope.showFacetSelection = function(facetEntries, key){
                var result = false;
                _.map(facetEntries, function(facetEntrySelected, fieldName) {
                  if(facetEntrySelected){
                    result = true;
                  }
                });
                return result;
              };
              
              $scope.showSelectedFacetValue = function(facetEntries, facetEntryKey, facetTitleKey){
                return facetEntryKey;
              };
              
              var canceler = null;
              
              $scope.updateQuery = function() {
                  
                  localStorageService.set(searchesStorageName, $scope.searches);
                  
                  var currentSearch = $scope.searches[$scope.tabIndex];
                  var antepostFilter = '';
                  var post = 0;
                  var ante = 2500;
                  
                  var facetFilters = [];
                  _.map(currentSearch.selectedFacets, function(selectedFacet, selectedFacetKey) {
                    if(selectedFacetKey.indexOf('description') === 0) {
                      return;
                    }
                    if(selectedFacetKey.startsWith('!')){
                      
                      var selectedFacetValue = '';
                      _.map(selectedFacet, function(selected, key) {
                        if(selected) {
                          if(selectedFacetValue) {
                            selectedFacetValue += ' OR ';
                          }
                          selectedFacetValue += '! "' + key + '"';
                        }
                      });
                      if(selectedFacetValue){
                        facetFilters.push(selectedFacetKey + ':(' + selectedFacetValue + ')');
                      }
                      
                    } else if(selectedFacetKey === 'ante' || selectedFacetKey === 'post') {
                      
                      var selectedFacetValue = '';
                      _.map(selectedFacet, function(selected, key) {
                        if(selected) {
                          selectedFacetValue += key;
                        }
                      });
                      if(selectedFacetValue){
                        
                        var splitted = selectedFacetValue.split(" ");
                        
                        if(splitted.length === 1){
                          
                          if(antepostFilter){
                            antepostFilter += ' AND ';
                          }
                          
                          if(selectedFacetKey === 'post'){
                            post = selectedFacetValue;
                          }
                          if(selectedFacetKey === 'ante'){
                            ante = selectedFacetValue;
                          }
                          
                          antepostFilter += selectedFacetKey + ':' + selectedFacetValue;
                          
                        }else{
                          
                          var mode = splitted[3];
                          post = splitted[0];
                          ante = splitted[2];
                          
                          if(antepostFilter){
                            if(mode === 'Enthalten'){
                              antepostFilter += ' AND ';
                            }else{
                              antepostFilter += ' OR ';
                            }
                          }
                          antepostFilter += selectedFacetKey + ':[' + post + ' TO '+ ante + ']';
                          
                        }
                      }
                      
                    } else {
                      
                      var selectedFacetValue = '';
                      _.map(selectedFacet, function(selected, key) {
                        if(selected) {
                          if(selectedFacetValue) {
                            selectedFacetValue += ' OR ';
                          }
                          selectedFacetValue += '"' + key + '"';
                        }
                      });
                      if(selectedFacetValue){
                        facetFilters.push(selectedFacetKey + ':' + selectedFacetValue + '');
                      }
                      
                    }
                  });
                  
                  if(antepostFilter){
                    facetFilters.push("(" + antepostFilter + ")");
                  }
                  
                  currentSearch.page = currentSearch.page ? currentSearch.page : 1;
                  currentSearch.rows = currentSearch.rows ? currentSearch.rows : '12';
                  currentSearch.searchfield = currentSearch.searchfield ? currentSearch.searchfield : 'suche_beschreibungen';
                  currentSearch.searchtext = currentSearch.searchtext ? currentSearch.searchtext : '';
                  
                  var solrSearchtext = '';
                  var searchtextSplit = currentSearch.searchtext.split(' ');
                  _.each(searchtextSplit, function(searchtext){
                    if(solrSearchtext){
                      solrSearchtext += ' AND ';
                    }
                    solrSearchtext += currentSearch.searchfield + ':' + searchtext + '*';
                  });
                  
                  if(canceler){
                    canceler.resolve();
                  }
                  
                  canceler = $q.defer();
                  
                  post = parseInt(post);
                  ante = parseInt(ante);
                  
                  $http.get(config.solrBaseUrl + '/solr/' + $attrs.indexName + '/select', {
                    timeout: canceler.promise,
                    params: {
                      'q' : solrSearchtext,
                      'searchtext': currentSearch.searchtext,
                      'wt': 'json',
                      'facet': 'true',
                      'facet.limit': '1000000',
                      'f.thesaurus.facet.limit': '1000000',
                      'facet.field': facetFields,
                      'facet.range': 'ante',
                      'f.ante.facet.range.start': post,
                      'f.ante.facet.range.end': ante,
                      'f.ante.facet.range.gap': Math.round( ( ante - post ) / 7 ),
                      'f.ante.facet.range.hardend': true,
                      'fq': facetFilters,
                      'start': (currentSearch.page - 1) * currentSearch.rows,
                      'rows': currentSearch.rows
                    }
                  }).success(function(searchResultResponse) {
                    
                    $scope.searchResults[$scope.tabIndex] = searchResultResponse;
                    
                  }).error(function(content) {
                    if(content){
                      console.log('Error: ' + content);
                    }
                  });
                };
              
              ctrl.updateQuery = $scope.updateQuery;
              
              $scope.openModal = function(hit, searchkeyword){
                $uibModal.open({
                    templateUrl: '/modal.html',
                    controller: 'SearchModalController',
                    size: 'search',
                    resolve: {
                        hit: function () {
                          return hit;
                        },
                        descriptions: ['productservice', function(productservice){
                          return productservice.retrieveDescriptions(hit);
                        }],
                        ensembles: ['productservice', function(productservice){
                          return productservice.retrieveEnsembles(hit);
                        }],
                        data: ['productservice', function(productservice){
                          return productservice.retrieveData(hit);
                        }],
                        searchkeyword: function () {
                          return searchkeyword;
                        },
                        hideClose: function(){
                          return false;
                        }
                      }
                  });
              };
              
              $scope.openSaveModal = function(){
                $scope.saveForm = { saveName: '' };
                $uibModal.open({
                  templateUrl: '/savemodal.html',
                  $scope: $scope
                });
              };
              
              var savingsStorageName = window.location.pathname + 'savings';
              
              $scope.save = function(close) {
                searchservice.getSavings(savingsStorageName).then(function(savings){
                  if(!savings){
                    savings = {};
                  }
                  savings[$scope.saveForm.saveName] = angular.copy($scope.searches);
                  searchservice.setSavings(savingsStorageName, savings).then(close);
                });
              };
              
              $scope.openQuelleModal = function(quelle){
                $uibModal.open({
                      controller: 'QuelleModalController',
                      templateUrl: '/quellemodal.html',
                      resolve: {
                          quelle: function () {
                            return quelle;
                          }
                        }
                    });
              };
              
              $scope.openLoadModal = function(){
                searchservice.getSavings(savingsStorageName).then(function(savings){
                  $scope.savings = savings;
                  $uibModal.open({
                      templateUrl: '/loadmodal.html',
                      $scope: $scope
                    });
                });
              };
              
              $scope.load = function(saving) {
                searchservice.setSavings(searchesStorageName, saving).then(init);
              };
              
              $scope.retrieveImageUrl = function(hit) {
                var size = 225;
                if($scope.celltype === 'lg' || $scope.celltype === 'rectangle'){
                  size = 450;
                }
                return imageservice.retrieveImageUrl(hit, size);
              };
              
              $scope.selectTab = function(tabIndex) {
                $scope.tabIndex = tabIndex;
              };
              
              $scope.removeTab = function(tabIndex) {
                if($scope.tabIndex === tabIndex) {
                  if($scope.tabIndex === 0){
                    $scope.tabIndex = 1;
                  }else{
                    $scope.tabIndex = $scope.tabIndex - 1;
                  }
                }
                $scope.searches.splice(tabIndex, 1);
              };
              
              $scope.$watch('searches', $scope.updateQuery, true);
              
              $timeout($scope.updateQuery, 0);
              ctrl.globalSearchResult = {};
              $timeout(function(){

                  $http.get(config.solrBaseUrl + '/solr/' + $attrs.indexName + '/select', {
                    params: {
                      'q' : 'suche_alles:*',
                      'wt': 'json',
                      'facet': 'true',
                      'facet.limit': '1000000',
                      'facet.field': facetFields,
                      'start': 0,
                      'rows': 0
                    }
                  }).success(function(searchResultResponse) {
                    
                    searchResultResponse.facet_counts.facet_fields_map = {};
                    _.each(_.keys(searchResultResponse.facet_counts.facet_fields), function(key, index){
                      searchResultResponse.facet_counts.facet_fields_map[key] = {};
                      _.each(searchResultResponse.facet_counts.facet_fields[key], function(value, index){
                        if(index % 2 === 0){
                          searchResultResponse.facet_counts.facet_fields_map[key][value] = searchResultResponse.facet_counts.facet_fields[key][index + 1];
                        }
                      })
                    });
                    
                    angular.copy(searchResultResponse, ctrl.globalSearchResult);
                    
                    introJs().start();
                    
                  }).error(function(content) {
                    if(content){
                      console.log('Error: ' + content);
                    }
                  });

              }, 0);
              
          }],
          controllerAs: 'searchCtrl'
      };
    }]);
});