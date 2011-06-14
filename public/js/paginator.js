/**
 * 
 */
jQuery(function($){
    var container = $('#paged-data-container');
    
    var overlay = $('<div>').addClass('loading overlay');
    
    $('.paginationControl').find('a').live('click', function(){
        var href = this.href;
        var pos = this.rel == 'next' ? '-120%' : '120%';
        
        if (Modernizr.history) {
            history.pushState(location.pathname, '', href);
        }
        container.find('#comments').animate({
            left: pos
        }, 'slow', function(){
            var dataContainer = container.find('.paged-data').addClass('loading');
            $.get(href, { format: 'html' }, function(data){
                dataContainer.removeClass('loading');
                container.html(data);
            }, 'html');
        });
        return false;
    });
    
    var initialPath = location.pathname;
    
    $(window).bind('popstate', function(e){
        // Prevent popstate handler dealing with initial page load
        if (location.pathname == initialPath) {
            initialPath = null;
            return;
        }
        container.append(overlay);
        $.get(location.pathname, { format: 'html' }, function(data){
            container.html(data);
        }, 'html');
    });
});