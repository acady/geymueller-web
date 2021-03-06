require.config({
  "baseUrl": "/content/themes/singlepage-pro/js",
  "paths": {
    "jquery": "vendor/jquery/dist/jquery",
    "angular": "vendor/angular/angular",
    "angular-animate": "vendor/angular-animate/angular-animate",
    "angular-bootstrap": "vendor/angular-bootstrap/ui-bootstrap-tpls",
    "angular-smooth-scroll": "vendor/ngSmoothScroll/lib/angular-smooth-scroll",
    "angular-ui-notification": "vendor/angular-ui-notification/dist/angular-ui-notification",
    "openseadragon": "vendor/openseadragon/built-openseadragon/openseadragon/openseadragon",
    "angularjs-slider": "vendor/angularjs-slider/dist/rzslider",
    "angular-tree-control": "vendor/angular-tree-control/angular-tree-control",
    "angular-loading-bar": "vendor/angular-loading-bar/build/loading-bar",
    "angular-ui-router": "vendor/angular-ui-router/release/angular-ui-router",
    "lodash": "vendor/lodash/dist/lodash",
    "introJs": "vendor/intro.js/intro",
    "d3": "vendor/d3/d3",
    "ol": "vendor/ol3-bower/ol",
    "app": "app/app",
    "angular-sanitize": "vendor/angular-sanitize/angular-sanitize",
    "controllers": "app/controllers",
    "directives": "app/directives",
    "services": "app/services",
    "filters": "app/filters"
  },
    shim: {
      "angular": { exports: "angular", deps: ["jquery"] },
      "angular-animate": { deps: ["angular"] },
      "angular-loading-bar": { deps: ["angular"] },
      "angular-ui-router": { deps: ["angular"] },
      "angular-sanitize" : { deps: ["angular"] },
      "lodash": {exports: "_" },
      "angular-bootstrap": { deps: ["angular"] },
      "angular-smooth-scroll": { deps: ["angular"] },
      "angular-ui-notification": { deps: ["angular"] },
      "services": { deps: ["angular-ui-router", "angular-sanitize",
        "angular-animate", "angular-loading-bar", "angular-bootstrap", "angular-smooth-scroll",
        "angular-ui-notification", "angularjs-slider", "angular-tree-control"]
      },
      "controllers": { deps: ["services"] },
      "directives": { deps: ["services"] },
      "filters": { deps: ["services"] },
      "ion.rangeSlider": { deps: ["jquery"] },
      "ion.rangeslider-angularjs": { deps: ["angular", "ion.rangeSlider"] },
      "angular-tree-control": { deps: ["angular"] }
    }
});

require(["app"]);
