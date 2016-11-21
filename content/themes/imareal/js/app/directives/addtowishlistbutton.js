define(['directives/module'], function (directives) {
  directives.directive('addToWishlistButton',[ '$window', '$http', '$uibModal', 'Notification', 'productservice', function($window, $http, $uibModal, Notification, productservice){
    return {
          restrict: 'E',
          templateUrl: '/addtowishlist.html',
          scope: {
            product: '='
          },
          link: function(scope, element, attrs){
            
            scope.addToWishlistLoading = false;
            
            var wishlistmodal = null;
            
            scope.openWishlistModal = function(){
              wishlistmodal = $uibModal.open({
                  templateUrl: '/wishlistmodal.html',
                  controller: [ '$scope', 'wishlists', function($scope, wishlists){
                    
                    $scope.wishlists = wishlists;
                    
                    var addToWishlist = function(productId, wishlist){
                        var form = angular.element('#add-to-wishlist-form');
                        var action = wishlist ? '/my-lists/edit-my-list/' : '/';
                        action += '?add-to-wishlist-itemid=';
                        action += productId;
                        if(wishlist){
                          action += '&wlid=' + wishlist.id;
                        }
                        form.attr('action', action);
                        angular.element('#wlid').val(wishlist ? wishlist.id : 'session');
                        form.submit();
                    };
                    
                    $scope.addToWishlist = function(wishlist){
                      productservice.addProduct(scope.product).success(function(productId){
                        addToWishlist(productId, wishlist);
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
            
          }
      };
      
    }]);
});