(function() {
    tinymce.create('tinymce.plugins.regtag', {
        init : function(ed, url) {
            ed.addButton('regtag', {
                title : 'Кнопка ЗАРЕГИСТРИРОВАТЬСЯ',
                image : url+'/regshort.png',
                onclick : function() {
                ed.selection.setContent('[register link="' + ed.selection.getContent() + '"]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });

    tinymce.PluginManager.add('regtag', tinymce.plugins.regtag);
})();