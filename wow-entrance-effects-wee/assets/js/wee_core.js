jQuery(function(n){function e(e){n("#animationSandbox").removeClass().addClass(e+" animated").one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend",function(){n(this).removeClass()})}n(document).ready(function(){n(".js--triggerAnimation").click(function(a){a.preventDefault();var t=n(".js--animations").val();e(t),n(".the-shortcode").val('[wee animation="'+t+'" duration="1" repeats="1" delay="0" offset="0"] Your Content here... [/wee]')}),n(".js--animations").change(function(){var a=n(this).val();e(a),n(".the-shortcode").val('[wee animation="'+a+'" duration="1" repeats="1" delay="0" offset="0"] Your Content here... [/wee]')})})});