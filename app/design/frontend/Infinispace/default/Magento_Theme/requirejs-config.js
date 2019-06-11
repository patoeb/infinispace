var config = {
    map: {
        "*" : {
            "lightslider": "js/lib/lightslider",
            "lightbox": "js/lib/lightbox",
            "filterizr": "js/lib/jquery.filterizr",
            "infinispace": "js/jquery.infinispace"
        }
    },

    shim: {
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