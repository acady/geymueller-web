define(['directives/module'], function (directives) {
  directives.directive('addToCartButton',[ '$window', '$http', '$uibModal', 'Notification', 'productservice', function($window, $http, $uibModal, Notification, productservice){
    return {
          restrict: 'E',
          templateUrl: '/addtocart.html',
          scope: {
            product: '='
          },
          link: function(scope, element, attrs){
            
            scope.addToCartLoading = false;
            
            var error = function() {
              Notification.error('Fehler');
              scope.addToCartLoading = false;
            };
            
            var addToCart = function(productId){
                var data = { 'product_id': productId };
                $http({
                  method  : 'POST',
                  url     : $window.location.pathname + '?wc-ajax=add_to_cart',
                  data    : $.param(data),
                  headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
                 })
                 .success(function(data) {
                   if(!data.fragments || data.error) {
                     error();
                   } else {
                     Notification.success('Erfolg');
                     scope.addToCartLoading = false;
                   }
                  })
                  .error(error);
            };
            
            scope.addToCart = function(){
                  
                  scope.addToCartLoading = true;
                  
                  productservice.addProduct(scope.product).success(addToCart).error(error);
                  
                };
            
            
          }
      };
      
    }]);
});