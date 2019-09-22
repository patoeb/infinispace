var config = {
    map: {
        "*" : {
            "bootstrap": "Magento_Theme/js/bootstrap.min",
            "lightslider": "js/lib/lightslider",
            "lightbox": "js/lib/lightbox",
            "filterizr": "js/lib/jquery.filterizr",
            "infinispace": "js/jquery.infinispace"
        }
    },

    shim: {
        'bootstrap': {
            'deps': ['jquery']
        },
        "lightslider": {
            deps: ["jquery"]
        },
        "lightbox": {
            deps: ["jquery"]
        },
        "filterizr": {
            deps: ["jquery"]
        }
    }
}