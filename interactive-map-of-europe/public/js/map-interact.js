( function( $ ) {

    "use strict";

    function isTouchEnabled() {
    return (('ontouchstart' in window)
        || (navigator.MaxTouchPoints > 0)
        || (navigator.msMaxTouchPoints > 0));
    }

    $(document).ready(function () {
        $("path[id^=\"eumapvorg_\"]").each(function (i, e) {
            addEvent($(e).attr('id'));
        });
    });

    function addEvent(id, relationId) {
        var _obj = $('#' + id);
        $('#eumapwrapper-org').css({'opacity': '1'});

        _obj.attr({'fill': eu_map_org_config[id]['upclr'], 'stroke': eu_map_org_config['default']['eubrdrclr_org']});

        _obj.attr({'cursor': 'default'});

        if (eu_map_org_config[id]['enbl'] === true) {
            if (isTouchEnabled()) {
                var touchmoved;
                _obj.on('touchend', function (e) {
                    if (touchmoved !== true) {
                        _obj.on('touchstart', function (e) {
                            _obj.css({'fill': eu_map_org_config[id]['dwnclr']});
                        })
                        _obj.on('touchend', function () {
                            _obj.css({'fill': eu_map_org_config[id]['upclr']});
                            if (eu_map_org_config[id]['targt'] === '_blank') {
                                window.open(eu_map_org_config[id]['url']);
                            } else if (eu_map_org_config[id]['targt'] === '_self') {
                                window.parent.location.href = eu_map_org_config[id]['url'];
                            }
                        })
                    }
                }).on('touchmove', function (e) {
                    touchmoved = true;
                }).on('touchstart', function () {
                    touchmoved = false;
                });
            }
            _obj.attr({'cursor': 'pointer'});

            _obj.on('mouseenter', function () {
                _obj.css({'fill': eu_map_org_config[id]['ovrclr']});
            }).on('mouseleave', function () {
                _obj.css({'fill': eu_map_org_config[id]['upclr']});
            });
            if (eu_map_org_config[id]['targt'] !== 'none') {
                _obj.on('mousedown', function () {
                    _obj.css({'fill': eu_map_org_config[id]['dwnclr']});
                });
            }
            _obj.on('mouseup', function () {
                _obj.css({'fill': eu_map_org_config[id]['ovrclr']});
                if (eu_map_org_config[id]['targt'] === '_blank') {
                    window.open(eu_map_org_config[id]['url']);
                } else if (eu_map_org_config[id]['targt'] === '_self') {
                    window.parent.location.href = eu_map_org_config[id]['url'];
                }
            });
        }
        else {
            _abb.css({'fill-opacity':'0.5'});
        }
    }
})(jQuery);
