(function() {
    tinymce.create('tinymce.plugins.buytag', {
        init : function(ed, url) {
            ed.addButton('buytag', {
                title : 'Кнопка КУПИТЬ',
                image : url+'/buyshort.png',
                onclick : function() {
                ed.selection.setContent('[buy link="' + ed.selection.getContent() + '"]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });

    tinymce.PluginManager.add('buytag', tinymce.plugins.buytag);
})();