Ext.ns('App.product');
Ext.ns('App.category');

App.init = function () {
    App.viewport = new Ext.Viewport({
        layout : 'border',
        items  : [
            App.globalToolbar(),
            App.navigation(),
            App.center()
        ]
    });



};

    
