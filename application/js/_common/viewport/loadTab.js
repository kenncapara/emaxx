App.loadTab = function(tabId) {
    var tabPanel = Ext.getCmp('main-tabpanel');
    var cmp = tabPanel.findById(tabId);
    if (null == cmp) {
        App.addTab(eval(tabId + '();'));
        // Ext.getCmp('app-navigation').collapse();
    } else {
        // cmp.show();
    }
    
};