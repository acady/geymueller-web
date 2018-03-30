define(['controllers', 'directives', 'filters', 'lodash'], function () {
  'use strict';
  var app = angular.module('app', ['app.controllers', 'app.directives', 'app.filters', 'chart.js', 'ui.bootstrap', 'ui.router', 'ngSanitize', 'smoothScroll', 'ui-notification', 'rzModule', 'treeControl', 'ngAnimate', 'angular-loading-bar']);

  app.config(['$locationProvider', '$stateProvider', function ($locationProvider, $stateProvider) {
    $locationProvider.html5Mode({
      enabled: true,
      rewriteLinks: false
    });

    $stateProvider.state('detail', {
      template: '<div class="d3-graph"> </div>',
      url: '/graph/',
      controller: 'GraphController',
      resolve: {
        hit: ['config', '$http', '$location', '$q', function (config, $http, $location, $q) {
          var deferred = $q.defer();
          $http.get(config.solrBaseUrl + '/solr/work/select', {
            params: {
              'q': 'archivnr:000168',
              'wt': 'json'
            }
          }).success(function (searchResultResponse) {

            deferred.resolve(searchResultResponse.response.docs[0]);

          }).error(function (content) {
            if (content) {
              console.log('Error: ' + content);
            }
          });
          return deferred.promise;
        }],
        data: ['hit', 'productservice', function (hit, productservice) {
          return productservice.retrieveData(hit);
        }]
      }
    });


  }]);

  app.factory('sessionData', function () {
    var currentToken = '[uninitialized-token]';

    return {
      getToken: function () {
        return currentToken;
      },
      setToken: function (token) {
        currentToken = token;
      }
    };
  });

  app.constant('config', {
    //solrBaseUrl: 'http://localhost:8983'
    solrBaseUrl: 'http://test.zedlacher.org:8984',
    //solrBaseUrl: 'http://104.45.88.196'
    // solrBaseUrl: 'http://realonline.imareal.sbg.ac.at.local'
    apiBaseUrl: 'http://cf000044.sbg.ac.at/api/data/',
    apiKey: '9rkWCL6e86',
    imageBaseUrl: 'http://cf000036.sbg.ac.at/iipsrv/iipsrv.fcgi?FIF=/'
  });

  angular.bootstrap(document, ['app'], {
    strictDi: true
  });

  if (angular.element('.billing-container').length) {
    var publikation = angular.element('#publikation');
    var modifyOption = function (element) {
      var publikation_visible = publikation.val() === 'Ja' ? 'block' : 'none';
      element.val(publikation.val() === 'Ja' ? '' : '-');
      if (publikation.val() === 'Ja') {
        element.parent().show();
      } else {
        element.parent().hide();
      }
    };
    var modifyOptions = function () {
      modifyOption(angular.element('#publikation_author'));
      modifyOption(angular.element('#publikation_title'));
      modifyOption(angular.element('#publikation_verlag'));
      modifyOption(angular.element('#publikation_auflage'));
    };
    modifyOptions();

    publikation.on('change', modifyOptions);

  }

});
