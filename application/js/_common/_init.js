Ext.ns('App');
Ext.BLANK_IMAGE_URL = '/ext/resources/images/default/s.gif';

Ext.onReady(function() {
 
    Ext.QuickTips.init();
    
    Ext.Ajax.addListener('requestexception', function (e, resp) {
        App.showError(resp);
    });
 
    App.init();
    
}); 